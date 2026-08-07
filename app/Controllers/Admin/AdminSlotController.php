<?php
declare(strict_types=1);

/**
 * Terminverwaltung für Sarah.
 *
 * Kernstück ist die Serien-Anlage (createSeries/storeSeries): einmal
 * Wochentage, Zeitfenster und Zeitraum angeben – daraus entstehen alle
 * Termine auf einen Schlag. Das ist die Funktion, die Sarah wöchentlich nutzt.
 */
final class AdminSlotController
{
    /** Wochenkalender aller Termine. */
    public function index(): void
    {
        Auth::require();

        $offset = $_GET['woche'] ?? 0;
        $monday = week_from_offset($offset);

        render('admin/slots/index', [
            'title'      => 'Termine',
            'monday'     => $monday,
            'weekOffset' => (int) $offset,
            'slotsByDay' => group_slots_by_day(Slot::forWeek($monday), $monday),
            // Für das Zuweisen direkt aus dem Kalender
            'students'   => Student::activeOptions(),
        ], 'admin/layout');
    }

    // -----------------------------------------------------------------------
    // Einzelner Termin
    // -----------------------------------------------------------------------

    public function create(): void
    {
        Auth::require();

        render('admin/slots/form', [
            'title'    => 'Termin anlegen',
            'students' => Student::activeOptions(),
            'values'   => [
                'date'         => (new DateTimeImmutable('tomorrow'))->format('Y-m-d'),
                'time'         => '14:00',
                'duration_min' => (string) config('booking.slot_duration_min'),
                'type'         => 'fahrstunde',
                'location'     => 'Treffpunkt Fahrschule',
                'student_id'   => '',
            ],
        ], 'admin/layout');
    }

    public function store(): void
    {
        Auth::require();
        verify_csrf();

        $values = [
            'date'            => trim((string) ($_POST['date'] ?? '')),
            'time'            => trim((string) ($_POST['time'] ?? '')),
            'duration_min'    => (string) ($_POST['duration_min'] ?? ''),
            'type'            => (string) ($_POST['type'] ?? 'fahrstunde'),
            'sonderfahrt_art' => (string) ($_POST['sonderfahrt_art'] ?? ''),
            'location'        => trim((string) ($_POST['location'] ?? '')),
            'note'            => trim((string) ($_POST['note'] ?? '')),
            // Leer = der Termin steht allen offen
            'student_id'      => (string) ($_POST['student_id'] ?? ''),
        ];

        $start = $this->parseDateTime($values['date'], $values['time']);

        if (!$start || !isset(Slot::TYPES[$values['type']])) {
            $this->backToForm('Bitte Datum, Uhrzeit und Art des Termins korrekt angeben.', $values);
        }
        if ($values['sonderfahrt_art'] !== '' && !isset(Slot::SONDERFAHRT_ARTEN[$values['sonderfahrt_art']])) {
            $this->backToForm('Bitte eine gültige Art der Sonderfahrt wählen.', $values);
        }

        $id = Slot::create([
            'starts_at'       => $start->format('Y-m-d H:i:s'),
            'duration_min'    => max(15, (int) $values['duration_min']),
            'type'            => $values['type'],
            'sonderfahrt_art' => $values['sonderfahrt_art'],
            'location'        => $values['location'],
            'note'            => $values['note'],
        ]);

        if ($id === null) {
            $this->backToForm('Zu dieser Uhrzeit gibt es bereits einen Termin.', $values);
        }

        $meldung = 'Termin am ' . format_datetime($start) . ' angelegt.';
        $fehler  = null;

        // Direkt zuweisen? Dann in einem Rutsch buchen. Schlägt das fehl, bleibt
        // der Termin trotzdem bestehen – er ist dann eben frei für alle.
        if ($values['student_id'] !== '') {
            $fehler = Booking::book($id, (int) $values['student_id'], 'admin');
            $person = Student::find((int) $values['student_id']);

            $meldung .= $fehler === null
                ? ' ' . ($person['name'] ?? 'Die Person') . ' ist eingetragen.'
                : ' Zuweisen hat nicht geklappt: ' . $fehler . ' Der Termin ist frei buchbar.';
        }

        set_flash($fehler === null ? 'success' : 'info', $meldung);
        redirect('/admin/termine?woche=' . $this->weekOffsetOf($start));
    }

    /** Weist einen bestehenden Termin direkt zu (aus dem Kalender heraus). */
    public function assign(string $id): void
    {
        Auth::require();
        verify_csrf();

        $studentId = (int) ($_POST['student_id'] ?? 0);
        $slot      = Slot::find((int) $id);

        if (!$slot) {
            set_flash('error', 'Diesen Termin gibt es nicht (mehr).');
            redirect($this->backToWeek());
        }
        if ($studentId === 0) {
            set_flash('error', 'Bitte auswählen, wer den Termin bekommen soll.');
            redirect($this->backToWeek());
        }

        $fehler = Booking::book((int) $id, $studentId, 'admin');

        if ($fehler !== null) {
            set_flash('error', $fehler);
        } else {
            $person = Student::find($studentId);
            set_flash('success', sprintf(
                '%s ist für %s eingetragen.',
                $person['name'] ?? 'Die Person',
                format_datetime(dt($slot['starts_at']))
            ));
        }

        redirect($this->backToWeek());
    }

    // -----------------------------------------------------------------------
    // Serien-Anlage
    // -----------------------------------------------------------------------

    public function createSeries(): void
    {
        Auth::require();

        $monday = week_start(new DateTimeImmutable('now'))->modify('+1 week');

        render('admin/slots/series', [
            'title'  => 'Termine für mehrere Wochen freigeben',
            'values' => [
                'from'         => $monday->format('Y-m-d'),
                'to'           => $monday->modify('+13 days')->format('Y-m-d'),
                'weekdays'     => ['1', '2', '3', '4', '5'],
                'time_from'    => '14:00',
                'time_to'      => '18:00',
                'interval'        => '60',
                'duration_min'    => (string) config('booking.slot_duration_min'),
                'type'            => 'fahrstunde',
                'sonderfahrt_art' => '',
                'location'        => 'Treffpunkt Fahrschule',
            ],
        ], 'admin/layout');
    }

    public function storeSeries(): void
    {
        Auth::require();
        verify_csrf();

        $values = [
            'from'         => trim((string) ($_POST['from'] ?? '')),
            'to'           => trim((string) ($_POST['to'] ?? '')),
            'weekdays'     => array_map('strval', (array) ($_POST['weekdays'] ?? [])),
            'time_from'    => trim((string) ($_POST['time_from'] ?? '')),
            'time_to'      => trim((string) ($_POST['time_to'] ?? '')),
            'interval'     => (string) ($_POST['interval'] ?? '60'),
            'duration_min'    => (string) ($_POST['duration_min'] ?? '45'),
            'type'            => (string) ($_POST['type'] ?? 'fahrstunde'),
            'sonderfahrt_art' => (string) ($_POST['sonderfahrt_art'] ?? ''),
            'location'        => trim((string) ($_POST['location'] ?? '')),
        ];

        $error = $this->validateSeries($values);
        if ($error !== null) {
            set_flash('error', $error);
            render('admin/slots/series', [
                'title'  => 'Termine für mehrere Wochen freigeben',
                'values' => $values,
            ], 'admin/layout');
            return;
        }

        [$created, $skipped] = $this->generateSeries($values);

        if ($created === 0) {
            set_flash('error', $skipped > 0
                ? 'Alle ' . $skipped . ' Termine gab es bereits – es wurde nichts angelegt.'
                : 'Für diese Auswahl ergaben sich keine Termine.');
            render('admin/slots/series', [
                'title'  => 'Termine für mehrere Wochen freigeben',
                'values' => $values,
            ], 'admin/layout');
            return;
        }

        $message = $created . ' Termine freigegeben.';
        if ($skipped > 0) {
            $message .= ' ' . $skipped . ' waren schon vorhanden und wurden übersprungen.';
        }
        set_flash('success', $message);
        redirect('/admin/termine?woche=' . $this->weekOffsetOf(new DateTimeImmutable($values['from'])));
    }

    /** Prüft die Eingaben der Serien-Anlage. Gibt null zurück, wenn alles passt. */
    private function validateSeries(array $v): ?string
    {
        if (!$v['weekdays']) {
            return 'Bitte mindestens einen Wochentag auswählen.';
        }
        if (!isset(Slot::TYPES[$v['type']])) {
            return 'Bitte eine gültige Art des Termins wählen.';
        }
        if ($v['sonderfahrt_art'] !== '' && !isset(Slot::SONDERFAHRT_ARTEN[$v['sonderfahrt_art']])) {
            return 'Bitte eine gültige Art der Sonderfahrt wählen.';
        }

        $from = $this->parseDateTime($v['from'], $v['time_from']);
        $to   = $this->parseDateTime($v['to'], $v['time_to']);
        if (!$from || !$to) {
            return 'Bitte Zeitraum und Uhrzeiten korrekt angeben.';
        }
        if ($this->parseDateTime($v['from'], '00:00') > $this->parseDateTime($v['to'], '00:00')) {
            return 'Das Enddatum liegt vor dem Startdatum.';
        }
        if ($v['time_from'] >= $v['time_to']) {
            return 'Die End-Uhrzeit muss nach der Start-Uhrzeit liegen.';
        }
        if ((int) $v['interval'] < 15) {
            return 'Der Abstand zwischen zwei Terminen muss mindestens 15 Minuten betragen.';
        }
        // Zeitraum begrenzen, damit niemand versehentlich Jahre freigibt
        $days = (int) $this->parseDateTime($v['from'], '00:00')
            ->diff($this->parseDateTime($v['to'], '00:00'))->days;
        if ($days > 120) {
            return 'Bitte höchstens vier Monate am Stück freigeben.';
        }

        return null;
    }

    /**
     * Erzeugt die Termine der Serie.
     * @return array{0:int,1:int} [angelegt, übersprungen]
     */
    private function generateSeries(array $v): array
    {
        $weekdays = array_map('intval', $v['weekdays']);
        $interval = max(15, (int) $v['interval']);
        $duration = max(15, (int) $v['duration_min']);
        $now      = new DateTimeImmutable('now');

        $day     = $this->parseDateTime($v['from'], '00:00');
        $lastDay = $this->parseDateTime($v['to'], '00:00');

        $created = 0;
        $skipped = 0;

        while ($day <= $lastDay) {
            if (in_array((int) $day->format('N'), $weekdays, true)) {
                $start = $this->parseDateTime($day->format('Y-m-d'), $v['time_from']);
                $end   = $this->parseDateTime($day->format('Y-m-d'), $v['time_to']);

                while ($start <= $end) {
                    // Vergangenes überspringen – dort kann ohnehin niemand buchen
                    if ($start > $now) {
                        $id = Slot::create([
                            'starts_at'       => $start->format('Y-m-d H:i:s'),
                            'duration_min'    => $duration,
                            'type'            => $v['type'],
                            'sonderfahrt_art' => $v['sonderfahrt_art'],
                            'location'        => $v['location'],
                            'note'            => '',
                        ]);
                        $id === null ? $skipped++ : $created++;
                    }
                    $start = $start->modify("+$interval minutes");
                }
            }
            $day = $day->modify('+1 day');
        }

        return [$created, $skipped];
    }

    // -----------------------------------------------------------------------
    // Einzelaktionen
    // -----------------------------------------------------------------------

    public function destroy(string $id): void
    {
        Auth::require();
        verify_csrf();

        if (Slot::delete((int) $id)) {
            set_flash('success', 'Termin gelöscht.');
        } else {
            set_flash('error', 'Gebuchte Termine lassen sich nicht löschen. '
                . 'Storniere zuerst die Buchung.');
        }

        redirect($this->backToWeek());
    }

    public function toggleBlocked(string $id): void
    {
        Auth::require();
        verify_csrf();

        if (Slot::toggleBlocked((int) $id)) {
            set_flash('success', 'Termin aktualisiert.');
        } else {
            set_flash('error', 'Gebuchte Termine lassen sich nicht sperren.');
        }

        redirect($this->backToWeek());
    }

    // -----------------------------------------------------------------------
    // Hilfen
    // -----------------------------------------------------------------------

    /** Zeigt das Formular mit Fehlermeldung und den bisherigen Eingaben erneut. */
    private function backToForm(string $message, array $values): never
    {
        set_flash('error', $message);
        render('admin/slots/form', [
            'title'    => 'Termin anlegen',
            'students' => Student::activeOptions(),
            'values'   => $values,
        ], 'admin/layout');
        exit;
    }

    /** Baut aus "2026-08-10" + "14:00" ein DateTimeImmutable – oder null. */
    private function parseDateTime(string $date, string $time): ?DateTimeImmutable
    {
        $value = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date . ' ' . $time);

        return $value === false ? null : $value->setTime(
            (int) $value->format('H'),
            (int) $value->format('i')
        );
    }

    /** Wochen-Offset eines Datums relativ zur aktuellen Woche. */
    private function weekOffsetOf(DateTimeInterface $date): int
    {
        $thisMonday   = week_start(new DateTimeImmutable('now'));
        $targetMonday = week_start($date);
        $diff         = $thisMonday->diff($targetMonday);

        return (int) ($diff->days / 7) * ($diff->invert ? -1 : 1);
    }

    /** Zurück zur zuletzt betrachteten Kalenderwoche. */
    private function backToWeek(): string
    {
        $week = (int) ($_POST['woche'] ?? 0);

        return '/admin/termine' . ($week !== 0 ? '?woche=' . $week : '');
    }
}
