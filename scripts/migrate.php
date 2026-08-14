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

/**
 * Legt Demo-Schüler:innen an und gibt [email => pin] zurück.
 * Die start_*-Werte sind der Anfangsstand der Pflichtfahrten – so ist der
 * Fortschritt in der Demo nicht überall bei null.
 */
function seed_students(PDO $pdo): array
{
    $students = [
        // name, email, telefon, pin, klasse, [überland, autobahn, nacht], notiz
        ['Lena Hoffmann', 'lena@example.de', '0170 1111111', '111111', 'B',
            [3, 2, 1], 'Fahrstunden seit Mai'],
        ['Tim Brauer', 'tim@example.de', '0170 2222222', '222222', 'B',
            [1, 0, 0], 'braucht noch Autobahnfahrten'],
        ['Mia Sander', 'mia@example.de', '0170 3333333', '333333', 'BE',
            [3, 1, 1], 'Prüfung im Herbst geplant'],
    ];

    $stmt = $pdo->prepare(
        'INSERT INTO students
            (name, email, phone, pin_hash, pin_changed_at, klasse,
             start_ueberland, start_autobahn, start_nacht, note)
         VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)'
    );

    $pins = [];
    foreach ($students as [$name, $email, $phone, $pin, $klasse, $start, $note]) {
        $stmt->execute([
            $name, $email, $phone, password_hash($pin, PASSWORD_DEFAULT),
            $klasse, $start[0], $start[1], $start[2], $note,
        ]);
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
        'INSERT INTO slots (starts_at, duration_min, type, sonderfahrt_art, location, note)
         VALUES (?, ?, ?, ?, ?, ?)'
    );

    $duration = (int) config('booking.slot_duration_min', 45);
    $monday   = week_start(new DateTimeImmutable('now'));
    $now      = new DateTimeImmutable('now');
    $ids      = [];
    // Die Samstags-Sonderfahrten reihum: so sind in der Demo alle drei
    // Pflichtfahrt-Arten vertreten
    $arten    = ['ueberland', 'autobahn', 'nacht'];

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
                $art       = $isSpecial ? $arten[$week % count($arten)] : null;

                $stmt->execute([
                    $start->format('Y-m-d H:i:s'),
                    $isSpecial ? 90 : $duration,
                    $isSpecial ? 'sonderfahrt' : 'fahrstunde',
                    $art,
                    'Treffpunkt Fahrschule',
                    $isSpecial ? 'Pflichtfahrt' : null,
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

/**
 * Ein paar Meldungen für Sarahs Posteingang, damit Übersicht und Posteingang
 * in der Demo nicht leer sind. Im echten Betrieb entstehen sie ausschließlich
 * durch den Notifier, wenn wirklich jemand bucht.
 */
function seed_notifications(PDO $pdo): int
{
    $bookings = $pdo->query(
        "SELECT b.id, s.starts_at, st.name
           FROM bookings b
           JOIN slots s     ON s.id = b.slot_id
           JOIN students st ON st.id = b.student_id
          WHERE b.status = 'gebucht'
          ORDER BY s.starts_at LIMIT 3"
    )->fetchAll();

    if (!$bookings) {
        return 0;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO notifications
            (event, actor, booking_id, student_name, starts_at, from_starts_at,
             title, body, channels, read_at, created_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $now   = new DateTimeImmutable('now');
    $count = 0;

    foreach ($bookings as $i => $booking) {
        $start = dt($booking['starts_at']);
        $name  = $booking['name'];
        // Älteste zuerst einfügen, damit die Reihenfolge der IDs der Zeit
        // entspricht – die Liste sortiert nach ID absteigend.
        $age = $now->modify('-' . ((count($bookings) - $i) * 19 + 6) . ' minutes');
        // Nur die jüngste Meldung wartet noch ungelesen
        $unread = $i === count($bookings) - 1;

        if ($i === 1) {
            // Eine verschobene Stunde – zeigt die Vorher/Nachher-Zeile
            $from = $start->modify('-1 day');
            $stmt->execute([
                'verschoben', 'schueler', $booking['id'], $name,
                $start->format('Y-m-d H:i:s'), $from->format('Y-m-d H:i:s'),
                $name . ' hat eine Stunde verschoben',
                sprintf(
                    "Die Stunde von %s wurde verschoben.\nVorher: %s\nJetzt:  %s",
                    $name,
                    format_datetime($from),
                    format_datetime($start)
                ),
                'mail', $age->format('Y-m-d H:i:s'), $age->format('Y-m-d H:i:s'),
            ]);
        } else {
            $stmt->execute([
                'gebucht', 'schueler', $booking['id'], $name,
                $start->format('Y-m-d H:i:s'), null,
                $name . ' hat sich eingetragen',
                sprintf('%s hat sich für %s eingetragen.', $name, format_datetime($start)),
                'mail',
                $unread ? null : $age->format('Y-m-d H:i:s'),
                $age->format('Y-m-d H:i:s'),
            ]);
        }
        $count++;
    }

    return $count;
}

/**
 * Zählt, was an Bestand da ist. Tabellen, die es noch nicht gibt (erster
 * Lauf), zählen als null – deshalb je Tabelle ein eigenes try.
 *
 * @return array<string,int> nur die Tabellen, in denen etwas steht
 */
function bestand(PDO $pdo): array
{
    $tabellen = [
        'students'      => 'Fahrschüler:innen',
        'slots'         => 'Termine',
        'bookings'      => 'Buchungen',
        'notifications' => 'Meldungen im Posteingang',
    ];

    $gefunden = [];
    foreach ($tabellen as $tabelle => $bezeichnung) {
        try {
            $anzahl = (int) $pdo->query("SELECT COUNT(*) FROM $tabelle")->fetchColumn();
            if ($anzahl > 0) {
                $gefunden[$bezeichnung] = $anzahl;
            }
        } catch (Throwable) {
            // Tabelle gibt es noch nicht – dann steht dort auch nichts drin.
        }
    }

    return $gefunden;
}

/**
 * Fragt nach, bevor Bestand gelöscht wird.
 *
 * Drei Ausgänge, und der dritte ist der wichtigste:
 *   - leere Datenbank        -> läuft ohne Rückfrage durch (erster Aufbau)
 *   - Bestand + Eingabe      -> es muss "LÖSCHEN" getippt werden
 *   - Bestand + keine Eingabe (Cronjob, Skript, docker exec ohne -it)
 *                            -> Abbruch. NICHT durchlaufen lassen: Genau so
 *                               sieht ein versehentlicher Aufruf aus.
 *
 * `--ja-wirklich` überspringt die Frage für den bewussten Skriptbetrieb.
 */
function bestaetigung_einholen(PDO $pdo, array $argv): void
{
    $vorhanden = bestand($pdo);
    if ($vorhanden === []) {
        return;   // nichts zu verlieren
    }

    out('');
    out('╭─ ACHTUNG ─────────────────────────────────────────────────╮');
    out('│ In dieser Datenbank stehen bereits Daten. Dieses Skript    │');
    out('│ spielt das Schema mit DROP TABLE ein – ALLES davon geht    │');
    out('│ verloren, es wird nichts ergänzt und nichts behalten.      │');
    out('╰───────────────────────────────────────────────────────────╯');
    out('');
    out('  Datenbank: ' . config('db.sqlite_path'));
    foreach ($vorhanden as $bezeichnung => $anzahl) {
        // sprintf polstert nach BYTES, nicht nach Zeichen. „Fahrschüler:innen"
        // hat wegen des Umlauts ein Byte mehr als Zeichen und stünde sonst um
        // genau diese Stelle versetzt. Also die Sollbreite um die Differenz
        // erhöhen.
        $zeichen = preg_split('//u', $bezeichnung, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $breite  = 28 + (strlen($bezeichnung) - count($zeichen));
        out(sprintf('  %-' . $breite . 's %d', $bezeichnung, $anzahl));
    }
    out('');

    if (in_array('--ja-wirklich', $argv, true)) {
        out('· --ja-wirklich angegeben, es wird nicht nachgefragt.');

        return;
    }

    // Ohne Eingabemöglichkeit wird NICHT gelöscht. Ein Cronjob oder ein
    // `docker compose exec` ohne -it landet hier – und beides ist mit
    // Sicherheit kein bewusster Löschbefehl.
    if (!stream_isatty(STDIN)) {
        out('✗ Abgebrochen: keine Eingabe möglich (kein Terminal).');
        out('  Gewollt? Dann mit --ja-wirklich noch einmal aufrufen.');
        exit(1);
    }

    fwrite(STDOUT, 'Wirklich alles löschen? Tippe LÖSCHEN: ');
    $antwort = trim((string) fgets(STDIN));

    if ($antwort !== 'LÖSCHEN') {
        out('✗ Abgebrochen, es wurde nichts verändert.');
        exit(1);
    }

    out('');
}

try {
    $withDemo = !in_array('--ohne-demo', $argv, true);

    $pdo = Database::connection();
    out('✓ SQLite-Datenbank: ' . config('db.sqlite_path'));

    // 0) Bremse. Das Schema kommt mit DROP TABLE herein – dieser Aufruf ist
    //    also immer ein Totalverlust, nie eine Ergänzung. Solange nur
    //    Demo-Daten drinstehen, ist das gewollt; sobald Sarah echte Termine
    //    einträgt, ist es der Super-GAU. Der Unterschied ist von außen nicht
    //    zu sehen, und der zwischen `migrate.php` und `migrate.php --ohne-demo`
    //    ist im Eifer schnell übersehen.
    bestaetigung_einholen($pdo, $argv);

    // 1) Schema einspielen (setzt die Datenbank neu auf)
    $pdo->exec(file_get_contents(APP_ROOT . '/database/schema.sqlite.sql'));
    out('✓ Schema eingespielt.');

    // 2) Admin-Zugang für Sarah aus der .env.
    //    Das Passwort steht dort im Klartext, ist also ein EINMALpasswort:
    //    must_change_password = 1 zwingt Sarah beim ersten Anmelden zum Wechsel.
    $email = (string) config('admin.email');
    $hash  = password_hash((string) config('admin.password'), PASSWORD_DEFAULT);
    $pdo->prepare(
        'INSERT OR REPLACE INTO admins (email, password_hash, must_change_password)
         VALUES (?, ?, 1)'
    )->execute([$email, $hash]);
    out("✓ Admin-Zugang '$email' angelegt (Passwortwechsel beim ersten Anmelden).");

    // 3) Demo-Daten
    $pins = [];
    if ($withDemo) {
        $pins    = seed_students($pdo);
        $slotIds = seed_slots($pdo);
        $booked  = seed_bookings($pdo, $slotIds);
        $notes   = seed_notifications($pdo);
        out('✓ Demo-Daten: ' . count($pins) . ' Schüler, ' . count($slotIds)
            . ' Termine (davon ' . $booked . ' gebucht), ' . $notes . ' Meldungen.');
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
