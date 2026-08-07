<?php
declare(strict_types=1);

/**
 * Schlanker PDO-Singleton für SQLite.
 *
 * SQLite genügt für den geplanten Umfang (Info-Website + Terminbuchung) und
 * braucht keinen Datenbankserver. Ein Wechsel auf MySQL/MariaDB betrifft später
 * nur diese Datei plus ein zweites Schema – die Models arbeiten mit reinem
 * SQL über Prepared Statements.
 */
final class Database
{
    private static ?PDO $instance = null;

    private const OPTIONS = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public static function connection(): PDO
    {
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        $path = (string) config('db.sqlite_path');
        $dir  = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        self::$instance = new PDO('sqlite:' . $path, null, null, self::OPTIONS);
        // Fremdschlüssel (ON DELETE CASCADE) in SQLite aktiv schalten
        self::$instance->exec('PRAGMA foreign_keys = ON');
        // Weniger Sperrkonflikte bei parallelen Zugriffen
        self::$instance->exec('PRAGMA journal_mode = WAL');
        self::$instance->exec('PRAGMA busy_timeout = 5000');

        return self::$instance;
    }

    /** Führt einen Callback in einer Transaktion aus und gibt dessen Rückgabewert zurück. */
    public static function transaction(callable $callback): mixed
    {
        $pdo = self::connection();
        $pdo->beginTransaction();
        try {
            $result = $callback($pdo);
            $pdo->commit();
            return $result;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
