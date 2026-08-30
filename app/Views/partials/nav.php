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
            <?php /* DIE GRUPPE „SCHWERPUNKTE", seit dem 21.08.2026 (SAR-65).

                     Hier stand ein einzelner Punkt „Fahren mit Handicap". Mit
                     /neurodivergenz kam eine zweite Seite dazu, die inhaltlich
                     danebengehört, und für zwei lange Punkte nebeneinander ist
                     in der Leiste kein Platz (die Rechnung steht in nd-base.css
                     beim 1120-px-Block).

                     WARUM DIE GRUPPE NICHT „FAHREN MIT HANDICAP" HEISST, obwohl
                     das der stärkere Begriff wäre: Sie wäre dann der Elternpunkt
                     von „Neurodivergenz" – und ein Menü, das das eine unter das
                     andere hängt, behauptet, Neurodivergenz sei ein Handicap.
                     Sarahs Text auf der Seite vermeidet genau diese Einordnung
                     („du möchtest dich überhaupt keinem Begriff zuordnen").
                     Nebenbei müsste die bestehende Seite dann umbenannt werden,
                     weil ein Elternpunkt nicht heißen kann wie sein Kind.
                     „Schwerpunkte" ordnet niemanden ein, es sagt nur, worauf
                     Sarah spezialisiert ist – und trägt später auch die
                     Hörschädigung oder die Angst vorm Steuer, falls die Kacheln
                     der Startseite eigene Seiten bekommen.

                     ES IST EIN <button>, KEIN LINK, und das ist der Kern der
                     Sache: Die Gruppe hat keine eigene Seite. Ein Link, der
                     nirgendwohin führt (href="#"), wäre für Vorlesesoftware ein
                     Versprechen, das er nicht hält. Der Knopf sagt über
                     `aria-expanded` genau, was er tut, und `aria-controls`
                     zeigt auf die Liste darunter.

                     OHNE JAVASCRIPT bleibt das Menü trotzdem bedienbar: Die
                     Liste ist im Markup immer da, und `:focus-within` in
                     nd-base.css klappt sie auf, sobald der Knopf oder einer
                     ihrer Links den Fokus hat. Mit Tastatur kommt man also
                     durch, auch wenn main.js nicht lädt. Auf dem Handy ist sie
                     ohnehin immer offen (siehe 1120-px-Block).

                     ZUGEKLAPPT AUCH AUF DEN EIGENEN SEITEN. Eine frühere Fassung
                     ließ das Untermenü aufgeklappt, wenn man auf einer der
                     beiden Seiten stand – der Gedanke war, dass man sonst erst
                     aufklappen muss, um zu sehen, wo man ist. Beim Ansehen war
                     es das Falsche: Das Menü hing beim Laden über der
                     Überschrift und verschwand beim ersten Klick irgendwohin,
                     also genau wie ein hängengebliebenes Menü. Wo man ist,
                     sagt der Knopf ohnehin – `nav_group_active()` färbt ihn
                     ein, sobald eine der beiden Seiten offen ist. */ ?>
            <?php $schwerpunkte = ['/fahren-mit-handicap', '/neurodivergenz']; ?>
            <div class="nav-group">
                <button class="nav-link nav-group-toggle<?= nav_group_active($schwerpunkte) ?>"
                        type="button"
                        aria-expanded="false"
                        aria-controls="navSchwerpunkte">
                    Schwerpunkte<span class="nav-caret" aria-hidden="true"></span>
                </button>
                <div class="nav-submenu" id="navSchwerpunkte">
                <?php /* DIE BEIDEN PUNKTE SAGEN SEIT SAR-107 (30.08.2026), WORIN
                         SIE SICH UNTERSCHEIDEN. Vorher hießen sie „Fahren mit
                         Handicap" und „Neurodivergenz" – der erste klang wie der
                         Oberbegriff für beide, und wer eine unsichtbare
                         Beeinträchtigung hat, wäre bei ihm gelandet und hätte
                         dort nur Technik gefunden.

                         „Körperlich" ist NICHT unsere Wortwahl: Sarahs eigener
                         Vorspann auf der Seite fängt mit „Eine körperliche
                         Einschränkung bedeutet nicht automatisch …" an, und in
                         der Kachel auf der Startseite steht „ob körperliches
                         oder seelisches Handicap". Wir übernehmen hier also nur
                         ihre eigene Unterscheidung ins Menü.

                         Beide Punkte sind jetzt gleich gebaut – Adjektiv plus
                         Sache, ohne „Fahren mit" davor. Vorher war der eine ein
                         Halbsatz und der andere ein Wort. */ ?>
                    <a class="nav-link<?= nav_active('/fahren-mit-handicap') ?>" href="<?= url('/fahren-mit-handicap') ?>">Körperliches Handicap</a>
                    <a class="nav-link<?= nav_active('/neurodivergenz') ?>" href="<?= url('/neurodivergenz') ?>">Neurodivergenz</a>
                </div>
            </div>

            <?php /* DIE FAHRSCHULE IM MENÜ, seit dem 21.08.2026 (SAR-54).

                     Sie steht hier, weil an dieser Stelle Platz frei wurde:
                     „Anmelden" und „Termine" sind mit der Terminplanung
                     verschwunden. Der Punkt füllt die Lücke nicht nur optisch –
                     er ist der Weg, den Besucher jetzt am ehesten brauchen: Die
                     Anmeldung läuft über die Fahrschule, nicht über diese Seite.

                     DER EINZIGE MENÜPUNKT, DER VON DER SEITE WEGFÜHRT, deshalb
                     der Pfeil. Er ist `aria-hidden`, weil Vorlesesoftware ihn
                     sonst als „Nordostpfeil" ansagt; was er bedeutet, steht als
                     Text daneben und nur für sie. Dieselbe Aufteilung wie bei
                     Sarahs Kanälen weiter unten.

                     Wie überall auf der Seite: Ist `SCHOOL_NAME` oder
                     `SCHOOL_URL` leer, gibt es den Punkt nicht. */ ?>
            <?php $navSchule = trim((string) config('school.name')); ?>
            <?php $navSchuleUrl = trim((string) config('school.url')); ?>
            <?php if ($navSchule !== '' && $navSchuleUrl !== ''): ?>
                <a class="nav-link" href="<?= e($navSchuleUrl) ?>" target="_blank" rel="noopener noreferrer">
                    <?= e($navSchule) ?><span aria-hidden="true"> &nearr;</span><span class="sr-only"> – öffnet in neuem Tab</span>
                </a>
            <?php endif; ?>

            <?php /* KONTAKT TRÄGT SEIT SAR-54 DEN KNOPF-STIL, den vorher
                     „Termine" hatte (Kevin, 21.08.2026). Der Header hatte
                     immer einen hervorgehobenen Abschluss; fällt er ersatzlos
                     weg, endet das Menü in einer Reihe gleich aussehender
                     Wörter und niemand weiß, was der nächste Schritt ist.

                     Kontakt ist dieser Schritt, solange die Terminplanung
                     ruht: Wer nicht anrufen will, schreibt. Kommt „Termine"
                     zurück, gehört der Knopf wieder dorthin – zwei
                     hervorgehobene Punkte nebeneinander sind keiner. */ ?>
            <a class="btn btn-primary btn-sm nav-cta<?= nav_active('/kontakt') ?>" href="<?= url('/kontakt') ?>">Kontakt</a>

            <?php /* HIER STAND DER WEG IN SARAHS TERMINPLANUNG, bis zum
                     21.08.2026 (ihr Ticket SAR-54): „Anmelden" und „Termine",
                     für Angemeldete stattdessen „Meine Stunden", „Abmelden"
                     und „Stunde eintragen".

                     Der Grund ist keiner der Website: Ihre Fahrschule bekommt
                     ab September ein neues System, das Termine wohl selbst
                     freigeben kann. Bis das geklärt ist, soll ihre eigene
                     Planung nicht mehr angeboten werden – „aber nicht
                     verwerfen".

                     Deshalb ist der Block nicht gelöscht, sondern hängt an
                     `termine_oeffentlich()` (helpers.php). Steht der Schalter
                     wieder auf true, ist das Menü unverändert das von vorher,
                     inklusive des angemeldeten Zustands. */ ?>
            <?php if (termine_oeffentlich()): ?>
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
