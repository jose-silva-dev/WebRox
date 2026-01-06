<?= $this->layout('components/layouts/web') ?>

<?php 
$selectedClass = $selectedClass ?? null;
$this->insert('plugins/hallfame/geral/partials/select-ranking', [
    'selectedSlug' => $selectedSlug ?? null,
    'selectedTop' => $selectedTop ?? null,
    'selectedClass' => $selectedClass
]);
?>

<div>
    <h2 class="web-title">Top <?= $ranking['top'] ?> - <?= $ranking['title'] ?></h2>
</div>

<div class="rakings">
    <div class="characters">
        <?php if (!empty($ranking['data'])): $count = 0; ?>
            <?php foreach ($ranking['data'] as $data): $count++ ?>
                <?= $this->insert('components/web/hallfame/box-character', [
                    'ranking'  => $data,
                    'type'     => $ranking['type'],
                    'position' => $count,
                ]) ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="warning" style="grid-column: 1 / -1;">
                Nenhum jogador encontrado neste ranking
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($ranking['cache_info'])): ?>
    <div style="text-align: center; margin-top: 1.5rem; padding: 1rem; background: var(--background-card); border-radius: 8px; border: 1px solid var(--neutral-300);">
        <p style="color: var(--neutral-50); font-size: 12px; margin: 0;">
            Gerado em <?= date('d/m/Y', $ranking['cache_info']['created_at']) ?> às <?= date('H:i', $ranking['cache_info']['created_at']) ?> 
            (intervalo de <?= $ranking['cache_info']['interval_minutes'] ?> minutos)
        </p>
    </div>
<?php endif; ?>