<?php /** @var array $stats @var array $upcoming */ ?>

<div class="stat-grid">
    <a class="stat-card" href="<?= url('/admin/termine') ?>">
        <span class="stat-value"><?= (int) $stats['frei_gesamt'] ?></span>
        <span class="stat-label">Freie Termine</span>
        <span class="stat-meta">noch buchbar</span>
    </a>
    <a class="stat-card" href="<?= url('/admin/buchungen') ?>">
        <span class="stat-value"><?= (int) $stats['gebucht_gesamt'] ?></span>
        <span class="stat-label">Gebuchte Termine</span>
        <span class="stat-meta">in der Zukunft</span>
    </a>
    <a class="stat-card" href="<?= url('/admin/termine') ?>">
        <span class="stat-value"><?= (int) $stats['diese_woche'] ?></span>
        <span class="stat-label">Nächste 7 Tage</span>
        <span class="stat-meta">Termine insgesamt</span>
    </a>
    <a class="stat-card" href="<?= url('/admin/schueler') ?>">
        <span class="stat-value"><?= (int) $stats['schueler'] ?></span>
        <span class="stat-label">Fahrschüler:innen</span>
        <span class="stat-meta">aktiv</span>
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Schnellzugriff</h2>
    </div>
    <div class="quick-actions">
        <a class="btn btn-primary" href="<?= url('/admin/termine/serie') ?>">Termine freigeben</a>
        <a class="btn btn-ghost" href="<?= url('/admin/termine/neu') ?>">Einzelnen Termin anlegen</a>
        <a class="btn btn-ghost" href="<?= url('/admin/schueler/neu') ?>">Fahrschüler:in anlegen</a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Das steht als Nächstes an</h2>
        <a class="link-more" href="<?= url('/admin/buchungen') ?>">Alle Buchungen &rarr;</a>
    </div>

    <?php if (!$upcoming): ?>
        <div class="empty-state">
            <p>Aktuell ist keine Fahrstunde gebucht.</p>
            <a class="btn btn-primary" href="<?= url('/admin/termine/serie') ?>">Termine freigeben</a>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Termin</th>
                    <th>Art</th>
                    <th>Fahrschüler:in</th>
                    <th>Telefon</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($upcoming as $slot): ?>
                    <?php $start = dt($slot['starts_at']); ?>
                    <tr>
                        <td data-label="Termin"><strong><?= e(format_datetime($start)) ?></strong></td>
                        <td data-label="Art"><?= e(Slot::label($slot)) ?></td>
                        <td data-label="Fahrschüler:in"><?= e($slot['student_name']) ?></td>
                        <td data-label="Telefon">
                            <?php if ($slot['student_phone']): ?>
                                <a href="tel:<?= e(preg_replace('/\s+/', '', (string) $slot['student_phone'])) ?>">
                                    <?= e($slot['student_phone']) ?>
                                </a>
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
