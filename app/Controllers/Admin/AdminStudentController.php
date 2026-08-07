<?php
declare(strict_types=1);

/**
 * Schülerverwaltung. Sarah legt hier ihre Fahrschüler:innen an und vergibt
 * die PIN – eine Selbstregistrierung gibt es bewusst nicht.
 *
 * Die PIN wird ausschließlich direkt nach dem Erzeugen im Klartext angezeigt
 * (über eine Flash-Message). Danach existiert nur noch der Hash.
 */
final class AdminStudentController
{
    public function index(): void
    {
        Auth::require();

        render('admin/schueler/index', [
            'title'    => 'Fahrschüler:innen',
            'students' => Student::all(),
            'counts'   => Student::upcomingCounts(),
        ], 'admin/layout');
    }

    public function create(): void
    {
        Auth::require();

        render('admin/schueler/form', [
            'title'   => 'Fahrschüler:in anlegen',
            'student' => null,
            'values'  => ['active' => '1'],
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
            ], 'admin/layout');
            return;
        }

        $pin = StudentAuth::generatePin();
        Student::create($values, $pin);

        set_flash('success', sprintf(
            '%s angelegt. PIN: %s – bitte jetzt notieren und weitergeben, '
            . 'sie wird nicht noch einmal angezeigt.',
            $values['name'],
            $pin
        ));
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
            'title'   => $student['name'] . ' bearbeiten',
            'student' => $student,
            'values'  => $student,
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
                'title'   => $student['name'] . ' bearbeiten',
                'student' => $student,
                'values'  => $values,
            ], 'admin/layout');
            return;
        }

        Student::update((int) $id, $values);
        set_flash('success', 'Änderungen gespeichert.');
        redirect('/admin/schueler');
    }

    public function resetPin(string $id): void
    {
        Auth::require();
        verify_csrf();

        $student = Student::find((int) $id);
        if (!$student) {
            $this->notFound();
        }

        $pin = Student::resetPin((int) $id);
        set_flash('success', sprintf(
            'Neue PIN für %s: %s – bitte jetzt notieren, sie wird nicht noch einmal angezeigt.',
            $student['name'],
            $pin
        ));
        redirect('/admin/schueler');
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

    private function input(): array
    {
        return [
            'name'   => trim((string) ($_POST['name'] ?? '')),
            'email'  => trim((string) ($_POST['email'] ?? '')),
            'phone'  => trim((string) ($_POST['phone'] ?? '')),
            'note'   => trim((string) ($_POST['note'] ?? '')),
            'active' => isset($_POST['active']) ? '1' : '0',
        ];
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

        return null;
    }

    private function notFound(): never
    {
        http_response_code(404);
        render('errors/404', ['title' => 'Nicht gefunden']);
        exit;
    }
}
