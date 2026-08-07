<?php
declare(strict_types=1);

/**
 * Sarahs eigener Zugang: Passwort ändern.
 *
 * Vor dem Livegang bekommt sie ein Einmalpasswort aus der .env. Solange das
 * gilt (`admins.must_change_password = 1`), lässt `Auth::require()` sie nur
 * auf diese Seite – erst nach dem Wechsel ist der Rest wieder erreichbar.
 */
final class AdminAccountController
{
    public function edit(): void
    {
        Auth::require();

        render('admin/passwort', [
            'title'   => 'Mein Zugang',
            'erzwingt' => Auth::mustChangePassword(),
        ], 'admin/layout');
    }

    public function update(): void
    {
        Auth::require();
        verify_csrf();

        $fehler = Auth::changePassword(
            (string) ($_POST['current'] ?? ''),
            (string) ($_POST['new'] ?? ''),
            (string) ($_POST['repeat'] ?? '')
        );

        if ($fehler !== null) {
            set_flash('error', $fehler);
            redirect('/admin/passwort');
        }

        set_flash('success', 'Neues Passwort gespeichert. Beim nächsten Anmelden gilt es.');
        redirect('/admin');
    }
}
