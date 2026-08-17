<?php /** @var array $bookings @var ?string $status */ ?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Buchungen</h2>
    </div>

    <div class="filter-bar">
        <a class="chip<?= $status === null ? ' is-active' : '' ?>" href="<?= url('/admin/buchungen') ?>">Alle</a>
        <?php foreach (Booking::STATUSES as $key => $label): ?>
            <a class="chip<?= $status === $key ? ' is-active' : '' ?>"
               href="<?= url('/admin/buchungen?status=' . $key) ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
    </div>

    <?php if (!$bookings): ?>
        <div class="empty-state">
            <p>Für diese Auswahl gibt es keine Buchungen.</p>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Termin</th>
                    <th>Fahrschüler:in</th>
                    <th>Art</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <?php
                    $start  = dt($booking['starts_at']);
                    $isPast = $start < new DateTimeImmutable('now');
                    ?>
                    <tr>
                        <td data-label="Termin">
                            <strong><?= e(format_datetime($start)) ?></strong>
                            <?php if ($isPast): ?>
                                <br><span class="muted" style="font-size:var(--fs-xs);">vergangen</span>
                            <?php endif; ?>
                        </td>
                        <td data-label="Fahrschüler:in">
                            <?= e($booking['student_name']) ?>
                            <?php if ($booking['student_phone']): ?>
                                <br><a href="tel:<?= e(preg_replace('/\s+/', '', (string) $booking['student_phone'])) ?>"
                                       style="font-size:var(--fs-xs);"><?= e($booking['student_phone']) ?></a>
                            <?php endif; ?>
                        </td>
                        <td data-label="Art"><?= e(Slot::label($booking)) ?></td>
                        <td data-label="Status">
                            <?php if ($booking['status'] === 'gebucht'): ?>
                                <span class="pill pill-success">Gebucht</span>
                            <?php else: ?>
                                <span class="pill pill-danger">Storniert</span>
                            <?php endif; ?>
                        </td>
                        <td class="cell-actions" data-label="Aktionen">
                            <?php if ($booking['status'] === 'gebucht' && !$isPast): ?>
                                <form class="inline-form" method="post"
                                      action="<?= url('/admin/buchungen/' . $booking['id'] . '/stornieren') ?>"
                                      data-confirm="Diese Buchung wirklich stornieren? Der Termin wird wieder frei.">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-danger btn-sm" type="submit">Stornieren</button>
                                </form>
                            <?php else: ?>
                                <span class="muted">–</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
