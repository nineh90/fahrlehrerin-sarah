<?php /** @var array $students @var array $counts */ ?>

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
                    <th>Termine</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td data-label="Name">
                            <strong><?= e($student['name']) ?></strong>
                            <?php if ($student['note']): ?>
                                <br><span class="muted" style="font-size:.82rem;"><?= e($student['note']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td data-label="Kontakt">
                            <a href="mailto:<?= e($student['email']) ?>"><?= e($student['email']) ?></a>
                            <?php if ($student['phone']): ?>
                                <br><a href="tel:<?= e(preg_replace('/\s+/', '', (string) $student['phone'])) ?>"><?= e($student['phone']) ?></a>
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
                               href="<?= url('/admin/schueler/' . $student['id'] . '/bearbeiten') ?>">Bearbeiten</a>
                            <form class="inline-form" method="post"
                                  action="<?= url('/admin/schueler/' . $student['id'] . '/pin') ?>"
                                  data-confirm="Neue PIN erzeugen? Die alte funktioniert danach nicht mehr.">
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
        <li>Beim Anlegen erzeugt das System eine 6-stellige PIN und zeigt sie <strong>einmalig</strong> an.</li>
        <li>Notiere sie dir und gib sie persönlich weiter – gespeichert wird sie nur verschlüsselt.</li>
        <li>PIN vergessen? Über „Neue PIN" erzeugst du jederzeit eine neue.</li>
        <li>Wer pausiert, wird auf „inaktiv" gesetzt: Der Zugang ist gesperrt, die Historie bleibt.</li>
    </ul>
</div>
