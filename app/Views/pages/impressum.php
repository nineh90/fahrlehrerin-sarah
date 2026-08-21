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
 * TELEFON UND E-MAIL KOMMEN AUS `config('contact.*')` – seit dem 21.08.2026,
 * und das ist die Umkehr einer früheren Entscheidung. Bis dahin stand die
 * Adresse hier fest im Text, mit der Begründung, es seien zwei verschiedene
 * Fragen: was Sarah als Impressumskontakt angegeben hat, und unter welcher
 * Adresse die Seite zum Schreiben einlädt. Beides dürfe auseinandergehen.
 *
 * DAS WAR DER FEHLER. Auseinandergegangen ist es nämlich, und zwar genau so,
 * wie es dabei herauskommt: Bis zum 20.08.2026 stand im Impressum `sarah@`
 * und auf der Kontaktseite `info@` – niemandem aufgefallen, bis SAR-65 die
 * Adressen zusammenführte. Die Freiheit, die der Kommentar verteidigte, war in
 * der Praxis nie eine Entscheidung, sondern immer ein Vergessen.
 *
 * Dazu kommt, dass die beiden Stellen unterschiedlich schwer wiegen. Eine
 * veraltete Adresse auf /kontakt ist ärgerlich. Eine veraltete Adresse im
 * Impressum ist ein Mangel nach § 5 DDG. Ausgerechnet die gefährlichere Stelle
 * an der schlechter gepflegten Quelle hängen zu lassen, ist verkehrt herum.
 *
 * DIE ANSCHRIFT BLEIBT FEST IM TEXT, siehe oben – dort ist die Trennung echt:
 * `config('contact.city')` ist Sarahs Einzugsgebiet und hat mit der
 * c/o-Anschrift des Impressumsdienstes nichts zu tun. Wer die beiden
 * zusammenlegt, schreibt Neu Wulmstorf als ladungsfähige Adresse ins
 * Impressum. Ändern also weiterhin HIER.
 *
 * DIE TELEFONNUMMER IST DER ZWEITE KONTAKTWEG. § 5 DDG verlangt neben der
 * E-Mail einen zweiten Weg zur unmittelbaren Kommunikation. Den stellte bis
 * zum 19.08.2026 das Formular des Impressumsdienstes; es ist auf Wunsch
 * entfallen, und danach stand hier nur noch eine Adresse. Sarahs Dienstnummer
 * steht ohnehin im Fuß und auf /kontakt, kostet hier also nichts. Sobald das
 * eigene Kontaktformular steht, gibt es einen dritten Weg – die Nummer darf
 * trotzdem bleiben.
 *
 * TikTok und Instagram zählen NICHT als zweiter Weg: Wer eine DM schreiben
 * will, braucht erst ein Konto bei einem fremden Anbieter.
 *
 * OFFEN, VOR DEM LIVEGANG ZU KLÄREN: ob die für die Fahrlehrerlaubnis
 * zuständige Behörde genannt werden muss. Der Block „Berufsbezeichnung"
 * unten nennt sie nicht; ihr Impressum tut es auch nicht. Bis das geklärt
 * ist, steht hier lieber gar nichts als eine geratene Behörde. Die
 * Niedersächsische Landesmedienanstalt weiter unten ist etwas anderes und
 * steht seit dem 21.08.2026 auch unter der Überschrift „Medienaufsicht", damit
 * die beiden nicht verwechselt werden.
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
        <?php /* Beide Wege aus `config('contact.*')`, dieselbe Quelle wie im Fuß
                 und auf /kontakt – Begründung im Kopf dieser Datei.

                 Der `tel:`-Link wirft die Leerzeichen weg und baut sich seine
                 Fassung damit selbst, genauso wie footer.php und kontakt.php es
                 tun. Deshalb darf in `contact.phone` nichts stehen, was in einer
                 Wählnummer nicht vorkommen darf; der Kommentar dort sagt es
                 auch. */ ?>
        <p>
            Telefon: <a href="tel:<?= e(preg_replace('/\s+/', '', (string) config('contact.phone'))) ?>"><?= e(config('contact.phone')) ?></a><br>
            E-Mail: <a href="mailto:<?= e(config('contact.email')) ?>"><?= e(config('contact.email')) ?></a>
        </p>
        <?php /* HIER STAND EIN DRITTER KONTAKTWEG, bis zum 19.08.2026: ein Satz
                 samt Link auf das Formular in Sarahs Online-Impressum. Auf
                 Wunsch wieder raus. Das Formular gibt es weiterhin, es steht
                 nur nicht mehr auf dieser Seite:
                 https://mein.online-impressum.de/fahrlehrerinsarah/
                 Ein eigenes Kontaktformular ist geplant. */ ?>

        <?php /* ÜBERSCHRIFT „MEDIENAUFSICHT", nicht „Zuständige Aufsichtsbehörde"
                 (21.08.2026). Die Angabe selbst stammt aus Sarahs Impressum und
                 ist regional richtig: Sie wohnt in Niedersachsen, und für
                 Creator auf TikTok und Instagram – also für Sarah – ist die
                 Landesmedienanstalt tatsächlich die Aufsicht, vor allem bei der
                 Werbekennzeichnung.

                 Die alte Überschrift las sich auf einer Fahrlehrerinnen-Seite
                 aber so, als beaufsichtige die NLM ihren Unterricht. Das tut
                 sie nicht, und die für die Fahrlehrerlaubnis zuständige Behörde
                 ist weiterhin ungeklärt (siehe Kopf dieser Datei). Zwei
                 verschiedene Behörden unter einer Überschrift, von denen nur
                 eine dasteht, wäre die schlechteste aller Fassungen. */ ?>
        <h2>Medienaufsicht</h2>
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
