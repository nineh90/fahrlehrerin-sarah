/* Fahrlehrerin Sarah – Frontend-Interaktion (kein Framework) */
(function () {
    'use strict';

    // Steht ganz oben, weil die Überschrift bis dahin per CSS unsichtbar ist
    // (siehe [data-typewriter] in nd-base.css). Was auch immer weiter unten
    // schiefgehen könnte – sichtbar ist sie danach auf jeden Fall.
    initTypewriter();

    /* Header schrumpfen lassen, sobald man scrollt: Oben trägt er Sarahs
       volles Logo, das unter der Leiste hervorsteht, danach die kompakte
       Marke. Aussehen und Maße stehen im CSS (.site-header.is-compact),
       hier steht nur, WANN umgeschaltet wird.

       Die beiden Schwellen sind mit Absicht verschieden (48 hinunter, 12
       hinauf). Bei einem einzelnen Wert flackert der Header, sobald jemand
       genau auf der Grenze stehen bleibt – das Umschalten ändert die Höhe,
       und auf einem Trackpad reicht die kleinste Bewegung, um die Grenze
       wieder zu kreuzen. Der Abstand dazwischen macht daraus eine klare
       Entscheidung.

       Gelesen wird nur in requestAnimationFrame: scrollY im Scroll-Ereignis
       selbst abzufragen zwingt den Browser zur Layout-Neuberechnung, und das
       bei jedem einzelnen Tick. */
    var header = document.querySelector('.site-header');
    if (header) {
        var kompakt = false;
        var wartet = false;

        var pruefe = function () {
            wartet = false;
            var y = window.scrollY || document.documentElement.scrollTop;
            if (!kompakt && y > 48) {
                kompakt = true;
                header.classList.add('is-compact');
            } else if (kompakt && y < 12) {
                kompakt = false;
                header.classList.remove('is-compact');
            }
        };

        window.addEventListener('scroll', function () {
            if (wartet) return;
            wartet = true;
            window.requestAnimationFrame(pruefe);
        }, { passive: true });

        // Wer die Seite mitten im Dokument neu lädt (oder mit einem Anker
        // kommt), startet sonst mit der großen Marke über dem Fließtext.
        // Dreimal, weil der Zustand auf drei Wegen falsch werden kann:
        // jetzt sofort; nach `load`, weil der Browser die alte Scrollposition
        // erst danach wiederherstellt; und beim Zurückwechseln auf den Tab,
        // weil im Hintergrund weder requestAnimationFrame noch Scroll-
        // Ereignisse zuverlässig laufen.
        pruefe();
        window.addEventListener('load', pruefe);
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) pruefe();
        });
    }

    // Mobile-Navigation umschalten
    var toggle = document.querySelector('.nav-toggle');
    var nav = document.querySelector('.main-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
        });
    }

    // Admin-Navigation: Hamburger-Drawer (mobil)
    var adminToggle = document.querySelector('.admin-nav-toggle');
    var adminSidebar = document.getElementById('adminSidebar');
    var adminBackdrop = document.querySelector('.admin-backdrop');
    if (adminToggle && adminSidebar) {
        var setAdminNav = function (open) {
            adminSidebar.classList.toggle('is-open', open);
            adminToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            adminToggle.setAttribute('aria-label', open ? 'Menü schließen' : 'Menü öffnen');
            if (adminBackdrop) adminBackdrop.hidden = !open;
            document.body.classList.toggle('admin-nav-open', open);
        };
        adminToggle.addEventListener('click', function () {
            setAdminNav(!adminSidebar.classList.contains('is-open'));
        });
        if (adminBackdrop) {
            adminBackdrop.addEventListener('click', function () { setAdminNav(false); });
        }
        adminSidebar.querySelectorAll('a, button').forEach(function (el) {
            el.addEventListener('click', function () { setAdminNav(false); });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setAdminNav(false);
        });
    }

    // Felder, die nur zu einer bestimmten Auswahl gehören (z. B. die Art der
    // Sonderfahrt nur bei "Sonderfahrt"). Ohne JS bleibt alles sichtbar –
    // der Controller wirft die unpassende Angabe ohnehin weg.
    document.querySelectorAll('[data-toggle-target]').forEach(function (select) {
        var target = document.querySelector(select.getAttribute('data-toggle-target'));
        var wanted = select.getAttribute('data-toggle-value');
        if (!target) return;

        var sync = function () { target.hidden = select.value !== wanted; };
        select.addEventListener('change', sync);
        sync();
    });

    // Auswahl, die sich selbst abschickt (Termin im Kalender zuweisen).
    // Ohne JS steht daneben ein Knopf im <noscript>.
    document.querySelectorAll('select[data-autosubmit]').forEach(function (select) {
        select.addEventListener('change', function () {
            if (select.value !== '') select.form.requestSubmit();
        });
    });

    // Rückfrage vor endgültigen Aktionen (Stornieren, Löschen).
    // Kein window.confirm-Ersatz nötig – ein klarer Satz genügt.
    document.querySelectorAll('[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm(form.getAttribute('data-confirm'))) {
                event.preventDefault();
            }
        });
    });

    /* =====================================================================
       GETIPPTER HERO  ·  [data-typewriter]
       ---------------------------------------------------------------------
       Der Hero der Startseite schreibt sich beim Laden selbst: erst die
       Überschrift, dann der Fließtext, dann die Ortszeile. Jeder Text steht
       vollständig im Template – hier wird er geleert und Zeichen für Zeichen
       wieder aufgebaut. Suchmaschinen und Vorlesesoftware sehen also immer
       den ganzen Satz, egal ob das Skript läuft.

       Zwei Dinge halten das erträglich, und beide sind Absicht:

       Die KNÖPFE TIPPEN NICHT MIT. Sie stehen von Anfang an da und sind nach
       knapp einer Sekunde klickbar, während der Text noch läuft. Ließe man
       sie auf das Ende warten, wäre der Hero dreizehn Sekunden lang eine
       Sackgasse – bei Besucher:innen, die von TikTok kommen, ist das die
       ganze Aufmerksamkeitsspanne.

       Der FLIESSTEXT TIPPT RUND DOPPELT SO SCHNELL wie die Überschrift
       (data-typewriter="fast"): 14 statt 34 ms je Zeichen. Der Grund ist die
       Lesegeschwindigkeit – bei etwa 285 Wörtern pro Minute tippt die Seite
       so schnell, wie man liest, und das fühlt sich an wie Bremsen. Der
       Fließtext liegt mit rund 850 deutlich darüber und ist immer fertig,
       bevor man ihm folgen konnte.
       ===================================================================== */
    function initTypewriter() {
        var felder = Array.prototype.slice.call(document.querySelectorAll('[data-typewriter]'));
        if (!felder.length) return;

        // Erste Amtshandlung: sichtbar machen. Das CSS versteckt die Texte,
        // damit sie nicht kurz vollständig aufblitzen – ab hier liegt die
        // Verantwortung dafür bei diesem Skript.
        felder.forEach(function (el) { el.style.visibility = 'visible'; });
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        // Tempo je Zeichen. Am 11.08.2026 von 42/20 auf 34/14 gezogen – der
        // Hero brauchte davor 6,3 s bis zum letzten Zeichen und wirkte zäh.
        // Untergrenze ist nicht das Auge, sondern die Uhr des Browsers: Unter
        // etwa 10 ms je Zeichen kommen die Timer nicht mehr sauber durch, das
        // Tippen wird ruckelig statt schneller.
        var TEMPO = { fast: 14 };
        var STANDARD = 34;

        var schritte = [];
        felder.forEach(function (el) {
            // Zeichen und Zeilenumbrüche in der Reihenfolge des Originals. Der
            // Umbruch wird als "\n" gemerkt und später wieder zum <br> – ihn
            // wegzulassen würde die Überschrift einzeilig machen.
            var teile = [];
            Array.prototype.forEach.call(el.childNodes, function (node) {
                if (node.nodeType === 3) {
                    // Leerraum zusammenfassen. Das ist nicht kosmetisch: Ein
                    // Absatz im Template steht eingerückt und über mehrere
                    // Zeilen, sein Textknoten enthält also Zeilenumbrüche und
                    // zwanzig Leerzeichen am Stück. Ungefiltert tippt das
                    // Skript die alle einzeln mit – sichtbar als sekundenlanger
                    // Hänger mitten im Satz, bei dem sich nichts tut. Der
                    // Browser fasst denselben Leerraum beim Rendern ohnehin zu
                    // einem Leerzeichen zusammen; hier passiert nur dasselbe.
                    Array.prototype.push.apply(
                        teile,
                        node.textContent.replace(/\s+/g, ' ').split('')
                    );
                } else if (node.nodeName === 'BR') {
                    teile.push('\n');
                }
            });
            // Der Rest der Einrückung: das Leerzeichen vor dem ersten und nach
            // dem letzten Wort.
            while (teile[0] === ' ') { teile.shift(); }
            while (teile[teile.length - 1] === ' ') { teile.pop(); }
            if (!teile.length) return;

            // Höhe festnageln, BEVOR der Text verschwindet. Ohne das klappt der
            // Hero beim Tippen Zeile für Zeile auf und schiebt alles darunter
            // vor sich her – der Fehler, an dem dieser Effekt sonst scheitert.
            // Inline-Elemente (das <span> in der Ortszeile) nehmen keine
            // min-height an; dort hält der umgebende Block die Höhe.
            var traeger = window.getComputedStyle(el).display === 'inline'
                ? el.parentElement
                : el;
            traeger.style.minHeight = traeger.getBoundingClientRect().height + 'px';

            // Vollständiger Satz als Beschriftung, solange getippt wird: So
            // liest Vorlesesoftware ihn am Stück und stolpert nicht über jedes
            // einzelne Zeichen.
            el.setAttribute('aria-label', teile.join('').replace(/\n/g, ' ').trim());
            el.textContent = '';

            schritte.push({
                el: el,
                teile: teile,
                tempo: TEMPO[el.getAttribute('data-typewriter')] || STANDARD
            });
        });

        // Ein Block nach dem anderen, in der Reihenfolge im HTML.
        (function naechsterBlock() {
            var schritt = schritte.shift();
            if (!schritt) return;

            var i = 0;
            schritt.el.classList.add('is-typing');

            (function tippe() {
                if (i >= schritt.teile.length) {
                    // Cursor weg, Beschriftung weg – ab jetzt ist es wieder
                    // ganz normaler Text. Die kurze Pause danach ist der
                    // Atemzug zwischen zwei Absätzen.
                    schritt.el.classList.remove('is-typing');
                    schritt.el.removeAttribute('aria-label');
                    window.setTimeout(naechsterBlock, 70);
                    return;
                }
                var zeichen = schritt.teile[i++];
                schritt.el.appendChild(zeichen === '\n'
                    ? document.createElement('br')
                    : document.createTextNode(zeichen));

                // Nach einem Satzzeichen kurz absetzen. Das ist der Unterschied
                // zwischen „da tippt jemand" und „da läuft ein Zähler".
                // Faktor 3 statt 5: Bei vier Satzzeichen im Fließtext summierte
                // sich allein das Absetzen auf eine halbe Sekunde.
                window.setTimeout(tippe,
                    /[.,!?:–]/.test(zeichen) ? schritt.tempo * 3 : schritt.tempo);
            })();
        })();
    }

    /* =====================================================================
       SCROLL-REVEAL
       ---------------------------------------------------------------------
       Inhalte gleiten beim Scrollen herein und beim Weiterscrollen wieder
       hinaus. Das Aussehen steht in nd-base.css (.reveal), hier steht nur,
       WAS animiert wird und AUS WELCHER RICHTUNG.

       Warum die Klassen aus dem JavaScript kommen und nicht im Template
       stehen: Die Regel `.reveal { opacity: 0 }` würde ohne JavaScript eine
       leere Seite hinterlassen. So bekommt die Klasse nur, wer sie auch
       wieder loswerden kann – und keine einzige View muss angefasst werden,
       wenn eine neue Seite dazukommt.
       ===================================================================== */
    initReveal();

    function initReveal() {
        // Nur die öffentliche Seite. Der Admin ist Sarahs Werkzeug zwischen
        // zwei Fahrstunden – dort auf eine Einblendung zu warten, nervt.
        if (document.body.classList.contains('admin-body') ||
            document.body.classList.contains('admin-auth-body')) return;
        if (!('IntersectionObserver' in window)) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        var main = document.querySelector('main');
        if (!main) return;

        // Die animierten Blöcke. Bewusst allgemein gehalten (Komponenten und
        // direkte Kinder eines .container), damit jede neue Seite die
        // Animation automatisch mitbringt.
        var BLOCKS = [
            '.duo-text', '.duo-media',
            '.card-grid > *', '.split-grid > *', '.process > *',
            '.section-head', '.notice', '.quote', '.cta-inner',
            '.empty-state', '.prose', '.week-grid', '.card',
            '.container > p', '.container > h2', '.container > figure', '.container > ul'
        ].join(', ');

        var ZOOM           = '.quote, .cta-inner';
        var STAGGER_PARENT = '.card-grid, .split-grid, .process';

        var found = Array.prototype.slice.call(main.querySelectorAll(BLOCKS))
            // Der Hero hat seinen eigenen Auftritt beim Laden (heroDrop /
            // heroRise in nd-base.css). Beide Systeme auf demselben Element
            // würden sich um `opacity` streiten.
            .filter(function (el) { return !el.closest('.hero'); });

        // Nur die äußerste Ebene animieren. Ein Fotorahmen in einer .duo-media
        // träfe sonst zwei Regeln und blendete zweimal ein – einmal als Rahmen
        // und einmal mit der Spalte drumherum.
        var blocks = found.filter(function (el) {
            return !found.some(function (other) {
                return other !== el && other.contains(el);
            });
        });

        function setDirection(el, dir) {
            el.classList.remove('reveal--up', 'reveal--left', 'reveal--right', 'reveal--zoom');
            el.classList.add('reveal--' + dir);
        }

        // Die Richtung kommt aus der gemessenen Position, nicht aus der
        // Reihenfolge im HTML. Das muss so: `.duo--text-first` dreht die
        // Spalten per CSS-`order` um, und unter 820 px stehen sie
        // übereinander. Gemessen stimmt die Richtung in allen drei Fällen
        // von selbst – eine Spalte, die fast so breit ist wie ihre Reihe,
        // steht gestapelt und kommt deshalb von unten.
        function sideOf(el) {
            var own = el.getBoundingClientRect();
            var row = el.parentElement.getBoundingClientRect();
            if (own.width > row.width * 0.8) return 'up';
            return (own.left + own.width / 2) < (row.left + row.width / 2) ? 'left' : 'right';
        }

        var columns  = [];   // Blöcke, deren Richtung von der Breite abhängt
        var viewport = window.innerHeight || document.documentElement.clientHeight;

        blocks.forEach(function (el) {
            // .hero-content ist die Textspalte des Heros – sie heißt nur
            // anders, weil sie im Hero eine eigene Breitenbegrenzung hat.
            if (el.matches('.duo-text, .duo-media, .hero-content')) {
                columns.push(el);
                setDirection(el, sideOf(el));
            } else {
                setDirection(el, el.matches(ZOOM) ? 'zoom' : 'up');
            }

            // Karten in einem Raster kommen nacheinander herein statt als
            // Block. Nach der sechsten Karte bleibt es beim gleichen Versatz,
            // sonst wartet man bei einer langen Liste auf die letzte.
            var parent = el.parentElement;
            if (parent && parent.matches(STAGGER_PARENT)) {
                var index = Array.prototype.indexOf.call(parent.children, el);
                el.dataset.revealDelay = Math.min(index, 5) * 90;
            }

            el.classList.add('reveal');

            // Was beim Laden schon im Bild steht, ist sofort sichtbar – ohne
            // Einblendung. Sonst wäre die Seite einen Wimpernschlag lang
            // fertig gezeichnet, würde verschwinden und wieder auftauchen.
            // Dieses Zucken wiegt schwerer als die eingesparte Animation;
            // beim Zurückscrollen animiert der Block dann ganz normal mit.
            if (el.getBoundingClientRect().top < viewport) {
                el.classList.add('is-in');
            }
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                var el = entry.target;
                if (entry.isIntersecting) {
                    el.style.setProperty('--reveal-delay', (el.dataset.revealDelay || 0) + 'ms');
                    el.classList.add('is-in');
                } else {
                    // Hinaus ohne Staffelung: Beim Verlassen des Bildschirms
                    // wirkt eine Verzögerung wie ein Hänger, nicht wie Absicht.
                    el.style.setProperty('--reveal-delay', '0ms');
                    el.classList.remove('is-in');
                }
            });
        }, {
            // Der eingezogene Rand sorgt dafür, dass die Einblendung startet,
            // wenn der Block ein Stück im Bild ist – und nicht schon, wenn
            // seine erste Pixelreihe die Kante streift.
            rootMargin: '-8% 0px -8% 0px'
        });

        blocks.forEach(function (el) { observer.observe(el); });

        // Beim Drehen des Handys oder Ziehen am Fenster wechseln die Spalten
        // zwischen nebeneinander und gestapelt – dann stimmt die Richtung
        // nicht mehr und wird neu gemessen.
        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                columns.forEach(function (el) { setDirection(el, sideOf(el)); });
            }, 200);
        });
    }
})();
