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
            /* VOLLER TITEL statt „… · Fahrlehrerin Sarah" (SAR-10). Der Anhang
               kostet 21 Zeichen, und Google schneidet den Titel bei rund 60 ab
               – auf der wichtigsten Seite der Seite ist das der Platz, an dem
               sonst „Handicap" stünde. Die Reihenfolge ist die Rangfolge:
               ihr Name, ihr Alleinstellungsmerkmal, ihr Ort. */
            'metaTitle'       => 'Fahrlehrerin Sarah – Führerschein mit Handicap, '
                . config('contact.city'),
            /* Die Aufzählung folgt der Karte „Ausbildung mit Handicap" auf der
               Startseite (SAR-43) – wer nach „Führerschein Kleinwuchs" sucht, soll
               das schon in der Google-Vorschau finden und nicht erst auf der Seite.
               „Prothese" stand hier bis zum 17.08.2026 und ist mit dem Thema
               entfallen; die Vorschau darf nichts anbieten, was die Seite nicht hat. */
            /* AUF LÄNGE GESCHRIEBEN (SAR-10). Google schneidet die Beschreibung
               bei rund 158 Zeichen ab. Die alte Fassung hatte 234 und brach
               mitten in „Kleinwuchs oder eingeschränkter" ab – die Aufzählung
               der Technik, wegen der sie so lang war, hat nie jemand gesehen.
               Kurz genug heißt: Das Wichtigste steht vorn UND wird gelesen. */
            'metaDescription' => 'Fahrlehrerin für Klasse B und BE in '
                . area_list() . ' – mit Erfahrung in der Ausbildung von '
                . 'Menschen mit Handicap.',
            /* Sarah als Person plus die Website selbst. Beides nur hier: Die
               Startseite ist die Seite, die für „wer ist das" steht. */
            'jsonLd'          => [Seo::person(), Seo::website()],
        ]);
    }
}
