<?php
declare(strict_types=1);

/** Anmeldung für Sarahs Backend. */
final class AdminAuthController
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            redirect('/admin');
        }

        render('admin/login', ['title' => 'Anmelden'], 'admin/auth-layout');
    }

    public function login(): void
    {
        verify_csrf();

        $email    = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if (Auth::attempt($email, $password)) {
            redirect('/admin');
        }

        set_flash('error', 'E-Mail oder Passwort stimmen nicht.');
        redirect('/admin/login');
    }

    public function logout(): void
    {
        verify_csrf();
        Auth::logout();
        set_flash('success', 'Du bist abgemeldet.');
        redirect('/admin/login');
    }
}
