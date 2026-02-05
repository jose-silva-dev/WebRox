<?= $this->layout('components/layouts/web') ?>

<?php
$selectedClass = $selectedClass ?? null;
$this->insert('plugins/hallfame/geral/partials/select-ranking', [
    'selectedSlug' => $selectedSlug ?? null,
    'selectedTop' => $selectedTop ?? null,
    'selectedClass' => $selectedClass
]);
?>

<section class="rankings-results">
    <header class="rankings-results-header">
        <h2 class="rankings-results-title"><?= __("plugin.rankings.top") ?> <?= (int) $ranking['top'] ?> – <?= htmlspecialchars($ranking['title']) ?></h2>
    </header>

    <div class="rankings-list rankings-list--hallfame">
        <?php if (!empty($ranking['data']) && $ranking['type'] === 'character'): ?>
            <div class="ranking-row-header ranking-row-header--hallfame">
                <span class="ranking-col ranking-col-pos">#</span>
                <span class="ranking-col ranking-col-avatar"></span>
                <span class="ranking-col ranking-col-info"><?= __("rankings.character") ?></span>
                <span class="ranking-col ranking-col-score"><?= __("rankings.pts") ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($ranking['data'])): $count = 0; ?>
            <?php foreach ($ranking['data'] as $data): $count++; ?>
                <?= $this->insert('components/web/hallfame/box-character', [
                    'ranking'    => $data,
                    'type'       => $ranking['type'],
                    'position'   => $count,
                    'is_hallfame' => true,
                ]) ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="rankings-empty">
                <i class="ph ph-trophy"></i>
                <p><?= __("rankings.no_players") ?></p>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($ranking['cache_info'])): ?>
        <div class="rankings-cache-info">
            <span><?= __("common.updated_at", ['date' => date('d/m/Y', $ranking['cache_info']['created_at']), 'time' => date('H:i', $ranking['cache_info']['created_at'])]) ?></span>
            <span>·</span>
            <span><?= __("common.cache_minutes", ['min' => (int) $ranking['cache_info']['interval_minutes']]) ?></span>
        </div>
    <?php endif; ?>
</section>
