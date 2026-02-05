<?= $this->layout('components/layouts/web') ?>

<?php
$geral = resolve('Geral');
$classInfo = $geral->getClass($character->class);
$mapInfo = $geral->getMap($character->mapnumber ?? 0);
$isOnline = ($character->status == 1 && $character->name == $character->gameidc);
?>

<div class="profile-container space-y-3">
    <div class="profile-hero card">
        <div class="profile-bg-glow"></div>
        <div class="profile-header-content">
            <div class="profile-avatar-wrapper">
                <img src="<?= $geral->getAvatar($character->avatar) ?>" alt="<?= $character->name ?>"
                    class="profile-avatar">
                <div class="status-badge <?= $isOnline ? 'online' : 'offline' ?>">
                    <i class="ph-fill ph-circle"></i>
                    <?= $isOnline ? __("profile.status_online") : __("profile.status_offline") ?>
                </div>
            </div>

            <div class="profile-main-info">
                <div class="char-name-row">
                    <h1 class="char-name"><?= $character->name ?></h1>
                </div>
                <div class="char-class-badge">
                    <i class="ph ph-shield"></i>
                    <?= $classInfo->name ?>
                </div>
            </div>

            <div class="guild-info-card <?= !$character->guild ? 'no-guild' : '' ?>">
                <?php if ($character->guild): ?>
                    <?php
                    $guildRankName = __("profile.guild_member");
                    switch ($character->guild_rank ?? 0) {
                        case 128: $guildRankName = __("profile.guild_master"); break;
                        case 64: $guildRankName = __("profile.guild_assistant"); break;
                        case 32: $guildRankName = __("profile.guild_battle_master"); break;
                    }
                    ?>
                    <div class="guild-mark-wrapper">
                        <?= resolve('Guild')->getRender($character->guild_mark, 64) ?>
                    </div>
                    <div class="guild-details">
                        <a href="<?= route("profile.guild.$character->guild") ?>" class="guild-name"><?= $character->guild ?></a>
                        <span class="guild-rank-badge"><?= $guildRankName ?></span>
                    </div>
                <?php else: ?>
                    <div class="guild-mark-wrapper" style="opacity: 0.2">
                        <i class="ph-fill ph-shield" style="font-size: 24px;"></i>
                    </div>
                    <div class="guild-details" style="opacity: 0.2">
                        <span class="guild-name"><?= __("profile.guild_name") ?></span>
                        <span class="guild-rank-badge"><?= __("profile.no_rank") ?></span>
                    </div>
                    <div class="no-guild-overlay"><?= __("profile.no_guild") ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon resets"><i class="ph-fill ph-arrows-counter-clockwise"></i></div>
            <div class="stat-data">
                <span class="label"><?= __("profile.stat_resets") ?></span>
                <span class="value"><?= number_format($character->resets ?? 0, 0, ',', '.') ?></span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon m-resets"><i class="ph-fill ph-crown"></i></div>
            <div class="stat-data">
                <span class="label"><?= __("profile.stat_m_resets") ?></span>
                <span class="value"><?= number_format($character->master_resets ?? 0, 0, ',', '.') ?></span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon level"><i class="ph-fill ph-chart-line-up"></i></div>
            <div class="stat-data">
                <span class="label"><?= __("profile.stat_level") ?></span>
                <span class="value"><?= $character->level ?></span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pk"><i class="ph-fill ph-skull"></i></div>
            <div class="stat-data">
                <span class="label"><?= __("profile.stat_pk_kills") ?></span>
                <span class="value text-danger"><?= number_format($character->pk ?? 0, 0, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <?php
    use Source\Support\ItemDecoder;
    $equipped = $equipped ?? ItemDecoder::getEquippedItems($character->inventory ?? '');
    
    // Helper para renderizar slot
    function renderSlot($slotKey, $slotName, $icon, $equipped, $size = 'normal') {
        $item = $equipped[$slotKey] ?? null;
        $sizeClass = $size === 'large' ? 'slot-large' : ($size === 'small' ? 'slot-small' : 'slot-normal');
        ?>
        <div class="equipment-slot <?= $item ? 'has-item' : 'empty' ?> <?= $sizeClass ?>" 
             data-slot="<?= $slotKey ?>"
             <?php if ($item): ?>
             data-item-name="<?= ItemDecoder::getItemName($item['index'], $item['level'], $item['slot_id'] ?? -1) ?>"
             data-item-level="+<?= $item['level'] ?>"
             data-item-option="<?= $item['option'] ?>"
             data-item-luck="<?= $item['luck'] ? __("profile.yes") : __("profile.no") ?>"
             data-item-skill="<?= $item['skill'] ? __("profile.yes") : __("profile.no") ?>"
             data-item-excellent="<?= $item['excellent'] ?>"
             <?php endif; ?>
        >
            <?php if ($item): ?>
                <div class="item-icon" style="background-image: url('<?= ItemDecoder::getItemImage($item['index']) ?>')">
                    <?php if ($item['level'] > 0): ?>
                        <span class="item-level">+<?= $item['level'] ?></span>
                    <?php endif; ?>
                    <?php if ($item['excellent'] > 0): ?>
                        <span class="item-excellent"><i class="ph-fill ph-star"></i></span>
                    <?php endif; ?>
                </div>

                <?php
                $hasExc = $item['excellent'] > 0;
                $hasAnc = $item['ancient'] > 0;
                $itemName = ($hasExc ? 'Excellent ' : '') . ItemDecoder::getItemName($item['index'], 0, $item['slot_id'] ?? -1);
                ?>
                <div class="item-tooltip">
                    <div class="tooltip-img" style="background-image: url('<?= ItemDecoder::getItemImage($item['index']) ?>')"></div>
                    <div class="tooltip-header <?= $hasExc ? 'excellent' : '' ?> <?= $hasAnc ? 'ancient' : '' ?>">
                        <?= $itemName ?><?php if ($item['level'] > 0): ?> +<?= $item['level'] ?><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
    ?>

    <div class="profile-main-grid">
        <div class="card equipment-card">
            <div class="card-header">
                <h2><i class="ph ph-backpack"></i> <?= __("profile.equipment") ?></h2>
                <span class="char-zen-badge"><i class="ph-fill ph-coins"></i> <strong><?= number_format($character->money ?? 0, 0, ',', '.') ?> Zen</strong></span>
            </div>
            
            <div class="equipment-grid">
                <?php renderSlot('pet', __("profile.slot_pet"), 'ph-dog', $equipped, 'large'); ?>
                <?php renderSlot('pendant', __("profile.slot_pendant"), 'ph-diamond', $equipped, 'small'); ?>
                <?php renderSlot('helm', __("profile.slot_helm"), 'ph-baseball-cap', $equipped, 'large'); ?>
                <div class="slot-spacer-small"></div>
                <?php renderSlot('wings', __("profile.slot_wings"), 'ph-bird', $equipped, 'large'); ?>

                <?php renderSlot('weapon_right', __("profile.slot_weapon"), 'ph-sword', $equipped, 'large'); ?>
                <?php renderSlot('ring_right', __("profile.slot_ring"), 'ph-ring', $equipped, 'small'); ?>
                <?php renderSlot('armor', __("profile.slot_armor"), 'ph-shield', $equipped, 'large'); ?>
                <?php renderSlot('ring_left', __("profile.slot_ring"), 'ph-ring', $equipped, 'small'); ?>
                <?php renderSlot('weapon_left', __("profile.slot_shield"), 'ph-shield-check', $equipped, 'large'); ?>

                <?php renderSlot('gloves', __("profile.slot_gloves"), 'ph-hand-fist', $equipped, 'large'); ?>
                <div class="slot-spacer-small"></div>
                <?php renderSlot('pants', __("profile.slot_pants"), 'ph-pants', $equipped, 'large'); ?>
                <div class="slot-spacer-small"></div>
                <?php renderSlot('boots', __("profile.slot_boots"), 'ph-sneaker', $equipped, 'large'); ?>
            </div>
        </div>

        <div class="card detail-card">
            <div class="card-header">
                <h2><i class="ph ph-sword"></i> <?= __("profile.attributes_base") ?></h2>
            </div>
            <div class="attributes-list">
                <div class="attr-item">
                    <div class="attr-label">
                        <span><?= __("profile.attr_strength") ?></span>
                        <strong><?= number_format($character->strength, 0, ',', '.') ?></strong>
                    </div>
                    <div class="attr-bar-bg">
                        <div class="attr-bar fill-red"
                            style="width: min(100%, <?= ($character->strength / 32767) * 100 ?>%)"></div>
                    </div>
                </div>
                <div class="attr-item">
                    <div class="attr-label">
                        <span><?= __("profile.attr_agility") ?></span>
                        <strong><?= number_format($character->dexterity, 0, ',', '.') ?></strong>
                    </div>
                    <div class="attr-bar-bg">
                        <div class="attr-bar fill-green"
                            style="width: min(100%, <?= ($character->dexterity / 32767) * 100 ?>%)"></div>
                    </div>
                </div>
                <div class="attr-item">
                    <div class="attr-label">
                        <span><?= __("profile.attr_vitality") ?></span>
                        <strong><?= number_format($character->vitality, 0, ',', '.') ?></strong>
                    </div>
                    <div class="attr-bar-bg">
                        <div class="attr-bar fill-blue"
                            style="width: min(100%, <?= ($character->vitality / 32767) * 100 ?>%)"></div>
                    </div>
                </div>
                <div class="attr-item">
                    <div class="attr-label">
                        <span><?= __("profile.attr_energy") ?></span>
                        <strong><?= number_format($character->energy, 0, ',', '.') ?></strong>
                    </div>
                    <div class="attr-bar-bg">
                        <div class="attr-bar fill-purple"
                            style="width: min(100%, <?= ($character->energy / 32767) * 100 ?>%)"></div>
                    </div>
                </div>
                <?php if ($character->class == 64 || $character->class == 65): ?>
                    <div class="attr-item">
                        <div class="attr-label">
                            <span><?= __("profile.attr_leadership") ?></span>
                            <strong><?= number_format($character->leadership, 0, ',', '.') ?></strong>
                        </div>
                        <div class="attr-bar-bg">
                            <div class="attr-bar fill-yellow"
                                style="width: min(100%, <?= ($character->leadership / 32767) * 100 ?>%)"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card detail-card">
            <div class="card-header">
                <h2><i class="ph ph-map-pin"></i> <?= __("profile.location") ?></h2>
            </div>
            <div class="location-info">
                <div class="map-preview">
                    <i class="ph ph-compass"></i>
                    <div class="map-name"><?= $mapInfo->name ?? __("profile.map_unknown") ?></div>
                    <div class="coords">X: <?= $character->mapposx ?? 0 ?> &bull; Y: <?= $character->mapposy ?? 0 ?>
                    </div>
                </div>

                <div class="info-table">
                    <div class="info-row">
                        <span class="info-label"><?= __("profile.account_status") ?></span>
                        <span class="info-value text-success"><?= __("profile.account_active") ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?= __("profile.last_login") ?></span>
                        <span class="info-value"><?= $isOnline ? __("profile.now") : __("profile.recently") ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-hero {
        position: relative;
        padding: 2.5rem !important;
        overflow: hidden;
        background: linear-gradient(135deg, var(--background-card) 0%, #1a1617 100%) !important;
    }

    .profile-bg-glow {
        position: absolute;
        top: -20%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(192, 34, 34, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .profile-header-content {
        position: relative;
        display: flex;
        align-items: center;
        gap: 2rem;
        z-index: 2;
    }

    .profile-avatar-wrapper {
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 16px;
        border: 3px solid var(--neutral-300);
        object-fit: cover;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    }

    .status-badge {
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 4px;
        border: 2px solid var(--background-card);
    }

    .status-badge.online {
        background: #28a745;
        color: white;
    }

    .status-badge.offline {
        background: #6c757d;
        color: white;
    }

    .status-badge i {
        font-size: 8px;
    }

    .char-name {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary, #fff);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .char-name-row {
        display: flex;
        align-items: baseline;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    /* Guild Info Card in Header */
    .guild-info-card {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(0, 0, 0, 0.4);
        padding: 8px 16px 8px 8px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        position: relative; /* Ensure overlay positioning */
    }

    .guild-info-card.no-guild {
        cursor: default;
    }

    .no-guild-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 800;
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-radius: 12px;
        z-index: 10;
    }

    .guild-mark-wrapper {
        width: 64px;
        height: 64px;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .guild-mark-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: pixelated;
    }

    .guild-details {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .guild-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-primary, #fff);
        text-decoration: none;
        transition: color 0.2s;
    }

    .guild-name:hover {
        color: var(--red-100);
    }

    .guild-rank-badge {
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--red-100);
        background: rgba(192, 34, 34, 0.1);
        padding: 2px 6px;
        border-radius: 4px;
        align-self: flex-start;
        margin-top: 2px;
    }

    @media (max-width: 768px) {
        .profile-header-content {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }

        .guild-info-card {
            margin-left: 0;
            width: 100%;
            justify-content: center;
        }
    }

    .char-class-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: var(--red-100);
        color: white;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .stat-card {
        background: var(--background-card);
        border: 1px solid var(--neutral-300);
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.resets {
        background: rgba(37, 99, 235, 0.1);
        color: #3b82f6;
    }

    .stat-icon.m-resets {
        background: rgba(251, 191, 36, 0.1);
        color: #fbbf24;
    }

    .stat-icon.level {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .stat-icon.pk {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .stat-data .label {
        display: block;
        font-size: 11px;
        color: var(--neutral-100);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .stat-data .value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-primary, #0f172a);
    }

    /* Main Profile Grid (Equipment, Attributes, Location) */
    .profile-main-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 1200px) {
        .profile-main-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Restored Styles for Detail Cards */
    .detail-card h2 {
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .attributes-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .attr-item .attr-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 13px;
    }

    .attr-item .attr-label span {
        color: var(--neutral-50);
    }

    .attr-item .attr-label strong {
        color: var(--text-primary, #0f172a);
    }

    .attr-bar-bg {
        height: 6px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 3px;
        overflow: hidden;
    }

    .attr-bar {
        height: 100%;
        border-radius: 3px;
    }

    .fill-red {
        background: #ef4444;
        box-shadow: 0 0 5px rgba(239, 68, 68, 0.3);
    }

    .fill-green {
        background: #10b981;
        box-shadow: 0 0 5px rgba(16, 185, 129, 0.3);
    }

    .fill-blue {
        background: #3b82f6;
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.3);
    }

    .fill-purple {
        background: #a855f7;
        box-shadow: 0 0 5px rgba(168, 85, 247, 0.3);
    }

    .fill-yellow {
        background: #f59e0b;
        box-shadow: 0 0 5px rgba(245, 158, 11, 0.3);
    }

    /* Location Card */
    .map-preview {
        background: rgba(255, 255, 255, 0.02);
        border: 1px dashed var(--neutral-300);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .map-preview i {
        font-size: 3rem;
        color: var(--red-100);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .map-preview .map-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    .map-preview .coords {
        color: var(--neutral-100);
        font-size: 13px;
        margin-top: 4px;
    }

    .info-table {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        font-size: 13px;
    }

    .info-label {
        color: var(--neutral-100);
    }

    .info-value {
        color: var(--text-primary, #0f172a);
        font-weight: 600;
    }

    /* Equipment Section */
    .equipment-card {
        margin-bottom: 0;
        height: 100%;
    }

    .equipment-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .char-zen-badge {
        font-size: 13px;
        color: #fbbf24;
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(251, 191, 36, 0.1);
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .char-zen-badge strong {
        font-size: 14px;
        font-weight: 800;
    }

    /* Novo Layout - Grid 5 Colunas (3 Grandes + 2 Pequenas intermediárias) */
    .equipment-grid {
        display: grid;
        grid-template-columns: 80px 50px 80px 50px 80px;
        gap: 15px;
        justify-content: center;
        margin: 0 auto;
        padding: 20px;
    }

    /* Remove obsolete .eq-col and .eq-row */
    
    .slot-spacer-small {
        width: 50px;
        height: 50px;
    }

    .equipment-slot {
        background: var(--background-sub-card);
        border: 2px solid var(--neutral-300);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.2s;
        cursor: pointer;
        flex-shrink: 0;
    }

    /* Tamanhos dos slots */
    .slot-large {
        width: 80px;
        height: 80px;
    }

    .slot-normal {
        width: 65px;
        height: 65px;
    }

    .slot-small {
        width: 50px;
        height: 50px;
    }

    .equipment-slot.empty {
        border-style: dashed;
        opacity: 0.5;
    }

    .equipment-slot.has-item {
        border-color: var(--red-100);
        background: linear-gradient(135deg, rgba(192, 34, 34, 0.1) 0%, transparent 100%);
    }

    .equipment-slot.has-item:hover {
        transform: scale(1.08);
        border-color: #fbbf24;
        box-shadow: 0 0 15px rgba(251, 191, 36, 0.3);
        z-index: 10;
    }

    .empty-slot-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        color: var(--neutral-100);
    }

    .slot-large .empty-slot-icon i {
        font-size: 32px;
    }

    .slot-normal .empty-slot-icon i {
        font-size: 24px;
    }

    .slot-small .empty-slot-icon i {
        font-size: 20px;
    }

    .empty-slot-icon span {
        font-size: 9px;
        text-align: center;
        line-height: 1.1;
    }

    .item-icon {
        width: 100%;
        height: 100%;
        background-size: 115%;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    .item-level {
        position: absolute;
        bottom: 2px;
        right: 2px;
        background: rgba(0, 0, 0, 0.9);
        color: #10b981;
        font-size: 10px;
        font-weight: 800;
        padding: 1px 4px;
        border-radius: 3px;
        line-height: 1;
    }

    .item-excellent {
        position: absolute;
        top: 2px;
        right: 2px;
        color: #fbbf24;
        font-size: 12px;
        filter: drop-shadow(0 0 3px rgba(251, 191, 36, 0.8));
    }

    /* Tooltip - layout limpo sem ícones */
    .item-tooltip {
        position: absolute;
        bottom: 110%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(30, 26, 22, 0.98);
        border: 1px solid #4a3f35;
        border-radius: 6px;
        padding: 0;
        min-width: 220px;
        max-width: 260px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        z-index: 100;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
    }

    .equipment-slot:hover .item-tooltip {
        opacity: 1;
    }

    .tooltip-img {
        width: 64px;
        height: 64px;
        margin: 10px auto 6px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .tooltip-header {
        font-weight: 700;
        font-size: 12px;
        color: #d4a855;
        text-align: center;
        padding: 0 12px 10px;
        border-bottom: 1px solid #3d3530;
    }

    .tooltip-header.excellent {
        color: #e8b84a;
    }

    .tooltip-header.ancient {
        color: #5eb8d4;
    }

    .tooltip-body {
        padding: 10px 12px 12px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .tooltip-line {
        font-size: 11px;
        color: #e8e4e0;
        line-height: 1.4;
    }

    .tooltip-line.option {
        color: #e879b0;
    }

    .tooltip-line.ancient {
        color: #5eb8d4;
    }

    .tooltip-line.luck {
        color: #5eb8d4;
    }

    .tooltip-line.skill {
        color: #5eb8d4;
    }

    .tooltip-line.killcount {
        color: #a78bfa;
    }

    @media (max-width: 768px) {
        .equipment-grid {
            transform: scale(0.85);
            gap: 10px;
        }
    }

    @media (max-width: 480px) {
        .equipment-grid {
            transform: scale(0.65);
            width: 120%; /* Compensate for scale causing left alignment */
            margin-left: -10%;
        }
    }
</style>