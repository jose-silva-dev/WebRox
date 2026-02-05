<?= $this->layout('components/layouts/web') ?>

<div class="donate-page">
    <header class="donate-page-header">
        <h1 class="donate-page-title"><?= __("donate.page_title") ?></h1>
        <div class="accent-line"></div>
        <p class="donate-page-subtitle"><?= __("donate.page_subtitle") ?></p>
    </header>

    <?php if (user()): ?>
        <?php
        $paypalReturn = $_GET['paypal'] ?? '';
        $donateReturn = $_GET['donate'] ?? '';
        $freeRedeem = isset($_GET['free']) && $_GET['free'] === '1';
        $isSuccess = $paypalReturn === 'success' || $donateReturn === 'success' || $freeRedeem;
        $isError = $paypalReturn === 'error' || $donateReturn === 'failure';
        $isCancel = $paypalReturn === 'cancel' || $donateReturn === 'cancel';
        if ($isSuccess): ?>
            <div class="donate-return-message success"><?= __("donate.payment_success") ?></div>
        <?php elseif ($isError): ?>
            <div class="donate-return-message error"><?= __("donate.payment_error") ?></div>
        <?php elseif ($isCancel): ?>
            <div class="donate-return-message cancel"><?= __("donate.payment_cancel") ?></div>
        <?php elseif ($donateReturn === 'pending'): ?>
            <div class="donate-return-message"><?= __("donate.payment_pending") ?></div>
        <?php endif; ?>
        <div class="donate-categories-container">
            <?php if (empty($plans)): ?>
                <div class="warning"><?= __("donate.no_packages") ?></div>
            <?php else:
                $groupedPlans = [];
                foreach ($plans as $index => $plan) {
                    $category = !empty($plan['category']) ? $plan['category'] : __('common.general');
                    $groupedPlans[$category][] = ['index' => $index, 'plan' => $plan];
                }
                $categoryKeys = array_keys($groupedPlans);
                ?>

                <nav class="donate-tabs" role="tablist" aria-label="<?= htmlspecialchars(__("nav.coins")) ?>">
                    <?php foreach ($categoryKeys as $tabIndex => $categoryName): ?>
                        <button type="button" class="donate-tab <?= $tabIndex === 0 ? 'donate-tab--active' : '' ?>" role="tab" aria-selected="<?= $tabIndex === 0 ? 'true' : 'false' ?>" aria-controls="donate-panel-<?= $tabIndex ?>" id="donate-tab-<?= $tabIndex ?>" data-panel="donate-panel-<?= $tabIndex ?>"><?= htmlspecialchars($categoryName) ?></button>
                    <?php endforeach; ?>
                </nav>

                <?php foreach ($categoryKeys as $panelIndex => $categoryName):
                    $group = $groupedPlans[$categoryName]; ?>
                    <section class="donate-category-section donate-panel <?= $panelIndex === 0 ? 'donate-panel--active' : '' ?>" id="donate-panel-<?= $panelIndex ?>" role="tabpanel" aria-labelledby="donate-tab-<?= $panelIndex ?>"<?php if ($panelIndex > 0): ?> hidden<?php endif; ?>>
                        <div class="donate-grid">
                            <?php foreach ($group as $item):
                                $plan = $item['plan'];
                                $index = $item['index']; ?>
                                <article class="donate-package-card">
                                    <?php if ($plan['bonus_percent'] > 0): ?>
                                        <span class="donate-bonus-badge">+<?= $plan['bonus_percent'] ?>%</span>
                                    <?php endif; ?>

                                    <div class="donate-package-image">
                                        <?php
                                        $imgFile = !empty($plan['image']) ? basename(trim($plan['image'])) : '';
                                        if ($imgFile !== ''): ?>
                                            <div class="donate-package-image-wrap">
                                                <img src="<?= public_path('images/donate/' . $imgFile) ?>" alt="<?= htmlspecialchars($plan['name']) ?>" onerror="var w=this.closest('.donate-package-image-wrap'); if(w){var p=w.querySelector('.donate-package-icon-placeholder'); if(p){p.style.display='flex'; this.style.display='none';}}}">
                                                <div class="donate-package-icon-placeholder" style="display: none;"><i class="ph ph-hand-coins"></i></div>
                                            </div>
                                        <?php else: ?>
                                            <div class="donate-package-icon-placeholder"><i class="ph ph-hand-coins"></i></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="donate-package-body">
                                        <h3 class="donate-package-name"><?= htmlspecialchars($plan['name']) ?></h3>
                                        <div class="donate-package-rewards">
                                            <span class="donate-coin-base"><?= number_format($plan['coin_amount'], 0, ',', '.') ?> <?= $plan['main_coin'] ?></span>
                                            <?php if ($plan['bonus_percent'] > 0): ?>
                                                <span class="donate-coin-bonus">+<?= number_format(($plan['coin_amount'] * $plan['bonus_percent'] / 100), 0, ',', '.') ?> <?= $plan['main_coin'] ?> <?= __("common.bonus") ?></span>
                                                <span class="donate-coin-total"><?= number_format($plan['coin_amount'] * (1 + $plan['bonus_percent'] / 100), 0, ',', '.') ?> <?= $plan['main_coin'] ?></span>
                                            <?php else: ?>
                                                <span class="donate-coin-total"><?= number_format($plan['coin_amount'], 0, ',', '.') ?> <?= $plan['main_coin'] ?></span>
                                            <?php endif; ?>

                                            <?php if (!empty($plan['bonus_coins'])): ?>
                                                <div class="donate-extras">
                                                    <span class="donate-extras-label"><?= __("common.extras") ?></span>
                                                    <?php foreach ($plan['bonus_coins'] as $coinName => $amount): ?>
                                                        <?php if ($amount > 0): ?>
                                                            <span class="donate-extra-item">+<?= number_format($amount, 0, ',', '.') ?> <?= htmlspecialchars($coinName) ?></span>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <?php $isFree = (float)($plan['price'] ?? 0) <= 0; ?>
                                        <p class="donate-package-price"><?= $isFree ? __("donate.free") : 'BRL ' . number_format($plan['price'], 2, ',', '.') ?></p>
                                        <?php if ($isFree): ?>
                                            <form action="<?= route('user/donate/purchase') ?>" method="post" style="margin:0;">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="plan_index" value="<?= (int) $index ?>">
                                                <input type="hidden" name="payment_method" value="free">
                                                <button type="submit" class="btn btn-primary donate-btn-buy"><?= __("donate.redeem") ?></button>
                                            </form>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-primary donate-btn-buy" data-plan-index="<?= (int) $index ?>" data-plan-name="<?= htmlspecialchars($plan['name'], ENT_QUOTES, 'UTF-8') ?>" data-plan-price="<?= (float) $plan['price'] ?>"><?= __("donate.buy_now") ?></button>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="donate-modal-overlay" id="payment-modal" aria-hidden="true">
            <div class="donate-modal">
                <button type="button" class="donate-modal-close" onclick="closePaymentModal()" aria-label="<?= __("common.close_label") ?>"><i class="ph ph-x"></i></button>
                <h2 class="donate-modal-title"><?= __("donate.finish_order") ?></h2>
                <div class="donate-modal-accent"></div>
                <p class="donate-modal-desc" id="modal-package-name"><?= __("donate.you_selected", ['name' => '']) ?></p>
                <div class="donate-modal-total">
                    <span><?= __("donate.total_to_pay") ?></span>
                    <strong id="modal-package-price">R$ 17,90</strong>
                </div>
                <p class="donate-modal-label"><?= __("donate.choose_payment") ?></p>
                <form action="<?= route('user/donate/purchase') ?>" method="post" id="purchase-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="plan_index" id="form-plan-index">
                    <input type="hidden" name="payment_method" id="form-payment-method">
                    <div class="donate-methods">
                        <?php if (userConfig("donate.mercadopago.is_active")): ?>
                            <button type="button" onclick="selectMethod('mercadopago')" class="donate-method-btn donate-method-mp"><?= __("donate.mercadopago") ?></button>
                        <?php endif; ?>
                        <?php if (userConfig("donate.stripe.is_active")): ?>
                            <button type="button" onclick="selectMethod('stripe')" class="donate-method-btn donate-method-stripe"><?= __("donate.stripe") ?></button>
                        <?php endif; ?>
                        <?php if (userConfig("donate.paypal.is_active")): ?>
                            <button type="button" onclick="selectMethod('paypal')" class="donate-method-btn donate-method-paypal"><?= __("donate.paypal") ?></button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="warning"><?= __("donate.login_required") ?></div>
    <?php endif; ?>
</div>

<script>
(function() {
    function openPaymentModal(index, name, price) {
        document.getElementById('form-plan-index').value = index;
        document.getElementById('modal-package-name').textContent = ('<?= addslashes(__("donate.you_selected", ["name" => "NAME_PLACEHOLDER"])) ?>').replace('NAME_PLACEHOLDER', name);
        document.getElementById('modal-package-price').textContent = 'R$ ' + price.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        var modal = document.getElementById('payment-modal');
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    }
    function closePaymentModal() {
        var modal = document.getElementById('payment-modal');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    }
    function doPurchaseSubmit() {
        var form = document.getElementById('purchase-form');
        if (!form || !document.getElementById('form-payment-method').value) return;
        var fd = new FormData(form);
        var btns = form.querySelectorAll('.donate-method-btn');
        btns.forEach(function(b) { b.disabled = true; b.style.opacity = '0.6'; });
        fetch(form.action, {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r) { return r.json().catch(function() { return {}; }); })
        .then(function(data) {
            btns.forEach(function(b) { b.disabled = false; b.style.opacity = ''; });
            var title = data.title || 'Erro';
            var msg = data.message || '';
            var cls = (data.class || 'error').toLowerCase();
            if (data.redirect) {
                if (window.Alert) Alert.show(title, msg, cls === 'error' ? 'error' : cls === 'warning' ? 'warning' : 'success');
                window.location.href = data.redirect;
                return;
            }
            if (window.Alert) Alert.show(title, msg, cls === 'warning' ? 'warning' : cls === 'success' ? 'success' : 'error');
            else alert(title + ': ' + msg);
        })
        .catch(function() {
            btns.forEach(function(b) { b.disabled = false; b.style.opacity = ''; });
            if (window.Alert) Alert.show('Erro', 'Falha na comunicação. Tente novamente.', 'error');
            else alert('Falha na comunicação. Tente novamente.');
        });
    }
    function selectMethod(method) {
        document.getElementById('form-payment-method').value = method;
        doPurchaseSubmit();
    }
    var purchaseForm = document.getElementById('purchase-form');
    if (purchaseForm) {
        purchaseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            doPurchaseSubmit();
        });
    }
    var paymentModal = document.getElementById('payment-modal');
    if (paymentModal) {
        paymentModal.addEventListener('click', function(e) {
            if (e.target === this) closePaymentModal();
        });
    }
    document.querySelectorAll('.donate-btn-buy[data-plan-index]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var i = this.getAttribute('data-plan-index');
            var n = this.getAttribute('data-plan-name');
            var p = parseFloat(this.getAttribute('data-plan-price'));
            openPaymentModal(i, n, p);
        });
    });
    // Tabs: trocar moeda
    document.querySelectorAll('.donate-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            var panelId = this.getAttribute('data-panel');
            document.querySelectorAll('.donate-tab').forEach(function(t) { t.classList.remove('donate-tab--active'); t.setAttribute('aria-selected', 'false'); });
            document.querySelectorAll('.donate-panel').forEach(function(p) { p.setAttribute('hidden', ''); });
            this.classList.add('donate-tab--active');
            this.setAttribute('aria-selected', 'true');
            var panel = document.getElementById(panelId);
            if (panel) { panel.removeAttribute('hidden'); }
        });
    });
    window.openPaymentModal = openPaymentModal;
    window.closePaymentModal = closePaymentModal;
    window.selectMethod = selectMethod;
})();
</script>