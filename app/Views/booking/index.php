<?php /** @var array $student @var array $upcoming @var array $past */ ?>
<section class="page-head">
    <div class="container">
        <h1>Meine Stunden</h1>
        <p class="page-lead">
            Hallo <?= e($student['name'] ?? '') ?>! Hier stehen deine Fahrstunden bei Sarah.
            Bis <?= (int) Booking::deadlineHours() ?> Stunden vorher kannst du selbst verschieben oder absagen –
            danach ruf bitte kurz an.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <span class="section-eyebrow">Kommende Stunden</span>
                <h2>Das steht an</h2>
            </div>
            <a class="link-more" href="<?= url('/termine') ?>">Weitere Zeiten ansehen &rarr;</a>
        </div>

        <?php if (!$upcoming): ?>
            <div class="empty-state card">
                <p>Du hast aktuell keine Fahrstunde eingetragen.</p>
                <a class="btn btn-primary" href="<?= url('/termine') ?>">Sarahs freie Zeiten</a>
            </div>
        <?php else: ?>
            <ul class="appointment-list">
                <?php foreach ($upcoming as $booking): ?>
                    <?php
                    $start    = dt($booking['starts_at']);
                    $editable = Booking::isEditable($booking);
                    ?>
                    <li class="appointment">
                        <div class="appointment-date">
                            <span class="appointment-day"><?= e($start->format('d')) ?></span>
                            <span class="appointment-month"><?= e($start->format('M')) ?></span>
                        </div>

                        <div class="appointment-main">
                            <h3><?= e(weekday_long($start)) ?>, <?= e(format_time($start)) ?></h3>
                            <p>
                                <?= e(Slot::label($booking)) ?>
                                <?php if ($booking['location']): ?>
                                    · <?= e($booking['location']) ?>
                                <?php endif; ?>
                            </p>
                            <?php if (!$editable): ?>
                                <p class="muted"><?= e(Booking::lockReason($booking)) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="appointment-actions">
                            <?php if ($editable): ?>
                                <a class="btn btn-ghost btn-sm"
                                   href="<?= url('/buchung/' . $booking['id'] . '/verschieben') ?>">Verschieben</a>
                                <form method="post"
                                      action="<?= url('/buchung/' . $booking['id'] . '/stornieren') ?>"
                                      data-confirm="Diesen Termin wirklich absagen?">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-danger btn-sm" type="submit">Absagen</button>
                                </form>
                            <?php else: ?>
                                <span class="pill pill-warning">Frist abgelaufen</span>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>

<?php if ($past): ?>
    <section class="section section--alt">
        <div class="container">
            <div class="section-head">
                <div class="section-head-text">
                    <span class="section-eyebrow">Verlauf</span>
                    <h2>Vergangen &amp; storniert</h2>
                </div>
            </div>

            <ul class="appointment-list">
                <?php foreach ($past as $booking): ?>
                    <?php
                    $start     = dt($booking['starts_at']);
                    $cancelled = $booking['status'] === 'storniert';
                    ?>
                    <li class="appointment <?= $cancelled ? 'appointment--cancelled' : 'appointment--past' ?>">
                        <div class="appointment-date">
                            <span class="appointment-day"><?= e($start->format('d')) ?></span>
                            <span class="appointment-month"><?= e($start->format('M')) ?></span>
                        </div>
                        <div class="appointment-main">
                            <h3><?= e(weekday_long($start)) ?>, <?= e(format_time($start)) ?></h3>
                            <p><?= e(Slot::label($booking)) ?></p>
                        </div>
                        <div class="appointment-actions">
                            <span class="pill <?= $cancelled ? 'pill-danger' : 'pill-neutral' ?>">
                                <?= e($cancelled ? 'Storniert' : 'Gefahren') ?>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>
