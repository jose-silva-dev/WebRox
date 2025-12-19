<?= $this->layout('components/layouts/web') ?>

<div class="space-y-1">
    <div class="web-title">
        Perfil <span><?= $guild->name ?></span>
    </div>

    <div class="profile">
        <div class="header">
            <?= resolve('Guild')->getRender($guild->mark, 105) ?>
        </div>
        <div class="information guild">
            <div>
                <p>Nome: <span><?= $guild->name ?></span></p>
                <p>Dono: <span><a href="<?= route("profile.character.$guild->owner") ?>"><?= $guild->owner ?></a></span></p>
                <p>Pontos: <span><?= resolve('Geral')->getFormatNumber($guild->score) ?></span></p>
            </div>
        </div>
        <div class="members">
            <?php if ($members): ?>
                <?php foreach ($members as $member): ?>
                    <p><a href="<?= route("profile.character.$member->name") ?>"><?= $member->name ?></a></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>