<?php
declare(strict_types=1);

/**
 * Session-basierte Admin-Authentifizierung (Sarah).
 * Der Schüler-Login läuft getrennt über StudentAuth – beide können
 * gleichzeitig aktiv sein, ohne sich in die Quere zu kommen.
 */
final class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT id, email, password_hash FROM admins WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

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

    /** Erzwingt Login; leitet sonst zur Login-Seite um. */
    public static function require(): void
    {
        if (!self::check()) {
            set_flash('error', 'Bitte zuerst anmelden.');
            redirect('/admin/login');
        }
    }

    public static function logout(): void
    {
        ensure_session();
        unset($_SESSION['admin_id'], $_SESSION['admin_email']);
    }
}
