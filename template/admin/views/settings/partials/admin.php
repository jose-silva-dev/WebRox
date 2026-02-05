<div class="settings-card">
    <h3 class="subtitle">Acesso Administrativo</h3>
    <div class="grid-2">
        <div class="settings-field">
            <label>Login do Admin</label>
            <input type="text" name="admin[login]" value="<?= htmlspecialchars($admin['login'] ?? '') ?>"  required>
            <small>Usuário para acessar o painel</small>
        </div>
        <div class="settings-field">
            <label>Senha do Admin</label>
            <input type="password" name="admin[password]" value="" placeholder="Deixe em branco para manter a atual" autocomplete="new-password">
            <small>Preencha apenas se quiser alterar a senha; ao salvar, será gravada com hash automaticamente.</small>
        </div>
    </div>
</div>
<div class="settings-card">
    <h3 class="subtitle">Staff</h3>
    <div class="settings-field">
        <label>Código da Staff</label>
        <input type="number" name="staff_code" value="<?= (int)($staff_code ?? 0) ?>"  required>
        <small>Código numérico para identificar contas da equipe no banco</small>
    </div>
</div>
