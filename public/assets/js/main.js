/* Fahrlehrerin Sarah – Frontend-Interaktion (kein Framework) */
(function () {
    'use strict';

    // Steht ganz oben, weil die Überschrift bis dahin per CSS unsichtbar ist
    // (siehe [data-typewriter] in nd-base.css). Was auch immer weiter unten
    // schiefgehen könnte – sichtbar ist sie danach auf jeden Fall.
    initTypewriter();

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
       GETIPPTE ÜBERSCHRIFT  ·  [data-typewriter]
       ---------------------------------------------------------------------
       Nur die H1 der Startseite, nur einmal beim Laden. Der Satz steht
       vollständig im Template – hier wird er geleert und Zeichen für Zeichen
       wieder aufgebaut. Suchmaschinen und Vorlesesoftware sehen also immer
       die ganze Überschrift, egal ob das Skript läuft.
       ===================================================================== */
    function initTypewriter() {
        var head = document.querySelector('[data-typewriter]');
        if (!head) return;

        // Erste Amtshandlung: sichtbar machen. Das CSS versteckt die
        // Überschrift, damit sie nicht kurz vollständig aufblitzt – ab hier
        // liegt die Verantwortung dafür bei diesem Skript.
        head.style.visibility = 'visible';
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        // Zeichen und Zeilenumbrüche in der Reihenfolge des Originals. Der
        // Umbruch wird als "\n" gemerkt und später wieder zum <br> – ihn
        // einfach wegzulassen würde die Überschrift einzeilig machen und den
        // Hero in der Höhe verschieben.
        var parts = [];
        Array.prototype.forEach.call(head.childNodes, function (node) {
            if (node.nodeType === 3) {
                Array.prototype.push.apply(parts, node.textContent.split(''));
            } else if (node.nodeName === 'BR') {
                parts.push('\n');
            }
        });
        if (!parts.length) return;

        // Höhe festnageln, BEVOR der Text verschwindet. Ohne das klappt der
        // Hero beim Tippen Zeile für Zeile auf und schiebt alles darunter vor
        // sich her – der Fehler, an dem dieser Effekt sonst immer scheitert.
        head.style.minHeight = head.getBoundingClientRect().height + 'px';

        // Vollständiger Satz als Beschriftung, solange getippt wird: So liest
        // Vorlesesoftware die Überschrift am Stück und stolpert nicht über
        // jedes einzelne Zeichen.
        head.setAttribute('aria-label', parts.join('').replace('\n', ' ').trim());
        head.textContent = '';
        head.classList.add('is-typing');

        var i = 0;
        (function type() {
            if (i >= parts.length) {
                // Cursor weg, Beschriftung weg – ab jetzt ist es wieder eine
                // ganz normale Überschrift.
                head.classList.remove('is-typing');
                head.removeAttribute('aria-label');
                return;
            }
            var part = parts[i++];
            head.appendChild(part === '\n'
                ? document.createElement('br')
                : document.createTextNode(part));

            // Nach einem Satzzeichen kurz absetzen. Das ist der Unterschied
            // zwischen „da tippt jemand" und „da läuft ein Zähler".
            window.setTimeout(type, /[.,!?–]/.test(part) ? 250 : 42);
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
