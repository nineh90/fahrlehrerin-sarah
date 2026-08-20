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
 * NEUEN WEGBEGLEITER AUFNEHMEN:
 *   1. Logo nach `public/assets/img/partner/<slug>.webp` (freigestellt, siehe
 *      Hinweis unten), Maße hier eintragen.
 *   2. Eintrag in LIST ergänzen. Der Array-Schlüssel ist die URL:
 *      /wegbegleiter/<slug>.
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

        /* SAR-64, aufgenommen am 20.08.2026.
           Der zweite Wegbegleiter, und der erste, der keine Fahrschule ist.
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

        /* SAR-63, aufgenommen am 20.08.2026.
           Ein gemeinnütziger Verein und damit der dritte Eintrag, der wieder
           etwas ganz anderes ist als die beiden davor. KE!N EINZELFALL e.V.
           hilft Menschen, die von schädigenden Taten betroffen sind.

           WARUM DER HIER STEHT, in einem Satz: Der Verein berät unter anderem
           zu Schwerbehindertenausweis und Pflegegrad. Das ist der Papierkram,
           der bei Sarahs Leuten oft vor der ersten Fahrstunde liegt.

           WIE BEI ANKERLIEBE GEHÖREN ZWEI PUNKTE VON SARAH BESTÄTIGT: die
           Freigabe für Logo und Namen, und der Satz auf der Unterseite, der
           die Verbindung herstellt. Beides steht in der README. */
        'kein-einzelfall' => [
            'name' => 'KE!N EINZELFALL e.V.',
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

    /** Die CSS-Klassen für ein Logo, samt Zusatz für blockige Marken. */
    public static function logoClass(array $partner, string $base): string
    {
        return self::hasBlockLogo($partner) ? $base . ' ' . $base . '--block' : $base;
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
