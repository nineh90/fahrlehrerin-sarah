<?php
declare(strict_types=1);

/**
 * Migrationsskript: legt die SQLite-Datenbank an, spielt das Schema ein,
 * erstellt Sarahs Admin-Zugang und füllt Demo-Daten ein.
 *
 * Aufruf:  php scripts/migrate.php              (Schema + Admin + Demo-Daten)
 *          php scripts/migrate.php --ohne-demo  (nur Schema + Admin)
 *
 * Die Demo-Termine werden RELATIV ZUM HEUTIGEN DATUM erzeugt. Dadurch sieht
 * die Demo auch in vier Wochen noch frisch aus – einfach neu migrieren.
 */

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/helpers.php';
require __DIR__ . '/../app/Database.php';

function out(string $msg): void
{
    fwrite(STDOUT, $msg . PHP_EOL);
}

/** Legt Demo-Schüler:innen an und gibt [email => pin] zurück. */
function seed_students(PDO $pdo): array
{
    $students = [
        ['Lena Hoffmann', 'lena@example.de',  '0170 1111111', '111111', 'Klasse B, Fahrstunden seit Mai'],
        ['Tim Brauer',    'tim@example.de',   '0170 2222222', '222222', 'Klasse B, braucht noch Autobahnfahrten'],
        ['Mia Sander',    'mia@example.de',   '0170 3333333', '333333', 'Klasse B, Prüfung im Herbst geplant'],
    ];

    $stmt = $pdo->prepare(
        'INSERT INTO students (name, email, phone, pin_hash, note) VALUES (?, ?, ?, ?, ?)'
    );

    $pins = [];
    foreach ($students as [$name, $email, $phone, $pin, $note]) {
        $stmt->execute([$name, $email, $phone, password_hash($pin, PASSWORD_DEFAULT), $note]);
        $pins[$email] = $pin;
    }

    return $pins;
}

/**
 * Erzeugt Termine für die aktuelle und die beiden folgenden Wochen.
 * Muster: Mo–Fr 14/15/16/17 Uhr, Sa 10/11 Uhr. Vergangenes wird übersprungen.
 *
 * @return array<int, int> IDs der angelegten Slots
 */
function seed_slots(PDO $pdo): array
{
    $pattern = [
        1 => ['14:00', '15:00', '16:00', '17:00'], // Montag
        2 => ['14:00', '15:00', '16:00', '17:00'],
        3 => ['14:00', '15:00', '16:00', '17:00'],
        4 => ['14:00', '15:00', '16:00', '17:00'],
        5 => ['13:00', '14:00', '15:00'],          // Freitag etwas kürzer
        6 => ['10:00', '11:00'],                   // Samstag
    ];

    $stmt = $pdo->prepare(
        'INSERT INTO slots (starts_at, duration_min, type, location, note) VALUES (?, ?, ?, ?, ?)'
    );

    $duration = (int) config('booking.slot_duration_min', 45);
    $monday   = week_start(new DateTimeImmutable('now'));
    $now      = new DateTimeImmutable('now');
    $ids      = [];

    for ($week = 0; $week < 3; $week++) {
        $weekStart = $monday->modify("+$week weeks");

        foreach ($pattern as $weekday => $times) {
            $day = $weekStart->modify('+' . ($weekday - 1) . ' days');

            foreach ($times as $time) {
                [$h, $i] = array_map('intval', explode(':', $time));
                $start = $day->setTime($h, $i);

                if ($start <= $now) {
                    continue; // Vergangenes nicht anbieten
                }

                // Ein Samstagstermin pro Woche ist eine längere Sonderfahrt
                $isSpecial = $weekday === 6 && $time === '10:00';

                $stmt->execute([
                    $start->format('Y-m-d H:i:s'),
                    $isSpecial ? 90 : $duration,
                    $isSpecial ? 'sonderfahrt' : 'fahrstunde',
                    'Treffpunkt Fahrschule',
                    $isSpecial ? 'Überland- oder Autobahnfahrt' : null,
                ]);
                $ids[] = (int) $pdo->lastInsertId();
            }
        }
    }

    return $ids;
}

/** Bucht einige Slots für die Demo-Schüler, damit die Ansichten gefüllt sind. */
function seed_bookings(PDO $pdo, array $slotIds): int
{
    $studentIds = $pdo->query('SELECT id FROM students ORDER BY id')->fetchAll(PDO::FETCH_COLUMN);
    if (!$studentIds || !$slotIds) {
        return 0;
    }

    // Jeden dritten Termin belegen, reihum unter den Schülern
    $bookSlot   = $pdo->prepare("UPDATE slots SET status = 'gebucht' WHERE id = ?");
    $insBooking = $pdo->prepare('INSERT INTO bookings (slot_id, student_id) VALUES (?, ?)');
    $insLog     = $pdo->prepare(
        "INSERT INTO booking_log (booking_id, action, to_slot_id, actor) VALUES (?, 'gebucht', ?, 'schueler')"
    );

    $count = 0;
    foreach ($slotIds as $index => $slotId) {
        if ($index % 3 !== 0) {
            continue;
        }
        $studentId = $studentIds[$count % count($studentIds)];

        $bookSlot->execute([$slotId]);
        $insBooking->execute([$slotId, $studentId]);
        $insLog->execute([(int) $pdo->lastInsertId(), $slotId]);
        $count++;
    }

    // Ein gesperrter Termin, damit die Sperr-Funktion sichtbar ist
    $free = $pdo->query("SELECT id FROM slots WHERE status = 'frei' ORDER BY starts_at DESC LIMIT 1")
        ->fetchColumn();
    if ($free) {
        $pdo->prepare("UPDATE slots SET status = 'gesperrt', note = 'Sarah nicht verfügbar' WHERE id = ?")
            ->execute([(int) $free]);
    }

    return $count;
}

try {
    $withDemo = !in_array('--ohne-demo', $argv, true);

    $pdo = Database::connection();
    out('✓ SQLite-Datenbank: ' . config('db.sqlite_path'));

    // 1) Schema einspielen (setzt die Datenbank neu auf)
    $pdo->exec(file_get_contents(APP_ROOT . '/database/schema.sqlite.sql'));
    out('✓ Schema eingespielt.');

    // 2) Admin-Zugang für Sarah aus der .env
    $email = (string) config('admin.email');
    $hash  = password_hash((string) config('admin.password'), PASSWORD_DEFAULT);
    $pdo->prepare('INSERT OR REPLACE INTO admins (email, password_hash) VALUES (?, ?)')
        ->execute([$email, $hash]);
    out("✓ Admin-Zugang '$email' angelegt.");

    // 3) Demo-Daten
    $pins = [];
    if ($withDemo) {
        $pins    = seed_students($pdo);
        $slotIds = seed_slots($pdo);
        $booked  = seed_bookings($pdo, $slotIds);
        out('✓ Demo-Daten: ' . count($pins) . ' Schüler, ' . count($slotIds)
            . ' Termine (davon ' . $booked . ' gebucht).');
    } else {
        out('· Demo-Daten übersprungen (--ohne-demo).');
    }

    $base = BASE_PATH !== '' ? BASE_PATH : '';
    out('');
    out('Fertig. Los geht es mit:  php -S localhost:8000 -t public');
    out('');
    out('  Admin (Sarah):   ' . $base . '/admin/login');
    out("    E-Mail:        $email");
    out('    Passwort:      (aus .env – ADMIN_PASSWORD)');

    if ($pins) {
        out('');
        out('  Schüler-Login:   ' . $base . '/login');
        foreach ($pins as $mail => $pin) {
            out(sprintf('    %-18s PIN %s', $mail, $pin));
        }
    }
} catch (Throwable $e) {
    fwrite(STDERR, 'Fehler bei der Migration: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
