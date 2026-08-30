<?php /** @var string $content @var string $title */ ?>
<?php
/* SEO-Bausteine, die jede Seite setzen kann (SAR-10):
   $metaTitle       – der VOLLSTÄNDIGE Titel, ohne angehängtes „· Fahrlehrerin
                      Sarah". Für die Seiten, bei denen der Anhang den Platz
                      wegnimmt, den ein Suchbegriff bräuchte.
   $metaDescription – die Beschreibung in der Trefferliste.
   $noindex         – true = diese Seite gehört dauerhaft in keinen Index,
                      unabhängig von ALLOW_INDEXING (Login, Kalender, …).
   $jsonLd          – strukturierte Daten, gebaut über die Klasse Seo.
   $canonicalPath   – nur nötig, wenn der Canonical NICHT der eigene Pfad ist. */
$seitenTitel = $metaTitle ?? (($title ?? 'Fahrlehrerin Sarah') . ' · Fahrlehrerin Sarah');
$seitenText  = $metaDescription
    ?? 'Sarah ist Fahrlehrerin in ' . config('contact.city')
     . ' – mit Geduld, klaren Ansagen und Erfahrung im Fahren mit Handicap.';
/* Der Canonical zeigt auf den Pfad OHNE Query-String. Genau darum geht es:
   /termine?woche=3 und /termine sind dieselbe Seite, und die Adresse mit
   Parameter soll nicht als eigene in den Index. */
$canonical = absolute_url($canonicalPath ?? current_path());
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($seitenTitel) ?></title>
    <meta name="description" content="<?= e($seitenText) ?>">

    <?php /* Die eine verbindliche Adresse dieser Seite. Ohne sie ist die Seite
             unter Domain, IP und (später) www dreimal dieselbe Seite – für eine
             Suchmaschine drei Seiten, die sich gegenseitig Konkurrenz machen.
             Steht APP_URL in der .env, ist der Wert fest; sonst rät
             absolute_url() den Host, siehe app/helpers.php. */ ?>
    <link rel="canonical" href="<?= e($canonical) ?>">

    <?php /* Solange die Seite nicht offiziell live ist, soll sie in keiner
             Suchmaschine auftauchen. Ein Meta allein reicht nicht – dazu gehört
             /robots.txt (RobotsController). Umschalten über ALLOW_INDEXING. */ ?>
    <?php if (!config('allow_indexing')): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php elseif (!empty($noindex)): ?>
        <?php /* Dauerhaft draußen, auch nach dem Livegang: Login, Kalender und
                 die persönlichen Seiten. „follow" bleibt bewusst stehen – die
                 Seite selbst soll nicht in den Index, ihre Links (Fuß,
                 Navigation) dürfen aber weiter verfolgt werden. */ ?>
        <meta name="robots" content="noindex, follow">
    <?php endif; ?>
    <?php /* Schriften kommen vom eigenen Server (public/assets/fonts/), nicht von
             Google. Vorgeladen wird nur das latin-Subset – das trägt den Text;
             latin-ext holt der Browser bei Bedarf selbst. */ ?>
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
    <meta property="og:locale" content="de_DE">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:title" content="<?= e($seitenTitel) ?>">
    <meta property="og:description" content="<?= e($seitenText) ?>">
    <meta property="og:image" content="<?= e(absolute_url('/assets/img/logo-sarah-teilen.jpg')) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    <?php /* Strukturierte Daten – nur dort, wo eine Seite sie ausdrücklich
             mitgibt (siehe app/Seo.php). Kein automatisches Markup auf jeder
             Seite: Sarahs Person auf dem Login-Formular zu behaupten, sagt
             über die Seite nichts und über die Person das Falsche. */ ?>
    <?php if (!empty($jsonLd)): ?>
        <?php /* Eine Seite darf einen Datensatz mitgeben oder mehrere. Ohne
                 diese Zeile zerfiele ein einzelner in seine Felder, und die
                 Seite bekäme statt eines Person-Blocks ein halbes Dutzend
                 leerer Skripte. array_is_list() unterscheidet die Liste
                 („mehrere") vom Datensatz („einer"). */ ?>
        <?php foreach (array_is_list($jsonLd) ? $jsonLd : [$jsonLd] as $datensatz): ?>
    <?= Seo::script($datensatz) ?>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <?php /* SPRUNGLINK, erster Tab-Stopp der Seite (SAR-34).
             Wer mit der Tastatur oder einem Screenreader kommt, musste vorher auf
             jeder Unterseite erst durch Logo und die ganze Hauptnavigation,
             bevor der Inhalt anfing. Unsichtbar bis er den Fokus bekommt – dann springt er
             sichtbar oben links ins Bild (Regel in a11y.css ist es nicht, sondern
             nd-base.css: der Sprunglink gehört zum Grundgerüst und nicht zu den
             abschaltbaren Modi). */ ?>
    <a class="skip-link" href="#inhalt">Zum Inhalt springen</a>

    <?php /* Die Barrierefreiheits-Leiste. Gleich hinter dem Sprunglink, damit sie
             der zweite Tab-Stopp ist – wer sie braucht, soll sie nicht suchen. */ ?>
    <?php require APP_ROOT . '/app/Views/partials/a11y-toolbar.php'; ?>

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

    <main id="inhalt">
        <?= $content ?>
    </main>

    <?php /* Hier stand bis zum 22.08.2026 Sarahs Einordnung (partials/site-note.php):
             „Ich bin Fahrlehrerin für die Klassen B und BE … angestellt bei der
             Fahrschule Sander, nicht selbstständig – diese Seite ist mein
             persönliches Schaufenster, keine Fahrschul-Website." Sie lief über
             dem Credit-Band auf jeder öffentlichen Seite, mit einer Ausnahme:
             die Unterseiten der Wegbegleiter (Schalter `showSiteNote` im
             PartnerController, mit ihr entfallen).

             Auf Nils' Wunsch ersatzlos gestrichen: Die Fahrschule Sander steht
             inzwischen an so vielen Stellen der Seite, dass die Fußnote unter
             JEDER Seite nichts mehr einordnet, was nicht ohnehin schon dasteht
             – Hero-Knopf, Sander-Sektion der Startseite, die Kachel unter
             „Wegbegleiter", Kasten „Anmeldung und Vertrag" auf
             /fahren-mit-handicap. (Die Unterseite der Fahrschule ist mit
             SAR-102 entfallen, die Kachel führt jetzt direkt zu ihr.)

             Was damit verschwindet, ist die eine Stelle, an der die Wörter
             „angestellt, nicht selbstständig" wörtlich standen. Wer sie
             zurückholen will: Die Datei liegt in der Versionsgeschichte, das
             CSS (.site-note) steht weiter in nd-base.css. */ ?>

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
    <?php /* Nur die Bedienung des Panels. Das Anwenden der Einstellungen liegt im
             Inline-Skript oben im <head> – siehe die Begründung dort. */ ?>
    <?php /* Sarahs Kanäle als Leiste am linken Rand (SAR-36). Steht hier unten und
             nicht oben beim Barrierefreiheits-Knopf, obwohl beide daneben zu sehen
             sind: Zwei Links auf fremde Plattformen sollen nicht der zweite
             Tab-Stopp der Seite sein. Begründung im Partial. */ ?>
    <?php require APP_ROOT . '/app/Views/partials/social-rail.php'; ?>

    <script src="<?= asset('js/a11y.js') ?>" defer></script>
</body>
</html>
