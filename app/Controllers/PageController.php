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
            'metaDescription' => 'Sarah ist angestellte Fahrlehrerin für die Klassen B und BE '
                . 'in ' . implode(', ', config('contact.area')) . ' – mit Schwerpunkt auf der '
                . 'Ausbildung von Menschen mit Handicap.',
        ]);
    }

    public function handicap(): void
    {
        render('pages/handicap', [
            'title'           => 'Fahren mit Handicap',
            'metaDescription' => 'Führerschein mit Prothese, Lenkhilfe oder Handbedienung: '
                . 'Wie die Ausbildung im angepassten Fahrzeug abläuft und was du dafür brauchst.',
        ]);
    }

    public function contact(): void
    {
        render('pages/kontakt', [
            'title'           => 'Kontakt',
            'metaDescription' => 'So erreichst du Sarah – Telefon, E-Mail, TikTok und Instagram.',
        ]);
    }

    /**
     * Referenzseite: Sarah erzählt, wer ihre Website erstellt hat.
     * Bewusst in ihrer Stimme und nicht als Werbetext von Nils-Digital –
     * eine Kopie von nils-digital.de wäre für beide Seiten schlechter
     * (doppelte Inhalte, und eine Empfehlung wirkt nur aus ihrem Mund).
     */
    public function website(): void
    {
        render('pages/meine-website', [
            'title'           => 'Wer diese Seite erstellt hat',
            'metaDescription' => 'Warum Sarah eine eigene Website wollte und wer sie '
                . 'umgesetzt hat – eine Referenz für Nils-Digital.',
            // Kein Credit-Band: die ganze Seite ist bereits der Credit
            'showNdCredit'    => false,
        ]);
    }

    public function impressum(): void
    {
        render('pages/impressum', ['title' => 'Impressum']);
    }

    public function datenschutz(): void
    {
        render('pages/datenschutz', ['title' => 'Datenschutz']);
    }
}
