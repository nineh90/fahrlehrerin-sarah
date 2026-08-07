<?php
declare(strict_types=1);

/**
 * Startseite des Backends.
 *
 * Reihenfolge nach Dringlichkeit statt nach Datenmodell: erst was sich seit dem
 * letzten Besuch getan hat, dann der heutige Tag, dann die Zahlen und der
 * Ausblick. Sarah macht das hier zwischen zwei Fahrstunden auf – oben steht,
 * was sie sofort wissen muss.
 */
final class AdminDashboardController
{
    public function index(): void
    {
        Auth::require();

        $now = new DateTimeImmutable('now');

        render('admin/dashboard', [
            'title'    => 'Übersicht',
            'now'      => $now,
            'greeting' => $this->greeting($now),
            'stats'    => Slot::stats(),
            'today'    => Slot::forDay($now),
            'upcoming' => Slot::upcomingBooked(6),
            'unread'   => Notification::recent(5, true),
            'feed'     => Notification::recent(6),
        ], 'admin/layout');
    }

    /** Tageszeitliche Begrüßung – dieselbe Ansprache wie im Rest der Seite. */
    private function greeting(DateTimeInterface $now): string
    {
        $hour = (int) $now->format('G');

        return match (true) {
            $hour < 5  => 'Noch wach',
            $hour < 11 => 'Guten Morgen',
            $hour < 18 => 'Hallo',
            default    => 'Guten Abend',
        };
    }
}
