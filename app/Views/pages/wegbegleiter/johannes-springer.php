<?php
/* WEGBEGLEITER · JOHANNES SPRINGER STUDIO  (SAR-60)
 * -------------------------------------------------------------------------
 * Videograf in Lilienthal bei Bremen. Der sechste Eintrag unter /wegbegleiter.
 *
 * KURZ WIE DIE ANDEREN: wer das ist, wie man hinkommt, woher die Angaben
 * stammen. Kein zweiter Webauftritt, keine Preise, keine Leistungsbeschreibung
 * in voller Länge. Was sich ändert, steht als Link dorthin.
 *
 * SEINE SEITE IST NEU UND NOCH NICHT FERTIG, Stand 20.08.2026. Im Kontaktteil
 * steht wörtlich „E-Mail-Adresse wird noch eingerichtet", und im Quelltext
 * seiner strukturierten Daten steht als offener Punkt, die Instagram-Adresse
 * zu ergänzen, „sobald das Profil steht". Deshalb hier weder Mail- noch
 * Instagram-Kachel. Die Telefonnummer aus seinem Impressum ist der einzige
 * direkte Weg, den es heute gibt; kommen die anderen dazu, gehören sie hier
 * nachgetragen.
 *
 * DASS ER IM ROLLSTUHL SITZT, steht hier, weil ER es auf seiner Seite an
 * prominenter Stelle selbst erzählt, und in seinen Worten: Er hat sich ein
 * System gebaut, mit dem er vom Rollstuhl aus eine Kamera voll bedient. Auf
 * Sarahs Seite ist das keine Randnotiz, sondern derselbe Gedanke wie in ihren
 * Umbau-Karten: Technik so anpassen, dass es geht. Kein Mitleid, keine
 * Heldengeschichte, ein Satz zur Sache.
 *
 * NICHT „UM DIE ECKE": Lilienthal liegt bei Bremen und damit rund 90 km von
 * Sarahs Gebiet entfernt. Anders als bei moooov steht hier deshalb kein Satz
 * über die kurze Anfahrt.
 *
 * WOHER DIE ANGABEN STAMMEN: von johannes-springer.studio und aus dem dortigen
 * Impressum, abgerufen am 20.08.2026.
 *
 * ZUM LOGO: Es gibt dort keine Wortmarke als Datei, nur das Favicon. Warum hier
 * trotzdem nichts nachgebaut wird, steht bei diesem Eintrag in Partners.php.
 */
$web = rtrim((string) $partner['url'], '/');

/* „Direkt zu Johannes" als Kachelreihe, dieselben Kacheln wie auf den anderen
   Wegbegleiter-Seiten.

   VIER KACHELN, weil es nur vier Ziele gibt. Das Raster kommt damit klar,
   `.card-grid` setzt vier nebeneinander; der Modifier `--5` bleibt weg.

   Seine Seite ist ein Einseiter, die ersten beiden Kacheln führen deshalb auf
   Sprungmarken darin und nicht auf eigene Seiten. Das ist kein Notbehelf: Der
   Text dort ist lang, und wer wissen will, was er anbietet, landet so direkt
   im richtigen Absatz statt oben im Vorspann.

   Alle Adressen am 20.08.2026 geprüft. Wer eine tot findet, nimmt die Kachel
   raus, statt eine neue zu erraten. */
$wege = [
    ['icon' => 'sparkles', 'titel' => 'Leistungen',    'text' => 'Videos, kurze Clips, Livestreams von Veranstaltungen.', 'ziel' => $web . '/#leistungen', 'label' => 'Die drei Formate'],
    ['icon' => 'thumb',    'titel' => 'Über ihn',      'text' => 'Wie er arbeitet und wie er dazu gekommen ist.',         'ziel' => $web . '/#ueber-mich', 'label' => 'Seine Geschichte'],
    ['icon' => 'phone',    'titel' => 'Anrufen',       'text' => 'Die Nummer aus seinem Impressum.',                      'ziel' => 'tel:01703836807',     'label' => '0170 3836807'],
    ['icon' => 'road',     'titel' => 'Die ganze Seite','text' => 'Beispiele, Kontakt und alles Weitere.',                'ziel' => $partner['url'],       'label' => 'johannes-springer.studio'],
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
        <?php /* alt="" weil der Name als <h1> direkt darunter steht – und das
                 wiegt hier schwerer als bei den anderen: Seit dem 21.08.2026
                 (SAR-60) steht im Logo derselbe Name noch einmal, diesmal
                 gezeichnet. Mit einem alt-Text hörte man ihn zweimal.

                 Die Klasse kommt aus `Partners`: Die Wortmarke ist breit und
                 wird deshalb wie jede andere Wortmarke behandelt, dazu die
                 Platte in seinem Seitengrund – ihre Schrift ist Creme und wäre
                 auf hellem Grund nicht zu sehen. */ ?>
        <img class="<?= e(Partners::logoClass($partner, 'partner-head-logo')) ?>"<?= Partners::logoPlateAttr($partner) ?>
             src="<?= asset('img/' . $partner['logo']) ?>" alt=""
             width="<?= (int) $partner['logo_width'] ?>"
             height="<?= (int) $partner['logo_height'] ?>">
        <h1><?= e($partner['name']) ?></h1>
        <p class="page-lead">
            Videograf aus Lilienthal bei Bremen. Er macht Erklärvideos, kurze
            Clips für Social Media und überträgt Veranstaltungen live.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="prose">
            <h2>Wer das ist</h2>
            <p>
                Johannes Springer hat mit dem Filmen als Hobby angefangen und
                macht es inzwischen beruflich. Drei Formate stehen auf seiner
                Seite: längere Videos, mit denen sich jemand nach außen zeigt,
                kurze Clips für Instagram, TikTok und YouTube, und
                Mehrkamera-Livestreams von Veranstaltungen. Letztere bisher vor
                allem aus dem Sport, bis hin zu Deutschen Meisterschaften.
            </p>
            <?php /* Sein eigener Satz, sinngemäß: „Vor allem bin ich ein
                     Problemlöser." Das Kamerasystem nennt er im selben Atemzug.
                     Es steht hier, weil es auf Sarahs Seite unter allen Sätzen
                     über ihn der ist, der am meisten mit ihrer Arbeit zu tun
                     hat: eine Technik, die jemand sich baut, damit es geht. */ ?>
            <p>
                Er beschreibt sich selbst als Problemlöser, und das fängt bei
                seiner eigenen Ausrüstung an: An seinem Rollstuhl arbeitet er
                mit einem selbst entwickelten System, mit dem er eine Kamera
                voll bedient. Nebenbei ist er Spieler und Trainer im
                Rollstuhlbasketball, und über den Sport ist er überhaupt erst
                zum Livestreaming gekommen.
            </p>
            <p>
                Aus seinen Jahren im sozialen Bereich hat er außerdem
                mitgenommen, dass er Projekte dort besonders gern unterstützt.
                Ein Angebot macht er nach eigener Angabe kostenlos und
                unverbindlich.
            </p>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Direkt zu Johannes</h2>
            </div>
        </div>

        <?php /* Jede Kachel ist als Ganzes ein Link, deshalb
                 `feature-card--link` (nd-base.css) und kein zweiter Link im
                 Text darin. Die Telefonkachel öffnet keinen neuen Tab, `tel:`
                 verlässt den Browser ohnehin und ein leerer Tab bliebe
                 zurück. */ ?>
        <div class="card-grid">
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
                 dahinter: Sie gehört auf den Hintergrund des Moduls über ihr.
                 Wer die Seite überarbeitet, ändert das Datum mit. */ ?>
        <p class="source-note">
            Angaben von johannes-springer.studio und aus dem dortigen Impressum,
            Stand 20.08.2026. Verbindlich ist, was dort steht. Name und
            Bildmarke gehören Johannes Springer.
        </p>
    </div>
</section>
