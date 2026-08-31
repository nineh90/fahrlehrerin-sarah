<?php $school = (string) config('school.name'); ?>
<section class="page-head">
    <div class="container">
        <?php /* SAR-107, 30.08.2026: „körperlichem" dazu. Die Seite handelt von
                 Technik – Linksgas, Lenkraddrehknopf, Handbedienung –, und wer
                 mit ADHS oder Autismus hier landete, fand nichts von dem, was er
                 gesucht hat. Das steht seit SAR-90 auf /neurodivergenz.

                 Das Wort ist Sarahs eigenes: Ihr Vorspann direkt darunter
                 beginnt mit „Eine körperliche Einschränkung". Die Überschrift
                 sagt jetzt dasselbe wie der erste Satz. */ ?>
        <h1>Fahren mit körperlichem Handicap</h1>
        <?php /* SARAHS VORSPANN, seit dem 21.08.2026 (Ticket SAR-82). Hier
                 stand eine kürzere Fassung von uns: „Mit Kleinwuchs, nach einem
                 Unfall oder mit einer Einschränkung, die dir jemand als
                 Ausschlussgrund verkauft hat: Lass uns darüber reden, bevor du
                 es abhakst."

                 Ihre ist länger und sagt dasselbe in vier Sätzen, aber sie sagt
                 es zu jedem einzeln: kleinwüchsig, nach einem Unfall, eine
                 andere technische Lösung. Der dritte Satz („Vielleicht wurde dir
                 sogar schon gesagt, dass Autofahren für dich nicht möglich sei")
                 nennt beim Namen, was in der alten Fassung nur angedeutet war. */ ?>
        <p class="page-lead">
            Eine körperliche Einschränkung bedeutet nicht automatisch, dass du auf den
            Führerschein verzichten musst. Vielleicht bist du kleinwüchsig, hast nach
            einem Unfall körperliche Einschränkungen oder brauchst beim Fahren eine
            andere technische Lösung. Vielleicht wurde dir sogar schon gesagt, dass
            Autofahren für dich nicht möglich sei. Bevor du diesen Wunsch abhakst, lass
            uns gemeinsam schauen, was möglich ist.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="duo">
            <div class="duo-media photo-wrap">
                <figure class="photo">
                    <img src="<?= asset('img/handicap-linksgas.jpg') ?>"
                         alt="Fußraum eines Fahrschulautos mit Linksgas-Umbau: links neben der
                              Bremse sitzt ein zusätzliches Gaspedal, das über ein grünes
                              Gestänge mit dem originalen Gaspedal verbunden ist"
                         width="1400" height="1050">
                </figure>
            </div>

            <div class="duo-text">
                <?php /* SARAHS FASSUNG, SEIT SAR-82. Sie löst ihre eigene von
                         SAR-52 ab, die hier stand: „Das Foto zeigt einen
                         Linksgas-Umbau. Dabei wird das Gas von rechts auf links
                         mechanisch umgelegt. Das rechte Pedal ist dann für den
                         Gebrauch blockiert." Dazu die Überschrift „Ein
                         angepasstes Auto fährt sich anders, nicht schwerer" –
                         ihr neuer erster Satz sagt dasselbe.

                         NICHTS GEHT DABEI VERLOREN: Was die alte Fassung über
                         den Linksgas-Umbau sagte, steht jetzt eine Kachel
                         weiter unten in ihrer eigenen, ausführlicheren
                         Beschreibung. Der Absatz hier führt dafür in die vier
                         Umbauten ein, statt einen davon vorwegzunehmen.

                         DAS FOTO WIRD NICHT MEHR ERWÄHNT („Das Foto zeigt …").
                         Es steht damit für sich, und was darauf zu sehen ist,
                         sagt sein alt-Text. Das ist die Regel dieser Seite,
                         seit die Bildunterschriften weg sind. */ ?>
                <h2>Autofahren mit angepasster Technik</h2>
                <p>
                    Ein angepasstes Fahrzeug fährt sich nicht unbedingt schwerer – zunächst
                    einfach anders. Je nachdem, was du brauchst, können unterschiedliche
                    technische Hilfsmittel zum Einsatz kommen.
                </p>
                <p>
                    Ich zeige dir in Ruhe, wie die Bedienelemente funktionieren, wir stellen
                    das Fahrzeug passend auf dich ein und du bekommst die Zeit, dich damit
                    vertraut zu machen.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <?php /* DIE VIER UMBAUTEN, in Sarahs Worten seit dem 21.08.2026
                 (SAR-82). Alle vier Texte sind ihre und damit tabu.

                 HIER STAND DIE ÜBERSCHRIFT „WOMIT WIR ARBEITEN" und sie ist
                 ersatzlos weg. Der Grund steht im Abschnitt darüber: Sarahs
                 Text führt die vier dort ein („können unterschiedliche
                 technische Hilfsmittel zum Einsatz kommen"), die Kacheln sind
                 seine Fortsetzung. Eine zweite Überschrift dazwischen wäre eine
                 von uns, mitten in einem Abschnitt, den sie am Stück
                 geschrieben hat.

                 SAR-53 GILT WEITER, deshalb steht die Regel hier als
                 Vorgeschichte: DIESE KARTEN BESCHREIBEN TECHNIK, KEINE KÖRPER.
                 Zwei von ihnen taten bis zum 19.08.2026 beides. „Wenn der
                 rechte Fuß nicht mitmacht" und „wenn die zweite Hand nicht
                 mitarbeiten kann" klingen im ersten Moment schonend, sind es
                 aber nicht: Beide setzen voraus, dass die Gliedmaße da ist und
                 sich nur weigert. Wer ohne rechtes Bein hier liest, bekommt
                 seinen Alltag als Unlust beschrieben.

                 Die Regel für alles, was hier künftig dazukommt: Sag, was der
                 Umbau TUT und wie gefahren wird. Wer ihn braucht, weiß das
                 selbst und muss es nicht von einer Website erklärt bekommen.
                 Kein „wenn X nicht mehr geht", kein „trotz", kein „leider".

                 Sarahs Fassung hält sich daran. Sie nennt Körpergröße bei der
                 Pedalverlängerung, aber als Maß und nicht als Mangel: „wenn
                 Gas, Bremse oder Kupplung aufgrund der Körpergröße nicht sicher
                 erreicht werden können".

                 ZWEI SPALTEN STATT VIER (`--2`): Ihre Texte sind mit 40 bis 50
                 Wörtern rund doppelt so lang wie die Entwürfe, die hier
                 standen. Im Viererraster wären das Spalten von 280 px und
                 vierzehn Zeilen Höhe – dasselbe Problem wie beim Ablauf weiter
                 unten, nur kleiner. Bei zwei Spalten sind es sieben Zeilen. */ ?>
        <div class="card-grid card-grid--2">
            <article class="feature-card">
                <span class="feature-icon"><?= icon('pedal') ?></span>
                <h3>Linksgas</h3>
                <p>
                    Beim Linksgas befindet sich das Gaspedal links neben der Bremse und
                    wird mit dem linken Fuß bedient. Das ursprüngliche Gaspedal wird für
                    die Nutzung entsprechend gesichert. Gerade am Anfang ist die Bedienung
                    ungewohnt. Deshalb üben wir sie Schritt für Schritt, bis deine Abläufe
                    sicher werden.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('knob') ?></span>
                <h3>Lenkraddrehknopf</h3>
                <p>
                    Ein Lenkraddrehknopf ermöglicht es, das Lenkrad sicher mit einer Hand
                    zu führen. Das kann beispielsweise in Verbindung mit einer
                    Handbedienung notwendig sein. Auch hier gilt: Erst kennenlernen, dann
                    ausprobieren und anschließend so lange üben, bis die Bedienung sicher
                    funktioniert.
                </p>
            </article>

            <article class="feature-card">
                <span class="feature-icon"><?= icon('lever') ?></span>
                <h3>Handbedienung</h3>
                <p>
                    Bei einer Handbedienung werden Gas und Bremse nicht mit den Füßen,
                    sondern über eine entsprechende Bedienvorrichtung mit der Hand
                    gesteuert. Das verlangt zunächst Aufmerksamkeit und Koordination. Wir
                    nehmen uns die Zeit, die Bewegungsabläufe gemeinsam aufzubauen und zu
                    festigen.
                </p>
            </article>

            <?php /* Hier stand bis zum 17.08.2026 „Prothesenfahren". Auf Wunsch
                     entfallen (SAR-43), samt Icon und allen Nennungen im Rest der
                     Seite. An seine Stelle trat der Umbau, um den es bei Kleinwuchs
                     geht – die Startseite nennt ihn seit SAR-43, und ohne diese Karte
                     verspräche sie etwas, das die Detailseite nicht kennt.

                     Der Text war bis SAR-82 ein Entwurf von uns; jetzt steht Sarahs
                     eigener da. Der Hinweis von damals, sie müsse ergänzen, welche
                     Systeme sie konkret im Auto hat, ist damit erledigt. */ ?>
            <article class="feature-card">
                <span class="feature-icon"><?= icon('extension') ?></span>
                <h3>Pedalverlängerung</h3>
                <p>
                    Pedalverlängerungen können eingesetzt werden, wenn Gas, Bremse oder
                    Kupplung aufgrund der Körpergröße nicht sicher erreicht werden können.
                    Dabei geht es nicht nur darum, die Pedale zu erreichen. Sitzposition,
                    Sicht, Abstand zum Lenkrad und die sichere Bedienung des Fahrzeugs
                    müssen zusammenpassen.
                </p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="duo duo--text-first">
            <div class="duo-media photo-wrap">
                <?php /* „während des Umbaus" trug bis zum 12.08.2026 die
                         Bildunterschrift. Die ist auf Sarahs Wunsch weg (keine
                         Erklärtexte unter den Fotos mehr), deshalb steht die
                         Einordnung jetzt im alt-Text: Auf dem Bild liegen Teile
                         herum, und ohne den Hinweis liest sich das als Pfusch
                         statt als Zwischenstand. */ ?>
                <figure class="photo photo--right">
                    <img src="<?= asset('img/handicap-handbedienung.jpg') ?>"
                         alt="Fußraum während des Umbaus auf Handbedienung: ein grün lackierter Hebel am Boden, verbunden über grüne Gestänge, daneben eine grüne Abdeckung vor den Pedalen"
                         width="1200" height="1484" loading="lazy" decoding="async">
                </figure>
            </div>

            <div class="duo-text">
                <?php /* SARAHS FASSUNG, SEIT SAR-82. Hier stand ein Entwurf von
                         uns unter der Überschrift „Welche Technik zu dir passt,
                         entscheiden wir gemeinsam".

                         WAS DABEI VERSCHWINDET, gehört gesagt: „Manchmal reicht
                         Linksgas, manchmal braucht es die komplette
                         Handbedienung, manchmal nur eine Automatik und einen
                         anders eingestellten Sitz." Damit steht das Wort
                         „Automatik" auf dieser Seite nicht mehr – auf der
                         Startseite nennt es die Kachel „Klasse B" weiter.
                         Ebenfalls weg: „In der ersten Stunde probieren wir aus,
                         was sich für dich am natürlichsten anfühlt." Den Satz
                         hat der Ablauf darunter längst übernommen, Schritt 3
                         heißt „Kennenlernen & ausprobieren".

                         IHRE FASSUNG SAGT DAFÜR ETWAS, DAS DEM ENTWURF FEHLTE:
                         wer über die Auflagen entscheidet. Der letzte Satz
                         verweist auf die zuständigen Stellen und schlägt damit
                         die Brücke zum Abschnitt „Was wir vorher klären müssen"
                         weiter unten (SAR-84). */ ?>
                <h2>Welche Lösung passt zu dir?</h2>
                <p>
                    Das lässt sich nicht pauschal beantworten – und genau deshalb schauen
                    wir uns deine Situation individuell an. Manchmal reicht eine
                    vergleichsweise kleine Anpassung, manchmal werden weitere technische
                    Hilfsmittel benötigt.
                </p>
                <p>
                    Welche Auflagen für deine Fahrerlaubnis gelten und welche
                    Voraussetzungen erfüllt werden müssen, wird von den zuständigen Stellen
                    geklärt.
                </p>
            </div>
        </div>
    </div>
</section>

<?php /* SARAHS ABSCHNITT ÜBER DIE ZUSAMMENARBEIT, seit dem 23.08.2026
         (Ticket SAR-92). Er stand bis dahin auf /ueber-mich und davor, bis
         zum 17.08.2026, auf der Startseite (SAR-24). Zweimal war er nur
         untergebracht: Auf einer Seite über Sarah las er sich als Vorschau
         auf diese hier, und ihre Kapitel dort sagen dasselbe in Prosa.

         DER TEXT IST VON SARAH, wörtlich seit dem 11.08.2026, und damit tabu
         für Umformulierungen. Die Auslassungspunkte nach der Aufzählung, das
         „normal" in Anführungszeichen und der direkte Satz über das gute
         Gefühl sind ihr Ton. Geändert wurde daran genau eines, schon auf der
         Startseite: Sie schreibt „DU musst ein gutes Gefühl haben", und weil
         Versalien im Web als Schreien gelesen werden, trägt die Betonung
         hier <strong>. Will sie die Großbuchstaben ausdrücklich, ist das ihre
         Entscheidung.

         EIN SATZ VON IHR IST NICHT MITGEZOGEN: „Ein angepasstes Fahrzeug
         fährt sich anders als üblich – nicht schwerer." Er ist die ältere,
         kürzere Fassung dessen, was drei Abschnitte weiter oben schon steht
         („Ein angepasstes Fahrzeug fährt sich nicht unbedingt schwerer –
         zunächst einfach anders", SAR-82, vom 21.08.2026). Beide sind von
         ihr, beide sagen dasselbe, und auf einer Seite untereinander liest
         sich das wie ein Versehen. Der ältere weicht, nicht der jüngere.

         DIE ÜBERSCHRIFT IST VON UNS und war es auch vorher. Auf /ueber-mich
         hieß der Abschnitt „Fahren mit Handicap"; hier oben steht das schon
         als Titel der Seite. „Ich kenne die Technik" ist keine Erfindung,
         sondern ihr eigener Satz aus dem ersten Absatz darunter.

         DER KNOPF „FAHREN MIT HANDICAP" IST WEG, er zeigte von /ueber-mich
         hierher und würde jetzt auf die eigene Seite verweisen. Der Aufruf
         zum Handeln steht im Schlussband unten, einmal pro Seite.

         DAS FOTO ZEIGT SARAH AM TISCH, und es ist die einzige Abbildung von
         ihr auf dieser Seite: Zwischen zwei Fußräumen steht hier der Mensch,
         der darin sitzt. Keine Bildunterschrift, wie überall seit dem
         12.08.2026, was zu sehen ist, sagt der alt-Text.

         SEIT DEM 23.08.2026 IST ES `sarah-hero.jpg` UND NICHT MEHR DER WEITE
         ZUSCHNITT VOM ROLLISTAMMTISCH (`sarah-rollistammtisch.jpg`). Der
         Wunsch kommt von Sarah: „das Foto nochmal tauschen gegen das ohne
         Cola Dose". Auf dem alten steht eine Getränkedose auf dem Tisch, auf
         der Startseite ist sie deshalb schon am 21.08.2026 verschwunden
         (SAR-80). Dieselbe Szene, nur enger geschnitten und ohne die Dose.

         DAMIT STEHT DASSELBE FOTO ZWEIMAL AUF DER WEBSITE, hier und im Hero
         der Startseite. Genau das hatte SAR-80 aufgelöst, damals zwischen
         Startseite und /ueber-mich. Es ist Sarahs Entscheidung und bleibt
         zunächst so; wer es auflösen will, braucht einen zweiten Zuschnitt
         ohne Dose, und der muss aus der Originaldatei kommen.

         Die alte Datei bleibt liegen. Sie ist der einzige weite Zuschnitt und
         zeigt als einzige den Infotisch mitsamt Schild.

         Bild links, Text rechts, also ohne `duo--text-first`: Der Abschnitt
         direkt darüber hat seine Abbildung rechts, und zwei Fotos an
         derselben Kante lesen sich als Spalte. */ ?>
<section class="section section--alt">
    <div class="container">
        <div class="duo">
            <?php /* DER FLECK HINTER DEM FOTO IST GRÜN, seit dem 23.08.2026 und
                     auf Sarahs Wunsch („den Rahmen außen rum in das grün wäre
                     Mega"). Vorher war er orange, gewählt als Abstand zu Teal
                     und Violett der beiden Technikfotos.

                     `--c-green` UND NICHT `--accent`: Der Fleck ist eine
                     Fläche, und dafür ist das helle Regenbogen-Grün da. Das
                     dunkle Sander-Grün von SAR-81 ist die Bedienfarbe für Text
                     und Knöpfe; als 13 % transparente Fläche wäre es ein
                     Grauschleier. Die Regel dazu steht bei den Status-Farben
                     in theme.css. */ ?>
            <div class="duo-media photo-wrap">
                <?php /* SEIT DEM 31.08.2026 DAS ROLLISTAMMTISCH-FOTO (SAR-103).
                         Hier lag `sarah-hero.jpg` – dasselbe Bild, das bis dahin
                         den Hero der Startseite trug. Mit SAR-103 ist es auf
                         /ueber-mich gezogen, und zweimal dieselbe Aufnahme auf
                         zwei Seiten ist genau die Doppelung, die dieses Projekt
                         mehrfach aufgelöst hat (SAR-80, SAR-92).

                         Der enge Ausschnitt vom Rollistammtisch lag seit dem
                         21.08.2026 ungenutzt in public/assets/img und ist
                         seinerzeit für genau so einen Platz neben Fließtext
                         zugeschnitten worden – 680 × 900, also ohne neue
                         Bildbearbeitung verwendbar. Inhaltlich passt er hier
                         besser als vorher: Sarah am Infotisch beim
                         Rollistammtisch, auf einer Seite über das Fahren mit
                         körperlichem Handicap.

                         Hochformat, deshalb `.photo--portrait`: Ohne die
                         Begrenzung bestimmt das Bild die Spaltenhöhe und der
                         Text daneben steht verloren in der Leere. Regel in
                         nd-base.css. */ ?>
                <figure class="photo photo--portrait">
                    <img src="<?= asset('img/sarah-rollistammtisch-nah.jpg') ?>"
                         alt="Sarah an einem Infotisch, daneben eine Tischlampe;
                              vor ihr liegen Karten der Fahrschule"
                         width="680" height="900" loading="lazy" decoding="async">
                </figure>
            </div>

            <div class="duo-text">
                <h2>Ich kenne die Technik</h2>
                <p>
                    Linksgas, Lenkraddrehknopf, Handbedienung für Gas und Bremse …
                    Ich kenne die Technik und weiß, dass es länger dauern kann, bis es
                    sich „normal“ anfühlt.
                </p>
                <p class="statement">
                    Nicht ich muss mich wohl fühlen – <strong>du</strong> musst ein gutes
                    Gefühl haben.
                </p>
                <p>
                    Wir arbeiten auf Augenhöhe miteinander, ich gebe dir nur die
                    Hilfestellung, es selbst zu schaffen.
                </p>
            </div>
        </div>
    </div>
</section>

<?php /* HELL, SEIT SAR-92 (23.08.2026). Der Ablauf stand seit SAR-82
         abgesetzt, weil er damals direkt auf „Welche Lösung passt zu dir?"
         folgte und zwei helle Abschnitte sonst ineinandergelaufen wären.
         Jetzt liegt Sarahs Abschnitt dazwischen und trägt das Dunkle.

         Die Seite wechselt von oben nach unten durchgehend ab: hell,
         abgesetzt, hell, abgesetzt. Wer hier eine Sektion einfügt, dreht
         die Reihenfolge für alles darunter mit, so wie SAR-92 es getan
         hat. */ ?>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>So läuft es ab</h2>
                <?php /* Ihr Vorspann steht IM section-head, nicht als eigener
                         Absatz darunter – dieselbe Stelle wie auf der Startseite
                         bei „Wie du bei mir Fahrschüler:in wirst". Dort steht
                         auch, warum: Im Kopf gehört er zur Überschrift und
                         bekommt deren Einzug, den der Regenbogenbalken vorgibt. */ ?>
                <p class="section-lead">
                    Du musst vorher nicht schon wissen, welche Technik du brauchst oder wie
                    der genaue Weg zu deinem Führerschein aussieht. Wir schauen gemeinsam,
                    wo du gerade stehst und was die nächsten Schritte sind.
                </p>
            </div>
        </div>

        <?php /* SARAHS ABLAUF IN IHRER ZWEITEN FASSUNG, seit dem 21.08.2026
                 (Ticket SAR-83). Wörtlich übernommen und tabu für
                 Umformulierungen, wie alles von ihr.

                 SIE ERSETZT IHRE EIGENE FASSUNG VON SAR-72 vom selben Tag. Beide
                 Texte sind von ihr, dieser ist der jüngere. Er ist deutlich
                 ausführlicher (rund 310 Wörter statt 150), erklärt das
                 Gutachtenverfahren genauer und hat den Schritt „Wir üben in
                 deinem Tempo" wieder, den SAR-72 gestrichen hatte.

                 WAS MIT SAR-72 VERSCHWINDET, gehört ausdrücklich gesagt, weil es
                 Zusagen waren und nicht nur Formulierungen:
                 - „Ich helfe dir weiter bei den notwendigen Unterlagen und
                   Anträgen, wie beispielsweise möglichen Kostenübernahmen bei den
                   Kostenträgern." Die neue Fassung sagt an derselben Stelle „Ich
                   kann dir erklären, was die einzelnen Schritte für deine
                   praktische Fahrausbildung bedeuten" – das ist erklären statt
                   helfen, und die Kostenübernahme kommt gar nicht mehr vor. Auf
                   der ganzen Website steht sie damit nirgends mehr.
                 - Die ersten Runden „auf unserem eigenen Firmengelände".
                 - „Ich sitze zur Prüfung nur noch neben dir und freue mich, wenn
                   du nach erfolgreichem Abschluss den Führerschein in den Händen
                   hältst."
                 Alle drei stehen in der Versionsgeschichte, falls sie
                 zurücksollen.

                 SIE STEHEN UNTEREINANDER, NICHT NEBENEINANDER (`--stapel`).
                 Zuerst mit `--process-cols: 5` gebaut und verworfen: Bei 1440 px
                 waren das fünf Spalten à 215 px und 30 Zeilen Höhe, Schritt 2
                 endete 300 px unter seinen Nachbarn. Bei Schritten von 55 bis 78
                 Wörtern trägt die Reihe nebeneinander nicht mehr. Die Rechnung
                 steht bei der Regel in nd-base.css.

                 DIE FAHRSCHULE STEHT HIER OHNE NAMEN („kümmert sich die
                 Fahrschule um die weiteren Schritte"), anders als in der Fassung
                 davor, die `SCHOOL_NAME` einsetzte. Das ist ihr Wortlaut und
                 bleibt so: Der Name steht auf dieser Seite ohnehin zweimal, im
                 Kasten „Anmeldung und Vertrag" und in der Einordnung unter jeder
                 Seite.

                 DIESER ABLAUF STAND BIS ZUM 21.08.2026 AUCH AUF DER STARTSEITE,
                 dort als senkrechte Zeitleiste. Mit SAR-72 ist er von dort
                 verschwunden; er steht genau einmal – hier. */ ?>
        <ol class="process process--stapel">
            <li class="process-step">
                <span class="process-num">1</span>
                <h3>Wir sprechen miteinander</h3>
                <p>Am Anfang steht ein unverbindliches Telefonat. Du erzählst mir kurz von
                   deiner Situation und davon, was du erreichen möchtest. Ich höre zu,
                   beantworte deine ersten Fragen und sage dir offen, wobei ich dich
                   unterstützen kann – und was von einer zuständigen Stelle oder durch ein
                   Gutachten geklärt werden muss.</p>
            </li>
            <li class="process-step">
                <span class="process-num">2</span>
                <h3>Gutachten &amp; mögliche Auflagen</h3>
                <p>Je nach Art und Umfang deiner Einschränkung kann für die Fahrerlaubnis
                   ein ärztliches oder fachärztliches Gutachten und gegebenenfalls eine
                   weitere Begutachtung erforderlich sein. Dabei wird geklärt, ob und unter
                   welchen Voraussetzungen du ein Fahrzeug führen kannst und welche
                   technischen Anpassungen oder Auflagen notwendig sind. Du musst dich durch
                   diesen Prozess nicht allein durchkämpfen. Ich kann dir erklären, was die
                   einzelnen Schritte für deine praktische Fahrausbildung bedeuten und
                   worauf es anschließend beim Fahren ankommt.</p>
            </li>
            <li class="process-step">
                <span class="process-num">3</span>
                <h3>Kennenlernen &amp; ausprobieren</h3>
                <p>Sobald die Voraussetzungen geklärt sind, geht es an die Praxis. Wir
                   stellen das Fahrzeug und die vorhandenen Hilfsmittel so ein, dass sie zu
                   dir passen. Dann lernst du die Bedienung in Ruhe kennen und bekommst ein
                   Gefühl dafür, wie sich das Fahren damit anfühlt. Ohne Druck und ohne die
                   Erwartung, dass alles sofort funktionieren muss.</p>
            </li>
            <li class="process-step">
                <span class="process-num">4</span>
                <h3>Wir üben in deinem Tempo</h3>
                <p>Dann machen wir das, was Fahrausbildung eigentlich ausmacht: üben,
                   wiederholen und sicherer werden. Manche Abläufe funktionieren schnell,
                   andere brauchen Zeit. Beides ist völlig in Ordnung. Mir ist wichtiger,
                   dass du dich mit dem Fahrzeug und der Technik wirklich sicher fühlst, als
                   dass wir irgendeinen Zeitplan erfüllen.</p>
            </li>
            <li class="process-step">
                <span class="process-num">5</span>
                <h3>Sicher Richtung Prüfung</h3>
                <p>Wenn die notwendigen Voraussetzungen erfüllt sind und du für die Prüfung
                   bereit bist, kümmert sich die Fahrschule um die weiteren Schritte und die
                   Anmeldung bei der Prüfstelle. Bis dahin arbeiten wir gemeinsam daran, dass
                   du das Fahrzeug sicher beherrschst und weißt, was dich in der Prüfung
                   erwartet. Das Ziel ist nicht, irgendwie durch die Prüfung zu kommen. Das
                   Ziel ist, dass du danach selbstständig und sicher unterwegs sein kannst.</p>
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

<?php /* `--alt` seit SAR-92: Der Ablauf darüber ist mit demselben Ticket auf
         hellen Grund gewechselt, also übernimmt dieser Abschnitt das
         Abgesetzte. */ ?>
<section class="section section--alt">
    <div class="container">
        <?php /* SARAHS EIGENER TEXT, seit dem 21.08.2026 (ihr Ticket SAR-84).
                 Wörtlich übernommen und damit tabu für Umformulierungen.

                 HIER STAND DER KASTEN „WAS ICH NICHT BEURTEILEN KANN", ein
                 Entwurf von uns. Er sagte dasselbe in zwei Sätzen; ihre Fassung
                 sagt es genauer (nicht nur „was ich nicht kann", sondern auch,
                 was sie sehr wohl beurteilen kann) und endet mit einer
                 Einladung statt mit einer Grenze.

                 KEIN KASTEN MEHR, sondern ein Abschnitt wie jeder andere. Der
                 Grund ist die Länge: Ein `.notice` ist für einen kurzen
                 Vorbehalt gedacht, ihre drei Absätze sind rund 130 Wörter. In
                 einem gelb geränderten Kasten läse sich das als Warnung, und
                 der letzte Absatz („darfst du dich trotzdem bei mir melden")
                 ist das Gegenteil davon.

                 DIE ÜBERSCHRIFT IST DAMIT NICHT MEHR DIESELBE wie die auf
                 /neurodivergenz. Bis heute hieß sie hier und dort „Was ich
                 nicht beurteilen kann"; dort ist es weiterhin Sarahs Wortlaut
                 und bleibt. */ ?>
        <div class="section-head">
            <div class="section-head-text">
                <h2>Was wir vorher klären müssen</h2>
            </div>
        </div>

        <div class="prose">
            <p>
                Ich bin Fahrlehrerin – keine Ärztin und keine Gutachterin. Deshalb kann
                und werde ich nicht beurteilen, ob du aus medizinischer Sicht
                fahrtauglich bist oder welche Auflagen für deine Fahrerlaubnis notwendig
                sind. Diese Entscheidungen gehören in die Hände der zuständigen
                Fachleute und Behörden.
            </p>
            <p>
                Was ich beurteilen kann: wie du mit der für dich vorgesehenen Technik im
                Fahrzeug zurechtkommst, wo wir in der praktischen Ausbildung ansetzen
                und was wir gemeinsam trainieren können.
            </p>
            <p>
                Wenn du noch ganz am Anfang stehst und nicht weißt, welche Gutachten,
                Nachweise oder nächsten Schritte für dich notwendig sind, darfst du dich
                trotzdem bei mir melden. Wir schauen gemeinsam, wo du gerade stehst – und
                von dort aus geht es weiter.
            </p>
        </div>

        <?php /* DER EINZIGE SATZ DES ALTEN KASTENS, DER ÜBRIG IST, und der
                 einzige Satz dieses Abschnitts, der nicht von Sarah stammt.

                 Ihr Text von SAR-84 deckt die medizinische und behördliche
                 Seite ab, das Vertragliche nicht – er ist ohne diesen Satz
                 geschrieben, weil sie den alten Kasten vermutlich nicht vor
                 sich hatte. Ersatzlos streichen wollten wir ihn nicht: Wer über
                 die Suche direkt auf dieser Seite landet, findet sonst nirgends
                 darauf, wo er sich anmeldet und was es kostet.

                 Er steht als Kasten und nicht im Fließtext darüber, damit die
                 Grenze sichtbar bleibt: oben ihre Worte, hier unsere.

                 Die Einordnung „angestellt, nicht selbstständig" stand bis zum
                 22.08.2026 zusätzlich unter jeder Seite (partials/site-note.php).
                 Seit die Fußnote weg ist, ist dieser Kasten auf dieser Seite die
                 einzige Stelle, die sagt, wo man sich anmeldet – also nicht mehr
                 die Ergänzung einer Einordnung, sondern sie selbst.

                 Fällt er irgendwann weg, ist das kein Verlust an Recht, aber
                 einer an Auskunft. */ ?>
        <div class="notice" style="--card-accent: var(--c-yellow);">
            <?= icon('shield') ?>
            <div>
                <h3>Anmeldung und Vertrag</h3>
                <p>
                    Anmeldung, Vertrag und Preise laufen über
                    <?= $school !== '' ? 'die ' . school_link() : 'die Fahrschule, bei der ich angestellt bin' ?> –
                    ich bin deine Fahrlehrerin, nicht deine Vertragspartnerin.
                </p>
            </div>
        </div>

        <?php /* SAR-65. Die spiegelbildliche Zeile steht auf /neurodivergenz.

                 Diese Seite handelt von der Technik am Auto und vom Weg über
                 die Behörde, die andere davon, wie unterrichtet wird – zwei
                 Seiten, die einander nicht ersetzen. Im Menü stehen sie unter
                 „Schwerpunkte" nebeneinander; hier steht derselbe Weg für
                 alle, die das Menü nicht benutzen.

                 Bewusst eine Fußnote und kein Kasten mit Werbetext: Jede Seite
                 hat genau einen Aufruf zum Handeln, und der steht im
                 Schlussband darunter. */ ?>
        <p class="cross-link">
            Zum anderen Schwerpunkt:
            <a href="<?= url('/neurodivergenz') ?>">Fahrschule &amp; Neurodivergenz</a>
        </p>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <div class="cta-inner">
            <?php /* SARAHS SCHLUSSBAND, ebenfalls SAR-84 und wörtlich von ihr.
                     Vorher stand hier unser Entwurf: „Unsicher, ob das bei dir
                     klappt? Genau dafür ist das erste Telefonat da. Es kostet
                     nichts und du bist danach schlauer."

                     Ihre Fassung ist länger als jedes andere Schlussband der
                     Seite, und das darf sie sein: Sie beantwortet die Frage in
                     der Überschrift Satz für Satz und nimmt jedem die Ausrede,
                     erst noch etwas herausfinden zu müssen. Genau das ist der
                     Grund, warum jemand hier nicht anruft.

                     SEIT SAR-101 (31.08.2026) STEHT IHR TEXT HIER ALLEIN.
                     Der Knopf daneben ist gefallen, also ist auch die
                     Aufschrift weg – das Einzige, was an diesem Band noch von
                     uns war. Begründung eine Ebene tiefer, wo der Knopf
                     stand. */ ?>
            <div class="cta-text">
                <h2>Du weißt noch nicht, ob das bei dir möglich ist?</h2>
                <p>
                    Dann musst du das auch noch nicht wissen. Melde dich einfach bei mir
                    und erzähl mir kurz, worum es bei dir geht. Wir schauen gemeinsam, wo
                    du gerade stehst und welcher nächste Schritt sinnvoll ist. Du musst
                    nicht mit fertigen Antworten zu mir kommen. Eine Frage reicht für den
                    Anfang.
                </p>
            </div>
            <?php /* HIER STAND DER SANDER-KNOPF – gefallen am 31.08.2026 mit
                     Ticket SAR-101 (Sarah: „zu viel Sander"). Damit ist auch
                     SAR-93 hier zurückgenommen, das ihn am 23.08.2026
                     anstelle von „Lass uns reden" gesetzt hatte.

                     DER WIDERSPRUCH LÖST SICH DAMIT VON SELBST, der zuletzt
                     an dieser Stelle als offen vermerkt war: Sarahs Text
                     daneben sagt „Melde dich einfach bei mir und erzähl mir
                     kurz, worum es bei dir geht", der Knopf führte aber zur
                     Fahrschule. Jetzt steht ihre Einladung allein da, und sie
                     meint wieder, was sie sagt.

                     IHR WORTLAUT IST UNBERÜHRT. Weggefallen ist nur der
                     Knopf – deshalb bleibt das Band selbst stehen, anders als
                     auf der Startseite und /ueber-mich, wo der Text unser
                     Entwurf war. */ ?>
        </div>
    </div>
</section>
