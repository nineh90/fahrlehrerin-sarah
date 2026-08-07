<?php
declare(strict_types=1);

/** Startseite des Backends: Zahlen und die nächsten Termine auf einen Blick. */
final class AdminDashboardController
{
    public function index(): void
    {
        Auth::require();

        render('admin/dashboard', [
            'title'    => 'Übersicht',
            'stats'    => Slot::stats(),
            'upcoming' => Slot::upcomingBooked(8),
        ], 'admin/layout');
    }
}
