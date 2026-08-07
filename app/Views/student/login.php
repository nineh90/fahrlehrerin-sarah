<?php /** @var array $values */ ?>
<section class="page-head">
    <div class="container">
        <h1>Anmelden</h1>
        <p class="page-lead">
            Für Sarahs Fahrschüler:innen: Melde dich mit deiner E-Mail-Adresse und
            deiner PIN an, um dich für eine Fahrstunde einzutragen.
        </p>
    </div>
</section>

<section class="section">
    <div class="container split-grid">
        <div class="card">
            <form class="form" method="post" action="<?= url('/login') ?>">
                <?= csrf_field() ?>

                <label>
                    E-Mail-Adresse
                    <input type="email" name="email" value="<?= old('email', $values) ?>"
                           required autocomplete="email" autofocus>
                </label>

                <label>
                    PIN
                    <input type="password" name="pin" inputmode="numeric" pattern="[0-9]*"
                           maxlength="6" required autocomplete="current-password">
                    <span class="form-hint">Die 6-stellige PIN bekommst du von Sarah.</span>
                </label>

                <div class="form-actions">
                    <button class="btn btn-primary btn-block" type="submit">Anmelden</button>
                </div>
            </form>
        </div>

        <div>
            <h2>Noch keine Zugangsdaten?</h2>
            <p class="muted">
                Deine PIN bekommst du direkt von Sarah – in der Fahrstunde, per
                Telefon oder Nachricht. Registrieren musst du dich hier nicht.
            </p>

            <ul class="steps">
                <li>
                    <strong>PIN bekommen</strong>
                    <span>Sarah trägt dich in ihre Planung ein und gibt dir deine PIN.</span>
                </li>
                <li>
                    <strong>Anmelden</strong>
                    <span>E-Mail-Adresse und PIN eingeben – fertig.</span>
                </li>
                <li>
                    <strong>Stunden selbst eintragen</strong>
                    <span>Eintragen, verschieben und absagen, wann es dir passt.</span>
                </li>
            </ul>

            <p class="muted">
                PIN vergessen? Ruf Sarah kurz an:
                <a href="tel:<?= e(preg_replace('/\s+/', '', (string) config('contact.phone'))) ?>"><?= e(config('contact.phone')) ?></a>.
            </p>
            <p class="muted">
                Du fährst noch gar nicht bei Sarah? Die Anmeldung läuft über die
                Fahrschule – <a href="<?= url('/kontakt') ?>">sprich sie einfach an</a>.
            </p>
        </div>
    </div>
</section>
