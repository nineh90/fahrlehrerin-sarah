<?php
declare(strict_types=1);

/**
 * Benachrichtigungen für Sarah – der Posteingang der Schaltzentrale.
 *
 * Geschrieben wird ausschließlich über Notifier, nie direkt aus Controllern.
 * Der Text ist zum Zeitpunkt des Ereignisses fertig formuliert und wird danach
 * nicht mehr angefasst: eine Meldung von gestern soll auch dann noch stimmen,
 * wenn der Termin inzwischen verschoben oder gelöscht wurde.
 */
final class Notification
{
    /** Schlüssel = DB-Wert, Wert = Anzeigetext. Anzeige IMMER über diese Map. */
    public const EVENTS = [
        'gebucht'    => 'Neu eingetragen',
        'verschoben' => 'Verschoben',
        'storniert'  => 'Abgesagt',
    ];

    /**
     * Legt eine Meldung an und gibt ihre ID zurück.
     * $data: event, actor, booking_id, student_name, starts_at, from_starts_at,
     *        title, body, channels, read_at
     */
    public static function create(array $data): int
    {
        $pdo = Database::connection();
        $pdo->prepare(
            'INSERT INTO notifications
                (event, actor, booking_id, student_name, starts_at, from_starts_at,
                 title, body, channels, read_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        )->execute([
            $data['event'],
            $data['actor'] ?? 'schueler',
            $data['booking_id'] ?? null,
            $data['student_name'],
            $data['starts_at'] ?? null,
            $data['from_starts_at'] ?? null,
            $data['title'],
            $data['body'],
            $data['channels'] ?? null,
            $data['read_at'] ?? null,
        ]);

        return (int) $pdo->lastInsertId();
    }

    /** Die jüngsten Meldungen, optional nur die ungelesenen. */
    public static function recent(int $limit = 20, bool $onlyUnread = false): array
    {
        $sql = 'SELECT * FROM notifications';
        if ($onlyUnread) {
            $sql .= ' WHERE read_at IS NULL';
        }
        $sql .= ' ORDER BY id DESC LIMIT ?';

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([$limit]);

        return $stmt->fetchAll();
    }

    /** Anzahl ungelesener Meldungen – für das Zählerchen in der Navigation. */
    public static function unreadCount(): int
    {
        return (int) Database::connection()
            ->query('SELECT COUNT(*) FROM notifications WHERE read_at IS NULL')
            ->fetchColumn();
    }

    /** Markiert eine einzelne Meldung als gelesen. */
    public static function markRead(int $id): void
    {
        Database::connection()
            ->prepare('UPDATE notifications SET read_at = CURRENT_TIMESTAMP WHERE id = ? AND read_at IS NULL')
            ->execute([$id]);
    }

    /** Markiert alles als gelesen. Gibt zurück, wie viele es waren. */
    public static function markAllRead(): int
    {
        $stmt = Database::connection()
            ->prepare('UPDATE notifications SET read_at = CURRENT_TIMESTAMP WHERE read_at IS NULL');
        $stmt->execute();

        return $stmt->rowCount();
    }

    /** Anzeigetext für das Ereignis. */
    public static function label(array $notification): string
    {
        return self::EVENTS[$notification['event']] ?? $notification['event'];
    }
}
