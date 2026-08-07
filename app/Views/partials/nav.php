<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= url('/') ?>">
            <?php /* Im Header steht das Signet (Bogen + Lenkrad) statt des vollen Logos:
                     Auf 54 px wäre der Schriftzug im Logo nur noch Matsch. Den Namen
                     trägt der Text daneben, deshalb alt="". */ ?>
            <img class="brand-logo" src="<?= asset('img/logo-signet.webp') ?>"
                 alt="" width="200" height="231">
            <span class="brand-text">
                <span class="brand-mark">Fahrlehrerin Sarah</span>
                <span class="brand-sub">Ich sitze rechts neben dir</span>
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
