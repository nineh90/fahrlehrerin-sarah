<?php
declare(strict_types=1);

/**
 * Buchen, Stornieren und Verschieben durch die Fahrschüler:innen.
 * Jede Methode setzt Login voraus und prüft, dass die Buchung wirklich
 * der angemeldeten Person gehört.
 */
final class BookingController
{
    /** Übersicht der eigenen Termine. */
    public function index(): void
    {
        StudentAuth::require();

        $bookings = Booking::forStudent((int) StudentAuth::id());
        $now      = new DateTimeImmutable('now');

        $upcoming = [];
        $past     = [];
        foreach ($bookings as $booking) {
            if ($booking['status'] === 'gebucht' && dt($booking['starts_at']) >= $now) {
                $upcoming[] = $booking;
            } else {
                $past[] = $booking;
            }
        }
        // Vergangenes/Storniertes: das Jüngste zuerst
        $past = array_reverse($past);

        render('booking/index', [
            'title'    => 'Meine Termine',
            'student'      => StudentAuth::user(),
            'showNdCredit' => false,
            'upcoming' => $upcoming,
            'past'     => $past,
        ]);
    }

    /** Einen freien Termin buchen. */
    public function store(string $id): void
    {
        StudentAuth::require();
        verify_csrf();

        $error = Booking::book((int) $id, (int) StudentAuth::id());

        if ($error !== null) {
            set_flash('error', $error);
            redirect('/termine');
        }

        set_flash('success', 'Eingetragen. Du findest die Stunde unter „Meine Stunden".');
        redirect('/meine-termine');
    }

    /** Eigenen Termin stornieren. */
    public function cancel(string $id): void
    {
        StudentAuth::require();
        verify_csrf();

        $booking = $this->ownBookingOrFail((int) $id);
        $error   = Booking::cancel((int) $booking['id']);

        if ($error !== null) {
            set_flash('error', $error);
        } else {
            set_flash('success', 'Stunde abgesagt. Die Zeit ist wieder frei.');
        }

        redirect('/meine-termine');
    }

    /** Auswahlseite: auf welchen freien Termin soll verschoben werden? */
    public function showReschedule(string $id): void
    {
        StudentAuth::require();

        $booking = $this->ownBookingOrFail((int) $id);

        if (!Booking::isEditable($booking)) {
            set_flash('error', Booking::lockReason($booking));
            redirect('/meine-termine');
        }

        render('booking/reschedule', [
            'title'   => 'Termin verschieben',
            'booking'      => $booking,
            'options'      => Slot::upcomingFree(),
            'showNdCredit' => false,
        ]);
    }

    /** Verschiebung durchführen. */
    public function reschedule(string $id): void
    {
        StudentAuth::require();
        verify_csrf();

        $booking   = $this->ownBookingOrFail((int) $id);
        $newSlotId = (int) ($_POST['slot_id'] ?? 0);

        if ($newSlotId <= 0) {
            set_flash('error', 'Bitte wähle eine neue Zeit aus.');
            redirect('/buchung/' . $booking['id'] . '/verschieben');
        }

        $error = Booking::reschedule((int) $booking['id'], $newSlotId);

        if ($error !== null) {
            set_flash('error', $error);
            redirect('/buchung/' . $booking['id'] . '/verschieben');
        }

        set_flash('success', 'Stunde verschoben.');
        redirect('/meine-termine');
    }

    /**
     * Lädt eine Buchung und stellt sicher, dass sie der angemeldeten Person
     * gehört – sonst 404, damit fremde IDs nichts verraten.
     */
    private function ownBookingOrFail(int $id): array
    {
        $booking = Booking::find($id);

        if (!$booking || (int) $booking['student_id'] !== StudentAuth::id()) {
            http_response_code(404);
            render('errors/404', ['title' => 'Buchung nicht gefunden']);
            exit;
        }

        return $booking;
    }
}
