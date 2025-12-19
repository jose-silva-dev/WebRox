<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Meus Personagens
</div>

<div class="user-characters">
    <?php if (!$characters): ?>
        <p class="warning">Nenhum personagem encontrado.</p>
    <?php else: ?>
        <?php foreach ($characters as $character): ?>
            <?= $this->insert('components/web/user/box-select-char', [
                'character' => $character,
            ]) ?>
        <?php endforeach; ?>
    <?php endif; ?>

</div>