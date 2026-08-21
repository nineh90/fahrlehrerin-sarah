<?php
declare(strict_types=1);

/**
 * Zentrale Konfiguration. Lädt .env (einfacher Parser, keine Abhängigkeiten)
 * und stellt globale Konstanten + den config()-Zugriff bereit.
 */

define('APP_ROOT', dirname(__DIR__));

/** Minimalistischer .env-Parser (KEY=VALUE, # = Kommentar). */
function load_env(string $path): void
{
    if (!is_readable($path)) {
        return;
    }
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        // Umschließende Anführungszeichen entfernen
        if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'")) {
            $value = substr($value, 1, -1);
        }
        if (getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

load_env(APP_ROOT . '/.env');

/** Liest einen Konfigurationswert aus der Umgebung mit Fallback. */
function env(string $key, mixed $default = null): mixed
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    return match (strtolower($value)) {
        'true'  => true,
        'false' => false,
        'null'  => null,
        default => $value,
    };
}

$config = [
    'app_env'   => env('APP_ENV', 'production'),
    'app_debug' => (bool) env('APP_DEBUG', false),
    'app_name'  => env('APP_NAME', 'Fahrlehrerin Sarah'),
    // BASE_PATH ohne abschließenden Slash, leer = Root-Domain
    'base_path' => rtrim((string) env('BASE_PATH', ''), '/'),
    // Die öffentliche Adresse der Seite, ohne abschließenden Slash.
    // Leer = absolute_url() rät den Host aus dem Request, wie vor SAR-10.
    // Gefüllt = jede absolute URL steht fest, egal wer sie erzeugt. Das ist
    // die Voraussetzung für Canonical und Sitemap: Ein Canonical, der sich
    // nach dem Request richtet, zeigt unter der IP auf die IP und hebt damit
    // genau die Zusammenführung auf, für die es ihn gibt.
    'app_url' => rtrim((string) env('APP_URL', ''), '/'),
    // Darf die Seite in Suchmaschinen auftauchen?
    // Standard ist NEIN – die sichere Richtung. Solange die Seite nur zum
    // Zeigen online steht, soll sie niemand über Google finden. Erst zum
    // Livegang auf true. Wirkt auf das robots-Meta jeder Seite UND auf
    // /robots.txt (siehe RobotsController).
    'allow_indexing' => (bool) env('ALLOW_INDEXING', false),
    'db' => [
        'sqlite_path' => env('DB_SQLITE_PATH', APP_ROOT . '/storage/database.sqlite'),
    ],
    'admin' => [
        'email'    => env('ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('ADMIN_PASSWORD', 'admin12345'),
        // Muss Sarah beim ersten Anmelden ein eigenes Passwort vergeben?
        // Im Testbetrieb aus, sonst sperrt sie beim Ausprobieren aus Versehen
        // alle anderen aus. Vor dem Livegang auf true.
        // Fehlt der Wert, wird erzwungen – die sichere Richtung.
        'force_password_change' => (bool) env('ADMIN_FORCE_PASSWORD_CHANGE', true),
    ],
    'booking' => [
        // Bis wie viele Stunden vor Terminbeginn darf storniert/verschoben werden
        'cancel_deadline_hours' => (int) env('CANCEL_DEADLINE_HOURS', 24),
        'slot_duration_min'     => (int) env('SLOT_DURATION_MIN', 45),

        // ZEIGT DIE WEBSITE DIE TERMINPLANUNG? Seit dem 21.08.2026 nicht mehr
        // (Sarahs Ticket SAR-54): Ihre Fahrschule bekommt ab September ein
        // neues System, das Termine wohl selbst freigeben kann. Bis das
        // geklärt ist, soll ihre eigene Planung von der Seite verschwinden –
        // „aber nicht verwerfen".
        //
        // DER SCHALTER NIMMT NUR DIE WEGE WEG, NICHT DIE SACHE: Menü, Fuß und
        // die Knöpfe auf den Inhaltsseiten führen nicht mehr dorthin. Routen,
        // Controller, Views, Models und der ganze Admin-Bereich bleiben
        // unangetastet und funktionieren; wer die Adresse kennt, kommt hin.
        // Genau so war es gewünscht, und genau deshalb ist es ein Schalter
        // und keine Löschung: Zurückholen ist eine Zeile, kein Wiederaufbau.
        //
        // Der Standardwert ist `false`. Das ist Absicht: Die `.env` auf dem
        // Server ist von Hand gepflegt, und ein Server ohne den Eintrag soll
        // die Planung NICHT anzeigen. Wer sie zurückholt, setzt bewusst
        // TERMINE_OEFFENTLICH=true.
        'public' => (bool) env('TERMINE_OEFFENTLICH', false),
    ],
    // Sarah ist angestellte Fahrlehrerin – ihre Fahrschule ist ein eigener
    // Betrieb. Bleibt 'name' leer, wird sie auf der Seite nirgends genannt.
    'school' => [
        'name' => env('SCHOOL_NAME', ''),
        'url'  => env('SCHOOL_URL', ''),
    ],
    'social' => [
        'tiktok_handle'    => ltrim((string) env('TIKTOK_HANDLE', 'fahrlehrerin_sarah'), '@'),
        'instagram_handle' => ltrim((string) env('INSTAGRAM_HANDLE', 'fahrlehrerinsarah'), '@'),
    ],
    /* KONTAKTDATEN – DIE EINZIGE QUELLE. Seit dem 21.08.2026 stehen sie nicht
       mehr zusätzlich in der .env, und das ist der Punkt: Vorher standen sie
       an beiden Stellen mit verschiedenen Werten, die .env gewann, und die
       Seite zeigte einen Platzhalter, obwohl hier die richtige Nummer stand.

       Sie sind auch keine Umgebungskonfiguration. Telefon, E-Mail, Ort und
       Einzugsgebiet sind auf jedem Rechner dieselben – anders als Passwörter,
       APP_URL oder ALLOW_INDEXING, die sich je Umgebung unterscheiden. Was
       überall gleich ist, gehört in den Code: Der Deploy bringt es mit, und
       niemand muss an eine Datei denken, die er nicht sieht.

       Dass die Nummer damit in einem öffentlichen Repo steht, ist geprüft und
       gewollt (Nils, 21.08.2026): Es ist Sarahs DIENSTnummer und steht ohnehin
       im Fuß jeder Seite. Für ihre private wäre die Antwort eine andere.

       Die env()-Aufrufe bleiben als Notausgang – wer einen Wert doch je
       Umgebung braucht, kann ihn in der .env setzen und übersteuert damit
       bewusst den Code. Nur eben nicht mehr aus Versehen. */
    'contact' => [
        // Sarahs echte Nummer seit dem 20.08.2026 (SAR-66). Vorher stand hier
        // der Platzhalter `0123 456789`, der auf jeder Seite im Fuß mitlief.
        //
        // Die Schreibweise mit Leerzeichen ist die für die ANZEIGE. Die
        // `tel:`-Links bauen sich ihre Fassung selbst, indem sie alle
        // Leerzeichen wegwerfen; wer hier etwas ändert, ändert also beides.
        // Deshalb gehört in diesen Wert nichts, was in einer Wählnummer nicht
        // vorkommen darf, also keine Klammern und kein Schrägstrich.
        'phone' => env('CONTACT_PHONE', '+49 175 3716772'),
        // Seit dem 20.08.2026 `sarah@` und nicht mehr `info@` (SAR-65). Das
        // ist der Rückfall für den Fall, dass die .env den Wert nicht setzt;
        // die echte Adresse steht dort.
        'email' => env('CONTACT_EMAIL', 'sarah@fahrlehrerinsarah.de'),
        'city'  => env('CONTACT_CITY', 'Neu Wulmstorf'),
        // Einzugsgebiet als Liste, in der .env mit Komma getrennt
        'area'  => array_values(array_filter(array_map(
            'trim',
            explode(',', (string) env('CONTACT_AREA', 'Neu Wulmstorf, Buxtehude, Stade, Hamburg'))
        ))),
    ],
    'mail' => [
        // log | smtp | mail  – siehe app/Mailer.php
        'driver' => env('MAIL_DRIVER', 'log'),
        'to'     => env('MAIL_TO', 'info@example.com'),
        'from'   => env('MAIL_FROM', 'noreply@example.com'),
        // Klarname vor der Adresse ("Fahrlehrerin Sarah <sarah@…>"). Leer = nur
        // die Adresse. Steht hier etwas mit Umlaut, wird es kodiert.
        'from_name' => env('MAIL_FROM_NAME', ''),
        // Wohin Antworten gehen, wenn das nicht die Absenderadresse sein soll.
        // Genau dafür gedacht, wenn from eine Adresse ist, die niemand liest.
        'reply_to'  => env('MAIL_REPLY_TO', ''),
        'smtp' => [
            'host'     => env('SMTP_HOST', ''),
            'port'     => (int) env('SMTP_PORT', 465),
            'user'     => env('SMTP_USER', ''),
            'password' => env('SMTP_PASSWORD', ''),
            // tls      = ab dem ersten Byte verschlüsselt (üblich auf Port 465)
            // starttls = im Klartext verbinden und dann hochstufen (Port 587)
            // none     = unverschlüsselt. Nur für einen Testserver im eigenen
            //            Netz – über das Internet geht damit das Passwort offen
            //            über die Leitung.
            'security' => env('SMTP_SECURITY', 'tls'),
        ],
    ],
    // Wie Sarah von Buchungen erfährt (siehe app/Notifier.php).
    // Der Posteingang in der Schaltzentrale läuft immer – das hier sind die
    // zusätzlichen Wege nach draußen.
    'notify' => [
        'mail'           => (bool) env('NOTIFY_MAIL', true),
        // leer = an mail.to
        'to'             => env('NOTIFY_TO', ''),
        // Mails an die Fahrschüler:innen selbst (bisher nur die PIN)
        'student_mail'   => (bool) env('NOTIFY_STUDENT_MAIL', true),
        // z.B. ein n8n-Webhook. Leer = kein Versand nach außen.
        'webhook_url'    => env('NOTIFY_WEBHOOK_URL', ''),
        'webhook_secret' => env('NOTIFY_WEBHOOK_SECRET', ''),
    ],
];

/** Globaler Zugriff auf Konfiguration via Punkt-Notation: config('contact.phone'). */
function config(string $key, mixed $default = null): mixed
{
    global $config;
    $segments = explode('.', $key);
    $value = $config;
    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }
    return $value;
}

// Fehleranzeige je nach Umgebung
if (config('app_debug')) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
    ini_set('display_errors', '0');
}

// Alle Datums-/Zeitangaben laufen in deutscher Ortszeit.
date_default_timezone_set('Europe/Berlin');

define('BASE_PATH', config('base_path'));
