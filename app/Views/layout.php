<?php /** @var string $content @var string $title */ ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Fahrlehrerin Sarah') ?> · Fahrlehrerin Sarah</title>
    <meta name="description" content="<?= e($metaDescription ?? 'Sarah ist Fahrlehrerin in ' . config('contact.city') . ' – mit Geduld, klaren Ansagen und Erfahrung im Fahren mit Handicap.') ?>">

    <?php /* Solange die Seite nicht offiziell live ist, soll sie in keiner
             Suchmaschine auftauchen. Ein Meta allein reicht nicht – dazu gehört
             /robots.txt (RobotsController). Umschalten über ALLOW_INDEXING. */ ?>
    <?php if (!config('allow_indexing')): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/nd-base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
    <link rel="icon" href="<?= asset('img/favicon.png') ?>" sizes="48x48" type="image/png">
    <link rel="apple-touch-icon" href="<?= asset('img/apple-touch-icon.png') ?>">

    <?php /* Vorschaubild beim Teilen (WhatsApp, Facebook, Signal) – braucht eine
             absolute URL, deshalb absolute_url() statt asset(). */ ?>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Fahrlehrerin Sarah">
    <meta property="og:title" content="<?= e($title ?? 'Fahrlehrerin Sarah') ?>">
    <meta property="og:description" content="<?= e($metaDescription ?? 'Sarah ist Fahrlehrerin in ' . config('contact.city') . ' – mit Geduld, klaren Ansagen und Erfahrung im Fahren mit Handicap.') ?>">
    <meta property="og:image" content="<?= e(absolute_url('/assets/img/logo-sarah-teilen.jpg')) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
</head>
<body>
    <?php require APP_ROOT . '/app/Views/partials/nav.php'; ?>

    <?php require APP_ROOT . '/app/Views/partials/flash.php'; ?>

    <main>
        <?= $content ?>
    </main>

    <?php
    /* Credit-Band auf den Info-Seiten. Auf den Seiten, auf denen jemand gerade
       eine Fahrstunde einträgt (Login, Kalender, eigene Stunden), bleibt es
       bewusst weg – dort wäre es nur im Weg. */
    if ($showNdCredit ?? true) {
        require APP_ROOT . '/app/Views/partials/nd-credit.php';
    }
    ?>

    <?php require APP_ROOT . '/app/Views/partials/footer.php'; ?>

    <script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
