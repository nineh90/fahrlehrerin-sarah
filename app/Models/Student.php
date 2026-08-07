<?php
declare(strict_types=1);

/**
 * Fahrschüler:innen. Werden ausschließlich von Sarah im Admin angelegt.
 * Sämtlicher SQL-Zugriff auf students läuft über diese Klasse.
 */
final class Student
{
    /** Führerscheinklassen, die Sarah ausbildet. Schlüssel = DB-Wert. */
    public const KLASSEN = [
        'B'  => 'Klasse B',
        'BE' => 'Klasse BE',
    ];

    /**
     * Pflichtstunden je Klasse (§5 FahrschAusbO, „besondere Ausbildungsfahrten").
     * Klasse B: 5 Überland, 4 Autobahn, 3 Nacht – je 45 Minuten.
     * Klasse BE baut auf einer vorhandenen B auf und verlangt entsprechend weniger.
     *
     * Stand August 2026. Ändert der Gesetzgeber die Zahlen, wird NUR hier
     * angefasst – Anzeige und Fortschritt leiten sich vollständig daraus ab.
     */
    public const PFLICHT_SOLL = [
        'B'  => ['ueberland' => 5, 'autobahn' => 4, 'nacht' => 3],
        'BE' => ['ueberland' => 3, 'autobahn' => 1, 'nacht' => 1],
    ];

    public static function all(): array
    {
        return Database::connection()
            ->query('SELECT * FROM students ORDER BY name COLLATE NOCASE')
            ->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM students WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM students WHERE email = ? LIMIT 1');
        $stmt->execute([mb_strtolower(trim($email))]);
        return $stmt->fetch() ?: null;
    }

    /** Legt einen Schüler an und gibt die neue ID zurück. */
    public static function create(array $data, string $pin): int
    {
        $pdo = Database::connection();
        $pdo->prepare(
            'INSERT INTO students
                (name, email, phone, pin_hash, pin_changed_at, klasse,
                 start_ueberland, start_autobahn, start_nacht, note)
             VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)'
        )->execute([
            $data['name'],
            mb_strtolower(trim($data['email'])),
            $data['phone'] ?: null,
            password_hash($pin, PASSWORD_DEFAULT),
            self::klasse($data),
            (int) ($data['start_ueberland'] ?? 0),
            (int) ($data['start_autobahn'] ?? 0),
            (int) ($data['start_nacht'] ?? 0),
            $data['note'] ?: null,
        ]);

        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        Database::connection()->prepare(
            'UPDATE students
                SET name = ?, email = ?, phone = ?, klasse = ?,
                    start_ueberland = ?, start_autobahn = ?, start_nacht = ?,
                    note = ?, active = ?
              WHERE id = ?'
        )->execute([
            $data['name'],
            mb_strtolower(trim($data['email'])),
            $data['phone'] ?: null,
            self::klasse($data),
            (int) ($data['start_ueberland'] ?? 0),
            (int) ($data['start_autobahn'] ?? 0),
            (int) ($data['start_nacht'] ?? 0),
            $data['note'] ?: null,
            !empty($data['active']) ? 1 : 0,
            $id,
        ]);
    }

    /** Setzt eine neue PIN und gibt sie im Klartext zurück (nur einmalig anzeigen!). */
    public static function resetPin(int $id): string
    {
        $pin = StudentAuth::generatePin();
        Database::connection()
            ->prepare('UPDATE students SET pin_hash = ?, pin_changed_at = CURRENT_TIMESTAMP WHERE id = ?')
            ->execute([password_hash($pin, PASSWORD_DEFAULT), $id]);

        return $pin;
    }

    /** Hält fest, dass die PIN per Mail rausging – nur für die Anzeige im Admin. */
    public static function markPinSent(int $id): void
    {
        Database::connection()
            ->prepare('UPDATE students SET pin_sent_at = CURRENT_TIMESTAMP WHERE id = ?')
            ->execute([$id]);
    }

    /** Löscht einen Schüler. Buchungen verschwinden per ON DELETE CASCADE mit. */
    public static function delete(int $id): void
    {
        Database::connection()->prepare('DELETE FROM students WHERE id = ?')->execute([$id]);
    }

    /** Prüft, ob eine E-Mail schon vergeben ist (optional außer beim eigenen Datensatz). */
    public static function emailTaken(string $email, ?int $exceptId = null): bool
    {
        $sql    = 'SELECT COUNT(*) FROM students WHERE email = ?';
        $params = [mb_strtolower(trim($email))];
        if ($exceptId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $exceptId;
        }
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Stand der Pflichtfahrten einer Person.
     *
     * Gezählt werden nur Sonderfahrten, die auch wirklich stattgefunden haben:
     * gebuchte Termine mit gesetzter Art, deren Zeit vorbei ist. Ein für nächste
     * Woche eingetragener Autobahntermin zählt also noch nicht – erst danach.
     * Dazu kommt der Anfangsstand aus den start_*-Spalten (alles, was vor dieser
     * Website gefahren wurde).
     *
     * @return array<string, array{gefahren:int,start:int,gesamt:int,soll:int,offen:int,prozent:int}>
     */
    public static function pflichtfahrten(int $id): array
    {
        $student = self::find($id);
        if (!$student) {
            return [];
        }
        $soll = self::PFLICHT_SOLL[$student['klasse']] ?? self::PFLICHT_SOLL['B'];

        $stmt = Database::connection()->prepare(
            "SELECT s.sonderfahrt_art AS art, COUNT(*) AS anzahl
               FROM bookings b
               JOIN slots s ON s.id = b.slot_id
              WHERE b.student_id = ?
                AND b.status = 'gebucht'
                AND s.type = 'sonderfahrt'
                AND s.sonderfahrt_art IS NOT NULL
                AND s.starts_at < datetime('now', 'localtime')
              GROUP BY s.sonderfahrt_art"
        );
        $stmt->execute([$id]);
        $gefahren = array_column($stmt->fetchAll(), 'anzahl', 'art');

        $stand = [];
        foreach (Slot::SONDERFAHRT_ARTEN as $art => $label) {
            $ist    = (int) ($gefahren[$art] ?? 0);
            $start  = (int) ($student['start_' . $art] ?? 0);
            $gesamt = $ist + $start;
            $ziel   = (int) ($soll[$art] ?? 0);

            $stand[$art] = [
                'gefahren' => $ist,
                'start'    => $start,
                'gesamt'   => $gesamt,
                'soll'     => $ziel,
                'offen'    => max(0, $ziel - $gesamt),
                // Über 100 % wird gedeckelt: der Balken soll nicht auslaufen,
                // eine Fahrt mehr als nötig ist kein Fehler
                'prozent'  => $ziel > 0 ? min(100, (int) round($gesamt / $ziel * 100)) : 100,
            ];
        }

        return $stand;
    }

    /** Sind alle Pflichtfahrten zusammen? */
    public static function pflichtfahrtenKomplett(array $stand): bool
    {
        foreach ($stand as $eintrag) {
            if ($eintrag['offen'] > 0) {
                return false;
            }
        }

        return $stand !== [];
    }

    /** Auswahlliste für Zuweisungen: nur aktive Personen, alphabetisch. */
    public static function activeOptions(): array
    {
        return Database::connection()
            ->query('SELECT id, name FROM students WHERE active = 1 ORDER BY name COLLATE NOCASE')
            ->fetchAll();
    }

    /** Fällt auf 'B' zurück, wenn nichts Gültiges kommt. */
    private static function klasse(array $data): string
    {
        $klasse = (string) ($data['klasse'] ?? 'B');

        return isset(self::KLASSEN[$klasse]) ? $klasse : 'B';
    }

    /** Anzahl kommender, nicht stornierter Termine je Schüler-ID. */
    public static function upcomingCounts(): array
    {
        $rows = Database::connection()->query(
            "SELECT b.student_id, COUNT(*) AS anzahl
               FROM bookings b
               JOIN slots s ON s.id = b.slot_id
              WHERE b.status = 'gebucht' AND s.starts_at >= datetime('now', 'localtime')
              GROUP BY b.student_id"
        )->fetchAll();

        return array_column($rows, 'anzahl', 'student_id');
    }
}
