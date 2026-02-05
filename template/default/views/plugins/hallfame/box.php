<?php if (!empty($rankings)): ?>

<div class="hall-tabs">
    <?php foreach ($rankings as $i => $ranking): ?>
        <button
            class="<?= $i === 0 ? 'active' : '' ?>"
            data-tab="<?= $ranking['tag'] ?>">
            <?= strtoupper($ranking['title']) ?>
        </button>
    <?php endforeach; ?>
</div>

<?php foreach ($rankings as $i => $ranking): ?>
    <div class="hall-tab <?= $i === 0 ? 'active' : '' ?>" id="<?= $ranking['tag'] ?>">

        <div class="rakings">
            <?php if (!empty($ranking['data'])): ?>
                <?php 
                    $topCount = (int)($ranking['top_count'] ?? 3);
                    if ($topCount < 1) $topCount = 1;
                    if ($topCount > 10) $topCount = 10;
                    
                    // Limitar os dados apenas ao top_count configurado
                    $topPlayers = array_slice($ranking['data'], 0, $topCount);
                ?>

                <?php if (!empty($topPlayers)): ?>
                    <div class="hall-top1" data-count="<?= count($topPlayers) ?>">
                        <?php 
                        $pos = 1;
                        foreach ($topPlayers as $player): 
                            // Apenas o primeiro lugar tem o estilo especial (isTop1 = true)
                            // Os demais no topo também aparecem destacados na div .hall-top1
                            $isTop1 = ($pos === 1);
                        ?>
                            <?= $this->insert('components/web/hallfame/box-character', [
                                'ranking'     => $player,
                                'type'        => $ranking['type'],
                                'position'    => $pos++,
                                'isTop1'      => $isTop1,
                                'is_hallfame' => true,
                            ]) ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="warning">
                    <?= __("rankings.no_players") ?>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($ranking['cache_info'])): ?>
            <div style="text-align: center; margin-top: 1rem; padding: 0.75rem; background: var(--background-card); border-radius: 8px; border: 1px solid var(--neutral-300);">
                <p style="color: var(--neutral-50); font-size: 11px; margin: 0;">
                    <?= __("common.generated_at", ['date' => date('d/m/Y', $ranking['cache_info']['created_at']), 'time' => date('H:i', $ranking['cache_info']['created_at'])]) ?> 
                    (<?= __("common.interval_minutes", ['min' => $ranking['cache_info']['interval_minutes']]) ?>)
                </p>
            </div>
        <?php endif; ?>

    </div>
<?php endforeach; ?>

<?php else: ?>
    <div class="warning">
        <?= __("rankings.no_configured") ?>
    </div>
<?php endif; ?>
