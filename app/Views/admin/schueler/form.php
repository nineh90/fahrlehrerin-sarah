<?php
/** @var ?array $student @var array $values @var ?array $stand */
$isEdit = $student !== null;
$action = $isEdit ? url('/admin/schueler/' . $student['id']) : url('/admin/schueler');
$klasse = $values['klasse'] ?? 'B';
$soll   = Student::PFLICHT_SOLL[$klasse] ?? Student::PFLICHT_SOLL['B'];
?>

<?php if ($isEdit): ?>
    <?php /* Der Ausbildungsstand steht oben: das ist die Frage, mit der Sarah
             diese Seite aufmacht – nicht die Stammdaten. */ ?>
    <div class="admin-cols">
        <div class="admin-card">
            <div class="admin-card-head">
                <h2>Pflichtfahrten · <?= e(Student::KLASSEN[$klasse] ?? $klasse) ?></h2>
                <?php if (Student::pflichtfahrtenKomplett($stand)): ?>
                    <span class="pill pill-success">Vollständig</span>
                <?php endif; ?>
            </div>

            <ul class="progress-list">
                <?php foreach ($stand as $art => $eintrag): ?>
                    <li class="progress-item progress-<?= e($art) ?>">
                        <div class="progress-head">
                            <span><?= e(Slot::SONDERFAHRT_ARTEN[$art] ?? $art) ?></span>
                            <strong>
                                <?= $eintrag['gesamt'] ?> / <?= $eintrag['soll'] ?>
                                <?php if ($eintrag['offen'] === 0): ?>
                                    <span class="progress-done" aria-label="vollständig"><?= icon('check') ?></span>
                                <?php endif; ?>
                            </strong>
                        </div>
                        <div class="progress-track">
                            <div class="progress-bar" style="width: <?= (int) $eintrag['prozent'] ?>%"></div>
                        </div>
                        <p class="progress-meta">
                            <?php if ($eintrag['start'] > 0): ?>
                                <?= $eintrag['gefahren'] ?> hier gefahren,
                                <?= $eintrag['start'] ?> vorher &middot;
                            <?php endif; ?>
                            <?= $eintrag['offen'] === 0
                                ? 'nichts mehr offen'
                                : 'noch ' . $eintrag['offen'] . ' offen' ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="muted" style="margin-bottom:0; font-size:.85rem;">
                Gezählt werden Sonderfahrten mit gesetzter Art, sobald der Termin
                vorbei ist. Trag die Art beim Anlegen des Termins ein – dann läuft
                der Stand von allein mit.
            </p>
        </div>

        <div class="admin-card">
            <div class="admin-card-head">
                <h2>Zugang</h2>
                <?php if ((int) ($student['active'] ?? 1) === 1): ?>
                    <span class="pill pill-success">Aktiv</span>
                <?php else: ?>
                    <span class="pill pill-neutral">Inaktiv</span>
                <?php endif; ?>
            </div>

            <dl class="detail-list">
                <dt>E-Mail zum Anmelden</dt>
                <dd><a href="mailto:<?= e($student['email']) ?>"><?= e($student['email']) ?></a></dd>

                <dt>PIN</dt>
                <dd>
                    <span class="pin-dots" aria-hidden="true">••••••</span>
                    <span class="muted">nur verschlüsselt gespeichert</span>
                </dd>

                <dt>Zuletzt erzeugt</dt>
                <dd>
                    <?= $student['pin_changed_at']
                        ? e(format_datetime(dt($student['pin_changed_at'])))
                        : '<span class="muted">unbekannt</span>' ?>
                </dd>

                <dt>Zuletzt verschickt</dt>
                <dd>
                    <?= $student['pin_sent_at']
                        ? e(format_datetime(dt($student['pin_sent_at'])))
                        : '<span class="muted">noch nie</span>' ?>
                </dd>
            </dl>

            <form method="post" action="<?= url('/admin/schueler/' . $student['id'] . '/pin') ?>"
                  data-confirm="Neue PIN erzeugen und per E-Mail verschicken? Die alte funktioniert danach nicht mehr.">
                <?= csrf_field() ?>
                <input type="hidden" name="zurueck" value="detail">
                <button class="btn btn-primary btn-block" type="submit">Neue PIN erzeugen &amp; mailen</button>
            </form>

            <p class="muted" style="margin:.9rem 0 0; font-size:.85rem;">
                Die PIN lässt sich nicht nachschlagen – sie steht nirgends im
                Klartext. Vergessen? Dann erzeugst du hier eine neue: sie geht
                sofort per Mail raus und wird dir einmalig angezeigt.
            </p>
        </div>
    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2><?= $isEdit ? 'Stammdaten' : 'Fahrschüler:in anlegen' ?></h2>
        <a class="link-more" href="<?= url('/admin/schueler') ?>">&larr; Zurück zur Liste</a>
    </div>

    <?php if (!$isEdit): ?>
        <p class="muted" style="margin-top:0;">
            Nach dem Speichern geht die PIN per E-Mail an die angegebene Adresse
            und wird dir <strong>einmalig</strong> oben als Meldung angezeigt.
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
                <span class="form-hint">Damit meldet sich die Person an – dorthin geht auch die PIN.</span>
            </label>
        </div>

        <div class="form-row">
            <label>
                Telefon (optional)
                <input type="tel" name="phone" value="<?= old('phone', $values) ?>">
            </label>
            <label>
                Führerscheinklasse
                <select name="klasse">
                    <?php foreach (Student::KLASSEN as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= $key === $klasse ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="form-hint">Bestimmt, wie viele Pflichtfahrten nötig sind.</span>
            </label>
        </div>

        <fieldset class="form-fieldset">
            <legend>Schon gefahrene Pflichtfahrten</legend>
            <p class="form-hint" style="margin-top:0;">
                Nur für Fahrten, die es vor dieser Website gab. Alles, was hier als
                Sonderfahrt eingetragen wird, zählt automatisch dazu.
            </p>
            <div class="form-row form-row--3">
                <?php foreach (Slot::SONDERFAHRT_ARTEN as $art => $label): ?>
                    <label>
                        <?= e($label) ?>
                        <input type="number" name="start_<?= e($art) ?>" min="0" max="99"
                               value="<?= (int) ($values['start_' . $art] ?? 0) ?>">
                        <span class="form-hint">von <?= (int) ($soll[$art] ?? 0) ?> nötig</span>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <label>
            Notiz (nur für dich sichtbar)
            <textarea name="note" rows="2" placeholder="z. B. braucht noch Autobahnfahrten"><?= old('note', $values) ?></textarea>
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
                <?= $isEdit ? 'Änderungen speichern' : 'Anlegen und PIN verschicken' ?>
            </button>
            <a class="btn btn-ghost" href="<?= url('/admin/schueler') ?>">Abbrechen</a>
        </div>
    </form>
</div>

<?php if ($isEdit): ?>
    <div class="admin-card">
        <div class="admin-card-head">
            <h3>Termine von <?= e($student['name']) ?></h3>
            <a class="link-more" href="<?= url('/admin/termine/neu') ?>">Termin anlegen &amp; zuweisen &rarr;</a>
        </div>
        <p class="muted" style="margin:0;">
            Einen freien Termin vergibst du am schnellsten im
            <a href="<?= url('/admin/termine') ?>">Kalender</a> über „Zuweisen".
            Für einen Prüfungstermin legst du ihn direkt für diese Person an –
            dann taucht er bei niemand anderem als frei auf.
        </p>
    </div>
<?php endif; ?>
