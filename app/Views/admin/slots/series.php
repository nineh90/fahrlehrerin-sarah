<?php
/** @var array $values */
$selectedDays = (array) ($values['weekdays'] ?? []);
?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Wann hast du regelmäßig Zeit?</h2>
        <a class="link-more" href="<?= url('/admin/termine') ?>">&larr; Zurück zum Kalender</a>
    </div>

    <p class="muted" style="margin-top:0;">
        Einmal ausfüllen, alle Termine entstehen auf einen Schlag. Zeiten, an denen
        bereits ein Termin existiert, werden automatisch übersprungen – du kannst das
        Formular also gefahrlos mehrfach abschicken.
    </p>

    <form class="form" method="post" action="<?= url('/admin/termine/serie') ?>">
        <?= csrf_field() ?>

        <div class="form-row">
            <label>
                Von (Datum)
                <input type="date" name="from" value="<?= old('from', $values) ?>" required>
            </label>
            <label>
                Bis (Datum)
                <input type="date" name="to" value="<?= old('to', $values) ?>" required>
                <span class="form-hint">Höchstens vier Monate am Stück.</span>
            </label>
        </div>

        <label>
            An welchen Wochentagen?
            <span class="choice-grid">
                <?php foreach (WEEKDAYS_LONG as $index => $name): ?>
                    <?php $value = (string) ($index + 1); ?>
                    <label class="choice">
                        <input type="checkbox" name="weekdays[]" value="<?= e($value) ?>"
                            <?= in_array($value, $selectedDays, true) ? 'checked' : '' ?>>
                        <span><?= e($name) ?></span>
                    </label>
                <?php endforeach; ?>
            </span>
        </label>

        <div class="form-row">
            <label>
                Erster Termin um
                <input type="time" name="time_from" value="<?= old('time_from', $values) ?>" required>
            </label>
            <label>
                Letzter Termin um
                <input type="time" name="time_to" value="<?= old('time_to', $values) ?>" required>
            </label>
        </div>

        <div class="form-row">
            <label>
                Abstand zwischen den Terminen
                <select name="interval">
                    <?php foreach ([45 => 'alle 45 Minuten', 60 => 'jede volle Stunde',
                                    90 => 'alle 90 Minuten', 120 => 'alle 2 Stunden'] as $min => $label): ?>
                        <option value="<?= $min ?>" <?= (string) $min === (string) ($values['interval'] ?? '') ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                Dauer je Fahrstunde
                <select name="duration_min">
                    <?php foreach ([45, 60, 90, 135] as $min): ?>
                        <option value="<?= $min ?>" <?= (string) $min === (string) ($values['duration_min'] ?? '') ? 'selected' : '' ?>>
                            <?= $min ?> Minuten
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-row">
            <label>
                Art des Termins
                <select name="type" data-toggle-target="#serieSonderfahrtArt" data-toggle-value="sonderfahrt">
                    <?php foreach (Slot::TYPES as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= $key === ($values['type'] ?? '') ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                Treffpunkt
                <input type="text" name="location" value="<?= old('location', $values) ?>"
                       placeholder="z. B. Treffpunkt Fahrschule">
            </label>
        </div>

        <div class="form-row" id="serieSonderfahrtArt">
            <label>
                Welche Pflichtfahrt?
                <select name="sonderfahrt_art">
                    <option value="">– keine Zuordnung –</option>
                    <?php foreach (Slot::SONDERFAHRT_ARTEN as $key => $label): ?>
                        <option value="<?= e($key) ?>"
                            <?= $key === ($values['sonderfahrt_art'] ?? '') ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="form-hint">
                    Gilt dann für alle Termine dieser Serie.
                </span>
            </label>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Termine freigeben</button>
            <a class="btn btn-ghost" href="<?= url('/admin/termine') ?>">Abbrechen</a>
        </div>
    </form>
</div>
