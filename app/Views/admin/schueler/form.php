<?php
/** @var ?array $student @var array $values */
$isEdit = $student !== null;
$action = $isEdit ? url('/admin/schueler/' . $student['id']) : url('/admin/schueler');
?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2><?= $isEdit ? 'Fahrschüler:in bearbeiten' : 'Fahrschüler:in anlegen' ?></h2>
        <a class="link-more" href="<?= url('/admin/schueler') ?>">&larr; Zurück zur Liste</a>
    </div>

    <?php if (!$isEdit): ?>
        <p class="muted" style="margin-top:0;">
            Nach dem Speichern siehst du die PIN <strong>einmalig</strong> als Meldung
            oben auf der Seite. Notiere sie dir gleich.
        </p>
    <?php endif; ?>

    <form class="form" method="post" action="<?= $action ?>">
        <?= csrf_field() ?>

        <div class="form-row">
            <label>
                Name
                <input type="text" name="name" value="<?= old('name', $values) ?>" required autofocus>
            </label>
            <label>
                E-Mail-Adresse
                <input type="email" name="email" value="<?= old('email', $values) ?>" required>
                <span class="form-hint">Damit meldet sich die Person später an.</span>
            </label>
        </div>

        <label>
            Telefon (optional)
            <input type="tel" name="phone" value="<?= old('phone', $values) ?>">
        </label>

        <label>
            Notiz (nur für dich sichtbar)
            <textarea name="note" rows="2" placeholder="z. B. Klasse B, braucht noch Autobahnfahrten"><?= old('note', $values) ?></textarea>
        </label>

        <?php if ($isEdit): ?>
            <label class="checkbox-label">
                <input type="checkbox" name="active" value="1"
                    <?= (int) ($values['active'] ?? 1) === 1 ? 'checked' : '' ?>>
                Zugang aktiv
            </label>
        <?php endif; ?>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">
                <?= $isEdit ? 'Änderungen speichern' : 'Anlegen und PIN erzeugen' ?>
            </button>
            <a class="btn btn-ghost" href="<?= url('/admin/schueler') ?>">Abbrechen</a>
        </div>
    </form>
</div>
