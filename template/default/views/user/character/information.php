<?= $this->layout('components/layouts/web') ?>

<?php
$geral = resolve('Geral');
$classInfo = $geral->getClass($character->class);
$mapInfo = $geral->getMap($character->mapnumber ?? 0);

// No user panel, we usually don't need "Online" badge in the same way, 
// but for unity we can check if it's the gameidc
$isOnline = ($character->status == 1 && $character->name == ($character->gameidc ?? ''));
?>

<div class="profile-container space-y-3">
    <div class="page-top-actions">
        <a href="<?= route('user.characters') ?>" class="btn-back">
            <i class="ph ph-arrow-left"></i>
            <?= __("user.back") ?>
        </a>
    </div>

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
                <div class="char-badges">
                    <div class="char-class-badge">
                        <i class="ph-fill ph-shield"></i>
                        <?= $classInfo->name ?>
                    </div>
                </div>
            </div>

            <div class="guild-info-card <?= !($character->guild ?? null) ? 'no-guild' : '' ?>">
                <?php if ($character->guild ?? null): ?>
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
                        <span class="guild-name"><?= $character->guild ?></span>
                        <span class="guild-rank-badge"><?= $guildRankName ?></span>
                    </div>
                <?php else: ?>
                    <div class="guild-mark-wrapper" style="opacity: 0.2">
                        <i class="ph-fill ph-shield" style="font-size: 32px;"></i>
                    </div>
                    <div class="guild-details" style="opacity: 0.2">
                        <span class="guild-name"><?= __("profile.no_guild") ?></span>
                        <span class="guild-rank-badge"><?= __("profile.none") ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="management-grid">
                <button type="button" class="manage-btn" onclick="openModal('modal-nick')">
                    <i class="ph-fill ph-identification-card"></i>
                    <span><?= __("char.change_nick") ?></span>
                </button>
                <button type="button" class="manage-btn" onclick="openModal('modal-avatar')">
                    <i class="ph-fill ph-user-circle-plus"></i>
                    <span><?= __("char.change_avatar") ?></span>
                </button>
                <button type="button" class="manage-btn" onclick="openModal('modal-map')">
                    <i class="ph-fill ph-compass-tool"></i>
                    <span><?= __("char.move_map") ?></span>
                </button>
                <button type="button" class="manage-btn" onclick="openModal('modal-classe')">
                    <i class="ph-fill ph-lightning"></i>
                    <span><?= __("char.change_class") ?></span>
                </button>
            </div>
        </div>
    </div>

    <div class="modals-container">
        <div id="modal-nick" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="ph-fill ph-identification-card"></i> <?= __("char.change_nick") ?></h3>
                    <button class="modal-close" onclick="closeModal('modal-nick')">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="<?= route("user.character.{$character->name}.nick.update") ?>" class="form-modern"
                        method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="nick"><?= __("char.new_nickname") ?></label>
                            <input type="text" id="nick" name="nick" required maxlength="10"
                                value="<?= $character->name ?>" placeholder="<?= __("char.placeholder_nick") ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('modal-nick')"><?= __("char.cancel") ?></button>
                            <button type="submit" class="btn btn-primary"><?= __("char.save_changes") ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modal-avatar" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="ph-fill ph-user-circle-plus"></i> <?= __("char.change_avatar") ?></h3>
                    <button class="modal-close" onclick="closeModal('modal-avatar')">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="<?= route("user.character.{$character->name}.avatar.update") ?>" class="form-modern"
                        method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="avatar"><?= __("char.select_image") ?></label>
                            <div class="file-upload-wrapper">
                                <input type="file" id="avatar" name="avatar" required accept="image/*">
                                <div class="file-upload-preview">
                                    <i class="ph ph-cloud-arrow-up"></i>
                                    <span><?= __("char.drag_image_here") ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('modal-avatar')"><?= __("char.cancel") ?></button>
                            <button type="submit" class="btn btn-primary"><?= __("char.update_avatar") ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modal-map" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="ph-fill ph-compass-tool"></i> <?= __("char.move_map") ?></h3>
                    <button class="modal-close" onclick="closeModal('modal-map')">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="<?= route("user.character.{$character->name}.map.update") ?>" class="form-modern"
                        method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="map"><?= __("char.destination") ?></label>
                            <select name="map" id="map" class="select-modern">
                                <?php foreach (resolve('Geral')->getMaps() as $mapnumber => $map): ?>
                                    <option value="<?= $mapnumber ?>" <?= $mapnumber == $character->mapnumber ? 'selected' : '' ?>><?= $map['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('modal-map')"><?= __("char.cancel") ?></button>
                            <button type="submit" class="btn btn-primary"><?= __("char.teleport") ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modal-classe" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="ph-fill ph-lightning"></i> <?= __("char.change_class") ?></h3>
                    <button class="modal-close" onclick="closeModal('modal-classe')">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="<?= route("user.character.{$character->name}.classe.update") ?>" class="form-modern"
                        method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="class"><?= __("char.new_class") ?></label>
                            <select name="class" id="class" class="select-modern">
                                <?php foreach (resolve('Geral')->getClasses() as $classnumber => $class): ?>
                                    <?php if (is_array($class) && isset($class['name'])): ?>
                                        <option value="<?= $classnumber ?>" <?= $classnumber == $character->class ? 'selected' : '' ?>><?= $class['name'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('modal-classe')"><?= __("char.cancel") ?></button>
                            <button type="submit" class="btn btn-primary"><?= __("char.confirm_class_change") ?></button>
                        </div>
                    </form>
                </div>
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
    // Decodificar equipamento
    use Source\Support\ItemDecoder;
    $equipped = ItemDecoder::getEquippedItems($character->inventory ?? '');
    
    // Helper para renderizar slot
    if (!function_exists('renderSlot')) {
        function renderSlot($slotKey, $slotName, $icon, $equipped, $size = 'normal') {
            $item = $equipped[$slotKey] ?? null;
            $sizeClass = $size === 'large' ? 'slot-large' : ($size === 'small' ? 'slot-small' : 'slot-normal');
            ?>
            <div class="equipment-slot <?= $item ? 'has-item' : 'empty' ?> <?= $sizeClass ?>" 
                 data-slot="<?= $slotKey ?>"
                 <?php if ($item): ?>
                 data-item-name="<?= htmlspecialchars(ItemDecoder::getItemName($item['index'], $item['level'], $item['slot_id'] ?? -1)) ?>"
                 data-item-level="+<?= $item['level'] ?>"
                 data-item-option="<?= $item['option'] ?>"
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
                    $hasAnc = $item['ancient'] ?? 0;
                    $itemName = ($hasExc ? 'Excellent ' : '') . ItemDecoder::getItemName($item['index'], 0, $item['slot_id'] ?? -1);
                    ?>
                    <div class="item-tooltip">
                        <div class="tooltip-img" style="background-image: url('<?= ItemDecoder::getItemImage($item['index']) ?>')"></div>
                        <div class="tooltip-header <?= $hasExc ? 'excellent' : '' ?> <?= $hasAnc ? 'ancient' : '' ?>">
                            <?= htmlspecialchars($itemName) ?><?php if ($item['level'] > 0): ?> +<?= $item['level'] ?><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
    }
    ?>

    <div class="profile-main-grid">
        <div class="card equipment-card">
            <div class="card-header">
                <h2><i class="ph ph-backpack"></i> <?= __("profile.equipment") ?></h2>
                <span class="char-zen-badge"><i class="ph-fill ph-coins"></i> <strong><?= number_format($character->money ?? 0, 0, ',', '.') ?> <?= __("profile.zen") ?></strong></span>
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
            </div>
        </div>
    </div>
</div>

<style>
    .page-top-actions {
        margin-bottom: 1rem;
    }

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
        color: white;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .char-name-row {
        display: flex;
        align-items: baseline;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    /* Guild Info Card Enhancement */
    .guild-info-card {
        margin-left: 2rem;
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(255, 255, 255, 0.03);
        padding: 12px 20px 12px 12px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
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
        image-rendering: pixelated;
    }

    .guild-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .guild-name {
        font-size: 1.4rem;
        font-weight: 900;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1;
    }

    .guild-rank-badge {
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 800;
        color: #4a9eff;
        background: rgba(74, 158, 255, 0.1);
        padding: 4px 8px;
        border-radius: 4px;
        align-self: flex-start;
    }

    /* Zen Badge */
    .char-badges {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .char-zen-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: rgba(251, 191, 36, 0.1);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.2);
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
    }

    /* Management Actions Grid (THE DIFFERENCE) */
    .management-grid {
        margin-left: auto;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .manage-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 12px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        color: #fff;
        transition: all 0.2s ease;
        min-width: 130px;
        cursor: pointer;
        font-family: inherit;
    }

    .manage-btn i {
        font-size: 20px;
        color: #4a9eff;
    }

    .manage-btn span {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .manage-btn:hover {
        background: rgba(74, 158, 255, 0.1);
        border-color: #4a9eff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 158, 255, 0.2);
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
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .stat-data .value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    /* Main Profile Grid */
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

    /* Attributes Section */
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
        color: white;
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

    .fill-red { background: #ef4444; }
    .fill-green { background: #10b981; }
    .fill-blue { background: #3b82f6; }
    .fill-purple { background: #a855f7; }
    .fill-yellow { background: #f59e0b; }

    /* Location Card */
    .map-preview {
        background: rgba(255, 255, 255, 0.02);
        border: 1px dashed var(--neutral-300);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
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
        color: var(--text-muted);
        font-size: 13px;
        margin-top: 4px;
    }

    /* Equipment Section */
    .equipment-grid {
        display: grid;
        grid-template-columns: 80px 50px 80px 50px 80px;
        gap: 15px;
        justify-content: center;
        padding: 20px;
    }

    .slot-spacer-small { width: 50px; height: 50px; }

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
    }

    .slot-large { width: 80px; height: 80px; }
    .slot-normal { width: 65px; height: 65px; }
    .slot-small { width: 50px; height: 50px; }

    .equipment-slot.empty { border-style: dashed; opacity: 0.5; }
    .equipment-slot.has-item {
        border-color: var(--red-100);
        background: linear-gradient(135deg, rgba(192, 34, 34, 0.1) 0%, transparent 100%);
    }

    .item-icon {
        width: 100%;
        height: 100%;
        background-size: 115%;
        background-position: center;
        background-repeat: no-repeat;
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
    }

    .item-excellent {
        position: absolute;
        top: 2px;
        right: 2px;
        color: #fbbf24;
    }

    .equipment-slot.has-item {
        position: relative;
    }
    .equipment-slot.has-item:hover {
        z-index: 10;
    }
    .item-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 8px;
        background: var(--bg-card, rgba(30, 26, 22, 0.98));
        border: 1px solid var(--border-color, #4a3f35);
        border-radius: 6px;
        padding: 0;
        min-width: 200px;
        max-width: 260px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        z-index: 100;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
    }
    .equipment-slot:hover .item-tooltip {
        opacity: 1;
    }
    .item-tooltip .tooltip-img {
        width: 64px;
        height: 64px;
        margin: 10px auto 6px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }
    .item-tooltip .tooltip-header {
        font-weight: 700;
        font-size: 12px;
        color: var(--text-primary);
        text-align: center;
        padding: 0 12px 10px;
        border-bottom: 1px solid var(--border-color);
    }
    .item-tooltip .tooltip-header.excellent {
        color: #e8b84a;
    }
    .item-tooltip .tooltip-header.ancient {
        color: #5eb8d4;
    }

    /* Modal: estilos de layout (tema vem do style.css global) */
    .form-modern { display: flex; flex-direction: column; gap: 20px; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px; }

    /* File Upload Styling */
    .file-upload-wrapper {
        position: relative; height: 120px; border: 2px dashed rgba(255, 255, 255, 0.1);
        border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .file-upload-wrapper input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
    .file-upload-preview { display: flex; flex-direction: column; align-items: center; gap: 10px; color: #888; }
    .file-upload-preview i { font-size: 32px; color: #4a9eff; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

    @media (max-width: 992px) {
        .management-grid { grid-template-columns: repeat(4, 1fr); margin-left: 0; width: 100%; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .profile-main-grid { grid-template-columns: 1fr; }
        .profile-header-content { flex-direction: column; text-align: center; }
        .guild-info-card { margin-left: 0; width: 100%; justify-content: center; }
    }
</style>

<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    window.onclick = function (event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    document.getElementById('avatar')?.addEventListener('change', function (e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const preview = this.nextElementSibling;
            preview.querySelector('span').innerText = fileName;
            preview.querySelector('i').className = 'ph ph-check-circle';
            preview.querySelector('i').style.color = '#10b981';
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.classList.remove('show');
            });
            document.body.style.overflow = 'auto';
        }
    });
</script>