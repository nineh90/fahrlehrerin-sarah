/* Bedienung der Barrierefreiheits-Leiste (SAR-34).
 *
 * Übernommen aus dem Schwesterprojekt „Kein Einzelfall" (resources/js/a11y.js
 * dort) und auf diese Seite übertragen: kein Bundler, kein Import, ein IIFE wie
 * main.js daneben.
 *
 * DAS PANEL KOMMT FERTIG AUS PHP (app/darstellung.php, gerendert in
 * partials/a11y-toolbar.php) – hier wird nur verdrahtet. Gearbeitet wird
 * ausschließlich über data-Attribute und echte Event-Listener, nie über
 * Ausdrücke in HTML-Attributen.
 *
 * Lesen, Speichern und Anwenden liegen NICHT hier, sondern in
 * window.sarahDarstellung. Das stellt ein kurzes Inline-Skript im <head>
 * bereit, damit gespeicherte Einstellungen schon vor dem ersten Zeichnen
 * greifen – sonst blitzt bei jedem Seitenaufruf die Standardansicht auf. Für
 * jemanden, der den hohen Kontrast braucht, ist das kein Schönheitsfehler.
 */
(function () {
    'use strict';

    var knopf = document.querySelector('[data-a11y-oeffnen]');
    var panel = document.getElementById('a11y-panel');
    var api = window.sarahDarstellung;

    /* Die Leselinie hängt unabhängig vom Panel: Das Element ist immer da, per
       CSS nur sichtbar, wenn die Option gesetzt ist. Deshalb steht sie vor dem
       Ausstieg unten – sie soll auch funktionieren, wenn das Panel fehlt. */
    var linie = document.getElementById('leselinie');
    if (linie) {
        document.addEventListener('mousemove', function (e) {
            linie.style.top = e.clientY + 'px';
        });
    }

    if (!knopf || !panel || !api) return;

    var werte = api.lesen();

    // --- Öffnen und Schließen ---------------------------------------------

    var zeigen = function (offen) {
        panel.hidden = !offen;
        knopf.setAttribute('aria-expanded', offen ? 'true' : 'false');
    };

    knopf.addEventListener('click', function () { zeigen(panel.hidden); });

    var zu = panel.querySelector('[data-a11y-schliessen]');
    if (zu) {
        zu.addEventListener('click', function () { zeigen(false); knopf.focus(); });
    }

    /* Klick daneben schließt. Der Knopf selbst ist ausgenommen – sonst würde
       sein eigener Klick das gerade geöffnete Panel sofort wieder zumachen. */
    document.addEventListener('click', function (e) {
        if (!panel.hidden && !panel.contains(e.target) && !knopf.contains(e.target)) {
            zeigen(false);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !panel.hidden) { zeigen(false); knopf.focus(); }
    });

    // --- Einstellungen ----------------------------------------------------

    /** Den Stand in die Bedienelemente zurückschreiben. */
    var spiegeln = function () {
        var i, el, liste;

        liste = panel.querySelectorAll('[data-a11y-setzen]');
        for (i = 0; i < liste.length; i++) {
            el = liste[i];
            var schluessel = el.getAttribute('data-a11y-setzen');
            var zahl = el.hasAttribute('data-a11y-zahl');
            var aktuell = werte[schluessel];
            if (aktuell === undefined || aktuell === null) aktuell = zahl ? 0 : '';
            el.setAttribute('aria-pressed',
                String(aktuell) === el.getAttribute('data-a11y-wert') ? 'true' : 'false');
        }

        liste = panel.querySelectorAll('[data-a11y-umschalten]');
        for (i = 0; i < liste.length; i++) {
            el = liste[i];
            el.setAttribute('aria-pressed',
                werte[el.getAttribute('data-a11y-umschalten')] ? 'true' : 'false');
        }

        var zaehler = document.querySelector('[data-a11y-zaehler]');
        if (zaehler) {
            /* Gezählt wird, was vom Standard abweicht. Die Stufen liefern 0 für
               „Standard" und der Kontrast einen leeren Text – beides ist falsy
               und zählt damit von selbst nicht mit. */
            var anzahl = 0;
            for (var k in werte) { if (werte[k]) anzahl++; }
            zaehler.textContent = String(anzahl);
            zaehler.hidden = anzahl < 1;
        }
    };

    var uebernehmen = function () {
        api.anwenden(werte);
        api.speichern(werte);
        spiegeln();
    };

    panel.addEventListener('click', function (e) {
        var setzen = e.target.closest('[data-a11y-setzen]');
        if (setzen) {
            var roh = setzen.getAttribute('data-a11y-wert');
            werte[setzen.getAttribute('data-a11y-setzen')] =
                setzen.hasAttribute('data-a11y-zahl') ? Number(roh) : roh;
            uebernehmen();
            return;
        }

        var um = e.target.closest('[data-a11y-umschalten]');
        if (um) {
            var s = um.getAttribute('data-a11y-umschalten');
            werte[s] = !werte[s];
            uebernehmen();
            return;
        }

        if (e.target.closest('[data-a11y-zuruecksetzen]')) {
            werte = {};
            uebernehmen();
        }
    });

    spiegeln();
})();
