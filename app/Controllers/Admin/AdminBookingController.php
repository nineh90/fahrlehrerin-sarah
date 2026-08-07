<?php
declare(strict_types=1);

/** Buchungsübersicht für Sarah. */
final class AdminBookingController
{
    public function index(): void
    {
        Auth::require();

        $status = (string) ($_GET['status'] ?? '');
        $status = isset(Booking::STATUSES[$status]) ? $status : null;

        render('admin/buchungen/index', [
            'title'    => 'Buchungen',
            'bookings' => Booking::all($status),
            'status'   => $status,
        ], 'admin/layout');
    }

    /**
     * Storniert im Namen einer Schülerin/eines Schülers.
     * Sarah darf das auch nach Ablauf der Frist – sie muss kurzfristig
     * absagen können, wenn etwa das Fahrschulauto ausfällt.
     */
    public function cancel(string $id): void
    {
        Auth::require();
        verify_csrf();

        $error = Booking::cancel((int) $id, 'admin');

        if ($error !== null) {
            set_flash('error', $error);
        } else {
            set_flash('success', 'Buchung storniert – der Termin ist wieder frei.');
        }

        redirect('/admin/buchungen');
    }
}
