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
                . 'in ' . area_list() . ' – Heilerziehungspflegerin mit '
                . 'Schwerpunkt Handicap.',
            /* Ihre Person, auf der Seite, die von ihr handelt. */
            'jsonLd'          => Seo::person(),
        ]);
    }

    public function handicap(): void
    {
        render('pages/handicap', [
            'title'           => 'Fahren mit Handicap',
            /* Der Titel weicht bewusst von der Überschrift ab: Auf der Seite
               steht „Fahren mit Handicap", gesucht wird nach „Führerschein".
               Beides darf verschieden sein – die Überschrift spricht die an,
               die schon da sind, der Titel die, die noch suchen. */
            'metaTitle'       => 'Führerschein mit Handicap – so läuft die Ausbildung ab',
            /* DIE EINZIGE STELLE, AN DER DIESE SEITE EINEN ORT NENNT. Nachgemessen
               am 20.08.2026: Im sichtbaren Text der Seite steht kein einziger
               Ortsname – 531 Wörter über Handbedienung und Lenkhilfe, aber
               „Führerschein mit Handicap" und „Hamburg" kommen nie zusammen vor.
               Die Beschreibung ist dafür nur das Pflaster: Sie ist KEIN
               Rankingfaktor und entscheidet nur über den Klick, wenn der
               Treffer schon da ist. Der eigentliche Satz fehlt im Text der
               Seite und wartet auf Sarahs Durchgang (eigenes Ticket). */
            'metaDescription' => 'Führerschein mit Handicap in ' . area_list()
                . ': Handbedienung, Lenkhilfe, Pedalverlängerung – und was du '
                . 'dafür brauchst.',
        ]);
    }

    public function contact(): void
    {
        render('pages/kontakt', [
            'title'           => 'Kontakt',
            /* Die alte Fassung nannte nur die Kanäle. Eine Kontaktseite ist der
               Treffer für „Fahrlehrerin + Ort + Kontakt" – dann darf in der
               Vorschau auch stehen, um wen es geht und wo. */
            'metaDescription' => 'So erreichst du Sarah – Fahrlehrerin in '
                . area_list() . '. Telefon, E-Mail, TikTok und Instagram.',
        ]);
    }

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
