<?php
/* IMPRESSUM (SAR-15)
 * -------------------------------------------------------------------------
 * Bis zum 19.08.2026 standen hier Platzhalter in eckigen Klammern. Sarah hat
 * ihr Impressum inzwischen über einen Dienst angelegt:
 * https://mein.online-impressum.de/fahrlehrerinsarah/
 * Die Angaben unten sind von dort übernommen, abgerufen am 19.08.2026.
 *
 * WAS DAS FÜR DIE ADRESSE HEISST: Sie lautet nicht auf Sarahs Wohnort,
 * sondern auf eine c/o-Anschrift des Dienstes in Sankt Augustin. Die Zeile
 * „c/o Online-Impressum 10297" ist Teil der Adresse und darf nicht wegfallen,
 * sonst kann dort keine Post zugeordnet werden. Deshalb steht die Anschrift
 * hier auch fest im Text und nicht über `config('contact.city')`: Der Ort in
 * der .env ist Sarahs Einzugsgebiet und hat mit dieser Adresse nichts zu tun.
 *
 * DIE E-MAIL STEHT HIER FEST IM TEXT und kommt nicht aus der .env. Bis zum
 * 20.08.2026 wich sie deshalb sichtbar ab: Im Impressum stand `sarah@`, auf
 * der Kontaktseite lief `info@`. Seit SAR-65 ist überall `sarah@`, die beiden
 * zeigen also auf dieselbe Adresse.
 *
 * DAS IST KEIN GRUND, HIER AUF `config()` UMZUSTELLEN. Es sind weiterhin zwei
 * verschiedene Fragen: welche Adresse Sarah als Impressumskontakt angegeben
 * hat, und unter welcher Adresse die Seite zum Schreiben einlädt. Sie dürfen
 * wieder auseinandergehen, ohne dass jemand das Impressum anfasst. Ändert sich
 * die Impressumsadresse, gehört sie HIER geändert.
 *
 * Sie ist seit dem 19.08.2026 auch der einzige Kontaktweg auf dieser Seite;
 * der Hinweis auf das Formular beim Dienst ist auf Wunsch entfallen.
 *
 * OFFEN, VOR DEM LIVEGANG ZU KLÄREN: ob die für die Fahrlehrerlaubnis
 * zuständige Behörde genannt werden muss. Der Block „Berufsbezeichnung"
 * unten nennt sie nicht; ihr Impressum tut es auch nicht. Bis das geklärt
 * ist, steht hier lieber gar nichts als eine geratene Behörde. Die
 * Niedersächsische Landesmedienanstalt weiter unten ist etwas anderes: Sie
 * ist die Medienaufsicht und stammt aus Sarahs Impressum.
 *
 * Diese Seite ist NICHT juristisch geprüft. Sie gibt wieder, was Sarah
 * veröffentlicht hat.
 */
?>
<section class="page-head">
    <div class="container">
        <h1>Impressum</h1>
        <p class="page-lead">Angaben gemäß § 5 DDG</p>
    </div>
</section>

<section class="section">
    <div class="container prose">
        <h2>Verantwortlich für diese Seite</h2>
        <p>
            FahrlehrerinSarah<br>
            Sarah Schweikert<br>
            c/o Online-Impressum 10297<br>
            Europaring 90<br>
            53757 Sankt Augustin
        </p>

        <h2>Kontakt</h2>
        <p>
            E-Mail: <a href="mailto:sarah@fahrlehrerinsarah.de">sarah@fahrlehrerinsarah.de</a>
        </p>
        <?php /* HIER STAND DER ZWEITE KONTAKTWEG, bis zum 19.08.2026: ein Satz
                 samt Link auf das Formular in Sarahs Online-Impressum, das den
                 zweiten Kanal nach § 5 DDG stellt. Auf Wunsch wieder raus.

                 Das Formular gibt es weiterhin, es steht nur nicht mehr auf
                 dieser Seite. Wer den Weg zurückholt, findet ihn unter
                 https://mein.online-impressum.de/fahrlehrerinsarah/ */ ?>

        <h2>Zuständige Aufsichtsbehörde</h2>
        <p>
            Niedersächsische Landesmedienanstalt, Sitz: Deutschland
        </p>

        <h2>Zur Einordnung</h2>
        <p>
            Diese Website ist der persönliche Auftritt einer <strong>angestellten
            Fahrlehrerin</strong>. Sie ist keine Fahrschule und tritt auch nicht als
            solche auf. Fahrschulverträge, Anmeldungen, Theorieunterricht und Preise
            liegen ausschließlich bei der Fahrschule, bei der Sarah beschäftigt ist.
            Über diese Seite kommt kein Vertrag zustande.
        </p>

        <h2>Berufsbezeichnung</h2>
        <p>
            Berufsbezeichnung: Fahrlehrerin (verliehen in der Bundesrepublik Deutschland)<br>
            Fahrlehrerlaubnis der Klassen: B, BE<br>
            Es gelten das Fahrlehrergesetz (FahrlG) und die
            Fahrschüler-Ausbildungsordnung (FahrschAusbO).
        </p>

        <h2>Umsetzung der Website</h2>
        <p>
            Gestaltung und technische Umsetzung:
            <a href="https://nils-digital.de" target="_blank" rel="noopener">Nils-Digital</a>.
            Für die Inhalte dieser Seite ist die oben genannte Anbieterin verantwortlich.
        </p>

        <h2>Streitschlichtung</h2>
        <p>
            Wir sind nicht bereit und nicht verpflichtet, an Streitbeilegungsverfahren
            vor einer Verbraucherschlichtungsstelle teilzunehmen.
        </p>
    </div>
</section>
