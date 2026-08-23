<?php /* /neurodivergenz – SAR-65, 21.08.2026.

         DER GESAMTE SICHTBARE TEXT DIESER SEITE IST VON SARAH und damit tabu
         für Umformulierungen (siehe CLAUDE.md). Sie hat ihn am Stück
         geschrieben, mit eigenen Zwischenüberschriften; die Aufteilung auf
         Abschnitte, Listen und Kacheln ist von uns, der Wortlaut nicht.

         WAS AN IHRER VORLAGE VERÄNDERT WURDE, vollständig:
         - Ihre Zwischenüberschriften sind Überschriften geworden (h2), nicht
           erster Satz eines Absatzes. Wortlaut unverändert, samt Satzzeichen –
           „Diagnose? Keine Voraussetzung für ein Gespräch." behält den Punkt.
         - Zwei Aufzählungen sind Listen statt Fließtext (siehe unten).
         - Die letzten zwei Sätze stehen im Schlussband statt im Absatz davor.
         Sonst nichts. Kein Satz gekürzt, keiner ergänzt, keine Reihenfolge
         gedreht.

         WARUM DAS EINE EIGENE SEITE IST und kein Abschnitt auf
         /fahren-mit-handicap: Der Anlass war Sarahs Satz „Ich habe bisher
         nicht ein Wort über die Menschen mit unsichtbaren Behinderungen
         gefunden". Als siebter Abschnitt einer fremden Seite wäre es
         weiterhin nicht gefunden. Dazu kommt, dass die beiden Seiten von
         Verschiedenem handeln: dort Technik am Auto und der Weg über die
         Behörde, hier die Art zu unterrichten.

         KEINE HINWEISKÄSTEN, KEINE RATSCHLÄGE VON UNS. Die Seite richtet sich
         an Menschen, die zu viele Reize schlecht vertragen; jeder Kasten, den
         wir dazuerfinden, ist einer mehr. Was hier steht, steht von ihr. */ ?>
<section class="page-head">
    <div class="container">
        <h1>Fahrschule &amp; Neurodivergenz</h1>
        <p class="page-lead">
            Autismus, ADHS oder eine andere Art der Reizverarbeitung müssen kein
            Hindernis für den Führerschein sein. Manchmal braucht es einfach eine
            Fahrausbildung, die anders funktioniert.
        </p>
    </div>
</section>

<?php /* Der Einstieg steht OHNE eigene Überschrift. Sarah hat ihm keine
         gegeben, und eine von uns wäre der einzige Satz auf der Seite, den
         sie nicht geschrieben hat – ausgerechnet der erste. Die Überschrift
         darüber ist die H1, das reicht: Ein Vorspann direkt unter dem Titel
         braucht keine zweite. */ ?>
<section class="section">
    <div class="container">
        <div class="prose">
            <p>
                Vielleicht fällt es dir schwer, gleichzeitig auf den Verkehr zu achten,
                Anweisungen zu verarbeiten und das Fahrzeug zu bedienen. Vielleicht
                überfordern dich viele Reize auf einmal. Vielleicht brauchst du klare
                Abläufe, mehr Wiederholungen oder möchtest vorher genau wissen, was in
                der nächsten Fahrstunde passiert. Oder du hast in einer anderen
                Fahrschule die Erfahrung gemacht, dass dein Verhalten als Desinteresse,
                Unaufmerksamkeit oder fehlende Motivation verstanden wurde.
            </p>
            <p>
                Bei mir musst du nicht so lernen wie alle anderen. Wir schauen, wie du
                am besten lernen kannst.
            </p>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Wenn Fahrschule mehr Kraft kostet</h2>
            </div>
        </div>

        <div class="prose">
            <p>Eine Fahrstunde ist eine ziemlich anspruchsvolle Situation.</p>

            <?php /* SECHS EINWORT-SÄTZE ALS LISTE, nicht als Absatz. Sarah hat
                     sie am Stück geschrieben: „Verkehr beobachten. Schilder
                     wahrnehmen. Spiegel kontrollieren. …" – im Fließtext ist das
                     ein Block aus sechs Punkten, der genau das tut, wovon er
                     handelt: alles auf einmal. Untereinander gesetzt liest man
                     sie einzeln, und die Menge wird sichtbar, statt zu erschlagen.

                     Bewusst OHNE Häkchen (`.check-list`): Das sind keine Vorzüge,
                     sondern die Last, um die es im Absatz danach geht. Ein Haken
                     davor läse sich wie eine Erfolgsliste. */ ?>
            <ul class="beat-list">
                <li>Verkehr beobachten.</li>
                <li>Schilder wahrnehmen.</li>
                <li>Spiegel kontrollieren.</li>
                <li>Geschwindigkeit einschätzen.</li>
                <li>Entscheidungen treffen.</li>
                <li>Das Fahrzeug bedienen.</li>
            </ul>

            <p>Und gleichzeitig spricht neben dir noch jemand.</p>
            <p>
                Für Menschen mit ADHS, Autismus oder einer anderen Form von
                Neurodivergenz kann diese Menge an Informationen besonders
                herausfordernd sein. Das bedeutet nicht automatisch, dass du nicht
                fahren kannst. Es kann bedeuten, dass wir die Art, wie wir es lernen,
                anpassen müssen.
            </p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Was dir beim Lernen helfen kann</h2>
            </div>
        </div>

        <div class="prose">
            <p>
                Es gibt nicht die eine Methode, die für jeden neurodivergenten Menschen
                funktioniert. Deshalb möchte ich zunächst herausfinden, was dir hilft.
                Vielleicht sind es:
            </p>

            <?php /* Neun Punkte. Einspaltig wäre das eine Kolonne, die über den
                     Bildschirmrand hinausläuft – hier stehen sie ab 720 px in
                     zwei Spalten (`--two`, Regel in nd-base.css). Häkchen sind
                     an dieser Stelle richtig: Sarah zählt auf, was hilft. */ ?>
            <ul class="check-list check-list--two">
                <li>klare und direkte Anweisungen</li>
                <li>möglichst wenig unnötiges Reden während anspruchsvoller Situationen</li>
                <li>Abläufe, die wir vorher besprechen</li>
                <li>feste Routinen</li>
                <li>einzelne Schritte statt vieler Informationen gleichzeitig</li>
                <li>Wiederholungen, ohne dass daraus Druck entsteht</li>
                <li>kurze Erklärpausen</li>
                <li>eine klare Rückmeldung dazu, was bereits funktioniert und woran wir noch arbeiten</li>
                <li>die Möglichkeit, Fragen auch mehrmals zu stellen</li>
            </ul>

            <p>
                Und vielleicht brauchst du etwas ganz anderes. Du kennst dich selbst am
                besten. Wenn du bereits weißt, was dir beim Lernen hilft oder was dich
                schnell überfordert, darfst du mir das sagen.
            </p>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <div class="duo">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-teal);">
                <?php /* Das Messefoto lag seit dem 17.08.2026 ungenutzt in
                         public/assets/img – es stand vorher auf /ueber-mich und
                         ist dort dem Freisteller gewichen (SAR-38).

                         Es steht bei DIESEM Abschnitt und nicht weiter oben:
                         „Du musst dich bei mir nicht verstellen" ist der Absatz,
                         in dem es um sie als Person geht und nicht um Methode.
                         Ein Gesicht dazu tut hier mehr als drei Zeilen weiter
                         oben neben einer Aufzählung.

                         Es ist das einzige Bild der Seite, und das ist Absicht.
                         Wer wegen Reizverarbeitung hier liest, braucht keine
                         bebilderte Seite, sondern eine ruhige. */ ?>
                <figure class="photo">
                    <img src="<?= asset('img/sarah-messe.jpg') ?>"
                         alt="Sarah an ihrem Messestand, lächelnd, mit hochgestrecktem Daumen"
                         width="640" height="800" loading="lazy" decoding="async">
                </figure>
            </div>

            <div class="duo-text">
                <h2>Du musst dich bei mir nicht verstellen</h2>
                <p>
                    Manche Menschen haben gelernt, ihre Schwierigkeiten möglichst gut zu
                    überspielen. Das musst du in meiner Fahrschule nicht. Wenn du gerade
                    eine Pause brauchst, sag es. Wenn eine Anweisung für dich nicht
                    eindeutig war, frag nach. Wenn dich etwas überfordert, können wir
                    darüber sprechen. Und wenn du eine Erklärung anders brauchst,
                    versuche ich es anders.
                </p>
                <p>
                    Ich kann dir nicht versprechen, dass jede Fahrstunde entspannt sein
                    wird. Autofahren bedeutet auch, mit unerwarteten Situationen umgehen
                    zu lernen. Aber ich kann darauf achten, wie wir dich darauf
                    vorbereiten.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
            <?php /* Das Fragezeichen mitten in der Überschrift und der Punkt am
                         Ende sind ihre – nicht glätten. */ ?>
                <h2>Diagnose? Keine Voraussetzung für ein Gespräch.</h2>
            </div>
        </div>

        <div class="prose">
            <p>
                Vielleicht hast du eine Diagnose. Vielleicht bist du gerade in einer
                Diagnostik. Vielleicht vermutest du selbst, dass du neurodivergent bist.
                Oder du möchtest dich überhaupt keinem Begriff zuordnen und weißt
                einfach: So, wie andere lernen, funktioniert es für mich nicht besonders
                gut. Auch dann kannst du dich bei mir melden.
            </p>
            <p>
                Für unsere Zusammenarbeit interessiert mich vor allem, was dir beim
                Lernen hilft und wo du Unterstützung brauchst.
            </p>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <?php /* DIESELBE ÜBERSCHRIFT STAND BIS ZUM 21.08.2026 AUCH AUF
                 /fahren-mit-handicap. Dort heißt der Abschnitt seit SAR-84
                 „Was wir vorher klären müssen" – Sarahs eigener Text, der
                 dieselbe Grenze zieht und noch dazu sagt, was sie sehr wohl
                 beurteilen kann.

                 Die beiden Seiten sprechen damit nicht mehr wortgleich, aber
                 im selben Muster: „Ich bin Fahrlehrerin – keine Ärztin und
                 keine Gutachterin" dort, „keine Ärztin und keine
                 Psychotherapeutin" hier. Beide Sätze sind ihre. */ ?>
        <div class="notice" style="--card-accent: var(--c-violet);">
            <?= icon('shield') ?>
            <div>
                <h3>Was ich nicht beurteilen kann</h3>
                <p>
                    Ich bin Fahrlehrerin – keine Ärztin und keine Psychotherapeutin. Ich
                    diagnostiziere weder Autismus noch ADHS und kann nicht beurteilen, ob
                    eine medizinische oder behördliche Abklärung in deinem individuellen
                    Fall erforderlich ist. Wenn entsprechende Fragen für deine
                    Fahrerlaubnis geklärt werden müssen, gehören diese zu den zuständigen
                    Fachleuten und Behörden.
                </p>
                <p>
                    Meine Aufgabe beginnt dort, wo Fahrausbildung beginnt: Ich möchte
                    herausfinden, wie ich dir etwas so vermitteln kann, dass du es
                    verstehen, anwenden und schließlich selbstständig umsetzen kannst.
                </p>
            </div>
        </div>

        <?php /* Der Weg zur Nachbarseite. Bewusst eine nüchterne Zeile und kein
                 Kasten mit Werbetext: Die beiden Seiten stehen im Menü
                 nebeneinander, hier steht nur derselbe Weg für alle, die das
                 Menü nicht benutzen. Auf /fahren-mit-handicap steht die
                 spiegelbildliche Zeile. */ ?>
        <p class="cross-link">
            Zum anderen Schwerpunkt:
            <a href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a>
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Du bist unsicher, ob wir zusammenpassen?</h2>
            </div>
        </div>

        <div class="prose">
            <p>
                Dann können wir genau darüber sprechen. Du musst mir beim ersten Kontakt
                weder deine Lebensgeschichte erzählen noch eine Diagnose erklären. Sag
                mir einfach, was dir beim Lernen wichtig ist oder womit du bisher
                Schwierigkeiten hattest. Dann schauen wir gemeinsam, ob meine Art der
                Fahrausbildung zu dir passt.
            </p>
        </div>
    </div>
</section>

<?php /* DAS SCHLUSSBAND IST IHR LETZTER SATZ, unverändert und ungeteilt:
         „Du musst nicht lernen wie alle anderen. Du musst lernen, sicher Auto
         zu fahren." Die beiden Sätze standen bei ihr am Ende des Absatzes
         darüber; hier tragen sie das Band.

         Das ist der Grund, warum auf dieser Seite kein einziges Wort
         Werbetext von uns steht: Jede andere Seite hat im Schlussband einen
         Satz, den wir geschrieben haben („Genau dafür ist das erste Telefonat
         da"). Hier war er nicht nötig – ihr Schluss ist der bessere.

         Nur die Aufschrift des Knopfes ist von uns, und die ist dieselbe wie
         auf /fahren-mit-handicap. */ ?>
<section class="cta-band">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Du musst nicht lernen wie alle anderen.</h2>
                <p>Du musst lernen, sicher Auto zu fahren.</p>
            </div>
            <?php /* SEIT SAR-93 (23.08.2026) DER WEG ZUR FAHRSCHULE statt
                     „Lass uns reden". Der Knopf kommt aus
                     `school_cta_button()`, Begründung dort.

                     DIE AUFSCHRIFT WAR DAS EINZIGE AUF DIESER SEITE, DAS NICHT
                     VON SARAH IST – der Hinweis eine Zeile höher meinte genau
                     sie. Jetzt steht dort der Name der Fahrschule aus der
                     Konfiguration. Ihr Text darüber ist unberührt, und er
                     endet weiter auf einer Einladung an SIE. */ ?>
            <?= school_cta_button() ?>
        </div>
    </div>
</section>
