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
    <?php /* Schriften kommen vom eigenen Server (public/assets/fonts/), nicht von
             Google. Vorgeladen wird nur das latin-Subset – das trägt den Text;
             latin-ext holt der Browser bei Bedarf selbst. */ ?>
    <link rel="preload" href="<?= asset('fonts/fredoka-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('fonts/roboto-mono-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= asset('css/fonts.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/nd-base.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
    <link rel="icon" href="<?= asset('img/favicon.png') ?>" sizes="48x48" type="image/png">
    <link rel="apple-touch-icon" href="<?= asset('img/apple-touch-icon.png') ?>">

    <?php /* Die getippte Überschrift (data-typewriter, nur auf der Startseite)
             ist bis zum Start des Skripts unsichtbar – sonst stünde sie einen
             Wimpernschlag lang vollständig da und verschwände wieder. Ohne
             JavaScript kommt das Skript nie, deshalb hebt <noscript> die Regel
             hier wieder auf. Muss NACH den Stylesheets stehen, sonst verliert es. */ ?>
    <noscript><style>[data-typewriter] { visibility: visible !important; }</style></noscript>

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
    <?php /* Bewegter Hintergrund: vier langsam ziehende Farbwolken hinter der
             ganzen Seite. Reine Dekoration – deshalb aria-hidden und leere
             <span>, es gibt hier nichts vorzulesen. Gestaltung in nd-base.css
             (.page-aurora), Farben in theme.css (--aurora-1 … -4).
             Steht bewusst nur hier und nicht im Admin-Layout. */ ?>
    <div class="page-aurora" aria-hidden="true">
        <span></span><span></span><span></span><span></span>
    </div>

    <?php require APP_ROOT . '/app/Views/partials/nav.php'; ?>

    <?php require APP_ROOT . '/app/Views/partials/flash.php'; ?>

    <main>
        <?= $content ?>
    </main>

    <?php /* Sarahs Einordnung in eigenen Worten. Steht ÜBER dem Credit-Band und
             ohne Schalter: Ihre Sache zuerst, und „auf jeder Seite" heißt auf
             jeder – auch dort, wo der Credit bewusst schweigt. */ ?>
    <?php require APP_ROOT . '/app/Views/partials/site-note.php'; ?>

    <?php /* Hier stand bis zum 17.08.2026 das große Credit-Band von
             Nils-Digital (partials/nd-credit.php): Logo, Überschrift,
             Werbetext und zwei Knöpfe, zwischen Sarahs Inhalt und ihrem Fuß.
             Es lief über den Schalter `showNdCredit`, den fünf Controller auf
             false setzten – auf Login, Kalender, „Meine Stunden" und beim
             Verschieben wäre es im Weg gewesen.

             Auf Sarahs Wunsch entfallen (Ticket SAR-32). An seine Stelle tritt
             ein schmaler Streifen UNTER dem Fuß, dafür ohne Ausnahme auf jeder
             Seite. Der Schalter ist damit weg, auch aus den Controllern – ein
             Flag, das nichts mehr bewirkt, ist eine Falle für den Nächsten.

             `nd-credit.php` liegt weiter im Ordner. Sie ist die Vorlage für
             das, was Sarah „später als Wegbegleiter" genannt hat; wer das Band
             zurückholt, braucht hier wieder ein `require` und in den fünf
             Controllern wieder ein `showNdCredit => false`. */ ?>
    <?php require APP_ROOT . '/app/Views/partials/footer.php'; ?>

    <?php /* Nach dem Fuß, nicht darin: Der Fuß gehört Sarah, was darunter
             steht, ist die Signatur dessen, der die Seite gebaut hat. */ ?>
    <?php require APP_ROOT . '/app/Views/partials/nd-banner.php'; ?>

    <script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
