<?php
declare(strict_types=1);

/**
 * Mailversand.
 *
 *   MAIL_DRIVER=log   -> storage/mail.log, kein echter Versand. Standard beim
 *                        Entwickeln: So liegt auf keinem Laptop ein Passwort,
 *                        und beim Ausprobieren geht nichts an echte Adressen.
 *   MAIL_DRIVER=smtp  -> echter Versand über einen angemeldeten Mailserver.
 *   MAIL_DRIVER=mail  -> PHP mail().
 *
 * ACHTUNG bei `mail`: Im Container dieses Projekts (`php:8.3-apache`, siehe
 * deploy/Dockerfile) gibt es KEIN Mailprogramm. mail() reicht die Nachricht an
 * /usr/sbin/sendmail weiter, die Datei existiert dort nicht, und der Aufruf
 * gibt lautlos false zurück. Der Treiber bleibt trotzdem drin, weil er auf
 * gewöhnlichem Hosting funktioniert – auf diesem Server ist er es nicht.
 *
 * WARUM SMTP UND NICHT DER EIGENE SERVER: Angemeldet beim Postfachanbieter
 * verlässt die Mail dessen Mailserver, und für den stimmen SPF und DKIM der
 * Domain bereits. Verschickt der VPS selbst, ist der Absender eine frische
 * IP ohne Ruf – ausgerechnet die PIN-Mail landet dann im Spam, und die IST
 * der Zugang.
 *
 * GRUNDREGEL: Versenden darf nie eine Buchung aufhalten. Deshalb fliegt hier
 * nichts nach oben (alles gibt bool zurück), und es gibt zwei Bremsen: eine
 * je Einzelschritt und eine für den ganzen Versand. Ein Mailserver, der nicht
 * antwortet, kostet höchstens TOTAL_TIMEOUT Sekunden.
 *
 * Warum ein Fehlschlag nicht verschwindet: Er landet in der PHP-Fehlerlog UND
 * in storage/mail.log, und der Grund ist über lastError() abrufbar. Der
 * Notifier hängt ihn an die Meldung in Sarahs Posteingang – sonst merkt es
 * niemand, bis sich jemand nicht anmelden kann, weil die PIN nie ankam.
 */
final class Mailer
{
    /** Geduld für einen einzelnen Schritt (Verbinden, eine Antwort lesen). */
    private const TIMEOUT = 5;

    /** Geduld für den gesamten Versand. Danach wird abgebrochen. */
    private const TOTAL_TIMEOUT = 12;

    private static string $lastError = '';

    /** Zeitpunkt, ab dem abgebrochen wird (Unixzeit mit Nachkommastellen). */
    private static float $deadline = 0.0;

    /**
     * Verschickt eine Nachricht. Gibt zurück, ob sie rausging.
     * Der Grund eines Fehlschlags steht danach in lastError().
     *
     * $replyTo setzt die Antwortadresse NUR für diese eine Nachricht und
     * übersteuert damit MAIL_REPLY_TO aus der .env. Gebraucht wird das vom
     * Kontaktformular: Absender bleibt Sarahs eigene Adresse (sonst stimmen
     * SPF und DKIM nicht und ausgerechnet die Anfrage landet im Spam), aber
     * ein Druck auf „Antworten" soll bei der fragenden Person landen.
     *
     * $fromName setzt den Klarnamen vor der Adresse, ebenfalls nur für diese
     * eine Nachricht, und übersteuert MAIL_FROM_NAME. Die ADRESSE bleibt
     * unberührt – nur der Name davor. SPF und DKIM hängen an der Adresse,
     * nicht am Namen, hier lässt sich also nichts kaputtmachen.
     */
    public static function send(
        string $to,
        string $subject,
        string $body,
        ?string $replyTo = null,
        ?string $fromName = null
    ): bool
    {
        self::$lastError = '';
        self::$deadline  = microtime(true) + self::TOTAL_TIMEOUT;

        $to = trim($to);
        if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return self::fail('Keine gültige Empfängeradresse: "' . $to . '"');
        }

        try {
            return match ((string) config('mail.driver')) {
                'smtp'  => self::viaSmtp($to, $subject, $body, $replyTo, $fromName),
                'mail'  => self::viaMailFunction($to, $subject, $body, $replyTo, $fromName),
                default => self::viaLog($to, $subject, $body, $replyTo, $fromName),
            };
        } catch (Throwable $e) {
            // Auch ein Programmierfehler hier darf die Buchung nicht mitreißen.
            return self::fail($e->getMessage());
        }
    }

    /** Warum der letzte Versand scheiterte. Leer, wenn er geklappt hat. */
    public static function lastError(): string
    {
        return self::$lastError;
    }

    // -----------------------------------------------------------------------
    // Die drei Wege
    // -----------------------------------------------------------------------

    private static function viaLog(
        string $to,
        string $subject,
        string $body,
        ?string $replyTo = null,
        ?string $fromName = null
    ): bool {
        // Bewusst lesbar und nicht als fertige Nachricht: Diese Datei ist zum
        // Nachschauen da, nicht zum Verschicken. Die Antwortadresse steht mit
        // drin – sonst lässt sich lokal nicht prüfen, ob sie richtig gesetzt
        // wird, und genau daran hängt beim Kontaktformular alles.
        $antwort = self::resolveReplyTo($replyTo);
        $name    = self::resolveFromName($fromName);

        return self::appendLog(sprintf(
            "[%s] Von: %s | An: %s%s | Betreff: %s\n%s\n%s\n\n",
            date('Y-m-d H:i:s'),
            $name !== '' ? $name . ' <' . trim((string) config('mail.from')) . '>'
                         : trim((string) config('mail.from')),
            $to,
            $antwort !== '' ? ' | Antwort an: ' . $antwort : '',
            $subject,
            str_repeat('-', 60),
            $body
        ));
    }

    private static function viaMailFunction(
        string $to,
        string $subject,
        string $body,
        ?string $replyTo = null,
        ?string $fromName = null
    ): bool {
        $headers = self::headers($to, $replyTo, $fromName);
        // Empfänger, Betreff und Zeitstempel setzt mail() bzw. der MTA selbst.
        unset($headers['To'], $headers['Date'], $headers['Message-ID']);

        $ok = @mail(
            $to,
            self::encodeHeader($subject),
            self::encodeBody($body),
            self::headerLines($headers)
        );

        return $ok ? true : self::fail(
            'mail() hat abgelehnt. Auf diesem Server gibt es kein Mailprogramm – '
            . 'MAIL_DRIVER=smtp ist hier der richtige Weg.'
        );
    }

    /**
     * Der eigentliche SMTP-Ablauf. Bewusst zu Fuß und ohne Bibliothek: Das
     * Projekt hat keinen Composer, und mehr als ein Dutzend Zeilen Protokoll
     * ist es nicht.
     */
    private static function viaSmtp(
        string $to,
        string $subject,
        string $body,
        ?string $replyTo = null,
        ?string $fromName = null
    ): bool {
        $host     = trim((string) config('mail.smtp.host', ''));
        $port     = (int) config('mail.smtp.port', 465);
        $user     = trim((string) config('mail.smtp.user', ''));
        $password = (string) config('mail.smtp.password', '');
        $security = strtolower(trim((string) config('mail.smtp.security', 'tls')));
        $from     = trim((string) config('mail.from'));

        if ($host === '') {
            return self::fail('SMTP_HOST ist nicht gesetzt.');
        }
        if ($from === '') {
            return self::fail('MAIL_FROM ist nicht gesetzt.');
        }

        // Das Zertifikat WIRD geprüft. Keine Fleißaufgabe: Ohne diese Zeilen
        // ist die Verbindung zwar verschlüsselt, aber jeder dazwischen kann
        // sich als der Mailserver ausgeben – und bekommt beim Anmelden das
        // Passwort im Klartext. Wer hier etwas abschaltet, weil "es sonst
        // nicht geht", hat das Problem nicht gelöst, sondern versteckt.
        $context = stream_context_create(['ssl' => [
            'verify_peer'       => true,
            'verify_peer_name'  => true,
            'allow_self_signed' => false,
            'SNI_enabled'       => true,
            'peer_name'         => $host,
        ]]);

        $errstr = '';
        $adresse = ($security === 'tls' ? 'ssl://' : 'tcp://') . $host . ':' . $port;

        // Bewusst KEINE Pfeilfunktion: stream_socket_client befüllt $errno und
        // $errstr per Referenz, und eine Pfeilfunktion fängt Variablen nur als
        // Kopie ein – die beiden kämen hier draußen nie an.
        $socket = self::ohneWarnung(
            static function () use ($adresse, $context, &$errno, &$errstr) {
                return stream_socket_client(
                    $adresse,
                    $errno,
                    $errstr,
                    self::TIMEOUT,
                    STREAM_CLIENT_CONNECT,
                    $context
                );
            },
            $warnungen
        );

        if ($socket === false) {
            // Reihenfolge mit Absicht: Ein Zertifikatsfehler steht NUR in den
            // Warnungen – $errstr sagt dann bloß "Unable to connect (Unknown
            // error)". Deshalb hat die erklärende Warnung Vorrang, sonst sucht
            // man das Netz ab, obwohl das Zertifikat nicht anerkannt wurde.
            $grund = self::ohneWarnungGrund($warnungen);
            if ($grund === '') {
                $grund = trim((string) $errstr) !== ''
                    ? trim((string) $errstr)
                    : 'Zeitüberschreitung';
            }

            return self::fail(sprintf('Keine Verbindung zu %s:%d – %s', $host, $port, $grund));
        }
        stream_set_timeout($socket, self::TIMEOUT);

        try {
            if (self::response($socket, 220, 'Begrüßung') === null) {
                return false;
            }

            // Der Name, mit dem wir uns vorstellen. Die Domain der
            // Absenderadresse ist dafür die plausibelste Angabe.
            $ehlo     = self::domainOf($from);
            $greeting = self::command($socket, 'EHLO ' . $ehlo, 250);
            if ($greeting === null) {
                return false;
            }

            if ($security === 'starttls') {
                if (self::command($socket, 'STARTTLS', 220) === null) {
                    return false;
                }
                $hochgestuft = self::ohneWarnung(
                    static fn () => stream_socket_enable_crypto(
                        $socket,
                        true,
                        STREAM_CRYPTO_METHOD_TLS_CLIENT
                    ),
                    $warnungen
                );
                if ($hochgestuft !== true) {
                    $grund = self::ohneWarnungGrund($warnungen);

                    return self::fail('STARTTLS fehlgeschlagen – ' . ($grund !== ''
                        ? $grund
                        : 'Zertifikat von ' . $host . ' nicht anerkannt.'));
                }
                // EHLO muss wiederholt werden: Was der Server im Klartext
                // angekündigt hat, gilt nach dem Hochstufen nicht mehr –
                // insbesondere bietet er AUTH oft erst jetzt an.
                $greeting = self::command($socket, 'EHLO ' . $ehlo, 250);
                if ($greeting === null) {
                    return false;
                }
            }

            if ($user !== '' && !self::authenticate($socket, $greeting, $user, $password)) {
                return false;
            }

            if (self::command($socket, 'MAIL FROM:<' . $from . '>', 250) === null) {
                return false;
            }
            // 251 heißt "nehme ich an und leite weiter" – auch ein Ja.
            if (self::command($socket, 'RCPT TO:<' . $to . '>', [250, 251]) === null) {
                return false;
            }
            if (self::command($socket, 'DATA', 354) === null) {
                return false;
            }

            fwrite($socket, self::message($to, $subject, $body, $replyTo, $fromName) . "\r\n.\r\n");
            if (self::response($socket, 250, 'Nachricht') === null) {
                return false;
            }

            // Ein misslungenes QUIT ist egal, die Mail ist angenommen.
            self::command($socket, 'QUIT', [221]);

            return true;
        } finally {
            @fclose($socket);
        }
    }

    // -----------------------------------------------------------------------
    // SMTP-Protokoll
    // -----------------------------------------------------------------------

    private static function authenticate($socket, string $greeting, string $user, string $password): bool
    {
        $angeboten = strtoupper($greeting);

        if (str_contains($angeboten, 'LOGIN')) {
            // Benutzername und Passwort gehen als eigene Zeilen, base64-kodiert.
            // Das ist KEINE Verschlüsselung – deshalb ist TLS oben Pflicht.
            return self::command($socket, 'AUTH LOGIN', 334, 'AUTH LOGIN') !== null
                && self::command($socket, base64_encode($user), 334, 'Benutzername') !== null
                && self::command($socket, base64_encode($password), 235, 'Passwort') !== null;
        }

        if (str_contains($angeboten, 'PLAIN')) {
            $token = base64_encode("\0" . $user . "\0" . $password);

            return self::command($socket, 'AUTH PLAIN ' . $token, 235, 'AUTH PLAIN') !== null;
        }

        return self::fail(
            'Der Mailserver bietet weder AUTH LOGIN noch AUTH PLAIN an. '
            . 'Angekündigt hat er: ' . trim($greeting)
        );
    }

    /**
     * Schickt einen Befehl und liest die Antwort.
     *
     * $label ist das, was im Fehlerfall protokolliert wird. Für alles rund um
     * die Anmeldung MUSS es gesetzt sein: Sonst stünde der base64-kodierte –
     * also im Klartext lesbare – Zugang in der Logdatei.
     */
    private static function command($socket, string $command, int|array $expected, string $label = ''): ?string
    {
        if (@fwrite($socket, $command . "\r\n") === false) {
            self::fail('Verbindung zum Mailserver abgebrochen.');

            return null;
        }

        return self::response($socket, $expected, $label !== '' ? $label : $command);
    }

    /**
     * Liest eine – auch mehrzeilige – Antwort und prüft ihren Code.
     * Gibt den Antworttext zurück oder null, wenn etwas nicht stimmt.
     */
    private static function response($socket, int|array $expected, string $label): ?string
    {
        $zeilen = [];

        do {
            if (microtime(true) > self::$deadline) {
                self::fail('Der Mailserver hat zu lange gebraucht (bei: ' . $label . ').');

                return null;
            }

            $zeile = @fgets($socket, 515);
            if ($zeile === false) {
                $meta = stream_get_meta_data($socket);
                self::fail(($meta['timed_out'] ?? false)
                    ? 'Keine Antwort vom Mailserver (bei: ' . $label . ').'
                    : 'Verbindung zum Mailserver verloren (bei: ' . $label . ').');

                return null;
            }

            $zeilen[] = rtrim($zeile, "\r\n");
            // Mehrzeilig: "250-…" geht weiter, "250 …" ist die letzte Zeile.
        } while (isset($zeile[3]) && $zeile[3] === '-');

        $letzte = (string) end($zeilen);
        $code   = (int) substr($letzte, 0, 3);

        if (!in_array($code, (array) $expected, true)) {
            self::fail($label . ' -> ' . implode(' | ', $zeilen));

            return null;
        }

        return implode("\n", $zeilen);
    }

    // -----------------------------------------------------------------------
    // Die Nachricht selbst
    // -----------------------------------------------------------------------

    /**
     * Die Antwortadresse dieser Nachricht: erst die je Aufruf übergebene,
     * sonst MAIL_REPLY_TO. Ungültiges fliegt raus statt in den Kopf – ein
     * Reply-To kommt beim Kontaktformular aus einem Formularfeld, und was
     * von dort kommt, gehört ungeprüft in keine Kopfzeile.
     */
    private static function resolveReplyTo(?string $replyTo): string
    {
        $wert = trim((string) ($replyTo ?? config('mail.reply_to', '')));

        return $wert !== '' && filter_var($wert, FILTER_VALIDATE_EMAIL) ? $wert : '';
    }

    /**
     * Der Klarname vor der Adresse: erst der je Aufruf übergebene, sonst
     * MAIL_FROM_NAME. Zeilenumbrüche und Steuerzeichen fliegen raus – der
     * Wert landet in einer Kopfzeile, und ein Umbruch darin wäre eine
     * eingeschleuste zweite Kopfzeile.
     */
    private static function resolveFromName(?string $fromName): string
    {
        $wert = (string) ($fromName ?? config('mail.from_name', ''));

        return trim(preg_replace('/[\p{C}]+/u', ' ', $wert) ?? '');
    }

    /** @return array<string,string> */
    private static function headers(string $to, ?string $replyTo = null, ?string $fromName = null): array
    {
        $from = trim((string) config('mail.from'));
        $name = self::resolveFromName($fromName);

        $headers = [
            'Date'         => date('r'),
            'From'         => $name !== ''
                ? self::encodeHeader($name) . ' <' . $from . '>'
                : $from,
            'To'           => $to,
            // Ohne eigene Message-ID vergibt mancher Server gar keine, und
            // Mailprogramme können Antworten dann nicht zuordnen.
            'Message-ID'   => '<' . bin2hex(random_bytes(12)) . '@' . self::domainOf($from) . '>',
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/plain; charset=UTF-8',
            // Base64 nimmt zwei Fallstricke auf einmal weg: Es gibt keine zu
            // langen Zeilen, und kein Punkt kann am Zeilenanfang stehen – ein
            // einzelner Punkt beendet sonst mitten im Text die Übertragung.
            'Content-Transfer-Encoding' => 'base64',
        ];

        $antwort = self::resolveReplyTo($replyTo);
        if ($antwort !== '') {
            $headers['Reply-To'] = $antwort;
        }

        return $headers;
    }

    /** @param array<string,string> $headers */
    private static function headerLines(array $headers): string
    {
        $zeilen = [];
        foreach ($headers as $name => $wert) {
            $zeilen[] = $name . ': ' . $wert;
        }

        return implode("\r\n", $zeilen);
    }

    private static function message(
        string $to,
        string $subject,
        string $body,
        ?string $replyTo = null,
        ?string $fromName = null
    ): string {
        $headers            = self::headers($to, $replyTo, $fromName);
        $headers['Subject'] = self::encodeHeader($subject);

        return self::headerLines($headers) . "\r\n\r\n" . self::encodeBody($body);
    }

    private static function encodeBody(string $body): string
    {
        return chunk_split(base64_encode($body), 76, "\r\n");
    }

    /**
     * Kopfzeilen dürfen nur ASCII enthalten (RFC 2047). Ohne das käme
     * "Müller hat sich eingetragen" als "M?ller" oder schlimmer an.
     *
     * Geschnitten wird an ZEICHENgrenzen, nicht an Bytegrenzen: Ein Umlaut
     * sind zwei Bytes, und mittendurch getrennt zerfällt er in zwei Hälften,
     * die kein Mailprogramm mehr zusammensetzt.
     */
    private static function encodeHeader(string $text): string
    {
        $text = str_replace(["\r", "\n"], ' ', trim($text));

        if (!preg_match('/[^\x20-\x7E]/', $text)) {
            return $text;   // reines ASCII, nichts zu tun
        }

        $zeichen = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
        if ($zeichen === false) {
            // Kein gültiges UTF-8 – dann lieber grob säubern als Unsinn senden.
            return preg_replace('/[^\x20-\x7E]/', '?', $text) ?? '';
        }

        // 30 Bytes je Stück: base64 macht daraus 40 Zeichen, plus "=?UTF-8?B?"
        // und "?=" sind es 52 – unter der Grenze von 75 Zeichen je kodiertem Wort.
        $stuecke = [];
        $aktuell = '';
        foreach ($zeichen as $z) {
            if (strlen($aktuell) + strlen($z) > 30) {
                $stuecke[] = $aktuell;
                $aktuell   = '';
            }
            $aktuell .= $z;
        }
        if ($aktuell !== '') {
            $stuecke[] = $aktuell;
        }

        return implode("\r\n ", array_map(
            static fn (string $stueck): string => '=?UTF-8?B?' . base64_encode($stueck) . '?=',
            $stuecke
        ));
    }

    /**
     * Führt etwas aus und fängt die PHP-Warnung ein, statt sie mit @ zu
     * verschlucken.
     *
     * Klingt nach Kosmetik, ist aber der Unterschied zwischen einer
     * brauchbaren und einer irreführenden Fehlermeldung: Scheitert der
     * TLS-Aufbau am Zertifikat, bleibt $errstr von stream_socket_client leer
     * und der eigentliche Grund ("certificate verify failed") steht
     * ausschließlich in der Warnung.
     */
    private static function ohneWarnung(callable $aktion, ?array &$warnungen): mixed
    {
        $warnungen = [];
        set_error_handler(static function (int $nummer, string $text) use (&$warnungen): bool {
            // Der Funktionsname am Anfang sagt nichts, was nicht schon aus dem
            // Zusammenhang hervorgeht.
            $warnungen[] = trim(preg_replace('/^\w+\(\):\s*/', '', $text) ?? $text);

            return true;   // nicht weiterreichen, wir behandeln es selbst
        });

        try {
            return $aktion();
        } finally {
            restore_error_handler();
        }
    }

    /**
     * Sucht aus mehreren Warnungen die heraus, die etwas erklärt.
     *
     * Ein gescheiterter TLS-Aufbau erzeugt drei Stück, und ausgerechnet die
     * LETZTE ist die nutzloseste ("Unable to connect … Unknown error"). Die
     * erste nennt den Grund: "certificate verify failed".
     */
    private static function ohneWarnungGrund(array $warnungen): string
    {
        foreach ($warnungen as $warnung) {
            if (preg_match('/SSL|TLS|certificate|crypto/i', $warnung)) {
                return $warnung;
            }
        }

        return $warnungen[0] ?? '';
    }

    private static function domainOf(string $address): string
    {
        $at = strrchr($address, '@');

        return $at === false ? 'localhost' : substr($at, 1);
    }

    // -----------------------------------------------------------------------

    /** Hält den Grund fest und gibt false zurück – zum direkten `return`. */
    private static function fail(string $grund): bool
    {
        self::$lastError = $grund;
        error_log('Mailer: ' . $grund);
        // Auch in die mail.log, damit ein Fehlversuch dort auftaucht, wo man
        // nach Mails sucht – und nicht nur in der Fehlerlog des Webservers.
        self::appendLog(sprintf("[%s] FEHLGESCHLAGEN: %s\n\n", date('Y-m-d H:i:s'), $grund));

        return false;
    }

    private static function appendLog(string $eintrag): bool
    {
        return (bool) @file_put_contents(APP_ROOT . '/storage/mail.log', $eintrag, FILE_APPEND);
    }
}
