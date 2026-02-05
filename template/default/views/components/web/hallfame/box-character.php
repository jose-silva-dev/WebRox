<?php
$topClass = '';
if ($position === 1) $topClass = 'top-1';
elseif ($position === 2) $topClass = 'top-2';
elseif ($position === 3) $topClass = 'top-3';
$isHallfame = !empty($is_hallfame);
$isOnline = isset($ranking->is_online) && $ranking->is_online;
$guildName = $ranking->guild_name ?? null;
$guildMark = $ranking->guild_mark ?? null;
$mapName = $ranking->map_name ?? null;
?>
<a href="<?= route("profile.$type.$ranking->name") ?>" class="ranking-character-box <?= $topClass ?> <?= $isHallfame ? 'ranking-character-box--hallfame' : '' ?>">
    <div class="ranking-col ranking-col-pos">
        <div class="pos"><?= $position ?></div>
    </div>

    <?php if (!$isHallfame): ?>
    <div class="ranking-col ranking-col-dot">
        <?php if ($type === 'character' && isset($ranking->is_online)): ?>
            <span class="ranking-status-dot <?= $isOnline ? 'ranking-status--online' : 'ranking-status--offline' ?>" title="<?= $isOnline ? __("common.online") : __("common.offline") ?>"></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="ranking-col ranking-col-avatar">
        <?php if ($type == 'guild'): ?>
            <?= resolve('Guild')->getRender($ranking->mark, 40) ?>
        <?php else: ?>
            <div class="ranking-avatar-wrap">
                <img src="<?= resolve('Geral')->getAvatar($ranking->avatar) ?>" alt="" class="ranking-avatar ranking-avatar-round">
            </div>
        <?php endif; ?>
    </div>

    <div class="ranking-col ranking-col-info">
        <span class="name"><?= htmlspecialchars($ranking->name) ?></span>
        <?php if (isset($ranking->class_name)): ?>
            <span class="ranking-class"><?= htmlspecialchars($ranking->class_name) ?></span>
        <?php endif; ?>
    </div>

    <?php if (!$isHallfame): ?>
    <div class="ranking-col ranking-col-guild">
        <?php if ($type === 'character' && !empty($guildName)): ?>
            <span class="ranking-guild-row">
                <?php if (!empty($guildMark)): ?>
                    <span class="ranking-guild-mark"><?= resolve('Guild')->getRender($guildMark, 24) ?></span>
                <?php endif; ?>
                <span class="ranking-guild-name"><?= htmlspecialchars($guildName) ?></span>
            </span>
        <?php else: ?>
            <span class="ranking-guild-empty">SEM GUILD</span>
        <?php endif; ?>
    </div>

    <?php if ($type === 'character'): ?>
        <div class="ranking-col ranking-col-location" title="<?= htmlspecialchars($mapName ?? '') ?>">
            <?php if (!empty($mapName)): ?>
                <i class="ph ph-map-pin"></i>
                <span><?= htmlspecialchars($mapName) ?></span>
            <?php else: ?>
                <span>–</span>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="ranking-col ranking-col-location"></div>
    <?php endif; ?>
    <?php endif; ?>

    <div class="ranking-col ranking-col-score">
        <span class="ranking-stats"><?= number_format($ranking->score ?? 0, 0, ',', '.') ?></span>
    </div>
</a>
