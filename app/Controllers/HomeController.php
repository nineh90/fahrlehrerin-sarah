<?php
declare(strict_types=1);

/** Startseite. */
final class HomeController
{
    public function index(): void
    {
        /* Bis zum 17.08.2026 holte die Startseite hier die nächsten sechs
           freien Termine als Appetithappen (`Slot::upcomingFree(6)`). Die
           Sektion ist auf Sarahs Wunsch entfallen (SAR-27) – der Wochenplan
           ist nur noch über „Termine" im Header erreichbar.

           Damit stellt die Startseite keine Datenbankabfrage mehr. Wer die
           Vorschau zurückholt, braucht den Aufruf und `'freeSlots' => …`
           wieder; `Slot::upcomingFree()` gibt es unverändert, der
           BookingController arbeitet damit. */
        render('home', [
            'title'           => 'Fahrlehrerin in ' . config('contact.city'),
            'metaDescription' => 'Sarah ist Fahrlehrerin für die Klassen B und BE in '
                . implode(', ', config('contact.area')) . ' – mit Erfahrung in der Ausbildung '
                . 'von Menschen mit Prothese, Lenkhilfe oder Handbedienung.',
        ]);
    }
}
