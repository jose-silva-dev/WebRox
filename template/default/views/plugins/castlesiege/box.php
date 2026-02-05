<?php use Source\Resolve\Guild as GuildResolve; ?>
<?php use Source\Services\CastleSiegeService; ?>

<div class="castle-siege-hero">

    <div class="castle-bg"></div>

    <img src="<?= assets('images/castlesiege/statue.png') ?>" class="castle-statue" alt="Castle Siege Statue">

    <div class="castle-content">
        <?php
        $pluginConfig = config('plugins.castlesiege.config') ?? [];
        $title = $pluginConfig['title'] ?? __("castlesiege.default_title");
        $subtitle = $pluginConfig['subtitle'] ?? __("castlesiege.default_subtitle");
        ?>
        <h2><?= htmlspecialchars($title) ?></h2>
        <p class="castle-subtitle"><?= htmlspecialchars($subtitle) ?></p>

        <?php if ($castle && !empty($castle['guild'])): ?>
            <div class="castle-guild">
                <div class="castle-guild-mark">
                    <?= (new GuildResolve())->getRender($castle['mark'], 64); ?>
                </div>
                <div class="castle-guild-info">
                    <strong><?= htmlspecialchars($castle['guild']) ?></strong>
                    <span><?= htmlspecialchars($castle['master']) ?></span>
                </div>
            </div>
        <?php else: ?>
            <div class="castle-guild" style="opacity: 0.5;">
                <div class="castle-guild-info" style="text-align: center; width: 100%;">
                    <strong><?= __("castlesiege.no_guild") ?></strong>
                    <span><?= __("castlesiege.awaiting") ?></span>
                </div>
            </div>
        <?php endif; ?>

        <div class="castle-next">
            <?= __("castlesiege.next_battle") ?>
            <?php if (!empty($castle['siege_start'])): ?>
                <span>
                    <?= CastleSiegeService::formatSiegeDatePtBr($castle['siege_start']) ?>
                </span>
            <?php else: ?>
                <span><?= __("castlesiege.soon") ?></span>
            <?php endif; ?>
        </div>

    </div>
</div>