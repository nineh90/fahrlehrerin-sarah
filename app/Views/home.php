<?php
/** @var array $freeSlots */
$school    = (string) config('school.name');
$schoolUrl = trim((string) config('school.url'));
?>
<section class="hero">
    <div class="container hero-inner">
        <div class="duo duo--narrow-media">
            <?php /* Die Augenbraue war am 07.08.2026 entfallen, weil die Klassen
                     im Header unter der Wortmarke standen und hier ein zweites
                     Mal gestanden hätten.

                     Seit dem Header-Umbau am 11.08.2026 stimmt diese Begründung
                     nicht mehr: Ganz oben zeigt der Header nur noch Sarahs
                     Logo, die Versalzeile „Klasse B · BE · Handicap" blendet
                     erst beim Scrollen ein. Genau dann, wenn jemand die Seite
                     öffnet, steht sie also nirgends – und deshalb steht sie
                     jetzt wieder hier. */ ?>
            <div class="hero-content">
                <p class="hero-eyebrow" data-typewriter="fast">Fahrlehrerin · Klasse B + BE · Handicap</p>
                <?php /* data-typewriter: main.js baut diese eine Überschrift beim
                         Laden Zeichen für Zeichen auf. Der Satz steht trotzdem
                         vollständig hier im HTML – für Suchmaschinen, für
                         Vorlesesoftware und für alle ohne JavaScript.
                         Bewusst nur hier: Eine tippende Überschrift trägt einmal.
                         Auf jeder Unterseite noch einmal wäre sie ein Tic. */ ?>
                <h1 data-typewriter>Hinterm Steuer<br>ist Platz für alle.</h1>
                <?php /* "fast" = doppeltes Tempo. Das ist kein Detail: Bei 42 ms
                         je Zeichen tippt die Seite mit rund 285 Wörtern pro
                         Minute, also ungefähr Lesegeschwindigkeit – dann fühlt
                         es sich wie Bremsen an. Bei 20 ms sind es etwa 600, der
                         Text ist immer schneller fertig, als man ihm folgt.
                         Für die Überschrift bleibt es beim langsamen Tempo,
                         die ist der Akzent und kurz genug. */ ?>
                <p class="hero-lead" data-typewriter="fast">
                    Ich bin Sarah. Mein Schwerpunkt: Fahren mit Handicap.
                </p>
                <p class="hero-meta">
                    <?= icon('pin') ?>
                    <span data-typewriter="fast">Unterwegs in <?= e(area_sentence()) ?></span>
                </p>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="<?= url('/ueber-mich') ?>">Mehr über mich</a>
                    <a class="btn btn-ghost btn-lg" href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a>
                </div>
            </div>

            <?php /* Lockup aus drei Ebenen: Bogen (Hintergrund), Sarah freigestellt
                     und der Schriftzug aus dem Logo. Zusammen ergeben sie das Logo
                     mit Sarah darin – statt Foto und Marke nebeneinander.
                     Maße/Positionen stehen in theme.css, alles in Prozent. */ ?>
            <div class="duo-media">
                <div class="hero-lockup">
                    <img class="hero-lockup-photo" src="<?= asset('img/sarah-lockup.webp') ?>"
                         alt="Sarah lächelt und streckt den Daumen hoch"
                         width="620" height="1130">
                    <img class="hero-lockup-word" src="<?= asset('img/logo-wortmarke.webp') ?>"
                         alt="Fahrlehrerin Sarah – Klasse B, Klasse BE, Handicapausbildung"
                         width="600" height="486">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Einordnung: Sarah ist Fahrlehrerin, keine Fahrschule -->
<section class="section">
    <div class="container">
        <div class="notice" style="--card-accent: var(--c-blue);">
            <?= icon('shield') ?>
            <div>
                <h3>Kurz vorweg: Das hier ist meine persönliche Seite.</h3>
                <p>
                    Ich bin angestellte Fahrlehrerin<?= $school !== '' ? ' bei der ' . school_link() : '' ?> –
                    keine eigene Fahrschule. Anmeldung, Vertrag und Preise laufen dort.
                    Hier erfährst du, wie ich arbeite und wann ich Zeit habe.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Fahren mit Handicap: Sarahs Schwerpunkt, prominent und mit Bild -->
<section class="section section--alt">
    <div class="container">
        <div class="duo duo--text-first">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-teal);">
                <figure class="photo">
                    <img src="<?= asset('img/handicap-linksgas.jpg') ?>"
                         alt="Fußraum eines Fahrschulautos mit Linksgas-Umbau: links neben der
                              Bremse sitzt ein zusätzliches Gaspedal, das über ein grünes
                              Gestänge mit dem originalen Gaspedal verbunden ist"
                         width="1400" height="1050" loading="lazy" decoding="async">
                    <figcaption>Linksgas: das zusätzliche Pedal links der Bremse, das originale rechts bleibt bedienbar</figcaption>
                </figure>
            </div>

            <div class="duo-text">
                <span class="section-eyebrow" style="padding-left:0;">Mein Schwerpunkt</span>
                <h2>Fahren mit Prothese, Handicap oder nach einem Unfall</h2>
                <p>
                    Ein angepasstes Fahrzeug fährt sich anders – nicht schwerer. Linksgas,
                    Lenkraddrehknopf, Handbedienung für Gas und Bremse: Ich kenne die Technik
                    und weiß, wie lange es dauert, bis sie sich selbstverständlich anfühlt.
                </p>
                <p>
                    Was ich nicht mache: dich anders behandeln als alle anderen. Wir üben,
                    bis es sitzt. Genau wie bei jedem anderen auch.
                </p>
                <div class="duo-actions">
                    <a class="btn btn-primary" href="<?= url('/fahren-mit-handicap') ?>">Wie das abläuft</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Zitat: bricht den Rhythmus, gibt Sarah eine Stimme -->
<section class="section">
    <div class="container">
        <blockquote class="quote">
            <p>
                „Die meisten kommen nicht mit einem Fahrproblem zu mir, sondern mit einem
                Satz im Kopf, den ihnen jemand gesagt hat. Den fahren wir als Erstes weg."
            </p>
            <footer>Sarah</footer>
        </blockquote>
    </div>
</section>

<!-- Schwerpunkte -->
<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <span class="section-eyebrow">Womit ich arbeite</span>
                <h2>Wofür man mich holt</h2>
            </div>
        </div>

        <div class="card-grid">
            <article class="feature-card">
                <span class="feature-icon"><?= icon('car') ?></span>
                <h3>Klasse B</h3>
                <p>
                    Der Autoführerschein – von der ersten Runde auf dem Parkplatz bis zur
                    Prüfungsfahrt. Automatik oder Schaltung, wie es zu dir passt.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('trailer') ?></span>
                <h3>Klasse BE</h3>
                <p>
                    Fahren mit Anhänger: Pferdeanhänger, Wohnwagen, Baustellenhänger.
                    Vor allem Rangieren – rückwärts um die Ecke will geübt sein.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('wheelchair') ?></span>
                <h3>Ausbildung mit Handicap</h3>
                <p>
                    Fahren mit Prothese, Lenkhilfe oder Handbedienung. Ich kenne die
                    Technik und übe sie, bis du nicht mehr darüber nachdenkst.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('thumb') ?></span>
                <h3>Angstfrei ans Steuer</h3>
                <p>
                    Prüfung mehrfach nicht bestanden? Seit dem Unfall nicht mehr gefahren?
                    Wir fangen da an, wo es sich noch machbar anfühlt.
                </p>
            </article>
        </div>
    </div>
</section>

<!-- TikTok mit Bild -->
<section class="section">
    <div class="container">
        <div class="duo duo--narrow-media">
            <div class="duo-text">
                <span class="section-eyebrow" style="padding-left:0;">Auf TikTok und Instagram</span>
                <h2>Was im Fahrschulauto wirklich passiert</h2>
                <p>
                    Auf meinen Kanälen zeige ich meinen Arbeitsalltag: Situationen, die in
                    der Prüfung immer wieder schiefgehen, Fragen, die mir jede Woche
                    gestellt werden, und wie ein angepasstes Fahrzeug von innen aussieht.
                </p>
                <p>
                    Kein Hochglanz, keine Werbung – einfach das, was ich sowieso den
                    ganzen Tag erkläre. Ein Beispiel siehst du hier direkt.
                </p>
                <div class="duo-actions">
                    <a class="btn btn-primary" href="<?= e(tiktok_url()) ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?= icon('tiktok') ?> @<?= e(config('social.tiktok_handle')) ?>
                    </a>
                    <a class="btn btn-ghost" href="<?= e(instagram_url()) ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?= icon('instagram') ?> Instagram
                    </a>
                </div>
                <?php /*
                    Später möglich: offizielles TikTok-Embed statt Link.
                    Bewusst noch nicht eingebaut – das Embed-Script lädt Fremdcode und
                    braucht vorher einen Hinweis in der Datenschutzerklärung sowie eine
                    Einwilligung. Handle steht in der .env (TIKTOK_HANDLE).
                */ ?>
            </div>

            <div class="duo-media photo-wrap" style="--card-accent: var(--c-red);">
                <figure class="video-frame">
                    <?php /* Kein autoplay: das Video hat Ton und startet nur auf Wunsch.
                             preload="metadata" lädt bloß die Kopfdaten, nicht die 5,7 MB. */ ?>
                    <video controls playsinline preload="metadata"
                           poster="<?= asset('img/sarah-vorstellung-poster.jpg') ?>"
                           width="576" height="1024">
                        <source src="<?= asset('video/sarah-vorstellung.mp4') ?>" type="video/mp4">
                        Dein Browser kann dieses Video nicht abspielen.
                        <a href="<?= e(tiktok_url()) ?>" target="_blank" rel="noopener noreferrer">
                            Schau es dir direkt auf TikTok an.
                        </a>
                    </video>
                    <figcaption>
                        „Mit einem Handicap ist der Weg zum Führerschein oftmals steinig und
                        schwer" – ein Ausschnitt von meinem Kanal
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>
</section>

<!-- Freie Zeiten -->
<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <span class="section-eyebrow">Meine Stundenplanung</span>
                <h2>Wann ich diese Woche Zeit habe</h2>
            </div>
            <a class="link-more" href="<?= url('/termine') ?>">Ganze Woche ansehen &rarr;</a>
        </div>

        <p class="muted" style="max-width:640px;margin:-1.4rem 0 2rem;">
            Diese Übersicht ist meine eigene Planung, kein Buchungssystem der Fahrschule.
            Meine Fahrschüler:innen tragen sich hier selbst ein, statt mir zwischen zwei
            Stunden hinterherzutelefonieren.
        </p>

        <?php if (!$freeSlots): ?>
            <div class="empty-state card">
                <p>Gerade ist alles voll. Neue Zeiten trage ich meistens sonntags ein –
                   schau in ein paar Tagen nochmal rein.</p>
                <a class="btn btn-ghost" href="<?= url('/kontakt') ?>">Schreib mir</a>
            </div>
        <?php else: ?>
            <?php /* --plain: keine Regenbogen-Rotation. Hier ist jede Karte dieselbe
                     Sache – eine freie Stunde. Siehe theme.css. */ ?>
            <div class="card-grid card-grid--plain">
                <?php foreach ($freeSlots as $slot): ?>
                    <?php $start = dt($slot['starts_at']); ?>
                    <article class="feature-card">
                        <span class="feature-icon"><?= icon('calendar') ?></span>
                        <h3><?= e(weekday_long($start)) ?>, <?= e($start->format('d.m.')) ?></h3>
                        <p>
                            <?= e(format_time($start)) ?> · <?= e(Slot::label($slot)) ?>
                            <?php if ($slot['location']): ?>
                                <br><?= e($slot['location']) ?>
                            <?php endif; ?>
                        </p>
                        <div class="feature-meta">
                            <a class="btn btn-ghost btn-sm" href="<?= url('/termine') ?>">Im Kalender öffnen</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php /* Der praktische nächste Schritt. Steht bewusst HIER und nicht weiter oben:
         Wer bis hierhin gelesen hat, ist überzeugt und fragt sich, wie es geht.
         Die Arbeitsteilung nebeneinander zu zeigen ist ehrlicher als ein Satz –
         Sarah verkauft nichts, sie fährt. */ ?>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <span class="section-eyebrow">Der erste Schritt</span>
                <h2>Wie du bei mir Fahrschüler:in wirst</h2>
            </div>
        </div>

        <p class="muted" style="max-width:660px;margin:-1.4rem 0 2rem;">
            Ich bin angestellte Fahrlehrerin, keine eigene Fahrschule. Die Anmeldung
            läuft deshalb nicht über diese Seite, sondern über
            <?= $school !== '' ? school_link() : 'meine Fahrschule' ?>. Sag dort einfach,
            dass du bei mir fahren möchtest.
        </p>

        <div class="split-grid">
            <article class="card" style="--card-accent: var(--c-green);">
                <h3 style="margin-top:0;">
                    <?= $school !== '' ? e($school) : 'Die Fahrschule' ?> übernimmt
                </h3>
                <ul class="check-list" style="margin-bottom:0;">
                    <li>Anmeldung und Ausbildungsvertrag</li>
                    <li>Theorieunterricht und Lernmaterial</li>
                    <li>Preise und Abrechnung</li>
                    <li>Anmeldung zur Prüfung bei der Führerscheinstelle</li>
                </ul>
            </article>

            <article class="card" style="--card-accent: var(--c-violet);">
                <h3 style="margin-top:0;">Bei mir sitzt du im Auto</h3>
                <ul class="check-list" style="margin-bottom:0;">
                    <li>Alle Fahrstunden, von der ersten bis zur Prüfung</li>
                    <li>Die Pflichtfahrten: Überland, Autobahn, bei Dunkelheit</li>
                    <li>Ausbildung mit Prothese, Lenkhilfe oder Handbedienung</li>
                    <li>Deine Termine – hier auf der Seite, ohne Telefonieren</li>
                </ul>
            </article>
        </div>

        <?php if ($school !== '' && $schoolUrl !== ''): ?>
            <p style="margin:2rem 0 0;">
                <a class="btn btn-ghost" href="<?= e($schoolUrl) ?>" target="_blank" rel="noopener">
                    Zur <?= e($school) ?> &nearr;
                </a>
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- Abschluss -->
<section class="cta-band">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Du überlegst noch?</h2>
                <p>
                    Ruf mich an oder schreib mir. Ich sage dir ehrlich, ob ich die
                    Richtige für dich bin – und wenn nicht, wen du fragen solltest.
                </p>
            </div>
            <a class="btn btn-primary btn-lg" href="<?= url('/kontakt') ?>">So erreichst du mich</a>
        </div>
    </div>
</section>
