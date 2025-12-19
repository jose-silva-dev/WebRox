<div class="rankings box">
    <?php foreach ($rankings as $ranking): ?>
        <div class="ranking">
            <p class="title"><?= $ranking['title'] ?></p>
            <?php foreach ($ranking['data'] as $data): ?>
                <a href="<?= route("profile.{$ranking['type']}.{$data->name}") ?>" class="player">
                    <?php if ($ranking['type'] == 'guild'): ?>
                        <?= resolve('Guild')->getRender($data->mark, 90) ?>
                    <?php else: ?>
                        <img src="<?= resolve('Geral')->getAvatar($data->avatar) ?>" alt="Avatar" class="avatar">
                    <?php endif; ?>
                    <p class="name"><?= $data->name ?></p>
                    <p class="points"><?= $data->score ?> Pontos</p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>