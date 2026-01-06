<div class="<?= isset($isTop1) && $isTop1 ? 'top1-card' : '' ?>">
    <a href="<?= route("profile.$type.$ranking->name") ?>">
        <p class="<?= isset($isTop1) && $isTop1 ? 'top1-title' : '' ?>"><?= $position ?>° - <?= $ranking->name ?></p>
        <?php if ($type == 'guild'): ?>
            <?= resolve('Guild')->getRender($ranking->mark, isset($isTop1) && $isTop1 ? 180 : 90) ?>
        <?php else: ?>
            <img src="<?= resolve('Geral')->getAvatar($ranking->avatar) ?>" alt="Avatar" class="avatar <?= isset($isTop1) && $isTop1 ? 'top1-avatar' : '' ?>">
        <?php endif; ?>
        <p class="<?= isset($isTop1) && $isTop1 ? 'top1-score' : '' ?>"><?= $ranking->score ?></p>
    </a>
</div>