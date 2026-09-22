<?php
/**
 * SARAHS NEUESTE TIKTOKS (SAR-129) – eingebunden in home.php.
 *
 * Kein Embed, sondern Vorschaubild + Überschrift + Link. Das Bild kommt von
 * unserem eigenen Server (/video-vorschau/{id}), nicht von TikTok: So baut die
 * Seite weiter keine Verbindung nach außen auf, wie es die
 * Datenschutzerklärung zusagt, und es braucht keine Einwilligung. Zu TikTok
 * geht es erst, wenn jemand klickt – derselbe Weg wie bei den Kanal-Knöpfen.
 *
 * Die Überschrift ist Sarahs TikTok-Beschreibung ohne Hashtags oder, wenn im
 * Admin eine eigene gesetzt ist, die. Sie ist echter Text und damit das, was
 * dieser Abschnitt für Suchmaschinen beiträgt.
 *
 * ⚠️ ENTWURF: „Neu auf TikTok" und „Alle Videos ansehen" sind nicht von Sarah.
 *
 * @var array $videos
 */
?>
<div class="video-feed">
    <div class="video-feed-head">
        <h3>Neu auf TikTok</h3>
        <a class="link-more" href="<?= e(tiktok_url()) ?>" target="_blank" rel="noopener noreferrer">
            Alle Videos ansehen &nearr;<span class="sr-only"> – öffnet TikTok in neuem Tab</span>
        </a>
    </div>

    <ul class="video-grid">
        <?php foreach ($videos as $video): ?>
            <li class="video-card">
                <a href="<?= e($video['url']) ?>" target="_blank" rel="noopener noreferrer">
                    <span class="video-card-thumb">
                        <img src="<?= url('/video-vorschau/' . $video['id']) ?>" alt=""
                             width="<?= (int) $video['thumb_w'] ?>" height="<?= (int) $video['thumb_h'] ?>"
                             loading="lazy" decoding="async">
                        <span class="video-card-play" aria-hidden="true"><?= icon('play') ?></span>
                    </span>
                    <span class="video-card-title"><?= e(Video::displayTitle($video)) ?></span>
                    <span class="video-card-meta">
                        <?= e(format_date(dt($video['posted_at']))) ?>
                        <span class="sr-only"> – Video auf TikTok, öffnet in neuem Tab</span>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
