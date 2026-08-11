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
        <p>
            Sarah <em>[Nachname]</em>, <em>[Anschrift]</em>, <?= e(config('contact.city')) ?>,
            E-Mail: <?= e(config('contact.email')) ?>
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
