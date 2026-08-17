<header class="site-header">
    <div class="container header-inner">
        <?php /* EIN LOGO, ZWEI GRÖSSEN.

                 Sarahs volles Logo steht oben groß und ragt unter der Leiste
                 hervor; beim Scrollen wird es kleiner. Mehr passiert nicht –
                 das Logo selbst bleibt in jedem Zustand dasselbe Bild.
                 Eine frühere Fassung tauschte es beim Scrollen gegen den
                 reinen Bogen aus; das war auf Wunsch von Nils falsch: Ein
                 Logo, das sich beim Scrollen verwandelt, prägt sich nicht ein.

                 Weil der Schriftzug im Logo klein nicht mehr lesbar ist,
                 blendet beim Scrollen die Wortmarke als echter Text daneben
                 ein. Sie steht auch oben schon im Fluss, nur unsichtbar – so
                 hält sie die Breite des Markenblocks und die Navigation
                 daneben verrutscht beim Umschalten nicht.

                 Das Bild trägt alt="" – den Namen trägt das aria-label am
                 Link, damit Vorlesesoftware in beiden Zuständen denselben
                 einen Satz hört. */ ?>
        <a class="brand" href="<?= url('/') ?>" aria-label="Fahrlehrerin Sarah – zur Startseite">
            <img class="brand-logo brand-logo--full" src="<?= asset('img/logo-sarah-klein.webp') ?>"
                 alt="" width="255" height="300">
            <span class="brand-text">
                <span class="brand-mark">Fahrlehrerin Sarah</span>
                <?php /* „Fahrlehrerin" steht schon eine Zeile höher im Namen – hier
                         nur die Klassen. Die Zeile läuft in Versalien mit weitem
                         Sperrsatz, jedes Wort mehr bricht den Header auf dem Handy
                         in eine dritte Zeile um. */ ?>
                <span class="brand-sub">Klasse B · BE · Handicap</span>
            </span>
        </a>

        <button class="nav-toggle" type="button" aria-label="Menü öffnen" aria-expanded="false" aria-controls="mainNav">
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" id="mainNav">
            <a class="nav-link<?= nav_active('/ueber-mich') ?>" href="<?= url('/ueber-mich') ?>">Über mich</a>
            <a class="nav-link<?= nav_active('/fahren-mit-handicap') ?>" href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a>
            <a class="nav-link<?= nav_active('/kontakt') ?>" href="<?= url('/kontakt') ?>">Kontakt</a>

            <?php if (StudentAuth::check()): ?>
                <a class="nav-link<?= nav_active('/meine-termine') ?>" href="<?= url('/meine-termine') ?>">Meine Stunden</a>
                <form class="inline-form" method="post" action="<?= url('/logout') ?>">
                    <?= csrf_field() ?>
                    <button class="nav-link" type="submit">Abmelden</button>
                </form>
                <a class="btn btn-primary btn-sm nav-cta<?= nav_active('/termine') ?>" href="<?= url('/termine') ?>">Stunde eintragen</a>
            <?php else: ?>
                <a class="nav-link<?= nav_active('/login') ?>" href="<?= url('/login') ?>">Anmelden</a>
                <?php /* Hieß bis zum 17.08.2026 „Meine freien Zeiten" (Sarah,
                         Ticket SAR-26). Weil die Knöpfe auf den Seiten seit
                         SAR-22 heißen wie ihr Menüpunkt, ist der Name hier
                         die Quelle: Wer ihn ändert, ändert ihn auch in
                         home.php, ueber-mich.php und footer.php mit.

                         Die Zielseite selbst heißt weiter „Meine freien
                         Zeiten" – das ist kein Versehen, siehe CLAUDE.md:
                         Die Terminplanung ist Sarahs eigenes Werkzeug, kein
                         Buchungssystem der Fahrschule. Das „meine" sagt
                         genau das. Als Wegweiser im Header ist „Termine"
                         trotzdem besser, weil er kurz sein muss und neben
                         „Anmelden" steht. */ ?>
                <a class="btn btn-primary btn-sm nav-cta<?= nav_active('/termine') ?>" href="<?= url('/termine') ?>">Termine</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
