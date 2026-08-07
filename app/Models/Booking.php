<?php
declare(strict_types=1);

/**
 * Buchungen von Fahrstunden.
 *
 * Die drei schreibenden Aktionen (buchen, stornieren, verschieben) laufen
 * jeweils in EINER Transaktion und halten Slot-Status und Buchung konsistent.
 * Gegen Doppelbuchungen schützt zusätzlich das bedingte UPDATE:
 * "UPDATE slots SET status='gebucht' WHERE id = ? AND status = 'frei'" –
 * greift nur, wenn der Termin in diesem Moment wirklich noch frei ist.
 *
 * Die Methoden geben bei Erfolg null zurück, sonst eine deutsche Fehlermeldung,
 * die der Controller direkt als Flash-Message ausgeben kann.
 */
final class Booking
{
    public const STATUSES = [
        'gebucht'   => 'Gebucht',
        'storniert' => 'Storniert',
    ];

    // -----------------------------------------------------------------------
    // Lesen
    // -----------------------------------------------------------------------

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT b.*, s.starts_at, s.duration_min, s.type, s.location, s.note AS slot_note,
                    st.name AS student_name, st.email AS student_email, st.phone AS student_phone
               FROM bookings b
               JOIN slots s    ON s.id = b.slot_id
               JOIN students st ON st.id = b.student_id
              WHERE b.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    /** Alle Buchungen eines Schülers, kommende zuerst. */
    public static function forStudent(int $studentId): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT b.*, s.starts_at, s.duration_min, s.type, s.location, s.note AS slot_note
               FROM bookings b
               JOIN slots s ON s.id = b.slot_id
              WHERE b.student_id = ?
              ORDER BY s.starts_at'
        );
        $stmt->execute([$studentId]);

        return $stmt->fetchAll();
    }

    /** Alle Buchungen für den Admin, optional nach Status gefiltert. */
    public static function all(?string $status = null): array
    {
        $sql = 'SELECT b.*, s.starts_at, s.duration_min, s.type, s.location,
                       st.name AS student_name, st.phone AS student_phone
                  FROM bookings b
                  JOIN slots s     ON s.id = b.slot_id
                  JOIN students st ON st.id = b.student_id';
        $params = [];

        if ($status !== null && isset(self::STATUSES[$status])) {
            $sql .= ' WHERE b.status = ?';
            $params[] = $status;
        }
        $sql .= ' ORDER BY s.starts_at DESC';

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /** Verlauf einer Buchung (gebucht / verschoben / storniert). */
    public static function history(int $bookingId): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT l.*, fs.starts_at AS from_starts_at, ts.starts_at AS to_starts_at
               FROM booking_log l
               LEFT JOIN slots fs ON fs.id = l.from_slot_id
               LEFT JOIN slots ts ON ts.id = l.to_slot_id
              WHERE l.booking_id = ?
              ORDER BY l.id'
        );
        $stmt->execute([$bookingId]);

        return $stmt->fetchAll();
    }

    // -----------------------------------------------------------------------
    // Regeln
    // -----------------------------------------------------------------------

    /** Frist in Stunden, bis wann Schüler selbst ändern dürfen. */
    public static function deadlineHours(): int
    {
        return (int) config('booking.cancel_deadline_hours', 24);
    }

    /**
     * Darf der Schüler diese Buchung noch selbst stornieren/verschieben?
     * Nein, wenn sie storniert ist oder die Frist überschritten wurde.
     */
    public static function isEditable(array $booking): bool
    {
        if ($booking['status'] !== 'gebucht') {
            return false;
        }
        $deadline = dt($booking['starts_at'])->modify('-' . self::deadlineHours() . ' hours');

        return new DateTimeImmutable('now') < $deadline;
    }

    /**
     * Liegt dieser Termin bereits innerhalb der Änderungsfrist?
     * Gebucht werden darf er trotzdem – die Frist schützt nur vor kurzfristigen
     * Absagen. Wer ihn wählt, kann ihn danach aber nicht mehr selbst ändern,
     * und genau darauf weist die Terminauswahl hin.
     */
    public static function isWithinDeadline(string $startsAt): bool
    {
        $deadline = dt($startsAt)->modify('-' . self::deadlineHours() . ' hours');

        return new DateTimeImmutable('now') >= $deadline;
    }

    /** Erklärt, warum eine Buchung nicht mehr änderbar ist. */
    public static function lockReason(array $booking): string
    {
        if ($booking['status'] !== 'gebucht') {
            return 'Diese Buchung wurde bereits storniert.';
        }

        return sprintf(
            'Änderungen sind bis %d Stunden vor dem Termin möglich. Melde dich bitte direkt bei Sarah.',
            self::deadlineHours()
        );
    }

    // -----------------------------------------------------------------------
    // Schreiben
    // -----------------------------------------------------------------------

    /**
     * Bucht einen freien Termin. Gibt null bei Erfolg zurück, sonst die Fehlermeldung.
     *
     * $actor 'admin' bedeutet: Sarah weist den Termin zu, statt dass sich jemand
     * selbst einträgt. Der Weg ist derselbe – Doppelbuchungsschutz, Verlauf und
     * Meldung gelten für beide Seiten gleichermaßen. Nur zwei Unterschiede:
     * Sarah darf auch einen gesperrten Termin vergeben (den hat sie selbst
     * blockiert, etwa für eine Prüfung), und sie darf ihn nachtragen, wenn er
     * schon vorbei ist.
     */
    public static function book(int $slotId, int $studentId, string $actor = 'schueler'): ?string
    {
        $slot = Slot::find($slotId);
        if (!$slot) {
            return 'Diesen Termin gibt es nicht (mehr).';
        }
        if ($actor !== 'admin' && Slot::isPast($slot)) {
            return 'Dieser Termin liegt bereits in der Vergangenheit.';
        }
        if ($slot['status'] === 'gebucht') {
            return 'Dieser Termin ist bereits vergeben.';
        }
        if ($slot['status'] === 'gesperrt' && $actor !== 'admin') {
            return 'Diese Zeit steht gerade nicht zur Verfügung.';
        }

        $student = Student::find($studentId);
        if (!$student) {
            return 'Diese:n Fahrschüler:in gibt es nicht (mehr).';
        }
        if ($actor === 'admin' && (int) $student['active'] !== 1) {
            return $student['name'] . ' ist auf inaktiv gesetzt. Bitte zuerst den Zugang wieder aktivieren.';
        }

        // Sarah vergibt auch gesperrte Zeiten, Schüler:innen nur freie
        $erlaubt = $actor === 'admin' ? ['frei', 'gesperrt'] : ['frei'];
        $bookingId = null;

        $error = Database::transaction(
            static function (PDO $pdo) use ($slotId, $studentId, $actor, $erlaubt, &$bookingId): ?string {
                // Greift nur, wenn der Termin JETZT noch zu haben ist -> keine Doppelbuchung
                $platzhalter = implode(',', array_fill(0, count($erlaubt), '?'));
                $update = $pdo->prepare(
                    "UPDATE slots SET status = 'gebucht' WHERE id = ? AND status IN ($platzhalter)"
                );
                $update->execute([$slotId, ...$erlaubt]);

                if ($update->rowCount() === 0) {
                    return 'Diese Zeit wurde gerade eben vergeben. Bitte wähle eine andere.';
                }

                $pdo->prepare('INSERT INTO bookings (slot_id, student_id) VALUES (?, ?)')
                    ->execute([$slotId, $studentId]);

                $bookingId = (int) $pdo->lastInsertId();
                self::log($pdo, $bookingId, 'gebucht', null, $slotId, $actor);

                return null;
            }
        );

        if ($error === null && $bookingId !== null) {
            Notifier::bookingChanged('gebucht', self::find($bookingId), $actor);
        }

        return $error;
    }

    /**
     * Storniert eine Buchung. $actor 'admin' umgeht die Frist –
     * Sarah muss auch kurzfristig absagen können.
     */
    public static function cancel(int $bookingId, string $actor = 'schueler'): ?string
    {
        $booking = self::find($bookingId);
        if (!$booking) {
            return 'Diese Buchung gibt es nicht (mehr).';
        }
        if ($booking['status'] !== 'gebucht') {
            return 'Diese Buchung wurde bereits storniert.';
        }
        if ($actor !== 'admin' && !self::isEditable($booking)) {
            return self::lockReason($booking);
        }

        Database::transaction(static function (PDO $pdo) use ($booking, $actor): void {
            $pdo->prepare(
                "UPDATE bookings SET status = 'storniert', cancelled_at = CURRENT_TIMESTAMP WHERE id = ?"
            )->execute([$booking['id']]);

            // Termin nur wieder freigeben, wenn er noch nicht vorbei ist
            $pdo->prepare(
                "UPDATE slots SET status = 'frei' WHERE id = ? AND status = 'gebucht'"
            )->execute([$booking['slot_id']]);

            self::log($pdo, (int) $booking['id'], 'storniert', (int) $booking['slot_id'], null, $actor);
        });

        Notifier::bookingChanged('storniert', $booking, $actor);

        return null;
    }

    /** Verschiebt eine Buchung auf einen anderen freien Termin. */
    public static function reschedule(int $bookingId, int $newSlotId, string $actor = 'schueler'): ?string
    {
        $booking = self::find($bookingId);
        if (!$booking) {
            return 'Diese Buchung gibt es nicht (mehr).';
        }
        if ($booking['status'] !== 'gebucht') {
            return 'Diese Buchung wurde bereits storniert.';
        }
        if ($actor !== 'admin' && !self::isEditable($booking)) {
            return self::lockReason($booking);
        }
        if ((int) $booking['slot_id'] === $newSlotId) {
            return 'Das ist bereits deine aktuelle Zeit.';
        }

        $newSlot = Slot::find($newSlotId);
        if (!$newSlot) {
            return 'Diesen Termin gibt es nicht (mehr).';
        }
        if (Slot::isPast($newSlot)) {
            return 'Dieser Termin liegt bereits in der Vergangenheit.';
        }

        $error = Database::transaction(
            static function (PDO $pdo) use ($booking, $newSlotId, $actor): ?string {
                $update = $pdo->prepare("UPDATE slots SET status = 'gebucht' WHERE id = ? AND status = 'frei'");
                $update->execute([$newSlotId]);

                if ($update->rowCount() === 0) {
                    return 'Diese Zeit wurde gerade eben vergeben. Bitte wähle eine andere.';
                }

                // Alten Termin freigeben und die Buchung umhängen
                $pdo->prepare("UPDATE slots SET status = 'frei' WHERE id = ? AND status = 'gebucht'")
                    ->execute([$booking['slot_id']]);
                $pdo->prepare('UPDATE bookings SET slot_id = ? WHERE id = ?')
                    ->execute([$newSlotId, $booking['id']]);

                self::log(
                    $pdo,
                    (int) $booking['id'],
                    'verschoben',
                    (int) $booking['slot_id'],
                    $newSlotId,
                    $actor
                );

                return null;
            }
        );

        if ($error === null) {
            // $booking hält noch die alte Zeit – genau die braucht die Meldung
            Notifier::bookingChanged('verschoben', $booking, $actor, $newSlot['starts_at']);
        }

        return $error;
    }

    /** Schreibt einen Verlaufseintrag. Läuft immer innerhalb der aufrufenden Transaktion. */
    private static function log(
        PDO $pdo,
        int $bookingId,
        string $action,
        ?int $fromSlotId,
        ?int $toSlotId,
        string $actor
    ): void {
        $pdo->prepare(
            'INSERT INTO booking_log (booking_id, action, from_slot_id, to_slot_id, actor)
             VALUES (?, ?, ?, ?, ?)'
        )->execute([$bookingId, $action, $fromSlotId, $toSlotId, $actor]);
    }
}
