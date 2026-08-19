<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <?php /* Helle Logo-Variante: auf dem dunklen Fuß wäre der schwarze
                         Schriftzug des Originals nicht lesbar. */ ?>
                <img class="footer-logo" src="<?= asset('img/logo-sarah-hell.webp') ?>"
                     alt="Fahrlehrerin Sarah" width="393" height="462"
                     loading="lazy" decoding="async">
                <?php /* Hier standen zwei Absätze: eine Selbstbeschreibung („Fahrlehrerin
                         aus Überzeugung …", ein Entwurf) und der Hinweis auf die
                         Fahrschule. Beide sind am 12.08.2026 entfallen, weil direkt
                         darüber Sarahs eigene Einordnung steht (site-note.php) und
                         dasselbe sagt – in ihren Worten statt in geliehenen.
                         Drei Selbstbeschreibungen auf 20 cm Bildschirm sind zwei zu
                         viel. Der Fuß trägt jetzt Logo und Wege, sonst nichts. */ ?>
            </div>

            <div>
                <h3>Über mich</h3>
                <ul class="footer-links">
                    <li><a href="<?= url('/ueber-mich') ?>">Wer ich bin</a></li>
                    <li><a href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a></li>
                    <?php /* Führt auf den Abschnitt unten auf der Startseite und nicht
                             auf eine eigene Übersichtsseite – die gibt es bewusst nicht
                             (Begründung im PartnerController). Der Sprungpunkt heißt
                             `#wegbegleiter` und sitzt am <section> im gleichnamigen
                             Partial; wer den umbenennt, bricht diesen Link hier mit. */ ?>
                    <li><a href="<?= url('/') ?>#wegbegleiter">Wegbegleiter</a></li>
                    <li><a href="<?= url('/kontakt') ?>">Kontakt</a></li>
                </ul>
            </div>

            <div>
                <h3>Fahrstunden</h3>
                <ul class="footer-links">
                    <li><a href="<?= url('/termine') ?>">Termine</a></li>
                    <li><a href="<?= url('/meine-termine') ?>">Meine Stunden</a></li>
                    <li><a href="<?= url('/login') ?>">Anmelden</a></li>
                </ul>
            </div>

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
            <p class="footer-copy">&copy; <?= date('Y') ?> Sarah <?= e(config('contact.city')) ?></p>

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
