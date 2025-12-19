<div>
    <a href="<?= route("profile.$type.$ranking->name") ?>">
        <p><?= $position ?>° - <?= $ranking->name ?></p>
        <?php if ($type == 'guild'): ?>
            <?= resolve('Guild')->getRender($ranking->mark, 90) ?>
        <?php else: ?>
            <img src="<?= resolve('Geral')->getAvatar($ranking->avatar) ?>" alt="Avatar" class="avatar">
        <?php endif; ?>
        <p><?= $ranking->score ?></p>
    </a>
</div>