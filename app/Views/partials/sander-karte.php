<?php
/**
 * DIE KACHEL DER FAHRSCHULE (SAR-106, 31.08.2026).
 *
 * Steht seit diesem Ticket auf ZWEI Seiten: in der Sektion „Wie du bei mir
 * Fahrschüler:in wirst" auf der Startseite und in der rechten Spalte von
 * /kontakt. Deshalb liegt sie hier und nicht zweimal im Markup.
 *
 * WARUM DAS NICHT VERHANDELBAR IST: Genau dieselbe Doppelung gab es schon
 * einmal – der Ablauf „So läuft es ab" stand wörtlich auf der Startseite und
 * auf /fahren-mit-handicap, und jede Textänderung musste an zwei Stellen
 * gemacht werden. Mit SAR-72 ist er deshalb auf eine Seite zusammengezogen
 * worden. Hier geht das nicht, die Kachel wird auf beiden Seiten gebraucht –
 * also gibt es sie einmal als Baustein.
 *
 * SIE IST SELBSTVERSORGT: `$school` und `$schoolUrl` liest sie selbst aus der
 * Konfiguration und verlässt sich nicht darauf, dass die einbindende View sie
 * zufällig gesetzt hat. Eine Kachel, die je nach Seite anders aussieht, weil
 * dort eine Variable fehlt, ist die schlimmere Sorte Fehler: Sie fällt beim
 * Bauen nicht auf.
 *
 * OHNE KONFIGURIERTE FAHRSCHULE formuliert sie ohne Namen und lässt den Knopf
 * weg – wie jede andere Stelle der Seite. `school_configured()` ist dieselbe
 * Bedingung, die auch die Schlussbänder lesen (SAR-93).
 *
 * ⚠️ TEXTE SIND ENTWÜRFE und nicht Sarahs Worte. Der Einordnungssatz stand
 * bis SAR-100 im Kopf der Sander-Sektion.
 */
$sanderName = trim((string) config('school.name'));
$sanderUrl  = trim((string) config('school.url'));
?>
<aside class="enroll-formal feature-card">
    <?php /* Steht VOR der Überschrift der Liste, nicht darunter: erst warum,
             dann was. */ ?>
    <p class="enroll-formal-lead">
        Ich bin angestellte Fahrlehrerin, keine eigene Fahrschule. Die Anmeldung
        läuft deshalb nicht über diese Seite, sondern über
        <?= $sanderName !== '' ? school_link() : 'meine Fahrschule' ?>. Sag dort einfach,
        dass du bei mir fahren möchtest.
    </p>
    <h3><?= $sanderName !== '' ? e($sanderName) : 'Die Fahrschule' ?> übernimmt</h3>
    <ul class="check-list">
        <li>Anmeldung und Ausbildungsvertrag</li>
        <li>Theorieunterricht und Lernmaterial</li>
        <li>Preise und Abrechnung</li>
        <li>Anmeldung zur Prüfung bei der Führerscheinstelle</li>
    </ul>
    <?php if (school_configured()): ?>
        <a class="btn btn-ghost" href="<?= e($sanderUrl) ?>" target="_blank" rel="noopener">
            Zur <?= e($sanderName) ?> &nearr;
        </a>
    <?php endif; ?>
</aside>
