<?php
declare(strict_types=1);

/**
 * Schüler-Login "light": E-Mail + 6-stellige PIN.
 *
 * Bewusst ohne Selbstregistrierung – Sarah legt ihre Schüler:innen im Admin an
 * und gibt die PIN persönlich weiter. Das hält die Hürde niedrig (kein Passwort
 * merken, keine Bestätigungsmail) und stellt trotzdem sicher, dass jede Person
 * nur ihre eigenen Termine sieht und ändert.
 *
 * Die PIN wird wie ein Passwort gehasht gespeichert (password_hash), nie im Klartext.
 */
final class StudentAuth
{
    /** Nach so vielen Fehlversuchen wird der Login kurz gesperrt. */
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 300;

    public static function attempt(string $email, string $pin): bool
    {
        if (self::isLockedOut()) {
            return false;
        }

        $student = Student::findByEmail($email);

        if (!$student || (int) $student['active'] !== 1 || !password_verify($pin, $student['pin_hash'])) {
            self::noteFailure();
            return false;
        }

        ensure_session();
        session_regenerate_id(true);
        unset($_SESSION['_login_attempts'], $_SESSION['_login_locked_until']);
        $_SESSION['student_id']   = (int) $student['id'];
        $_SESSION['student_name'] = $student['name'];
        return true;
    }

    public static function check(): bool
    {
        ensure_session();
        return !empty($_SESSION['student_id']);
    }

    public static function id(): ?int
    {
        return self::check() ? (int) $_SESSION['student_id'] : null;
    }

    /** Der eingeloggte Schüler-Datensatz (frisch aus der DB) oder null. */
    public static function user(): ?array
    {
        $id = self::id();
        return $id === null ? null : Student::find($id);
    }

    /** Anzeigename ohne DB-Zugriff (für Navigation). */
    public static function name(): string
    {
        ensure_session();
        return (string) ($_SESSION['student_name'] ?? '');
    }

    /** Erzwingt Login; leitet sonst zur Login-Seite um. */
    public static function require(): void
    {
        if (!self::check()) {
            set_flash('info', 'Bitte melde dich an, um dich einzutragen.');
            redirect('/login');
        }
    }

    public static function logout(): void
    {
        ensure_session();
        unset($_SESSION['student_id'], $_SESSION['student_name']);
    }

    // -----------------------------------------------------------------------
    // Einfacher Brute-Force-Schutz (pro Session)
    // -----------------------------------------------------------------------

    public static function isLockedOut(): bool
    {
        ensure_session();
        $until = (int) ($_SESSION['_login_locked_until'] ?? 0);
        if ($until > time()) {
            return true;
        }
        if ($until !== 0) {
            unset($_SESSION['_login_locked_until'], $_SESSION['_login_attempts']);
        }
        return false;
    }

    private static function noteFailure(): void
    {
        ensure_session();
        $attempts = (int) ($_SESSION['_login_attempts'] ?? 0) + 1;
        $_SESSION['_login_attempts'] = $attempts;
        if ($attempts >= self::MAX_ATTEMPTS) {
            $_SESSION['_login_locked_until'] = time() + self::LOCKOUT_SECONDS;
        }
    }

    /** Erzeugt eine neue 6-stellige PIN (Klartext – nur einmalig anzeigen!). */
    public static function generatePin(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
