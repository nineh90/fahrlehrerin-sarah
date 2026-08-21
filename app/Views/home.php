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
            <?php /* DIE AUGENBRAUE NENNT SEIT DEM 21.08.2026 DIE FAHRSCHULE
                     (Ticket SAR-78) und nicht mehr die Klassen. Hier stand
                     „Fahrlehrerin · Klasse B + BE · Handicap".

                     Das gehört zur selben Bewegung wie der Knopf darunter
                     (SAR-77): Sarahs Arbeitgeber trägt ihren Schwerpunkt mit,
                     findet es aber unglücklich, dass sie nach außen alleine
                     dazustehen scheint. Jetzt steht die Zuordnung in der
                     allerersten Zeile des Heros.

                     WAS DAMIT AUS DEM HERO VERSCHWINDET, gehört gewusst: die
                     Klassen B und BE. Sie standen hier, seit der Header sie
                     beim Öffnen der Seite nicht mehr zeigt – seine Versalzeile
                     blendet erst beim Scrollen ein. Ganz weg sind sie nicht:
                     Sarahs Einordnung unten auf jeder Seite nennt sie
                     ausgeschrieben („Fahrlehrerin für die Klassen B und BE"),
                     und im Logo stehen sie mit im Bild. Im Hero-Text steht
                     jetzt keine mehr.

                     Der Mittelpunkt ist der Trenner dieser Seite – er steht so
                     im Logo, im Fuß und stand so in der alten Fassung. Ein
                     Bindestrich wäre der einzige an der ganzen Seite.

                     Ist `SCHOOL_NAME` leer, steht wieder die alte Zeile da –
                     dieselbe Regel wie überall: Die Seite formuliert ohne die
                     Fahrschule, wenn es sie in der Konfiguration nicht gibt. */ ?>
            <div class="hero-content">
                <p class="hero-eyebrow" data-typewriter="fast"><?= $school !== '' ? 'Fahrlehrerin Sarah · ' . e($school) : 'Fahrlehrerin · Klasse B + BE · Handicap' ?></p>
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
                         schob den ganzen Block.

                         DER BINDESTRICH IN „FÜHRERSCHEIN-AUSBILDUNG" ist seit
                         dem 20.08.2026 drin (SAR-59, Kevin). Das Wort ist mit
                         22 Zeichen das längste der Seite und war auf schmalen
                         Geräten das Maß aller Dinge: Bei 320 px stand es exakt
                         von Rand zu Rand, ohne einen Millimeter Luft, und die
                         Schriftgröße `--fs-hero-sm` war erkennbar darauf
                         gerechnet. Reißen konnte es nur `overflow-wrap:
                         break-word` (nd-base.css), und das bricht ohne
                         Bindestrich mitten im Wort.

                         Die Schreibweise ist orthografisch in Ordnung: Der
                         Bindestrich gliedert ein zusammengesetztes Wort, der
                         zweite Teil wird dabei großgeschrieben.

                         `hero-headline` HÄLT DAS WORT AUF DEM DESKTOP ZUSAMMEN
                         (nd-base.css, `white-space: nowrap`), und zwar aus
                         einem Grund, den man erst beim Nachmessen sieht: Das
                         lange Wort hat sich seine Spalte immer selbst erzwungen.
                         Ein Rasterfeld kann nicht schmaler werden als das
                         breiteste unteilbare Wort darin, und genau das hielt die
                         Überschrift dreizeilig – nicht die Spaltenbreite hielt
                         das Wort, das Wort hielt die Spalte.

                         Mit dem Bindestrich war das Wort plötzlich teilbar, die
                         Spalte fiel auf ihren Rasteranteil zurück und die
                         Überschrift wurde vierzeilig. `nowrap` stellt den alten
                         Zustand her, jetzt mit den 30 px, die der Bindestrich
                         zusätzlich braucht. Unter 500 px wird die Sperre
                         aufgehoben, dort SOLL das Wort brechen. */ ?>
                <h1 class="hero-headline" data-typewriter>Führerschein-Ausbildung<br>für Menschen<br>mit Handicap</h1>
                <?php /* "fast" = doppeltes Tempo. Das ist kein Detail: Bei 42 ms
                         je Zeichen tippt die Seite mit rund 285 Wörtern pro
                         Minute, also ungefähr Lesegeschwindigkeit – dann fühlt
                         es sich wie Bremsen an. Bei 20 ms sind es etwa 600, der
                         Text ist immer schneller fertig, als man ihm folgt.
                         Für die Überschrift bleibt es beim langsamen Tempo,
                         die ist der Akzent und kurz genug. */ ?>
                <?php /* HIER SPRICHT SIE SELBST, seit dem 21.08.2026 (SAR-78):
                         „Moin ihr Lieben. Mein Name ist Sarah."

                         DAS IST IHR WORTLAUT, nicht nachempfunden: Mit genau
                         diesen zwei Sätzen fangen ihre Videos an (Kevin,
                         21.08.2026). Damit gilt hier dieselbe Regel wie für
                         ihre Zitate – umformulieren, kürzen oder „glätten" ist
                         keine Option, denn es wäre eine Behauptung darüber, wie
                         sie sich vorstellt. Der Zusatz dahinter („Fahrlehrerin
                         für die Klassen B und BE") ist dagegen unsere Ergänzung
                         und darf angefasst werden.

                         Der erste Satz der Seite klingt damit nach ihr und
                         nicht nach einer Selbstbeschreibung.

                         Vorher stand hier „Ich bin Sarah. Mein Schwerpunkt:
                         Führerscheinausbildung für Menschen mit Handicap." Der
                         Satz sagte dasselbe wie die Überschrift direkt darüber,
                         und das war zwischenzeitlich sogar so beauftragt
                         (SAR-59, Kevin). Mit dem neuen Vorspann ist die
                         Doppelung weg: Die H1 nennt den Schwerpunkt, die Zeile
                         darunter begrüßt. Der Schwerpunkt geht dabei nicht
                         verloren, er steht eine Zeile höher.

                         DIE KLASSEN STEHEN JETZT HIER. Sie standen bis heute in
                         der Augenbraue darüber, und die nennt seit SAR-78 die
                         Fahrschule. Ohne diesen Zusatz stünde im ganzen ersten
                         Bildschirm nicht mehr, was sie ausbildet – dabei sucht
                         genau danach, wer einen Führerschein anfängt.

                         DER HANDICAP-SCHWERPUNKT GEHÖRT HIER NICHT NOCH EINMAL
                         HIN (Kevin, 21.08.2026). Der Satz endete kurz auf
                         „– inklusive Handicapausbildung"; die Überschrift eine
                         Zeile höher sagt genau das. Was hier steht, ergänzt die
                         H1, es wiederholt sie nicht.

                         DER EINE UMBRUCH STEHT HART IM TEXT, alles danach bricht
                         der Browser selbst. Hart, weil die Begrüßung eine eigene
                         Zeile ist und keine, die je nach Fensterbreite
                         woanders endet; `main.js` merkt sich das <br> und setzt
                         es beim Tippen wieder. Der zweite Satz bleibt bewusst
                         frei umbrechend – feste Umbrüche in einem langen Satz
                         sitzen auf dem Handy immer falsch. */ ?>
                <p class="hero-lead" data-typewriter="fast">
                    Moin ihr Lieben.<br>Mein Name ist Sarah, Fahrlehrerin für die Klassen B und BE.
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
                <?php /* DER ZWEITE KNOPF FÜHRT ZUR FAHRSCHULE, seit dem 21.08.2026
                         (Ticket SAR-77). Vorher stand hier „Fahren mit Handicap".

                         Der Grund kommt aus der Fahrschule selbst: Sarahs
                         Arbeitgeber trägt ihren Handicap-Schwerpunkt mit, ihm
                         missfällt aber, dass sie nach außen alleine dazustehen
                         scheint. Genannt wurde er auf der Seite schon (Sektion
                         „Wie du bei mir Fahrschüler:in wirst"), nur eben erst
                         weit unten. Im Hero steht der Bezug jetzt sofort.

                         Der Handicap-Schwerpunkt verliert dadurch nichts an
                         dieser Stelle: Die Überschrift direkt darüber sagt ihn
                         aus, und der Weg zur Unterseite steht im Menü.

                         Warum extern und nicht auf eine eigene Unterseite: Eine
                         Seite über die Fahrschule bei Sarah wäre ein zweiter
                         Auftritt für einen fremden Betrieb – die Entscheidung
                         gegen eine solche Unterseite steht in CLAUDE.md und
                         gilt weiter. Der Knopf reicht zur Fahrschule durch,
                         `target="_blank"` lässt Sarahs Seite dabei offen.

                         Die if-Prüfung ist kein Schmuck: Alle Templates dieser
                         Seite formulieren ohne die Fahrschule, wenn SCHOOL_NAME
                         oder SCHOOL_URL leer sind. Wer die beiden Zeilen in der
                         .env leert, bekommt hier wieder den alten Knopf – nicht
                         einen, der ins Leere zeigt. */ ?>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="<?= url('/ueber-mich') ?>">Über mich</a>
                    <?php if ($school !== '' && $schoolUrl !== ''): ?>
                        <a class="btn btn-ghost btn-lg" href="<?= e($schoolUrl) ?>" target="_blank" rel="noopener">
                            <?= e($school) ?> &nearr;
                        </a>
                    <?php else: ?>
                        <a class="btn btn-ghost btn-lg" href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a>
                    <?php endif; ?>
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

                     SEIT DEM 21.08.2026 STEHT HIER EIN EIGENES FOTO (SAR-80,
                     Kevin): Sarah am Tisch, den Kopf in die Hand gestützt.
                     Davor war es derselbe Zuschnitt wie auf /ueber-mich
                     (`sarah-rollistammtisch-nah.jpg`) – die Startseite und ihre
                     Über-mich-Seite zeigten also dasselbe Bild. Das ist damit
                     erledigt, und `/ueber-mich` behält seinen Zuschnitt für
                     sich.

                     Kein --portrait (das begrenzt die Höhe für Fließtext
                     daneben, hier trägt das Bild die Spalte). Das Foto ist
                     hochkantiger als sein Vorgänger, 9:16 statt 3:4 – der Hero
                     wird dadurch rund 190 px höher. Auf einem 1920 × 956er
                     Schirm passt er noch auf einen Bildschirm, auf einem
                     kleinen Laptop nicht mehr ganz. Wer das ändern will, senkt
                     `.hero-photo { max-width }` in theme.css; am Bild selbst
                     ist nichts zu schneiden.

                     Auf schmalen Screens legt nd-base.css die Medienspalte hinter
                     den Text. Das gilt hier NICHT – `hero--photo` schaltet es ab.
                     Warum, steht in theme.css: Hinter Fließtext taugt eine Fläche,
                     kein Gesicht. */ ?>
            <div class="duo-media">
                <figure class="photo hero-photo" style="--card-accent: var(--c-violet);">
                    <img src="<?= asset('img/sarah-hero.jpg') ?>"
                         alt="Sarah sitzt lächelnd an einem Tisch, den Kopf in die Hand
                              gestützt, daneben eine Tischlampe und ein Becher mit Stiften"
                         width="800" height="1421" fetchpriority="high">
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
        <?php /* Video links, Text rechts (Sarah, 17.08.2026).

                 Die Spalte steht im Markup vorn und nicht per CSS-`order`
                 gedreht: Beim Grid hängen die Spaltenbreiten an der Position
                 im Raster, nicht am Element. Über `order` gedreht bekäme das
                 Hochformat-Video die breite Spalte (1.15fr) und der Text die
                 schmale – deshalb `duo--narrow-media-left`, die gespiegelte
                 Fassung der Klasse.

                 Weil die Videospalte damit auch im Markup vorn steht, kommt
                 sie auf schmalen Screens obendrauf: Auf dem Handy sieht man
                 jetzt zuerst das Video und dann den Text dazu. Das war der
                 zweite Teil von SAR-28 und ist hier gratis mitgekommen. */ ?>
        <div class="duo duo--narrow-media-left">
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
                <?php /* Beide Knöpfe tragen den Namen der Plattform, nicht den
                         Handle (Sarah, 17.08.2026). Vorher stand auf dem einen
                         „@fahrlehrerin_sarah" und auf dem anderen „Instagram" –
                         zwei verschiedene Sorten Beschriftung nebeneinander,
                         und der Handle ist auf Instagram ohnehin ein anderer.
                         Dieselbe Regel wie bei den Menü-Knöpfen (SAR-22): Ein
                         Ziel, ein Name.

                         Der Handle bleibt in der .env (TIKTOK_HANDLE) und
                         steckt weiter in der verlinkten Adresse – nur
                         ausgeschrieben steht er hier nicht mehr. */ ?>
                <div class="duo-actions">
                    <a class="btn btn-primary" href="<?= e(tiktok_url()) ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?= icon('tiktok') ?> TikTok
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

        <?php /* `--5` seit SAR-44: Mit der fünften Karte stünde eine allein in der
                 zweiten Zeile. Der Modifier macht 3 + 2 daraus, zweite Zeile mittig
                 (Begründung in nd-base.css). Kommt je eine Karte dazu oder weg,
                 gehört er angepasst oder entfernt – er ist auf fünf gerechnet. */ ?>
        <div class="card-grid card-grid--5">
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
                <?php /* SAR-43: Stand bis zum 17.08.2026 als „Fahren mit Prothese,
                         Lenkhilfe oder Handbedienung". Die drei Beispiele lasen sich
                         als die Liste dessen, was geht – kleinwüchsige Fahrschüler:innen
                         kamen darin nicht vor und mussten annehmen, sie seien nicht
                         gemeint.

                         Jetzt stehen die UMBAUTEN vorn und die Voraussetzung dahinter.
                         Das ist nicht nur Reihenfolge: Der Satz zählt damit auf, was
                         Sarah beherrscht, statt aufzuzählen, wer kommen darf. Pedal-
                         verlängerung und Sitzerhöhung sind die Umbauten, um die es bei
                         Kleinwuchs geht – sie fehlten vorher ganz.

                         „Kleinwuchs" ist der Begriff, den der Bundesverband
                         kleinwüchsiger Menschen selbst verwendet.

                         PROTHESE IST GANZ ENTFALLEN und nicht nur hier: auch aus den
                         beiden Meta-Beschreibungen, aus dem Vorspann von
                         /fahren-mit-handicap und als eigene Karte „Prothesenfahren"
                         von dort. „Eingeschränkte Beweglichkeit" ist der Ersatz –
                         breiter gefasst und ohne ein Hilfsmittel zu nennen, das die
                         Seite nicht mehr anbietet.

                         Die Aufzählung steht damit an drei Stellen: hier und in den
                         Meta-Beschreibungen von HomeController und PageController.
                         Wer sie ändert, ändert sie dreimal – sonst verspricht die
                         Seite etwas, das die Google-Vorschau nicht kennt. */ ?>
                <p>
                    Handbedienung, Lenkhilfe, Pedalverlängerung, Sitzerhöhung – ob
                    Kleinwuchs oder eingeschränkte Beweglichkeit. Ich kenne die Technik
                    und übe sie, bis du nicht mehr darüber nachdenkst.
                </p>
            </article>

            <?php /* SAR-44. Steht hinter „Ausbildung mit Handicap": beides ist
                     Ausbildung mit besonderer Voraussetzung, und die Karte
                     danach („Angstfrei ans Steuer") handelt vom Kopf und nicht
                     vom Körper – sie schließt die Reihe ab.

                     ZUM TEXT: FahrSignal ist echt (eigenes Projekt, Produktidee
                     von Sarah) und beschrieben, wie die App wirklich arbeitet –
                     Anweisung als Verkehrszeichen auf dem Gerät der Schülerin,
                     farbcodiert nach Dringlichkeit, Empfängerschirm ohne
                     bedienbare Elemente. Aber sie ist NICHT veröffentlicht.
                     Deshalb steht hier „in der Testphase" (bis zum 17.08.2026
                     „entsteht gerade") und kein Satz, der eine fertige App
                     verspricht. Der Halbsatz ist die einzige Stelle der Seite,
                     die vom Stand eines anderen Projekts abhängt: Wer die Karte
                     anfasst, prüft ihn vorher – ein Werbesatz für etwas, das es
                     noch nicht gibt, wäre auf einer Seite, die sonst nichts
                     verspricht, der einzige Bruch. */ ?>
            <article class="feature-card">
                <span class="feature-icon"><?= icon('ear') ?></span>
                <h3>Ausbildung mit Hörschädigung</h3>
                <p>
                    Was ich sage, hörst du nicht – also zeige ich es dir. Meine Anweisungen
                    erscheinen als Schild auf einem Gerät im Auto, farbig nach Dringlichkeit.
                    Die App dafür heißt FahrSignal und ist gerade in der Testphase.
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
        <?php /* Der Einordnungssatz steht IM section-head und nicht als eigener
                 Absatz darunter. Vorher zog ihn ein `margin-top:-1.4rem` wieder
                 an die Überschrift heran – gegen den Abstand, den `.section-head`
                 selbst mitbringt. Zwei Regeln, die sich gegenseitig aufheben,
                 sind eine Regel zu viel: Im Kopf gehört er zur Überschrift und
                 bekommt deren Einzug (die 16 px des Regenbogenbalkens). */ ?>
        <div class="section-head">
            <div class="section-head-text">
                <h2>Wie du bei mir Fahrschüler:in wirst</h2>
                <p class="section-lead">
                    Ich bin angestellte Fahrlehrerin, keine eigene Fahrschule. Die Anmeldung
                    läuft deshalb nicht über diese Seite, sondern über
                    <?= $school !== '' ? school_link() : 'meine Fahrschule' ?>. Sag dort einfach,
                    dass du bei mir fahren möchtest.
                </p>
            </div>
        </div>

        <?php /* HIER STAND DER ABLAUF „SO LÄUFT ES AB", bis zum 21.08.2026
                 (Sarahs Ticket SAR-72). Fünf Schritte als senkrechte Zeitleiste
                 (`.enroll-main` mit `.enroll-steps`), daneben die Kachel der
                 Fahrschule.

                 ER STEHT JETZT NUR NOCH AUF /fahren-mit-handicap, dort in Sarahs
                 eigenem Wortlaut und in vier Schritten. Vorher stand derselbe
                 Ablauf wörtlich auf beiden Seiten – jede Textänderung musste an
                 zwei Stellen gemacht werden, und die Startseite erzählte den Weg
                 zweimal: einmal hier und einmal auf der Unterseite, auf die sie
                 verweist.

                 WAS DIESE SEKTION JETZT NOCH SAGT, ist genau das, wofür sie da
                 ist: Sarah ist angestellt, die Anmeldung läuft über die
                 Fahrschule, und was die übernimmt, steht in der Kachel. Der Weg
                 zur Ausbildung selbst gehört auf die Seite, die davon handelt.

                 Kommt der Ablauf je zurück, steht er in der Versionsgeschichte;
                 `.enroll-steps` in theme.css ist absichtlich stehen geblieben.
                 Die Kachel ist dieselbe wie vorher (`.feature-card`), sie steht
                 jetzt allein – deshalb begrenzt `.enroll` ihre Breite, statt sie
                 über die ganze Seite zu ziehen (Begründung dort). */ ?>
        <div class="enroll enroll--nur-fahrschule">
            <aside class="enroll-formal feature-card">
                <h3><?= $school !== '' ? e($school) : 'Die Fahrschule' ?> übernimmt</h3>
                <ul class="check-list">
                    <li>Anmeldung und Ausbildungsvertrag</li>
                    <li>Theorieunterricht und Lernmaterial</li>
                    <li>Preise und Abrechnung</li>
                    <li>Anmeldung zur Prüfung bei der Führerscheinstelle</li>
                </ul>

                <?php if ($school !== '' && $schoolUrl !== ''): ?>
                    <a class="btn btn-ghost" href="<?= e($schoolUrl) ?>" target="_blank" rel="noopener">
                        Zur <?= e($school) ?> &nearr;
                    </a>
                <?php endif; ?>
            </aside>
        </div>
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

<?php /* Die Wegbegleiter ganz zum Schluss – unter dem Abschluss-CTA und damit
         als Letztes vor dem Fuß. Begründung für Ort und Aufbau steht im
         Partial; hier liegt nur die Entscheidung, dass die Reihe auf die
         Startseite gehört und sonst nirgendwohin. */ ?>
<?php require APP_ROOT . '/app/Views/partials/wegbegleiter.php'; ?>
