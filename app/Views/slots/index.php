<?php
/** @var DateTimeImmutable $monday @var int $weekOffset @var array $slotsByDay @var bool $isLoggedIn */
$sunday = $monday->modify('+6 days');
?>
<section class="page-head">
    <div class="container">
        <h1>Meine freien Zeiten</h1>
        <p class="page-lead">
            Das ist mein eigener Wochenplan – kein Buchungssystem der Fahrschule.
            Meine Fahrschüler:innen tragen sich hier für die nächste Stunde ein
            und können später selbst verschieben oder absagen.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="week-bar">
            <h2>
                Woche vom <?= e($monday->format('d.m.')) ?> bis <?= e($sunday->format('d.m.Y')) ?>
                <?php if ($weekOffset === 0): ?>
                    <span class="pill pill-accent">Diese Woche</span>
                <?php endif; ?>
            </h2>
            <div class="week-nav">
                <?php if ($weekOffset > -1): ?>
                    <a class="btn btn-ghost btn-sm" href="<?= url('/termine?woche=' . ($weekOffset - 1)) ?>">&larr; Vorherige</a>
                <?php endif; ?>
                <?php if ($weekOffset !== 0): ?>
                    <a class="btn btn-ghost btn-sm" href="<?= url('/termine') ?>">Diese Woche</a>
                <?php endif; ?>
                <?php if ($weekOffset < 12): ?>
                    <a class="btn btn-ghost btn-sm" href="<?= url('/termine?woche=' . ($weekOffset + 1)) ?>">Nächste &rarr;</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!$isLoggedIn): ?>
            <div class="notice" style="--card-accent: var(--c-blue); margin-bottom: 1.8rem;">
                <?= icon('shield') ?>
                <div>
                    <h3>Du fährst schon bei mir?</h3>
                    <p>
                        Dann <a href="<?= url('/login') ?>">melde dich an</a> und trag dich direkt ein.
                        Deine PIN bekommst du von mir in der Fahrstunde.
                    </p>
                    <p>
                        Du bist noch nicht angemeldet? Die Anmeldung läuft über die Fahrschule –
                        <a href="<?= url('/kontakt') ?>">sprich mich einfach an</a>.
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <div class="week-grid">
            <?php foreach ($slotsByDay as $day): ?>
                <?php $date = $day['date']; ?>
                <div class="week-day<?= is_today($date) ? ' week-day--today' : '' ?>">
                    <div class="week-day-head">
                        <span class="week-day-name"><?= e(weekday_long($date)) ?></span>
                        <span class="week-day-date"><?= e($date->format('d.m.Y')) ?></span>
                    </div>
                    <div class="week-day-body">
                        <?php if (!$day['slots']): ?>
                            <p class="week-day-empty">Keine Termine</p>
                        <?php endif; ?>

                        <?php foreach ($day['slots'] as $slot): ?>
                            <?php
                            $start  = dt($slot['starts_at']);
                            $isPast = Slot::isPast($slot);
                            $isOwn  = !empty($slot['is_own']);
                            $class  = $isOwn ? 'slot--eigen' : 'slot--' . $slot['status'];
                            ?>
                            <div class="slot <?= e($class) ?><?= $isPast ? ' slot--vergangen' : '' ?>">
                                <span>
                                    <span class="slot-time"><?= e($start->format('H:i')) ?></span>
                                    <span class="slot-meta"><?= e(Slot::label($slot)) ?></span>
                                </span>

                                <?php if ($isOwn): ?>
                                    <span class="pill pill-accent">Dein Termin</span>
                                <?php elseif ($slot['status'] === 'gebucht'): ?>
                                    <span class="pill pill-neutral">Belegt</span>
                                <?php elseif ($isPast): ?>
                                    <span class="pill pill-neutral">Vorbei</span>
                                <?php elseif ($isLoggedIn): ?>
                                    <form method="post" action="<?= url('/termine/' . $slot['id'] . '/buchen') ?>">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-primary btn-sm" type="submit">Eintragen</button>
                                    </form>
                                <?php else: ?>
                                    <a class="btn btn-ghost btn-sm" href="<?= url('/login') ?>">Anmelden</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
