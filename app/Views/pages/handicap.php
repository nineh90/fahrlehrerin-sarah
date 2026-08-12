<?php $school = (string) config('school.name'); ?>
<section class="page-head">
    <div class="container">
        <h1>Fahren mit Handicap</h1>
        <p class="page-lead">
            Mit Prothese, nach einer Amputation, nach einem Unfall oder mit einer
            Einschränkung, die dir jemand als Ausschlussgrund verkauft hat:
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
                <p>
                    Die meisten, die zu mir kommen, haben denselben Satz im Kopf: „Ob das
                    überhaupt geht?" Meistens geht es. Manchmal braucht es eine andere
                    Technik, oft ein paar Stunden mehr – aber fast nie ein Nein.
                </p>
                <p>
                    Das Foto zeigt einen Linksgas-Umbau: ein zusätzliches Gaspedal links
                    der Bremse. Mehr Unterschied zum normalen Fahrschulauto ist da nicht.
                </p>
                <p>
                    Ich erkläre dir die Bedienelemente in Ruhe und wir fahren so lange
                    damit, bis du nicht mehr überlegen musst, sondern einfach machst.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <span class="section-eyebrow">Technik im Fahrzeug</span>
                <h2>Womit wir arbeiten</h2>
            </div>
        </div>

        <div class="card-grid">
            <article class="feature-card">
                <span class="feature-icon"><?= icon('pedal') ?></span>
                <h3>Linksgas</h3>
                <p>
                    Ein zweites Gaspedal links der Bremse, wenn der rechte Fuß nicht
                    mitmacht. Der Umbau ist klein, die Umstellung überraschend schnell –
                    schwierig ist am Anfang nur, den rechten Fuß stillhalten zu lassen.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('knob') ?></span>
                <h3>Lenkraddrehknopf</h3>
                <p>
                    Lenken mit einer Hand – der Klassiker, wenn die zweite Hand nicht
                    mitarbeiten kann. Nach zwei, drei Stunden fühlt es sich normal an.
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

            <article class="feature-card">
                <span class="feature-icon"><?= icon('prosthesis') ?></span>
                <h3>Prothesenfahren</h3>
                <p>
                    Ob Bein- oder Armprothese: Wir schauen zuerst, was mit deiner Prothese
                    gut geht, und suchen dann die passende Technik dazu – nicht umgekehrt.
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
                <span class="section-eyebrow">Der Weg dahin</span>
                <h2>So läuft es ab</h2>
            </div>
        </div>

        <ol class="process">
            <li class="process-step">
                <span class="process-num">1</span>
                <h3>Wir telefonieren</h3>
                <p>Du erzählst mir, worum es geht. Ich sage dir ehrlich, was ich einschätzen
                   kann und was ein Gutachten klären muss.</p>
            </li>
            <li class="process-step">
                <span class="process-num">2</span>
                <h3>Gutachten &amp; Auflagen</h3>
                <p>Für die Fahrerlaubnis wird meist ein medizinisches oder verkehrsmedizinisches
                   Gutachten gebraucht. Daraus ergeben sich die Auflagen für dein Fahrzeug.</p>
            </li>
            <li class="process-step">
                <span class="process-num">3</span>
                <h3>Erste Stunde</h3>
                <p>Wir setzen uns ins angepasste Fahrzeug, stellen alles auf dich ein
                   und fahren erstmal nur, damit du ein Gefühl bekommst.</p>
            </li>
            <li class="process-step">
                <span class="process-num">4</span>
                <h3>Üben bis es sitzt</h3>
                <p>Wie bei jedem anderen auch: so lange, bis du sicher bist. Der einzige
                   Unterschied ist der Weg, nicht das Ziel.</p>
            </li>
        </ol>
    </div>
</section>

<?php /* Der Ablauf einer einzelnen Fahrstunde. Stand bis zum 12.08.2026 auf
         /ueber-mich; dort ist er auf Sarahs Wunsch entfallen und hierher
         gewandert („Wie die Stunde abläuft vielleicht bei fahren mit handicap").

         An dieser Stelle, weil der Abschnitt darüber den Weg zum Führerschein
         beschreibt und dieser hier die einzelne Stunde darin – vom Großen ins
         Kleine. Ohne das Foto des Fahrschulautos, das vorher danebenstand: Auf
         dieser Seite gibt es schon zwei Fotos, ein drittes macht sie zur Galerie.

         ENTWURF, nicht von Sarah – wie alles, was hier nicht ausdrücklich als
         ihr Text markiert ist. */ ?>
<section class="section">
    <div class="container">
        <div class="prose">
            <h2>Wie eine Stunde bei mir abläuft</h2>
            <p>
                Zu Beginn sagen wir beide, was heute dran ist – du, was du üben willst,
                ich, was ich für nötig halte. Am Ende bekommst du eine ehrliche
                Einschätzung: was saß, was noch nicht, und was wir beim nächsten Mal
                machen.
            </p>
            <p>
                Ich rede während der Fahrt wenig, aber früh. Lieber eine Ansage zwei
                Sekunden vorher als ein Kommentar hinterher.
            </p>
            <ul class="check-list">
                <li>Klare Ansagen, kein Anschreien</li>
                <li>Feste Ansprechpartnerin – du fährst immer mit mir</li>
                <li>Ehrliche Rückmeldung zu deinem Stand</li>
                <li>Termine, die zu Schule, Ausbildung oder Schicht passen</li>
            </ul>
        </div>
    </div>
</section>

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
