<h3 class="subtitle">Donate</h3>
<p class="form-hint" style="margin-bottom: 1rem;">
    Gateways (MercadoPago, Stripe, PayPal) e pacotes: <a href="<?= route('admin/plugins/manage?plugin=gatewaypayment') ?>" style="color: var(--primary-color);">Plugins → Gateway Payment</a> e <a href="<?= route('admin/plugins/manage?plugin=donate') ?>" style="color: var(--primary-color);">Plugins → Donate</a>.
</p>
<p class="form-hint" style="margin-bottom: 1rem;">
    A moeda de cada pacote é definida no plugin Donate. A tabela/coluna para creditar vêm de <strong>Configurações → Coin (Moedas)</strong>. Os campos abaixo são <strong>fallback</strong> (moeda não configurada em Moedas ou modo legado).
</p>
<hr style="margin:20px 0;border-color:var(--border-color)">
<h4 class="subtitle">Banco de dados – fallback (doações)</h4>
<div class="form-group">
    <label>Tabela (fallback)</label>
    <input type="text" name="user[donate][table]" value="<?= htmlspecialchars($user['donate']['table'] ?? '') ?>"  required>
</div>
<div class="grid-2">
    <div class="form-group">
        <label>Coluna conta (fallback)</label>
        <input type="text" name="user[donate][column_account]" value="<?= htmlspecialchars($user['donate']['column_account'] ?? '') ?>"  required>
    </div>
    <div class="form-group">
        <label>Coluna moeda (fallback)</label>
        <input type="text" name="user[donate][column_coin]" value="<?= htmlspecialchars($user['donate']['column_coin'] ?? '') ?>"  required>
    </div>
</div>
<div class="form-group">
    <label>
        <input type="hidden" name="user[donate][active_multiplier]" value="0">
        <input type="checkbox" name="user[donate][active_multiplier]" value="1" <?= !empty($user['donate']['active_multiplier']) ? 'checked' : '' ?>>
        Usar multiplicador por faixa de valor
    </label>
</div>
<hr style="margin:20px 0;border-color:var(--border-color)">
<h4 class="subtitle">Faixas do multiplicador</h4>
<?php $mults = $user['donate']['multiplier'] ?? []; ?>
<div class="space-y-1">
    <?php foreach ($mults as $i => $m): ?>
        <div class="grid-3">
            <div class="form-group">
                <label>Min</label>
                <input type="number" name="user[donate][multiplier][<?= $i ?>][min]" value="<?= (int)($m['min'] ?? 0) ?>" required>
            </div>
            <div class="form-group">
                <label>Max</label>
                <input type="number" name="user[donate][multiplier][<?= $i ?>][max]" value="<?= (int)($m['max'] ?? 0) ?>" required>
            </div>
            <div class="form-group">
                <label>Multiplicador</label>
                <input type="number" name="user[donate][multiplier][<?= $i ?>][multiplier]" value="<?= (int)($m['multiplier'] ?? 1) ?>" required>
            </div>
        </div>
    <?php endforeach; ?>
</div>
