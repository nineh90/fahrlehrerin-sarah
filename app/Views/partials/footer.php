<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <?php /* Helle Logo-Variante: auf dem dunklen Fuß wäre der schwarze
                         Schriftzug des Originals nicht lesbar. */ ?>
                <img class="footer-logo" src="<?= asset('img/logo-sarah-hell.webp') ?>"
                     alt="Fahrlehrerin Sarah" width="400" height="462"
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
                    <li><a href="<?= url('/kontakt') ?>">Kontakt</a></li>
                </ul>
            </div>

            <div>
                <h3>Fahrstunden</h3>
                <ul class="footer-links">
                    <li><a href="<?= url('/termine') ?>">Meine freien Zeiten</a></li>
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
                <span class="sep">·</span>
                <a href="<?= url('/meine-website') ?>">Diese Website</a>
                <span class="sep">·</span>
                <a href="<?= url('/admin/login') ?>">Sarahs Schaltzentrale</a>
            </nav>
            <p class="footer-copy">&copy; <?= date('Y') ?> Sarah <?= e(config('contact.city')) ?></p>

            <a class="footer-credit" href="https://nils-digital.de" target="_blank" rel="noopener">
                <img class="footer-credit-mark" src="<?= asset('img/nils-digital-logo.png') ?>"
                     alt="" width="320" height="233" loading="lazy" decoding="async">
                <span>
                    Gemacht mit <span class="heart">&hearts;</span> von
                    <strong>Nils-Digital</strong>
                </span>
            </a>
        </div>
    </div>
</footer>
