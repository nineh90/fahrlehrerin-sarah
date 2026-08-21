<?php
declare(strict_types=1);

/**
 * /sitemap.xml – SAR-10.
 *
 * Hängt am selben Schalter wie das robots-Meta und /robots.txt:
 * `ALLOW_INDEXING`. Steht der auf false, gibt es hier **404 und keine Liste**.
 * Das ist Absicht und nicht Übervorsicht: Eine Sitemap ist eine Einladung.
 * Sie auszuliefern, während jede Seite darin „noindex" trägt, wäre ein
 * Widerspruch – und sie bliebe abrufbar, wenn jemand die Adresse einmal
 * gesehen hat, auch ohne Verweis in der robots.txt.
 *
 * WAS HIER DRINSTEHT, IST EINE AUSSAGE. Eine Sitemap sagt: „Diese Seiten
 * sollen in den Index." Deshalb stehen hier ausschließlich die Inhaltsseiten
 * – und keine Seite, die anderswo ein „noindex" trägt. Beides gleichzeitig
 * zu behaupten, ist der häufigste Fehler in der Search Console.
 *
 * Nicht dabei und mit Absicht:
 * - /termine, /login, /meine-termine, /buchung/* – Sarahs Werkzeug, nicht ihr
 *   Schaufenster. Die Terminplanung liegt zudem auf Eis (Stand 20.08.2026).
 * - /admin/* – versteht sich.
 * - /impressum, /datenschutz – dürfen gefunden werden, müssen aber nicht
 *   beworben werden. Sie stehen im Fuß jeder Seite und werden darüber
 *   gefunden.
 */
final class SitemapController
{
    /**
     * Die öffentlichen Inhaltsseiten mit ihrer Gewichtung.
     *
     * `priority` ist ein Wunsch an die Suchmaschine und keine Anweisung –
     * Google ignoriert das Feld seit Jahren offiziell. Es steht hier trotzdem,
     * weil es die Rangfolge dokumentiert, in der WIR die Seiten sehen: Die
     * Startseite und der Handicap-Schwerpunkt tragen die Seite.
     */
    private const SEITEN = [
        '/'                    => ['prioritaet' => '1.0', 'frequenz' => 'monthly'],
        '/fahren-mit-handicap' => ['prioritaet' => '0.9', 'frequenz' => 'monthly'],
        /* Dieselbe Gewichtung wie die Handicap-Seite (SAR-65): Die beiden sind
           die zwei Schwerpunkte und stehen im Menü nebeneinander. Eine
           niedrigere Zahl hier hieße, wir hielten die eine für nachrangig. */
        '/neurodivergenz'      => ['prioritaet' => '0.9', 'frequenz' => 'monthly'],
        '/ueber-mich'          => ['prioritaet' => '0.8', 'frequenz' => 'monthly'],
        '/kontakt'             => ['prioritaet' => '0.6', 'frequenz' => 'yearly'],
    ];

    public function index(): void
    {
        if (!config('allow_indexing')) {
            http_response_code(404);
            header('Content-Type: text/plain; charset=utf-8');
            echo "Diese Seite ist noch nicht offiziell live.\n";
            return;
        }

        header('Content-Type: application/xml; charset=utf-8');

        $eintraege = self::SEITEN;

        /* Die Wegbegleiter kommen aus derselben Liste wie die Navigation
           (app/Partners.php). Wer dort einen ergänzt, hat ihn hier
           automatisch mit – eine zweite, handgepflegte Liste würde
           auseinanderlaufen, und zwar unbemerkt. */
        foreach (array_keys(Partners::all()) as $slug) {
            $eintraege['/wegbegleiter/' . $slug] = [
                'prioritaet' => '0.3',
                'frequenz'   => 'yearly',
            ];
        }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($eintraege as $pfad => $angaben) {
            echo "  <url>\n";
            /* htmlspecialchars und nicht e(): In XML müssen & < > " kodiert
               sein, sonst ist das Dokument ungültig und die Search Console
               lehnt die ganze Datei ab, nicht nur die eine Zeile. */
            echo '    <loc>' . htmlspecialchars(absolute_url($pfad), ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
            echo '    <changefreq>' . $angaben['frequenz'] . "</changefreq>\n";
            echo '    <priority>' . $angaben['prioritaet'] . "</priority>\n";
            echo "  </url>\n";
        }

        echo '</urlset>' . "\n";
    }
}
