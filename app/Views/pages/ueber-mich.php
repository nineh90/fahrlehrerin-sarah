<?php
/* `$schoolUrl` stand hier bis zum 23.08.2026 (SAR-93). Die einzige Stelle, die
   ihn brauchte, war der Knopf zur Fahrschule im Schlussband; der kommt jetzt
   aus `school_cta_button()` und holt sich die Adresse selbst. */
$school = (string) config('school.name');
?>

<?php /* Im Hero steht seit dem 17.08.2026 Sarahs Video (SAR-38). Vorher saß
         hier Sarah im Regenbogenbogen; die Abbildung ist nicht weg, sondern
         eine Sektion tiefer gewandert und trägt jetzt „Über mich" – dort stand
         bis dahin das Rollistammtisch-Foto.

         `hero--video` ist kein Schmuck, sondern nötig: nd-base.css legt die
         Medienspalte eines Heros ab 820 px absolut HINTER den Text, macht sie
         durchscheinend und setzt `pointer-events: none`. Das ist für eine
         dekorative Fläche gedacht. Bei einem Video wäre es doppelt falsch –
         halbtransparent hinter Schrift sieht es nach Fehler aus, und ohne
         Zeigerereignisse ist der Abspielknopf nicht mehr zu treffen. Der
         Modifier schaltet die Mechanik ab, genau wie `hero--photo` auf der
         Startseite (Regeln in theme.css).

         Das Video liegt weiterhin AUCH auf der Startseite, dort mit Text und
         den Kanal-Knöpfen daneben (SAR-28). Hier steht es ohne. */ ?>
<section class="hero hero--video">
    <div class="container hero-inner">
        <div class="duo duo--narrow-media">
            <div class="hero-content">
                <?php /* Hieß bis zum 17.08.2026 „Hallo, ich bin Sarah.", dann kurz
                         „Moin ihr Lieben. Ich bin Sarah." (beides SAR-39).
                         Der Umbruch bleibt an derselben Stelle: Begrüßung oben,
                         Name unten. Er ist hier ein `<br>` und keine Textbreite,
                         weil die Zeile sonst je nach Fenster irgendwo umbricht –
                         mitten in „ihr Lieben" sieht der Gruß aus wie verrutscht.

                         „Lieben" groß: substantiviertes Adjektiv in der Anrede.
                         Kleingeschrieben wäre es ein Rechtschreibfehler auf der
                         ersten Zeile, die jemand von Sarah liest. */ ?>
                <h1>Moin ihr Lieben.<br>Mein Name ist Sarah.</h1>
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
                <?php /* SEIT SAR-54 STEHT HIER NUR NOCH EIN KNOPF (21.08.2026):
                         „Termine" ist weg, solange die Planung nicht öffentlich
                         ist. „Schreib mir" wird dafür der Hauptknopf – ein
                         einzelner Knopf in der Nebenrolle sieht aus, als fehle
                         der eigentliche. Kommt „Termine" zurück, ist auch die
                         Rangfolge wieder die alte. */ ?>
                <div class="hero-actions">
                    <?php if (termine_oeffentlich()): ?>
                        <a class="btn btn-primary btn-lg" href="<?= url('/termine') ?>">Termine</a>
                        <a class="btn btn-ghost btn-lg" href="<?= url('/kontakt') ?>">Schreib mir</a>
                    <?php else: ?>
                        <a class="btn btn-primary btn-lg" href="<?= url('/kontakt') ?>">Schreib mir</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="duo-media photo-wrap">
                <?php /* Dasselbe Video wie auf der Startseite, dieselbe Auszeichnung.
                         Kein autoplay: Das Video hat Ton und startet nur auf Wunsch.
                         `preload="metadata"` lädt bloß die Kopfdaten und nicht die
                         5,7 MB – hier oben im Hero wichtiger als irgendwo sonst,
                         weil der Abschnitt immer im ersten Bildschirm liegt.

                         Die Bildunterschrift bleibt: Sie gehört zum Rahmen und sagt,
                         woher der Ausschnitt kommt. „Ohne Text" im Ticket meinte die
                         Textspalte daneben, nicht sie. */ ?>
                <figure class="video-frame">
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

<section class="section">
    <div class="container">
        <?php /* Bild links, Text rechts (Nils, 14.08.2026). Vorher stand es über
                 `duo--text-first` rechts neben dem Text – dieselbe Seite hat aber
                 direkt darüber schon eine Abbildung rechts: bis SAR-38 Sarah im
                 Bogen des Heros, seitdem ihr Video. Zwei Abbildungen untereinander
                 an derselben Kante lasen sich wie eine Spalte, links blieb nur
                 Text. Der Wechsel gilt also weiter.

                 `duo--stack-text-first` regelt den anderen Fall: Auf schmalen
                 Screens fällt die Spalte weg, und ohne den Modifier stünde das
                 Foto direkt unter der Hero-Abbildung. So kommt erst ihr Text und
                 das Foto danach. */ ?>
        <div class="duo duo--stack-text-first">
            <div class="duo-media photo-wrap">
                <?php /* SARAHS FOTO, seit dem 31.08.2026 (SAR-103).

                         Es stand bis dahin im Hero der Startseite. Dort trägt
                         jetzt ein Hintergrundvideo die Fläche, und ein Foto
                         zusätzlich davor wäre zu viel gewesen – also ist es
                         hierher gezogen, wo eine Seite namens „Über mich"
                         ohnehin ein Bild von ihr verträgt.

                         HIER LAG VORHER DER FREISTELLER `sarah-lockup.webp`
                         (SAR-38): dieselbe Sarah ohne Hintergrund, an der Hüfte
                         beschnitten, mit weichem Auslauf nach unten. Die Datei
                         bleibt liegen, wie alle anderen Fassungen auch
                         (`sarah-messe.jpg`, `sarah-fass.webp`,
                         `sarah-rollistammtisch.jpg`), falls die Entscheidung
                         kippt. Was dabei verloren geht, gehört gewusst: Der
                         Freisteller ließ Sarah frei in der Fläche stehen, das
                         gerahmte Foto setzt sie in einen Kasten. Zwei
                         verschiedene Bildsprachen, und die Seite hat sich für
                         die des Rests der Website entschieden.

                         MIT RAHMEN UND `.photo-wrap`, anders als der
                         Freisteller: Beides ist für ein rechteckiges Foto
                         gedacht und war um eine Silhouette herum falsch. Der
                         Fleck dahinter trägt seit SAR-96 das Sander-Grün.

                         `.photo--portrait` begrenzt das Hochformat – ohne die
                         Regel bestimmt das Bild die Spaltenhöhe und der Text
                         daneben steht verloren in der Leere. */ ?>
                <figure class="photo photo--portrait">
                    <img src="<?= asset('img/sarah-hero.jpg') ?>"
                         alt="Sarah sitzt lächelnd an einem Tisch, den Kopf in die Hand
                              gestützt, daneben eine Tischlampe und ein Becher mit Stiften"
                         width="800" height="1421" loading="lazy" decoding="async">
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

         Ab hier folgen ihre Kapitel in ihrer Reihenfolge und ihrem Wortlaut.
         Es sind seit dem 17.08.2026 drei; das vierte („Mein Ziel: Dein Weg zum
         Führerschein") ist mit SAR-41 entfallen, siehe die Notiz unten am
         Akkordeon. Wo unten von „vier" die Rede ist, ist die Vorgeschichte
         gemeint und nicht der heutige Stand.

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

            <?php /* Hier stand bis zum 17.08.2026 ihr viertes Kapitel „Mein Ziel:
                     Dein Weg zum Führerschein" (Ticket SAR-41 – entfallen).

                     WAS DABEI VON DER SEITE VERSCHWUNDEN IST, denn es stand
                     nirgends sonst: „Ein Führerschein ist weit mehr als ein
                     Dokument", der Satz über den Menschen hinter dem Lenkrad
                     statt dem Handicap, „Individuell. Auf Augenhöhe." und ihre
                     beiden Schlusszeilen über den Weg, der zu dir passt. Alles
                     ihr Wortlaut und in keinem anderen Abschnitt gespiegelt.
                     Wer eine der Zeilen zurückholen will, findet sie in der
                     Versionsgeschichte und in texte-von-sarah.md.

                     Damit endet das Akkordeon jetzt mit „Gemeinsam schauen wir,
                     was möglich ist". Das trägt: Der Abschnitt endet auf ihrem
                     Netzwerk und den Ansprechpartnern, also auf einem Angebot,
                     und nicht mitten im Erzählen. Die Farben der Kapitel rücken
                     von allein nach (Rotation in theme.css). */ ?>
        </div>
    </div>
</section>

<?php /* HIER STAND „FAHREN MIT HANDICAP" bis zum 23.08.2026 (Ticket
         SAR-92). Der ganze Abschnitt ist auf /fahren-mit-handicap gezogen,
         mit Text, Foto und allem: Sarahs Schwerpunkt gehört auf die Seite,
         die ihn behandelt, und nicht als Vorschau auf die Seite über sie.

         Er kam am 17.08.2026 von der Startseite hierher (SAR-24) und war
         schon damals eher untergebracht als zuhause. Der zweite Teil von
         SAR-24 stand als offener Punkt an genau dieser Stelle: Der Abschnitt
         überschnitt sich inhaltlich mit ihren Kapiteln im Akkordeon darüber.
         Damit ist der Punkt erledigt.

         WAS DIESE SEITE DABEI VERLIERT, gehört gesagt: das Foto vom
         Rollistammtisch (es steht jetzt drüben) und den Knopf „Fahren mit
         Handicap". Mit ihm fällt der einzige Weg von hier auf die
         Schwerpunktseite weg, der im Lesefluss lag; über das Menü führt
         „Schwerpunkte" weiterhin dorthin.

         Von Sarahs Sätzen ist einer nicht mitgezogen, der Rest steht drüben
         wörtlich: „Ein angepasstes Fahrzeug fährt sich anders als üblich –
         nicht schwerer." Ihre jüngere Fassung desselben Satzes (SAR-82)
         steht dort bereits im Abschnitt „Autofahren mit angepasster
         Technik". Die Begründung dazu steht in handicap.php, damit sie da
         liegt, wo die Entscheidung wirkt. */ ?>

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

         WIEDER OHNE `--alt`, seit dem 23.08.2026 (SAR-92): Zwischen dem
         Akkordeon und diesem Hinweis stand seit SAR-24 der Schwerpunkt-
         Abschnitt auf hellem Grund, deshalb brauchte es hier den Wechsel.
         Der Abschnitt ist weg, darüber liegt das abgesetzte Akkordeon, und
         zwei abgesetzte Sektionen hintereinander liefen ineinander. */ ?>
<section class="section">
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
                <?php /* ⚠️ ENTWURF, nicht Sarahs Wortlaut. SAR-93, 30.08.2026:
                         Hier stand „Dann melde dich – am besten kurz
                         telefonisch", der Knopf daneben führt aber zur
                         Fahrschule. Zweite Fassung wie auf der Startseite, aus
                         demselben Grund. */ ?>
                <?php if (school_configured()): ?>
                    <p>
                        Dann geht es über die <?= e($school) ?> weiter: Dort meldest
                        du dich an und sagst, dass du zu mir möchtest.
                    </p>
                <?php else: ?>
                    <p>Dann melde dich – am besten kurz telefonisch, das geht am schnellsten.</p>
                <?php endif; ?>
            </div>
            <?php /* NUR NOCH DER WEG ZUR FAHRSCHULE, seit dem 23.08.2026
                     (Ticket SAR-93). Hier standen zwei Knöpfe nebeneinander,
                     „Kontakt" als Hauptknopf und die Fahrschule daneben. Die
                     Begründung dafür stand an dieser Stelle und ist mit dem
                     Knopf hinfällig: Wer gerade über Sarah gelesen habe, wolle
                     SIE fragen und nicht ein Sekretariat.

                     Sarahs Kontakt ist damit von dieser Seite nicht
                     verschwunden: Er steht im Menü, im Fuß und als eigene
                     Seite. Was hier wegfällt, ist der Aufruf am Ende der
                     Seite.

                     DER KNOPF BLEIBT `btn-ghost` und wird nicht zum
                     Hauptknopf: Kevin (23.08.2026) mag die Farbe genau so in
                     der Kachel. Das ist eine Ausnahme von dem, was sonst für
                     einzelne Knöpfe gilt (siehe Hero, SAR-54: ein einzelner
                     Knopf in der Nebenrolle sieht aus, als fehle der
                     eigentliche) – hier ist es Absicht.

                     OFFEN UND NICHT NEBENBEI ENTSCHIEDEN: Der Satz darüber
                     sagt „melde dich, am besten kurz telefonisch", der Knopf
                     führt jetzt auf die Website der Fahrschule. Beides
                     zusammen passt nicht ganz; der Text gehört bei
                     Gelegenheit nachgezogen.

                     Aufschrift, Farbe und der Rückfall ohne konfigurierte
                     Fahrschule stehen seit dem 23.08.2026 in
                     `school_cta_button()` (helpers.php): Seitdem trägt jedes
                     Schlussband der Website denselben Knopf, und der gehört an
                     eine Stelle und nicht in fünf Views. */ ?>
            <div class="cta-actions">
                <?= school_cta_button() ?>
            </div>
        </div>
    </div>
</section>
