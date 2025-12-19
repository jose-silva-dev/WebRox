<?= $this->layout('components/layouts/web') ?>

<?= $this->insert('plugins/hallfame/geral/partials/select-ranking') ?>

<div>
    <h2 class="web-title">Top <?= $ranking['top'] ?> - <?= $ranking['title'] ?></h2>
</div>

<div class="rakings">
    <div class="characters">
        <?php if ($ranking['data']): $count = 0; ?>
            <?php foreach ($ranking['data'] as $data): $count++ ?>
                <?= $this->insert('components/web/hallfame/box-character', [
                    'ranking'  => $data,
                    'type'     => $ranking['type'],
                    'position' => $count,
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>