<?php /** @var array $values @var array $students */ ?>

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
                <select name="type" data-toggle-target="#sonderfahrtArt" data-toggle-value="sonderfahrt">
                    <?php foreach (Slot::TYPES as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= $key === ($values['type'] ?? '') ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <?php /* Nur bei Sonderfahrten relevant – per JS ein-/ausgeblendet, ohne JS
                 bleibt es sichtbar und der Controller ignoriert es bei anderen Arten. */ ?>
        <div class="form-row" id="sonderfahrtArt">
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
                    Zählt beim Ausbildungsstand mit, sobald der Termin vorbei ist.
                </span>
            </label>
        </div>

        <label>
            Zuweisen an
            <select name="student_id">
                <option value="">– niemanden, der Termin steht allen offen –</option>
                <?php foreach ($students as $person): ?>
                    <option value="<?= (int) $person['id'] ?>"
                        <?= (string) $person['id'] === (string) ($values['student_id'] ?? '') ? 'selected' : '' ?>>
                        <?= e($person['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="form-hint">
                Für Prüfungstermine: Der Termin ist damit sofort vergeben und
                taucht bei niemand anderem als frei auf.
            </span>
        </label>

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
