<?php /** @var string $content @var string $title */ ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Schaltzentrale') ?> · Fahrlehrerin Sarah</title>
    <meta name="robots" content="noindex, nofollow">
    <?php /* SAR-104: Vorgeladen wird nur das latin-Subset, und darin beide
             Schnitte – 400 trägt den Fließtext, 700 die Überschriften, beides
             steht sofort im Bild. latin-ext bleibt draußen: Es ist mit Abstand
             die dickste Datei und wird nur gebraucht, wenn ein Name ein ł oder
             ș enthält. Der Browser holt es dann von selbst nach. */ ?>
    <link rel="preload" href="<?= asset('fonts/carlito-latin-400.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('fonts/carlito-latin-700.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= asset('css/fonts.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/nd-base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
    <link rel="icon" href="<?= asset('img/favicon.png') ?>" sizes="48x48" type="image/png">
    <link rel="apple-touch-icon" href="<?= asset('img/apple-touch-icon.png') ?>">

    <?php require APP_ROOT . '/app/Views/partials/a11y-head.php'; ?>
</head>
<body class="admin-body">
    <?php /* Die Leiste gibt es auch hier (SAR-34). Sarah ist die Einzige, die die
             Schaltzentrale benutzt, und gleichzeitig die, die diese Einstellungen
             am ehesten braucht – ihren Dunkelmodus beim Wechsel hierher zu
             verlieren wäre genau die Inkonsequenz, die so ein Bedienfeld
             unbrauchbar macht. Kein Sprunglink: Der Adminbereich hat keine
             Hauptnavigation, an der man vorbeimüsste. */ ?>
    <?php require APP_ROOT . '/app/Views/partials/a11y-toolbar.php'; ?>

    <aside class="admin-sidebar" id="adminSidebar">
        <a class="brand admin-brand" href="<?= url('/admin') ?>">
            <img class="admin-brand-logo" src="<?= asset('img/logo-sarah-hell.webp') ?>"
                 alt="Fahrlehrerin Sarah" width="393" height="462">
            <span class="brand-sub">Schaltzentrale</span>
        </a>

        <nav class="admin-nav">
            <?php $unread = admin_unread_count(); ?>
            <a class="<?= trim(nav_exact('/admin')) ?>" href="<?= url('/admin') ?>">Übersicht</a>
            <a class="<?= trim(nav_active('/admin/benachrichtigungen')) ?>"
               href="<?= url('/admin/benachrichtigungen') ?>">
                Posteingang
                <?php if ($unread > 0): ?>
                    <span class="nav-badge" aria-label="<?= $unread ?> ungelesen"><?= $unread ?></span>
                <?php endif; ?>
            </a>
            <a class="<?= trim(nav_active('/admin/termine')) ?>" href="<?= url('/admin/termine') ?>">Termine</a>
            <a class="<?= trim(nav_active('/admin/buchungen')) ?>" href="<?= url('/admin/buchungen') ?>">Buchungen</a>
            <a class="<?= trim(nav_active('/admin/schueler')) ?>" href="<?= url('/admin/schueler') ?>">Fahrschüler:innen</a>
        </nav>

        <div class="admin-sidebar-foot">
            <a href="<?= url('/admin/passwort') ?>">Mein Zugang</a>
            <a href="<?= url('/') ?>" target="_blank" rel="noopener">Website ansehen &nearr;</a>
            <form method="post" action="<?= url('/admin/logout') ?>">
                <?= csrf_field() ?>
                <button class="btn btn-ghost btn-sm btn-block" type="submit">Abmelden</button>
            </form>
        </div>
    </aside>

    <button class="admin-backdrop" type="button" aria-label="Menü schließen" hidden></button>

    <div class="admin-main">
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <button class="admin-nav-toggle" type="button" aria-label="Menü öffnen"
                        aria-expanded="false" aria-controls="adminSidebar">
                    <span></span><span></span><span></span>
                </button>
                <h1><?= e($title ?? 'Schaltzentrale') ?></h1>
            </div>
            <div class="admin-topbar-right">
                <?php $unreadTop = admin_unread_count(); ?>
                <a class="topbar-bell<?= $unreadTop > 0 ? ' has-unread' : '' ?>"
                   href="<?= url('/admin/benachrichtigungen') ?>"
                   aria-label="Posteingang<?= $unreadTop > 0 ? ': ' . $unreadTop . ' ungelesen' : '' ?>">
                    <?= icon('bell') ?>
                    <?php if ($unreadTop > 0): ?>
                        <span class="bell-dot"><?= $unreadTop > 9 ? '9+' : $unreadTop ?></span>
                    <?php endif; ?>
                </a>
                <span class="admin-user"><?= e(Auth::user()['email'] ?? '') ?></span>
            </div>
        </div>

        <div class="admin-content">
            <?php require APP_ROOT . '/app/Views/partials/flash.php'; ?>
            <?= $content ?>
        </div>
    </div>

    <script src="<?= asset('js/main.js') ?>" defer></script>
    <script src="<?= asset('js/a11y.js') ?>" defer></script>
</body>
</html>
