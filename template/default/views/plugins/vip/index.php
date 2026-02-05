<?= $this->layout('components/layouts/web') ?>

<div class="vip-page">
    <header class="vip-page-header">
        <h1 class="vip-page-title"><?= __("vip.page_title") ?></h1>
        <div class="accent-line"></div>
        <p class="vip-page-subtitle">
            <?= __("vip.page_subtitle") ?>
        </p>
    </header>

    <?php if (!empty($plans)): ?>
        <div class="vip-plans-grid">
            <?php foreach ($plans as $planIndex => $plan):
                $isFeatured = isset($plan['recommended']) && $plan['recommended']; ?>
                <article class="vip-plan-card <?= $isFeatured ? 'vip-plan-card--featured' : '' ?>">
                    <div class="vip-plan-header">
                        <h2 class="vip-plan-name"><?= htmlspecialchars($plan['name'] ?? __("vip.plan_name")) ?></h2>
                        <p class="vip-plan-price">
                            <?= number_format((int) ($plan['price'] ?? 0), 0, ',', '.') ?>
                            <small><?= htmlspecialchars($plan['currency_type'] ?? 'WCoinC') ?></small>
                        </p>
                        <span class="vip-plan-duration"><?= (int) ($plan['days'] ?? 0) ?> <?= __("common.days") ?></span>
                    </div>

                    <ul class="vip-plan-benefits">
                        <?php
                        $benefits = array_filter(array_map('trim', explode("\n", trim($plan['description'] ?? ''))));
                        foreach ($benefits as $benefit): ?>
                            <li class="vip-plan-benefit"><i class="ph-fill ph-check-circle"></i><span><?= htmlspecialchars($benefit) ?></span></li>
                        <?php endforeach; ?>
                    </ul>

                    <?php
                    $expRate = (int) ($plan['exp_rate'] ?? 100);
                    $masterExpRate = (int) ($plan['master_exp_rate'] ?? 100);
                    $dropRate = (int) ($plan['drop_rate'] ?? 100);
                    if ($expRate > 100 || $masterExpRate > 100 || $dropRate > 100): ?>
                        <div class="vip-plan-rates">
                            <?php if ($expRate > 100): ?><span class="vip-rate vip-rate--exp">Exp +<?= $expRate - 100 ?>%</span><?php endif; ?>
                            <?php if ($masterExpRate > 100): ?><span class="vip-rate vip-rate--master">Master +<?= $masterExpRate - 100 ?>%</span><?php endif; ?>
                            <?php if ($dropRate > 100): ?><span class="vip-rate vip-rate--drop">Drop +<?= $dropRate - 100 ?>%</span><?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= route('/vip/purchase') ?>" method="post" class="vip-plan-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="plan_index" value="<?= $planIndex ?>">
                        <button type="submit" class="btn btn-primary vip-plan-btn">
                            <i class="ph ph-shopping-cart"></i>
                            <?= __("vip.acquire_now") ?>
                        </button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="vip-empty">
            <i class="ph ph-crown"></i>
            <p><?= __("vip.no_plans") ?></p>
        </div>
    <?php endif; ?>
</div>