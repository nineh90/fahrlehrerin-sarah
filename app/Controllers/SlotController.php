<?php
declare(strict_types=1);

/** Öffentliche Wochenansicht der Termine. */
final class SlotController
{
    public function index(): void
    {
        $offset = $_GET['woche'] ?? 0;
        $monday = week_from_offset($offset);
        $slots  = Slot::forWeekPublic($monday, StudentAuth::id());

        render('slots/index', [
            'title'        => 'Meine freien Zeiten',
            'monday'       => $monday,
            'weekOffset'   => (int) $offset,
            'slotsByDay'   => group_slots_by_day($slots, $monday),
            'isLoggedIn'   => StudentAuth::check(),
            // Wer gerade eine Fahrstunde einträgt, soll nicht abgelenkt werden
            'showNdCredit' => false,
        ]);
    }
}
