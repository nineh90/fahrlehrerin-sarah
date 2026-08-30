<?php
declare(strict_types=1);

/**
 * Das Kontaktformular (SAR-95).
 *
 * WARUM ES SO WENIG FRAGT. Sarah ist angestellte Fahrlehrerin. Ein Formular
 * mit zehn Feldern läse sich wie die Anmeldestrecke einer Fahrschule – also
 * wie ein Vertragsangebot, das es hier nicht gibt. Gefragt wird deshalb nur,
 * was Sarah braucht, um überhaupt antworten zu können: worum es geht, wer
 * schreibt und wie sie zurückkommt. Alles Weitere – wann jemand kann, wo er
 * wohnt – klärt sich in ihrer Antwort. Danach zu fragen, bevor überhaupt
 * feststeht, ob es passt, macht aus einer Nachricht einen Aufnahmebogen.
 *
 * ES WIRD NICHTS GESPEICHERT (Nils, 27.08.2026). Die Anfrage geht als Mail
 * an Sarah und ist danach nur noch in ihrem Postfach. Kein Datensatz, keine
 * Löschfrist, keine Admin-Ansicht, die niemand öffnet. Wer das ändert,
 * ändert damit auch die Datenschutzerklärung – dort steht ausdrücklich, dass
 * hier nichts liegen bleibt.
 *
 * ⚠️ ALLE TEXTE HIER SIND ENTWÜRFE und nicht Sarahs Worte. Das gilt für die
 * Meldungen genauso wie für die beiden Mails. Vor dem Livegang geht sie
 * darüber. Die Auswahl unter „Worum geht es" ist die Ausnahme: Das sind
 * wörtlich die sechs Kachel-Überschriften der Startseite, also ihre Fassung.
 */
final class Contact
{
    /**
     * Worum es geht. Schlüssel = was in der Mail steht, Wert = was dasteht.
     *
     * Die sechs sind die Karten aus „Wobei ich dich begleite" (home.php),
     * in derselben Reihenfolge und mit demselben Wortlaut. Absicht: Wer die
     * Startseite gelesen hat, findet hier wieder, was er dort angeklickt
     * hätte – und es entsteht keine zweite, abweichende Leistungsliste.
     */
    public const ANLIEGEN = [
        'klasse-b'  => 'Klasse B',
        'klasse-be' => 'Klasse BE',
        'handicap'  => 'Ausbildung mit Handicap',
        'hoeren'    => 'Ausbildung mit Hörschädigung',
        'neurodiv'  => 'Neurodivergenz',
        'angstfrei' => 'Angstfrei ans Steuer',
        'anderes'   => 'Etwas anderes',
    ];

    /**
     * Die Meldungen, wenn etwas fehlt.
     *
     * Stehen hier und nicht verstreut im Code, weil sie an ZWEI Stellen
     * gebraucht werden: von validate() auf dem Server und – über ein
     * data-Attribut im Formular – vom Schrittwechsel im Browser. Zwei
     * Fassungen desselben Satzes würden sich früher oder später
     * unterscheiden, und dann sagt die Seite je nach Weg etwas anderes.
     */
    public const MELDUNGEN = [
        'anliegen'     => 'Bitte sag mir kurz, worum es geht.',
        'name'         => 'Bitte trag deinen Namen ein.',
        'name-lang'    => 'Das ist zu lang für einen Namen.',
        'email'        => 'Diese E-Mail-Adresse sieht nicht richtig aus.',
        'erreichbar'   => 'Ohne E-Mail-Adresse oder Telefonnummer kann ich mich '
            . 'nicht zurückmelden – bitte trag eins von beidem ein.',
        'nachricht'    => 'Das ist zu lang. Ruf mich lieber an, dann erzählst du '
            . 'es mir direkt.',
        'einwilligung' => 'Ohne dein Einverständnis darf ich deine Angaben nicht '
            . 'verarbeiten.',
    ];

    /** Längste erlaubte Nachricht. Darüber ist es kein Kontaktformular mehr. */
    public const MAX_NACHRICHT = 3000;

    /**
     * Der Name, der in Sarahs Postfach vor der Adresse steht.
     *
     * WARUM DAS NICHT MAIL_FROM_NAME IST. Die Anfrage kommt von Sarahs
     * eigener Adresse – anders geht es nicht, sonst brechen SPF und DKIM.
     * Mit dem Klarnamen „Fahrlehrerin Sarah" davor stand die Anfrage aber in
     * ihrem Postfach, als hätte sie sie sich selbst geschrieben.
     *
     * Geändert wird deshalb NUR diese eine Nachricht und nicht der Wert in
     * der .env: Aus derselben Anwendung geht die Eingangsbestätigung an die
     * fragende Person raus, und die ist in Sarahs Stimme geschrieben
     * („… melde mich, sobald ich zwischen zwei Fahrstunden dazu komme.
     * Viele Grüße, Sarah"). Käme die von „Kontaktformular Website", wäre der
     * Absender ein Automat und der Text eine Person. Dasselbe gälte für jede
     * andere Mail der Anwendung.
     *
     * Die ADRESSE bleibt unberührt, nur der Name davor ändert sich.
     */
    public const ABSENDER_NAME = 'Kontaktformular Website';

    /**
     * Der Gruß über der Anfrage – jedes Mal ein anderer. Sarahs Osterei.
     *
     * DAS IST DIE EINZIGE STELLE DES PROJEKTS, AN DER EIN ERFUNDENER TEXT
     * unbedenklich ist: Diese Zeile geht ausschließlich an Sarah, kein
     * Besucher bekommt sie je zu sehen, und sie steht unter niemandes Namen.
     * Überall sonst gilt weiter, dass Text entweder von ihr stammt oder als
     * Entwurf gekennzeichnet ist.
     *
     * Der Ton lehnt sich an die Eingangsbestätigung an, damit die Seite
     * nicht nach außen locker und nach innen nach Formular klingt.
     *
     * WICHTIG BEIM ERGÄNZEN: Der Spruch trägt KEINE Information. Alles, was
     * Sarah wirklich braucht – wer, worum es geht, wie sie zurückkommt –,
     * steht darunter und im Betreff. Wer hier die Fakten hineinzieht, macht
     * eine Zeile, die man überliest, zur einzigen Quelle.
     *
     * Gezogen wird rein zufällig, ohne Gedächtnis: Das Formular speichert
     * nichts, also weiß auch niemand, was zuletzt drankam. Bei dreizehn
     * Sprüchen wiederholt sich also gelegentlich einer hintereinander – der
     * Preis dafür, dass hier nichts liegen bleibt.
     */
    public const BEGRUESSUNGEN = [
        'Handbremse lösen: Es gibt Post.',
        'Jemand hat geblinkt und will zu dir rüber.',
        'Frische Anfrage, noch warm.',
        'Da draußen will wieder jemand losfahren.',
        'Jemand hat sich getraut und auf „Absenden" gedrückt.',
        'Neue Anfrage. Kein Grund zu hupen.',
        'Einer mehr, der Blinker, Kupplung und Atmen gleichzeitig lernen will.',
        'Schulterblick: Da kommt was von rechts.',
        'Post für dich – und ausnahmsweise keine Werbung.',
        'Anfrage sauber eingeparkt in deinem Postfach.',
        'Jemand möchte bei dir ans Steuer.',
        'Es hat geklingelt. Sinnbildlich.',
        'Nicht abwürgen: Da ist eine Anfrage.',
    ];

    // -----------------------------------------------------------------------
    // Prüfen
    // -----------------------------------------------------------------------

    /**
     * Prüft die Eingaben.
     *
     * @param  array<string,mixed> $post
     * @return array{values: array<string,mixed>, errors: array<string,string>}
     */
    public static function validate(array $post): array
    {
        $values = [
            'anliegen'     => self::line($post['anliegen']  ?? ''),
            'name'         => self::line($post['name']      ?? ''),
            'email'        => self::line($post['email']     ?? ''),
            'telefon'      => self::line($post['telefon']   ?? ''),
            'nachricht'    => self::text($post['nachricht'] ?? ''),
            'einwilligung' => !empty($post['einwilligung']),
        ];

        $errors = [];

        if (!isset(self::ANLIEGEN[$values['anliegen']])) {
            $errors['anliegen'] = self::MELDUNGEN['anliegen'];
        }

        if (mb_strlen($values['name']) < 2) {
            $errors['name'] = self::MELDUNGEN['name'];
        } elseif (mb_strlen($values['name']) > 80) {
            $errors['name'] = self::MELDUNGEN['name-lang'];
        }

        if ($values['email'] !== '' && !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = self::MELDUNGEN['email'];
        }

        /* Eins von beidem reicht – manche mögen keine Mail, manche kein
           Telefon. Beides leer geht aber nicht: Dann steht die Anfrage in
           Sarahs Postfach und sie hat keine Möglichkeit zu antworten. */
        if ($values['email'] === '' && self::ziffern($values['telefon']) === '') {
            $errors['erreichbar'] = self::MELDUNGEN['erreichbar'];
        }

        if (mb_strlen($values['nachricht']) > self::MAX_NACHRICHT) {
            $errors['nachricht'] = self::MELDUNGEN['nachricht'];
        }

        if (!$values['einwilligung']) {
            $errors['einwilligung'] = self::MELDUNGEN['einwilligung'];
        }

        return ['values' => $values, 'errors' => $errors];
    }

    // -----------------------------------------------------------------------
    // Verschicken
    // -----------------------------------------------------------------------

    /**
     * Schickt die Anfrage an Sarah und – wenn eine Adresse dasteht – die
     * Eingangsbestätigung an die fragende Person.
     *
     * Rückgabe: ['sarah' => bool, 'person' => bool|null]. `null` heißt, es
     * wurde gar nicht erst versucht (keine Adresse angegeben). Die
     * Unterscheidung zählt: Nur die Mail an Sarah entscheidet darüber, ob
     * die Anfrage angekommen ist. Bleibt die Bestätigung aus, ist das ein
     * Schönheitsfehler – bleibt Sarahs Mail aus, ist die Anfrage weg.
     *
     * @param  array<string,mixed> $values
     * @return array{sarah: bool, person: bool|null}
     */
    public static function send(array $values): array
    {
        $sarah = Mailer::send(
            trim((string) config('contact.email')),
            self::subjectForSarah($values),
            self::bodyForSarah($values),
            /* Absender bleibt Sarahs eigene Adresse – im fremden Namen zu
               senden bricht SPF und DKIM, und dann landet ausgerechnet die
               Anfrage im Spam. Ein Druck auf „Antworten" soll aber bei der
               fragenden Person landen, nicht bei ihr selbst. */
            $values['email'] !== '' ? (string) $values['email'] : null,
            /* … und im Postfach steht davor nicht ihr eigener Name, sondern
               woher die Mail kommt. Siehe ABSENDER_NAME oben. */
            self::ABSENDER_NAME
        );

        if (!$sarah) {
            error_log('Kontaktformular: Mail an Sarah gescheitert – ' . Mailer::lastError());
        }

        $person = null;
        if ($values['email'] !== '' && filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $person = Mailer::send(
                (string) $values['email'],
                'Deine Nachricht ist angekommen',
                self::bodyForPerson($values)
            );

            if (!$person) {
                error_log('Kontaktformular: Bestätigung an ' . $values['email']
                    . ' gescheitert – ' . Mailer::lastError());
            }
        }

        return ['sarah' => $sarah, 'person' => $person];
    }

    // -----------------------------------------------------------------------
    // Die beiden Texte
    // -----------------------------------------------------------------------

    /** @param array<string,mixed> $v */
    private static function subjectForSarah(array $v): string
    {
        /* Anliegen und Name im Betreff – so sieht Sarah auf dem Sperrbildschirm
           schon, worum es geht, ohne die Mail zu öffnen. */
        return 'Anfrage über die Website: '
            . (self::ANLIEGEN[$v['anliegen']] ?? 'Kontakt')
            . ' – ' . $v['name'];
    }

    /** @param array<string,mixed> $v */
    private static function bodyForSarah(array $v): string
    {
        $zeilen = [
            /* Das Osterei. Steht ÜBER der Sachlage und ersetzt sie nicht –
               siehe BEGRUESSUNGEN. */
            self::BEGRUESSUNGEN[array_rand(self::BEGRUESSUNGEN)],
            '',
            $v['name'] . ' hat dir über das Formular auf deiner Website geschrieben.',
            '',
            'Worum es geht:  ' . (self::ANLIEGEN[$v['anliegen']] ?? '–'),
            '',
            'Erreichbar über:',
            $v['email'] !== ''   ? '  E-Mail:   ' . $v['email']   : '  E-Mail:   – keine angegeben –',
            $v['telefon'] !== '' ? '  Telefon:  ' . $v['telefon'] : '  Telefon:  – keine angegeben –',
        ];

        if ($v['nachricht'] !== '') {
            $zeilen[] = '';
            $zeilen[] = 'Dazu geschrieben:';
            $zeilen[] = '';
            $zeilen[] = self::einrücken((string) $v['nachricht']);
        }

        $zeilen[] = '';
        $zeilen[] = str_repeat('-', 60);

        /* Der Hinweis unten ist kein Beiwerk. Ohne E-Mail-Adresse geht die
           Antwort nicht per Knopfdruck, und wer das erst nach dem Tippen
           merkt, hat umsonst geschrieben. */
        $zeilen[] = $v['email'] !== ''
            ? 'Auf „Antworten" zu drücken schreibt direkt an ' . $v['name'] . '.'
            : 'ACHTUNG: Es steht keine E-Mail-Adresse dabei. Antworten geht nur '
              . 'per Telefon.';
        $zeilen[] = 'Diese Anfrage wird nirgends gespeichert – sie steht nur in '
            . 'dieser Mail.';
        $zeilen[] = 'Eingegangen am ' . date('d.m.Y') . ' um ' . date('H:i') . ' Uhr.';

        return implode("\n", $zeilen);
    }

    /**
     * Die Eingangsbestätigung an die fragende Person.
     *
     * DIESER TEXT IST VON NILS UND SARAH (30.08.2026) und ersetzt den
     * Entwurf, der hier bis dahin stand. Wortlaut, Gedankenstriche und das
     * „&" sind ihre – wer daran glättet, macht daraus wieder einen Entwurf.
     * Geändert wurde beim Übernehmen nur eines, auf ausdrücklichen Wunsch:
     * Von den zehn Emojis der Vorlage sind zwei geblieben, das 👋 am Anfang
     * und das 😜 am Schluss. Die übrigen standen neben Sätzen, die dasselbe
     * schon sagten.
     *
     * ZWEI DINGE AUS DEM ALTEN TEXT SIND WEG, weil die neue Fassung sie
     * nicht vorsieht: die Anrede mit dem Vornamen und der Rückblick
     * („Das hast du mir geschickt"), der Anliegen und Nachricht noch einmal
     * aufführte. Beides steht in der Versionsgeschichte.
     *
     * Die Telefonnummer kommt aus der Konfiguration und steht nicht im Text:
     * Sie steht an vier weiteren Stellen der Seite, und eine Nummer, die
     * sich an fünf Orten ändern muss, ändert sich irgendwann nur an vieren.
     *
     * @param array<string,mixed> $v
     */
    private static function bodyForPerson(array $v): string
    {
        $telefon = trim((string) config('contact.phone'));

        return implode("\n", [
            'Moin 👋',
            '',
            'Nachricht ist angekommen – ich ignoriere dich also nicht. Versprochen.',
            '',
            'Wahrscheinlich sitze ich gerade neben jemandem, der versucht, Blinker,',
            'Kupplung und Atmen gleichzeitig zu koordinieren.',
            '',
            'Sobald ich wieder beide Hände fürs Handy frei habe, melde ich mich bei',
            'dir. Manchmal dauert\'s ein bisschen – 24–48 Stunden sind im',
            'Ausnahmefall drin.',
            '',
            'Brennt die Hütte und es kann wirklich nicht warten?',
            'Dann ruf einfach durch: ' . $telefon,
            '',
            'Gehe ich nicht ran, bin ich vermutlich gerade in einer Fahrstunde –',
            'Rückruf kommt!',
            '',
            'Bis dahin: locker bleiben & nicht abwürgen. 😜',
            '',
            'Sarah',
        ]);
    }

    // -----------------------------------------------------------------------
    // Kleinkram
    // -----------------------------------------------------------------------

    /** Einzeiliges Feld: Zeilenumbrüche und Steuerzeichen fliegen raus. */
    private static function line(mixed $wert): string
    {
        if (!is_string($wert)) {
            return '';
        }

        return trim(preg_replace('/[\p{C}]+/u', ' ', $wert) ?? '');
    }

    /** Mehrzeiliges Feld: Umbrüche bleiben, alles andere Unsichtbare nicht. */
    private static function text(mixed $wert): string
    {
        if (!is_string($wert)) {
            return '';
        }

        $wert = str_replace(["\r\n", "\r"], "\n", $wert);
        $wert = preg_replace('/[^\P{C}\n]+/u', '', $wert) ?? '';

        return trim($wert);
    }

    /** Nur die Ziffern einer Telefonnummer – zum Prüfen, ob überhaupt eine dasteht. */
    private static function ziffern(string $wert): string
    {
        return preg_replace('/\D+/', '', $wert) ?? '';
    }

    /** Fremden Text um zwei Zeichen einrücken, damit er sich vom Rest absetzt. */
    private static function einrücken(string $text): string
    {
        return '  ' . str_replace("\n", "\n  ", $text);
    }
}
