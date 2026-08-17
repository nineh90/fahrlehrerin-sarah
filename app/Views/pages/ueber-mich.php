<?php
$school    = (string) config('school.name');
$schoolUrl = trim((string) config('school.url'));
?>

<?php /* Hero im Stil der Startseite, aber bewusst NICHT dasselbe Lockup:
         Dort steht die Wortmarke im Bogen, hier steht Sarah drin. Der Name
         steht schon im Header und in der Überschrift – ein zweites Mal wäre
         Logo-Doppelung. Anderer Ausschnitt derselben Aufnahme, damit die
         beiden Seiten nicht wie eine Kopie voneinander wirken. */ ?>
<section class="hero">
    <div class="container hero-inner">
        <div class="duo duo--narrow-media">
            <div class="hero-content">
                <h1>Hallo,<br>ich bin Sarah.</h1>
                <?php /* Der Leitsatz, mit dem Sarahs eigener Text anfängt. Er stand
                         in ihrer Fassung als erste Zeile unter der Überschrift
                         „Über mich" – hier oben trägt er die ganze Seite. Vorher
                         stand an dieser Stelle ein Entwurf („Fahren lernt man nicht
                         durch Druck …"), der nie von ihr war. */ ?>
                <p class="hero-lead">
                    Mobilität bedeutet Freiheit, Selbstständigkeit und Teilhabe.
                </p>
                <p class="hero-meta">
                    <?= icon('pin') ?>
                    <?php /* „Unterwegs in" steht nur noch für Vorlesesoftware da:
                             Sichtbar sagt das Pin-Symbol schon, dass es um Orte
                             geht, und die Zeile liest sich ohne die Einleitung
                             ruhiger. Vorgelesen wären es sonst vier Ortsnamen
                             ohne jeden Zusammenhang – das Symbol ist
                             aria-hidden. */ ?>
                    <span class="sr-only">Unterwegs in </span>
                    <span><?= e(area_sentence()) ?></span>
                </p>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="<?= url('/termine') ?>">Meine freien Zeiten</a>
                    <a class="btn btn-ghost btn-lg" href="<?= url('/kontakt') ?>">Schreib mir</a>
                </div>
            </div>

            <div class="duo-media">
                <div class="hero-arc">
                    <img src="<?= asset('img/sarah-lockup.webp') ?>"
                         alt="Sarah, lächelnd, mit hochgestrecktem Daumen"
                         width="620" height="1130">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php /* Bild links, Text rechts (Nils, 14.08.2026). Vorher stand es über
                 `duo--text-first` rechts neben dem Text – dieselbe Seite hat aber
                 direkt darüber schon eine Abbildung rechts, nämlich Sarah im Bogen
                 des Heros. Zwei Bilder untereinander an derselben Kante lasen sich
                 wie eine Spalte, links blieb nur Text.

                 `duo--stack-text-first` regelt den anderen Fall: Auf schmalen
                 Screens fällt die Spalte weg, und ohne den Modifier stünde das
                 Foto direkt unter der Hero-Abbildung. So kommt erst ihr Text und
                 das Foto danach. */ ?>
        <div class="duo duo--stack-text-first">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-orange);">
                <?php /* Derselbe Moment wie im Schwerpunkt-Abschnitt der Startseite,
                         aber ein deutlich engerer Ausschnitt aus demselben Original –
                         nah an Sarah, mit Tischlampe und etwas Deko (Nils, 12.08.2026).
                         Zwei Zuschnitte eines Fotos auf zwei Seiten lesen sich nicht
                         als Wiederholung, solange sie verschieden genug sind: dort
                         der ganze Tisch, hier ihr Gesicht.

                         Hier lagen zwischenzeitlich zwei andere Bilder – `sarah-messe.jpg`
                         (Ausschnitt mit Messe-Umgebung) und der Freisteller am Fass
                         (`sarah-fass.webp`, entstanden aus Nils' Wunsch, die Aufschrift
                         zu zeigen). Beide liegen weiter im Ordner, falls die
                         Entscheidung noch einmal kippt.

                         Kein Freisteller mehr, also wieder der normale .photo-Rahmen;
                         .photo--portrait bleibt, weil das Hochformat sonst die
                         Spaltenhöhe bestimmt. */ ?>
                <figure class="photo photo--portrait">
                    <img src="<?= asset('img/sarah-rollistammtisch-nah.jpg') ?>"
                         alt="Sarah sitzt lächelnd an ihrem Infotisch, davor eine Tischlampe
                              und ein Schild mit der Aufschrift „Die Rollistammtische“"
                         width="680" height="900">
                </figure>
            </div>

            <div class="duo-text">
                <?php /* AB HIER SARAHS EIGENER TEXT (11.08.2026), wörtlich.
                         Nicht glätten, nicht kürzen, nicht „schöner" formulieren –
                         siehe texte-von-sarah.md und die Offenen Punkte in der
                         CLAUDE.md. Hier stand vorher ein Entwurf mit einer
                         erfundenen Geschichte („weil jemand vor mir saß, dem drei
                         andere abgesagt hatten"). Ihre echte Geschichte steht eine
                         Sektion weiter unten und ist eine völlig andere. */ ?>
                <h2>Über mich</h2>
                <p>
                    Ich bin ausgebildete Heilerziehungspflegerin und Fahrlehrerin aus
                    Leidenschaft. In meiner Arbeit verbinde ich pädagogisches Fachwissen
                    mit fahrpraktischer Kompetenz und einem Erfahrungsschatz, der mich
                    bereits mein ganzes Leben begleitet.
                </p>
                <p>
                    Mein besonderer Schwerpunkt liegt in der Fahrausbildung von Menschen
                    mit Handicap und individuellen Beeinträchtigungen.
                </p>
                <p>
                    Denn ich bin überzeugt: Ein Handicap sollte nicht automatisch
                    bedeuten, auf persönliche Mobilität und die damit verbundene Freiheit
                    verzichten zu müssen.
                </p>

            </div>
        </div>

        <?php /* DAS WICHTIGSTE ÜBER SARAH AUF EINEN BLICK.

                 Ihr Text daneben liest sich in fünf Minuten – diese Box in fünf
                 Sekunden. Beides hat seine Leser: Wer wissen will, wer sie ist,
                 liest den Text; wer prüfen will, ob sie die Richtige ist, sucht
                 Klasse, Gebiet und Schwerpunkt.

                 Die Punkte sind KEINE Erfindung, sondern die Fakten aus ihrem
                 eigenen Text – Heilerziehungspflegerin, Schwerpunkt Handicap,
                 das Netzwerk über die Fahrstunde hinaus. Wer hier etwas ergänzt,
                 muss es dort belegen können.

                 Steht unter der Spalte und nicht darin: Neben dem Foto wäre die
                 Liste eine sechste Zeile im Fließtext geworden, quer über die
                 Breite ist sie ein eigener Block, den man auch überspringen kann.

                 Die ersten drei Punkte tragen bewusst keine Erklärzeile (Sarah,
                 12.08.2026) – sie erklären sich selbst. Die letzten drei brauchen
                 eine: Ein Ort, ein Netzwerk und ein Kanal sind ohne die Angabe,
                 welcher, keine Information. */ ?>
        <div class="info-box">
            <ul class="facts">
                <li>
                    <?= icon('heart') ?>
                    <span><strong>Fahrlehrerin und Heilerziehungspflegerin</strong></span>
                </li>
                <li>
                    <?= icon('car') ?>
                    <span><strong>Klasse B und BE</strong></span>
                </li>
                <li>
                    <?= icon('wheelchair') ?>
                    <span><strong>Ausbildung mit Handicap</strong></span>
                </li>
                <li>
                    <?= icon('shield') ?>
                    <span>
                        <strong>Netzwerk aus Fachstellen</strong>
                        <span>Unterstützung auch über die Fahrstunde hinaus</span>
                    </span>
                </li>
                <li>
                    <?= icon('pin') ?>
                    <span>
                        <strong>Unterwegs in</strong>
                        <span><?= e(implode(' · ', config('contact.area'))) ?></span>
                    </span>
                </li>
                <li>
                    <?= icon('chat') ?>
                    <span>
                        <strong>Auch online</strong>
                        <?php /* Die Kanalnamen sind die Links, nicht ein „hier"
                                 daneben: Wer „TikTok" liest, klickt darauf.
                                 Ziele kommen aus der Konfiguration (tiktok_url(),
                                 instagram_url()) – dieselben Adressen wie im
                                 Fuß und auf der Kontaktseite. */ ?>
                        <span>
                            Auf <a href="<?= e(tiktok_url()) ?>" target="_blank" rel="noopener noreferrer">TikTok</a>
                            und <a href="<?= e(instagram_url()) ?>" target="_blank" rel="noopener noreferrer">Instagram</a>
                        </span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</section>

<?php /* An dieser Stelle stand ein Zitat in Anführungszeichen unter Sarahs
         Namen – erfunden, wie alle Zitate auf der Seite. Es ist entfallen, weil
         ab hier ihre echten Sätze stehen. Ein erfundener daneben wäre nicht nur
         überflüssig, sondern peinlich.

         Ab hier folgen ihre vier Kapitel in ihrer Reihenfolge und ihrem
         Wortlaut.

         SIE STEHEN SEIT DEM 13.08.2026 ZUM ANLESEN DA (Sarahs Wunsch: „zu
         viel Text macht es unübersichtlich … vielleicht Reiter, die man
         anklickt"). Vorher waren es vier volle Abschnitte untereinander,
         abwechselnd getönt – rund 370 Wörter am Stück und mehrere
         Bildschirmlängen Scrollen. Jetzt zeigt jedes Kapitel Überschrift und
         ersten Absatz, der Rest kommt über „Mehr lesen".

         Drei Entscheidungen dahinter, die nicht willkürlich sind:

         · IHR WORTLAUT IST UNVERÄNDERT. Gekürzt wurde nichts, geschrieben
           wurde nichts – nur die Verpackung ist eine andere. Ihre Sätze,
           ihre Absatzbrüche, ihre Reihenfolge. Wer hier beim Umbauen
           „strafft", macht aus ihrem Text wieder einen Entwurf (siehe
           CLAUDE.md, Offene Punkte).

         · DER TEASER IST IHR ERSTER ABSATZ, nicht eine Zusammenfassung
           davon. Das ist der ganze Punkt: Eine Zusammenfassung wäre eine
           fremde Stimme über ihrer, und genau die soll auf dieser Seite
           nirgends stehen. Wo der Schnitt liegt, ist deshalb keine
           Geschmacksfrage – er liegt hinter dem ersten Absatz, weil das die
           einzige Stelle ist, die niemand erfunden hat.

         · REINE ÜBERSCHRIFTEN REICHTEN NICHT. Eine erste Fassung klappte die
           Kapitel komplett zu; „Über mich" bestand dann aus vier Zeilen, die
           nichts über ihren Inhalt verrieten. Angelesen entscheidet man, ob
           man weiterliest – bei einer bloßen Überschrift entscheidet man nur,
           ob man einen Klick riskiert.

         Was NICHT hinter den Klick gewandert ist: ihr Einstiegstext und die
         Info-Box weiter oben. Die tragen die Seite und dürfen niemanden einen
         Klick kosten.

         Kein `name`-Attribut, die Abschnitte sind also unabhängig: Bei einem
         echten Akkordeon fällt das gerade Gelesene zu, sobald man das nächste
         öffnet – die Seite springt einem unter dem Finger weg. Kurz bleibt
         sie hier ohnehin, weil zugeklappt schon jedes Kapitel etwas zeigt. */ ?>
<section class="section section--alt">
    <div class="container">
        <div class="accordion">
            <article class="accordion-item">
                <h2 class="accordion-title">Warum mir diese Arbeit besonders am Herzen liegt</h2>
                <p class="accordion-teaser">
                    Aufgewachsen bin ich im schönen Hannover als ältestes von drei Kindern.
                    Meine beiden jüngeren Geschwister kamen mit geistigen und körperlichen
                    Beeinträchtigungen zur Welt.
                </p>
                <details>
                    <summary class="accordion-more">
                        <span class="accordion-more-open">Mehr lesen</span>
                        <span class="accordion-more-close">Weniger anzeigen</span>
                        <span class="accordion-chevron" aria-hidden="true"></span>
                    </summary>
                    <div class="accordion-body">
                        <p>
                            Dadurch durfte ich schon sehr früh lernen, dass Menschen unterschiedliche
                            Voraussetzungen mitbringen – und dass manchmal einfach ein anderer Weg
                            notwendig ist, um das gleiche Ziel zu erreichen.
                        </p>
                        <p>Diese Erfahrung prägt meine Arbeit bis heute.</p>
                        <p class="statement">
                            Ich sehe nicht zuerst die Einschränkung. Ich schaue auf den Menschen,
                            seine Fähigkeiten, seine Möglichkeiten und darauf, was wir gemeinsam
                            erreichen können.
                        </p>
                    </div>
                </details>
            </article>

            <article class="accordion-item">
                <h2 class="accordion-title">Fahrlehrerin und Pädagogin – eine besondere Kombination</h2>
                <p class="accordion-teaser">
                    Meine Ausbildung zur Heilerziehungspflegerin und meine Erfahrung im
                    pädagogischen Bereich ermöglichen es mir, Fahrausbildung noch einmal aus
                    einer anderen Perspektive zu betrachten.
                </p>
                <details>
                    <summary class="accordion-more">
                        <span class="accordion-more-open">Mehr lesen</span>
                        <span class="accordion-more-close">Weniger anzeigen</span>
                        <span class="accordion-chevron" aria-hidden="true"></span>
                    </summary>
                    <div class="accordion-body">
                        <p>
                            Menschen lernen unterschiedlich. Manche benötigen mehr Zeit, andere eine
                            besondere Form der Erklärung, mehr Wiederholungen, klare Strukturen oder
                            individuell angepasste Lernwege.
                        </p>
                        <p>Genau darauf kann ich eingehen.</p>
                        <p>
                            Für mich geht es deshalb nicht darum, eine klassische Fahrausbildung
                            einfach auf einen Menschen mit Handicap zu übertragen. Es geht darum, die
                            Fahrausbildung an den Menschen anzupassen.
                        </p>
                        <p>
                            Mit Geduld, Ruhe, Empathie und der notwendigen fachlichen Kompetenz möchte
                            ich meinen Fahrschülerinnen und Fahrschülern einen geschützten Rahmen
                            geben, in dem sie lernen, Sicherheit gewinnen und Vertrauen in die eigenen
                            Fähigkeiten entwickeln können.
                        </p>
                    </div>
                </details>
            </article>

            <article class="accordion-item">
                <h2 class="accordion-title">Gemeinsam schauen wir, was möglich ist</h2>
                <p class="accordion-teaser">
                    Eine körperliche, geistige oder andere Beeinträchtigung kann viele Fragen
                    rund um den Führerschein mit sich bringen.
                </p>
                <details>
                    <summary class="accordion-more">
                        <span class="accordion-more-open">Mehr lesen</span>
                        <span class="accordion-more-close">Weniger anzeigen</span>
                        <span class="accordion-chevron" aria-hidden="true"></span>
                    </summary>
                    <div class="accordion-body">
                        <?php /* Sarah hat die fünf Fragen als eigene Zeilen geschrieben, nicht
                                 als Fließtext – also stehen sie auch hier untereinander. Ohne
                                 Häkchen davor: Häkchen machen aus Fragen Merkmale, und das
                                 sind es nicht. */ ?>
                        <ul class="question-list">
                            <li>Kann ich überhaupt einen Führerschein machen?</li>
                            <li>Welche Voraussetzungen muss ich erfüllen?</li>
                            <li>Benötige ich ein speziell angepasstes Fahrzeug?</li>
                            <li>Welche Gutachten oder Genehmigungen sind notwendig?</li>
                            <li>Und wer kann mich auf diesem Weg unterstützen?</li>
                        </ul>
                        <p>
                            Mit diesen Fragen müssen meine Fahrschülerinnen und Fahrschüler und ihre
                            Familien nicht allein bleiben.
                        </p>
                        <p>
                            Durch meinen langjährigen Erfahrungsschatz und mein breit gefächertes
                            Netzwerk aus Fachstellen, Hilfsorganisationen und kompetenten Partnern
                            kann ich auch über die eigentliche Fahrstunde hinaus unterstützen,
                            Orientierung geben und bei Bedarf die richtigen Ansprechpartner
                            zusammenbringen.
                        </p>
                    </div>
                </details>
            </article>

            <article class="accordion-item">
                <h2 class="accordion-title">Mein Ziel: Dein Weg zum Führerschein</h2>
                <?php /* Ihr kürzester Kapitelanfang – ein einzelner Satz. Er bleibt
                         trotzdem allein stehen, obwohl der Teaser damit kürzer ist als
                         die drei anderen: Der Satz stellt eine Behauptung auf, deren
                         Begründung im nächsten Absatz steht. Genau das ist ein
                         Anlesetext. */ ?>
                <p class="accordion-teaser">Ein Führerschein ist weit mehr als ein Dokument.</p>
                <details>
                    <summary class="accordion-more">
                        <span class="accordion-more-open">Mehr lesen</span>
                        <span class="accordion-more-close">Weniger anzeigen</span>
                        <span class="accordion-chevron" aria-hidden="true"></span>
                    </summary>
                    <div class="accordion-body">
                        <p>
                            Er kann ein großes Stück Freiheit, Unabhängigkeit, Selbstbestimmung und
                            gesellschaftliche Teilhabe bedeuten.
                        </p>
                        <p>
                            Deshalb steht für mich nicht das Handicap im Mittelpunkt, sondern der
                            Mensch hinter dem Lenkrad.
                        </p>
                        <p>
                            Ich möchte gemeinsam mit dir herausfinden, welcher Weg für dich der
                            richtige ist und was du brauchst, um dein persönliches Ziel zu erreichen.
                        </p>
                        <p>
                            Individuell. Auf Augenhöhe. Mit Geduld, Fachwissen und dem Blick für das,
                            was möglich ist.
                        </p>
                        <?php /* Ihre beiden Schlusszeilen. Sie stehen bei ihr getrennt und
                                 tragen genau dadurch – zusammengezogen zu einem Satz wären sie
                                 eine Floskel. */ ?>
                        <p class="statement">
                            Denn manchmal braucht es keinen einfacheren Weg.<br>
                            Sondern einen Weg, der zu dir passt.
                        </p>
                    </div>
                </details>
            </article>
        </div>
    </div>
</section>

<?php /* Fahren mit Handicap: Sarahs Schwerpunkt.

         STAND BIS ZUM 17.08.2026 AUF DER STARTSEITE und ist auf Sarahs
         Wunsch komplett hierher gezogen (Ticket SAR-24) – Text, Foto und
         Knopf unverändert übernommen. Die Startseite hat die Sektion nicht
         mehr.

         DIESER TEXT IST VON SARAH – wörtlich, seit dem 11.08.2026. Nicht
         „glätten": Die Auslassungspunkte nach der Technik-Aufzählung, das
         „normal" in Anführungszeichen und der direkte Satz über das gute
         Gefühl sind ihr Ton. Wer hier umformuliert, macht daraus wieder
         einen Entwurf.

         Geändert wurde genau eines: Sie schreibt „DU musst ein gutes Gefühl
         haben". Versalien lesen sich im Web als Schreien, die Betonung trägt
         hier <strong>. Falls sie die Großbuchstaben ausdrücklich will, ist
         das ihre Entscheidung – dann zurückändern.

         Neben dem Text stand bis zum 12.08.2026 das Linksgas-Foto. Sarahs
         Wunsch: Die Technikfotos gehören auf /fahren-mit-handicap, hier
         steht sie selbst.

         Das Foto zeigt sie am Infotisch beim Rollistammtisch – also genau in
         dem Umfeld, um das es im Text daneben geht. Das fremde Branding im
         Hintergrund (Wandmuster des Veranstalters, das Schild auf dem Tisch)
         bleibt sichtbar, dieselbe Entscheidung wie beim Fahrschulauto
         (Nils, 12.08.2026): Es zeigt, wo sie unterwegs ist.

         Keine Bildunterschrift – seit dem 12.08.2026 die Regel für die ganze
         Seite: Was das Bild zeigt, steht im alt-Attribut, und das liest nur
         vor, wer es braucht.

         NOCH OFFEN (SAR-24, zweiter Teil): Diese Seite trägt jetzt zweimal
         denselben Moment – hier der weite Zuschnitt vom Rollistammtisch, weiter
         oben neben ihrem Über-mich-Text der nahe. Und inhaltlich überschneidet
         sich der Abschnitt mit ihren Kapiteln darüber. Beides wird in einem
         eigenen Durchgang aufgeräumt, nicht nebenbei.

         `.section` statt `.section--alt` wie auf der Startseite: Davor steht
         hier das Akkordeon, und das ist bereits abgesetzt. Deshalb wechselt
         der Anmelde-Hinweis darunter auf `--alt`, damit der Hell-Dunkel-
         Wechsel der Seite bestehen bleibt. */ ?>
<section class="section">
    <div class="container">
        <div class="duo duo--text-first">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-teal);">
                <?php /* Hochformat, deshalb .photo--portrait: Ohne die Begrenzung
                         bestimmt das Bild die Spaltenhöhe und der Text daneben
                         steht verloren in der Leere. */ ?>
                <figure class="photo photo--portrait">
                    <img src="<?= asset('img/sarah-rollistammtisch.jpg') ?>"
                         alt="Sarah sitzt lächelnd an einem Infotisch; davor liegen Karten
                              der Fahrschule, eine Schale Bonbons und ein Schild mit der
                              Aufschrift „Die Rollistammtische“"
                         width="900" height="1021" loading="lazy" decoding="async">
                </figure>
            </div>

            <div class="duo-text">
                <span class="section-eyebrow" style="padding-left:0;">Mein Schwerpunkt</span>
                <h2>Fahren mit Handicap</h2>
                <p>
                    Ein angepasstes Fahrzeug fährt sich anders als üblich – nicht schwerer.
                </p>
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
                <div class="duo-actions">
                    <a class="btn btn-primary" href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php /* Hier stand „Wie eine Stunde bei mir abläuft", daneben das Foto des
         Fahrschulautos. Beides ist am 12.08.2026 auf Sarahs Wunsch entfallen:
         Nach ihrem eigenen Text las sich der Ablauf einer einzelnen Fahrstunde
         wie ein Anhang, und diese Seite soll von ihr handeln, nicht von der
         Organisation.

         Der Ablauf steht jetzt auf /fahren-mit-handicap – ihr Vorschlag –, dort
         direkt hinter „So läuft es ab": erst der Weg zum Führerschein, dann die
         einzelne Stunde. Das Foto des Fahrschulautos ist damit vorerst nirgends
         eingebunden; die Datei bleibt liegen.

         Achtung, der Text dort ist weiter ein ENTWURF und nicht von Sarah. */ ?>

<?php /* Die Arbeitsteilung stand auf dieser Seite bisher nirgends. In der
         Prosa oben heißt es nur „angestellt" – dass Anmeldung, Vertrag,
         Theorie und Preise über die Fahrschule laufen und nicht über Sarah,
         erfuhr man ausschließlich auf der Startseite. Wer über eine Suche
         direkt hier landet, hat diese Sektion nie gesehen.

         Bewusst kurz gehalten und nicht die ganze Startseiten-Sektion
         wiederholt: Hier geht es um Sarah, die Fahrschule ist die Fußnote
         dazu. Prüft auf leeren SCHOOL_NAME, wie alle anderen Stellen auch.

         `--alt` seit dem 17.08.2026: Darüber steht jetzt der Schwerpunkt-
         Abschnitt auf hellem Grund (SAR-24). Ohne den Wechsel liefen zwei
         gleich helle Sektionen ineinander. */ ?>
<section class="section section--alt">
    <div class="container">
        <div class="notice" style="--card-accent: var(--c-blue);">
            <?= icon('shield') ?>
            <div>
                <h3>Anmelden kannst du dich nicht bei mir</h3>
                <p>
                    Ich bin angestellte Fahrlehrerin<?= $school !== '' ? ' bei der ' . school_link() : '' ?> –
                    Anmeldung, Ausbildungsvertrag, Theorieunterricht und Preise laufen dort.
                    Bei mir sitzt du im Auto: alle Fahrstunden von der ersten bis zur Prüfung.
                </p>
                <p>
                    Sag bei der Anmeldung einfach, dass du bei mir fahren möchtest.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Klingt nach dir?</h2>
                <p>Dann melde dich – am besten kurz telefonisch, das geht am schnellsten.</p>
            </div>
            <?php /* Zwei Wege nebeneinander, in dieser Reihenfolge: Wer gerade
                     über Sarah gelesen hat, will SIE fragen und nicht ein
                     Sekretariat – deshalb bleibt der Kontakt der Hauptknopf.
                     Der Weg zur Fahrschule steht daneben, ruhiger, für alle,
                     die schon entschieden sind. */ ?>
            <div class="cta-actions">
                <a class="btn btn-primary btn-lg" href="<?= url('/kontakt') ?>">Kontakt</a>
                <?php if ($school !== '' && $schoolUrl !== ''): ?>
                    <a class="btn btn-ghost btn-lg" href="<?= e($schoolUrl) ?>"
                       target="_blank" rel="noopener">Zur <?= e($school) ?> &nearr;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
