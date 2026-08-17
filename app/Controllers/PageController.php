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
        render('pages/ueber-mich', [
            'title'           => 'Über mich',
            // „Heilerziehungspflegerin" steht hier, seit Sarahs eigener Text auf der
            // Seite ist: Die Ausbildung ist der Grund, warum sie diesen Schwerpunkt
            // hat, und in der Suche unterscheidet sie sie von jeder anderen Fahrschule.
            'metaDescription' => 'Sarah ist angestellte Fahrlehrerin für die Klassen B und BE '
                . 'in ' . implode(', ', config('contact.area')) . ' – ausgebildete '
                . 'Heilerziehungspflegerin mit Schwerpunkt auf der Ausbildung von '
                . 'Menschen mit Handicap.',
        ]);
    }

    public function handicap(): void
    {
        render('pages/handicap', [
            'title'           => 'Fahren mit Handicap',
            /* Siehe HomeController: dieselbe Aufzählung, dieselbe Begründung (SAR-43). */
            'metaDescription' => 'Führerschein mit Kleinwuchs, Prothese, Lenkhilfe oder '
                . 'Handbedienung: Wie die Ausbildung im angepassten Fahrzeug abläuft und '
                . 'was du dafür brauchst.',
        ]);
    }

    public function contact(): void
    {
        render('pages/kontakt', [
            'title'           => 'Kontakt',
            'metaDescription' => 'So erreichst du Sarah – Telefon, E-Mail, TikTok und Instagram.',
        ]);
    }

    /* Hier lag bis zum 17.08.2026 `website()` für /meine-website – die
       Referenzseite „Wer diese Seite erstellt hat", auf der Sarah in eigenen
       Worten erzählte, wie die Website entstanden ist. Auf Wunsch entfallen,
       samt Route, View und den drei Links darauf (Fuß, ND-Streifen,
       nd-credit.php). Der Hinweis auf Nils-Digital bleibt: Der Streifen unter
       dem Fuß führt weiterhin nach nils-digital.de. */

    public function impressum(): void
    {
        render('pages/impressum', ['title' => 'Impressum']);
    }

    public function datenschutz(): void
    {
        render('pages/datenschutz', ['title' => 'Datenschutz']);
    }
}
