<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div class="admin-page-header">
        <div>
            <h1 class="title">Gerenciar Plugin: Gateway Payment</h1>
            <div class="admin-accent-line"></div>
            <span class="admin-page-desc">
                Configure os gateways de pagamento para doações. Ative o plugin e escolha MercadoPago, Stripe e/ou PayPal.
            </span>
        </div>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <form action="<?= route('admin/plugins/gatewaypayment/save') ?>" method="post">
            <?= csrf_field() ?>

            <h3 class="subtitle" style="margin-top: 8px;">MercadoPago</h3>
            <div class="form-group">
                <label>
                    <input type="hidden" name="gatewaypayment[mercadopago][is_active]" value="0">
                    <input type="checkbox" name="gatewaypayment[mercadopago][is_active]" value="1"
                        <?= !empty($plugin['config']['mercadopago']['is_active']) ? 'checked' : '' ?>>
                    MercadoPago ativo
                </label>
                <small class="form-hint">Ative para permitir doações via MercadoPago</small>
            </div>
            <div class="form-group">
                <label for="mercadopago_token">Token MercadoPago</label>
                <input type="text" name="gatewaypayment[mercadopago][token]" id="mercadopago_token" class="input"
                    value="<?= htmlspecialchars($plugin['config']['mercadopago']['token'] ?? '') ?>"
>
                <small class="form-hint">Token de acesso (painel do desenvolvedor MercadoPago)</small>
            </div>

            <hr style="margin: 16px 0; border-color: var(--border-color);">

            <h3 class="subtitle">Stripe</h3>
            <div class="form-group">
                <label>
                    <input type="hidden" name="gatewaypayment[stripe][is_active]" value="0">
                    <input type="checkbox" name="gatewaypayment[stripe][is_active]" value="1"
                        <?= !empty($plugin['config']['stripe']['is_active']) ? 'checked' : '' ?>>
                    Stripe ativo
                </label>
                <small class="form-hint">Ative para permitir doações via Stripe (cartão global)</small>
            </div>
            <div class="form-group">
                <label for="stripe_token">Stripe Publishable Key</label>
                <input type="text" name="gatewaypayment[stripe][token_stripe]" id="stripe_token" class="input"
                    value="<?= htmlspecialchars($plugin['config']['stripe']['token_stripe'] ?? '') ?>"
>
                <small class="form-hint">Chave pública (Publishable Key)</small>
            </div>
            <div class="form-group">
                <label for="stripe_secret">Stripe Secret Key</label>
                <input type="password" name="gatewaypayment[stripe][secret_stripe]" id="stripe_secret" class="input"
                    value=""
>
                <small class="form-hint">Chave secreta (Secret Key). Deixe em branco para manter a atual.</small>
            </div>

            <hr style="margin: 16px 0; border-color: var(--border-color);">

            <h3 class="subtitle">PayPal</h3>
            <div class="form-group">
                <label>
                    <input type="hidden" name="gatewaypayment[paypal][is_active]" value="0">
                    <input type="checkbox" name="gatewaypayment[paypal][is_active]" value="1"
                        <?= !empty($plugin['config']['paypal']['is_active']) ? 'checked' : '' ?>>
                    PayPal ativo
                </label>
                <small class="form-hint">Ative para permitir doações via PayPal</small>
            </div>
            <div class="form-group">
                <label for="paypal_client_id">PayPal Client ID</label>
                <input type="text" name="gatewaypayment[paypal][client_id]" id="paypal_client_id" class="input"
                    value="<?= htmlspecialchars($plugin['config']['paypal']['client_id'] ?? '') ?>"
>
                <small class="form-hint">Obtido em developer.paypal.com → Apps & Credentials</small>
            </div>
            <div class="form-group">
                <label for="paypal_client_secret">PayPal Client Secret</label>
                <input type="password" name="gatewaypayment[paypal][client_secret]" id="paypal_client_secret" class="input"
                    value="" placeholder="<?= htmlspecialchars(!empty($plugin['config']['paypal']['client_secret']) ? '•••••••• (já configurado)' : 'Obrigatório na primeira vez') ?>"
                    autocomplete="new-password">
                <small class="form-hint"><?= !empty($plugin['config']['paypal']['client_secret']) ? 'Deixe em branco para manter o atual.' : 'Preencha com o Secret do app (Sandbox ou Produção) em developer.paypal.com → Apps & Credentials.' ?></small>
            </div>
            <div class="form-group">
                <label>
                    <input type="hidden" name="gatewaypayment[paypal][sandbox]" value="0">
                    <input type="checkbox" name="gatewaypayment[paypal][sandbox]" value="1"
                        <?= !empty($plugin['config']['paypal']['sandbox']) ? 'checked' : '' ?>>
                    Usar ambiente Sandbox (testes)
                </label>
                <small class="form-hint">Desmarque para produção (pagamentos reais)</small>
            </div>

            <div class="form-group" style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>

    <div class="form admin-info-box" style="margin-top: 30px; border-left: 4px solid var(--green-100);">
        <div style="padding: 20px;">
            <h3 class="subtitle" style="color: var(--green-100); margin-bottom: 12px; margin-top: 0;">
                <i class="ph ph-info"></i> Importante
            </h3>
            <ul class="admin-list-hint">
                <li>É necessário ativar o plugin na lista de plugins para que os gateways apareçam na página de doações.</li>
                <li>Os pacotes de doação são configurados no plugin Donate.</li>
                <li>MercadoPago: use o token de produção ou de teste conforme o ambiente.</li>
                <li>Stripe: configure o webhook <code><?= rtrim($GLOBALS['base_url'] ?? base_url, '/') ?>/stripe/notification</code> no painel Stripe para pagamentos automáticos.</li>
                <li>PayPal: após o pagamento o usuário retorna ao site e o crédito é aplicado automaticamente na página de retorno.</li>
            </ul>
        </div>
    </div>
</div>
