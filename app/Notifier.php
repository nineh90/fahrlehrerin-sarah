<?php
declare(strict_types=1);

/**
 * Sarah über Änderungen an ihren Stunden informieren.
 *
 * EIN Einstiegspunkt: Notifier::bookingChanged(). Aufgerufen wird er im Model
 * Booking, direkt nachdem die Transaktion erfolgreich war – dadurch löst jede
 * Buchung eine Meldung aus, egal ob sie aus dem Schüler- oder dem Adminbereich
 * kam, und niemand kann den Aufruf beim Anlegen einer neuen Route vergessen.
 *
 * Drei Kanäle, absichtlich abgestuft:
 *   1. Posteingang in der Schaltzentrale – immer, kann nicht ausfallen
 *   2. E-Mail an NOTIFY_TO              – wenn NOTIFY_MAIL=true
 *   3. Webhook (n8n, Make, Zapier …)    – wenn NOTIFY_WEBHOOK_URL gesetzt ist
 *
 * Der Webhook ist die vorgesehene Brücke zu allem Weiteren: Kalendereintrag,
 * Push, WhatsApp. Deshalb schickt er die Rohdaten als JSON und nicht den
 * fertigen Text – was daraus wird, entscheidet der Automat auf der anderen
 * Seite. Ob je ein Kalender direkt angebunden wird, ist offen; bis dahin ist
 * n8n der Weg, ohne diese Anwendung noch einmal anzufassen.
 *
 * Grundregel: Benachrichtigen darf NIE eine Buchung kaputt machen. Alles hier
 * läuft in try/catch, ein toter Webhook kostet höchstens ein paar Sekunden.
 */
final class Notifier
{
    /** Wie lange auf den Webhook gewartet wird, bevor aufgegeben wird. */
    private const WEBHOOK_TIMEOUT = 4;

    /**
     * Eine Änderung an einer Buchung melden.
     *
     * @param string      $event    gebucht | verschoben | storniert
     * @param array       $booking  Buchung inkl. student_name/starts_at – bei
     *                              'verschoben' die Daten VOR der Änderung
     * @param string      $actor    schueler | admin
     * @param string|null $newStartsAt neue Startzeit, nur bei 'verschoben'
     */
    public static function bookingChanged(
        string $event,
        ?array $booking,
        string $actor = 'schueler',
        ?string $newStartsAt = null
    ): void {
        if ($booking === null || !isset(Notification::EVENTS[$event])) {
            return;
        }

        try {
            $payload = self::payload($event, $booking, $actor, $newStartsAt);
            $text    = self::compose($event, $booking, $actor, $newStartsAt);

            $channels = [];
            // Was Sarah selbst ausgelöst hat, muss ihr niemand mailen. Der
            // Webhook bekommt es trotzdem: eine Absage von ihr muss genauso im
            // Kalender landen wie eine vom Schüler.
            if ($actor !== 'admin' && self::sendMail($text['subject'], $text['body'])) {
                $channels[] = 'mail';
            }
            if (self::sendWebhook($payload)) {
                $channels[] = 'webhook';
            }

            Notification::create([
                'event'          => $event,
                'actor'          => $actor,
                'booking_id'     => (int) $booking['id'],
                'student_name'   => (string) $booking['student_name'],
                'starts_at'      => $newStartsAt ?? $booking['starts_at'],
                'from_starts_at' => $newStartsAt !== null ? $booking['starts_at'] : null,
                'title'          => $text['title'],
                'body'           => $text['body'],
                'channels'       => $channels ? implode(',', $channels) : null,
                // Was Sarah selbst getan hat, muss sie nicht mehr lesen –
                // es bleibt aber als Verlauf stehen.
                'read_at'        => $actor === 'admin' ? date('Y-m-d H:i:s') : null,
            ]);
        } catch (Throwable $e) {
            // Eine fehlgeschlagene Meldung darf die Buchung nicht mitreißen.
            error_log('Notifier: ' . $e->getMessage());
        }
    }

    // -----------------------------------------------------------------------
    // An die Fahrschüler:innen
    // -----------------------------------------------------------------------

    /**
     * Schickt eine frisch erzeugte PIN an die Person selbst.
     *
     * Das ist die EINZIGE Stelle, an der eine PIN das System im Klartext
     * verlässt – gespeichert wird sie nirgends (siehe Student::resetPin()).
     * Kommt die Mail nicht an, bleibt Sarah der Weg über die Anzeige im
     * Admin: sie sieht die PIN direkt nach dem Erzeugen einmalig.
     *
     * Gibt zurück, ob die Mail rausging.
     */
    public static function pinToStudent(array $student, string $pin): bool
    {
        if (!config('notify.student_mail')) {
            return false;
        }
        $to = trim((string) ($student['email'] ?? ''));
        if ($to === '') {
            return false;
        }

        // Nur der Vorname – so klingt es wie von Sarah und nicht wie ein Formular
        $vorname = explode(' ', trim((string) $student['name']))[0];

        $body = sprintf(
            "Hallo %s,\n\n"
            . "du kannst dich ab jetzt selbst für deine Fahrstunden bei mir eintragen,\n"
            . "Termine verschieben oder absagen.\n\n"
            . "  Adresse:  %s\n"
            . "  E-Mail:   %s\n"
            . "  PIN:      %s\n\n"
            . "Die PIN gehört dir allein – bitte gib sie nicht weiter. Wenn du sie\n"
            . "verlierst, sag mir Bescheid, dann erzeuge ich dir eine neue.\n\n"
            . "Absagen und Verschieben sind bis %d Stunden vor der Stunde möglich.\n"
            . "Danach melde dich bitte direkt bei mir: %s\n\n"
            . "Bis bald\n"
            . "Sarah",
            $vorname,
            absolute_url('/login'),
            $student['email'],
            $pin,
            Booking::deadlineHours(),
            (string) config('contact.phone')
        );

        return Mailer::send($to, 'Dein Zugang zu meinen Fahrstunden', $body);
    }

    // -----------------------------------------------------------------------
    // Texte
    // -----------------------------------------------------------------------

    /** @return array{title:string,subject:string,body:string} */
    private static function compose(
        string $event,
        array $booking,
        string $actor,
        ?string $newStartsAt
    ): array {
        $name = (string) $booking['student_name'];
        $alt  = format_datetime(dt((string) $booking['starts_at']));
        $neu  = $newStartsAt !== null ? format_datetime(dt($newStartsAt)) : $alt;
        // Die Schaltzentrale spricht Sarah in der Du-Form an – auch über sie selbst.
        // Bei ihren eigenen Aktionen gehört der Name des Schülers in den Satz,
        // sonst steht in der Liste nur, DASS sie etwas getan hat.
        $title = match (true) {
            $event === 'gebucht' && $actor === 'admin'    => 'Du hast ' . $name . ' einen Termin zugewiesen',
            $event === 'gebucht'                          => $name . ' hat sich eingetragen',
            $event === 'verschoben' && $actor === 'admin' => 'Du hast die Stunde von ' . $name . ' verschoben',
            $event === 'verschoben'                       => $name . ' hat eine Stunde verschoben',
            $event === 'storniert' && $actor === 'admin'  => 'Du hast die Stunde von ' . $name . ' abgesagt',
            default                                       => $name . ' hat eine Stunde abgesagt',
        };

        $body = match ($event) {
            'gebucht'    => $actor === 'admin'
                ? sprintf('%s ist für %s eingetragen.', $name, $neu)
                : sprintf('%s hat sich für %s eingetragen.', $name, $neu),
            'verschoben' => sprintf(
                "Die Stunde von %s wurde verschoben.\nVorher: %s\nJetzt:  %s",
                $name,
                $alt,
                $neu
            ),
            'storniert'  => sprintf(
                "Die Stunde von %s am %s wurde abgesagt. Die Zeit ist wieder frei.",
                $name,
                $alt
            ),
        };

        $extra = [];
        if (!empty($booking['type'])) {
            $extra[] = Slot::label($booking);
        }
        if (!empty($booking['location'])) {
            $extra[] = 'Treffpunkt: ' . $booking['location'];
        }
        if (!empty($booking['student_phone'])) {
            $extra[] = 'Telefon: ' . $booking['student_phone'];
        }
        if ($extra) {
            $body .= "\n\n" . implode("\n", $extra);
        }

        $body .= "\n\nAlle Termine: " . absolute_url('/admin');

        return [
            'title'   => $title,
            'subject' => '[' . config('app_name') . '] ' . $title,
            'body'    => $body,
        ];
    }

    // -----------------------------------------------------------------------
    // Kanäle
    // -----------------------------------------------------------------------

    private static function sendMail(string $subject, string $body): bool
    {
        if (!config('notify.mail')) {
            return false;
        }
        $to = (string) (config('notify.to') ?: config('mail.to'));

        return $to !== '' && Mailer::send($to, $subject, $body);
    }

    /**
     * Rohdaten als JSON an den konfigurierten Webhook. Ist ein Secret gesetzt,
     * geht die HMAC-Signatur des Bodys als Header mit – so kann der Empfänger
     * (z.B. ein n8n-Workflow) prüfen, dass die Daten wirklich von hier kommen.
     */
    private static function sendWebhook(array $payload): bool
    {
        $url = (string) config('notify.webhook_url', '');
        if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $json    = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $headers = ['Content-Type: application/json; charset=utf-8'];

        $secret = (string) config('notify.webhook_secret', '');
        if ($secret !== '') {
            $headers[] = 'X-Signature: sha256=' . hash_hmac('sha256', (string) $json, $secret);
        }

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $json,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => self::WEBHOOK_TIMEOUT,
                CURLOPT_CONNECTTIMEOUT => 2,
            ]);
            curl_exec($ch);
            $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

            return $status >= 200 && $status < 300;
        }

        // Ohne cURL (kommt auf einfachem Shared Hosting vor) über Streams
        $context = stream_context_create(['http' => [
            'method'        => 'POST',
            'header'        => implode("\r\n", $headers),
            'content'       => $json,
            'timeout'       => self::WEBHOOK_TIMEOUT,
            'ignore_errors' => true,
        ]]);

        return @file_get_contents($url, false, $context) !== false;
    }

    /** Was der Automat auf der anderen Seite bekommt: Daten, kein fertiger Text. */
    private static function payload(
        string $event,
        array $booking,
        string $actor,
        ?string $newStartsAt
    ): array {
        $startsAt = (string) ($newStartsAt ?? $booking['starts_at']);
        $start    = dt($startsAt);
        $minutes  = (int) ($booking['duration_min'] ?? config('booking.slot_duration_min', 45));

        return [
            'event'      => $event,
            'actor'      => $actor,
            'occurred_at' => (new DateTimeImmutable('now'))->format(DATE_ATOM),
            'booking'    => [
                'id'       => (int) $booking['id'],
                'type'     => $booking['type'] ?? null,
                'location' => $booking['location'] ?? null,
            ],
            'student'    => [
                'name'  => $booking['student_name'] ?? null,
                'email' => $booking['student_email'] ?? null,
                'phone' => $booking['student_phone'] ?? null,
            ],
            // ISO-8601 mit Zeitzone – direkt als Kalendereintrag verwendbar
            'slot'       => [
                'starts_at'    => $start->format(DATE_ATOM),
                'ends_at'      => $start->modify('+' . $minutes . ' minutes')->format(DATE_ATOM),
                'duration_min' => $minutes,
                'previous_starts_at' => $newStartsAt !== null
                    ? dt((string) $booking['starts_at'])->format(DATE_ATOM)
                    : null,
            ],
        ];
    }
}
