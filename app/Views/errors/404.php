<section class="section">
    <div class="container center">
        <p class="error-code">404</p>
        <h1>Diese Seite gibt es nicht</h1>
        <p class="muted" style="max-width:520px;margin:1rem auto 2rem;">
            Vielleicht hast du dich vertippt oder der Link ist veraltet.
            Zurück zur Startseite geht es hier:
        </p>
        <?php /* Der zweite Knopf führte zu Sarahs freien Zeiten – seit SAR-54
                 nur noch, wenn die Planung öffentlich ist (21.08.2026). Eine
                 Fehlerseite, die auf eine Seite zeigt, zu der es sonst nirgends
                 einen Weg gibt, wäre die einzige verbliebene Tür. */ ?>
        <div class="hero-actions center-actions">
            <a class="btn btn-primary" href="<?= url('/') ?>">Zur Startseite</a>
            <?php if (termine_oeffentlich()): ?>
                <a class="btn btn-ghost" href="<?= url('/termine') ?>">Sarahs freie Zeiten</a>
            <?php endif; ?>
        </div>
    </div>
</section>
