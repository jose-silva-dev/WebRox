<?= $this->layout('components/layouts/web') ?>

<div class="space-y-1">
    <div class="web-title">
        Perfil <span><?= $character->name ?></span>
    </div>

    <div class="profile">
        <div class="header">
            <img src="<?= resolve('Geral')->getAvatar($character->avatar) ?>" alt="<?= $character->name ?>" title="<?= $character->name ?>">
            <div class="status">
                <?php if ($character->status == 1 && $character->name == $character->gameidc): ?>
                    <div class="online">Online</div>
                <?php else: ?>
                    <div class="offline">Offline</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="information">
            <div>
                <p>Nome: <span><?= $character->name ?></span></p>
                <p>Classe: <span><?= resolve('Geral')->getClass($character->class)->name ?></span></p>
                <p>Mapa: <span><?php 
                    $map = resolve('Geral')->getMap($character->mapnumber ?? 0);
                    echo isset($map->name) ? $map->name : 'Mapa Desconhecido';
                ?> (x: <?= $character->mapposx ?? 0 ?>, y: <?= $character->mapposy ?? 0 ?>)</span></p>
                <p>Nível: <span><?= resolve('Geral')->getFormatNumber($character->level) ?></span></p>
                <p>Guilda: <span>
                        <?php if ($character->guild): ?>
                            <a href="<?= route("profile.guild.$character->guild") ?>"><?= $character->guild ?></a>
                        <?php else: ?>
                            Nenhuma
                        <?php endif; ?>
                    </span>
                </p>
            </div>
            <div>
                <p>Força: <span><?= resolve('Geral')->getFormatNumber($character->strength) ?></span></p>
                <p>Agilidade: <span><?= resolve('Geral')->getFormatNumber($character->dexterity) ?></span></p>
                <p>Vitalidade: <span><?= resolve('Geral')->getFormatNumber($character->vitality) ?></span></p>
                <p>Energia: <span><?= resolve('Geral')->getFormatNumber($character->energy) ?></span></p>
                <?php if ($character->class == 64 || $character->class == 65): ?>
                    <p>Comando: <span><?= resolve('Geral')->getFormatNumber($character->leadership) ?></span></p>
                <?php endif; ?>
                <p>Localização: <span><?php 
                    $map = resolve('Geral')->getMap($character->mapnumber ?? 0);
                    echo isset($map->name) ? $map->name : 'Mapa Desconhecido';
                ?> (x: <?= $character->mapposx ?? 0 ?>, y: <?= $character->mapposy ?? 0 ?>)</span></p>
            </div>
        </div>
    </div>
</div>