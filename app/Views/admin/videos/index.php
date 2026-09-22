<?php /** @var array $videos */ ?>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Video von TikTok übernehmen</h2>
    </div>
    <p class="muted" style="margin:0 0 1rem;">
        Auf TikTok beim Video auf „Teilen" und „Link kopieren" tippen, hier
        einfügen. Titel und Vorschaubild holt die Seite selbst. Auf der
        Startseite stehen die <?= Video::HOME_LIMIT ?> neuesten sichtbaren Videos.
    </p>

    <form class="form" method="post" action="<?= url('/admin/videos') ?>">
        <?= csrf_field() ?>
        <div class="form-row">
            <label>
                Link zum Video
                <input type="url" name="link" required inputmode="url"
                       placeholder="https://www.tiktok.com/@<?= e(config('social.tiktok_handle')) ?>/video/…">
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Übernehmen</button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <h2>Deine Videos</h2>
    </div>

    <?php if (!$videos): ?>
        <div class="empty-state">
            <p>Noch keine Videos übernommen. Solange die Liste leer ist, zeigt die
               Startseite den Abschnitt gar nicht erst an.</p>
        </div>
    <?php else: ?>
        <?php $aufStartseite = array_column(Video::latestVisible(), 'id'); ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Vorschau</th>
                    <th>Überschrift auf der Seite</th>
                    <th>Veröffentlicht</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($videos as $video): ?>
                    <tr>
                        <td data-label="Vorschau">
                            <a href="<?= e($video['url']) ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?= url('/video-vorschau/' . $video['id']) ?>" alt=""
                                     width="54" height="96" loading="lazy"
                                     style="width:54px;height:96px;object-fit:cover;border-radius:var(--radius-sm);">
                            </a>
                        </td>
                        <td data-label="Überschrift">
                            <form class="form" method="post"
                                  action="<?= url('/admin/videos/' . $video['id']) ?>">
                                <?= csrf_field() ?>
                                <input type="text" name="title" maxlength="150"
                                       value="<?= e((string) $video['title']) ?>"
                                       placeholder="<?= e(Video::displayTitle(['caption' => $video['caption']])) ?>"
                                       aria-label="Eigene Überschrift">
                                <button class="btn btn-ghost btn-sm" type="submit">Speichern</button>
                            </form>
                            <?php if ($video['caption'] !== ''): ?>
                                <span class="muted" style="font-size:var(--fs-xs);">
                                    TikTok: <?= e($video['caption']) ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td data-label="Veröffentlicht">
                            <?= e(format_date(dt($video['posted_at']))) ?>
                        </td>
                        <td data-label="Status">
                            <?php if (!$video['visible']): ?>
                                <span class="pill pill-neutral">ausgeblendet</span>
                            <?php elseif (in_array($video['id'], $aufStartseite, true)): ?>
                                <span class="pill pill-success">auf der Startseite</span>
                            <?php else: ?>
                                <span class="pill pill-neutral">sichtbar, aber nicht unter den <?= Video::HOME_LIMIT ?> neuesten</span>
                            <?php endif; ?>
                        </td>
                        <td data-label="">
                            <form class="inline-form" method="post"
                                  action="<?= url('/admin/videos/' . $video['id'] . '/sichtbar') ?>">
                                <?= csrf_field() ?>
                                <button class="btn btn-ghost btn-sm" type="submit">
                                    <?= $video['visible'] ? 'Ausblenden' : 'Einblenden' ?>
                                </button>
                            </form>
                            <form class="inline-form" method="post"
                                  action="<?= url('/admin/videos/' . $video['id'] . '/loeschen') ?>">
                                <?= csrf_field() ?>
                                <button class="btn btn-ghost btn-sm" type="submit">Entfernen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
