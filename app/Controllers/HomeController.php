<?php
declare(strict_types=1);

/** Startseite. */
final class HomeController
{
    public function index(): void
    {
        // Die nächsten freien Termine als Appetithappen auf der Startseite
        $freeSlots = array_slice(Slot::upcomingFree(6), 0, 6);

        render('home', [
            'title'           => 'Fahrlehrerin in ' . config('contact.city'),
            'metaDescription' => 'Sarah ist Fahrlehrerin für die Klassen B und BE in '
                . implode(', ', config('contact.area')) . ' – mit Erfahrung in der Ausbildung '
                . 'von Menschen mit Prothese, Lenkhilfe oder Handbedienung.',
            'freeSlots'       => $freeSlots,
        ]);
    }
}
