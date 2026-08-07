<?php /** @var array $values */ ?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Einzelnen Termin anlegen</h2>
        <a class="link-more" href="<?= url('/admin/termine') ?>">&larr; Zurück zum Kalender</a>
    </div>

    <form class="form" method="post" action="<?= url('/admin/termine') ?>">
        <?= csrf_field() ?>

        <div class="form-row">
            <label>
                Datum
                <input type="date" name="date" value="<?= old('date', $values) ?>" required>
            </label>
            <label>
                Uhrzeit
                <input type="time" name="time" value="<?= old('time', $values) ?>" required>
            </label>
        </div>

        <div class="form-row">
            <label>
                Dauer
                <select name="duration_min">
                    <?php foreach ([45, 60, 90, 135] as $min): ?>
                        <option value="<?= $min ?>" <?= (string) $min === (string) ($values['duration_min'] ?? '') ? 'selected' : '' ?>>
                            <?= $min ?> Minuten
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                Art des Termins
                <select name="type">
                    <?php foreach (Slot::TYPES as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= $key === ($values['type'] ?? '') ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <label>
            Treffpunkt
            <input type="text" name="location" value="<?= old('location', $values) ?>"
                   placeholder="z. B. Treffpunkt Fahrschule">
        </label>

        <label>
            Notiz (nur für dich sichtbar)
            <textarea name="note" rows="2"><?= old('note', $values) ?></textarea>
        </label>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Termin anlegen</button>
            <a class="btn btn-ghost" href="<?= url('/admin/termine') ?>">Abbrechen</a>
        </div>
    </form>
</div>
