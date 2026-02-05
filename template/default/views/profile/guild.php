<?= $this->layout('components/layouts/web') ?>

<?php
$geral = resolve('Geral');
$guildManager = resolve('Guild');
$guildModel = new \Source\Models\Guild();
?>

<div class="profile-container space-y-3">
    <div class="guild-header-section">
        <div class="card guild-main-card">
            <div class="guild-emblem-container">
                <?= $guildManager->getRender($guild->mark, 120) ?>
            </div>
            <div class="guild-title-section">
                <h1 class="guild-name"><?= htmlspecialchars($guild->name) ?></h1>
            </div>
        </div>

        <div class="guild-info-grid">
            <div class="card guild-info-card">
                <div class="info-card-icon">
                    <i class="ph-fill ph-shield-star"></i>
                </div>
                <div class="info-card-content">
                    <span class="info-card-label">Guild Master</span>
                    <a href="<?= route("profile.character.{$guild->owner}") ?>" class="info-card-value">
                        <?= htmlspecialchars($guild->owner) ?>
                    </a>
                </div>
            </div>

            <div class="card guild-info-card">
                <div class="info-card-icon">
                    <i class="ph-fill ph-users-three"></i>
                </div>
                <div class="info-card-content">
                    <span class="info-card-label">Guild Members</span>
                    <span class="info-card-value"><?= (int) $totalMembers ?></span>
                </div>
            </div>

            <div class="card guild-info-card">
                <div class="info-card-icon guild-rank-icon">
                    <i class="ph-fill ph-trophy"></i>
                </div>
                <div class="info-card-content">
                    <span class="info-card-label">Guild Rank</span>
                    <span class="info-card-value rank-value">#<?= (int) $rank ?></span>
                </div>
            </div>

            <div class="card guild-info-card">
                <div class="info-card-icon score-icon">
                    <i class="ph-fill ph-star"></i>
                </div>
                <div class="info-card-content">
                    <span class="info-card-label">Guild Score</span>
                    <span class="info-card-value score-value"><?= number_format($guild->score, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card detail-card">
        <div class="card-header">
            <h2><i class="ph ph-users"></i> Membros da Guilda</h2>
        </div>

        <div class="guild-members-table-wrapper">
            <?php if ($members && count($members) > 0): ?>
                <table class="guild-members-table">
                    <thead>
                        <tr>
                            <th class="col-pos">#</th>
                            <th class="col-online"></th>
                            <th class="col-class">Classe</th>
                            <th class="col-name">Personagem</th>
                            <th class="col-status">Status</th>
                            <th class="col-level">LVL</th>
                            <th class="col-ml">ML</th>
                            <th class="col-resets">Resets</th>
                            <th class="col-gr">GR</th>
                            <th class="col-location">Localização</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $position = 1;
                        foreach ($members as $member):
                            $mClass = $geral->getClass($member->class ?? 0);
                            $statusName = $guildModel->getGuildStatusName($member->status ?? 0);
                            $isOnline = !empty($member->online);
                            $mapObj = $geral->getMap($member->map ?? 0);
                            $mapName = $mapObj->name ?? 'Desconhecido';
                        ?>
                            <tr class="member-row <?= $isOnline ? 'online' : '' ?>">
                                <td class="col-pos"><?= $position++ ?></td>
                                <td class="col-online">
                                    <span class="status-indicator <?= $isOnline ? 'online' : 'offline' ?>" 
                                          title="<?= $isOnline ? 'Online' : 'Offline' ?>"></span>
                                </td>
                                <td class="col-class">
                                    <div class="class-info">
                                        <img src="<?= $geral->getAvatar($member->avatar ?? 0) ?>" 
                                             alt="<?= htmlspecialchars($mClass->name) ?>" 
                                             class="class-avatar"
                                             title="<?= htmlspecialchars($mClass->name) ?>">
                                        <span class="class-abbr"><?= htmlspecialchars($mClass->abbr ?? '') ?></span>
                                    </div>
                                </td>
                                <td class="col-name">
                                    <a href="<?= route("profile.character.{$member->name}") ?>" class="member-name-link">
                                        <?= htmlspecialchars($member->name) ?>
                                    </a>
                                </td>
                                <td class="col-status">
                                    <span class="guild-status <?= strtolower(str_replace(' ', '-', $statusName)) ?>">
                                        <?= htmlspecialchars($statusName) ?>
                                    </span>
                                </td>
                                <td class="col-level">
                                    <span class="level-value"><?= (int) ($member->level ?? 0) ?></span>
                                </td>
                                <td class="col-ml">
                                    <span class="ml-value"><?= isset($member->master_level) ? (int) $member->master_level : 0 ?></span>
                                </td>
                                <td class="col-resets">
                                    <span class="reset-value"><?= isset($member->resets) ? (int) $member->resets : 0 ?></span>
                                </td>
                                <td class="col-gr">
                                    <span class="gr-value"><?= isset($member->grand_resets) ? (int) $member->grand_resets : 0 ?></span>
                                </td>
                                <td class="col-location">
                                    <?php if ($isOnline): ?>
                                        <span class="location-name" title="<?= htmlspecialchars($mapName) ?>">
                                            <i class="ph ph-map-pin"></i>
                                            <?= htmlspecialchars($mapName) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="location-hidden" title="Offline">
                                            <i class="ph ph-eye-slash"></i>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="ph ph-users"></i>
                    <p>Nenhum membro encontrado nesta guilda.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Guild Header Section */
    .guild-header-section {
        display: grid;
        gap: 1rem;
        grid-template-columns: 1fr;
    }

    .guild-main-card {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(192, 34, 34, 0.1) 0%, rgba(15, 12, 13, 0.3) 100%);
        border: 1px solid var(--neutral-300);
    }

    .guild-emblem-container {
        flex-shrink: 0;
        background: rgba(255, 255, 255, 0.03);
        padding: 1.5rem;
        border-radius: 16px;
        border: 2px solid var(--neutral-300);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .guild-title-section {
        flex: 1;
    }

    .guild-name {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        margin: 0;
    }

    /* Guild Info Grid */
    .guild-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
    }

    .guild-info-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: var(--background-card);
        border: 1px solid var(--neutral-300);
        transition: all 0.3s ease;
    }

    .guild-info-card:hover {
        transform: translateY(-2px);
        border-color: var(--red-100);
        box-shadow: 0 8px 20px rgba(192, 34, 34, 0.2);
    }

    .info-card-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(192, 34, 34, 0.15);
        border-radius: 12px;
        font-size: 24px;
        color: var(--red-100);
        flex-shrink: 0;
    }

    .guild-rank-icon {
        background: rgba(251, 191, 36, 0.15);
        color: #fbbf24;
    }

    .score-icon {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }

    .info-card-content {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .info-card-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--neutral-100);
        letter-spacing: 0.5px;
    }

    .info-card-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-primary);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .info-card-value.rank-value {
        color: #fbbf24;
    }

    .info-card-value.score-value {
        color: #3b82f6;
    }

    .info-card-value:is(a) {
        transition: color 0.2s;
    }

    .info-card-value:is(a):hover {
        color: var(--red-100);
    }

    /* Members Table */
    .guild-members-table-wrapper {
        overflow-x: auto;
    }

    .guild-members-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .guild-members-table thead {
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 2px solid var(--neutral-300);
    }

    .guild-members-table th {
        padding: 12px 16px;
        text-align: left;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: var(--neutral-100);
        letter-spacing: 0.5px;
    }

    .guild-members-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--neutral-300);
    }

    .member-row {
        transition: background 0.2s;
    }

    .member-row:hover {
        background: rgba(192, 34, 34, 0.05);
    }

    .member-row.online {
        background: rgba(34, 197, 94, 0.02);
    }

    /* Column Specific Styles */
    .col-pos {
        width: 50px;
        text-align: center;
        font-weight: 700;
        color: var(--neutral-100);
    }

    .col-online {
        width: 40px;
        text-align: center;
    }

    .status-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--neutral-300);
    }

    .status-indicator.online {
        background: #22c55e;
        box-shadow: 0 0 8px rgba(34, 197, 94, 0.5);
    }

    .col-class {
        width: 100px;
    }

    .class-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .class-avatar {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid var(--neutral-300);
    }

    .class-abbr {
        font-weight: 700;
        color: var(--neutral-100);
        font-size: 12px;
    }

    .col-name {
        min-width: 150px;
    }

    .member-name-link {
        font-weight: 700;
        color: var(--text-primary);
        transition: color 0.2s;
    }

    .member-name-link:hover {
        color: var(--red-100);
    }

    .col-status {
        min-width: 180px;
    }

    .guild-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .guild-status.guild-master {
        background: rgba(251, 191, 36, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }

    .guild-status.assistant-guild-master {
        background: rgba(168, 85, 247, 0.15);
        color: #a855f7;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }

    .guild-status.battle-master {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .guild-status.guild-member {
        background: rgba(148, 163, 184, 0.15);
        color: #94a3b8;
        border: 1px solid rgba(148, 163, 184, 0.3);
    }

    .col-level,
    .col-ml,
    .col-resets,
    .col-gr {
        width: 80px;
        text-align: center;
    }

    .level-value {
        font-weight: 700;
        color: var(--text-primary);
    }

    .ml-value {
        font-weight: 700;
        color: #fbbf24;
    }

    .reset-value {
        font-weight: 700;
        color: #3b82f6;
    }

    .gr-value {
        font-weight: 700;
        color: #a855f7;
    }

    .col-location {
        min-width: 140px;
    }

    .location-name {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--neutral-100);
    }

    .location-name i {
        color: #22c55e;
    }

    .location-hidden {
        display: inline-flex;
        align-items: center;
        color: var(--neutral-300);
    }

    .empty-state {
        padding: 3rem;
        text-align: center;
        color: var(--neutral-100);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .guild-main-card {
            flex-direction: column;
            text-align: center;
        }

        .guild-name {
            font-size: 1.75rem;
        }

        .guild-info-grid {
            grid-template-columns: 1fr;
        }

        .guild-members-table {
            font-size: 12px;
        }

        .guild-members-table th,
        .guild-members-table td {
            padding: 10px 8px;
        }

        .class-avatar {
            width: 24px;
            height: 24px;
        }
    }
</style>
