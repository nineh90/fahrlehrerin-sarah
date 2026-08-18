<?php
/**
 * KOPFTEIL DER BARRIEREFREIHEITS-LEISTE (SAR-34).
 *
 * Eingebunden von ALLEN drei Layouts – Frontend, Adminbereich und
 * Admin-Login. Sarah ist die Einzige, die den Adminbereich benutzt, und sie
 * ist gleichzeitig die, die diese Einstellungen am ehesten braucht. Hätte
 * nur das Frontend das Skript, würde ihr Dunkelmodus beim Wechsel in die
 * Schaltzentrale abfallen – und genau das ist die Art Inkonsequenz, die
 * solche Einstellungen unbrauchbar macht.
 */
?>
<?php /* Zuletzt von den Stilvorlagen, weil a11y.css die Farb-Tokens aus
         theme.css umdefiniert. */ ?>
<link rel="stylesheet" href="<?= asset('css/a11y.css') ?>">

<?php /* DARSTELLUNGS-EINSTELLUNGEN, ANGEWENDET VOR DEM ERSTEN ZEICHNEN.
         Dieses Skript steht bewusst INLINE und im <head> und nicht unten bei
         den anderen: Eine gespeicherte Einstellung muss stehen, bevor der
         Browser das erste Pixel malt. Läge es unten oder in einer externen
         Datei, blitzte bei jedem Seitenaufruf kurz die helle Standardansicht
         auf – für jemanden, der den hohen Kontrast braucht, ist das kein
         Schönheitsfehler, sondern genau das, was er vermeiden will.

         Die Tabelle „Wert -> Wirkung auf <html>" kommt aus
         app/darstellung.php und wird hier als JSON eingesetzt. Damit lesen
         dieses Skript und a11y.js aus derselben Quelle; zweimal
         hingeschrieben würden sie auseinanderlaufen.

         Angefasst wird ausschließlich <html>. Dadurch wirkt jede Einstellung
         automatisch auch auf Bausteine, die es heute noch nicht gibt. */ ?>
<?php $darstellung = require APP_ROOT . '/app/darstellung.php'; ?>
<script>
window.sarahDarstellung = (function () {
    var REGELN = <?= json_encode($darstellung['anwendung'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    var SCHLUESSEL = <?= json_encode($darstellung['speicher'], JSON_THROW_ON_ERROR) ?>;

    function lesen() {
        try {
            return JSON.parse(localStorage.getItem(SCHLUESSEL)) || {};
        } catch (e) {
            return {};   /* defekte Daten dürfen die Seite nicht mitreißen */
        }
    }

    function speichern(werte) {
        try {
            localStorage.setItem(SCHLUESSEL, JSON.stringify(werte));
        } catch (e) {
            /* Privater Modus o.ä. – dann gilt die Einstellung eben nur für
               diese Sitzung. Kein Grund, irgendetwas abzubrechen. */
        }
    }

    function anwenden(werte) {
        var el = document.documentElement, name, regel;
        for (name in REGELN.variablen) {
            regel = REGELN.variablen[name];
            el.style.setProperty(regel[0], regel[1][werte[name] || 0]);
        }
        REGELN.datensaetze.forEach(function (n) {
            if (werte[n]) { el.dataset[n] = werte[n]; } else { delete el.dataset[n]; }
        });
        REGELN.klassen.forEach(function (n) {
            el.classList.toggle('a11y-' + n, !!werte[n]);
        });
    }

    anwenden(lesen());

    return { lesen: lesen, speichern: speichern, anwenden: anwenden };
})();
</script>

