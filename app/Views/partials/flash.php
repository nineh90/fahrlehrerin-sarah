<?php $flashes = take_flashes(); ?>
<?php if ($flashes): ?>
    <div class="container flash-wrap">
        <?php foreach ($flashes as $type => $message): ?>
            <div class="flash flash--<?= e($type) ?>" role="status"><?= e($message) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
