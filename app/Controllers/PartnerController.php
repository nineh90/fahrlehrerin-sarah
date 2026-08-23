<?php
declare(strict_types=1);

/**
 * Die Unterseiten der Wegbegleiter: /wegbegleiter/<slug>.
 *
 * Eine Route für alle. Die Stammdaten kommen aus `Partners`, der Text aus
 * einer View mit demselben Namen wie der Slug. Wer einen Wegbegleiter
 * aufnimmt, fasst diesen Controller nicht an (Anleitung in app/Partners.php).
 *
 * Bewusst KEINE Übersichtsseite unter /wegbegleiter: Die Übersicht ist der
 * Abschnitt unten auf der Startseite. Eine zweite Seite mit denselben zwei
 * Kacheln wäre ein Klick ins Leere.
 */
final class PartnerController
{
    public function show(string $slug): void
    {
        $partner = Partners::find($slug);

        /* Zwei Bedingungen, und beide müssen sein: Der Eintrag entscheidet, ob
           es den Wegbegleiter gibt, und erst dadurch ist der Slug ein bekannter
           Wert und der Dateiname unten harmlos. Die Dateiprüfung fängt den
           Fall ab, dass jemand den Eintrag anlegt und die View vergisst; ohne
           sie wäre das ein Serverfehler statt einer 404. */
        $view = 'pages/wegbegleiter/' . $slug;
        if ($partner === null || !is_file(APP_ROOT . '/app/Views/' . $view . '.php')) {
            http_response_code(404);
            render('errors/404', ['title' => 'Seite nicht gefunden', 'noindex' => true]);
            return;
        }

        render($view, [
            'title'           => $partner['name'],
            'metaDescription' => $partner['meta'],
            'partner'         => $partner,
            /* Die Unterseite handelt vom Wegbegleiter, also steht hier dessen
               Markup und nicht Sarahs (SAR-10). Ein Person-Block über Sarah
               auf der Seite eines fremden Betriebs würde die beiden
               zusammenziehen – genau das, was die Seite nicht behaupten soll. */
            'jsonLd'          => Seo::partner($partner),
            /* Hier stand bis zum 22.08.2026 `'showSiteNote' => false`: die
               Ausnahme für die Wegbegleiter-Unterseiten, auf denen Sarahs
               Fußnote unter fremdem Logo stand. Die Fußnote selbst ist an dem
               Tag von allen Seiten entfallen, damit auch ihr Schalter – ein
               Flag ohne Wirkung ist eine Falle. Begründung im Layout. */
        ]);
    }
}
