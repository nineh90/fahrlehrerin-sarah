<?php
declare(strict_types=1);

/**
 * Statische Info-Seiten.
 *
 * Bewusst KEINE Preisseite: Sarah ist angestellte Fahrlehrerin, Anmeldung und
 * Preise laufen über ihre Fahrschule. Eine Preisliste auf dieser Seite würde
 * den Eindruck erwecken, sie verkaufe eigene Leistungen.
 */
final class PageController
{
    public function about(): void
    {
        /* Die Fahrschule gehört in den Titel dieser Seite – sie ist die
           Antwort auf „bei wem fährt man denn dann?" (SAR-10). Bleibt
           SCHOOL_NAME leer, verschwindet sie hier genauso wie überall sonst,
           und der Titel fällt auf die kurze Fassung zurück. */
        $schule = (string) config('school.name', '');

        render('pages/ueber-mich', [
            'title'           => 'Über mich',
            'metaTitle'       => $schule !== ''
                ? 'Über mich – Fahrlehrerin bei der ' . $schule
                : 'Über mich – Fahrlehrerin Sarah, Klasse B und BE',
            // „Heilerziehungspflegerin" steht hier, seit Sarahs eigener Text auf der
            // Seite ist: Die Ausbildung ist der Grund, warum sie diesen Schwerpunkt
            // hat, und in der Suche unterscheidet sie sie von jeder anderen Fahrschule.
            'metaDescription' => 'Sarah, angestellte Fahrlehrerin für Klasse B und BE '
                . 'in ' . area_sentence() . ' – Heilerziehungspflegerin mit '
                . 'Schwerpunkt Handicap.',
            /* Ihre Person, auf der Seite, die von ihr handelt. */
            'jsonLd'          => Seo::person(),
        ]);
    }

    public function handicap(): void
    {
        render('pages/handicap', [
            'title'           => 'Fahren mit körperlichem Handicap',
            /* Der Titel weicht bewusst von der Überschrift ab: Auf der Seite
               steht „Fahren mit Handicap", gesucht wird nach „Führerschein".
               Beides darf verschieden sein – die Überschrift spricht die an,
               die schon da sind, der Titel die, die noch suchen. */
            'metaTitle'       => 'Führerschein mit Handicap – so läuft die Ausbildung ab',
            /* DIE EINZIGE STELLE, AN DER DIESE SEITE EINEN ORT NENNT. Nachgemessen
               am 20.08.2026 und nach Sarahs Neufassung am 21.08.2026 (SAR-82,
               SAR-83, SAR-84) noch einmal: Im sichtbaren Text der Seite steht
               weiterhin kein einziger Ortsname – inzwischen 889 Wörter statt
               531, aber „Führerschein mit Handicap" und „Hamburg" kommen nie
               zusammen vor.
               Die Beschreibung ist dafür nur das Pflaster: Sie ist KEIN
               Rankingfaktor und entscheidet nur über den Klick, wenn der
               Treffer schon da ist. Der eigentliche Satz fehlt im Text der
               Seite und wartet auf Sarahs Durchgang (eigenes Ticket). */
            'metaDescription' => 'Führerschein mit Handicap in ' . area_sentence()
                . ': Handbedienung, Lenkhilfe, Pedalverlängerung – und was du '
                . 'dafür brauchst.',
        ]);
    }

    /**
     * /neurodivergenz – SAR-65.
     *
     * Der Anlass kam von Sarah selbst: „Ich habe bisher nicht ein Wort über
     * die Menschen mit unsichtbaren Behinderungen gefunden." Genau deshalb
     * ist es eine eigene Seite und kein Abschnitt auf /fahren-mit-handicap –
     * angehängt wäre es weiterhin nicht gefunden, und die beiden Seiten
     * handeln von Verschiedenem: dort von der Technik am Auto und vom Weg
     * über die Behörde, hier davon, wie unterrichtet wird.
     */
    public function neurodivergenz(): void
    {
        render('pages/neurodivergenz', [
            'title'           => 'Fahrschule & Neurodivergenz',
            /* Wie bei der Handicap-Seite: Die Überschrift spricht die an, die
               schon da sind, der Titel die, die noch suchen. Gesucht wird
               nach der Diagnose und nicht nach dem Oberbegriff – „ADHS" und
               „Autismus" stehen deshalb vorn, „Neurodivergenz" kennt nicht
               jede:r, der oder die betroffen ist. */
            'metaTitle'       => 'Führerschein mit ADHS oder Autismus – Fahrschule, die anders lernt',
            'metaDescription' => 'Fahrausbildung für neurodivergente Menschen in '
                . area_sentence() . ': klare Abläufe, einzelne Schritte, '
                . 'Wiederholungen ohne Druck. Diagnose ist keine Voraussetzung.',
        ]);
    }

    /* `contact()` lag bis zum 27.08.2026 hier. Mit dem Kontaktformular
       (SAR-95) nimmt /kontakt auch ein POST entgegen und muss nach einem
       Eingabefehler dieselbe Seite mit den alten Werten neu rendern – das
       gehört zusammen in den ContactController. */

    /* Hier lag bis zum 17.08.2026 `website()` für /meine-website – die
       Referenzseite „Wer diese Seite erstellt hat", auf der Sarah in eigenen
       Worten erzählte, wie die Website entstanden ist. Auf Wunsch entfallen,
       samt Route, View und den drei Links darauf (Fuß, ND-Streifen,
       nd-credit.php). Der Hinweis auf Nils-Digital bleibt: Der Streifen unter
       dem Fuß führt weiterhin nach nils-digital.de. */

    /* Impressum und Datenschutz bleiben INDEXIERBAR. Das ist eine bewusste
       Entscheidung gegen die verbreitete Gewohnheit, beide auf noindex zu
       setzen: Ein Impressum, das man findet, ist ein Vertrauenssignal, und
       gefunden werden soll es auch dann, wenn jemand gezielt danach sucht.
       Sie stehen nur nicht in der Sitemap – dort steht, was beworben wird. */
    public function impressum(): void
    {
        render('pages/impressum', [
            'title'           => 'Impressum',
            'metaDescription' => 'Impressum und Anbieterkennzeichnung der Website '
                . 'von Fahrlehrerin Sarah.',
        ]);
    }

    public function datenschutz(): void
    {
        render('pages/datenschutz', [
            'title'           => 'Datenschutz',
            'metaDescription' => 'Welche Daten diese Website verarbeitet – und '
                . 'welche nicht. Keine Schriften von Google, keine Einbettungen, '
                . 'kein Tracking.',
        ]);
    }
}
