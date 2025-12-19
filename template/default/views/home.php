<?= $this->layout('components/layouts/web') ?>

<?= $this->insert('plugins/slider/index', ['sliders' => $sliders]) ?>

<div class="space-y-1">
    <div class="web-title">
        Top Jogadores
    </div>
    <?= $this->insert('plugins/hallfame/box', ['rankings' => $rankings]) ?>
</div>

<div class="space-y-1">
    <div class="web-title">
        Últimas Notícias...
    </div>
    <?= $this->insert('plugins/notice/home', ['notices' => $notices]) ?>
</div>