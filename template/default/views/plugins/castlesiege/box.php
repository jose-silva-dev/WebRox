<?php use Source\Resolve\Guild as GuildResolve; ?>
<?php use Source\Services\CastleSiegeService; ?>

<div class="castle-siege-hero">

    <!-- FUNDO -->
    <div class="castle-bg"></div>

    <!-- ESTÁTUA -->
    <img
        src="/template/default/assets/images/castlesiege/statue.png"
        class="castle-statue"
        alt="Castle Siege Statue"
    >

    <!-- CONTEÚDO -->
    <div class="castle-content">
        <?php
        $pluginConfig = config('plugins.castlesiege.config') ?? [];
        $title = $pluginConfig['title'] ?? 'Castle Siege';
        $subtitle = $pluginConfig['subtitle'] ?? 'Apenas uma guild reinará sobre o castelo';
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

            <div class="castle-next">
    Próxima Batalha:
    <?php if (!empty($castle['siege_start'])): ?>
        <span>
            <?= CastleSiegeService::formatSiegeDatePtBr($castle['siege_start']) ?>
        </span>
    <?php else: ?>
        <span>Em Breve</span>
    <?php endif; ?>
</div>
        <?php else: ?>
            <div class="castle-next">
                Sem Guild Dona —
                <span>Próxima Batalha: Em Breve</span>
            </div>
        <?php endif; ?>

    </div>
</div>
