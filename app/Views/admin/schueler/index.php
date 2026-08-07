<?php /** @var array $students @var array $counts @var array $stand */ ?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Fahrschüler:innen</h2>
        <a class="btn btn-primary btn-sm" href="<?= url('/admin/schueler/neu') ?>">Neue:n anlegen</a>
    </div>

    <?php if (!$students): ?>
        <div class="empty-state">
            <p>Noch niemand angelegt. Lege deine Fahrschüler:innen an, damit sie
               selbst Termine buchen können.</p>
            <a class="btn btn-primary" href="<?= url('/admin/schueler/neu') ?>">Erste:n anlegen</a>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Kontakt</th>
                    <th>Pflichtfahrten</th>
                    <th>Termine</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <?php
                        $eigen  = $stand[$student['id']] ?? [];
                        $gesamt = array_sum(array_column($eigen, 'gesamt'));
                        $ziel   = array_sum(array_column($eigen, 'soll'));
                        ?>
                        <td data-label="Name">
                            <a href="<?= url('/admin/schueler/' . $student['id'] . '/bearbeiten') ?>">
                                <strong><?= e($student['name']) ?></strong>
                            </a>
                            <br><span class="muted" style="font-size:.82rem;">
                                <?= e(Student::KLASSEN[$student['klasse']] ?? $student['klasse']) ?>
                                <?php if ($student['note']): ?>
                                    &middot; <?= e($student['note']) ?>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td data-label="Kontakt">
                            <a href="mailto:<?= e($student['email']) ?>"><?= e($student['email']) ?></a>
                            <?php if ($student['phone']): ?>
                                <br><a href="tel:<?= e(preg_replace('/\s+/', '', (string) $student['phone'])) ?>"><?= e($student['phone']) ?></a>
                            <?php endif; ?>
                        </td>
                        <td data-label="Pflichtfahrten">
                            <?php if ($ziel > 0 && $gesamt >= $ziel): ?>
                                <span class="pill pill-success"><?= $gesamt ?> von <?= $ziel ?></span>
                            <?php else: ?>
                                <span class="pill pill-neutral"><?= $gesamt ?> von <?= $ziel ?></span>
                            <?php endif; ?>
                        </td>
                        <td data-label="Termine">
                            <?= (int) ($counts[$student['id']] ?? 0) ?> gebucht
                        </td>
                        <td data-label="Status">
                            <?php if ((int) $student['active'] === 1): ?>
                                <span class="pill pill-success">Aktiv</span>
                            <?php else: ?>
                                <span class="pill pill-neutral">Inaktiv</span>
                            <?php endif; ?>
                        </td>
                        <td class="cell-actions" data-label="Aktionen">
                            <a class="btn btn-ghost btn-sm"
                               href="<?= url('/admin/schueler/' . $student['id'] . '/bearbeiten') ?>">Öffnen</a>
                            <form class="inline-form" method="post"
                                  action="<?= url('/admin/schueler/' . $student['id'] . '/pin') ?>"
                                  data-confirm="Neue PIN erzeugen und per E-Mail verschicken? Die alte funktioniert danach nicht mehr.">
                                <?= csrf_field() ?>
                                <button class="btn btn-ghost btn-sm" type="submit">Neue PIN</button>
                            </form>
                            <form class="inline-form" method="post"
                                  action="<?= url('/admin/schueler/' . $student['id'] . '/loeschen') ?>"
                                  data-confirm="Wirklich löschen? Alle Buchungen dieser Person werden mit gelöscht.">
                                <?= csrf_field() ?>
                                <button class="btn btn-danger btn-sm" type="submit">Löschen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="admin-card">
    <h3>Wie der Zugang funktioniert</h3>
    <ul class="check-list" style="margin-top:1rem;">
        <li>Beim Anlegen erzeugt das System eine 6-stellige PIN, schickt sie per
            E-Mail an die Person und zeigt sie dir <strong>einmalig</strong> an.</li>
        <li>Nachschlagen geht nicht: Die PIN wird nur verschlüsselt gespeichert –
            genau wie ein Passwort. Auch du kommst nicht mehr an sie heran.</li>
        <li>PIN vergessen? Über „Neue PIN" erzeugst du jederzeit eine neue.
            Sie geht sofort per Mail raus, die alte gilt dann nicht mehr.</li>
        <li>Wer pausiert, wird auf „inaktiv" gesetzt: Der Zugang ist gesperrt, die Historie bleibt.</li>
    </ul>
</div>
