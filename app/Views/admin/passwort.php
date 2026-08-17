<?php /** @var bool $erzwingt */ ?>

<?php if ($erzwingt): ?>
    <div class="admin-card card-alert">
        <div class="admin-card-head">
            <h2>Bitte jetzt dein eigenes Passwort vergeben</h2>
        </div>
        <p style="margin:0;">
            Dein Zugang läuft noch mit dem Startpasswort, das beim Einrichten
            vergeben wurde. Solange das so ist, kommst du nur auf diese Seite.
            Sobald du ein eigenes gesetzt hast, ist die ganze Schaltzentrale wieder da.
        </p>
    </div>
<?php endif; ?>

<div class="admin-cols">
    <div class="admin-card">
        <div class="admin-card-head">
            <h2>Passwort ändern</h2>
        </div>

        <form class="form" method="post" action="<?= url('/admin/passwort') ?>">
            <?= csrf_field() ?>

            <label>
                Aktuelles Passwort
                <input type="password" name="current" required autocomplete="current-password"
                       autofocus>
            </label>

            <label>
                Neues Passwort
                <input type="password" name="new" required autocomplete="new-password"
                       minlength="<?= Auth::MIN_PASSWORD_LENGTH ?>">
                <span class="form-hint">
                    Mindestens <?= Auth::MIN_PASSWORD_LENGTH ?> Zeichen.
                </span>
            </label>

            <label>
                Neues Passwort wiederholen
                <input type="password" name="repeat" required autocomplete="new-password"
                       minlength="<?= Auth::MIN_PASSWORD_LENGTH ?>">
            </label>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Passwort speichern</button>
                <?php if (!$erzwingt): ?>
                    <a class="btn btn-ghost" href="<?= url('/admin') ?>">Abbrechen</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="admin-card">
        <div class="admin-card-head">
            <h3>Ein gutes Passwort</h3>
        </div>
        <ul class="check-list">
            <li>Drei bis vier zufällige Wörter hintereinander sind besser zu merken
                und schwerer zu knacken als <code>Sarah2026!</code></li>
            <li>Nicht dasselbe wie bei E-Mail, Instagram oder TikTok – wenn dort
                etwas passiert, ist sonst auch dieser Zugang offen</li>
            <li>Nirgends notieren, wo andere mitlesen können. Ein Passwortmanager
                im Browser oder auf dem Handy ist dafür gemacht</li>
        </ul>

        <dl class="detail-list">
            <dt>Angemeldet als</dt>
            <dd><?= e(Auth::user()['email'] ?? '') ?></dd>
        </dl>

        <p class="muted" style="margin:0; font-size:var(--fs-xs);">
            Die E-Mail-Adresse für die Anmeldung lässt sich hier nicht ändern –
            dafür bin ich zuständig. Sag mir Bescheid, wenn sie anders lauten soll.
        </p>
    </div>
</div>
