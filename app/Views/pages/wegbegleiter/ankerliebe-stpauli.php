<?php
/* WEGBEGLEITER · ANKERLIEBE ST. PAULI  (SAR-64)
 * -------------------------------------------------------------------------
 * Der zweite Eintrag unter /wegbegleiter und der erste, der nichts mit
 * Fahrschule zu tun hat: Ricarda Belmar vermietet auf St. Pauli möblierte
 * Apartments.
 *
 * BEWUSST KURZ (Kevin, 20.08.2026). Die Seite der Fahrschule Sander ist lang,
 * weil dort die Anmeldung läuft und acht Filialen zu nennen sind. Hier gibt es
 * genau drei Dinge zu sagen: wer das ist, wie man hinkommt, woher die Angaben
 * stammen. Kein zweiter Webauftritt, keine Preise, keine Belegung. Alles, was
 * sich ändert, steht als Link dorthin. Eine Preisangabe, die hier veraltet,
 * ist schlimmer als keine.
 *
 * DER SATZ, DER DIE VERBINDUNG BEHAUPTET, ist der zweite im Vorspann („Wer von
 * weiter weg kommt …"). Er ist die EINZIGE Stelle auf dieser Seite, die etwas
 * über die Zusammenarbeit sagt, und er stammt nicht von Sarah, sondern ist aus
 * dem Auftrag geschlossen. Sarah gehört gefragt, ob er stimmt; falsch ist er in
 * einer Zeile ersetzt, ohne dass der Rest wackelt.
 *
 * WOHER DIE ANGABEN STAMMEN: von ankerliebe-stpauli.de und aus deren Impressum,
 * abgerufen am 20.08.2026. Die Anschrift ist die aus dem Impressum. Auf der
 * Seite „Über uns" steht als Lage die Herbertstraße, im Impressum die
 * Erichstraße; hier steht die Impressumsanschrift, geraten wird nichts.
 *
 * DAS LOGO IST NOCH NICHT FREIGEGEBEN, Stand 20.08.2026. Für die Fahrschule
 * Sander ist das geklärt, weil Sarah dort arbeitet. Hier gilt die Frage neu
 * (siehe Kopf von app/Partners.php und Punkt 3 in der README), denn ein fremdes
 * Logo zu zeigen ist eine Nutzung und kein Zitat.
 */
$web = rtrim((string) $partner['url'], '/');

/* „Direkt zu Ankerliebe" als Kachelreihe, dieselben Kacheln wie auf der Seite
   der Fahrschule und wie auf der Startseite.

   Fünf Einträge sind Absicht: `.card-grid--5` fängt genau diese Zahl ab und
   setzt sie als 3 + 2 mit mittiger zweiter Zeile. Wer hier eine Kachel ergänzt
   oder streicht, nimmt den Modifier unten mit raus.

   Alle Adressen am 20.08.2026 geprüft. Wer eine davon tot findet, nimmt die
   Kachel raus, statt eine neue Adresse zu erraten. */
$wege = [
    ['icon' => 'pin',       'titel' => 'Die Apartments',  'text' => 'Fünf Wohnungen, alle im selben Haus.',                'ziel' => $web . '/rooms/',           'label' => 'Wohnungen ansehen'],
    ['icon' => 'mail',      'titel' => 'Anfragen',        'text' => 'Belegung und Preise laufen über ihr Formular.',       'ziel' => $web . '/anfrageformular/', 'label' => 'Zum Anfrageformular'],
    ['icon' => 'phone',     'titel' => 'Anrufen',         'text' => 'Dieselbe Nummer nimmt auch WhatsApp an.',             'ziel' => 'tel:+4915221597522',       'label' => '+49 152 2159 7522'],
    ['icon' => 'instagram', 'titel' => 'Instagram',       'text' => 'Ricarda zeigt dort ihre Wohnungen und den Kiez.',     'ziel' => 'https://www.instagram.com/ricarda_belmar', 'label' => '@ricarda_belmar'],
    ['icon' => 'heart',     'titel' => 'Die ganze Seite', 'text' => 'Ausstattung, Lage und alles Weitere.',                'ziel' => $partner['url'],            'label' => 'ankerliebe-stpauli.de'],
];
?>
<section class="page-head">
    <div class="container">
        <?php /* Der Rückweg steht OBEN, aus demselben Grund wie beim ersten
                 Wegbegleiter: Wer über die Logo-Reihe hereinkommt, ist einen
                 Klick von der Startseite weg und soll ihn ohne Suchen
                 zurückgehen können. */ ?>
        <p class="back-link">
            <a href="<?= url('/') ?>#wegbegleiter">&larr; Wegbegleiter</a>
        </p>
        <?php /* alt="" weil der Name als <h1> direkt darunter steht. Zweimal
                 derselbe Name hintereinander vorgelesen ist eine Dopplung,
                 keine Information. */ ?>
        <img class="<?= e(Partners::logoClass($partner, 'partner-head-logo')) ?>"<?= Partners::logoPlateAttr($partner) ?>
             src="<?= asset('img/' . $partner['logo']) ?>" alt=""
             width="<?= (int) $partner['logo_width'] ?>"
             height="<?= (int) $partner['logo_height'] ?>">
        <h1><?= e($partner['name']) ?></h1>
        <p class="page-lead">
            Ricarda Belmar vermietet mitten auf St. Pauli möblierte Apartments.
            Wer von weiter weg zum Fahren nach Hamburg kommt, hat bei ihr ein
            Bett und muss nicht jeden Abend zurück.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="prose">
            <h2>Wer das ist</h2>
            <p>
                Ricarda Belmar ist auf dem Kiez aufgewachsen, gelernte
                Hotelfachfrau und hat im Hostel angefangen. 2012 hat sie
                zusammen mit ihrem Mann Ankerliebe St. Pauli gegründet und
                Gewerberäume zu Wohnungen umgebaut.
            </p>
            <p>
                Heute sind es fünf Apartments in der Erichstraße, ein paar
                Schritte von der Reeperbahn: je ein Schlafraum, Küchenzeile,
                Bad und Wohnbereich, dazu WLAN und Fernseher. Gedacht sind sie
                für ein Wochenende genauso wie für ein paar Wochen, und
                hineinkommen kann man auch ohne Empfang, der Schlüssel liegt im
                Kasten.
            </p>
            <?php /* Hier stand bis zum 20.08.2026 ein dritter Absatz: „Vorher
                     fragen, wenn du Stufen nicht magst" – der Hinweis, dass
                     auf der Seite von Ankerliebe nirgends steht, wie die
                     Wohnungen zu erreichen sind. Raus auf Kevins Wunsch. Die
                     Seite ist ein Verweis auf einen Betrieb und keine
                     Beratung zu dessen Räumen; wer eine Wohnung mietet, klärt
                     so etwas ohnehin mit der Vermieterin, und die steht eine
                     Kachel weiter unten mit Telefonnummer. */ ?>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Direkt zu Ankerliebe</h2>
            </div>
        </div>

        <?php /* Jede Kachel ist als Ganzes ein Link, deshalb
                 `feature-card--link` (nd-base.css) und kein zweiter Link im
                 Text darin. Die vier externen öffnen im neuen Tab; die
                 Telefonkachel nicht, `tel:` verlässt den Browser ohnehin und
                 ein leerer Tab bliebe zurück. */ ?>
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

        <?php /* Die Herkunftsangabe, wie beim ersten Wegbegleiter. Sie steht
                 hier, weil auf dieser Seite fremde Angaben stehen. Wer sie
                 liest, soll wissen, wie alt sie sind und wo das Verbindliche
                 steht. Wer die Seite überarbeitet, ändert das Datum mit.

                 SIE STEHT IN DIESEM ABSCHNITT UND NICHT DAHINTER (Kevin,
                 20.08.2026). Als eigener Abschnitt lag sie hinter der
                 Trennlinie von `.section--alt`, auf einer frisch angefangenen
                 Fläche, und sah aus wie ein Nachtrag von jemand anderem. Auf
                 der Sander-Seite fiel das nicht auf: Dort steht davor ein
                 `.cta-band` ohne eigenen Hintergrund, der Seitengrund läuft
                 also durch bis zur Fußnote. Hier gibt es keinen durchlaufenden
                 Grund, also gehört sie auf den des Moduls über ihr.

                 KÜRZER SEIT DEM 20.08.2026: Hier standen zusätzlich Rechtsform
                 und Anschrift der Vermieterin. Das ist ein halbes Impressum,
                 und zwar ein fremdes. Es steht vollständig auf ihrer eigenen
                 Seite, die von hier aus dreimal verlinkt ist. */ ?>
        <p class="source-note">
            Angaben von ankerliebe-stpauli.de und aus deren Impressum, Stand
            20.08.2026. Verbindlich ist, was dort steht. Logo und Name gehören
            Ankerliebe St. Pauli.
        </p>
    </div>
</section>
