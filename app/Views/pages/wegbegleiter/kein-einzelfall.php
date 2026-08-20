<?php
/* WEGBEGLEITER · KE!N EINZELFALL e.V.  (SAR-63)
 * -------------------------------------------------------------------------
 * Der dritte Eintrag unter /wegbegleiter und der erste, der kein Betrieb ist,
 * sondern ein gemeinnütziger Verein: Opferhilfe aus Hamburg, gegründet 2024.
 *
 * KURZ WIE DIE ANKERLIEBE-SEITE: wer das ist, wie man hinkommt, woher die
 * Angaben stammen. Diese Seite ist ein Verweis und keine zweite Website des
 * Vereins. Was sich ändert (Termine, Gruppen, Veranstaltungen), steht als Link
 * dorthin und nicht hier.
 *
 * BEIM TON AUFPASSEN. Es geht um Menschen, die Gewalt oder andere schädigende
 * Taten erlebt haben. Die Seite bleibt deshalb sachlich und beschreibt, was der
 * Verein tut. Keine Betroffenheitsprosa, keine Beispiele, keine Zahlen zu
 * Taten. Alles, was hier steht, ist die Selbstbeschreibung des Vereins von
 * seiner eigenen Seite. Ausgedacht wird nichts.
 *
 * KEINE ABGRENZUNG UND KEINE HINWEISE (Kevin, 20.08.2026). Hier stand ein Satz
 * „Ich bin Fahrlehrerin und keine Beratungsstelle"; er ist raus, und zwar als
 * Regel für alle Wegbegleiter-Seiten und nicht nur für diese. So eine Seite
 * beschreibt einen Betrieb und verlinkt ihn. Wer Sarah ist und was sie nicht
 * ist, steht auf ihren eigenen Seiten und gehört nicht unter fremde Logos.
 *
 * DER SATZ, DER DIE VERBINDUNG HERSTELLT, steht im Vorspann („also der
 * Papierkram …"). Er ist die einzige Stelle, die etwas über den Zusammenhang
 * mit Sarahs Arbeit sagt, und er ist aus dem Angebot des Vereins geschlossen
 * und nicht von Sarah bestätigt. In einer Zeile austauschbar.
 *
 * WOHER DIE ANGABEN STAMMEN: von kein-einzelfall.de und aus deren Impressum,
 * abgerufen am 20.08.2026. Der Leitsatz unten ist ein wörtliches Zitat von der
 * Startseite des Vereins, deshalb steht er auch als Zitat da.
 *
 * DAS LOGO IST NOCH NICHT FREIGEGEBEN, Stand 20.08.2026, genau wie bei
 * Ankerliebe. Siehe Kopf von app/Partners.php und Punkt 3 in der README.
 */
$web = rtrim((string) $partner['url'], '/');

/* „Direkt zum Verein" als Kachelreihe, dieselben Kacheln wie auf den beiden
   anderen Wegbegleiter-Seiten.

   Fünf Einträge sind Absicht: `.card-grid--5` fängt genau diese Zahl ab und
   setzt sie als 3 + 2 mit mittiger zweiter Zeile. Wer hier eine Kachel ergänzt
   oder streicht, nimmt den Modifier unten mit raus.

   Bewusst KEINE Spendenkachel, obwohl der Verein eine Spendenseite hat: Diese
   Reihe ist für Leute da, die Hilfe suchen, und eine Bitte um Geld dazwischen
   liest sich falsch. Wer spenden will, findet den Weg über die letzte Kachel.

   Alle Adressen am 20.08.2026 geprüft. Wer eine davon tot findet, nimmt die
   Kachel raus, statt eine neue Adresse zu erraten. */
$wege = [
    ['icon' => 'chat',      'titel' => 'Selbsthilfegruppen', 'text' => 'Kostenfrei und nicht an eine Mitgliedschaft gebunden.',        'ziel' => $web . '/selbsthilfegruppen/', 'label' => 'Gruppen ansehen'],
    ['icon' => 'shield',    'titel' => 'Anfragen',           'text' => 'Zu Entschädigungsrecht, Schwerbehindertenausweis, Pflegegrad.', 'ziel' => $web . '/anfragen/',           'label' => 'Anfrage stellen'],
    ['icon' => 'extension', 'titel' => 'Wissen',             'text' => 'Erklärt, wie das Hilfesystem funktioniert.',                   'ziel' => $web . '/wissen/',             'label' => 'Zum Wissensbereich'],
    ['icon' => 'mail',      'titel' => 'Schreiben',          'text' => 'Antworten tut der Verein, nicht ich.',                         'ziel' => 'mailto:kontakt@kein-einzelfall.de', 'label' => 'kontakt@kein-einzelfall.de'],
    ['icon' => 'heart',     'titel' => 'Die ganze Seite',    'text' => 'Verein, Veranstaltungen, Mitgliedschaft und alles Weitere.',   'ziel' => $partner['url'],               'label' => 'kein-einzelfall.de'],
];
?>
<section class="page-head">
    <div class="container">
        <?php /* Der Rückweg steht OBEN, wie bei den anderen beiden: Wer über
                 die Logo-Reihe hereinkommt, ist einen Klick von der Startseite
                 weg und soll ihn ohne Suchen zurückgehen können. */ ?>
        <p class="back-link">
            <a href="<?= url('/') ?>#wegbegleiter">&larr; Wegbegleiter</a>
        </p>
        <?php /* alt="" weil der Name als <h1> direkt darunter steht. Die Klasse
                 kommt aus `Partners`: Dieses Logo ist quadratisch und bekommt
                 deshalb mehr Höhe als eine Wortmarke. */ ?>
        <img class="<?= e(Partners::logoClass($partner, 'partner-head-logo')) ?>"<?= Partners::logoPlateAttr($partner) ?>
             src="<?= asset('img/' . $partner['logo']) ?>" alt=""
             width="<?= (int) $partner['logo_width'] ?>"
             height="<?= (int) $partner['logo_height'] ?>">
        <h1><?= e($partner['name']) ?></h1>
        <p class="page-lead">
            Ein Hamburger Verein für Opferhilfe. Er berät unter anderem zum
            Schwerbehindertenausweis und zum Pflegegrad, also zu dem Papierkram,
            der bei manchen lange vor der ersten Fahrstunde liegt.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="prose">
            <h2>Wer das ist</h2>
            <p>
                KE!N EINZELFALL e.V. wurde 2024 in Hamburg gegründet, aus
                persönlicher Betroffenheit heraus und mit dem Ziel, von
                schädigenden Taten betroffene Menschen nicht länger allein zu
                lassen. Der Verein ist da für Betroffene und Angehörige, für
                Interessierte und für Fachleute.
            </p>
            <?php /* Der Leitsatz wörtlich von der Startseite des Vereins,
                     im Fließtext und ausdrücklich als ihr Satz gekennzeichnet.

                     BEWUSST NICHT als `.quote`: Dieses Element ist laut seinem
                     eigenen Kommentar in nd-base.css „ein Satz in Sarahs
                     Stimme". Ein fremder Leitsatz in Sarahs Zitatform gelesen
                     wird zu Sarahs Aussage, und groß und mittig gesetzt würde
                     er die Seite übernehmen, auf der er nur zitiert ist. */ ?>
            <p>
                Ihr Leitsatz steht ganz oben auf ihrer Seite: „Keiner soll mehr
                sagen müssen: ‚Ich hab es nicht gewusst!‘“
            </p>
            <p>
                Angeboten werden Selbsthilfegruppen, die kostenfrei sind und
                keine Mitgliedschaft voraussetzen, Arbeitsgruppen für alle, die
                mitarbeiten möchten, und Aufklärung zum Hilfesystem. Wer Fragen
                zum Sozialen Entschädigungsrecht, zum Schwerbehindertenausweis
                oder zum Pflegegrad hat, kann sich damit an den Verein wenden.
            </p>
            <?php /* Hier stand bis zum 20.08.2026 eine Abgrenzung: „Ich bin
                     Fahrlehrerin und keine Beratungsstelle." Raus auf Kevins
                     Wunsch, und mit einer Ansage, die über diese Seite
                     hinausgeht: Solche Sätze braucht es auf den Seiten der
                     Wegbegleiter nicht. Dieselbe Entscheidung traf kurz vorher
                     schon den Stufen-Hinweis auf der Ankerliebe-Seite.

                     Die Regel dahinter: Eine Wegbegleiter-Seite beschreibt
                     einen Betrieb und verlinkt ihn, mehr nicht. Was Sarah ist
                     und was sie nicht ist, steht auf ihren eigenen Seiten. */ ?>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Direkt zum Verein</h2>
            </div>
        </div>

        <?php /* Jede Kachel ist als Ganzes ein Link, deshalb
                 `feature-card--link` (nd-base.css) und kein zweiter Link im
                 Text darin.

                 `mailto:` steht hier neben `tel:` in derselben Prüfung: Beide
                 verlassen den Browser und übergeben an ein anderes Programm.
                 Ein neuer Tab bliebe dabei leer zurück, und ein Pfeil „führt
                 nach draußen" verspricht eine Seite, die nie kommt. */ ?>
        <div class="card-grid card-grid--5">
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
                 dahinter, aus demselben Grund wie bei Ankerliebe: Sie gehört
                 auf den Hintergrund des Moduls über ihr, sonst sieht sie aus
                 wie ein Nachtrag hinter der Trennlinie. Wer die Seite
                 überarbeitet, ändert das Datum mit.

                 Ohne Registernummer und Anschrift des Vereins: Das ist sein
                 Impressum und nicht Sarahs, es steht vollständig auf seiner
                 eigenen Seite. */ ?>
        <p class="source-note">
            Angaben von kein-einzelfall.de und aus deren Impressum, Stand
            20.08.2026. Verbindlich ist, was dort steht. Logo und Name gehören
            dem Verein.
        </p>
    </div>
</section>
