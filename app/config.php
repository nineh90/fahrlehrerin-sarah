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
    'db' => [
        'sqlite_path' => env('DB_SQLITE_PATH', APP_ROOT . '/storage/database.sqlite'),
    ],
    'admin' => [
        'email'    => env('ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('ADMIN_PASSWORD', 'admin12345'),
    ],
    'booking' => [
        // Bis wie viele Stunden vor Terminbeginn darf storniert/verschoben werden
        'cancel_deadline_hours' => (int) env('CANCEL_DEADLINE_HOURS', 24),
        'slot_duration_min'     => (int) env('SLOT_DURATION_MIN', 45),
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
    'contact' => [
        'phone' => env('CONTACT_PHONE', '0123 456789'),
        'email' => env('CONTACT_EMAIL', 'hallo@fahrlehrerin-sarah.de'),
        'city'  => env('CONTACT_CITY', 'Neu Wulmstorf'),
        // Einzugsgebiet als Liste, in der .env mit Komma getrennt
        'area'  => array_values(array_filter(array_map(
            'trim',
            explode(',', (string) env('CONTACT_AREA', 'Neu Wulmstorf, Buxtehude, Stade, Hamburg'))
        ))),
    ],
    'mail' => [
        'driver' => env('MAIL_DRIVER', 'log'),
        'to'     => env('MAIL_TO', 'info@example.com'),
        'from'   => env('MAIL_FROM', 'noreply@example.com'),
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
