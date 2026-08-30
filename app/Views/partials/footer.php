<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <?php /* SAR-49: WORTMARKE ALS TEXT, KEIN LOGO MEHR.
                         Hier lag bis zum 19.08.2026 `logo-sarah-hell.webp`, die
                         helle Fassung von Sarahs Logo. Sie ist nicht sauber
                         freigestellt: Um den Regenbogenbogen steht ein weißer
                         Rand, der auf dem hellen Seitengrund nicht auffällt,
                         auf dem dunklen Fuß aber als Schleier um das ganze
                         Zeichen liegt.

                         Statt die Datei nachzubessern steht hier jetzt der
                         Inhalt des Logos als Text. Das löst nebenbei drei
                         Dinge: Es gibt keinen Rand mehr, der falsch sein kann,
                         die Wortmarke skaliert mit der Schriftgröße aus der
                         Barrierefreiheits-Leiste, und sie kostet keinen Download
                         von 30 kB auf jeder Seite.

                         Der Name steht in EINER Zeile neben dem Regenbogen.
                         Zwischenstand war eine kleine Zeile „Fahrlehrerin" über
                         einem großen „Sarah", wie im Logo gestapelt; auf Wunsch
                         wieder zusammengezogen. Das große Wort war neben den
                         schmalen Spalten daneben zu laut für einen Fuß.

                         Der Regenbogenstrich davor ist derselbe 28 × 3 px Strich
                         wie bei `.hero-eyebrow` (nd-base.css) und damit kein
                         neues Gestaltungsmittel. NICHT als Farbverlauf in der
                         Schrift: Violett kommt auf dem Fuß auf 2,62:1 und fiele
                         für Text durch, auch für großen. Als Strich trägt der
                         Bogen keine Schrift und darf deshalb bunt sein.

                         Die Datei bleibt liegen, sie wird noch gebraucht: Die
                         Seitenleiste der Schaltzentrale zeigt sie weiter
                         (admin/layout.php), und zwar auf demselben dunklen
                         Grund. Der weiße Rand ist dort also genauso zu sehen.
                         Wer ihn dort auch loswerden will, macht dasselbe wie
                         hier oder bessert die Datei nach. */ ?>
                <p class="footer-wordmark">
                    <span class="footer-wordmark-name">Fahrlehrerin Sarah</span>
                    <span class="footer-wordmark-claims">
                        Klasse B <span class="sep" aria-hidden="true">·</span> Klasse BE<br>
                        Handicapausbildung
                    </span>
                </p>
                <?php /* Hier standen zwei Absätze: eine Selbstbeschreibung („Fahrlehrerin
                         aus Überzeugung …", ein Entwurf) und der Hinweis auf die
                         Fahrschule. Beide sind am 12.08.2026 entfallen, weil direkt
                         darüber Sarahs eigene Einordnung stand (site-note.php) und
                         dasselbe sagte – in ihren Worten statt in geliehenen. Die
                         Fußnote selbst ist am 22.08.2026 entfallen; zurückgeholt
                         wurde hier nichts, der Fuß bleibt Wortmarke und Wege.
                         Drei Selbstbeschreibungen auf 20 cm Bildschirm sind zwei zu
                         viel. Der Fuß trägt jetzt Wortmarke und Wege, sonst
                         nichts. */ ?>
            </div>

            <div>
                <h3>Über mich</h3>
                <ul class="footer-links">
                    <li><a href="<?= url('/ueber-mich') ?>">Wer ich bin</a></li>
                    <?php /* Beschriftung wie im Menü (SAR-107): Der Punkt steht
                             direkt über „Neurodivergenz", also genau die Paarung,
                             die deutlich werden soll. Stünde hier weiter „Fahren
                             mit Handicap", widerspräche der Fuß dem Menü. */ ?>
                    <li><a href="<?= url('/fahren-mit-handicap') ?>">Körperliches Handicap</a></li>
                    <?php /* SAR-65. Steht hier FLACH neben den anderen und nicht
                             eingerückt unter „Fahren mit Handicap", obwohl die
                             beiden im Menü eine Gruppe sind: Der Fuß ist eine
                             Liste von Wegen, keine zweite Navigation. Eine
                             Verschachtelung über vier Punkte wäre Aufwand für
                             eine Ordnung, die hier niemand sucht. */ ?>
                    <li><a href="<?= url('/neurodivergenz') ?>">Neurodivergenz</a></li>
                    <?php /* Führt auf den Abschnitt unten auf der Startseite und nicht
                             auf eine eigene Übersichtsseite – die gibt es bewusst nicht
                             (Begründung im PartnerController). Der Sprungpunkt heißt
                             `#wegbegleiter` und sitzt am <section> im gleichnamigen
                             Partial; wer den umbenennt, bricht diesen Link hier mit. */ ?>
                    <li><a href="<?= url('/') ?>#wegbegleiter">Wegbegleiter</a></li>
                    <li><a href="<?= url('/kontakt') ?>">Kontakt</a></li>
                </ul>
            </div>

            <?php /* DIE SPALTE „FAHRSTUNDEN" ALS GANZES, seit SAR-54 nur noch
                     bei eingeschalteter Terminplanung (21.08.2026). Nicht bloß
                     ihre drei Links: Eine Überschrift ohne Punkte darunter ist
                     schlimmer als eine Spalte weniger.

                     Der Fuß steht dann auf drei Spalten statt vier, und seit
                     SAR-94 (23.08.2026) verteilt das Raster sie auch wirklich
                     von selbst. Bis dahin waren vier Spalten fest
                     ausgeschrieben: Die vierte blieb leer am rechten Rand
                     stehen, die drei anderen drängten sich auf zwei Dritteln
                     der Breite, und Sarahs Adresse brach mitten im Wort um.
                     Wie das Raster jetzt zählt, steht bei `.footer-grid` in
                     nd-base.css. Hier ist weiterhin nichts nachzurechnen. */ ?>
            <?php if (termine_oeffentlich()): ?>
                <div>
                    <h3>Fahrstunden</h3>
                    <ul class="footer-links">
                        <li><a href="<?= url('/termine') ?>">Termine</a></li>
                        <li><a href="<?= url('/meine-termine') ?>">Meine Stunden</a></li>
                        <li><a href="<?= url('/login') ?>">Anmelden</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <div>
                <h3>Direkt erreichen</h3>
                <ul class="footer-links">
                    <li><a href="tel:<?= e(preg_replace('/\s+/', '', (string) config('contact.phone'))) ?>"><?= e(config('contact.phone')) ?></a></li>
                    <li><a href="mailto:<?= e(config('contact.email')) ?>"><?= e(config('contact.email')) ?></a></li>
                    <li><a href="<?= e(tiktok_url()) ?>" target="_blank" rel="noopener noreferrer">TikTok</a></li>
                    <li><a href="<?= e(instagram_url()) ?>" target="_blank" rel="noopener noreferrer">Instagram</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <nav class="footer-legal" aria-label="Rechtliches">
                <a href="<?= url('/impressum') ?>">Impressum</a>
                <span class="sep">·</span>
                <a href="<?= url('/datenschutz') ?>">Datenschutz</a>
                <?php /* HIER STAND DER WEG IN SARAHS SCHALTZENTRALE, bis zum
                         19.08.2026 (Ticket SAR-54). Sie ist NICHT weg, nur
                         nicht mehr verlinkt: `/admin/login` gibt es
                         unverändert, Sarah ruft die Adresse direkt auf oder
                         hat sie im Lesezeichen.

                         Warum der Link raus ist: Der Fuß ist der Ort für die
                         Wege, die Besucher:innen gehen sollen. Ein Eingang zur
                         Verwaltung gehört nicht dazu; er lädt Fremde ein,
                         etwas auszuprobieren, was sie nichts angeht, und für
                         Sarah spart er keinen Klick, weil sie ohnehin immer
                         dieselbe Adresse ansteuert.

                         DAS IST KEINE SICHERUNG. Wer die Adresse kennt, kommt
                         weiterhin auf den Login, und das soll auch so sein.
                         Was den Bereich schützt, ist das Passwort und die
                         Anmeldepflicht im AdminAuthController, nicht die
                         Unauffälligkeit der Adresse. Vor Suchmaschinen liegt
                         `/admin` außerdem schon per robots.txt zu (siehe
                         RobotsController).

                         Zwischen Datenschutz und Schaltzentrale stand bis zum
                         17.08.2026 noch „Diese Website", der zweite Weg auf
                         /meine-website. Die Seite ist entfallen, also auch der
                         Link: Ein Eintrag im Fuß, der ins Leere führt, ist
                         schlimmer als gar keiner. Damit ist die Zeile jetzt
                         das, was sie heißt, nämlich Rechtliches und sonst
                         nichts. */ ?>
            </nav>
            <?php /* DER RECHTEINHABER GEHOERT AUSGESCHRIEBEN. Bis zum 21.08.2026
                     stand hier „Sarah" und direkt dahinter der Ort aus der
                     Konfiguration, ohne etwas dazwischen – gelesen wurde daraus
                     „Sarah Neu Wulmstorf", also ein Nachname. Ein Copyright-
                     Vermerk nennt aber genau eine Sache, nämlich wem die Inhalte
                     gehören, und dafür braucht es ihren echten Namen.

                     ZWEITE STELLE MIT IHREM NACHNAMEN: Impressum und
                     Datenschutz (dort als verantwortliche Stelle). Heiratet sie,
                     sind es drei Zeilen, nicht eine. Absichtlich trotzdem nicht
                     aus `config()`: Der Name in einem Copyright-Vermerk und die
                     Anbieterangabe nach § 5 DDG sind zwei verschiedene Aussagen,
                     und die Impressumsseite begründet im Kopf ausführlich, warum
                     sie ihre Angaben fest im Text hält.

                     Der Ort BLEIBT und kommt weiter aus der Konfiguration: Er
                     ist der einzige Ortsbezug, der auf jeder Seite mitläuft, und
                     „Fahrlehrerin in …" sagt dasselbe wie `areaServed` in den
                     strukturierten Daten. Die Marke „Fahrlehrerin Sarah" steht
                     oben im Fuß als Wortmarke – hier unten steht die Person. */ ?>
            <p class="footer-copy">
                &copy; <?= date('Y') ?> Sarah Schweikert
                <span class="sep" aria-hidden="true">·</span>
                Fahrlehrerin in <?= e(config('contact.city')) ?>
            </p>

            <?php /* Hier stand bis zum 17.08.2026 „Gemacht mit ♥ von
                     Nils-Digital" samt Logo. Entfallen mit SAR-32: Der Streifen
                     unter dem Fuß sagt dasselbe, und zweimal derselbe Hinweis
                     auf 10 cm Bildschirm ist einmal zu viel. Der Fuß trägt
                     jetzt Sarahs Wege, ihr Rechtliches und ihr Copyright –
                     sonst nichts. Das CSS (.footer-credit) bleibt in
                     nd-base.css, es gehört zur ND-Signatur. */ ?>
        </div>
    </div>
</footer>
