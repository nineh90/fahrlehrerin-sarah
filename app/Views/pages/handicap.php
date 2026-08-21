<?php $school = (string) config('school.name'); ?>
<section class="page-head">
    <div class="container">
        <h1>Fahren mit Handicap</h1>
        <p class="page-lead">
            Mit Kleinwuchs, nach einem Unfall oder mit einer Einschränkung, die dir
            jemand als Ausschlussgrund verkauft hat:
            Lass uns darüber reden, bevor du es abhakst.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="duo">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-teal);">
                <figure class="photo">
                    <img src="<?= asset('img/handicap-linksgas.jpg') ?>"
                         alt="Fußraum eines Fahrschulautos mit Linksgas-Umbau: links neben der
                              Bremse sitzt ein zusätzliches Gaspedal, das über ein grünes
                              Gestänge mit dem originalen Gaspedal verbunden ist"
                         width="1400" height="1050">
                </figure>
            </div>

            <div class="duo-text">
                <h2>Ein angepasstes Auto fährt sich anders, nicht schwerer</h2>
                <?php /* SAR-52, Sarahs Fassung. Hier standen drei Absätze; der erste
                         („Die meisten, die zu mir kommen, haben denselben Satz im
                         Kopf: ‚Ob das überhaupt geht?'") ist mit dem Ticket
                         entfallen. Er war kein Verlust an dieser Stelle: Die
                         Seite beantwortet dieselbe Frage schon im Vorspann oben
                         („bevor du es abhakst") und noch einmal im Ablauf weiter
                         unten. Was übrig bleibt, beschreibt das Foto daneben,
                         und genau dafür steht der Text hier.

                         Zwei Absätze und nicht einer, obwohl Sarah es am Stück
                         geschrieben hat: Die ersten drei Sätze erklären die
                         Technik auf dem Bild, der letzte sagt, wie sie
                         unterrichtet. Am Stück gesetzt liest sich das in einer
                         schmalen Spalte neben einem Foto als ein Block, in dem
                         der letzte Satz untergeht. Wortlaut und Reihenfolge sind
                         unverändert. */ ?>
                <p>
                    Das Foto zeigt einen Linksgas-Umbau. Dabei wird das Gas von rechts
                    auf links mechanisch umgelegt. Das rechte Pedal ist dann für den
                    Gebrauch blockiert.
                </p>
                <p>
                    Ich erkläre dir die Bedienelemente in Ruhe und wir fahren so lange
                    damit, bis es sich für dich völlig normal anfühlt.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Womit wir arbeiten</h2>
            </div>
        </div>

        <?php /* SAR-53: DIESE KARTEN BESCHREIBEN TECHNIK, KEINE KÖRPER.
                 Zwei von ihnen taten bis zum 19.08.2026 beides. „Wenn der
                 rechte Fuß nicht mitmacht" und „wenn die zweite Hand nicht
                 mitarbeiten kann" klingen im ersten Moment schonend, sind es
                 aber nicht: Beide setzen voraus, dass die Gliedmaße da ist und
                 sich nur weigert. Wer ohne rechtes Bein hier liest, bekommt
                 seinen Alltag als Unlust beschrieben. Dazu kam ein dritter
                 Satz, „schwierig ist am Anfang nur, den rechten Fuß stillhalten
                 zu lassen", der dieselbe Voraussetzung macht.

                 Die Regel für alles, was hier künftig dazukommt: Sag, was der
                 Umbau TUT und wie gefahren wird. Wer ihn braucht, weiß das
                 selbst und muss es nicht von einer Website erklärt bekommen.
                 Kein „wenn X nicht mehr geht", kein „trotz", kein „leider".

                 Die Startseite war davon nicht betroffen, ihre Handicap-Karte
                 spricht schon von Kleinwuchs und eingeschränkter Beweglichkeit
                 statt von Körperteilen. */ ?>
        <div class="card-grid">
            <article class="feature-card">
                <span class="feature-icon"><?= icon('pedal') ?></span>
                <h3>Linksgas</h3>
                <p>
                    Das Gaspedal sitzt links neben der Bremse, gefahren wird mit dem
                    linken Fuß. Der Umbau ist klein, und die Umstellung geht schneller,
                    als die meisten erwarten.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('knob') ?></span>
                <h3>Lenkraddrehknopf</h3>
                <p>
                    Ein Knauf auf dem Lenkradkranz, mit dem sich das Lenkrad sicher mit
                    einer Hand führen lässt. Nach zwei, drei Stunden fühlt es sich
                    normal an.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('lever') ?></span>
                <h3>Handbedienung</h3>
                <p>
                    Gas und Bremse über einen Hebel statt über die Pedale. Braucht am
                    Anfang Konzentration, wird aber schnell zur Gewohnheit.
                </p>
            </article>

            <?php /* Hier stand bis zum 17.08.2026 „Prothesenfahren". Auf Wunsch
                     entfallen (SAR-43), samt Icon und allen Nennungen im Rest der
                     Seite. An seine Stelle tritt der Umbau, um den es bei Kleinwuchs
                     geht – die Startseite nennt ihn seit SAR-43, und ohne diese Karte
                     verspräche sie etwas, das die Detailseite nicht kennt.

                     ENTWURF, nicht von Sarah – wie alles hier, was nicht ausdrücklich
                     als ihr Text markiert ist. Der Text bleibt bewusst bei dem, was
                     technisch allgemein gilt (Aufsätze, Sitzhöhe, Sichtlinie);
                     welche Systeme sie konkret im Auto hat, muss sie ergänzen. */ ?>
            <article class="feature-card">
                <span class="feature-icon"><?= icon('extension') ?></span>
                <h3>Pedalverlängerung</h3>
                <p>
                    Aufsätze holen die Pedale nach oben, dazu kommt der Sitz höher.
                    Gesucht ist die eine Position, in der du gleichzeitig gut siehst,
                    bequem ans Lenkrad kommst und die Pedale ganz durchtreten kannst.
                </p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="duo duo--text-first">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-violet);">
                <figure class="photo photo--right">
                    <?php /* „während des Umbaus" trug bis zum 12.08.2026 die
                             Bildunterschrift. Die ist auf Sarahs Wunsch weg (keine
                             Erklärtexte unter den Fotos mehr), deshalb steht die
                             Einordnung jetzt im alt-Text: Auf dem Bild liegen Teile
                             herum, und ohne den Hinweis liest sich das als Pfusch
                             statt als Zwischenstand. */ ?>
                    <img src="<?= asset('img/handicap-handbedienung.jpg') ?>"
                         alt="Fußraum während des Umbaus auf Handbedienung: ein grün lackierter Hebel am Boden, verbunden über grüne Gestänge, daneben eine grüne Abdeckung vor den Pedalen"
                         width="1200" height="1484" loading="lazy" decoding="async">
                </figure>
            </div>

            <div class="duo-text">
                <h2>Welche Technik zu dir passt, entscheiden wir gemeinsam</h2>
                <p>
                    Nicht jeder Umbau passt zu jedem. Manchmal reicht Linksgas, manchmal
                    braucht es die komplette Handbedienung, manchmal nur eine Automatik und
                    einen anders eingestellten Sitz.
                </p>
                <p>
                    In der ersten Stunde probieren wir aus, was sich für dich am
                    natürlichsten anfühlt – und danach richtet sich alles Weitere.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>So läuft es ab</h2>
            </div>
        </div>

        <?php /* SARAHS EIGENER ABLAUF, seit dem 21.08.2026 (Ticket SAR-72).
                 Der Text kommt von ihr und ersetzt den Entwurf, der hier stand –
                 er ist damit tabu für Umformulierungen, wie alles von ihr (siehe
                 CLAUDE.md). Zwei offensichtliche Tippfehler der Vorlage sind
                 korrigiert und beim Ticket vermerkt: „mein angepasste" →
                 „angepasstes", „bis zu ein gutes Gefühl" → „bis du".

                 VIER SCHRITTE STATT FÜNF: „Üben bis es sitzt" ist entfallen, das
                 Üben steht jetzt im Prüfungsschritt („Bis zur Prüfung üben wir
                 gemeinsam"). Deshalb steht hier auch kein `--process-cols` mehr –
                 vier ist der Rückfallwert in nd-base.css.

                 DIESER ABLAUF STAND BIS HEUTE AUCH AUF DER STARTSEITE, dort als
                 senkrechte Zeitleiste in der Sektion „Wie du bei mir
                 Fahrschüler:in wirst". Mit SAR-72 ist er von dort verschwunden;
                 die Startseite zeigt nur noch die Einordnung und die Kachel der
                 Fahrschule. Der Ablauf steht damit genau einmal – hier. */ ?>
        <ol class="process">
            <li class="process-step">
                <span class="process-num">1</span>
                <h3>Wir telefonieren</h3>
                <p>Du erzählst mir, worum es geht. Ich sage dir ehrlich, wie ich die
                   Situation einschätze und welche Gutachten etc. für den Antrag bei
                   deiner Behörde notwendig sind.</p>
            </li>
            <li class="process-step">
                <span class="process-num">2</span>
                <h3>Gutachten &amp; Auflagen</h3>
                <p>In den meisten Fällen fordert deine zuständige Verkehrsbehörde ein
                   amtsärztliches / verkehrsmedizinisches Gutachten. Ich helfe dir weiter
                   bei den notwendigen Unterlagen und Anträgen, wie beispielsweise
                   möglichen Kostenübernahmen bei den Kostenträgern.</p>
            </li>
            <li class="process-step">
                <span class="process-num">3</span>
                <h3>Erste Stunde</h3>
                <p>Wir setzen uns in mein angepasstes Fahrschulfahrzeug und stellen alles
                   auf dich ein. Danach fahren wir beide die ersten Runden auf unserem
                   eigenen Firmengelände, bis du ein gutes Gefühl hast. Sobald du bereit
                   bist und dich sicher fühlst, gehen wir gemeinsam auf die Straßen.</p>
            </li>
            <li class="process-step">
                <span class="process-num">4</span>
                <h3>Prüfung &amp; Überprüfung</h3>
                <?php /* Der Name der Fahrschule kommt wie überall aus der
                         Konfiguration. Steht dort nichts, formuliert der Satz
                         ohne ihn – dieselbe Regel wie auf der ganzen Seite. */ ?>
                <p>Bis zur Prüfung / Überprüfung üben wir gemeinsam. Mir ist dabei wichtig,
                   dass DU dich gut fühlst. Ich sitze zur Prüfung nur noch neben dir und
                   freue mich, wenn du nach erfolgreichem Abschluss den Führerschein in den
                   Händen hältst. Den Termin dafür meldet
                   <?= $school !== '' ? 'die ' . e($school) : 'die Fahrschule' ?> bei der
                   zuständigen Prüfstelle, wenn du dich sicher genug fühlst.</p>
            </li>
        </ol>
    </div>
</section>

<?php /* HIER STAND „WIE EINE STUNDE BEI MIR ABLÄUFT", bis zum 21.08.2026
         (Sarahs Ticket SAR-35). Zwei Absätze zum Ablauf einer einzelnen
         Fahrstunde, dazu vier Haken: klare Ansagen, feste Ansprechpartnerin,
         ehrliche Rückmeldung, passende Termine.

         DIE SEKTION IST JETZT NIRGENDS MEHR. Sie stand bis zum 12.08.2026 auf
         /ueber-mich und ist von dort schon einmal umgezogen – auf Sarahs
         Vorschlag hierher, weil der Abschnitt darüber den Weg zum Führerschein
         beschreibt und dieser die einzelne Stunde darin. Mit SAR-35 fällt sie
         ganz weg. Zweimal verschoben und dann gestrichen heißt: Sie hatte
         nirgends einen Platz, an dem sie gebraucht wurde.

         DER TEXT WAR EIN ENTWURF und nicht von Sarah – das ist der Grund,
         warum hier nichts nachzutragen ist. Was inhaltlich zählte, sagt sie
         auf /ueber-mich mit eigenen Worten.

         Das Video aus dem ursprünglichen Ticket („an geeigneter Stelle wieder
         verwenden") ist erledigt: Es steht seit SAR-28 auf der Startseite,
         direkt hinter dem Hero.

         Kommt der Ablauf je zurück, steht er in der Versionsgeschichte. */ ?>

<section class="section section--alt">
    <div class="container">
        <div class="notice" style="--card-accent: var(--c-yellow);">
            <?= icon('clock') ?>
            <div>
                <h3>Was ich nicht beurteilen kann</h3>
                <p>
                    Ob du fahren darfst, entscheidet nicht die Fahrschule und schon gar
                    nicht ich, sondern die Führerscheinstelle auf Basis eines Gutachtens.
                    Was ich dir sagen kann: wie das Fahren mit der jeweiligen Technik
                    praktisch funktioniert und worauf du dich einstellen kannst.
                </p>
                <p>
                    Anmeldung, Vertrag und Preise laufen über
                    <?= $school !== '' ? 'die ' . school_link() : 'die Fahrschule, bei der ich angestellt bin' ?> –
                    ich bin deine Fahrlehrerin, nicht deine Vertragspartnerin.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Unsicher, ob das bei dir klappt?</h2>
                <p>
                    Genau dafür ist das erste Telefonat da. Es kostet nichts und
                    du bist danach schlauer.
                </p>
            </div>
            <a class="btn btn-primary btn-lg" href="<?= url('/kontakt') ?>">Lass uns reden</a>
        </div>
    </div>
</section>
