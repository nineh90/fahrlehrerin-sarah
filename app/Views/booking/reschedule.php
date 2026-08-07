<?php
/** @var array $booking @var array $options */
$current = dt($booking['starts_at']);
?>
<section class="page-head">
    <div class="container">
        <h1>Termin verschieben</h1>
        <p class="page-lead">
            Dein aktueller Termin: <strong><?= e(format_datetime($current)) ?></strong>.
            Wähle unten einen freien Termin – der alte wird dann automatisch wieder freigegeben.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!$options): ?>
            <div class="empty-state card">
                <p>Aktuell sind keine anderen Termine frei. Melde dich gerne direkt bei Sarah.</p>
                <a class="btn btn-ghost" href="<?= url('/meine-termine') ?>">Zurück</a>
            </div>
        <?php else: ?>
            <form method="post" action="<?= url('/buchung/' . $booking['id'] . '/verschieben') ?>">
                <?= csrf_field() ?>

                <div class="card">
                    <h2 style="margin-top:0;">Neuer Termin</h2>
                    <div class="choice-grid" role="group" aria-label="Freie Termine">
                        <?php foreach ($options as $slot): ?>
                            <?php
                            $start  = dt($slot['starts_at']);
                            $locked = Booking::isWithinDeadline($slot['starts_at']);
                            ?>
                            <label class="choice<?= $locked ? ' choice--locked' : '' ?>"
                                <?= $locked ? 'title="Dieser Termin ist so kurzfristig, dass du ihn danach nicht mehr selbst ändern kannst."' : '' ?>>
                                <input type="radio" name="slot_id" value="<?= (int) $slot['id'] ?>" required>
                                <span>
                                    <?= e(format_date($start)) ?> · <?= e($start->format('H:i')) ?> Uhr
                                    <?php if ($locked): ?>
                                        <span class="choice-hint">danach nicht mehr änderbar</span>
                                    <?php endif; ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <p class="form-hint">
                        Termine in den nächsten <?= (int) Booking::deadlineHours() ?> Stunden kannst du
                        buchen, danach aber nicht mehr selbst verschieben oder absagen.
                    </p>

                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Termin verschieben</button>
                        <a class="btn btn-ghost" href="<?= url('/meine-termine') ?>">Abbrechen</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>
