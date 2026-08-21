<section class="page-head">
    <div class="container">
        <h1>Datenschutz</h1>
        <p class="page-lead">Was mit deinen Daten passiert – und was nicht</p>
    </div>
</section>

<section class="section">
    <div class="container prose">
        <div class="placeholder-note">
            <strong>Entwurf, juristisch noch nicht geprüft.</strong>
            Der Text beschreibt korrekt, was die Seite technisch tut. Vor dem Livegang
            muss er trotzdem geprüft und um die Hosting-Angaben ergänzt werden
            (Auftragsverarbeitung, Serverstandort, Server-Logfiles).
        </div>

        <h2>Verantwortliche Stelle</h2>
        <?php /* Dieselben Angaben wie im Impressum, seit SAR-15 auch hier echt.
                 Sie MÜSSEN übereinstimmen: Verantwortliche Stelle nach DSGVO und
                 Anbieterin nach DDG sind dieselbe Person, und zwei verschiedene
                 Anschriften auf zwei Rechtsseiten derselben Website sind ein
                 Widerspruch.

                 GENAU DESHALB KOMMT DIE E-MAIL JETZT AUS `config('contact.email')`
                 (21.08.2026): Der Satz „wer eine ändert, ändert beide" stand hier
                 schon vorher – aber solange die Adresse an zwei Stellen im Text
                 stand, war er eine Bitte und keine Zusicherung. Jetzt ist es
                 dieselbe Quelle wie im Impressum, im Fuß und auf /kontakt, und
                 auseinandergehen kann es nicht mehr.

                 DIE ANSCHRIFT BLEIBT AUCH HIER FEST IM TEXT, aus demselben Grund
                 wie drüben: `config('contact.city')` ist Sarahs Einzugsgebiet,
                 nicht die c/o-Anschrift. Ausführlich im Kopf von impressum.php.

                 Eine Telefonnummer verlangt Art. 13 DSGVO hier nicht, die
                 E-Mail genügt als Kontaktdatum des Verantwortlichen. Im
                 Impressum steht sie, weil § 5 DDG einen zweiten Weg zur
                 unmittelbaren Kommunikation verlangt – das ist eine andere
                 Vorschrift mit einem anderen Zweck. */ ?>
        <p>
            Sarah Schweikert<br>
            c/o Online-Impressum 10297, Europaring 90, 53757 Sankt Augustin<br>
            E-Mail: <a href="mailto:<?= e(config('contact.email')) ?>"><?= e(config('contact.email')) ?></a>
        </p>

        <h2>Welche Daten gespeichert werden</h2>
        <p>
            Für Sarahs Stundenplanung werden Name, E-Mail-Adresse und – falls angegeben –
            Telefonnummer der Fahrschüler:innen gespeichert, dazu die eingetragenen,
            verschobenen und abgesagten Fahrstunden. Diese Daten dienen ausschließlich
            der Terminabstimmung zwischen Sarah und ihren Fahrschüler:innen.
        </p>
        <p>
            Die Daten werden nicht an die Fahrschule, an Werbepartner oder an sonstige
            Dritte weitergegeben.
        </p>

        <h2>Zugangsdaten</h2>
        <p>
            Die persönliche PIN wird nicht im Klartext gespeichert, sondern nur als
            kryptografischer Hash. Auch Sarah kann sie nicht auslesen – bei Verlust
            wird eine neue PIN vergeben.
        </p>

        <h2>Cookies</h2>
        <p>
            Diese Website setzt ausschließlich ein technisch notwendiges Sitzungs-Cookie,
            das die Anmeldung während des Besuchs aufrechterhält. Es findet keine Analyse,
            kein Tracking und keine Werbung statt.
        </p>

        <?php /* Der Abschnitt gehört zur Barrierefreiheits-Leiste (SAR-34): Das Panel
                 verlinkt mit „Was gespeichert wird" auf genau diesen Anker. Wer etwas
                 im Browser ablegt, muss sagen, was – auch wenn es die Seite nie
                 verlässt und für eine Einwilligung zu belanglos ist. Wird die Liste
                 der Einstellungen in app/darstellung.php erweitert, gehört dieser
                 Absatz mit angefasst. */ ?>
        <h2 id="darstellung">Deine Darstellungs-Einstellungen</h2>
        <p>
            Über den Knopf am linken Bildschirmrand kannst du Schriftgröße, Abstände,
            Kontrast und ein paar Lesehilfen einstellen. Damit du das nicht auf jeder
            Seite neu machen musst, merkt sich dein Browser deine Auswahl in seinem
            eigenen Speicher (<em>localStorage</em>, Eintrag <code>sarah-a11y</code>).
        </p>
        <p>
            Diese Angaben bleiben auf deinem Gerät. Sie werden nicht an diese Website
            und an niemanden sonst übertragen, nicht ausgewertet und nicht mit anderen
            Daten verknüpft. Im Panel setzt der Knopf „Alles zurücksetzen" den Eintrag
            wieder zurück; du kannst ihn auch jederzeit über die Einstellungen deines
            Browsers löschen.
        </p>

        <h2>Schriftarten</h2>
        <p>
            Die verwendeten Schriftarten liegen auf dem Server dieser Website und werden
            von dort geladen. Es wird keine Verbindung zu Google Fonts oder einem anderen
            fremden Anbieter aufgebaut, deine IP-Adresse verlässt diese Seite also nicht.
        </p>

        <h2>TikTok und Instagram</h2>
        <p>
            Sarahs Kanäle sind ausschließlich verlinkt, nicht eingebettet. Daten werden
            also erst dann an TikTok oder Instagram übertragen, wenn du den Link bewusst
            anklickst und die jeweilige Plattform öffnest. Dort gelten deren
            Datenschutzbestimmungen.
        </p>

        <h2>Deine Rechte</h2>
        <p>
            Du hast das Recht auf Auskunft, Berichtigung, Löschung, Einschränkung der
            Verarbeitung, Datenübertragbarkeit und Widerspruch. Eine kurze Nachricht an
            die oben genannte Adresse genügt – deine Daten werden dann gelöscht.
        </p>
    </div>
</section>
