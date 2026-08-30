<?php
declare(strict_types=1);

/**
 * /kontakt – Kontaktdaten und das Formular (SAR-95).
 *
 * Liegt bewusst nicht mehr im PageController: Die Seite ist die einzige
 * öffentliche, die ein POST entgegennimmt, und die GET-Fassung muss nach
 * einem Fehler dieselben Daten wieder anzeigen können. Beides gehört
 * zusammen an einen Ort.
 *
 * ES WIRD NICHTS GESPEICHERT. Was hier ankommt, geht als Mail weiter und ist
 * danach nur noch in Sarahs Postfach – siehe app/Contact.php.
 */
final class ContactController
{
    /** Wie viele Anfragen aus derselben Sitzung, bevor Schluss ist. */
    private const MAX_PRO_SITZUNG = 3;

    /** Zeitraum dafür, in Sekunden. */
    private const FENSTER = 3600;

    /**
     * Schneller als das kann niemand ein Formular ausfüllen. Wer es doch
     * tut, ist ein Skript.
     *
     * Zusammen mit dem Honigtopf-Feld ist das der ganze Spamschutz – und das
     * ist Absicht: reCAPTCHA, hCaptcha und Turnstile laden Fremdcode und
     * bauen eine Verbindung nach außen auf. Diese Seite tut das an keiner
     * einzigen Stelle, und genau das steht in der Datenschutzerklärung. Ein
     * Schutz, der diesen Satz kaputt macht, kostet mehr, als er bringt.
     */
    private const MIN_SEKUNDEN = 3;

    public function index(): void
    {
        $this->render();
    }

    public function store(): void
    {
        verify_csrf();

        /* Honigtopf: Das Feld ist im Formular versteckt und für Menschen
           nicht erreichbar. Ein Bot füllt aus, was er findet. Wir tun so,
           als wäre alles gut – wer eine Fehlermeldung bekommt, probiert es
           anders herum noch einmal. */
        if (trim((string) ($_POST['website'] ?? '')) !== '') {
            $this->danke();
        }

        // Zeitfalle. Der Zeitpunkt kommt aus der Session, nicht aus dem
        // Formular – ein verstecktes Feld könnte ein Bot einfach umschreiben.
        $begonnen = (int) ($_SESSION['_kontakt_start'] ?? 0);
        if ($begonnen > 0 && (time() - $begonnen) < self::MIN_SEKUNDEN) {
            $this->danke();
        }

        if (!$this->darfNochSenden()) {
            $this->render(
                Contact::validate($_POST)['values'],
                ['form' => 'Du hast gerade schon geschrieben. Wenn es eilt, '
                    . 'ruf mich bitte an – die Nummer steht nebenan.']
            );
            return;
        }

        ['values' => $values, 'errors' => $errors] = Contact::validate($_POST);

        if ($errors !== []) {
            /* Kein Redirect: Nach einem Fehler soll dastehen, was getippt
               wurde. Deshalb wird hier direkt gerendert und nicht über eine
               Flash-Message umgeleitet. */
            $this->render($values, $errors);
            return;
        }

        $ergebnis = Contact::send($values);

        if (!$ergebnis['sarah']) {
            /* Der einzige Fall, in dem jemand umsonst getippt hat. Das darf
               nicht still passieren, und ein „versuch es später noch einmal"
               hilft niemandem – also steht hier die Nummer. */
            $this->render($values, ['form' => 'Das hat gerade nicht geklappt – '
                . 'meine Technik streikt. Ruf mich bitte an: '
                . config('contact.phone') . '.']);
            return;
        }

        $this->merkeGesendet();
        $this->danke();
    }

    // -----------------------------------------------------------------------

    /**
     * @param array<string,mixed>  $values
     * @param array<string,string> $errors
     */
    private function render(array $values = [], array $errors = []): void
    {
        // Startzeit für die Zeitfalle. Wird bei jedem Aufruf neu gesetzt,
        // sonst schlägt sie beim zweiten Anlauf nach einem Fehler zu.
        ensure_session();
        $_SESSION['_kontakt_start'] = time();

        render('pages/kontakt', [
            'title'           => 'Kontakt',
            /* Die Bestätigung nach dem Absenden lesen wir HIER mit, damit die
               View sie an die Stelle des Formulars setzen kann. Ein Band am
               Seitenanfang allein hilft dem nicht, der gerade unten getippt
               hat – und ein wieder leeres Formular liest sich, als wäre
               nichts passiert.

               GELESEN, NICHT VERBRAUCHT: Das Band oben bleibt zusätzlich
               stehen. Eigentlich sollte die Seite nach dem Absenden von
               selbst zum Formular springen – die Adresse trägt dafür
               `#schreib-mir` –, aber genau das tut sie nachweislich nicht
               (nachgemessen: scrollY bleibt 0). Solange das so ist, ist die
               doppelte Meldung die sichere Seite: Wer oben landet, liest das
               Band, wer unten steht, den Block. */
            'erfolg'          => peek_flash('success'),
            /* Die alte Fassung nannte nur die Kanäle. Eine Kontaktseite ist der
               Treffer für „Fahrlehrerin + Ort + Kontakt" – dann darf in der
               Vorschau auch stehen, um wen es geht und wo. */
            'metaDescription' => 'So erreichst du Sarah – Fahrlehrerin in '
                . area_sentence() . '. Telefon, E-Mail, Nachricht über das '
                . 'Formular, TikTok und Instagram.',
            'values'          => $values,
            'errors'          => $errors,
        ]);
    }

    /**
     * Nach dem Absenden umleiten (Post/Redirect/Get), damit ein Neuladen die
     * Anfrage nicht ein zweites Mal verschickt.
     */
    private function danke(): never
    {
        set_flash('success', 'Deine Nachricht ist raus – ich melde mich bei dir. '
            . 'Wenn du eine E-Mail-Adresse angegeben hast, liegt gleich eine '
            . 'Bestätigung in deinem Postfach.');
        /* Mit Sprungmarke: Der Browser steht danach beim Formular, also da,
           wo die Bestätigung erscheint – und nicht wieder ganz oben. */
        redirect('/kontakt#schreib-mir');
    }

    private function darfNochSenden(): bool
    {
        ensure_session();
        $bisher = $this->letzteSendungen();

        return count($bisher) < self::MAX_PRO_SITZUNG;
    }

    private function merkeGesendet(): void
    {
        ensure_session();
        $bisher   = $this->letzteSendungen();
        $bisher[] = time();

        $_SESSION['_kontakt_gesendet'] = $bisher;
    }

    /**
     * Die Zeitpunkte der letzten Sendungen innerhalb des Fensters.
     *
     * Bewusst nur in der Session und nicht in der Datenbank: Eine Bremse pro
     * IP bräuchte eine Tabelle mit IP-Adressen – also genau die Speicherung,
     * die dieses Formular nicht haben soll. Wer Kekse wegwirft, kommt an
     * dieser Bremse vorbei; Honigtopf und Zeitfalle stehen dann noch davor,
     * und für die Größenordnung dieser Seite reicht das.
     *
     * @return list<int>
     */
    private function letzteSendungen(): array
    {
        $roh    = $_SESSION['_kontakt_gesendet'] ?? [];
        $grenze = time() - self::FENSTER;

        if (!is_array($roh)) {
            return [];
        }

        return array_values(array_filter(
            array_map('intval', $roh),
            static fn (int $zeit): bool => $zeit > $grenze
        ));
    }
}
