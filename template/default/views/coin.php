<?= $this->layout('components/layouts/web') ?>

<div class="card" style="border: none; background: transparent; padding: 0;">
    <div class="web-title" style="margin-bottom: 8px;">
        <?= __("coin.title") ?>
    </div>
    <p style="color: var(--text-secondary); margin-bottom: 32px;"><?= __("coin.subtitle") ?></p>

    <?php if (user()): ?>
        <div class="donate-grid">
            <div class="package-card" onclick="selectPackage('season6.3', 'monthly')">
                <div class="package-icon">
                    <i class="ph ph-server"></i>
                </div>
                <div class="package-name">Season 6.3</div>
                <div class="package-details">ACESSO MENSAL</div>
                <div class="package-price">R$ 120,00</div>
                <button class="btn btn-primary" style="width: 100%;"><?= __("coin.select_btn") ?></button>
            </div>

            <div class="package-card featured" onclick="selectPackage('season6.3', 'lifetime')">
                <div style="position: absolute; top: 16px; right: 16px; color: var(--primary-color);">
                    <i class="ph ph-check-circle-fill"></i>
                </div>
                <div class="package-icon">
                    <i class="ph ph-diamond"></i>
                </div>
                <div class="package-name">Season 6.3</div>
                <div class="package-details">ACESSO VITALÍCIO</div>
                <div class="package-price" style="color: var(--primary-color);">R$ 1.000,00</div>
                <div class="package-details" style="color: var(--primary-color); font-weight: 600;">PAGAMENTO ÚNICO</div>
                <button class="btn btn-primary" style="width: 100%;"><?= __("coin.select_btn") ?></button>
            </div>

            <div class="package-card" onclick="selectPackage('season6', 'monthly')">
                <div class="package-icon">
                    <i class="ph ph-server"></i>
                </div>
                <div class="package-name">Season 6</div>
                <div class="package-details">ACESSO MENSAL</div>
                <div class="package-price">R$ 60,00</div>
                <button class="btn btn-primary" style="width: 100%;"><?= __("coin.select_btn") ?></button>
            </div>

            <div class="package-card" onclick="selectPackage('season6', 'lifetime')">
                <div class="package-icon">
                    <i class="ph ph-diamond"></i>
                </div>
                <div class="package-name">Season 6</div>
                <div class="package-details">ACESSO VITALÍCIO</div>
                <div class="package-price">R$ 600,00</div>
                <div class="package-details">PAGAMENTO ÚNICO</div>
                <button class="btn btn-primary" style="width: 100%;"><?= __("coin.select_btn") ?></button>
            </div>
        </div>

        <div style="margin-top: 40px; display: none;" id="payment-section">
            <div class="card">
                <div class="card-header">
                    <h2>Confirmar e Pagar</h2>
                </div>
                <div class="row" style="display: flex; gap: 24px;">
                    <div style="flex: 1;">
                        <div class="form-group">
                            <label class="form-label">Resumo do Pedido</label>
                            <div
                                style="background: var(--bg-input); padding: 16px; border-radius: 8px; border: 1px solid var(--border-color);">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="color: var(--text-secondary);">Produto</span>
                                    <span style="color: white;" id="summary-product">Season 6.3</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="color: var(--text-secondary);">Tipo</span>
                                    <span style="color: var(--primary-color);" id="summary-type">Acesso Vitalício</span>
                                </div>
                                <hr style="border-color: var(--border-color); margin: 12px 0;">
                                <div
                                    style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 700;">
                                    <span style="color: white;">Total</span>
                                    <span style="color: white;" id="summary-price">R$ 1.000,00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="flex: 1;">
                        <div class="form-group">
                            <label class="form-label">Forma de Pagamento</label>
                            <?php if (userConfig("donate.mercadopago.is_active")): ?>
                                <button class="btn btn-primary" style="width: 100%; margin-bottom: 12px;"
                                    onclick="submitPayment('mp')">
                                    Mercado Pago
                                </button>
                            <?php endif; ?>
                            <?php if (userConfig("donate.stripe.is_active")): ?>
                                <button class="btn btn-primary" style="width: 100%; background-color: #635bff;"
                                    onclick="submitPayment('stripe')">
                                    Stripe
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="warning">
            Você precisa estar logado para ver os planos!
        </div>
    <?php endif; ?>
</div>

<script>
    function selectPackage(product, type) {
        // Demo interaction
        document.getElementById('payment-section').style.display = 'block';
        // Smooth scroll to payment section
        document.getElementById('payment-section').scrollIntoView({ behavior: 'smooth' });
    }
</script>