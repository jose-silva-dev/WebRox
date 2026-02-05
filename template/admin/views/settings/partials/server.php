<div class="settings-card">
    <h3 class="subtitle">Importar Itens</h3>
    <p class="settings-desc">Coloque o Item.txt do seu MuServer na pasta <code>storage/item/</code> e clique em Sincronizar para atualizar os nomes dos itens no site.</p>
    <div class="settings-field">
        <button type="button" id="btn-update-items" class="btn btn-primary btn-sm">
            <i class="ph-fill ph-arrows-clockwise"></i> Sincronizar Itens (Item.txt)
        </button>
        <div id="update-items-result" style="margin-top: 6px; font-size: 0.75rem; color: #2ecc71; display: none;"></div>
    </div>
</div>

<div class="settings-card">
    <h3 class="subtitle">Configurações do Servidor</h3>
    <div class="grid-3">
        <div class="settings-field">
            <label>Nome do Servidor</label>
            <input type="text" name="server_name" value="<?= htmlspecialchars($server['name']) ?>"  required>
            <small>Nome exibido no site</small>
        </div>
        <div class="settings-field">
            <label>Versão</label>
            <input type="text" name="server_version" value="<?= htmlspecialchars($server['version']) ?>"  required>
            <small>Versão do servidor</small>
        </div>
        <div class="settings-field">
            <label>Experiência</label>
            <input type="text" name="experience" value="<?= htmlspecialchars($server['experience']) ?>" placeholder="1000x" required>
            <small>Taxa de experiência (ex: 1000x)</small>
        </div>
        <div class="settings-field">
            <label>Drop</label>
            <input type="text" name="drop" value="<?= htmlspecialchars($server['drop']) ?>"  required>
            <small>Taxa de drop (ex: 100%)</small>
        </div>
        <div class="settings-field">
            <label>Level Máximo</label>
            <input type="number" name="level" value="<?= (int)$server['level'] ?>"  required>
            <small>Nível máximo permitido</small>
        </div>
        <div class="settings-field">
            <label>Pontos de Atributo</label>
            <input type="number" name="points_attributes" value="<?= (int)$server['points_attributes'] ?>"  required>
            <small>Pontos máximos por atributo</small>
        </div>
        <div class="settings-field">
            <label>PVP</label>
            <input type="text" name="pvp" value="<?= htmlspecialchars($server['pvp']) ?>" placeholder="Balanceado" required>
            <small>Tipo de PVP (ex: Balanceado, Livre)</small>
        </div>
        <div class="settings-field">
            <label>Online Base</label>
            <input type="number" name="online_base" value="<?= (int)$server['online_base'] ?>"  required>
            <small>Valor base para cálculo de online</small>
        </div>
        <div class="settings-field">
            <label>Multiplicador Online</label>
            <input type="number" name="online_multiplier" value="<?= (int)$server['online_multiplier'] ?>"  required>
            <small>Multiplicador do online real</small>
        </div>
    </div>
</div>

<div class="settings-card">
    <h3 class="subtitle">Configuração do Banco de Dados</h3>
    <div class="grid-2">
        <div class="settings-field">
            <label>Tipo de Conexão</label>
            <input type="hidden" name="db_type" value="">
            <label style="display:flex; align-items:center; gap:6px; font-size:0.875rem;">
                <input type="checkbox" name="db_type" value="PDO::ConnectionSQLSRV" <?= ($database['type'] ?? '') === 'PDO::ConnectionSQLSRV' ? 'checked' : '' ?>>
                pdo_sqlsrv
            </label>
            <small>Driver de conexão com SQL Server (Microsoft)</small>
        </div>
        <div class="settings-field">
            <label>IP do Servidor</label>
            <input type="text" name="db_ip" value="<?= htmlspecialchars($database['ip_vps'] ?? '') ?>"  required>
            <small>Endereço IP ou hostname do SQL Server</small>
        </div>
        <div class="settings-field">
            <label>Porta</label>
            <input type="text" name="db_port" value="<?= htmlspecialchars($database['port'] ?? '') ?>" >
            <small>Deixe vazio para porta padrão (1433)</small>
        </div>
        <div class="settings-field">
            <label>Nome do Banco de Dados</label>
            <input type="text" name="db_name" value="<?= htmlspecialchars($database['dbname'] ?? '') ?>"  required>
            <small>Nome do banco no SQL Server</small>
        </div>
        <div class="settings-field">
            <label>Usuário</label>
            <input type="text" name="db_user" value="<?= htmlspecialchars($database['user'] ?? '') ?>"  required>
            <small>Usuário com permissão de acesso</small>
        </div>
        <div class="settings-field">
            <label>Senha</label>
            <div style="display:flex; gap:6px;">
                <input type="password" name="db_pass" id="db_pass" value="<?= htmlspecialchars($database['passwd'] ?? '') ?>" style="flex:1" required>
                <button type="button" class="btn btn-warning btn-sm" onclick="toggleDbPassword()" title="Mostrar / Ocultar"><i class="ph ph-eye"></i></button>
            </div>
            <small>Senha do usuário do banco</small>
        </div>
    </div>
    <div style="margin-top:0.6rem; display:flex; gap:8px; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="testDbConnection()"><i class="ph ph-plug"></i> Testar Conexão</button>
        <div id="db-test-result"></div>
    </div>
    <small>Teste a conexão antes de salvar</small>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnUpdateItems = document.getElementById('btn-update-items');
    var resultDiv = document.getElementById('update-items-result');
    if (btnUpdateItems) {
        btnUpdateItems.addEventListener('click', function() {
            var originalText = this.innerHTML;
            this.innerHTML = '<i class="ph-fill ph-spinner animate-spin"></i> Processando...';
            this.disabled = true;
            resultDiv.style.display = 'none';
            var formData = new FormData();
            formData.append('_token', '<?= csrf_token() ?>');
            fetch('<?= route('admin/settings/update-items') ?>', { method: 'POST', body: formData })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    btnUpdateItems.innerHTML = originalText;
                    btnUpdateItems.disabled = false;
                    resultDiv.style.display = 'block';
                    resultDiv.style.color = data.error ? '#e74c3c' : '#2ecc71';
                    resultDiv.textContent = data.error ? 'Erro: ' + data.message : data.message;
                })
                .catch(function(err) {
                    btnUpdateItems.innerHTML = originalText;
                    btnUpdateItems.disabled = false;
                    resultDiv.style.display = 'block';
                    resultDiv.style.color = '#e74c3c';
                    resultDiv.textContent = 'Erro ao processar requisição';
                });
        });
    }
});
</script>
