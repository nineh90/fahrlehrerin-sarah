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
        $now    = new DateTimeImmutable('now');

        // Ist in der gezeigten Woche überhaupt noch etwas frei?
        $hasFree = false;
        foreach ($slots as $slot) {
            if ($slot['status'] === 'frei' && dt($slot['starts_at']) >= $now) {
                $hasFree = true;
                break;
            }
        }

        // Wenn nicht: nachsehen, wo es weitergeht. Sonst endet die Suche für
        // Ratsuchende an der ersten leeren Woche, obwohl weiter vorn alles
        // offen ist.
        $nextFree = $hasFree ? null : Slot::nextFreeFrom(max($now, $monday));

        render('slots/index', [
            'title'        => 'Meine freien Zeiten',
            'monday'       => $monday,
            'weekOffset'   => (int) $offset,
            'slotsByDay'   => group_slots_by_day($slots, $monday),
            'isLoggedIn'   => StudentAuth::check(),
            'nextFree'     => $nextFree,
            'nextFreeWeek' => $nextFree !== null ? week_offset_of(dt($nextFree['starts_at'])) : null,
        ]);
    }
}
