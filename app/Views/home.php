<?php
$school    = (string) config('school.name');
$schoolUrl = trim((string) config('school.url'));
?>
<?php /* hero--photo: In der Medienspalte liegt ein Foto, keine Fläche. Der
         Modifier schaltet auf schmalen Screens die Regel aus nd-base.css ab,
         die die Abbildung hinter den Text legt (Begründung in theme.css). */ ?>
<section class="hero hero--photo">
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
                <?php /* Beide Umbrüche stehen hart im Text, und das ist kein
                         Geschmack: Der Typewriter baut die Zeile Zeichen für
                         Zeichen auf, ein vom Browser gesetzter Umbruch springt
                         dabei mitten im Wort in die nächste Zeile. Nachgemessen
                         mit nur einem <br> nach „Führerscheinausbildung":
                         „Handicap" rutschte beim letzten Zeichen nach unten und
                         schob den ganzen Block. */ ?>
                <h1 data-typewriter>Führerscheinausbildung<br>für Menschen<br>mit Handicap</h1>
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
<?php /* „Unterwegs in" steht nur noch für Vorlesesoftware da: Sichtbar
                             sagt das Pin-Symbol daneben schon, dass es um Orte geht,
                             und die Zeile liest sich ohne die Einleitung ruhiger.
                             Vorgelesen wären es sonst vier Ortsnamen ohne jeden
                             Zusammenhang – das Symbol ist aria-hidden. */ ?>
                    <span class="sr-only">Unterwegs in </span>
                    <span data-typewriter="fast"><?= e(area_sentence()) ?></span>
                </p>
                <?php /* Die Knöpfe heißen wie die Menüpunkte, zu denen sie führen
                         (Sarah, 17.08.2026, Ticket SAR-22): „so einfach wie
                         möglich". Wer im Menü „Über mich" gelesen hat, soll
                         denselben Namen wiederfinden und nicht raten müssen, ob
                         „Mehr über mich" woanders hinführt.

                         Gilt für die ganze Seite und für jedes Ziel, das im Menü
                         steht. Wer hier einen Knopf ergänzt, gibt ihm den Namen
                         aus `partials/nav.php` – oder, wenn das Ziel nicht im
                         Menü steht (TikTok, Instagram, die Fahrschule), einen
                         eigenen. */ ?>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="<?= url('/ueber-mich') ?>">Über mich</a>
                    <a class="btn btn-ghost btn-lg" href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a>
                </div>
            </div>

            <?php /* SARAH SELBST, seit dem 17.08.2026 (ihr Wunsch, Ticket SAR-21).

                     Hier lagen vorher zwei Fassungen: bis zum 12.08.2026 ein
                     Lockup aus drei Ebenen (Bogen als Bühne, Sarah freigestellt
                     an der Stelle des Lenkrads, Schriftzug darunter), danach auf
                     ihren Wunsch nur ihr Logo. Beide sind weg – jetzt steht hier
                     ein Foto von ihr.

                     Warum das Logo an dieser Stelle inzwischen nicht mehr trägt:
                     Es schreibt „Klasse B · Klasse BE · Handicapausbildung" mit
                     aus. Seit die Überschrift daneben „Führerscheinausbildung für
                     Menschen mit Handicap" heißt (SAR-20), stand zweimal fast
                     dasselbe auf einem Bildschirm, einmal gezeichnet und einmal
                     gesetzt. Das Logo trägt weiter den Header, dort steht kein
                     Text daneben, der mit ihm konkurriert.

                     Es ist dasselbe Foto wie auf /ueber-mich, mit Absicht: Sarah
                     wollte genau dieses. Auf beiden Seiten derselbe Rahmen wäre
                     eine Kopie, deshalb hier kein --portrait (das begrenzt die
                     Höhe für Fließtext daneben, hier trägt das Bild die Spalte)
                     und eine andere Akzentfarbe am Rahmen.

                     Auf schmalen Screens legt nd-base.css die Medienspalte hinter
                     den Text. Das gilt hier NICHT – `hero--photo` schaltet es ab.
                     Warum, steht in theme.css: Hinter Fließtext taugt eine Fläche,
                     kein Gesicht. */ ?>
            <div class="duo-media">
                <figure class="photo hero-photo" style="--card-accent: var(--c-violet);">
                    <img src="<?= asset('img/sarah-rollistammtisch-nah.jpg') ?>"
                         alt="Sarah sitzt lächelnd an ihrem Infotisch, davor eine Tischlampe
                              und ein Schild mit der Aufschrift „Die Rollistammtische“"
                         width="680" height="900" fetchpriority="high">
                </figure>
            </div>
        </div>
    </div>
</section>

<?php /* SARAHS VIDEO – steht seit dem 17.08.2026 hier oben, direkt hinter dem
         Hero (ihr Wunsch, Ticket SAR-28: „an eine bessere Stelle").

         Vorher lag der Abschnitt an vierter Stelle von sechs. Nachgemessen
         hieß das auf einem Handy (390 × 844): Das Video begann 3,9
         Bildschirme weit unten – fast viermal wischen. Auf dem Desktop 2,3.
         Der Grund war die Spalte: Gestapelt kommt erst der ganze Text samt
         beider Knöpfe, dann erst das Video.

         Warum ausgerechnet dieser Abschnitt nach oben gehört: Das Video ist
         der einzige Inhalt der Startseite, der nachweislich von Sarah ist –
         ihre Stimme, ihr Gesicht, ihre Worte. Die Texte drumherum sind zum
         großen Teil noch Entwürfe (siehe „Offene Punkte" in CLAUDE.md). Und
         ihr Publikum kommt von TikTok: Wer von dort kommt, erwartet
         Bewegtbild und wischt nicht vier Bildschirme weit danach.

         Kein autoplay, das bleibt auch hier oben so – das Video hat Ton.
         `preload="metadata"` ist an dieser Stelle wichtiger als vorher: Der
         Browser lädt nur die Kopfdaten, nicht die 5,7 MB, obwohl der
         Abschnitt jetzt fast immer im ersten Scrollbereich liegt. */ ?>
<section class="section">
    <div class="container">
        <div class="duo duo--narrow-media">
            <div class="duo-text">
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

<?php /* Hier stand bis zum 12.08.2026 ein Kasten „Kurz vorweg: Das hier ist meine
         persönliche Seite" – dieselbe Einordnung, die seit Sarahs Wunsch unten auf
         jeder Seite steht (partials/site-note.php). Zweimal auf einer Seite wäre
         sie einmal zu viel, und direkt unter dem Hero las sie sich wie eine
         Entschuldigung dafür, dass hier keine Fahrschule steht. */ ?>

<?php /* Hier stand bis zum 17.08.2026 „Mein Schwerpunkt – Fahren mit
         Handicap": Sarahs eigener Text über Linksgas, Lenkraddrehknopf und
         Handbedienung, daneben das Foto vom Rollistammtisch.

         Auf ihren Wunsch komplett nach /ueber-mich gezogen (Ticket SAR-24) –
         Text, Foto und Knopf unverändert. Dass die beiden Seiten dadurch
         Überschneidungen haben, ist bekannt und wird dort in einem eigenen
         Durchgang aufgeräumt.

         Zwei Dinge, die diese Verschiebung nebenbei erledigt hat: Der
         Streifenwechsel der Seite stimmt weiterhin (die Sektion war `--alt`,
         die nächste ist es nicht, es bleibt beim Hell-Dunkel-Wechsel), und
         die Startseite zeigt den Rollistammtisch jetzt nur noch einmal –
         nämlich im Hero. Vorher standen dort beide Zuschnitte desselben
         Fotos, keinen Bildschirm auseinander. */ ?>

<!-- Zitat: bricht den Rhythmus, gibt Sarah eine Stimme -->
<section class="section section--alt">
    <div class="container">
        <?php /* ECHTES ZITAT, wörtlich aus Sarahs eigenem Text (11.08.2026,
                 Abschnitt „Warum mir diese Arbeit besonders am Herzen liegt",
                 Wortlaut in texte-von-sarah.md). Bis zum 12.08.2026 stand hier
                 ein erfundener Satz – „Die meisten kommen nicht mit einem
                 Fahrproblem zu mir …" –, der neben ihrem echten Text eine
                 Sektion höher nicht mehr zu halten war.

                 Nicht kürzen und nicht umstellen: Sobald ein Satz in
                 Anführungszeichen unter ihrem Namen steht, ist jede Änderung
                 daran eine Behauptung darüber, was sie gesagt hat. Wer ein
                 anderes Zitat will, sucht sich einen anderen ihrer Sätze –
                 er formuliert diesen nicht um.

                 Derselbe Satz steht auf /ueber-mich mitten in ihrem Fließtext,
                 dort hervorgehoben. Das ist Absicht: Ein Kernsatz darf zweimal
                 vorkommen, hier als Zitat, dort im Zusammenhang. */ ?>
        <blockquote class="quote">
            <p>
                „Ich sehe nicht zuerst die Einschränkung. Ich schaue auf den Menschen,
                seine Fähigkeiten, seine Möglichkeiten und darauf, was wir gemeinsam
                erreichen können."
            </p>
            <footer>Sarah</footer>
        </blockquote>
    </div>
</section>

<!-- Schwerpunkte -->
<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <?php /* Hieß bis zum 17.08.2026 „Wofür man mich holt" (Sarah,
                         Ticket SAR-25). Das „man" war der Fehler: Es steht
                         mitten auf einer Seite, die sonst durchgehend „ich"
                         und „du" sagt, und „holen" klingt nach beauftragen.

                         Warum nicht das Naheliegende – „Meine Leistungen",
                         „Mein Angebot"? Das darf hier nicht stehen. Sarah ist
                         angestellte Fahrlehrerin; Anmeldung, Vertrag und
                         Preise laufen über die Fahrschule. Eine Seite, die
                         ein Leistungspaket behauptet, gibt ein Angebot ab,
                         das sie gar nicht machen kann (siehe CLAUDE.md,
                         Projektkontext). Die alte Formulierung war der
                         Versuch, genau das zu umgehen.

                         „Begleiten" trägt zusätzlich die beiden Karten, die
                         keine Fahrzeugklasse sind – Handicap und die Angst
                         vorm Steuer. „Was ich mit dir fahre" hätte für die
                         beiden zu kurz gegriffen. */ ?>
                <h2>Wobei ich dich begleite</h2>
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

<?php /* Hier stand bis zum 17.08.2026 „Wann ich diese Woche Zeit habe": die
         nächsten sechs freien Stunden als Karten, dazu der Hinweis, dass das
         Sarahs eigene Planung ist und kein Buchungssystem der Fahrschule.

         Auf ihren Wunsch entfallen (Ticket SAR-27) – der Wochenplan ist nur
         noch über „Termine" im Header erreichbar. Damit steht die Startseite
         für das, wer sie ist, und die Planung an einer Stelle statt an zwei.

         Zwei Dinge, die dabei mitgegangen sind und die man kennen muss, falls
         die Sektion je zurückkommt:

         Der Satz „meine eigene Planung, kein Buchungssystem der Fahrschule"
         ist die fachliche Abgrenzung und darf nicht ersatzlos verschwinden.
         Er steht sinngemäß weiter auf /termine („Das ist mein eigener
         Wochenplan – kein Buchungssystem der Fahrschule"), deshalb war hier
         nichts nachzutragen.

         `$freeSlots` braucht die Startseite damit nicht mehr; der Aufruf von
         `Slot::upcomingFree()` ist aus dem HomeController entfernt. Die
         Methode selbst bleibt – der BookingController arbeitet mit ihr. */ ?>

<?php /* Der praktische nächste Schritt. Steht bewusst HIER und nicht weiter oben:
         Wer bis hierhin gelesen hat, ist überzeugt und fragt sich, wie es geht.
         Die Arbeitsteilung nebeneinander zu zeigen ist ehrlicher als ein Satz –
         Sarah verkauft nichts, sie fährt.

         `--alt` seit dem 17.08.2026: Davor lag die Sektion mit den freien
         Zeiten, die abgesetzt war. Ohne den Wechsel stießen hier zwei gleich
         helle Sektionen aneinander (SAR-27). */ ?>
<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
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
            <a class="btn btn-primary btn-lg" href="<?= url('/kontakt') ?>">Kontakt</a>
        </div>
    </div>
</section>
