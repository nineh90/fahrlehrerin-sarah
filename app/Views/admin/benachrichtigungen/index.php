<?php /** @var array $notifications @var bool $onlyUnread @var int $unread */ ?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Posteingang</h2>
        <?php if ($unread > 0): ?>
            <form class="inline-form" method="post" action="<?= url('/admin/benachrichtigungen/gelesen') ?>">
                <?= csrf_field() ?>
                <button class="btn btn-ghost btn-sm" type="submit">Alles als gelesen markieren</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="filter-bar">
        <a class="chip<?= $onlyUnread ? '' : ' is-active' ?>"
           href="<?= url('/admin/benachrichtigungen') ?>">Alle</a>
        <a class="chip<?= $onlyUnread ? ' is-active' : '' ?>"
           href="<?= url('/admin/benachrichtigungen?filter=neu') ?>">
            Ungelesen<?= $unread > 0 ? ' (' . $unread . ')' : '' ?>
        </a>
    </div>

    <?php if (!$notifications): ?>
        <div class="empty-state">
            <p><?= $onlyUnread
                ? 'Nichts Ungelesenes. Alles abgehakt.'
                : 'Hier landet jede Ein- und Umtragung. Bisher ist nichts passiert.' ?></p>
            <a class="btn btn-primary" href="<?= url('/admin/termine/serie') ?>">Termine freigeben</a>
        </div>
    <?php else: ?>
        <ul class="feed">
            <?php foreach ($notifications as $note): ?>
                <?php $isNew = $note['read_at'] === null; ?>
                <li class="feed-item feed-<?= e($note['event']) ?><?= $isNew ? ' is-new' : '' ?>">
                    <span class="feed-dot" aria-hidden="true"></span>

                    <div class="feed-body">
                        <p class="feed-title">
                            <?= e($note['title']) ?>
                            <?php if ($isNew): ?><span class="pill pill-accent">neu</span><?php endif; ?>
                        </p>

                        <p class="feed-meta">
                            <span class="pill pill-neutral"><?= e(Notification::label($note)) ?></span>
                            <?php if ($note['starts_at']): ?>
                                <?php if ($note['from_starts_at']): ?>
                                    <s><?= e(format_datetime(dt($note['from_starts_at']))) ?></s>
                                    &rarr;
                                <?php endif; ?>
                                <strong><?= e(format_datetime(dt($note['starts_at']))) ?></strong>
                            <?php endif; ?>
                        </p>

                        <p class="feed-foot">
                            <?= e(time_ago(dt($note['created_at']))) ?>
                            · <?= $note['actor'] === 'admin' ? 'von dir' : 'von ' . e($note['student_name']) ?>
                            <?php if ($note['channels']): ?>
                                · weitergeleitet: <?= e(str_replace(
                                    ['mail', 'webhook'],
                                    ['E-Mail', 'Webhook'],
                                    (string) $note['channels']
                                )) ?>
                            <?php endif; ?>
                        </p>
                    </div>

                    <?php if ($isNew): ?>
                        <form class="inline-form feed-action" method="post"
                              action="<?= url('/admin/benachrichtigungen/' . $note['id'] . '/gelesen') ?>">
                            <?= csrf_field() ?>
                            <button class="btn btn-ghost btn-sm" type="submit"
                                    aria-label="Als gelesen markieren">Gelesen</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h3>Wie du benachrichtigt wirst</h3>
    </div>
    <p class="muted" style="margin:0 0 .8rem;">
        Jede Ein- und Umtragung landet hier im Posteingang – das läuft immer und
        braucht keine Einstellung.
    </p>
    <ul class="check-list">
        <li>
            <strong>E-Mail:</strong>
            <?php if (config('notify.mail')): ?>
                geht an <?= e((string) (config('notify.to') ?: config('mail.to'))) ?><?php
                if (config('mail.driver') !== 'mail'): ?>
                    – aktuell im Testbetrieb, die Mails landen nur in
                    <code>storage/mail.log</code><?php endif; ?>.
            <?php else: ?>
                ausgeschaltet (<code>NOTIFY_MAIL</code> in der <code>.env</code>).
            <?php endif; ?>
        </li>
        <li>
            <strong>Automatisierung:</strong>
            <?php if (config('notify.webhook_url')): ?>
                Ein Webhook ist eingerichtet – jede Meldung geht zusätzlich als
                Datensatz dorthin.
            <?php else: ?>
                noch keiner eingerichtet. Über <code>NOTIFY_WEBHOOK_URL</code> lässt
                sich ein Dienst wie n8n anschließen, der daraus zum Beispiel einen
                Kalendereintrag oder eine Nachricht aufs Handy macht.
            <?php endif; ?>
        </li>
    </ul>
</div>
