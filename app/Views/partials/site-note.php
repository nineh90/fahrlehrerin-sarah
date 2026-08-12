<?php
/* Sarahs Einordnung in eigenen Worten – auf JEDER Seite, ganz unten.

   Ihr Wunsch (11.08.2026): „Den Text hier – können wir den irgendwie fixieren?
   Am besten irgendwo unten – auf jeder Seite? Ich denke das passt besser, als
   dass es der Inhalt ist von ‚wie ich dazu gekommen bin'."

   Der Satz stand vorher als erster Absatz auf /ueber-mich und ein zweites Mal
   sinngemäß als Kasten unter dem Hero der Startseite. Beide Stellen sind
   entfallen – er steht jetzt genau einmal pro Seite, dafür überall.

   Warum unten und nicht oben: Es ist eine Fußnote, keine Hauptbotschaft.
   Direkt unter dem Hero las es sich wie eine Entschuldigung dafür, dass hier
   keine Fahrschule steht. Unten ist es das, was es ist: die Einordnung, die
   jemand sucht, der wissen will, mit wem er es zu tun hat.

   Ort und Fahrschule kommen aus der Konfiguration, nicht als fester Text:
   `area_sentence()` und `school_link()` stehen an einem Dutzend Stellen der
   Seite, und sie müssen alle dasselbe sagen. Steht `SCHOOL_NAME` leer,
   formuliert der Satz sich von selbst ohne den Namen.

   <aside>, weil es zum Inhalt der Seite gehört, aber nicht ihr Inhalt ist –
   Vorlesesoftware kann es überspringen. */
$school = (string) config('school.name');
?>
<aside class="site-note">
    <div class="container">
        <p>
            Ich bin Fahrlehrerin für die Klassen B und BE und unterrichte rund um
            <?= e(area_sentence()) ?>.
            Angestellt<?= $school !== '' ? ' bei der ' . school_link() : '' ?>, nicht
            selbstständig – diese Seite ist mein persönliches Schaufenster, keine
            Fahrschul-Website.
        </p>
    </div>
</aside>
