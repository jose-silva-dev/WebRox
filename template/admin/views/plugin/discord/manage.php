<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div class="admin-page-header">
        <div>
            <h1 class="title">Gerenciar Plugin: Discord</h1>
            <div class="admin-accent-line"></div>
        </div>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <form action="<?= route('admin/plugins/discord/save') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="server_id">Server ID do Discord</label>
                <input type="text" name="server_id" id="server_id" class="input"
                    value="<?= htmlspecialchars($plugin['config']['server_id'] ?? '') ?>"
>
                <small class="form-hint">ID do servidor Discord (encontre em Configurações do Servidor > Widget)</small>
            </div>

            <div class="form-group">
                <label for="invite">Link de Convite</label>
                <input type="url" name="invite" id="invite" class="input"
                    value="<?= htmlspecialchars($plugin['config']['invite'] ?? '') ?>"
>
                <small class="form-hint">Link de convite permanente do servidor</small>
            </div>

            <div class="form-group">
                <label for="member_count">Contagem de Membros (Fallback)</label>
                <input type="number" name="member_count" id="member_count" class="input"
                    value="<?= htmlspecialchars($plugin['config']['member_count'] ?? 0) ?>" min="0" >
                <small class="form-hint">Número exibido se a API do Discord falhar (0 = usar API real)</small>
            </div>

            <hr style="margin: 16px 0; border-color: var(--border-color);">
            <h3 class="subtitle" style="color: #5865F2;">Login e Sincronização com Discord (OAuth)</h3>
            <small class="form-hint" style="margin-bottom: 10px;">Configure uma aplicação em <a href="https://discord.com/developers/applications" target="_blank" rel="noopener">Discord Developer Portal</a>. Em OAuth2 > Redirects adicione: <code><?= rtrim($GLOBALS['base_url'] ?? base_url, '/') ?>/auth/discord/callback</code></small>

            <div class="form-group">
                <label for="client_id">Client ID (OAuth2)</label>
                <input type="text" name="client_id" id="client_id" class="input"
                    value="<?= htmlspecialchars($plugin['config']['client_id'] ?? '') ?>"
>
            </div>

            <div class="form-group">
                <label for="client_secret">Client Secret (OAuth2)</label>
                <input type="password" name="client_secret" id="client_secret" class="input"
                    value="<?= htmlspecialchars($plugin['config']['client_secret'] ?? '') ?>"
>
                <small class="form-hint">Deixe em branco para manter o valor atual</small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>

    <div class="form" style="margin-top: 16px; border-left: 4px solid #5865F2;">
        <div style="padding: 20px;">
            <h3 class="subtitle" style="color: #5865F2; margin-bottom: 15px;">
                <i class="ph ph-info"></i> Como Configurar
            </h3>
            <ol class="admin-list-hint">
                <li>Acesse as configurações do seu servidor Discord</li>
                <li>Vá em <strong>Widget</strong> e ative o Widget do Servidor</li>
                <li>Copie o <strong>Server ID</strong> e cole no campo acima</li>
                <li>Crie um convite permanente e cole o link</li>
                <li>Configure a contagem de membros (opcional, para fallback)</li>
            </ol>
        </div>
    </div>
</div>