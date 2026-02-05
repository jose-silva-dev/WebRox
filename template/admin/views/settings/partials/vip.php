<h3 class="subtitle">Configurações VIP</h3>
<small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
    Configure o sistema VIP e os tipos disponíveis
</small>
<div>
    <label>Coluna VIP</label>
    <input type="text" name="user[vip][column]" value="<?= htmlspecialchars($user['vip']['column'] ?? '') ?>"  required>
    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Nome da coluna no banco de dados que armazena o tipo VIP</small>
</div>
<div>
    <label>Coluna data de expiração VIP</label>
    <input type="text" name="user[vip][column_expire]" value="<?= htmlspecialchars($user['vip']['column_expire'] ?? 'AccountExpireDate') ?>" >
    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Nome da coluna no banco (ex: AccountExpireDate) que armazena a data em que o VIP expira</small>
</div>
<div>
    <label>Tipo de VIP ao Registrar</label>
    <select name="user[vip][register][type]">
        <?php foreach (($user['vip']['name'] ?? []) as $i => $vipName): ?>
            <option value="<?= $i ?>" <?= ((int)($user['vip']['register']['type'] ?? 0) === (int)$i) ? 'selected' : '' ?>><?= htmlspecialchars($vipName) ?></option>
        <?php endforeach; ?>
    </select>
    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Tipo VIP que será atribuído automaticamente ao criar nova conta</small>
</div>
<div>
    <label>
        <input type="hidden" name="user[vip][register][active]" value="0">
        <input type="checkbox" name="user[vip][register][active]" value="1" <?= !empty($user['vip']['register']['active']) ? 'checked' : '' ?>>
        Registrar VIP Automático
    </label>
    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Se ativado, novas contas receberão VIP automaticamente ao se registrar</small>
</div>
<div>
    <label>Dias VIP</label>
    <input type="number" name="user[vip][register][days]" value="<?= (int)($user['vip']['register']['days'] ?? 0) ?>"  required>
    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Quantidade de dias de VIP ao registrar (se VIP automático estiver ativo)</small>
</div>
<h5 class="subtitle">Tipos do VIP</h5>
<div class="grid-2">
    <?php foreach (($user['vip']['name'] ?? []) as $k => $vipName): ?>
        <div>
            <label>VIP <?= $k ?></label>
            <input type="text" name="user[vip][name][<?= $k ?>]" value="<?= htmlspecialchars($vipName) ?>" required>
        </div>
    <?php endforeach; ?>
</div>
