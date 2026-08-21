<?php
declare(strict_types=1);

/**
 * WEGBEGLEITER: die Betriebe, mit denen Sarah zusammenarbeitet.
 *
 * Der Name ist Sarahs eigener (Ticket SAR-32, damals als Idee notiert):
 * „Partner" klingt nach Werbeplatz, „Wegbegleiter" nach den Leuten, die auf
 * ihrem Weg tatsächlich vorkommen. Genau die stehen hier, und nur die.
 *
 * Zwei Teile pro Eintrag, bewusst getrennt:
 *
 *   1. HIER die Stammdaten: Name, Logo, Adresse der eigenen Website. Sie
 *      tragen die Kachel unten auf der Startseite (partials/wegbegleiter.php)
 *      und den Kopf der Unterseite.
 *   2. Der Fließtext der Unterseite als eigene View unter
 *      `app/Views/pages/wegbegleiter/<slug>.php`. Eine Infoseite ist Text und
 *      keine Tabelle; in ein Datenfeld gepresst wäre sie nach dem zweiten
 *      Partner unlesbar.
 *
 * DIE REIHENFOLGE HIER IST DIE REIHENFOLGE AUF DER SEITE, und sie ist seit dem
 * 21.08.2026 gesetzt (Nils): Fahrschule Sander, moooov, Johannes Springer,
 * Nils-Digital, KE!N EINZELFALL, Ankerliebe. Sie sortiert nach Nähe zu Sarahs Arbeit –
 * zuerst ihre Arbeitgeberin, dann die Werkstatt, die die Fahrzeuge umbaut, und
 * so weiter nach außen. Vorher stand hier die Reihenfolge der Aufnahme, also
 * die Reihenfolge der Tickets.
 *
 * Die SAR-Nummern in den Kommentaren unten und Sätze wie „der dritte
 * aufgenommene Eintrag" beziehen sich weiter auf die Aufnahme und nicht auf
 * die Position in dieser Liste. Wer umsortiert, fasst sie also nicht an.
 *
 * `hint` IST DER SATZ, DER BEIM ÜBERFAHREN DER KACHEL ERSCHEINT (seit dem
 * 21.08.2026, Nils). Er sagt in drei bis vier Wörtern, was der Betrieb mit
 * Sarah zu tun hat, und ist damit die Kurzfassung von `meta`. Zwei Regeln:
 *
 *   · Er steht in SARAHS PERSPEKTIVE („Mein Arbeitgeber", „Hat diese Website
 *     gebaut"), nicht in der Selbstbeschreibung des Betriebs. Die Kachel ist
 *     Sarahs Aussage darüber, wer sie begleitet, kein Werbeplatz.
 *   · Er bleibt kurz genug für eine bis zwei Zeilen. Wer mehr erzählen will,
 *     schreibt es auf die Unterseite – da steht ohnehin der ganze Text.
 *
 * Fehlt das Feld, zeigt die Kachel nur das Logo und verhält sich wie vorher.
 *
 * NEUEN WEGBEGLEITER AUFNEHMEN:
 *   1. Logo nach `public/assets/img/partner/<slug>.webp` (freigestellt, siehe
 *      Hinweis unten), Maße hier eintragen.
 *   2. Eintrag in LIST ergänzen, `hint` nicht vergessen. Der Array-Schlüssel
 *      ist die URL: /wegbegleiter/<slug>.
 *   3. View `app/Views/pages/wegbegleiter/<slug>.php` anlegen.
 * Route und Controller bleiben unangetastet, die gelten für alle.
 *
 * LOGOS GEHÖREN IHREN INHABERN. Sie liegen hier lokal statt als Fremd-Link auf
 * den Server des Partners: Ein Hotlink lädt bei jedem Seitenaufruf von dort,
 * verrät die Besucher:innen dorthin und bricht, sobald der Partner seine Datei
 * umbenennt.
 *
 * Ein fremdes Logo zu zeigen ist eine Nutzung und kein Zitat. Für JEDEN neuen
 * Eintrag gehört sie freigegeben. Für die Fahrschule Sander ist das geklärt
 * (Kevin, 19.08.2026): Sarah arbeitet dort, sie darf das Logo verwenden.
 */
final class Partners
{
    /**
     * @var array<string, array{name:string, url:string, logo:string,
     *      logo_width:int, logo_height:int, meta:string}>
     */
    private const LIST = [
        'fahrschule-sander' => [
            /* Der Name trägt zwei Dinge: die Überschrift der Unterseite und den
               alt-Text des Logos, und damit ist er der NAME DES LINKS auf der
               Startseite, seit die Kachel nur noch das Logo zeigt. Hier standen
               bis zum 19.08.2026 zusätzlich `role` („Meine Fahrschule") und
               `claim` (ein Satz zum Betrieb); beide gingen mit der schlanken
               Kachel und stehen jetzt ausformuliert auf der Unterseite. */
            'name' => 'Fahrschule Sander',
            'hint' => 'Mein Arbeitgeber',
            /* ACHTUNG, DIESE ADRESSE STEHT ZWEIMAL: hier und in der `.env` als
               `SCHOOL_URL`, von wo `school_link()` sie an einem Dutzend
               Stellen der Seite ausgibt. Das ist kein Versehen: Die beiden
               beantworten verschiedene Fragen („wo ist Sarah angestellt" vs.
               „wohin führt diese Kachel") und können auseinandergehen, sobald
               ein Wegbegleiter dazukommt, der nicht ihre Fahrschule ist.
               Ändert sich die Adresse, gehört sie an BEIDEN Stellen geändert. */
            'url'   => 'https://www.fahrschule-sander.de/',
            'logo'  => 'partner/fahrschule-sander.webp',
            /* Echte Maße der Datei. Sie stehen im <img> und halten den Platz
               frei, bevor das Bild da ist. Sonst springt die ganze Reihe beim
               Nachladen. */
            'logo_width'  => 400,
            'logo_height' => 100,
            'meta' => 'Die Fahrschule Sander in Neu Wulmstorf: Sarahs '
                . 'Arbeitgeberin, acht Standorte zwischen Hamburg und Stade. '
                . 'Dort läuft die Anmeldung, bei Sarah die Fahrstunde.',
        ],

        /* SAR-62, aufgenommen am 20.08.2026.
           Der vierte aufgenommene Eintrag und der erste, bei dem die Verbindung
           zu Sarahs Arbeit keine Erklärung braucht: Moooov baut Autos für Menschen mit
           Handicap um. Handbediengeräte, Lenkhilfen, Pedalanpassungen, also
           genau die Technik, die auf /fahren-mit-handicap in den Karten steht.
           Die Werkstatt sitzt in Harsefeld und damit in Sarahs Einzugsgebiet. */
        'moooov' => [
            'name' => 'moooov',
            'hint' => 'Baut Autos für Handicap um',
            'url'  => 'https://moooov-mobility.de/',
            'logo' => 'partner/moooov.webp',
            'logo_width'  => 400,
            'logo_height' => 102,
            /* DIESES LOGO BRAUCHT SEINEN EIGENEN GRUND. Die Wortmarke ist ein
               helles Mintgrün (#77F1A1) und für den dunklen Hintergrund
               gezeichnet, auf dem sie auf der eigenen Seite steht. Auf der
               weißen Kachel käme sie auf 1,4:1 und wäre ein blasser Schemen.

               #1F2B37 ist keine ausgedachte Farbe, sondern die ihrer eigenen
               Navigationsleiste. Darauf steht die Marke bei 10:1, und zwar in
               jedem Kontrastmodus. Umfärben wäre die Alternative gewesen und
               die schlechtere: Ein fremdes Logo umzufärben ändert es. */
            'logo_plate' => '#1F2B37',
            'meta' => 'moooov aus Harsefeld baut Autos für Menschen mit '
                . 'Handicap um: Handbediengeräte, Lenkhilfen, '
                . 'Pedalanpassungen. Dazu ein angepasster Fahrschulwagen.',
        ],

        /* SAR-60, aufgenommen am 20.08.2026.
           Johannes Springer ist Videograf in Lilienthal bei Bremen: Erklär-
           videos, kurze Clips für Social Media, Mehrkamera-Livestreams. */
        'johannes-springer' => [
            'name' => 'Johannes Springer Studio',
            'hint' => 'Video und Livestream',
            'url'  => 'https://johannes-springer.studio/',
            /* DIE BILDMARKE VON DER SEITE, und zwar die einzige, die es dort
               als Datei gibt: ihr Favicon (assets/img/favicon.svg, ein oranger
               Block auf dunklem Grund). Aus dem SVG gerastert, damit sie in der
               Kachel scharf steht.

               EIN WORTMARKEN-LOGO GIBT ES DORT NICHT. „JOHANNES SPRINGER
               STUDIO" ist auf seiner Seite gesetzter Text und keine Bilddatei.
               Nachgebaut wird sie hier nicht: Eine Marke, die es als Datei
               nicht gibt, selbst zu zeichnen hieße, sie zu erfinden. Wer den
               Namen in der Kachel lesbar haben will, holt eine Logodatei bei
               ihm. Bis dahin trägt der alt-Text den Namen.

               KEINE `logo_plate` wie bei moooov und Nils-Digital, obwohl die
               Marke dunkel ist: Sie bringt ihren dunklen Grund selbst mit. Im
               dunklen Kontrastmodus setzt a11y.css die helle Platte darunter,
               und die ist hier genau richtig – ohne sie stünde ein Quadrat in
               #14161C auf einer fast gleich dunklen Kachel. */
            'logo'        => 'partner/johannes-springer.webp',
            'logo_width'  => 256,
            'logo_height' => 256,
            'meta' => 'Johannes Springer Studio aus Lilienthal bei Bremen: '
                . 'Videos, kurze Clips für Social Media und '
                . 'Mehrkamera-Livestreams von Veranstaltungen.',
        ],

        /* SAR-61, aufgenommen am 20.08.2026.
           Nils-Digital hat diese Website gebaut. Damit schließt sich ein
           Kreis: Der Kommentar in layout.php nennt das Credit-Band der Agentur
           (partials/nd-credit.php) ausdrücklich „die Vorlage für das, was Sarah
           später als Wegbegleiter genannt hat". Aus dem Werbeband ist eine
           Kachel geworden, die aussieht wie alle anderen.

           DREIMAL AM SEITENENDE, das gehört gesehen: Die Agentur steht jetzt
           als Kachel, im Streifen unter dem Fuß (partials/nd-banner.php) und
           im Impressum. Keine davon ist falsch, aber wenn eine zu viel ist,
           ist es der Streifen; die Kachel sagt dasselbe und ordnet sich ein. */
        'nils-digital' => [
            'name' => 'Nils-Digital',
            'hint' => 'Hat diese Website gebaut',
            'url'  => 'https://nils-digital.de/',
            'logo' => 'partner/nils-digital.webp',
            /* Die Bildmarke aus `img/nils-digital-logo.png`, freigestellt und
               auf ihren Inhalt beschnitten. Die Originaldatei bleibt, wo sie
               ist: Der Streifen unter dem Fuß benutzt sie weiter. */
            'logo_width'  => 300,
            'logo_height' => 213,
            /* Wie bei moooov, aus demselben Grund und mit derselben Mechanik:
               Das Türkis der Marke kommt auf Weiß nur auf 2,9:1. #111827 ist
               die Farbe ihres eigenen Seitenkopfs, dort steht sie bei 6,1:1. */
            'logo_plate' => '#111827',
            'meta' => 'Nils-Digital aus Ibbenbüren hat diese Website gebaut. '
                . 'Nils Nehring macht Webentwicklung, Apps und '
                . 'KI-Automatisierung für kleine Betriebe und Selbstständige.',
        ],

        /* SAR-63, aufgenommen am 20.08.2026.
           Ein gemeinnütziger Verein und damit der dritte aufgenommene Eintrag,
           der wieder etwas ganz anderes ist als die beiden davor. KE!N EINZELFALL e.V.
           hilft Menschen, die von schädigenden Taten betroffen sind.

           WARUM DER HIER STEHT, in einem Satz: Der Verein berät unter anderem
           zu Schwerbehindertenausweis und Pflegegrad. Das ist der Papierkram,
           der bei Sarahs Leuten oft vor der ersten Fahrstunde liegt.

           WIE BEI ANKERLIEBE GEHÖREN ZWEI PUNKTE VON SARAH BESTÄTIGT: die
           Freigabe für Logo und Namen, und der Satz auf der Unterseite, der
           die Verbindung herstellt. Beides steht in der README. */
        'kein-einzelfall' => [
            'name' => 'KE!N EINZELFALL e.V.',
            'hint' => 'Opferhilfe und Beratung',
            'url'  => 'https://kein-einzelfall.de/',
            'logo' => 'partner/kein-einzelfall.webp',
            /* QUADRATISCH, und das ist der erste Fall dieser Art. Die Logo-
               Reihe gibt allen dieselbe HÖHE und lässt die Breite laufen; das
               stimmt für Wortmarken, staucht eine quadratische Marke aber auf
               46 × 46 px neben 241 px breite Nachbarn. Wie die Reihe damit
               umgeht, steht bei `.partner-logo--block` in nd-base.css.

               Die Datei ist auf ihrer Seite ein JPEG auf weißem Grund und
               512 px groß. Hier freigestellt (sonst weißer Kasten auf der
               Platte im dunklen Kontrastmodus) und auf 256 px gebracht, das
               reicht für die doppelte Anzeigegröße. */
            'logo_width'  => 256,
            'logo_height' => 256,
            'meta' => 'KE!N EINZELFALL e.V. aus Hamburg: Opferhilfe, '
                . 'kostenfreie Selbsthilfegruppen und Beratung zu '
                . 'Entschädigungsrecht, Schwerbehindertenausweis und Pflegegrad.',
        ],

        /* SAR-64, aufgenommen am 20.08.2026.
           Der zweite aufgenommene Wegbegleiter, und der erste, der keine
           Fahrschule ist.
           Ricarda Belmar vermietet auf St. Pauli möblierte Apartments; wer
           von weiter weg zum Fahren nach Hamburg kommt, schläft irgendwo.
           Genau dafür steht der Eintrag hier.

           ZWEI PUNKTE GEHÖREN VON SARAH BESTÄTIGT, bevor die Seite live geht:
           die Freigabe für Logo und Namen (siehe Hinweis oben, sie gilt für
           jeden Eintrag neu), und der Satz auf der Unterseite, der sagt, wie
           die beiden zusammenhängen. Der steht dort als einzige Stelle, die
           eine Aussage über die Zusammenarbeit macht, und ist bewusst so
           gebaut, dass er in einer Zeile ausgetauscht werden kann. */
        'ankerliebe-stpauli' => [
            'name' => 'Ankerliebe St. Pauli',
            'hint' => 'Apartments in Hamburg',
            'url'  => 'https://ankerliebe-stpauli.de/',
            'logo' => 'partner/ankerliebe-stpauli.webp',
            /* Aus dem Kopf der Website geholt und freigestellt: Die Datei dort
               ist ein PNG auf weißem Grund. Auf der Kachel fiele das nicht
               auf, die ist selbst weiß, aber im dunklen Kontrastmodus stünde
               ein weißer Kasten auf der cremefarbenen Platte, die a11y.css
               unter jedes Partnerlogo legt. */
            'logo_width'  => 382,
            'logo_height' => 73,
            'meta' => 'Ankerliebe St. Pauli: möblierte Apartments in der '
                . 'Erichstraße, ein paar Schritte von der Reeperbahn. Ein Bett '
                . 'für alle, die zum Fahren nach Hamburg kommen.',
        ],
    ];

    /**
     * Braucht dieses Logo mehr Höhe als eine Wortmarke?
     *
     * Die Reihe gibt allen Logos dieselbe Höhe. Das ist für Wortmarken
     * gedacht, die breiter als hoch sind. Eine quadratische oder gar hohe
     * Marke steht bei derselben Höhe deutlich kleiner da als ihre Nachbarn,
     * weil sie viel weniger Fläche bekommt.
     *
     * Die Grenze liegt bei 2,2 und ist ein gerundeter Erfahrungswert, kein
     * Naturgesetz: Die beiden Wortmarken hier liegen bei 4,0 und 5,2, das
     * Vereinslogo bei 1,0. Dazwischen ist viel Luft. Wer eine Marke aufnimmt,
     * die knapp daneben liegt, schaut sich die Reihe an und verschiebt im
     * Zweifel die Zahl, statt die Datei zu verzerren.
     */
    public static function hasBlockLogo(array $partner): bool
    {
        $height = max(1, (int) ($partner['logo_height'] ?? 1));

        return (int) ($partner['logo_width'] ?? 0) / $height < 2.2;
    }

    /**
     * Die Plattenfarbe hinter einem Logo, oder null.
     *
     * Nur für Marken, die auf hellem Grund nicht lesbar sind, weil sie für
     * einen dunklen gezeichnet wurden. Die Farbe gehört dann dem Partner und
     * ist von seiner eigenen Seite abgelesen, nicht ausgesucht.
     *
     * Die Prüfung auf eine echte Hex-Farbe ist kein Selbstzweck: Der Wert
     * landet unten als Inline-Style im Markup. Er kommt zwar aus der Liste
     * oben und damit aus dieser Datei, aber ein Tippfehler soll ein Logo ohne
     * Platte ergeben und keinen kaputten style-Block.
     */
    public static function logoPlate(array $partner): ?string
    {
        $value = (string) ($partner['logo_plate'] ?? '');

        return preg_match('/^#[0-9A-Fa-f]{6}$/', $value) === 1 ? $value : null;
    }

    /** Die CSS-Klassen für ein Logo, samt Zusätzen für Form und Platte. */
    public static function logoClass(array $partner, string $base): string
    {
        $classes = [$base];

        if (self::hasBlockLogo($partner)) {
            $classes[] = $base . '--block';
        }
        if (self::logoPlate($partner) !== null) {
            $classes[] = $base . '--plate';
        }

        return implode(' ', $classes);
    }

    /**
     * Das style-Attribut für ein Logo mit Platte, sonst ein leerer String.
     *
     * Die Farbe steht als Custom Property im Markup und nicht als fertige
     * `background`-Regel: So bleibt das Aussehen der Platte (Rundung,
     * Polsterung) in nd-base.css, und aus den Daten kommt nur der eine Wert,
     * der von Partner zu Partner verschieden ist.
     */
    public static function logoPlateAttr(array $partner): string
    {
        $plate = self::logoPlate($partner);

        return $plate === null ? '' : ' style="--logo-plate: ' . $plate . '"';
    }

    /** Alle Wegbegleiter in der Reihenfolge, in der sie hier stehen. */
    public static function all(): array
    {
        return self::LIST;
    }

    /**
     * Ein Wegbegleiter über seinen Slug, oder null.
     *
     * Der Slug kommt aus der URL. Weil hier ein Array-SCHLÜSSEL nachgeschlagen
     * wird und nicht ein Pfad zusammengebaut, kann von außen nichts anderes
     * herauskommen als einer der Einträge oben. Der Controller baut daraus
     * einen Dateinamen, und dass das ungefährlich ist, hängt an genau dieser
     * Zeile. Wer hier auf „Datei suchen" umbaut, öffnet ein Scheunentor.
     */
    public static function find(string $slug): ?array
    {
        return self::LIST[$slug] ?? null;
    }

    /** Die interne Adresse der Unterseite eines Wegbegleiters. */
    public static function path(string $slug): string
    {
        return url('/wegbegleiter/' . $slug);
    }
}
