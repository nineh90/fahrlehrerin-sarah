<?php
/** @var DateTimeImmutable $monday @var int $weekOffset @var array $slotsByDay */
$sunday = $monday->modify('+6 days');
?>

<div class="admin-card">
    <div class="week-bar" style="margin-bottom:0;">
        <h2>
            Woche vom <?= e($monday->format('d.m.')) ?> bis <?= e($sunday->format('d.m.Y')) ?>
            <?php if ($weekOffset === 0): ?>
                <span class="pill pill-accent">Diese Woche</span>
            <?php endif; ?>
        </h2>
        <div class="week-nav">
            <?php if ($weekOffset > -1): ?>
                <a class="btn btn-ghost btn-sm" href="<?= url('/admin/termine?woche=' . ($weekOffset - 1)) ?>">&larr; Vorherige</a>
            <?php endif; ?>
            <?php if ($weekOffset !== 0): ?>
                <a class="btn btn-ghost btn-sm" href="<?= url('/admin/termine') ?>">Diese Woche</a>
            <?php endif; ?>
            <?php if ($weekOffset < 12): ?>
                <a class="btn btn-ghost btn-sm" href="<?= url('/admin/termine?woche=' . ($weekOffset + 1)) ?>">Nächste &rarr;</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Termine anlegen</h2>
        <div class="quick-actions">
            <a class="btn btn-primary btn-sm" href="<?= url('/admin/termine/serie') ?>">Mehrere Wochen freigeben</a>
            <a class="btn btn-ghost btn-sm" href="<?= url('/admin/termine/neu') ?>">Einzelner Termin</a>
        </div>
    </div>

    <div class="week-grid">
        <?php foreach ($slotsByDay as $day): ?>
            <?php $date = $day['date']; ?>
            <div class="week-day<?= is_today($date) ? ' week-day--today' : '' ?>">
                <div class="week-day-head">
                    <span class="week-day-name"><?= e(weekday_short($date)) ?>, <?= e($date->format('d.m.')) ?></span>
                    <span class="week-day-date"><?= count($day['slots']) ?> Termine</span>
                </div>
                <div class="week-day-body">
                    <?php if (!$day['slots']): ?>
                        <p class="week-day-empty">Frei – keine Termine angelegt</p>
                    <?php endif; ?>

                    <?php foreach ($day['slots'] as $slot): ?>
                        <?php $start = dt($slot['starts_at']); ?>
                        <div class="slot slot--<?= e($slot['status']) ?><?= Slot::isPast($slot) ? ' slot--vergangen' : '' ?>">
                            <span>
                                <span class="slot-time"><?= e($start->format('H:i')) ?></span>
                                <span class="slot-meta">
                                    <?= e(Slot::label($slot)) ?><br>
                                    <?php if ($slot['status'] === 'gebucht'): ?>
                                        <?= e($slot['student_name'] ?? 'gebucht') ?>
                                    <?php else: ?>
                                        <?= e(Slot::STATUSES[$slot['status']] ?? $slot['status']) ?>
                                    <?php endif; ?>
                                </span>
                            </span>

                            <?php if ($slot['status'] !== 'gebucht'): ?>
                                <span class="cell-actions">
                                    <form class="inline-form" method="post"
                                          action="<?= url('/admin/termine/' . $slot['id'] . '/sperren') ?>">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="woche" value="<?= (int) $weekOffset ?>">
                                        <button class="btn btn-ghost btn-sm" type="submit"
                                                title="<?= $slot['status'] === 'gesperrt' ? 'Wieder freigeben' : 'Für Buchungen sperren' ?>">
                                            <?= $slot['status'] === 'gesperrt' ? 'Freigeben' : 'Sperren' ?>
                                        </button>
                                    </form>
                                    <form class="inline-form" method="post"
                                          action="<?= url('/admin/termine/' . $slot['id'] . '/loeschen') ?>"
                                          data-confirm="Diesen Termin wirklich löschen?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="woche" value="<?= (int) $weekOffset ?>">
                                        <button class="btn btn-danger btn-sm" type="submit" aria-label="Termin löschen">✕</button>
                                    </form>
                                </span>
                            <?php else: ?>
                                <span class="pill pill-success">Gebucht</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
