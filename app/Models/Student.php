<?php
declare(strict_types=1);

/**
 * Fahrschüler:innen. Werden ausschließlich von Sarah im Admin angelegt.
 * Sämtlicher SQL-Zugriff auf students läuft über diese Klasse.
 */
final class Student
{
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
            'INSERT INTO students (name, email, phone, pin_hash, note) VALUES (?, ?, ?, ?, ?)'
        )->execute([
            $data['name'],
            mb_strtolower(trim($data['email'])),
            $data['phone'] ?: null,
            password_hash($pin, PASSWORD_DEFAULT),
            $data['note'] ?: null,
        ]);

        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        Database::connection()->prepare(
            'UPDATE students SET name = ?, email = ?, phone = ?, note = ?, active = ? WHERE id = ?'
        )->execute([
            $data['name'],
            mb_strtolower(trim($data['email'])),
            $data['phone'] ?: null,
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
            ->prepare('UPDATE students SET pin_hash = ? WHERE id = ?')
            ->execute([password_hash($pin, PASSWORD_DEFAULT), $id]);

        return $pin;
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
