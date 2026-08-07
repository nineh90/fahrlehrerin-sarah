<?php
declare(strict_types=1);

/**
 * Session-basierte Admin-Authentifizierung (Sarah).
 * Der Schüler-Login läuft getrennt über StudentAuth – beide können
 * gleichzeitig aktiv sein, ohne sich in die Quere zu kommen.
 */
final class Auth
{
    /** Mindestlänge für Sarahs Passwort. Kurz genug zum Merken, lang genug. */
    public const MIN_PASSWORD_LENGTH = 10;

    /** Route, die auch bei erzwungenem Passwortwechsel erreichbar bleiben muss. */
    private const PASSWORD_PATH = '/admin/passwort';

    public static function attempt(string $email, string $password): bool
    {
        $admin = self::findByEmail($email);

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            return false;
        }

        ensure_session();
        session_regenerate_id(true);
        $_SESSION['admin_id']    = (int) $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        return true;
    }

    public static function check(): bool
    {
        ensure_session();
        return !empty($_SESSION['admin_id']);
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        return [
            'id'    => $_SESSION['admin_id'],
            'email' => $_SESSION['admin_email'] ?? '',
        ];
    }

    /**
     * Erzwingt Login; leitet sonst zur Login-Seite um.
     *
     * Steht das Einmalpasswort-Kennzeichen, geht es zusätzlich zwangsweise auf
     * die Passwortseite – ausgenommen die Seite selbst, sonst dreht sich die
     * Weiterleitung im Kreis.
     */
    public static function require(): void
    {
        if (!self::check()) {
            set_flash('error', 'Bitte zuerst anmelden.');
            redirect('/admin/login');
        }

        if (self::mustChangePassword() && current_path() !== self::PASSWORD_PATH) {
            set_flash('info', 'Dein Zugang läuft noch mit dem Startpasswort. '
                . 'Bitte vergib jetzt dein eigenes.');
            redirect(self::PASSWORD_PATH);
        }
    }

    /**
     * Läuft der Zugang noch mit dem Passwort aus der .env – UND soll das
     * erzwungen werden?
     *
     * Zwei Bedingungen mit Absicht: Die Datenbankspalte hält fest, DASS das
     * Passwort aus der .env stammt. Der Schalter `ADMIN_FORCE_PASSWORD_CHANGE`
     * entscheidet, ob daraus eine Sperre wird. Im Testbetrieb steht er auf
     * false – sonst vergibt die erste Person, die sich anmeldet, ein eigenes
     * Passwort und sperrt damit alle anderen aus. Vor dem Livegang auf true,
     * dann greift die Sperre sofort, ohne dass an der Datenbank etwas passieren
     * muss.
     */
    public static function mustChangePassword(): bool
    {
        if (!config('admin.force_password_change')) {
            return false;
        }
        $admin = self::current();

        return $admin !== null && (int) $admin['must_change_password'] === 1;
    }

    /**
     * Setzt ein neues Passwort. Gibt null bei Erfolg zurück, sonst die
     * Fehlermeldung – dasselbe Muster wie im Booking-Model.
     */
    public static function changePassword(string $current, string $new, string $repeat): ?string
    {
        $admin = self::current();
        if ($admin === null) {
            return 'Du bist nicht angemeldet.';
        }
        if (!password_verify($current, $admin['password_hash'])) {
            return 'Das aktuelle Passwort stimmt nicht.';
        }
        if (mb_strlen($new) < self::MIN_PASSWORD_LENGTH) {
            return sprintf('Das neue Passwort muss mindestens %d Zeichen haben.', self::MIN_PASSWORD_LENGTH);
        }
        if ($new !== $repeat) {
            return 'Die beiden neuen Passwörter stimmen nicht überein.';
        }
        if ($new === $current) {
            return 'Das neue Passwort ist dasselbe wie das alte.';
        }

        Database::connection()->prepare(
            'UPDATE admins
                SET password_hash = ?, must_change_password = 0,
                    password_changed_at = CURRENT_TIMESTAMP
              WHERE id = ?'
        )->execute([password_hash($new, PASSWORD_DEFAULT), $admin['id']]);

        // Nach einem Passwortwechsel eine frische Session-ID: Wer die alte
        // mitgelesen hat, kommt damit nicht weiter.
        session_regenerate_id(true);

        return null;
    }

    public static function logout(): void
    {
        ensure_session();
        unset($_SESSION['admin_id'], $_SESSION['admin_email']);
    }

    // -----------------------------------------------------------------------

    /** Der angemeldete Datensatz aus der Datenbank (nicht aus der Session). */
    private static function current(): ?array
    {
        if (!self::check()) {
            return null;
        }
        $stmt = Database::connection()->prepare('SELECT * FROM admins WHERE id = ? LIMIT 1');
        $stmt->execute([(int) $_SESSION['admin_id']]);

        return $stmt->fetch() ?: null;
    }

    private static function findByEmail(string $email): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);

        return $stmt->fetch() ?: null;
    }
}
