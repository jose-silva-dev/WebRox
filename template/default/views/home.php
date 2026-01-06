<?= $this->layout('components/layouts/web') ?>

<?php if (!empty($sliderPluginEnabled) && !empty($sliders)): ?>
    <?= $this->insert('plugins/slider/index', ['sliders' => $sliders]) ?>
<?php endif; ?>

<?php if (!empty($hallfamePluginEnabled) && !empty($rankings)): ?>
<div class="space-y-1">
    <div class="web-title">
        Hall da Fama 👑
    </div>
    <?= $this->insert('plugins/hallfame/box', ['rankings' => $rankings]) ?>
</div>
<?php endif; ?>

<?php if (!empty($castlesiegePluginEnabled) && $castle !== null): ?>
<div class="space-y-1">
    <div class="web-title">
        Castle Siege
    </div>

    <?= $this->insert('plugins/castlesiege/box', [
        'castle' => $castle
    ]) ?>
</div>
<?php endif; ?>

<?php if (!empty($noticePluginEnabled) && !empty($notices)): ?>
<div class="space-y-1">
    <div class="web-title">
        Últimas Notícias..
    </div>
    <?= $this->insert('plugins/notice/home', ['notices' => $notices]) ?>
</div>
<?php endif; ?>