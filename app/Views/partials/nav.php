<header class="site-header">
    <div class="container header-inner">
        <?php /* ZWEI ZUSTÄNDE, und das ist der Kern der Sache.

                 Ganz oben steht Sarahs volles Logo groß – der Bogen mit dem
                 Schriftzug, so wie sie es gezeichnet hat. Vorher war es nur im
                 Footer zu sehen und hat sich dadurch nie eingeprägt.

                 Beim Scrollen wird daraus der reine Bogen mit der Wortmarke
                 als Text daneben. Bewusst NUR der Bogen: Das frühere Signet
                 hatte das Lenkrad in die Bogenmitte einkomponiert – eine
                 Neuzeichnung, die im Original so nicht vorkommt. Sie ist auf
                 Wunsch von Nils am 11.08.2026 komplett entfallen. Der Bogen
                 allein ist Sarahs echte Form, und eine Fläche ohne Schrift
                 bleibt auch bei 46 px lesbar. Das ist KEIN
                 bloßes Verkleinern des vollen Logos, sondern ein Austausch,
                 und dafür gibt es einen gemessenen Grund: Nachgestellt bei
                 54, 72, 88, 104, 120 px liest sich der Schriftzug erst ab
                 rund 104 px sauber, darunter wird „Klasse B · Klasse BE"
                 zu Matsch. Ein Logo, das beim Scrollen unleserlich wird,
                 wäre schlechter als das, was vorher da war.

                 Beide Bilder tragen alt="" – den Namen trägt das aria-label
                 am Link, damit Vorlesesoftware in beiden Zuständen denselben
                 einen Satz hört und nicht je nach Scrollposition etwas
                 anderes. */ ?>
        <a class="brand" href="<?= url('/') ?>" aria-label="Fahrlehrerin Sarah – zur Startseite">
            <img class="brand-logo brand-logo--full" src="<?= asset('img/logo-sarah-klein.webp') ?>"
                 alt="" width="260" height="300">
            <img class="brand-logo brand-logo--compact" src="<?= asset('img/logo-bogen-klein.webp') ?>"
                 alt="" width="160" height="185">
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
                <a class="btn btn-primary btn-sm nav-cta<?= nav_active('/termine') ?>" href="<?= url('/termine') ?>">Meine freien Zeiten</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
