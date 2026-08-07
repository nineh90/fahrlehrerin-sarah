<?php
declare(strict_types=1);

/** Anmeldung der Fahrschüler:innen (E-Mail + PIN). */
final class StudentAuthController
{
    public function showLogin(): void
    {
        if (StudentAuth::check()) {
            redirect('/meine-termine');
        }

        render('student/login', [
            'title'        => 'Anmelden',
            'values'       => [],
            'showNdCredit' => false,
        ]);
    }

    public function login(): void
    {
        verify_csrf();

        $email = trim((string) ($_POST['email'] ?? ''));
        $pin   = trim((string) ($_POST['pin'] ?? ''));

        if (StudentAuth::isLockedOut()) {
            set_flash('error', 'Zu viele Fehlversuche. Bitte warte ein paar Minuten.');
            redirect('/login');
        }

        if (StudentAuth::attempt($email, $pin)) {
            set_flash('success', 'Willkommen zurück, ' . StudentAuth::name() . '!');
            redirect('/meine-termine');
        }

        set_flash('error', 'E-Mail oder PIN stimmen nicht. Bitte noch einmal versuchen.');
        render('student/login', [
            'title'        => 'Anmelden',
            'values'       => ['email' => $email],
            'showNdCredit' => false,
        ]);
    }

    public function logout(): void
    {
        verify_csrf();
        StudentAuth::logout();
        set_flash('success', 'Du bist abgemeldet.');
        redirect('/');
    }
}
