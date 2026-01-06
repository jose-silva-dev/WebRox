<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Informação: <span><?= e($character->name) ?></span>
</div>

<div class="character-info space-y-1">
    <?= $this->insert('components/web/user/avatar-box', ['character' => $character]) ?>
    <?= $this->insert('user/character/partials/menu', ['character' => $character]) ?>

    <table class="table">
        <tbody>
            <tr>
                <td>Força:</td>
                <td><?= resolve('Geral')->getFormatNumber($character->strength) ?></td>
            </tr>
            <tr>
                <td>Agilidade:</td>
                <td><?= resolve('Geral')->getFormatNumber($character->dexterity) ?></td>
            </tr>
            <tr>
                <td>Vitalidade:</td>
                <td><?= resolve('Geral')->getFormatNumber($character->vitality) ?></td>
            </tr>
            <tr>
                <td> Energia:</td>
                <td><?= resolve('Geral')->getFormatNumber($character->energy) ?></td>
            </tr>
            <?php if ($character->class == 64 || $character->class == 65): ?>
                <tr>
                    <td>Comando:</td>
                    <td><?= resolve('Geral')->getFormatNumber($character->leadership) ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>Classe:</td>
                <td><?= resolve('Geral')->getClass($character->class)->name ?></td>
            </tr>
            <tr>
                <td>Mapa:</td>
                <td><?= resolve('Geral')->getMap($character->mapnumber)->name ?> (x: <?= $character->mapposx ?>, y: <?= $character->mapposy ?>)</td>
            </tr>
            <tr>
                <td>Level:</td>
                <td><?= resolve('Geral')->getFormatNumber($character->level) ?></td>
            </tr>
        </tbody>
    </table>
</div>