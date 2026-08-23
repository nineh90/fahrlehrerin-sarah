<?php
/* WEGBEGLEITER · FAHRSCHULE SANDER
 * -------------------------------------------------------------------------
 * Sarahs Arbeitgeberin und damit der erste Eintrag unter /wegbegleiter.
 *
 * WAS DIESE SEITE IST: eine Einordnung aus Sarahs Sicht. Wer der Betrieb ist,
 * wo er sitzt und wie man ihn erreicht. Sie ist KEIN zweiter Webauftritt der
 * Fahrschule. Alles, was sich ändern kann (Preise, Unterrichtszeiten,
 * Aktionen), steht bewusst nicht hier, sondern als Link dorthin: Eine
 * Preisangabe, die hier veraltet, ist schlimmer als keine.
 *
 * AUF DAS NÖTIGE ZUSAMMENGESTRICHEN (Kevin, 19.08.2026). Entfallen sind:
 *   · der Kasten „Ich verkaufe hier nichts". Genau das sagte damals
 *     `site-note.php` unter jeder Seite (entfallen am 22.08.2026), und der
 *     Vorspann oben sagt es ohnehin.
 *   · der Abschnitt „Was das für dich heißt" mit der Häkchenliste. Dieselbe
 *     Aufteilung („die Fahrschule übernimmt …") steht schon auf der
 *     Startseite und auf /kontakt.
 *   · die Pillenreihe mit allen 21 Ausbildungsklassen. Die Liste war lang,
 *     erklärte sich nicht von selbst und gehört der Fahrschule; jetzt steht
 *     der eine Satz oben im Text, der dasselbe sagt.
 *   · der Einordnungssatz unter „Acht Filialen".
 * Übrig bleiben drei Blöcke: wer das ist, wie man hinkommt, wo es sie gibt.
 *
 * WOHER DIE ANGABEN STAMMEN: von der Website der Fahrschule und aus deren
 * Impressum, abgerufen am 19.08.2026. Die Standortliste unten ist die
 * Impressumsliste; das ist die einzige Stelle, an der die Adressen
 * vollständig stehen. Wo die Fahrschule keine Postleitzahl nennt, steht hier
 * auch keine, erraten wird nichts.
 *
 * DAS LOGO DARF STEHEN: Sarah arbeitet für diese Fahrschule (geklärt am
 * 19.08.2026). Damit ist auch die offene Frage aus der README beantwortet, ob
 * die Fahrschule namentlich genannt werden darf. Sie darf, hier wie in
 * `SCHOOL_NAME`. Für jeden WEITEREN Wegbegleiter gilt die Frage neu.
 */
$web   = rtrim((string) $partner['url'], '/');
$stadt = (string) config('contact.city');

/* Die acht Filialen, Reihenfolge wie im Impressum der Fahrschule.
   Ort steht getrennt, weil er bei Bützfleth nicht der Filialname ist (die
   Filiale heißt Bützfleth, die Adresse liegt in Stade). Telefonnummern
   zweimal: einmal lesbar, einmal für den `tel:`-Link ohne Trenner. */
$filialen = [
    ['name' => 'Neu Wulmstorf',    'strasse' => 'Bahnhofstr. 24',          'ort' => '21629 Neu Wulmstorf', 'tel' => '040 700 66 88',   'wahl' => '0407006688'],
    ['name' => 'Elstorf',          'strasse' => 'Mühlenstr. 2f',           'ort' => 'Elstorf',             'tel' => '04168 90 07 66',  'wahl' => '04168900766'],
    ['name' => 'Hollenstedt',      'strasse' => 'Hauptstr. 9',             'ort' => 'Hollenstedt',         'tel' => '04165 22 27 66',  'wahl' => '04165222766'],
    ['name' => 'Buxtehude',        'strasse' => 'Felix-Wankel-Straße 34',  'ort' => 'Buxtehude',           'tel' => '04161 800 84 60', 'wahl' => '041618008460'],
    ['name' => 'Horneburg',        'strasse' => 'Bleiche 5',               'ort' => 'Horneburg',           'tel' => '04163 900 41 28', 'wahl' => '041639004128'],
    ['name' => 'Hamburg-Eißendorf','strasse' => 'Eißendorfer Str. 187',    'ort' => 'Hamburg',             'tel' => '040 38 08 88 28', 'wahl' => '04038088828'],
    ['name' => 'Stade',            'strasse' => 'Harsefelder Straße 14',   'ort' => 'Stade',               'tel' => '04141 77 77 85',  'wahl' => '04141777785'],
    ['name' => 'Bützfleth',        'strasse' => 'Obstmarschenweg 314',     'ort' => 'Stade',               'tel' => '04146 92 88 760', 'wahl' => '041469288760'],
];

/* „Direkt zur Fahrschule" als Kachelreihe.
   Vorher war das eine Karte mit fünf Zeilen Beschriftung und Link, gequetscht
   in die schmale Nebenspalte. Als die beiden Blöcke daneben entfielen, stand
   sie allein in einer halben Bildschirmbreite und sah aus wie übrig geblieben.
   Jetzt liegt sie über die volle Breite und benutzt dieselben Kacheln wie die
   Startseite, samt farbiger Kopfkante aus theme.css.

   Fünf Einträge sind Absicht und kein Zufall: `.card-grid--5` fängt genau
   diese Zahl ab und setzt sie als 3 + 2 mit mittiger zweiter Zeile. Wer hier
   einen Eintrag ergänzt oder streicht, nimmt den Modifier unten mit raus.

   Alle Adressen am 19.08.2026 geprüft. Wer eine davon tot findet, nimmt die
   Kachel raus, statt eine neue Adresse zu erraten. */
$wege = [
    ['icon' => 'check',    'titel' => 'Anmelden',         'text' => 'Anmeldung und Ausbildungsvertrag laufen über die Fahrschule.', 'ziel' => $web . '/anmelden/',           'label' => 'Zum Anmeldeformular'],
    ['icon' => 'calendar', 'titel' => 'Unterrichtszeiten','text' => 'Wann welcher Standort Theorie anbietet.',                      'ziel' => $web . '/unterrichtszeiten/', 'label' => 'Zeiten ansehen'],
    ['icon' => 'chat',     'titel' => 'Preise',           'text' => 'Preise legt die Fahrschule fest, nicht ich.',                  'ziel' => $web . '/preise/',            'label' => 'Preis anfragen'],
    ['icon' => 'phone',    'titel' => 'Büro anrufen',     'text' => 'Die Zentrale in ' . $stadt . '.',                              'ziel' => 'tel:0407006688',             'label' => '040 700 66 88'],
    ['icon' => 'car',      'titel' => 'Die ganze Seite',  'text' => 'Fahrzeuge, Kurse, Aktuelles und alles Weitere.',               'ziel' => $partner['url'],              'label' => 'fahrschule-sander.de'],
];
?>
<section class="page-head">
    <div class="container">
        <?php /* Der Rückweg steht OBEN und nicht unten: Wer hier über die
                 Logo-Reihe hereinkommt, ist einen Klick von der Startseite weg
                 und soll ihn ohne Suchen zurückgehen können. */ ?>
        <p class="back-link">
            <a href="<?= url('/') ?>#wegbegleiter">&larr; Wegbegleiter</a>
        </p>
        <?php /* Das Logo trägt hier alt="" weil der Name als <h1> direkt
                 darunter steht. Zweimal derselbe Name hintereinander
                 vorgelesen ist eine Dopplung, keine Information. */ ?>
        <img class="<?= e(Partners::logoClass($partner, 'partner-head-logo')) ?>"<?= Partners::logoPlateAttr($partner) ?>
             src="<?= asset('img/' . $partner['logo']) ?>" alt=""
             width="<?= (int) $partner['logo_width'] ?>"
             height="<?= (int) $partner['logo_height'] ?>">
        <h1><?= e($partner['name']) ?></h1>
        <p class="page-lead">
            Meine Fahrschule. Hier bin ich angestellt, und hier meldest du dich an,
            wenn du bei mir fahren möchtest.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="prose">
            <h2>Wer das ist</h2>
            <p>
                Die Fahrschule Sander GmbH sitzt in <?= e($stadt) ?> und ist mit acht
                Standorten zwischen Hamburg und Stade unterwegs, also genau in dem
                Gebiet, in dem ich auch fahre. Geführt wird sie von Malte Sander.
            </p>
            <?php /* Der Satz, der die Pillenreihe mit 21 Klassen ersetzt. Er sagt
                     dasselbe in einer Zeile und grenzt gleich mit ab, was Sarah
                     davon selbst macht. Ohne den zweiten Halbsatz liest sich der
                     erste, als könne sie alles unterrichten. */ ?>
            <p>
                Ausgebildet wird dort in allen Führerscheinklassen, vom Mofa bis zum
                Lastzug. Ich selbst unterrichte davon die Klassen B und BE, mit
                meinem Schwerpunkt auf der Ausbildung von Menschen mit Handicap.
            </p>
            <p>
                <strong>Der eine Satz, auf den es ankommt:</strong> Sag bei der Anmeldung,
                dass du bei mir fahren möchtest. Sonst landest du irgendwo in der
                Ausbildung, und das kann dir dort niemand ansehen.
            </p>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Direkt zur Fahrschule</h2>
            </div>
        </div>

        <?php /* Jede Kachel ist als Ganzes ein Link, deshalb `feature-card--link`
                 (nd-base.css) und kein zweiter Link im Text darin. Die vier
                 externen führen auf die Seite der Fahrschule und öffnen im neuen
                 Tab; die Telefonkachel nicht, `tel:` verlässt den Browser
                 ohnehin und ein leerer Tab bliebe zurück. */ ?>
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
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Acht Filialen zwischen Hamburg und Stade</h2>
            </div>
        </div>

        <ul class="branch-grid">
            <?php foreach ($filialen as $filiale): ?>
                <li class="branch">
                    <strong><?= e($filiale['name']) ?></strong>
                    <span><?= e($filiale['strasse']) ?></span>
                    <span><?= e($filiale['ort']) ?></span>
                    <a href="tel:<?= e(preg_replace('/\s+/', '', $filiale['wahl'])) ?>"><?= e($filiale['tel']) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <p class="muted" style="margin-top:1.6rem;">
            Alle Filialen mit Öffnungszeiten:
            <a href="<?= e($web . '/filialen/') ?>" target="_blank" rel="noopener noreferrer">auf der Seite der Fahrschule</a>.
        </p>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Du willst bei mir fahren?</h2>
                <p>
                    Dann melde dich bei der Fahrschule an und sag, dass du zu mir
                    möchtest. Wenn du vorher noch etwas wissen willst: Ruf mich an,
                    ich sage dir ehrlich, ob ich die Richtige für dich bin.
                </p>
            </div>
            <div class="hero-actions">
                <a class="btn btn-primary btn-lg" href="<?= url('/kontakt') ?>">Kontakt</a>
                <a class="btn btn-ghost btn-lg" href="<?= e($web . '/anmelden/') ?>"
                   target="_blank" rel="noopener noreferrer">Zur Anmeldung &nearr;</a>
            </div>
        </div>
    </div>
</section>

<section class="section section--footnote">
    <div class="container">
        <?php /* Die Herkunftsangabe. Sie steht hier, weil auf dieser Seite fremde
                 Angaben stehen: Adressen, Telefonnummern, ein Angebot. Wer sie
                 liest, soll wissen, wie alt sie sind und wo das Verbindliche
                 steht. Wer die Seite überarbeitet, ändert das Datum mit.

                 Form und Abstände stecken seit dem 20.08.2026 in `.source-note`
                 (nd-base.css) statt in Inline-Styles. Beide Wegbegleiter-Seiten
                 enden damit gleich. */ ?>
        <p class="source-note">
            Angaben von der Website und aus dem Impressum der Fahrschule Sander,
            Stand 19.08.2026. Verbindlich ist, was dort steht. Logo und Name
            gehören der Fahrschule Sander GmbH.
        </p>
    </div>
</section>
