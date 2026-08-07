<?php
declare(strict_types=1);

/**
 * Von Sarah freigegebene Termine.
 *
 * Status-Bedeutung:
 *   frei     – für Schüler buchbar
 *   gebucht  – belegt (es existiert eine aktive Buchung)
 *   gesperrt – von Sarah blockiert, für Schüler nicht sichtbar
 */
final class Slot
{
    /** Schlüssel = DB-Wert, Wert = Anzeigetext. Anzeige IMMER über diese Maps. */
    public const STATUSES = [
        'frei'     => 'Frei',
        'gebucht'  => 'Gebucht',
        'gesperrt' => 'Gesperrt',
    ];

    public const TYPES = [
        'fahrstunde'  => 'Fahrstunde',
        'sonderfahrt' => 'Sonderfahrt',
        'pruefung'    => 'Prüfung',
    ];

    /**
     * Die drei Pflichtfahrten (§5 FahrschAusbO). Nur bei type='sonderfahrt'
     * relevant – aus ihnen errechnet sich der Ausbildungsstand.
     */
    public const SONDERFAHRT_ARTEN = [
        'ueberland' => 'Überlandfahrt',
        'autobahn'  => 'Autobahnfahrt',
        'nacht'     => 'Nachtfahrt',
    ];

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM slots WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Alle Termine einer Woche (Montag 00:00 bis Sonntag 24:00), inkl. Name
     * des buchenden Schülers. Für den Admin-Kalender.
     */
    public static function forWeek(DateTimeInterface $monday): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT s.*, b.id AS booking_id, b.student_id, st.name AS student_name
               FROM slots s
               LEFT JOIN bookings b ON b.slot_id = s.id AND b.status = \'gebucht\'
               LEFT JOIN students st ON st.id = b.student_id
              WHERE s.starts_at >= ? AND s.starts_at < ?
              ORDER BY s.starts_at'
        );
        $stmt->execute(self::weekBounds($monday));

        return $stmt->fetchAll();
    }

    /**
     * Termine einer Woche aus Schülersicht: gesperrte bleiben außen vor,
     * eigene Buchungen werden markiert.
     */
    public static function forWeekPublic(DateTimeInterface $monday, ?int $studentId): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT s.*, b.id AS booking_id, b.student_id
               FROM slots s
               LEFT JOIN bookings b ON b.slot_id = s.id AND b.status = \'gebucht\'
              WHERE s.starts_at >= ? AND s.starts_at < ?
                AND s.status IN (\'frei\', \'gebucht\')
              ORDER BY s.starts_at'
        );
        $stmt->execute(self::weekBounds($monday));

        $slots = $stmt->fetchAll();
        foreach ($slots as &$slot) {
            $slot['is_own'] = $studentId !== null && (int) $slot['student_id'] === $studentId;
        }

        return $slots;
    }

    /**
     * Alle Termine eines Tages inkl. Schülerdaten – der Tagesplan im Dashboard.
     * Bewusst mit den freien und gesperrten Zeiten: Sarah soll ihren Tag sehen,
     * nicht nur die belegten Stunden.
     */
    public static function forDay(DateTimeInterface $day): array
    {
        $start = DateTimeImmutable::createFromInterface($day)->setTime(0, 0);

        $stmt = Database::connection()->prepare(
            'SELECT s.*, st.name AS student_name, st.phone AS student_phone, b.id AS booking_id
               FROM slots s
               LEFT JOIN bookings b  ON b.slot_id = s.id AND b.status = \'gebucht\'
               LEFT JOIN students st ON st.id = b.student_id
              WHERE s.starts_at >= ? AND s.starts_at < ?
              ORDER BY s.starts_at'
        );
        $stmt->execute([
            $start->format('Y-m-d H:i:s'),
            $start->modify('+1 day')->format('Y-m-d H:i:s'),
        ]);

        return $stmt->fetchAll();
    }

    /** Alle künftigen freien Termine – Auswahlliste beim Verschieben. */
    public static function upcomingFree(int $limit = 60): array
    {
        $stmt = Database::connection()->prepare(
            "SELECT * FROM slots
              WHERE status = 'frei' AND starts_at >= datetime('now', 'localtime')
              ORDER BY starts_at LIMIT ?"
        );
        $stmt->execute([$limit]);

        return $stmt->fetchAll();
    }

    /**
     * Die nächste freie Zeit ab einem Zeitpunkt.
     *
     * Der Wochenkalender zeigt immer nur sieben Tage. Gibt Sarah eine Woche
     * weiter vorn frei und dazwischen liegt eine leere Woche, sieht die Seite
     * aus, als wäre nichts da – man müsste blind weiterklicken. Damit kann die
     * Ansicht stattdessen sagen, wo es weitergeht.
     */
    public static function nextFreeFrom(DateTimeInterface $from): ?array
    {
        $stmt = Database::connection()->prepare(
            "SELECT * FROM slots
              WHERE status = 'frei' AND starts_at >= ?
              ORDER BY starts_at LIMIT 1"
        );
        $stmt->execute([DateTimeImmutable::createFromInterface($from)->format('Y-m-d H:i:s')]);

        return $stmt->fetch() ?: null;
    }

    /** Nächste belegte Termine – für Sarahs Dashboard. */
    public static function upcomingBooked(int $limit = 8): array
    {
        $stmt = Database::connection()->prepare(
            "SELECT s.*, st.name AS student_name, st.phone AS student_phone, b.id AS booking_id
               FROM slots s
               JOIN bookings b  ON b.slot_id = s.id AND b.status = 'gebucht'
               JOIN students st ON st.id = b.student_id
              WHERE s.starts_at >= datetime('now', 'localtime')
              ORDER BY s.starts_at LIMIT ?"
        );
        $stmt->execute([$limit]);

        return $stmt->fetchAll();
    }

    /** Kennzahlen für das Dashboard. */
    public static function stats(): array
    {
        $pdo = Database::connection();

        return [
            'frei_gesamt' => (int) $pdo->query(
                "SELECT COUNT(*) FROM slots WHERE status = 'frei' AND starts_at >= datetime('now','localtime')"
            )->fetchColumn(),
            'gebucht_gesamt' => (int) $pdo->query(
                "SELECT COUNT(*) FROM slots WHERE status = 'gebucht' AND starts_at >= datetime('now','localtime')"
            )->fetchColumn(),
            'diese_woche' => (int) $pdo->query(
                "SELECT COUNT(*) FROM slots
                  WHERE starts_at >= datetime('now','localtime')
                    AND starts_at < datetime('now','localtime','+7 days')"
            )->fetchColumn(),
            'woche_gebucht' => (int) $pdo->query(
                "SELECT COUNT(*) FROM slots
                  WHERE status = 'gebucht'
                    AND starts_at >= datetime('now','localtime')
                    AND starts_at < datetime('now','localtime','+7 days')"
            )->fetchColumn(),
            'schueler' => (int) $pdo->query('SELECT COUNT(*) FROM students WHERE active = 1')->fetchColumn(),
        ];
    }

    /**
     * Legt einen Termin an. Gibt die neue ID zurück oder null, wenn zu dieser
     * Uhrzeit bereits ein Termin existiert (UNIQUE auf starts_at).
     */
    public static function create(array $data): ?int
    {
        $pdo = Database::connection();
        try {
            $pdo->prepare(
                'INSERT INTO slots (starts_at, duration_min, type, sonderfahrt_art, location, note)
                 VALUES (?, ?, ?, ?, ?, ?)'
            )->execute([
                $data['starts_at'],
                (int) $data['duration_min'],
                $data['type'],
                // Die Art gehört nur zur Sonderfahrt – sonst bliebe eine
                // Autobahnfahrt an einer Prüfung kleben und würde mitgezählt
                $data['type'] === 'sonderfahrt' ? ($data['sonderfahrt_art'] ?: null) : null,
                $data['location'] ?: null,
                $data['note'] ?: null,
            ]);
        } catch (PDOException $e) {
            // 23000 = Constraint-Verletzung -> Termin existiert schon
            if ($e->getCode() === '23000') {
                return null;
            }
            throw $e;
        }

        return (int) $pdo->lastInsertId();
    }

    /** Sperrt einen freien Termin bzw. gibt einen gesperrten wieder frei. */
    public static function toggleBlocked(int $id): bool
    {
        $slot = self::find($id);
        if (!$slot || $slot['status'] === 'gebucht') {
            return false;
        }

        $new = $slot['status'] === 'gesperrt' ? 'frei' : 'gesperrt';
        Database::connection()
            ->prepare('UPDATE slots SET status = ? WHERE id = ?')
            ->execute([$new, $id]);

        return true;
    }

    /** Löscht einen Termin. Gebuchte Termine werden nicht gelöscht. */
    public static function delete(int $id): bool
    {
        $slot = self::find($id);
        if (!$slot || $slot['status'] === 'gebucht') {
            return false;
        }
        Database::connection()->prepare('DELETE FROM slots WHERE id = ?')->execute([$id]);

        return true;
    }

    /** Liegt der Termin in der Vergangenheit? */
    public static function isPast(array $slot): bool
    {
        return dt($slot['starts_at']) < new DateTimeImmutable('now');
    }

    /**
     * Anzeigetext für Typ + Dauer, z.B. "Fahrstunde · 45 Min.".
     * Sonderfahrten nennen ihre Art statt des Oberbegriffs: "Autobahnfahrt"
     * sagt mehr als "Sonderfahrt".
     */
    public static function label(array $slot): string
    {
        $art = $slot['sonderfahrt_art'] ?? null;
        $typ = $art !== null && isset(self::SONDERFAHRT_ARTEN[$art])
            ? self::SONDERFAHRT_ARTEN[$art]
            : (self::TYPES[$slot['type']] ?? $slot['type']);

        return $typ . ' · ' . (int) $slot['duration_min'] . ' Min.';
    }

    /** @return array{0:string,1:string} Start und Ende der Woche als DB-Zeitstempel. */
    private static function weekBounds(DateTimeInterface $monday): array
    {
        $start = DateTimeImmutable::createFromInterface($monday)->setTime(0, 0);

        return [
            $start->format('Y-m-d H:i:s'),
            $start->modify('+7 days')->format('Y-m-d H:i:s'),
        ];
    }
}
