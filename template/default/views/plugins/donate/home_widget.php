<?php if (!empty($donatePluginEnabled)): ?>
    <div class="card donate-widget">
        <div class="card-header">
            <h2><?= __("donate.widget_title") ?></h2>
            <a href="<?= route('user.donate') ?>" class="donate-widget-cta"><?= __("donate.widget_see_plans") ?></a>
        </div>

        <div class="donate-widget-body">
            <div class="donate-widget-copy">
                <p class="donate-widget-desc"><?= __("donate.widget_desc") ?></p>
            </div>

            <?php if (!empty($donatePlans)): ?>
                <div class="donate-widget-plans">
                    <?php foreach ($donatePlans as $plan): ?>
                        <a href="<?= route('user.donate') ?>" class="donate-widget-plan">
                            <span class="donate-widget-plan-name"><?= htmlspecialchars($plan['name'] ?? '') ?></span>
                            <span class="donate-widget-plan-price"><?= (float)($plan['price'] ?? 0) <= 0 ? __("donate.free") : 'R$ ' . number_format((float)($plan['price'] ?? 0), 2, ',', '.') ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
