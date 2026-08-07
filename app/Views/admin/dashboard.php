<?php
/**
 * @var array $stats @var array $today @var array $upcoming
 * @var array $unread @var array $feed @var string $greeting @var DateTimeImmutable $now
 */

// Heutige Zahlen aus dem Tagesplan – dafür lohnt keine eigene Abfrage.
$heuteGebucht = array_filter($today, static fn ($s) => $s['status'] === 'gebucht');
$naechste     = null;
foreach ($today as $slot) {
    if ($slot['status'] === 'gebucht' && dt($slot['starts_at']) >= $now) {
        $naechste = $slot;
        break;
    }
}
?>

<div class="admin-hero">
    <div class="admin-hero-text">
        <p class="admin-hero-date">
            <?= e(weekday_long($now)) ?>, <?= e(format_date_long($now)) ?>
        </p>
        <h2><?= e($greeting) ?>!</h2>
        <p class="admin-hero-line">
            <?php $anzahl = count($heuteGebucht); ?>
            <?php if ($naechste !== null): ?>
                <?= $anzahl === 1 ? 'Heute steht eine Stunde an' : 'Heute stehen ' . $anzahl . ' Stunden an' ?> –
                die nächste um <strong><?= e(format_time(dt($naechste['starts_at']))) ?></strong>
                mit <?= e($naechste['student_name']) ?>.
            <?php elseif ($heuteGebucht): ?>
                Für heute ist alles erledigt –
                <?= $anzahl === 1 ? 'eine Stunde lag an' : $anzahl . ' Stunden lagen an' ?>.
            <?php elseif ($today): ?>
                Heute ist keine Stunde gebucht –
                <?= count($today) === 1 ? 'eine Zeit steht' : count($today) . ' Zeiten stehen' ?> im Plan.
            <?php else: ?>
                Für heute hast du keine Zeiten freigegeben.
            <?php endif; ?>
        </p>
    </div>

    <div class="quick-actions">
        <a class="btn btn-primary" href="<?= url('/admin/termine/serie') ?>">Zeiten freigeben</a>
        <a class="btn btn-ghost" href="<?= url('/admin/termine/neu') ?>">Einzelner Termin</a>
        <a class="btn btn-ghost" href="<?= url('/admin/schueler/neu') ?>">Fahrschüler:in anlegen</a>
    </div>
</div>

<?php if ($unread): ?>
    <div class="admin-card card-alert">
        <div class="admin-card-head">
            <h2>Neu seit deinem letzten Blick</h2>
            <a class="link-more" href="<?= url('/admin/benachrichtigungen') ?>">Posteingang &rarr;</a>
        </div>

        <ul class="feed">
            <?php foreach ($unread as $note): ?>
                <li class="feed-item feed-<?= e($note['event']) ?> is-new">
                    <span class="feed-dot" aria-hidden="true"></span>
                    <div class="feed-body">
                        <p class="feed-title"><?= e($note['title']) ?></p>
                        <p class="feed-meta">
                            <?php if ($note['from_starts_at']): ?>
                                <s><?= e(format_datetime(dt($note['from_starts_at']))) ?></s> &rarr;
                            <?php endif; ?>
                            <?php if ($note['starts_at']): ?>
                                <strong><?= e(format_datetime(dt($note['starts_at']))) ?></strong>
                            <?php endif; ?>
                        </p>
                    </div>
                    <span class="feed-time"><?= e(time_ago(dt($note['created_at']))) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <form class="inline-form" method="post" action="<?= url('/admin/benachrichtigungen/gelesen') ?>">
            <?= csrf_field() ?>
            <button class="btn btn-ghost btn-sm" type="submit">Alles gesehen</button>
        </form>
    </div>
<?php endif; ?>

<div class="stat-grid">
    <a class="stat-card" href="<?= url('/admin/termine') ?>">
        <span class="stat-value"><?= (int) $stats['frei_gesamt'] ?></span>
        <span class="stat-label">Freie Zeiten</span>
        <span class="stat-meta">können eingetragen werden</span>
    </a>
    <a class="stat-card" href="<?= url('/admin/buchungen') ?>">
        <span class="stat-value"><?= (int) $stats['gebucht_gesamt'] ?></span>
        <span class="stat-label">Gebuchte Stunden</span>
        <span class="stat-meta">in der Zukunft</span>
    </a>
    <a class="stat-card" href="<?= url('/admin/termine') ?>">
        <span class="stat-value"><?= (int) $stats['diese_woche'] ?></span>
        <span class="stat-label">Nächste 7 Tage</span>
        <span class="stat-meta">davon <?= (int) $stats['woche_gebucht'] ?> gebucht</span>
    </a>
    <a class="stat-card" href="<?= url('/admin/schueler') ?>">
        <span class="stat-value"><?= (int) $stats['schueler'] ?></span>
        <span class="stat-label">Fahrschüler:innen</span>
        <span class="stat-meta">aktiv</span>
    </a>
</div>

<div class="admin-cols">
    <div class="admin-card">
        <div class="admin-card-head">
            <h2>Dein Tag</h2>
            <a class="link-more" href="<?= url('/admin/termine') ?>">Wochenplan &rarr;</a>
        </div>

        <?php if (!$today): ?>
            <div class="empty-state">
                <p>Für heute stehen keine Zeiten im Plan.</p>
                <a class="btn btn-primary btn-sm" href="<?= url('/admin/termine/serie') ?>">Zeiten freigeben</a>
            </div>
        <?php else: ?>
            <ul class="day-plan">
                <?php foreach ($today as $slot): ?>
                    <?php
                    $start  = dt($slot['starts_at']);
                    $isPast = $start < $now;
                    ?>
                    <li class="day-row status-<?= e($slot['status']) ?><?= $isPast ? ' is-past' : '' ?>">
                        <span class="day-time"><?= e($start->format('H:i')) ?></span>
                        <span class="day-info">
                            <strong>
                                <?= $slot['student_name']
                                    ? e($slot['student_name'])
                                    : e(Slot::STATUSES[$slot['status']] ?? $slot['status']) ?>
                            </strong>
                            <span class="muted"><?= e(Slot::label($slot)) ?></span>
                        </span>
                        <?php if ($slot['student_phone']): ?>
                            <a class="day-phone"
                               href="tel:<?= e(preg_replace('/\s+/', '', (string) $slot['student_phone'])) ?>"
                               aria-label="<?= e($slot['student_name']) ?> anrufen"><?= icon('phone') ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="admin-card">
        <div class="admin-card-head">
            <h2>Als Nächstes</h2>
            <a class="link-more" href="<?= url('/admin/buchungen') ?>">Alle Buchungen &rarr;</a>
        </div>

        <?php if (!$upcoming): ?>
            <div class="empty-state">
                <p>Aktuell ist keine Fahrstunde gebucht.</p>
            </div>
        <?php else: ?>
            <ul class="day-plan">
                <?php foreach ($upcoming as $slot): ?>
                    <?php $start = dt($slot['starts_at']); ?>
                    <li class="day-row status-gebucht">
                        <span class="day-time">
                            <?= e(weekday_short($start)) ?><br>
                            <span class="day-time-sub"><?= e($start->format('H:i')) ?></span>
                        </span>
                        <span class="day-info">
                            <strong><?= e($slot['student_name']) ?></strong>
                            <span class="muted">
                                <?= e(is_today($start) ? 'heute' : $start->format('d.m.')) ?>
                                · <?= e(Slot::label($slot)) ?>
                            </span>
                        </span>
                        <?php if ($slot['student_phone']): ?>
                            <a class="day-phone"
                               href="tel:<?= e(preg_replace('/\s+/', '', (string) $slot['student_phone'])) ?>"
                               aria-label="<?= e($slot['student_name']) ?> anrufen"><?= icon('phone') ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php if ($feed): ?>
    <div class="admin-card">
        <div class="admin-card-head">
            <h2>Zuletzt passiert</h2>
            <a class="link-more" href="<?= url('/admin/benachrichtigungen') ?>">Ganzer Verlauf &rarr;</a>
        </div>

        <ul class="feed feed-compact">
            <?php foreach ($feed as $note): ?>
                <li class="feed-item feed-<?= e($note['event']) ?>">
                    <span class="feed-dot" aria-hidden="true"></span>
                    <div class="feed-body">
                        <p class="feed-title"><?= e($note['title']) ?></p>
                    </div>
                    <span class="feed-time"><?= e(time_ago(dt($note['created_at']))) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
