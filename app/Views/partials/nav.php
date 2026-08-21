<header class="site-header">
    <div class="container header-inner">
        <?php /* EIN LOGO, ZWEI GRÖSSEN.

                 Sarahs volles Logo steht oben groß und ragt unter der Leiste
                 hervor; beim Scrollen wird es kleiner. Mehr passiert nicht –
                 das Logo selbst bleibt in jedem Zustand dasselbe Bild.
                 Eine frühere Fassung tauschte es beim Scrollen gegen den
                 reinen Bogen aus; das war auf Wunsch von Nils falsch: Ein
                 Logo, das sich beim Scrollen verwandelt, prägt sich nicht ein.

                 Bis zum 17.08.2026 blendete beim Scrollen zusätzlich eine
                 Wortmarke als echter Text daneben ein („Fahrlehrerin Sarah" /
                 „Klasse B · BE · Handicap"). Sie ist mit SAR-37 entfallen; die
                 Bewegung des Logos bleibt. Der Markenblock trägt jetzt nur noch
                 das eine Bild – die Regeln, die den Text ein- und ausblendeten,
                 sind in nd-base.css mit weg, sonst wäre die Animation nur ihres
                 Inhalts beraubt und nicht entfernt.

                 Das Bild trägt alt="" – den Namen trägt das aria-label am
                 Link. Das war schon vorher so und ist jetzt die EINZIGE Quelle
                 des Namens im Header: Wer das aria-label entfernt, nimmt der
                 Vorlesesoftware den Namen der Seite ersatzlos weg. */ ?>
        <a class="brand" href="<?= url('/') ?>" aria-label="Fahrlehrerin Sarah – zur Startseite">
            <img class="brand-logo brand-logo--full" src="<?= asset('img/logo-sarah-klein.webp') ?>"
                 alt="" width="255" height="300">
        </a>

        <button class="nav-toggle" type="button" aria-label="Menü öffnen" aria-expanded="false" aria-controls="mainNav">
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" id="mainNav">
            <?php /* SAR-48. Der Weg zurück auf die Startseite steht ZWEIMAL im
                     Header: als Logo und als Menüpunkt. Das ist keine Dopplung aus
                     Versehen. Dass ein Logo zur Startseite führt, ist eine erlernte
                     Konvention – wer sie nicht kennt, sieht dort nur ein Bild und
                     findet im Menü keinen Weg heim. Der Menüpunkt ist für ihn da.

                     Er steht vorn, weil er die oberste Ebene ist; alles danach
                     liegt darunter. Und er ist der einzige Punkt, dessen aktiver
                     Zustand exakt passen muss: nav_active('/') vergleicht bei '/'
                     auf Gleichheit statt auf Präfix (siehe helpers.php), sonst
                     wäre er auf JEDER Seite hervorgehoben.

                     Er kostet Breite und hat damit den Umschaltpunkt des Headers
                     verschoben – die Rechnung steht in nd-base.css beim
                     1120-px-Block. Wer diesen Punkt wieder entfernt, darf die
                     Grenze dort senken. */ ?>
            <a class="nav-link<?= nav_active('/') ?>" href="<?= url('/') ?>">Startseite</a>
            <a class="nav-link<?= nav_active('/ueber-mich') ?>" href="<?= url('/ueber-mich') ?>">Über mich</a>
            <a class="nav-link<?= nav_active('/fahren-mit-handicap') ?>" href="<?= url('/fahren-mit-handicap') ?>">Fahren mit Handicap</a>
            <a class="nav-link<?= nav_active('/kontakt') ?>" href="<?= url('/kontakt') ?>">Kontakt</a>

            <?php if (StudentAuth::check()): ?>
                <a class="nav-link<?= nav_active('/meine-termine') ?>" href="<?= url('/meine-termine') ?>">Meine Stunden</a>
                <form class="inline-form" method="post" action="<?= url('/logout') ?>">
                    <?= csrf_field() ?>
                    <button class="nav-link" type="submit">Abmelden</button>
                </form>
                <a class="btn btn-primary btn-sm nav-cta<?= nav_active('/termine') ?>" href="<?= url('/termine') ?>">Stunde eintragen</a>
            <?php else: ?>
                <a class="nav-link<?= nav_active('/login') ?>" href="<?= url('/login') ?>">Anmelden</a>
                <?php /* Hieß bis zum 17.08.2026 „Meine freien Zeiten" (Sarah,
                         Ticket SAR-26). Weil die Knöpfe auf den Seiten seit
                         SAR-22 heißen wie ihr Menüpunkt, ist der Name hier
                         die Quelle: Wer ihn ändert, ändert ihn auch in
                         home.php, ueber-mich.php und footer.php mit.

                         Die Zielseite selbst heißt weiter „Meine freien
                         Zeiten" – das ist kein Versehen, siehe CLAUDE.md:
                         Die Terminplanung ist Sarahs eigenes Werkzeug, kein
                         Buchungssystem der Fahrschule. Das „meine" sagt
                         genau das. Als Wegweiser im Header ist „Termine"
                         trotzdem besser, weil er kurz sein muss und neben
                         „Anmelden" steht. */ ?>
                <a class="btn btn-primary btn-sm nav-cta<?= nav_active('/termine') ?>" href="<?= url('/termine') ?>">Termine</a>
            <?php endif; ?>

            <?php /* SARAHS KANÄLE, ABER NUR AUF DEM HANDY (21.08.2026).

                     Sie standen dort bis heute als schwebende Reiter unten links
                     am Bildschirmrand (`partials/social-rail.php`) und lagen
                     damit über dem Inhalt – auf der Startseite über dem Knopf im
                     Hero. Die Leiste ist auf schmalen Schirmen abgeschaltet, hier
                     stehen ihre beiden Links stattdessen.

                     DASSELBE ZIEL ZWEIMAL IM MARKUP, und das ist Absicht: Die
                     Randleiste steht am ENDE des Körpers, damit zwei Links auf
                     fremde Plattformen nicht vor Sarahs eigener Navigation
                     vorgelesen werden. Genau deshalb kann sie hier oben nicht
                     einfach hineinwandern. Sichtbar ist immer nur eine der
                     beiden Fassungen (`display: none`, nicht `visibility`), also
                     hört und findet niemand sie doppelt.

                     Die Adressen kommen aus derselben Quelle wie überall
                     (TIKTOK_HANDLE, INSTAGRAM_HANDLE in der .env). */ ?>
            <div class="nav-social">
                <a href="<?= e(tiktok_url()) ?>" target="_blank" rel="noopener noreferrer">
                    <?= icon('tiktok') ?>
                    TikTok<span class="sr-only"> – Sarahs Kanal, öffnet in neuem Tab</span>
                </a>
                <a href="<?= e(instagram_url()) ?>" target="_blank" rel="noopener noreferrer">
                    <?= icon('instagram') ?>
                    Instagram<span class="sr-only"> – Sarahs Kanal, öffnet in neuem Tab</span>
                </a>
            </div>
        </nav>
    </div>
</header>
