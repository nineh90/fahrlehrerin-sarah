<?php
/* WEGBEGLEITER · MOOOOV  (SAR-62)
 * -------------------------------------------------------------------------
 * Der vierte Eintrag unter /wegbegleiter und der erste, bei dem die Verbindung
 * zu Sarahs Arbeit keine Erklärung braucht: Moooov baut Autos für Menschen mit
 * Handicap um. Handbediengeräte, Lenkhilfen, Pedalanpassungen, also genau die
 * Technik, die auf /fahren-mit-handicap in den Umbau-Karten steht. Die
 * Werkstatt sitzt in Harsefeld und damit in Sarahs Einzugsgebiet.
 *
 * KURZ WIE DIE ANDEREN: wer das ist, wie man hinkommt, woher die Angaben
 * stammen. Kein zweiter Webauftritt. Keine Preise, keine Fahrzeugliste, keine
 * Aussagen zu Fördermitteln. Das ändert sich alles und steht als Link dorthin.
 *
 * KEINE ABGRENZUNG UND KEINE HINWEISE, die Regel von der Seite des Vereins
 * gilt hier genauso. Der Absatz zum Kostenträger unten ist keiner: Er
 * beschreibt, was auf DEREN Seite steht, und gibt keinen Rat von Sarah.
 *
 * ZWEI E-MAIL-ADRESSEN, deshalb keine Mail-Kachel. Im Kopf jeder Seite steht
 * `hi@moooov.de`, im Impressum `info@moooov.de`. Beide sind echt, welche die
 * richtige ist, entscheidet nicht diese Seite. Die Telefonnummer ist an beiden
 * Stellen dieselbe, die steht deshalb hier; zum Schreiben führt die Kachel
 * „Die ganze Seite" auf ihr Kontaktformular.
 *
 * WOHER DIE ANGABEN STAMMEN: von moooov-mobility.de und aus deren Impressum,
 * abgerufen am 20.08.2026.
 *
 * DAS LOGO IST NOCH NICHT FREIGEGEBEN, Stand 20.08.2026, wie bei den beiden
 * Einträgen davor. Siehe Kopf von app/Partners.php und Punkt 3 in der README.
 * Zusätzlich hier: Es steht auf einer dunklen Platte in der Hausfarbe des
 * Betriebs, weil die Marke auf Weiß nicht lesbar wäre. Begründung bei
 * `.partner-logo--plate` in nd-base.css.
 */
$web = rtrim((string) $partner['url'], '/');

/* „Direkt zu moooov" als Kachelreihe, dieselben Kacheln wie auf den anderen
   Wegbegleiter-Seiten.

   Fünf Einträge sind Absicht: `.card-grid--5` fängt genau diese Zahl ab und
   setzt sie als 3 + 2 mit mittiger zweiter Zeile. Wer hier eine Kachel ergänzt
   oder streicht, nimmt den Modifier unten mit raus.

   Der Fahrschulwagen hat bewusst KEINE eigene Kachel, obwohl er der Punkt mit
   dem engsten Bezug zu Sarah ist: Er braucht einen Satz und nicht drei Wörter,
   und den bekommt er oben im Text. Sechs Kacheln wären hier der schlechtere
   Tausch, das Raster bricht dann in 4 + 2 mit angeschlagener zweiter Zeile.

   Alle Adressen am 20.08.2026 geprüft. Wer eine davon tot findet, nimmt die
   Kachel raus, statt eine neue Adresse zu erraten. */
$wege = [
    ['icon' => 'lever',     'titel' => 'KFZ-Umbau',      'text' => 'Handbedienung, Lenkhilfen, Pedalanpassungen, Drehsitze.', 'ziel' => $web . '/kfz-umbau/',                'label' => 'Umbauten ansehen'],
    ['icon' => 'check',     'titel' => 'Der Weg zum Führerschein', 'text' => 'Ihr Ablauf, vom Kostenträger bis zur Schlüsselzahl.', 'ziel' => $web . '/der-weg-zum-fuehrerschein/', 'label' => 'Den Ablauf lesen'],
    ['icon' => 'phone',     'titel' => 'Anrufen',        'text' => 'Die Werkstatt in Harsefeld.',                             'ziel' => 'tel:041662079985',                  'label' => '04166 2079985'],
    ['icon' => 'instagram', 'titel' => 'Instagram',      'text' => 'Umbauten und Fahrzeuge aus der Werkstatt.',               'ziel' => 'https://www.instagram.com/moooov.de/', 'label' => '@moooov.de'],
    ['icon' => 'road',      'titel' => 'Die ganze Seite','text' => 'Rollstühle, Outdoor, Mietwagen, Team und Kontakt.',       'ziel' => $partner['url'],                     'label' => 'moooov-mobility.de'],
];
?>
<section class="page-head">
    <div class="container">
        <?php /* Der Rückweg steht OBEN, wie bei allen anderen: Wer über die
                 Logo-Reihe hereinkommt, ist einen Klick von der Startseite weg
                 und soll ihn ohne Suchen zurückgehen können. */ ?>
        <p class="back-link">
            <a href="<?= url('/') ?>#wegbegleiter">&larr; Wegbegleiter</a>
        </p>
        <?php /* alt="" weil der Name als <h1> direkt darunter steht. Klasse und
                 Plattenfarbe kommen aus `Partners`, damit Kachel und Seitenkopf
                 dieselbe Quelle haben. */ ?>
        <img class="<?= e(Partners::logoClass($partner, 'partner-head-logo')) ?>"<?= Partners::logoPlateAttr($partner) ?>
             src="<?= asset('img/' . $partner['logo']) ?>" alt=""
             width="<?= (int) $partner['logo_width'] ?>"
             height="<?= (int) $partner['logo_height'] ?>">
        <h1><?= e($partner['name']) ?></h1>
        <p class="page-lead">
            Die Werkstatt, die Autos so umbaut, dass man sie fahren kann.
            Handbedienung, Lenkhilfen, Pedale an der richtigen Stelle. Zu finden
            in Harsefeld, also gleich um die Ecke.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="prose">
            <h2>Wer das ist</h2>
            <p>
                Die Moooov GmbH sitzt in der Marktstraße in Harsefeld und
                arbeitet an Mobilität für Menschen mit Handicap. Der größte Teil
                davon ist der KFZ-Umbau: Handbediengeräte für Gas und Bremse,
                Lenkhilfen und Multifunktionsdrehknöpfe, Pedalanpassungen,
                Hubdrehsitze, Kassettenlifte und Transferhilfen. Dazu kommen
                Rollstühle, Outdoor-Geräte und Mietwagen.
            </p>
            <?php /* Der Absatz mit dem engsten Bezug zu Sarah, deshalb steht er
                     hier und nicht in einer Kachel: Ein Fahrschulwagen mit
                     genau diesen Umbauten ist der Unterschied zwischen „geht
                     bei mir nicht" und einer Fahrstunde. Die vier Anpassungen
                     sind ihre Aufzählung, nicht meine. */ ?>
            <p>
                Für Fahrschulen gibt es dort einen angepassten Leihwagen, mit
                Handgas und Bremse, Multifunktionsdrehknopf, nach links
                verlegten Pedalen und Pedalverlängerung. Wer eine andere
                Ausstattung braucht, etwa Hebebühne oder leichtgängige Lenkung,
                kann danach fragen.
            </p>
            <?php /* Beschreibt, was auf IHRER Seite steht, und gibt keinen Rat
                     von Sarah. Der Punkt gehört trotzdem hierher: Er ist der
                     Grund, warum man diesen Betrieb kennt, bevor man sich
                     irgendwo anmeldet, und nicht danach. */ ?>
            <p>
                Auf ihrer Seite steht außerdem der ganze Weg zum Führerschein
                aufgeschrieben, vom Antrag beim Kostenträger über das
                medizinische und das technische Gutachten bis zu den
                Schlüsselzahlen im Führerschein. Nach ihrer Darstellung kommt
                der Kostenträger dabei vor die Anmeldung bei einer Fahrschule.
            </p>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Direkt zu moooov</h2>
            </div>
        </div>

        <?php /* Jede Kachel ist als Ganzes ein Link, deshalb
                 `feature-card--link` (nd-base.css) und kein zweiter Link im
                 Text darin. Die Telefonkachel öffnet keinen neuen Tab, `tel:`
                 verlässt den Browser ohnehin und ein leerer Tab bliebe
                 zurück. */ ?>
        <div class="card-grid card-grid--5">
            <?php foreach ($wege as $weg): ?>
                <?php $extern = !str_starts_with($weg['ziel'], 'tel:'); ?>
                <a class="feature-card feature-card--link" href="<?= e($weg['ziel']) ?>"
                   <?= $extern ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>
                    <span class="feature-icon"><?= icon($weg['icon']) ?></span>
                    <h3><?= e($weg['titel']) ?></h3>
                    <p><?= e($weg['text']) ?></p>
                    <span class="feature-meta">
                        <strong><?= e($weg['label']) ?><?= $extern ? ' &nearr;' : '' ?></strong>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

        <?php /* Die Herkunftsangabe steht IN diesem Abschnitt und nicht
                 dahinter: Sie gehört auf den Hintergrund des Moduls über ihr,
                 sonst sieht sie aus wie ein Nachtrag hinter der Trennlinie.
                 Wer die Seite überarbeitet, ändert das Datum mit. */ ?>
        <p class="source-note">
            Angaben von moooov-mobility.de und aus deren Impressum, Stand
            20.08.2026. Verbindlich ist, was dort steht. Logo und Name gehören
            der Moooov GmbH.
        </p>
    </div>
</section>
