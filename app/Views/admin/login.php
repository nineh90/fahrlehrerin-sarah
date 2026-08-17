<div class="card">
    <div class="login-head">
        <span class="brand">
            <img class="login-logo" src="<?= asset('img/logo-sarah-klein.webp') ?>"
                 alt="Fahrlehrerin Sarah" width="255" height="300">
            <span class="brand-sub">Schaltzentrale</span>
        </span>
    </div>

    <h1>Anmelden</h1>

    <form class="form" method="post" action="<?= url('/admin/login') ?>">
        <?= csrf_field() ?>

        <label>
            E-Mail-Adresse
            <input type="email" name="email" required autocomplete="username" autofocus>
        </label>

        <label>
            Passwort
            <input type="password" name="password" required autocomplete="current-password">
        </label>

        <div class="form-actions">
            <button class="btn btn-primary btn-block" type="submit">Anmelden</button>
        </div>
    </form>

    <a class="login-back" href="<?= url('/') ?>">&larr; Zurück zur Website</a>
</div>
