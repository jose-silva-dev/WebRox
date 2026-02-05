<?= $this->layout('components/layouts/admin') ?>
<style>
.settings-tabs__item.is-selected { background: rgba(255,255,255,0.14); color: #fff; border: none; }
.settings-tabs__item.is-selected i { color: #fff; }
</style>
<div class="adm-page settings-page">
    <header class="adm-page__header settings-header">
        <div>
            <p class="settings-eyebrow">Configurações do Sistema</p>
            <h1 class="adm-page__title">Configuração</h1>
            <p class="settings-subtitle adm-page__subtitle">Ajuste a identidade visual, integrações e recursos do seu portal.</p>
        </div>
    </header>

    <form action="<?= route('admin/settings/update') ?>" method="post" enctype="multipart/form-data" class="settings-form">
        <?= csrf_field() ?>

        <nav class="settings-tabs" id="settings-nav" aria-label="Seções de configuração">
            <button type="button" class="settings-tabs__item is-selected" data-tab="site"><i class="ph ph-planet" aria-hidden="true"></i><span>Site</span></button>
            <button type="button" class="settings-tabs__item" data-tab="server"><i class="ph ph-cpu" aria-hidden="true"></i><span>Servidor</span></button>
            <button type="button" class="settings-tabs__item" data-tab="admin"><i class="ph ph-user-gear" aria-hidden="true"></i><span>Admin</span></button>
            <button type="button" class="settings-tabs__item" data-tab="rankings"><i class="ph ph-trophy" aria-hidden="true"></i><span>Rankings</span></button>
            <button type="button" class="settings-tabs__item" data-tab="user"><i class="ph ph-wallet" aria-hidden="true"></i><span>Coin</span></button>
            <button type="button" class="settings-tabs__item" data-tab="security"><i class="ph ph-shield-check" aria-hidden="true"></i><span>Segurança</span></button>
            <button type="button" class="settings-tabs__item" data-tab="mail"><i class="ph ph-envelope" aria-hidden="true"></i><span>E-mail</span></button>
            <button type="button" class="settings-tabs__item" data-tab="vip"><i class="ph ph-crown" aria-hidden="true"></i><span>Vip</span></button>
            <button type="button" class="settings-tabs__item" data-tab="vip-packs"><i class="ph ph-hand-coins" aria-hidden="true"></i><span>Donate</span></button>
            <button type="button" class="settings-tabs__item" data-tab="terms"><i class="ph ph-scroll" aria-hidden="true"></i><span>Termos</span></button>
        </nav>

        <div class="settings-panels">
            <div class="tab-content settings-panel active" id="site">
                <div class="settings-card">
                    <h3 class="subtitle">Configurações do Site</h3>
                    <div class="settings-field">
                        <label>Timezone</label>
                        <input type="text"
                               name="timezone"
                               value="<?= htmlspecialchars($site['timezone']) ?>"
                               required>
                        <small>Fuso horário do servidor (ex: America/Sao_Paulo, UTC, Europe/London)</small>
                    </div>
                    <div class="settings-field">
                        <label>Licença (Customer Name)</label>
                        <input type="text"
                               name="license[customer_name]"
                               value="<?= htmlspecialchars($license['customer_name'] ?? '') ?>"
>
                        <small>Código de licença fornecido pela desenvolvedora (não altere sem autorização)</small>
                    </div>
                </div>

                <div class="settings-card">
                    <h3 class="subtitle">Informações do Site</h3>
                    <p class="settings-desc">Escolha se a marca no cabeçalho será texto (título) ou imagem (logo). Descrição pode ser ativada separadamente.</p>

                    <?php
                    $brandType = $site['brand_type'] ?? (!empty($site['logo']['enabled']) ? 'logo' : 'title');
                    ?>
                    <div class="settings-field">
                        <label>Marca no cabeçalho</label>
                        <div class="settings-choice-group">
                            <label class="settings-choice">
                                <input type="radio" name="site[brand_type]" value="title" <?= $brandType === 'title' ? 'checked' : '' ?> id="site-brand-type-title">
                                <span>Título (texto como marca)</span>
                            </label>
                            <label class="settings-choice">
                                <input type="radio" name="site[brand_type]" value="logo" <?= $brandType === 'logo' ? 'checked' : '' ?> id="site-brand-type-logo">
                                <span>Logo (imagem)</span>
                            </label>
                        </div>
                    </div>

                    <div id="site-title-group" class="settings-field settings-nested <?= $brandType === 'title' ? '' : 'is-hidden' ?>">
                        <label>Título do Site</label>
                        <input type="text"
                               name="site[title][value]"
                               value="<?= htmlspecialchars(!empty($site['title']['value']) ? $site['title']['value'] : 'Web Roxmu') ?>"
                               id="site-title-value">
                        <small>Texto exibido como marca no cabeçalho (quando não for imagem)</small>
                    </div>

                    <div id="site-logo-group" class="settings-field settings-nested <?= $brandType === 'logo' ? '' : 'is-hidden' ?>">
                        <label>Caminho do Logo</label>
                        <input type="text"
                               name="site[logo][value]"
                               id="site-logo-value"
                               value="<?= htmlspecialchars(!empty($site['logo']['value']) ? $site['logo']['value'] : 'images/logo.png') ?>"
>
                        <small>Caminho relativo ao diretório de assets. Ou envie uma nova imagem abaixo.</small>

                        <div class="settings-field settings-nested">
                            <label>Enviar nova imagem (substitui o logo atual)</label>
                            <input type="file" name="site_logo_upload" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp">
                            <small>Formatos aceitos: PNG, JPG, GIF, WebP.</small>
                        </div>

                        <?php if (!empty($site['logo']['value']) && function_exists('assets')): ?>
                            <div class="settings-preview">
                                <span class="settings-preview__label">Preview</span>
                                <div class="settings-preview__frame">
                                    <img src="<?= assets($site['logo']['value']) ?>?v=<?= time() ?>" alt="Logo" onerror="this.parentElement.style.display='none'">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="settings-field">
                        <label class="settings-toggle">
                            <input type="hidden" name="site[description][enabled]" value="0">
                            <input type="checkbox" name="site[description][enabled]" value="1" <?= !empty($site['description']['enabled']) ? 'checked' : '' ?> id="site-description-enabled">
                            Ativar descrição
                        </label>
                        <div id="site-description-group" class="settings-field settings-nested <?= !empty($site['description']['enabled']) ? '' : 'is-hidden' ?>">
                            <label>Descrição do Site</label>
                            <textarea name="site[description][value]"
                                      rows="2"
                                      <?= !empty($site['description']['enabled']) ? 'required' : '' ?>><?= htmlspecialchars(!empty($site['description']['value']) ? $site['description']['value'] : '') ?></textarea>
                            <small>Descrição exibida no cabeçalho do site.</small>
                        </div>
                    </div>

                    <div class="settings-field">
                        <label class="settings-toggle">
                            <input type="hidden" name="site[page_title][enabled]" value="0">
                            <input type="checkbox" name="site[page_title][enabled]" value="1" <?= !empty($site['page_title']['enabled']) ? 'checked' : '' ?> id="site-page-title-enabled">
                            Ativar título da página
                        </label>
                        <div id="site-page-title-group" class="settings-field settings-nested <?= !empty($site['page_title']['enabled']) ? '' : 'is-hidden' ?>">
                            <label>Título da Página (tag &lt;title&gt;)</label>
                            <input type="text"
                                   name="site[page_title][value]"
                                   value="<?= htmlspecialchars(!empty($site['page_title']['value']) ? $site['page_title']['value'] : 'Web Roxmu - Servidor de Mu Online') ?>"
                                   <?= !empty($site['page_title']['enabled']) ? 'required' : '' ?>>
                            <small>Título exibido na aba do navegador.</small>
                        </div>
                    </div>

                    <div class="settings-field">
                        <label class="settings-toggle">
                            <input type="hidden" name="site[footer][enabled]" value="0">
                            <input type="checkbox" name="site[footer][enabled]" value="1" <?= !empty($site['footer']['enabled']) ? 'checked' : '' ?> id="site-footer-enabled">
                            Ativar footer
                        </label>
                        <div id="site-footer-group" class="settings-field settings-nested <?= !empty($site['footer']['enabled']) ? '' : 'is-hidden' ?>">
                            <label>Texto do Footer</label>
                            <input type="text"
                                   name="site[footer][value]"
                                   value="<?= htmlspecialchars(!empty($site['footer']['value']) ? $site['footer']['value'] : 'Web Roxmu') ?>"
                                   <?= !empty($site['footer']['enabled']) ? 'required' : '' ?>>
                            <small>Texto exibido no rodapé (o ano é inserido automaticamente).</small>
                        </div>
                    </div>
                </div>

                <div class="settings-card">
                    <h3 class="subtitle">Fontes do site</h3>
                    <p class="settings-desc">Nome exato da fonte no Google Fonts. Padrão: Space Grotesk e Inter.</p>
                    <div class="grid-2">
                        <div class="settings-field">
                            <label>Fonte 1 – Site principal</label>
                            <input type="text" name="site[font_primary]" value="<?= htmlspecialchars($site['font_primary'] ?? 'Space Grotesk') ?>" >
                            <small>Ex.: Space Grotesk</small>
                        </div>
                        <div class="settings-field">
                            <label>Fonte 2 – Site principal</label>
                            <input type="text" name="site[font_secondary]" value="<?= htmlspecialchars($site['font_secondary'] ?? 'Inter') ?>" >
                            <small>Ex.: Inter</small>
                        </div>
                        <div class="settings-field">
                            <label>Fonte 1 – Admin</label>
                            <input type="text" name="site[font_admin_primary]" value="<?= htmlspecialchars($site['font_admin_primary'] ?? 'Space Grotesk') ?>" >
                            <small>Ex.: Space Grotesk</small>
                        </div>
                        <div class="settings-field">
                            <label>Fonte 2 – Admin</label>
                            <input type="text" name="site[font_admin_secondary]" value="<?= htmlspecialchars($site['font_admin_secondary'] ?? 'Inter') ?>" >
                            <small>Ex.: Inter</small>
                        </div>
                    </div>
                </div>

                <div class="settings-card">
                    <h3 class="subtitle">Requisitos Mínimos do Sistema</h3>
                    <p class="settings-desc">Exibidos na página de downloads.</p>
                    <div class="grid-2">
                        <div class="settings-field">
                            <label>CPU - Mínimo</label>
                            <input type="text" name="download_requirements[cpu_min]" value="<?= htmlspecialchars(config('download_requirements.cpu_min', 'Single Core - 1.5 Ghz')) ?>" >
                        </div>
                        <div class="settings-field">
                            <label>CPU - Recomendado</label>
                            <input type="text" name="download_requirements[cpu_recommended]" value="<?= htmlspecialchars(config('download_requirements.cpu_recommended', 'Dual Core 2.0 Ghz (ou superior)')) ?>" >
                        </div>
                        <div class="settings-field">
                            <label>RAM - Mínimo</label>
                            <input type="text" name="download_requirements[ram_min]" value="<?= htmlspecialchars(config('download_requirements.ram_min', '1GB')) ?>" >
                        </div>
                        <div class="settings-field">
                            <label>RAM - Recomendado</label>
                            <input type="text" name="download_requirements[ram_recommended]" value="<?= htmlspecialchars(config('download_requirements.ram_recommended', '2GB (ou superior)')) ?>" >
                        </div>
                        <div class="settings-field">
                            <label>OS - Mínimo</label>
                            <input type="text" name="download_requirements[os_min]" value="<?= htmlspecialchars(config('download_requirements.os_min', 'Windows 7')) ?>" >
                        </div>
                        <div class="settings-field">
                            <label>OS - Recomendado</label>
                            <input type="text" name="download_requirements[os_recommended]" value="<?= htmlspecialchars(config('download_requirements.os_recommended', 'Windows 10 ou 11')) ?>" >
                        </div>
                        <div class="settings-field">
                            <label>Placa de Vídeo - Mínimo</label>
                            <input type="text" name="download_requirements[video_min]" value="<?= htmlspecialchars(config('download_requirements.video_min', '128MB / 64 Bits')) ?>" >
                        </div>
                        <div class="settings-field">
                            <label>Placa de Vídeo - Recomendado</label>
                            <input type="text" name="download_requirements[video_recommended]" value="<?= htmlspecialchars(config('download_requirements.video_recommended', '256MB / 128 Bits (ou superior)')) ?>" >
                        </div>
                    </div>
                </div>

                <div class="settings-card">
                    <h3 class="subtitle">Template</h3>
                    <div class="settings-field">
                        <label>Nome do Tema (pasta)</label>
                        <input type="text" name="template[theme]" value="<?= htmlspecialchars($template['theme'] ?? '') ?>" >
                        <small>Nome da pasta em <code>template/</code> (ex: default)</small>
                    </div>
                </div>
            </div>

            <div class="tab-content settings-panel" id="server">
                <div class="settings-card">
                    <h3 class="subtitle">Importar Itens</h3>
                    <p class="settings-desc">Coloque o Item.txt do seu MuServer na pasta <code>storage/item/</code> e clique em Sincronizar para atualizar os nomes dos itens no site.</p>
                    <div class="settings-field">
                        <button type="button" id="btn-update-items" class="btn btn-primary btn-sm">
                            <i class="ph-fill ph-arrows-clockwise"></i> Sincronizar Itens (Item.txt)
                        </button>
                        <div id="update-items-result" class="settings-feedback"></div>
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
                            <input type="text" name="experience" value="<?= htmlspecialchars($server['experience']) ?>"  required>
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
                            <input type="text" name="pvp" value="<?= htmlspecialchars($server['pvp']) ?>"  required>
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
                            <label class="settings-choice">
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
                            <div class="settings-inline">
                                <input type="password" name="db_pass" id="db_pass" value="<?= htmlspecialchars($database['passwd'] ?? '') ?>" class="settings-inline__fill" required>
                                <button type="button" class="btn btn-warning btn-sm" onclick="toggleDbPassword()" title="Mostrar / Ocultar"><i class="ph ph-eye"></i></button>
                            </div>
                            <small>Senha do usuário do banco</small>
                        </div>
                    </div>
                    <div class="settings-inline settings-inline--spaced">
                        <button type="button" class="btn btn-primary btn-sm" onclick="testDbConnection()"><i class="ph ph-plug"></i> Testar Conexão</button>
                        <div id="db-test-result"></div>
                    </div>
                    <small>Teste a conexão antes de salvar</small>
                </div>
            </div>

            <div class="tab-content settings-panel" id="admin">
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
            </div>

            <script>
                (function() {
                    var titleGroup = document.getElementById('site-title-group');
                    var logoGroup = document.getElementById('site-logo-group');
                    var titleRadio = document.getElementById('site-brand-type-title');
                    var logoRadio = document.getElementById('site-brand-type-logo');
                    if (titleRadio && titleGroup && logoGroup) {
                        titleRadio.addEventListener('change', function() {
                            titleGroup.classList.remove('is-hidden');
                            logoGroup.classList.add('is-hidden');
                        });
                    }
                    if (logoRadio && titleGroup && logoGroup) {
                        logoRadio.addEventListener('change', function() {
                            titleGroup.classList.add('is-hidden');
                            logoGroup.classList.remove('is-hidden');
                        });
                    }
                })();
            </script>
            <script>
                (function() {
                    var descEnabled = document.getElementById('site-description-enabled');
                    var descGroup = document.getElementById('site-description-group');
                    if (descEnabled && descGroup) descEnabled.addEventListener('change', function() { descGroup.classList.toggle('is-hidden', !this.checked); });
                    var pageTitleEnabled = document.getElementById('site-page-title-enabled');
                    var pageTitleGroup = document.getElementById('site-page-title-group');
                    if (pageTitleEnabled && pageTitleGroup) pageTitleEnabled.addEventListener('change', function() { pageTitleGroup.classList.toggle('is-hidden', !this.checked); });
                    var footerEnabled = document.getElementById('site-footer-enabled');
                    var footerGroup = document.getElementById('site-footer-group');
                    if (footerEnabled && footerGroup) footerEnabled.addEventListener('change', function() { footerGroup.classList.toggle('is-hidden', !this.checked); });
                })();
            </script>

            <div class="tab-content settings-panel" id="rankings">
                <div class="settings-card">
                    <h3 class="subtitle">Configuração de Cache</h3>
                    
                    <div>
                        <label>
                            <input type="hidden" name="rankings[cache][enabled]" value="0">
                            <input type="checkbox" 
                                   name="rankings[cache][enabled]" 
                                   value="1"
                                   <?= !empty($rankings['cache']['enabled']) ? 'checked' : '' ?>
                                   id="ranking-cache-enabled">
                            Ativar Cache de Rankings
                        </label>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Quando ativado, os rankings serão armazenados em cache para melhorar a performance
                        </small>
                    </div>

                    <div id="ranking-cache-settings" style="<?= empty($rankings['cache']['enabled']) ? 'display: none;' : '' ?>">
                        <div>
                            <label for="ranking-cache-interval">Intervalo de Atualização (minutos)</label>
                            <input type="number" 
                                   name="rankings[cache][interval]" 
                                   id="ranking-cache-interval"
                                   value="<?= htmlspecialchars($rankings['cache']['interval'] ?? 30) ?>"
                                   min="5"
                                   max="1440"
                                   required>
                            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                Tempo em minutos que o cache será mantido antes de atualizar (mínimo: 5, máximo: 1440)
                            </small>
                        </div>
                        
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--neutral-300);">
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    id="clear-ranking-cache"
                                    onclick="clearRankingCache()">
                                <i class="ph ph-trash"></i> Limpar Cache de Rankings
                            </button>
                            <div id="clear-ranking-cache-result" class="settings-feedback" style="margin-top: 8px; display: none;"></div>
                            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                Use este botão após trocar de banco de dados ou quando os rankings estiverem desatualizados
                            </small>
                        </div>
                    </div>
                </div>

                <div class="settings-card">
                    <h3 class="subtitle">Rankings - Geral</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Rankings disponíveis na página de rankings completa. Por padrão vêm os rankings padrão; a opção <strong>Remover</strong> funciona normalmente. Se quiser remover todos e alterar à sua maneira, pode fazer — a escolha é sua.
                </small>

                <div class="form" style="margin-bottom: 15px;">
                    <label style="display:flex; gap:10px; align-items:center;">
                        <input type="checkbox" name="rankings[geral_prune_disabled]" value="1">
                        Limpar rankings desativados antigos ao salvar (remove do arquivo e não volta mais)
                    </label>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Útil para “limpar sujeira” de configurações antigas. Se marcar e salvar, os itens com <strong>Ativo</strong> desmarcado serão removidos.
                    </small>
                </div>

                <?php
                $geralRankings = $rankings['geral'] ?? [];
                if (!is_array($geralRankings)) {
                    $geralRankings = [];
                }
                ?>

                <div id="rankings-geral-container" class="space-y-1">
                    <?php foreach ($geralRankings as $i => $rank): ?>
                        <?php if (!is_array($rank)) continue; ?>
                        <div class="form ranking-item space-y-1" data-ranking-index="<?= $i ?>">
                            <label>
                                <input type="hidden"
                                       name="rankings[geral][<?= $i ?>][enabled]"
                                       value="0">
                                <input type="checkbox"
                                       name="rankings[geral][<?= $i ?>][enabled]"
                                       value="1"
                                       <?= !empty($rank['enabled']) ? 'checked' : '' ?>>
                                Ativo
                            </label>

                            <div>
                                <label>Título</label>
                                <input type="text"
                                       name="rankings[geral][<?= $i ?>][title]"
                                       value="<?= htmlspecialchars($rank['title'] ?? '') ?>"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Título exibido no ranking
                                </small>
                            </div>

                            <div class="grid-2">
                                <div>
                                    <label>Tabela</label>
                                    <input type="text"
                                           name="rankings[geral][<?= $i ?>][table]"
                                           value="<?= htmlspecialchars($rank['table'] ?? '') ?>"
                                           required>
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Nome da tabela no banco de dados
                                    </small>
                                </div>

                                <div>
                                    <label>Coluna</label>
                                    <input type="text"
                                           name="rankings[geral][<?= $i ?>][column]"
                                           value="<?= htmlspecialchars($rank['column'] ?? '') ?>"
                                           required>
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Nome da coluna que será ordenada
                                    </small>
                                </div>
                            </div>

                            <div class="grid-2">
                                <div>
                                    <label>Tag</label>
                                    <input type="text"
                                           name="rankings[geral][<?= $i ?>][tag]"
                                           value="<?= htmlspecialchars($rank['tag'] ?? '') ?>"
                                           required>
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Abreviação/tag do ranking (ex: RD, RS, PK, HR)
                                    </small>
                                </div>

                                <div>
                                    <label>Slug</label>
                                    <input type="text"
                                           name="rankings[geral][<?= $i ?>][slug]"
                                           value="<?= htmlspecialchars($rank['slug'] ?? '') ?>"
                                           required>
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Identificador único usado na URL (ex: resets-diarios, pk-total)
                                    </small>
                                </div>
                            </div>

                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #333;">
                                <button type="button" class="btn btn-danger btn-sm remove-ranking-geral" title="Remover">
                                    <i class="ph ph-x" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="space-y-1">
                    <button type="button" class="btn btn-success" id="add-ranking-geral">
                        <i class="ph ph-plus"></i> Adicionar Ranking
                    </button>
                </div>
            </div>

            <div class="tab-content settings-panel space-y-2" id="user">
                <h3 class="subtitle">Coin</h3>


                <h4 class="subtitle">Coins</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure as moedas/coins disponíveis no servidor e suas tabelas no banco de dados
                </small>

                <div id="coins-container" class="space-y-1">
                    <?php foreach (($user['coins'] ?? []) as $i => $coin): ?>
                        <div class="form coin-item space-y-1">
                            <div style="display:flex; justify-content:space-between; align-items:center">
                                <strong class="sub-title coin-title-<?= $i ?>"><?= htmlspecialchars($coin['title'] ?? 'Coin') ?></strong>
                                <button type="button" class="btn btn-danger btn-sm remove-coin" title="Remover">
                                    <i class="ph ph-x" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div>
                                <label>Título</label>
                                <input type="text"
                                       name="user[coins][<?= $i ?>][title]"
                                       value="<?= htmlspecialchars($coin['title']) ?>"
                                       class="coin-title-input"
                                       data-coin-index="<?= $i ?>"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Nome da moeda exibido no site
                                </small>
                            </div>

                            <div>
                                <label>Tabela</label>
                                <input type="text"
                                       name="user[coins][<?= $i ?>][table]"
                                       value="<?= htmlspecialchars($coin['table']) ?>"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Nome da tabela no banco de dados onde a moeda está armazenada
                                </small>
                            </div>

                            <div>
                                <label>Coluna Conta</label>
                                <input type="text"
                                       name="user[coins][<?= $i ?>][column_account]"
                                       value="<?= htmlspecialchars($coin['column_account']) ?>"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Nome da coluna que identifica a conta (ex: AccountID, memb___id)
                                </small>
                            </div>

                            <div>
                                <label>Coluna Coin</label>
                                <input type="text"
                                       name="user[coins][<?= $i ?>][column_coin]"
                                       value="<?= htmlspecialchars($coin['column_coin']) ?>"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Nome da coluna que armazena o valor da moeda
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div>
                    <button type="button" class="btn btn-success" id="add-coin">
                        <i class="ph ph-plus"></i> Adicionar Coin
                    </button>
                </div>

            </div>

            <div class="tab-content settings-panel space-y-2" id="mail">
                <h3 class="subtitle">Configurações de E-mail</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure o servidor SMTP para envio de e-mails (recuperação de senha, notificações, etc.)
                </small>

                <div class="grid-2">
                    <div>
                        <label>Host SMTP</label>
                        <input type="text" 
                               name="mail_host" 
                               value="<?= htmlspecialchars($mail['host']) ?>" 
>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Endereço do servidor SMTP (ex: smtp.gmail.com, smtp.outlook.com)
                        </small>
                    </div>

                    <div>
                        <label>Porta SMTP</label>
                        <input type="number" 
                               name="mail_port" 
                               value="<?= (int)$mail['port'] ?>" 
>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Porta do servidor SMTP (587 para TLS, 465 para SSL, 25 para não criptografado)
                        </small>
                    </div>

                    <div>
                        <label>Usuário SMTP</label>
                        <input type="text" 
                               name="mail_username" 
                               value="<?= htmlspecialchars($mail['username']) ?>" 
>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            E-mail ou usuário para autenticação no servidor SMTP
                        </small>
                    </div>

                    <div>
                        <label>Senha SMTP</label>
                        <input type="password" 
                               name="mail_password" 
                               value="<?= htmlspecialchars($mail['password']) ?>">
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Senha do e-mail ou senha de aplicativo (Gmail requer senha de app)
                        </small>
                    </div>

                    <div style="grid-column: span 2">
                        <label>E-mail Remetente</label>
                        <input type="email" 
                               name="mail_email" 
                               value="<?= htmlspecialchars($mail['email']) ?>" 
>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            E-mail que aparecerá como remetente nas mensagens enviadas
                        </small>
                    </div>
                </div>
            </div>

            <div class="tab-content settings-panel space-y-2" id="security">
                <h3 class="subtitle">Segurança</h3>

                <h4 class="subtitle">Criptografia de senhas (players)</h4>
                <div class="form-group">
                    <label>Tipo de hash</label>
                    <select name="user[password_hash_type]" required>
                        <?php
                        $hashTypes = [
                            'plain' => 'Texto Puro (sem hash)',
                            'md5' => 'MD5',
                            'sha256' => 'SHA256'
                        ];
                        $currentHashType = $user['password_hash_type'] ?? 'plain';
                        ?>
                        <?php foreach ($hashTypes as $value => $label): ?>
                            <option value="<?= htmlspecialchars($value) ?>"
                                <?= $currentHashType === $value ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-hint" style="color: var(--text-warning, #f59e0b);">Alterar afeta apenas novas senhas; as antigas seguem válidas até serem trocadas.</small>
                </div>

                <hr style="margin:30px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Proteção DDoS</h4>
                <div class="form-group">
                    <label>
                        <input type="checkbox"
                               name="ddos[enabled]"
                               value="1"
                               <?= ($ddos['enabled'] ?? true) ? 'checked' : '' ?>>
                        Habilitar proteção DDoS
                    </label>
                </div>

                <hr style="margin:30px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Rate limiting global</h4>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Máximo de requisições por IP</label>
                        <input type="number"
                               name="ddos[global_rate_limit][max_requests]"
                               value="<?= htmlspecialchars($ddos['global_rate_limit']['max_requests'] ?? 300) ?>"
                               min="1"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Janela (segundos)</label>
                        <input type="number"
                               name="ddos[global_rate_limit][window_seconds]"
                               value="<?= htmlspecialchars($ddos['global_rate_limit']['window_seconds'] ?? 60) ?>"
                               min="1"
                               required>
                        <small class="form-hint">ex.: 60 = 1 minuto</small>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Limites por rota sensível</h4>

                <div id="ddos-routes-container" class="space-y-1">
                    <?php 
                    $routeIndex = 0;
                    foreach ($ddos['route_limits'] ?? [] as $route => $config): 
                    ?>
                    <div class="ddos-route-item" data-index="<?= $routeIndex ?>">
                        <div class="grid-3">
                            <div>
                                <label>Rota</label>
                                <input type="text" 
                                       name="ddos[route_limits][<?= $routeIndex ?>][route]" 
                                       value="<?= htmlspecialchars($route) ?>" 
                                       required>
                            </div>
                            <div>
                                <label>Máximo</label>
                                <input type="number" 
                                       name="ddos[route_limits][<?= $routeIndex ?>][max]" 
                                       value="<?= htmlspecialchars($config['max'] ?? 10) ?>" 
                                       min="1" 
                                       required>
                            </div>
                            <div>
                                <label>Janela (segundos)</label>
                                <input type="number" 
                                       name="ddos[route_limits][<?= $routeIndex ?>][window]" 
                                       value="<?= htmlspecialchars($config['window'] ?? 60) ?>" 
                                       min="1" 
                                       required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-ddos-route" style="margin-top: 8px;" title="Remover">
                            <i class="ph ph-x" aria-hidden="true"></i>
                        </button>
                    </div>
                    <?php 
                    $routeIndex++;
                    endforeach; 
                    ?>
                </div>

                <button type="button" class="btn btn-primary btn-sm" id="add-ddos-route" style="margin-top: 10px;">
                    <i class="ph ph-plus"></i> Adicionar Rota
                </button>

                <hr style="margin:30px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Padrões suspeitos</h4>
                <p class="form-hint" style="margin-bottom:12px;">Em site de jogos, mantenha desabilitado ou use limites altos para não bloquear jogadores (múltiplas abas, rankings, refresh).</p>
                <div class="form-group">
                    <label>
                        <input type="checkbox"
                               name="ddos[suspicious_patterns][enabled]"
                               value="1"
                               <?= ($ddos['suspicious_patterns']['enabled'] ?? false) ? 'checked' : '' ?>>
                        Habilitar detecção
                    </label>
                </div>
                <div class="grid-3">
                    <div class="form-group">
                        <label>User-Agent mínimo (caracteres)</label>
                        <input type="number"
                               name="ddos[suspicious_patterns][min_user_agent_length]"
                               value="<?= htmlspecialchars($ddos['suspicious_patterns']['min_user_agent_length'] ?? 10) ?>"
                               min="1"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Limite requisições rápidas</label>
                        <input type="number"
                               name="ddos[suspicious_patterns][rapid_request_threshold]"
                               value="<?= htmlspecialchars($ddos['suspicious_patterns']['rapid_request_threshold'] ?? 120) ?>"
                               min="1"
                               required>
                        <small class="form-hint">Recomendado 100–150 para jogos</small>
                    </div>
                    <div class="form-group">
                        <label>Janela (segundos)</label>
                        <input type="number"
                               name="ddos[suspicious_patterns][rapid_request_window]"
                               value="<?= htmlspecialchars($ddos['suspicious_patterns']['rapid_request_window'] ?? 5) ?>"
                               min="1"
                               required>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Bloqueio automático de IPs</h4>
                <div class="form-group">
                    <label>
                        <input type="checkbox"
                               name="ddos[ip_blocking][enabled]"
                               value="1"
                               <?= ($ddos['ip_blocking']['enabled'] ?? true) ? 'checked' : '' ?>>
                        Habilitar bloqueio
                    </label>
                </div>
                <div class="form-group">
                    <label>Duração do bloqueio (segundos)</label>
                    <input type="number"
                           name="ddos[ip_blocking][block_duration]"
                           value="<?= htmlspecialchars($ddos['ip_blocking']['block_duration'] ?? 1800) ?>"
                           min="1"
                           required>
                    <small class="form-hint">ex.: 1800 = 30 min (recomendado para jogos), 3600 = 1 hora</small>
                </div>

                <hr style="margin:30px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Requisições simultâneas</h4>
                <p class="form-hint" style="margin-bottom:12px;">Recomendado desligado em site de jogos (jogador com jogo + site em várias abas é normal). Só ativa atrás de Cloudflare.</p>
                <div class="form-group">
                    <label>
                        <input type="checkbox"
                               name="ddos[concurrent_requests][enabled]"
                               value="1"
                               <?= ($ddos['concurrent_requests']['enabled'] ?? false) ? 'checked' : '' ?>>
                        Habilitar (pode bloquear usuários legítimos)
                    </label>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Máximo simultâneas</label>
                        <input type="number"
                               name="ddos[concurrent_requests][max_concurrent]"
                               value="<?= htmlspecialchars($ddos['concurrent_requests']['max_concurrent'] ?? 50) ?>"
                               min="1"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Janela (segundos)</label>
                        <input type="number"
                               name="ddos[concurrent_requests][window_seconds]"
                               value="<?= htmlspecialchars($ddos['concurrent_requests']['window_seconds'] ?? 5) ?>"
                               min="1"
                               required>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Google reCAPTCHA</h4>
                <div class="form-group">
                    <label>
                        <input type="checkbox"
                               name="recaptcha[enabled]"
                               value="1"
                               <?= ($recaptcha['enabled'] ?? false) ? 'checked' : '' ?>
                               onchange="document.getElementById('recaptcha-config').style.display = this.checked ? 'block' : 'none';">
                        Habilitar reCAPTCHA (login, registro, recuperação de senha)
                    </label>
                </div>

                <div id="recaptcha-config" style="display: <?= ($recaptcha['enabled'] ?? false) ? 'block' : 'none' ?>; margin-top: 20px;">
                    <div class="grid-2">
                        <div class="form-group">
                            <label>Versão</label>
                            <select name="recaptcha[version]" required>
                                <option value="v2" <?= ($recaptcha['version'] ?? 'v2') === 'v2' ? 'selected' : '' ?>>v2 (checkbox)</option>
                                <option value="v3" <?= ($recaptcha['version'] ?? 'v2') === 'v3' ? 'selected' : '' ?>>v3 (invisível)</option>
                            </select>
                        </div>
                        <div id="recaptcha-score-config" class="form-group" style="display: <?= ($recaptcha['version'] ?? 'v2') === 'v3' ? 'block' : 'none' ?>;">
                            <label>Score mínimo (v3)</label>
                            <input type="number"
                                   name="recaptcha[score_threshold]"
                                   value="<?= htmlspecialchars($recaptcha['score_threshold'] ?? 0.5) ?>"
                                   min="0"
                                   max="1"
                                   step="0.1">
                            <small class="form-hint">0 = bot, 1 = humano. Recomendado: 0,5</small>
                        </div>
                    </div>

                    <div class="grid-2" style="margin-top: 15px;">
                        <div class="form-group">
                            <label>Site Key</label>
                            <input type="text"
                                   name="recaptcha[site_key]"
                                   value="<?= htmlspecialchars($recaptcha['site_key'] ?? '') ?>"
>
                            <small class="form-hint"><a href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener" style="color: var(--primary-color);">Obter chaves</a></small>
                        </div>
                        <div class="form-group">
                            <label>Secret Key</label>
                            <input type="text"
                                   name="recaptcha[secret_key]"
                                   value="<?= htmlspecialchars($recaptcha['secret_key'] ?? '') ?>"
>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content settings-panel space-y-2" id="vip">
                <h3 class="subtitle">Configurações VIP</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure o sistema VIP e os tipos disponíveis
                </small>

                <div>
                    <label>Coluna VIP</label>
                    <input type="text"
                           name="user[vip][column]"
                           value="<?= htmlspecialchars($user['vip']['column'] ?? '') ?>"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Nome da coluna no banco de dados que armazena o tipo VIP
                    </small>
                </div>

                <div>
                    <label>Coluna data de expiração VIP</label>
                    <input type="text"
                           name="user[vip][column_expire]"
                           value="<?= htmlspecialchars($user['vip']['column_expire'] ?? 'AccountExpireDate') ?>"
>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Nome da coluna no banco (ex: AccountExpireDate) que armazena a data em que o VIP expira
                    </small>
                </div>

                <div>
                    <label>Tipo de VIP ao Registrar</label>
                    <select name="user[vip][register][type]">
                        <?php foreach (($user['vip']['name'] ?? []) as $i => $vipName): ?>
                            <option value="<?= $i ?>"
                                <?= ((int)($user['vip']['register']['type'] ?? 0) === (int)$i) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($vipName) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Tipo VIP que será atribuído automaticamente ao criar nova conta
                    </small>
                </div>

                <div>
                    <label>
                        <input type="hidden"
                               name="user[vip][register][active]"
                               value="0">
                        <input type="checkbox"
                               name="user[vip][register][active]"
                               value="1"
                               <?= !empty($user['vip']['register']['active']) ? 'checked' : '' ?>>
                        Registrar VIP Automático
                    </label>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Se ativado, novas contas receberão VIP automaticamente ao se registrar
                    </small>
                </div>

                <div>
                    <label>Dias VIP</label>
                    <input type="number"
                           name="user[vip][register][days]"
                           value="<?= (int)($user['vip']['register']['days'] ?? 0) ?>"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Quantidade de dias de VIP ao registrar (se VIP automático estiver ativo)
                    </small>
                </div>

                <h5 class="subtitle">Tipos do VIP</h5>

                <div class="grid-2">
                    <?php foreach (($user['vip']['name'] ?? []) as $k => $vipName): ?>
                        <div>
                            <label>VIP <?= $k ?></label>
                            <input type="text"
                                   name="user[vip][name][<?= $k ?>]"
                                   value="<?= htmlspecialchars($vipName) ?>"
                                   required>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="tab-content settings-panel space-y-2" id="vip-packs">
                <h3 class="subtitle">Donate</h3>
                <p class="form-hint" style="margin-bottom: 1rem;">
                    Gateways (MercadoPago, Stripe, PayPal) e pacotes: <a href="<?= route('admin/plugins/manage?plugin=gatewaypayment') ?>" style="color: var(--primary-color);">Plugins → Gateway Payment</a> e <a href="<?= route('admin/plugins/manage?plugin=donate') ?>" style="color: var(--primary-color);">Plugins → Donate</a>.
                </p>
                <p class="form-hint" style="margin-bottom: 1rem;">
                    No sistema atual, a moeda de cada pacote é definida no plugin Donate (WCoinC, WCoinP, GoblinPoint ou custom). A tabela e coluna usadas para creditar vêm de <strong>Configurações → Coin (Moedas)</strong>, onde cada moeda tem sua tabela/coluna. Os campos abaixo são <strong>fallback</strong>: usados só se a moeda do pacote não existir em Moedas ou em doações no modo legado (multiplicador por valor).
                </p>

                <hr style="margin:20px 0;border-color:var(--border-color)">

                <h4 class="subtitle">Banco de dados – fallback (doações)</h4>
                <div class="form-group">
                    <label>Tabela (fallback)</label>
                    <input type="text"
                           name="user[donate][table]"
                           value="<?= htmlspecialchars($user['donate']['table'] ?? '') ?>"
                           required>
                    <small class="form-hint">Usado quando a moeda do pacote não está em Coin ou no modo legado.</small>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Coluna conta (fallback)</label>
                        <input type="text"
                               name="user[donate][column_account]"
                               value="<?= htmlspecialchars($user['donate']['column_account'] ?? '') ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Coluna moeda (fallback)</label>
                        <input type="text"
                               name="user[donate][column_coin]"
                               value="<?= htmlspecialchars($user['donate']['column_coin'] ?? '') ?>"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <input type="hidden" name="user[donate][active_multiplier]" value="0">
                        <input type="checkbox"
                               name="user[donate][active_multiplier]"
                               value="1"
                               <?= !empty($user['donate']['active_multiplier']) ? 'checked' : '' ?>>
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
                                <input type="number"
                                       name="user[donate][multiplier][<?= $i ?>][min]"
                                       value="<?= (int)($m['min'] ?? 0) ?>"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Max</label>
                                <input type="number"
                                       name="user[donate][multiplier][<?= $i ?>][max]"
                                       value="<?= (int)($m['max'] ?? 0) ?>"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Multiplicador</label>
                                <input type="number"
                                       name="user[donate][multiplier][<?= $i ?>][multiplier]"
                                       value="<?= (int)($m['multiplier'] ?? 1) ?>"
                                       required>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="tab-content settings-panel space-y-2" id="terms">
                <div class="settings-card">
                    <h3 class="subtitle">Termos de Uso e Regras do Jogo</h3>
                    <p class="settings-desc">
                        Configure o conteúdo dos termos de uso e regras do jogo que aparecem no formulário de cadastro.
                    </p>

                    <div class="settings-field">
                        <label>Termos de Uso</label>
                        <textarea
                            name="terms[content]"
                            id="terms-content"
                            rows="15"
><?= htmlspecialchars(is_string($terms['content'] ?? '') ? $terms['content'] : '') ?></textarea>
                        <small>Conteúdo dos termos de uso exibido na página de termos.</small>
                    </div>

                    <div class="settings-field">
                        <label>Regras do Jogo</label>
                        <textarea
                            name="rules[content]"
                            id="rules-content"
                            rows="15"
><?= htmlspecialchars(is_string($rules['content'] ?? '') ? $rules['content'] : '') ?></textarea>
                        <small>Conteúdo das regras do jogo exibido na página de regras.</small>
                    </div>

                    <div class="settings-note">
                        <strong>Informações</strong>
                        <ul style="margin: 0; padding-left: 20px;">
                            <li>O conteúdo será exibido nas páginas de termos e regras</li>
                            <li>Você pode usar HTML para formatar o texto</li>
                            <li>Os links aparecem no formulário de cadastro e abrem em nova aba</li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </div>
            <br>
            <button class="btn btn-primary" type="submit">
                <i class="ph ph-floppy-disk"></i> Salvar Configurações
            </button>

        </form>
</div>

<script>
  window.TEST_DB_URL = "<?= route('admin/settings/test-db') ?>";
  window.CLEAR_RANKING_CACHE_URL = "<?= route('admin/settings/clear-ranking-cache') ?>";
  window.COIN_INDEX = <?= count($user['coins'] ?? []) ?>;
</script>

<script>
    // Variável para o índice de rotas DDoS
    window.ddosRouteIndex = <?= isset($routeIndex) ? $routeIndex : count($ddos['route_limits'] ?? []) ?>;
</script>
<script>
    // Garantir que o app.js não intercepte esta página
    window.DISABLE_APP_JS_INTERCEPT = true;
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update Items
        const btnUpdateItems = document.getElementById('btn-update-items');
        const resultDiv = document.getElementById('update-items-result');

        if (btnUpdateItems) {
            btnUpdateItems.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="ph-fill ph-spinner animate-spin"></i> Processando...';
                this.disabled = true;
                if (resultDiv) {
                    resultDiv.classList.remove('settings-feedback--success', 'settings-feedback--error');
                    resultDiv.textContent = '';
                }

                const formData = new FormData();
                formData.append('_token', '<?= csrf_token() ?>');

                fetch('<?= route('admin/settings/update-items') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    
                    if (resultDiv) {
                        if (data.error) {
                            resultDiv.classList.add('settings-feedback--error');
                            resultDiv.textContent = 'Erro: ' + data.message;
                        } else {
                            resultDiv.classList.add('settings-feedback--success');
                            resultDiv.textContent = data.message;
                        }
                    }
                })
                .catch(error => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    if (resultDiv) {
                        resultDiv.classList.add('settings-feedback--error');
                        resultDiv.textContent = 'Erro ao processar requisição (' + error + ')';
                    }
                    console.error('Error:', error);
                });
            });
        }
    });
</script>
<script src="<?= assets('js/custom.js', 'admin') ?>?v=<?= time() ?>" defer></script>
