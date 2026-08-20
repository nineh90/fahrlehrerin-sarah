<?php
/* WEGBEGLEITER · NILS-DIGITAL  (SAR-61)
 * -------------------------------------------------------------------------
 * Die Agentur, die diese Website gebaut hat. Der fünfte Eintrag und der
 * einzige, den man schon kennt, bevor man ihn anklickt: Der Streifen unter dem
 * Fuß sagt es auf jeder Seite, und im Impressum steht es auch.
 *
 * DAMIT SCHLIESST SICH EIN KREIS. Der Kommentar in layout.php nennt das alte
 * Credit-Band der Agentur (partials/nd-credit.php) ausdrücklich „die Vorlage
 * für das, was Sarah später als Wegbegleiter genannt hat". Aus dem Werbeband
 * mit Überschrift, Fließtext und zwei Knöpfen ist eine Kachel geworden, die
 * aussieht wie die der Fahrschule und die des Vereins.
 *
 * UND GENAU DESHALB IST DIESE SEITE KURZ. Sie steht auf der Website einer
 * Kundin. Was hier zu viel Eigenwerbung ist, fällt auf Sarah zurück, nicht auf
 * die Agentur. Also: wer das ist, was sie macht, wo man sie erreicht. Keine
 * Preise, keine Versprechen, keine Kundenstimmen. Die Referenzen bleiben auf
 * ihrer eigenen Seite und werden hier nicht nacherzählt.
 *
 * KEINE TELEFONKACHEL: Im Impressum steht keine Nummer, nur eine Adresse und
 * eine E-Mail. Erfunden wird keine.
 *
 * VIER KACHELN und nicht fünf, weil es nur vier Ziele gibt. Das Raster kommt
 * damit klar, `.card-grid` setzt vier nebeneinander. Der Modifier `--5` bleibt
 * hier deshalb weg.
 *
 * WOHER DIE ANGABEN STAMMEN: von nils-digital.de und aus deren Impressum,
 * abgerufen am 20.08.2026.
 *
 * DAS LOGO STEHT AUF EINER PLATTE, wie bei moooov und aus demselben Grund: Das
 * Türkis der Bildmarke kommt auf Weiß nur auf 2,9:1. Die Farbe ist die ihres
 * eigenen Seitenkopfs. Begründung bei `.partner-logo--plate` in nd-base.css.
 */
$web = rtrim((string) $partner['url'], '/');

/* „Direkt zu Nils-Digital" als Kachelreihe, dieselben Kacheln wie auf den
   anderen Wegbegleiter-Seiten.

   Alle Adressen am 20.08.2026 geprüft. Die Unterseiten liegen dort unter
   `/pages/…`, das ist kein Tippfehler. Wer eine Adresse tot findet, nimmt die
   Kachel raus, statt eine neue zu erraten. */
$wege = [
    ['icon' => 'sparkles',  'titel' => 'Projekte',        'text' => 'Was Nils sonst so gebaut hat.',            'ziel' => $web . '/pages/projekte.html', 'label' => 'Referenzen ansehen'],
    ['icon' => 'chat',      'titel' => 'Anfragen',        'text' => 'Formular für Projekte und Fragen.',        'ziel' => $web . '/pages/kontakt.html',  'label' => 'Zum Kontaktformular'],
    ['icon' => 'mail',      'titel' => 'Schreiben',       'text' => 'Die Adresse aus ihrem Impressum.',         'ziel' => 'mailto:info@nils-digital.de', 'label' => 'info@nils-digital.de'],
    ['icon' => 'extension', 'titel' => 'Die ganze Seite', 'text' => 'Leistungen, Referenzen und alles Weitere.', 'ziel' => $partner['url'],              'label' => 'nils-digital.de'],
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
            Die Werkstatt hinter dieser Website. Nils Nehring baut Webseiten und
            Anwendungen für kleine Betriebe und Selbstständige, und diese Seite
            hier ist eine davon.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="prose">
            <h2>Wer das ist</h2>
            <p>
                Nils-Digital sitzt in Ibbenbüren und wird von Nils Nehring
                geführt. Drei Bereiche stehen auf seiner Seite: Webentwicklung,
                individuelle Anwendungen und KI-Automatisierung. Was er dabei
                als Erstes über sich sagt, ist nicht die Technik, sondern dass
                man ihn direkt erreicht und kein Ticketsystem dazwischen steht.
            </p>
            <?php /* Der Satz, der die Verbindung herstellt, und der einzige,
                     der etwas über die Zusammenarbeit sagt. Er behauptet
                     nichts, was nicht ohnehin im Impressum und im Streifen
                     unter dem Fuß steht. */ ?>
            <p>
                Diese Website ist eines seiner Projekte, vom Entwurf bis zur
                Schaltzentrale, mit der Sarah ihre Termine verwaltet. Wer sich
                fragt, wer so etwas macht: der hier.
            </p>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Direkt zu Nils-Digital</h2>
            </div>
        </div>

        <?php /* Jede Kachel ist als Ganzes ein Link, deshalb
                 `feature-card--link` (nd-base.css) und kein zweiter Link im
                 Text darin. `mailto:` gilt wie `tel:` nicht als extern: Beide
                 verlassen den Browser, ein neuer Tab bliebe leer zurück. */ ?>
        <div class="card-grid">
            <?php foreach ($wege as $weg): ?>
                <?php $extern = !preg_match('/^(tel:|mailto:)/', $weg['ziel']); ?>
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
                 dahinter: Sie gehört auf den Hintergrund des Moduls über ihr.
                 Wer die Seite überarbeitet, ändert das Datum mit. */ ?>
        <p class="source-note">
            Angaben von nils-digital.de und aus deren Impressum, Stand
            20.08.2026. Verbindlich ist, was dort steht. Logo und Name gehören
            Nils Nehring.
        </p>
    </div>
</section>
