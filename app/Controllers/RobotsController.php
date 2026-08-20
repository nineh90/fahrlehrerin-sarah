<?php
declare(strict_types=1);

/**
 * /robots.txt – bewusst als Route und nicht als Datei in public/.
 *
 * Eine statische Datei würde immer dasselbe sagen. Hier hängt der Inhalt an
 * `ALLOW_INDEXING`, damit Testbetrieb und Livegang mit derselben Zeile in der
 * .env umgeschaltet werden wie das robots-Meta im Layout. Beides muss
 * zusammenpassen: Ein "noindex" im Meta nützt nichts, wenn die robots.txt
 * das Crawlen erlaubt und umgekehrt.
 *
 * Wichtig: Wer hier später doch eine statische public/robots.txt anlegt,
 * hebelt diese Route aus – die .htaccess liefert vorhandene Dateien direkt aus.
 */
final class RobotsController
{
    public function index(): void
    {
        header('Content-Type: text/plain; charset=utf-8');

        if (!config('allow_indexing')) {
            // Alles zu. Der Kommentar steht drin, damit klar ist, dass das
            // Absicht ist und kein vergessener Testzustand.
            echo "# Diese Seite ist noch nicht offiziell live.\n";
            echo "User-agent: *\n";
            echo "Disallow: /\n";
            return;
        }

        echo "User-agent: *\n";
        // Der Adminbereich und die persönlichen Seiten der Fahrschüler:innen
        // gehören auch im Livebetrieb in keinen Index.
        //
        // WICHTIG: Ein Disallow hier ist KEIN noindex. Eine gesperrte Adresse
        // kann trotzdem im Index landen – ohne Beschreibung, weil Google sie
        // ja nicht lesen durfte, aber mit ihrer URL. Das eigentliche noindex
        // dieser Seiten steht deshalb im Layout (SAR-10, $noindex); die
        // beiden Sperren ergänzen sich und ersetzen sich nicht.
        echo "Disallow: /admin\n";
        echo "Disallow: /meine-termine\n";
        echo "Disallow: /buchung\n";
        echo "Disallow: /login\n";
        echo "\n";
        // Wo die Liste der Seiten steht, die in den Index sollen. Ersetzt seit
        // SAR-10 die Zeile `Host:` – die stammt von Yandex, ist nie ein
        // Standard gewesen und wird von Google schlicht überlesen.
        echo 'Sitemap: ' . absolute_url('/sitemap.xml') . "\n";
    }
}
