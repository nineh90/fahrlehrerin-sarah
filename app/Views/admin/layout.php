<?php /** @var string $content @var string $title */ ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Verwaltung') ?> · Fahrlehrerin Sarah</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/nd-base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
    <link rel="icon" href="<?= asset('img/favicon.png') ?>" sizes="48x48" type="image/png">
    <link rel="apple-touch-icon" href="<?= asset('img/apple-touch-icon.png') ?>">
</head>
<body class="admin-body">

    <aside class="admin-sidebar" id="adminSidebar">
        <a class="brand admin-brand" href="<?= url('/admin') ?>">
            <img class="admin-brand-logo" src="<?= asset('img/logo-sarah-hell.webp') ?>"
                 alt="Fahrlehrerin Sarah" width="400" height="462">
            <span class="brand-sub">Verwaltung</span>
        </a>

        <nav class="admin-nav">
            <a class="<?= trim(nav_exact('/admin')) ?>" href="<?= url('/admin') ?>">Übersicht</a>
            <a class="<?= trim(nav_active('/admin/termine')) ?>" href="<?= url('/admin/termine') ?>">Termine</a>
            <a class="<?= trim(nav_active('/admin/buchungen')) ?>" href="<?= url('/admin/buchungen') ?>">Buchungen</a>
            <a class="<?= trim(nav_active('/admin/schueler')) ?>" href="<?= url('/admin/schueler') ?>">Fahrschüler:innen</a>
        </nav>

        <div class="admin-sidebar-foot">
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
                <h1><?= e($title ?? 'Verwaltung') ?></h1>
            </div>
            <span class="admin-user"><?= e(Auth::user()['email'] ?? '') ?></span>
        </div>

        <div class="admin-content">
            <?php require APP_ROOT . '/app/Views/partials/flash.php'; ?>
            <?= $content ?>
        </div>
    </div>

    <script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
