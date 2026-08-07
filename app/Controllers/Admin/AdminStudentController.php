<?php
declare(strict_types=1);

/**
 * Schülerverwaltung. Sarah legt hier ihre Fahrschüler:innen an und vergibt
 * die PIN – eine Selbstregistrierung gibt es bewusst nicht.
 *
 * Die PIN wird ausschließlich direkt nach dem Erzeugen im Klartext angezeigt
 * (über eine Flash-Message) und gleichzeitig per Mail an die Person geschickt.
 * Danach existiert nur noch der Hash: Sarah kann eine PIN nicht nachschlagen,
 * sondern nur eine neue erzeugen. Das ist Absicht und der Grund, warum es
 * überall „Neue PIN" heißt und nirgends „PIN anzeigen".
 */
final class AdminStudentController
{
    public function index(): void
    {
        Auth::require();

        $students = Student::all();

        // Kurzstand der Pflichtfahrten je Person – in der Liste reicht "7 von 12"
        $stand = [];
        foreach ($students as $person) {
            $stand[$person['id']] = Student::pflichtfahrten((int) $person['id']);
        }

        render('admin/schueler/index', [
            'title'    => 'Fahrschüler:innen',
            'students' => $students,
            'counts'   => Student::upcomingCounts(),
            'stand'    => $stand,
        ], 'admin/layout');
    }

    public function create(): void
    {
        Auth::require();

        render('admin/schueler/form', [
            'title'   => 'Fahrschüler:in anlegen',
            'student' => null,
            'values'  => ['active' => '1', 'klasse' => 'B'],
            'stand'   => null,
        ], 'admin/layout');
    }

    public function store(): void
    {
        Auth::require();
        verify_csrf();

        $values = $this->input();
        $error  = $this->validate($values);

        if ($error !== null) {
            set_flash('error', $error);
            render('admin/schueler/form', [
                'title'   => 'Fahrschüler:in anlegen',
                'student' => null,
                'values'  => $values,
                'stand'   => null,
            ], 'admin/layout');
            return;
        }

        $pin = StudentAuth::generatePin();
        $id  = Student::create($values, $pin);

        set_flash('success', $this->pinMessage($values['name'], $values['email'], $pin, $id));
        redirect('/admin/schueler');
    }

    public function edit(string $id): void
    {
        Auth::require();

        $student = Student::find((int) $id);
        if (!$student) {
            $this->notFound();
        }

        render('admin/schueler/form', [
            'title'   => $student['name'],
            'student' => $student,
            'values'  => $student,
            'stand'   => Student::pflichtfahrten((int) $id),
        ], 'admin/layout');
    }

    public function update(string $id): void
    {
        Auth::require();
        verify_csrf();

        $student = Student::find((int) $id);
        if (!$student) {
            $this->notFound();
        }

        $values = $this->input();
        $error  = $this->validate($values, (int) $id);

        if ($error !== null) {
            set_flash('error', $error);
            render('admin/schueler/form', [
                'title'   => $student['name'],
                'student' => $student,
                'values'  => $values,
                'stand'   => Student::pflichtfahrten((int) $id),
            ], 'admin/layout');
            return;
        }

        Student::update((int) $id, $values);
        set_flash('success', 'Änderungen gespeichert.');
        redirect('/admin/schueler/' . (int) $id . '/bearbeiten');
    }

    /**
     * Erzeugt eine neue PIN und schickt sie der Person.
     * Angezeigt wird sie zusätzlich – falls die Mail nicht ankommt, hat Sarah
     * sie so trotzdem einmal gesehen und kann sie persönlich weitergeben.
     */
    public function resetPin(string $id): void
    {
        Auth::require();
        verify_csrf();

        $student = Student::find((int) $id);
        if (!$student) {
            $this->notFound();
        }

        $pin = Student::resetPin((int) $id);
        set_flash('success', $this->pinMessage(
            $student['name'],
            $student['email'],
            $pin,
            (int) $id
        ));

        // Kein freier Pfad aus dem Formular – nur die zwei Orte, an denen der
        // Knopf steht. Sonst wäre das eine offene Weiterleitung.
        redirect(($_POST['zurueck'] ?? '') === 'detail'
            ? '/admin/schueler/' . (int) $id . '/bearbeiten'
            : '/admin/schueler');
    }

    public function destroy(string $id): void
    {
        Auth::require();
        verify_csrf();

        $student = Student::find((int) $id);
        if (!$student) {
            $this->notFound();
        }

        Student::delete((int) $id);
        set_flash('success', $student['name'] . ' wurde gelöscht.');
        redirect('/admin/schueler');
    }

    // -----------------------------------------------------------------------

    /**
     * Verschickt die PIN und baut die Meldung für Sarah.
     * Die PIN steht bewusst AUCH in der Meldung: geht die Mail nicht raus
     * (Tippfehler in der Adresse, Versand aus), ist sie sonst verloren.
     */
    private function pinMessage(string $name, string $email, string $pin, int $id): string
    {
        $verschickt = Notifier::pinToStudent(['name' => $name, 'email' => $email], $pin);
        if ($verschickt) {
            Student::markPinSent($id);
        }

        return sprintf(
            'PIN für %s: %s – %s Notiere sie dir jetzt, sie wird nicht noch einmal angezeigt.',
            $name,
            $pin,
            $verschickt
                ? 'per E-Mail an ' . $email . ' verschickt.'
                : 'die E-Mail konnte nicht verschickt werden, bitte persönlich weitergeben.'
        );
    }

    private function input(): array
    {
        return [
            'name'            => trim((string) ($_POST['name'] ?? '')),
            'email'           => trim((string) ($_POST['email'] ?? '')),
            'phone'           => trim((string) ($_POST['phone'] ?? '')),
            'klasse'          => (string) ($_POST['klasse'] ?? 'B'),
            'note'            => trim((string) ($_POST['note'] ?? '')),
            'active'          => isset($_POST['active']) ? '1' : '0',
            // Anfangsstand der Pflichtfahrten – nie negativ, nie absurd hoch
            'start_ueberland' => $this->startwert('start_ueberland'),
            'start_autobahn'  => $this->startwert('start_autobahn'),
            'start_nacht'     => $this->startwert('start_nacht'),
        ];
    }

    private function startwert(string $feld): int
    {
        return max(0, min(99, (int) ($_POST[$feld] ?? 0)));
    }

    private function validate(array $values, ?int $exceptId = null): ?string
    {
        if ($values['name'] === '') {
            return 'Bitte einen Namen angeben.';
        }
        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Bitte eine gültige E-Mail-Adresse angeben.';
        }
        if (Student::emailTaken($values['email'], $exceptId)) {
            return 'Diese E-Mail-Adresse ist bereits vergeben.';
        }
        if (!isset(Student::KLASSEN[$values['klasse']])) {
            return 'Bitte eine gültige Führerscheinklasse wählen.';
        }

        return null;
    }

    private function notFound(): never
    {
        http_response_code(404);
        render('errors/404', ['title' => 'Nicht gefunden']);
        exit;
    }
}
