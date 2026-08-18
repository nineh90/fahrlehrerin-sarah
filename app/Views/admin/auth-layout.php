<?php /** @var string $content @var string $title */ ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Anmelden') ?> · Fahrlehrerin Sarah</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preload" href="<?= asset('fonts/fredoka-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('fonts/roboto-mono-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= asset('css/fonts.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/nd-base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
    <link rel="icon" href="<?= asset('img/favicon.png') ?>" sizes="48x48" type="image/png">
    <link rel="apple-touch-icon" href="<?= asset('img/apple-touch-icon.png') ?>">

    <?php /* Nur der Kopfteil und keine Leiste: Auf der Login-Seite gibt es nichts
             einzustellen, was den Weg zum Formular erleichtert. Eine gespeicherte
             Einstellung muss hier aber greifen – sonst schlägt jemandem, der den
             hohen Kontrast braucht, beim Anmelden die helle Seite entgegen. */ ?>
    <?php require APP_ROOT . '/app/Views/partials/a11y-head.php'; ?>
</head>
<body class="admin-auth-body">
    <div class="admin-auth">
        <div class="login-card">
            <?php require APP_ROOT . '/app/Views/partials/flash.php'; ?>
            <?= $content ?>
        </div>
    </div>
</body>
</html>
