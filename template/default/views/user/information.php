<?= $this->layout('components/layouts/web') ?>

<style>
    .account-page {
        max-width: 1280px;
        width: 100%;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--account-page-title);
        margin-bottom: 8px;
    }

    .page-subtitle {
        font-size: 14px;
        color: var(--account-page-subtitle);
    }

    .account-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }

    .account-page .info-card {
        background: var(--account-info-card-bg);
        border: 1px solid var(--account-info-card-border);
        border-radius: 8px;
        padding: 18px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .account-page .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--accent-color, #4a9eff);
    }

    .account-page .info-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--account-info-card-shadow);
    }

    .account-page .info-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .account-page .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .account-page .info-label {
        font-size: 11px;
        color: var(--account-info-label);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex: 1;
    }

    .account-page .info-value {
        font-size: var(--text-lg);
        font-weight: 700;
        color: var(--account-info-value);
        min-height: 1.5em;
        line-height: 1.3;
    }

    .account-page .info-extra {
        font-size: 11px;
        color: var(--account-info-extra);
        margin-top: 6px;
    }

    .buy-btn {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: #fff;
        border: none;
        padding: 5px 14px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .buy-btn:hover {
        transform: scale(1.05);
    }

    .sync-btn {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: #fff;
        border: none;
        padding: 5px 14px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .sync-btn:hover {
        transform: scale(1.05);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-vip {
        background: #FFD700;
        color: #000;
    }

    .account-page .status-not-linked {
        background: var(--account-status-notlinked-bg);
        color: var(--account-status-notlinked-color);
    }

    /* Email hover effect */
    .email-card {
        position: relative;
    }

    .account-page .email-edit-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--account-email-overlay-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        cursor: pointer;
    }

    .account-page .email-card:hover .email-edit-overlay {
        opacity: 1;
    }

    .account-page .edit-email-btn {
        color: var(--account-edit-btn-color);
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    /* Characters card link */
    .characters-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    @media (max-width: 1024px) {
        .account-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .account-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="account-page">
    <div class="page-header">
        <div class="page-title"><?= __("user.panel_title") ?></div>
        <div class="page-subtitle"><?= __("user.panel_subtitle") ?></div>
    </div>

    <?php if (isset($_GET['discord']) && $_GET['discord'] === 'linked'): ?>
    <div style="margin-bottom: 20px; padding: 12px 16px; background: rgba(88, 101, 242, 0.2); border: 1px solid #5865F2; border-radius: 8px; color: #a5b4fc;">
        <i class="ph ph-check-circle"></i> <?= __("user.discord_linked_success") ?>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['discord']) && $_GET['discord'] === 'unlinked'): ?>
    <div style="margin-bottom: 20px; padding: 12px 16px; background: rgba(156, 163, 175, 0.2); border: 1px solid #6b7280; border-radius: 8px; color: #9ca3af;">
        <i class="ph ph-check-circle"></i> <?= __("user.discord_unlinked") ?>
    </div>
    <?php endif; ?>

    <div class="account-grid">
        <a href="<?= route('user.profile') ?>" class="characters-link">
            <div class="info-card" style="--accent-color: #2196F3;">
                <div class="info-card-header">
                    <div class="info-icon" style="background: #2196F3;">
                        👤
                    </div>
                    <div class="info-label"><?= __("user.account_label") ?></div>
                </div>
                <div class="info-value"><?= e(resolve('User')->getUsername()) ?></div>
            </div>
        </a>

        <a href="<?= route('user.character.select') ?>" class="characters-link">
            <div class="info-card" style="--accent-color: #00bcd4;">
                <div class="info-card-header">
                    <div class="info-icon" style="background: #00bcd4;">
                        ⚔️
                    </div>
                    <div class="info-label"><?= __("user.my_characters") ?></div>
                </div>
                <div class="info-value"><?= (int)($characterCount ?? 0) ?></div>
            </div>
        </a>

        <div class="info-card email-card" style="--accent-color: #f44336;">
            <div class="info-card-header">
                <div class="info-icon" style="background: #f44336;">
                    📧
                </div>
                <div class="info-label"><?= __("user.email_label") ?></div>
            </div>
            <div class="info-value" style="font-size: 14px; word-break: break-all;">
                <?= e(resolve('User')->getEmail()) ?>
            </div>
            <a href="#" onclick="openEmailPopup(); return false;" class="email-edit-overlay">
                <div class="edit-email-btn">
                    <i class="ph ph-pencil-simple"></i>
                    <?= __("user.change_email") ?>
                </div>
            </a>
        </div>

        <?php
        $allCoins = resolve('User')->getCoins();
        $donateEnabled = config('plugins.donate.enabled');
        $coinColors = ['#4a9eff', '#9c27b0', '#ff9800', '#4CAF50', '#f44336', '#00bcd4'];
        $coinIcons = ['💰', '💎', '🪙', '⭐', '🎁', '🏆'];
        foreach ($allCoins as $index => $coin):
            $color = $coinColors[$index % count($coinColors)];
            $icon = $coinIcons[$index % count($coinIcons)];
        ?>
        <div class="info-card" style="--accent-color: <?= $color ?>;">
            <div class="info-card-header">
                <div class="info-icon" style="background: <?= $color ?>;"><?= $icon ?></div>
                <div class="info-label"><?= strtoupper($coin['title']) ?></div>
                <?php if ($donateEnabled): ?>
                    <a href="<?= route('user.donate') ?>" class="buy-btn btn-primary"><?= __("user.buy") ?></a>
                <?php endif; ?>
            </div>
            <div class="info-value"><?= number_format($coin['amount']) ?></div>
        </div>
        <?php endforeach; ?>

        <div class="info-card" style="--accent-color: #9c27b0;">
            <div class="info-card-header">
                <div class="info-icon" style="background: #9c27b0;">
                    🕐
                </div>
                <div class="info-label"><?= __("user.last_login_label") ?></div>
            </div>
            <div class="info-value" style="font-size: 15px;"><?= __("user.today") ?> 10:38</div>
        </div>

        <div class="info-card" style="--accent-color: #FFD700;">
            <div class="info-card-header">
                <div class="info-icon" style="background: #FFD700;">
                    👑
                </div>
                <div class="info-label"><?= __("user.vip_label") ?></div>
            </div>
            <div class="info-value">
                <?php
                $vipId = resolve('User')->getVipId();
                $vipClass = 'status-vip-' . $vipId;
                ?>
                <span class="status-badge <?= $vipClass ?>"><?= resolve('User')->getVip() ?></span>
            </div>
            <?php $expireText = resolve('User')->getExpireVipText(); ?>
            <?php if ($expireText !== null): ?>
            <div class="info-extra"><?= htmlspecialchars($expireText) ?></div>
            <?php endif; ?>
        </div>

        <div class="info-card" style="--accent-color: #5865F2;">
            <div class="info-card-header">
                <div class="info-icon" style="background: #5865F2;">
                    <i class="ph ph-discord-logo" style="color: #fff;"></i>
                </div>
                <div class="info-label"><?= __("user.discord_sync") ?></div>
            </div>
            <div class="info-value" style="font-size: 14px;">
                <?php $discordLinked = $discordLinked ?? false; $discordPluginEnabled = config('plugins.discord.enabled'); ?>
                <?php if (!empty($discordLinked)): ?>
                    <span class="status-badge" style="background: rgba(88, 101, 242, 0.3); color: #a5b4fc;"><?= __("user.linked") ?></span>
                <?php else: ?>
                    <span class="status-badge status-not-linked"><?= __("user.not_linked") ?></span>
                <?php endif; ?>
            </div>
            <?php if ($discordPluginEnabled): ?>
                <?php if (empty($discordLinked)): ?>
                    <a href="<?= rtrim(route(''), '/') ?>/auth/discord?state=link" class="sync-btn" style="margin-top: 10px; padding: 8px 16px; text-align: center; display: inline-block; box-sizing: border-box; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); color: #fff; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none;"><?= __("user.sync") ?></a>
                <?php else: ?>
                    <form action="<?= rtrim(route(''), '/') ?>/auth/discord/unlink" method="post" style="margin-top: 10px;">
                        <?= csrf_field() ?>
                        <button type="submit" class="sync-btn discord-unlink-btn" style="margin-top: 0; padding: 8px 16px; background: rgba(255,255,255,0.1); color: #9ca3af; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;"><?= __("user.unlink") ?></button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
