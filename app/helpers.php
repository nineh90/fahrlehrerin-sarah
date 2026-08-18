<?php
declare(strict_types=1);

/**
 * Zentrale Helfer-Funktionen für URLs, Escaping, Redirects, CSRF, Flash-Messages
 * und deutsche Datumsformate. Werden in praktisch jedem View/Controller genutzt.
 */

/**
 * Erzeugt eine absolute URL inkl. BASE_PATH.
 * IMMER für interne Links/Assets verwenden, damit der Sub-Pfad-Betrieb funktioniert.
 */
function url(string $path = '/'): string
{
    if ($path === '' || $path[0] !== '/') {
        $path = '/' . $path;
    }
    return BASE_PATH . $path;
}

/**
 * Asset-URL (public/assets/...) mit Fingerabdruck gegen alte Browser-Caches.
 *
 * Angehängt wird die Änderungszeit der Datei als ?v=… – ändert sich die Datei,
 * ändert sich die URL, und der Browser holt sie neu. Ohne das ist die
 * Cache-Vorgabe aus public/.htaccess eine Falle: CSS liegt dort einen Tag im
 * Browser, und ein Besucher, der gestern da war, sieht die heutige Änderung
 * schlicht nicht. Genau das ist am 11.08.2026 passiert.
 *
 * SCHRIFTEN SIND AUSGENOMMEN, und zwar zwingend: Das Layout lädt sie per
 * <link rel="preload"> vor, angefordert werden sie danach aber von fonts.css
 * über einen festen relativen Pfad ohne Parameter. Zwei verschiedene URLs für
 * dieselbe Datei heißt: einmal vorgeladen, einmal noch mal geholt. Die
 * Schriften brauchen den Fingerabdruck auch nicht – sie ändern sich nie, und
 * wenn doch, bekommen sie einen neuen Dateinamen.
 *
 * Fehlt die Datei (falscher Pfad, noch nicht deployt), gibt es einfach keinen
 * Parameter. Ein Tippfehler im Pfad soll eine 404 auslösen und keinen Fehler.
 */
function asset(string $path): string
{
    $path = ltrim($path, '/');
    $url  = url('/assets/' . $path);

    if (str_starts_with($path, 'fonts/')) {
        return $url;
    }

    $datei = APP_ROOT . '/public/assets/' . $path;
    $stand = is_file($datei) ? filemtime($datei) : false;

    return $stand === false ? $url : $url . '?v=' . $stand;
}

/**
 * Absolute URL inkl. Schema und Host.
 * Nur dort nötig, wo relative Pfade nicht reichen – etwa bei Open-Graph-Bildern,
 * die Facebook/WhatsApp & Co. von außen abrufen.
 */
function absolute_url(string $path = '/'): string
{
    $host = (string) ($_SERVER['HTTP_HOST'] ?? '');
    if ($host === '') {
        return url($path);
    }
    $https  = $_SERVER['HTTPS'] ?? '';
    $scheme = ($https !== '' && $https !== 'off') ? 'https' : 'http';

    return $scheme . '://' . $host . url($path);
}

/** HTML-Escaping für die Ausgabe. IMMER bei der Ausgabe von Daten verwenden. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** HTTP-Redirect auf eine interne Route (inkl. BASE_PATH) und beendet das Skript. */
function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

// ---------------------------------------------------------------------------
// Session, Flash, CSRF
// ---------------------------------------------------------------------------

/** Startet die Session, falls noch nicht geschehen. */
function ensure_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

/** Setzt eine Flash-Message (überlebt einen Redirect). Typ: success|error|info */
function set_flash(string $type, string $message): void
{
    ensure_session();
    $_SESSION['_flash'][$type] = $message;
}

/** Liest und verwirft alle Flash-Messages. */
function take_flashes(): array
{
    ensure_session();
    $flashes = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $flashes;
}

/** Gibt den aktuellen CSRF-Token zurück (erzeugt ihn bei Bedarf). */
function csrf_token(): string
{
    ensure_session();
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

/** Verstecktes Formularfeld mit CSRF-Token. */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

/** Prüft den übermittelten CSRF-Token; bricht bei Fehlschlag mit 419 ab. */
function verify_csrf(): void
{
    $sent = $_POST['_csrf'] ?? '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        http_response_code(419);
        exit('Sitzung abgelaufen oder ungültiges Formular. Bitte erneut versuchen.');
    }
}

// ---------------------------------------------------------------------------
// Views
// ---------------------------------------------------------------------------

/** Rendert einen View mit Layout. $data wird als Variablen extrahiert. */
function view(string $template, array $data = [], string $layout = 'layout'): string
{
    extract($data, EXTR_SKIP);
    ob_start();
    require APP_ROOT . '/app/Views/' . $template . '.php';
    $content = ob_get_clean();

    if ($layout === '') {
        return $content;
    }

    ob_start();
    require APP_ROOT . '/app/Views/' . $layout . '.php';
    return ob_get_clean();
}

/** Gibt einen View aus (Shortcut). */
function render(string $template, array $data = [], string $layout = 'layout'): void
{
    echo view($template, $data, $layout);
}

/** Der angefragte Pfad ohne BASE_PATH und ohne Query-String. */
function current_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    if (BASE_PATH !== '' && str_starts_with($path, BASE_PATH)) {
        $path = substr($path, strlen(BASE_PATH));
    }

    return '/' . trim($path, '/');
}

/** Markiert die aktive Navigation (auch für Unterseiten des Pfads). */
function nav_active(string $path): string
{
    $current = current_path();
    $target  = '/' . trim($path, '/');

    if ($target === '/') {
        return $current === '/' ? ' is-active' : '';
    }

    return str_starts_with($current, $target) ? ' is-active' : '';
}

/** Markiert die aktive Navigation nur bei exakt diesem Pfad. */
function nav_exact(string $path): string
{
    return current_path() === '/' . trim($path, '/') ? ' is-active' : '';
}

/**
 * Liefert ein Inline-SVG-Icon (stroke = currentColor) aus einem festen Satz.
 * Reine Deko – die Farbe kommt aus dem umgebenden Element, deshalb kein
 * einziger Farbwert im Markup.
 */
function icon(string $name): string
{
    $paths = [
        'car'       => '<path d="M3 13l1.8-4.5A2 2 0 0 1 6.6 7h10.8a2 2 0 0 1 1.8 1.3L21 13v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Z"/><path d="M5 13h14"/><circle cx="7.5" cy="15.3" r="1"/><circle cx="16.5" cy="15.3" r="1"/>',
        'calendar'  => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><circle cx="8.5" cy="14.5" r="1"/><circle cx="12" cy="14.5" r="1"/>',
        'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.2 2"/>',
        'heart'     => '<path d="M20.8 6.6a5.1 5.1 0 0 0-7.2 0L12 8.2l-1.6-1.6a5.1 5.1 0 1 0-7.2 7.2l8.8 8.8 8.8-8.8a5.1 5.1 0 0 0 0-7.2Z"/>',
        /* Für „Angstfrei ans Steuer". Die Nachbarkarten tragen alle Fahrzeug-
           und Technik-Icons; diese eine handelt vom Menschen und nicht von
           einer Führerscheinklasse, deshalb bricht sie die Reihe bewusst auf.
           Es ist außerdem die Geste, die Sarah auf dem Hero-Foto macht. */
        'thumb'     => '<path d="M7 21H4.6A1.6 1.6 0 0 1 3 19.4v-6.2A1.6 1.6 0 0 1 4.6 11.6H7"/><path d="M7 11.6l3.8-8.1a1.4 1.4 0 0 1 2.6.7v5.1h5.2a2 2 0 0 1 2 2.4l-1.3 6.4A2 2 0 0 1 17.3 21H7Z"/>',
        'road'      => '<path d="M5 21 8 3M19 21 16 3"/><path d="M12 4v3M12 11v3M12 18v3"/>',
        /* Klasse BE = Auto MIT Anhänger. Der Vorgänger zeigte einen großen
           Kasten mit einer Fahrerkabine daneben und las sich dadurch als
           Pickup – also als ein Fahrzeug statt als Gespann. Jetzt sind es
           zwei getrennte Körper mit einer Deichsel dazwischen; genau das
           ist der Unterschied, um den es in der Klasse geht. */
        'trailer'   => '<path d="M1.4 15.6v-2.4l1.5-3.3a1.5 1.5 0 0 1 1.4-.9h3.9a1.5 1.5 0 0 1 1.3.7l2 3.5v2.4z"/><path d="M2.9 13.2h8.6"/><circle cx="3.9" cy="15.6" r="1.4"/><circle cx="9.6" cy="15.6" r="1.4"/><path d="M11.5 14.4h2.7"/><path d="M14.2 15.6v-4.6a.9.9 0 0 1 .9-.9h6.6a.9.9 0 0 1 .9.9v4.6z"/><circle cx="18.4" cy="15.6" r="1.4"/>',
        /* Bewusst das bekannte Zugänglichkeits-Piktogramm (Person im Rad) und
           kein Rollstuhl von der Seite: Es ist dieselbe Form, die im Lenkrad
           von Sarahs Logo sitzt, und es steht für Handicap allgemein. Ihr
           Schwerpunkt umfasst auch Kleinwuchs und Handbedienung – ein reiner
           Rollstuhl würde das Thema enger machen, als es ist.

           Seit dem Logo-Tausch am 17.08.2026 ist es die DYNAMISCHE Fassung
           („Accessible Icon"): nach vorn gelehnt, der Arm greift zurück ans
           Rad. Das neue Logo trägt sie im Lenkrad, also trägt die Seite sie
           auch – vorher saß hier die aufrechte, statische Figur.

           Gezeichnet ist sie nach dem Logo, nicht davon abgepaust: Vier
           Striche müssen bei 26 px noch auseinanderfallen. Deshalb sitzt der
           Kopf frei über der Schulter statt sie zu berühren, und das Rad ist
           kleiner als im Logo – sonst verschluckt sein Bogen den Arm. */
        'wheelchair' => '<circle cx="17" cy="4.6" r="1.9"/><path d="M13.8 6.6 7.6 8.6l1.8 3.4"/><path d="M14.6 7.8 11.8 11.4l4.6 1.4.8 7"/><circle cx="9.6" cy="16.6" r="4.8"/>',

        /* Durchgestrichenes Ohr – das international übliche Zeichen für
           Gehörlosigkeit. Bewusst NICHT das Ohr mit Schallwellen daneben: Das
           ist das Zeichen für Hören und meint bei 26 px das Gegenteil.
           Ein Handy mit Schild darauf wäre die App gewesen, nicht die
           Zielgruppe – die Nachbarkarten benennen alle Menschen, keine Geräte.
           Der Strich läuft fast von Ecke zu Ecke: Kürzer gerät er in die
           Silhouette des Ohrs und liest sich als Teil davon. */
        'ear'       => '<path d="M6.6 9.4a5.4 5.4 0 0 1 10.8 0c0 3.6-3.6 4.6-3.6 7.6a2.9 2.9 0 0 1-5.8 0"/><path d="M10.2 9.6a1.9 1.9 0 0 1 3.6.8c0 1.5-1.7 1.7-1.7 3.2"/><path d="M4.4 4.4 19.6 19.6"/>',

        /* ---- Die vier Umbauten auf /fahren-mit-handicap -------------------
           Vorher liefen die Karten mit Auto, Schild, Uhr und Funkeln – also
           mit dem, was gerade im Satz übrig war. Auf einer Seite, die von
           Technik handelt, muss man die Technik erkennen. */

        /* Linksgas: zwei Pedale, das linke geriffelt (das neue Gaspedal), und
           ein Pfeil, der nach links zeigt. Ohne den Pfeil sind es nur zwei
           Pedale – die Aussage steckt in der Seite, auf die das Gas wandert. */
        'pedal'     => '<rect x="3" y="8.4" width="6.6" height="11.4" rx="2.2"/><rect x="13.4" y="8.4" width="6.6" height="11.4" rx="2.2"/><path d="M5.1 11.6h2.4M5.1 14.1h2.4M5.1 16.6h2.4"/><path d="M17.4 4.8H7.3"/><path d="m9.4 2.7-2.1 2.1 2.1 2.1"/>',

        /* Lenkraddrehknopf: Lenkrad mit dem Knauf auf dem Kranz. Der Knauf ist
           als einziges Element gefüllt – offen gezeichnet liest er sich als
           Loch im Lenkrad statt als etwas, das darauf sitzt. */
        'knob'      => '<circle cx="12" cy="12" r="7.8"/><circle cx="12" cy="12" r="2.5"/><path d="M12 4.2v5.3"/><path d="m5.4 15.6 4.4-2.5"/><path d="m18.6 15.6-4.4-2.5"/><circle cx="6.5" cy="6.5" r="2.1" fill="currentColor" stroke="none"/>',

        /* Handbedienung: Hebel mit Griff auf einer Grundplatte. Der Vorgänger
           hatte zusätzlich einen Doppelpfeil für „Gas und Bremse über dieselbe
           Bewegung" – inhaltlich richtig, bei 26 px aber tödlich: Der schräge
           Hebel zerfiel neben dem Pfeil in lauter einzelne Striche und Punkte.
           Jetzt drei große, ruhige Formen. Was der Pfeil erklärt hätte, steht
           ohnehin im Text der Karte darunter. */
        'lever'     => '<path d="M6.4 20.4h11.2"/><path d="M12 20.4v-7.6"/><path d="M8.6 8.2a3.4 3.4 0 0 1 6.8 0v1.2a3.4 3.4 0 0 1-3.4 3.4 3.4 3.4 0 0 1-3.4-3.4Z"/>',

        /* Hier lag bis zum 17.08.2026 'prosthesis' – ein Bein mit Schaft,
           Kniegelenk und Fuß, für die Karte „Prothesenfahren". Karte und Icon
           sind mit SAR-43 entfallen; das Icon steht in der Versionsgeschichte,
           falls das Thema zurückkommt.

           Pedalverlängerung: dasselbe geriffelte Pedal wie in 'pedal', damit
           beide Karten dieselbe Sprache sprechen, und ein Pfeil daneben. Der
           Pfeil zeigt nach OBEN und nicht zur Seite: Verlängert wird nach oben,
           dem Fuß entgegen. Eine zweite Variante mit Pedal und aufgesetztem
           Zweitteil war anatomisch näher dran, zerfiel bei 26 px aber in zwei
           Kästchen ohne erkennbaren Zusammenhang. */
        'extension' => '<rect x="5.6" y="8.6" width="7" height="11.2" rx="2.4"/><path d="M7.8 11.4h2.6M7.8 14.2h2.6M7.8 17h2.6"/><path d="M17.4 19.6V6.6"/><path d="m14.8 9.2 2.6-2.8 2.6 2.8"/>',
        'shield'    => '<path d="M12 3l7.5 3v5.4c0 4.6-3.1 8.8-7.5 10.1-4.4-1.3-7.5-5.5-7.5-10.1V6Z"/><path d="m9.2 12.2 2 2 3.6-3.8"/>',
        'sparkles'  => '<path d="m12 3 1.7 4.6L18.3 9l-4.6 1.4L12 15l-1.7-4.6L5.7 9l4.6-1.4Z"/><path d="m18 15 .8 2.2 2.2.8-2.2.8L18 21l-.8-2.2-2.2-.8 2.2-.8Z"/>',
        'chat'      => '<path d="M21 12a8 8 0 0 1-8 8H7l-4 3v-5.6A8 8 0 0 1 13 4a8 8 0 0 1 8 8Z"/>',
        'phone'     => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>',
        'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'bell'      => '<path d="M18 8a6 6 0 1 0-12 0c0 5-2 6.5-2 6.5h16S18 13 18 8Z"/><path d="M13.7 20a2 2 0 0 1-3.4 0"/>',
        'check'     => '<path d="m5 12.5 4.5 4.5L19 7"/>',
        'pin'       => '<path d="M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11Z"/><circle cx="12" cy="10" r="2.6"/>',
        /* Das bekannte Zugänglichkeitszeichen (Figur mit ausgebreiteten Armen im
           Kreis) für den Knopf der Barrierefreiheits-Leiste. Bewusst MIT Kreis:
           Ohne ihn steht am Bildschirmrand nur ein Strichmännchen, und der Kreis
           ist es, der das Zeichen international wiedererkennbar macht. Nicht das
           Rollstuhl-Piktogramm ('wheelchair'): Die Leiste stellt die Darstellung
           für alle ein und nicht nur für Rollstuhlfahrer:innen. */
        'accessibility' => '<circle cx="12" cy="12" r="9.2"/><circle cx="12" cy="7.4" r="1.5"/><path d="M7.6 10.4h8.8"/><path d="M12 10.4v3.4"/><path d="m12 13.8-1.9 4.4M12 13.8l1.9 4.4"/>',
        'tiktok'    => '<path d="M16 4c.4 2.4 2 4 4.4 4.2v3.1c-1.7.1-3.2-.4-4.4-1.3v5.6a5.9 5.9 0 1 1-5.1-5.8v3.2a2.7 2.7 0 1 0 1.9 2.6V4Z"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r=".9" fill="currentColor" stroke="none"/>',
        'default'   => '<circle cx="12" cy="12" r="9"/><path d="M12 8v4l2.5 2"/>',
    ];

    $inner = $paths[$name] ?? $paths['default'];

    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" '
        . 'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $inner . '</svg>';
}

/**
 * Das Einzugsgebiet als lesbarer Satzteil: "Neu Wulmstorf, Buxtehude, Stade und Hamburg".
 * Für Aufzählungen mit Trennzeichen stattdessen implode() auf config('contact.area').
 */
function area_sentence(string $conjunction = 'und'): string
{
    $orte = config('contact.area', []);
    if (!$orte) {
        return '';
    }
    if (count($orte) === 1) {
        return $orte[0];
    }
    $last = array_pop($orte);

    return implode(', ', $orte) . ' ' . $conjunction . ' ' . $last;
}

/**
 * Der Name von Sarahs Fahrschule, verlinkt – oder leer.
 *
 * Sarah ist angestellt: Anmeldung, Vertrag, Theorie und Preise laufen über die
 * Fahrschule. Überall, wo das im Text vorkommt, soll der Name stehen und
 * anklickbar sein. Ist `SCHOOL_NAME` leer, gibt die Funktion einen leeren
 * String zurück – die Templates prüfen darauf und formulieren dann ohne Namen.
 *
 * Gibt fertiges HTML zurück (deshalb NICHT noch einmal durch e() schicken).
 */
function school_link(): string
{
    $name = trim((string) config('school.name'));
    if ($name === '') {
        return '';
    }
    $url = trim((string) config('school.url'));
    if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
        return e($name);
    }

    return sprintf(
        '<a href="%s" target="_blank" rel="noopener">%s</a>',
        e($url),
        e($name)
    );
}

/** Profil-URL zu Sarahs TikTok-Kanal. */
function tiktok_url(): string
{
    return 'https://www.tiktok.com/@' . config('social.tiktok_handle');
}

/** Profil-URL zu Sarahs Instagram-Kanal. */
function instagram_url(): string
{
    return 'https://www.instagram.com/' . config('social.instagram_handle');
}

/**
 * Anzahl ungelesener Meldungen für das Zählerchen in der Admin-Navigation.
 *
 * Steht hier und nicht im View, damit das Layout kein Model direkt befragt.
 * Pro Request nur eine Abfrage. Fehlt die Tabelle (Datenbank älter als das
 * Benachrichtigungs-Modul), ist die Antwort 0 statt eines Fehlers – die
 * Schaltzentrale soll deswegen nicht stehen bleiben.
 */
function admin_unread_count(): int
{
    static $count = null;
    if ($count === null) {
        try {
            $count = Notification::unreadCount();
        } catch (Throwable) {
            $count = 0;
        }
    }

    return $count;
}

/** Liest alten Formularwert nach Validierungsfehler. */
function old(string $key, array $values, string $default = ''): string
{
    return e((string) ($values[$key] ?? $default));
}

// ---------------------------------------------------------------------------
// Datum & Zeit (deutsch, ohne intl-Extension)
// ---------------------------------------------------------------------------

const WEEKDAYS_SHORT = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];
const WEEKDAYS_LONG  = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
const MONTHS_LONG    = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
                        'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];

/** Wandelt einen DB-Zeitstempel ("2026-08-10 14:00:00") in ein DateTimeImmutable. */
function dt(string $value): DateTimeImmutable
{
    return new DateTimeImmutable($value);
}

/** Kurzer Wochentag zu einem Datum, z.B. "Mo". */
function weekday_short(DateTimeInterface $date): string
{
    return WEEKDAYS_SHORT[(int) $date->format('N') - 1];
}

/** Ausgeschriebener Wochentag, z.B. "Montag". */
function weekday_long(DateTimeInterface $date): string
{
    return WEEKDAYS_LONG[(int) $date->format('N') - 1];
}

/** Datum deutsch, z.B. "Mo, 10.08.2026". */
function format_date(DateTimeInterface $date): string
{
    return weekday_short($date) . ', ' . $date->format('d.m.Y');
}

/** Datum lang, z.B. "10. August 2026". */
function format_date_long(DateTimeInterface $date): string
{
    return (int) $date->format('j') . '. ' . MONTHS_LONG[(int) $date->format('n') - 1]
        . ' ' . $date->format('Y');
}

/** Uhrzeit, z.B. "14:00 Uhr". */
function format_time(DateTimeInterface $date): string
{
    return $date->format('H:i') . ' Uhr';
}

/** Termin komplett, z.B. "Mo, 10.08.2026 · 14:00 Uhr". */
function format_datetime(DateTimeInterface $date): string
{
    return format_date($date) . ' · ' . format_time($date);
}

/**
 * Grober Abstand zu jetzt, z.B. "gerade eben", "vor 3 Std.", "vor 2 Tagen".
 * Für Meldungslisten: dort zählt „wie frisch ist das", nicht das genaue Datum.
 * Ab einer Woche wird wieder das Datum ausgegeben.
 */
function time_ago(DateTimeInterface $date): string
{
    $seconds = (new DateTimeImmutable('now'))->getTimestamp() - $date->getTimestamp();
    if ($seconds < 0) {
        return format_datetime($date);
    }

    $minutes = intdiv($seconds, 60);
    $hours   = intdiv($minutes, 60);
    $days    = intdiv($hours, 24);

    return match (true) {
        $minutes < 1 => 'gerade eben',
        $minutes < 60 => 'vor ' . $minutes . ' Min.',
        $hours   < 24 => 'vor ' . $hours . ' Std.',
        $days    === 1 => 'gestern',
        $days    < 7 => 'vor ' . $days . ' Tagen',
        default => format_date($date),
    };
}

/** Montag der Woche, in der $date liegt (00:00 Uhr). */
function week_start(DateTimeInterface $date): DateTimeImmutable
{
    $d = DateTimeImmutable::createFromInterface($date);
    return $d->modify('monday this week')->setTime(0, 0);
}

/**
 * Übersetzt den ?woche=-Parameter (Offset in Wochen ab dieser Woche)
 * in den Montag der gewünschten Woche. Begrenzt auf -1 … +12 Wochen.
 */
function week_from_offset(mixed $offset): DateTimeImmutable
{
    $weeks = max(-1, min(12, (int) $offset));
    return week_start(new DateTimeImmutable('now'))->modify(sprintf('%+d weeks', $weeks));
}

/**
 * Umkehrung von week_from_offset(): In wie vielen Wochen ab dieser Woche liegt
 * das Datum? Damit lässt sich zu einem Termin der passende ?woche=-Link bauen.
 */
function week_offset_of(DateTimeInterface $date): int
{
    $current = week_start(new DateTimeImmutable('now'));
    $target  = week_start($date);

    // Über die Zeitstempel und gerundet: Bei der Zeitumstellung ist eine Woche
    // 23 bzw. 25 Stunden lang, eine Ganzzahldivision würde dann danebenliegen.
    return (int) round(($target->getTimestamp() - $current->getTimestamp()) / (7 * 86400));
}

/**
 * Verteilt Termine auf die sieben Tage einer Woche.
 * Ergebnis: [['date' => DateTimeImmutable, 'slots' => [...]], … ] – immer
 * sieben Einträge, auch wenn ein Tag leer bleibt.
 */
function group_slots_by_day(array $slots, DateTimeInterface $monday): array
{
    $days  = [];
    $start = DateTimeImmutable::createFromInterface($monday)->setTime(0, 0);

    for ($i = 0; $i < 7; $i++) {
        $day = $start->modify("+$i days");
        $days[$day->format('Y-m-d')] = ['date' => $day, 'slots' => []];
    }

    foreach ($slots as $slot) {
        $key = dt($slot['starts_at'])->format('Y-m-d');
        if (isset($days[$key])) {
            $days[$key]['slots'][] = $slot;
        }
    }

    return array_values($days);
}

/** Liegt das Datum heute? */
function is_today(DateTimeInterface $date): bool
{
    return $date->format('Y-m-d') === (new DateTimeImmutable('now'))->format('Y-m-d');
}
