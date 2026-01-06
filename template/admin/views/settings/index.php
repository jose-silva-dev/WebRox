<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Configurações do Sistema</h1>

    <div class="form">

        <!-- ABAS -->
        <div class="tabs">
            <button class="tab active" data-tab="site">Site</button>
            <button class="tab" data-tab="server">Servidor</button>
            <button class="tab" data-tab="admin">Admin</button>
            <button class="tab" data-tab="rankings">Rankings</button>
            <button class="tab" data-tab="user">Coin</button>
            <button class="tab" data-tab="security">Segurança</button>
            <button class="tab" data-tab="mail">E-mail</button>
            <button class="tab" data-tab="discord">Discord</button>
            <button class="tab" data-tab="vip">Vip</button>
            <button class="tab" data-tab="vip-packs">Donate</button>
            <button class="tab" data-tab="terms">Termos e Regras</button>
        </div>

        <form action="<?= route('admin/settings/update') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>

            <!-- SITE -->
            <div class="tab-content active space-y-2" id="site">
                <h3 class="subtitle">Configurações do Site</h3>

                <div>
                    <label>Timezone</label>
                    <input type="text" 
                           name="timezone" 
                           value="<?= htmlspecialchars($site['timezone']) ?>" 
                           placeholder="America/Sao_Paulo"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Fuso horário do servidor (ex: America/Sao_Paulo, UTC, Europe/London)
                    </small>
                </div>
                
                <div>
                    <label>Licença (Customer Name)</label>
                    <input type="text"
                           name="license[customer_name]"
                           value="<?= htmlspecialchars($license['customer_name'] ?? '') ?>"
                           placeholder="ROXERA#######">
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <h3 class="subtitle">Informações do Site</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure o título, logo e descrição do site. Você pode desativar cada elemento individualmente.
                </small>

                <!-- TÍTULO -->
                <div class="form space-y-1">
                    <label>
                        <input type="hidden" name="site[title][enabled]" value="0">
                        <input type="checkbox" name="site[title][enabled]" value="1" <?= !empty($site['title']['enabled']) ? 'checked' : '' ?> id="site-title-enabled">
                        Ativar Título
                    </label>
                    <div id="site-title-group" style="display: <?= !empty($site['title']['enabled']) ? 'block' : 'none' ?>;">
                        <label>Título do Header</label>
                        <input type="text"
                               name="site[title][value]"
                               value="<?= htmlspecialchars(!empty($site['title']['value']) ? $site['title']['value'] : 'Web Roxmu') ?>"
                               placeholder="Web Roxmu"
                               <?= !empty($site['title']['enabled']) ? 'required' : '' ?>>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Título exibido no cabeçalho do site
                        </small>
                    </div>
                </div>

                <!-- LOGO -->
                <div class="form space-y-1" style="margin-top: 20px;">
                    <label>
                        <input type="hidden" name="site[logo][enabled]" value="0">
                        <input type="checkbox" name="site[logo][enabled]" value="1" <?= !empty($site['logo']['enabled']) ? 'checked' : '' ?> id="site-logo-enabled">
                        Ativar Logo
                    </label>
                    <div id="site-logo-group" style="display: <?= !empty($site['logo']['enabled']) ? 'block' : 'none' ?>;">
                        <label>Caminho do Logo</label>
                        <input type="text"
                               name="site[logo][value]"
                               value="<?= htmlspecialchars(!empty($site['logo']['value']) ? $site['logo']['value'] : 'images/logo.png') ?>"
                               placeholder="images/logo.png"
                               <?= !empty($site['logo']['enabled']) ? 'required' : '' ?>>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Caminho relativo ao diretório de assets (ex: images/logo.png)
                        </small>
                    </div>
                </div>

                <!-- DESCRIÇÃO -->
                <div class="form space-y-1" style="margin-top: 20px;">
                    <label>
                        <input type="hidden" name="site[description][enabled]" value="0">
                        <input type="checkbox" name="site[description][enabled]" value="1" <?= !empty($site['description']['enabled']) ? 'checked' : '' ?> id="site-description-enabled">
                        Ativar Descrição
                    </label>
                    <div id="site-description-group" style="display: <?= !empty($site['description']['enabled']) ? 'block' : 'none' ?>;">
                        <label>Descrição do Site</label>
                        <textarea name="site[description][value]"
                                  rows="3"
                                  placeholder="Web Roxmu is a web application that provides a platform for users to interact with each other."
                                  <?= !empty($site['description']['enabled']) ? 'required' : '' ?>><?= htmlspecialchars(!empty($site['description']['value']) ? $site['description']['value'] : 'Web Roxmu is a web application that provides a platform for users to interact with each other.') ?></textarea>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Descrição exibida no cabeçalho do site
                        </small>
                    </div>
                </div>

                <!-- TÍTULO DA PÁGINA -->
                <div class="form space-y-1" style="margin-top: 20px;">
                    <label>
                        <input type="hidden" name="site[page_title][enabled]" value="0">
                        <input type="checkbox" name="site[page_title][enabled]" value="1" <?= !empty($site['page_title']['enabled']) ? 'checked' : '' ?> id="site-page-title-enabled">
                        Ativar Título da Página
                    </label>
                    <div id="site-page-title-group" style="display: <?= !empty($site['page_title']['enabled']) ? 'block' : 'none' ?>;">
                        <label>Título da Página</label>
                        <input type="text"
                               name="site[page_title][value]"
                               value="<?= htmlspecialchars(!empty($site['page_title']['value']) ? $site['page_title']['value'] : 'Web Roxmu - Servidor de Mu Online') ?>"
                               placeholder="Web Roxmu - Servidor de Mu Online"
                               <?= !empty($site['page_title']['enabled']) ? 'required' : '' ?>>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Título exibido na aba do navegador (tag &lt;title&gt;)
                        </small>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="form space-y-1" style="margin-top: 20px;">
                    <label>
                        <input type="hidden" name="site[footer][enabled]" value="0">
                        <input type="checkbox" name="site[footer][enabled]" value="1" <?= !empty($site['footer']['enabled']) ? 'checked' : '' ?> id="site-footer-enabled">
                        Ativar Footer
                    </label>
                    <div id="site-footer-group" style="display: <?= !empty($site['footer']['enabled']) ? 'block' : 'none' ?>;">
                        <label>Texto do Footer</label>
                        <input type="text"
                               name="site[footer][value]"
                               value="<?= htmlspecialchars(!empty($site['footer']['value']) ? $site['footer']['value'] : 'Web Roxmu') ?>"
                               placeholder="Web Roxmu"
                               <?= !empty($site['footer']['enabled']) ? 'required' : '' ?>>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Texto exibido no rodapé do site (o ano será adicionado automaticamente)
                        </small>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <h3 class="subtitle">Requisitos Mínimos do Sistema</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure os requisitos mínimos do sistema que serão exibidos na página de downloads.
                </small>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                    <div>
                        <label>CPU - Mínimo</label>
                        <input type="text"
                               name="download_requirements[cpu_min]"
                               value="<?= htmlspecialchars(config('download_requirements.cpu_min', 'Single Core - 1.5 Ghz')) ?>"
                               placeholder="Single Core - 1.5 Ghz">
                    </div>
                    <div>
                        <label>CPU - Recomendado</label>
                        <input type="text"
                               name="download_requirements[cpu_recommended]"
                               value="<?= htmlspecialchars(config('download_requirements.cpu_recommended', 'Dual Core 2.0 Ghz (ou superior)')) ?>"
                               placeholder="Dual Core 2.0 Ghz (ou superior)">
                    </div>
                    <div>
                        <label>RAM - Mínimo</label>
                        <input type="text"
                               name="download_requirements[ram_min]"
                               value="<?= htmlspecialchars(config('download_requirements.ram_min', '1GB')) ?>"
                               placeholder="1GB">
                    </div>
                    <div>
                        <label>RAM - Recomendado</label>
                        <input type="text"
                               name="download_requirements[ram_recommended]"
                               value="<?= htmlspecialchars(config('download_requirements.ram_recommended', '2GB (ou superior)')) ?>"
                               placeholder="2GB (ou superior)">
                    </div>
                    <div>
                        <label>OS - Mínimo</label>
                        <input type="text"
                               name="download_requirements[os_min]"
                               value="<?= htmlspecialchars(config('download_requirements.os_min', 'Windows 7')) ?>"
                               placeholder="Windows 7">
                    </div>
                    <div>
                        <label>OS - Recomendado</label>
                        <input type="text"
                               name="download_requirements[os_recommended]"
                               value="<?= htmlspecialchars(config('download_requirements.os_recommended', 'Windows 10 ou 11')) ?>"
                               placeholder="Windows 10 ou 11">
                    </div>
                    <div>
                        <label>Placa de Vídeo - Mínimo</label>
                        <input type="text"
                               name="download_requirements[video_min]"
                               value="<?= htmlspecialchars(config('download_requirements.video_min', '128MB / 64 Bits')) ?>"
                               placeholder="128MB / 64 Bits">
                    </div>
                    <div>
                        <label>Placa de Vídeo - Recomendado</label>
                        <input type="text"
                               name="download_requirements[video_recommended]"
                               value="<?= htmlspecialchars(config('download_requirements.video_recommended', '256MB / 128 Bits (ou superior)')) ?>"
                               placeholder="256MB / 128 Bits (ou superior)">
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:#333">
       
                <h3 class="subtitle">Template</h3>

                <div>
                    <label>Nome do Tema (pasta)</label>
                    <input type="text"
                           name="template[theme]"
                           value="<?= htmlspecialchars($template['theme'] ?? '') ?>"
                           placeholder="default">
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Nome da pasta do template em <code>template/</code> (ex: default, admin)
                    </small>
                </div>
            </div>
            

            <!-- SERVIDOR -->
            <div class="tab-content space-y-2" id="server">
                <h3 class="subtitle">Configurações do Servidor</h3>

                <div class="grid-3">
                    <div>
                        <label>Nome do Servidor</label>
                        <input type="text" 
                               name="server_name" 
                               value="<?= htmlspecialchars($server['name']) ?>" 
                               placeholder="MuRox Premium"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Nome exibido no site
                        </small>
                    </div>

                    <div>
                        <label>Versão</label>
                        <input type="text" 
                               name="server_version" 
                               value="<?= htmlspecialchars($server['version']) ?>" 
                               placeholder="Season 6.3"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Versão do servidor
                        </small>
                    </div>

                    <div>
                        <label>Experiência</label>
                        <input type="text" 
                               name="experience" 
                               value="<?= htmlspecialchars($server['experience']) ?>" 
                               placeholder="1000x"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Taxa de experiência (ex: 1000x)
                        </small>
                    </div>

                    <div>
                        <label>Drop</label>
                        <input type="text" 
                               name="drop" 
                               value="<?= htmlspecialchars($server['drop']) ?>" 
                               placeholder="100%"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Taxa de drop (ex: 100%)
                        </small>
                    </div>

                    <div>
                        <label>Level Máximo</label>
                        <input type="number" 
                               name="level" 
                               value="<?= (int)$server['level'] ?>" 
                               placeholder="400"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Nível máximo permitido
                        </small>
                    </div>

                    <div>
                        <label>Pontos de Atributo</label>
                        <input type="number" 
                               name="points_attributes" 
                               value="<?= (int)$server['points_attributes'] ?>" 
                               placeholder="32767"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Pontos máximos por atributo
                        </small>
                    </div>

                    <div>
                        <label>PVP</label>
                        <input type="text" 
                               name="pvp" 
                               value="<?= htmlspecialchars($server['pvp']) ?>" 
                               placeholder="Balanceado"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Tipo de PVP (ex: Balanceado, Livre)
                        </small>
                    </div>

                    <div>
                        <label>Online Base</label>
                        <input type="number" 
                               name="online_base" 
                               value="<?= (int)$server['online_base'] ?>" 
                               placeholder="1"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Valor base para cálculo de online
                        </small>
                    </div>

                    <div>
                        <label>Multiplicador Online</label>
                        <input type="number" 
                               name="online_multiplier" 
                               value="<?= (int)$server['online_multiplier'] ?>" 
                               placeholder="0"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Multiplicador do online real
                        </small>
                    </div>
                </div>

                <hr style="margin: 25px 0; border-color: #333">

                <h3 class="subtitle">Configuração do Banco de Dados</h3>

                <div class="grid-2">
                    <div>
                        <label>Tipo de Conexão</label>
                        <input type="hidden" name="db_type" value="">
                        <label style="display:flex; align-items:center; gap:8px;">
                            <input type="checkbox"
                                   name="db_type"
                                   value="PDO::ConnectionSQLSRV"
                                   <?= ($database['type'] ?? '') === 'PDO::ConnectionSQLSRV' ? 'checked' : '' ?>>
                            pdo_sqlsrv
                        </label>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Driver de conexão com SQL Server (Microsoft)
                        </small>
                    </div>

                    <div>
                        <label>IP do Servidor</label>
                        <input type="text"
                               name="db_ip"
                               value="<?= htmlspecialchars($database['ip_vps'] ?? '') ?>"
                               placeholder="127.0.0.1"
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Endereço IP ou hostname do servidor SQL Server
                        </small>
                    </div>

                    <div>
                        <label>Nome do Banco de Dados</label>
                        <input type="text"
                               name="db_name"
                               value="<?= htmlspecialchars($database['dbname'] ?? '') ?>"
                               placeholder="MuOnlineS6"
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Nome do banco de dados no SQL Server
                        </small>
                    </div>

                    <div>
                        <label>Usuário</label>
                        <input type="text"
                               name="db_user"
                               value="<?= htmlspecialchars($database['user'] ?? '') ?>"
                               placeholder="sa"
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Usuário com permissão de acesso ao banco
                        </small>
                    </div>

                    <div>
                        <label>Senha</label>
                        <div style="display:flex; gap:6px;">
                            <input type="password"
                                   name="db_pass"
                                   id="db_pass"
                                   value="<?= htmlspecialchars($database['passwd'] ?? '') ?>"
                                   style="flex:1"
                                   required>
                            <button type="button"
                                    class="btn btn-warning"
                                    onclick="toggleDbPassword()"
                                    title="Mostrar / Ocultar">
                                <i class="ph ph-eye"></i>
                            </button>
                        </div>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Senha do usuário do banco de dados
                        </small>
                    </div>
                </div>

                <div style="margin-top:15px; display:flex; gap:10px; align-items:center;">
                    <button type="button" class="btn btn-primary" onclick="testDbConnection()">
                        <i class="ph ph-plug"></i> Testar Conexão
                    </button>
                    <div id="db-test-result"></div>
                </div>
                <small style="color: #999; font-size: 12px; display: block; margin-top: 8px;">
                    Teste a conexão antes de salvar para verificar se as credenciais estão corretas
                </small>

                <hr style="margin:30px 0;border-color:#333">

                <h3 class="subtitle">Servidores Online (Status)</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure os servidores do jogo para exibir status online no site
                </small>

                <div id="servers-container" class="space-y-1">
                    <?php foreach (($online_servers['list'] ?? []) as $i => $srv): ?>
                        <div class="form server-item space-y-1">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <strong class="sub-title">Servidor</strong>
                                <button type="button" class="btn btn-danger btn-sm remove-server">
                                    <i class="ph ph-trash"></i> Remover
                                </button>
                            </div>

                            <div>
                                <label>Nome do Servidor</label>
                                <input type="text"
                                       name="online_servers[list][<?= $i ?>][name]"
                                       value="<?= htmlspecialchars($srv['name'] ?? '') ?>"
                                       placeholder="Servidor Easy">
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Nome exibido no site (usado em toda a página inicial)
                                </small>
                            </div>

                            <div>
                                <label>Nome da Sala</label>
                                <input type="text"
                                       name="online_servers[list][<?= $i ?>][server_name]"
                                       value="<?= htmlspecialchars($srv['server_name'] ?? '') ?>"
                                       placeholder="Server01">
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Nome do servidor no banco de dados (ServerName) - usado APENAS para buscar quantidade de players online por sala
                                </small>
                            </div>

                            <div>
                                <label>IP do Servidor</label>
                                <input type="text"
                                       name="online_servers[list][<?= $i ?>][ip]"
                                       value="<?= htmlspecialchars($srv['ip']) ?>"
                                       placeholder="127.0.0.1">
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Endereço IP do servidor do jogo
                                </small>
                            </div>

                            <div>
                                <label>Porta</label>
                                <input type="number"
                                       name="online_servers[list][<?= $i ?>][port]"
                                       value="<?= (int)$srv['port'] ?>"
                                       placeholder="55901">
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Porta de conexão do servidor
                                </small>
                            </div>

                            <div>
                                <label>Máximo de Players</label>
                                <input type="number"
                                       name="online_servers[list][<?= $i ?>][max_players]"
                                       value="<?= (int)($srv['max_players'] ?? 100) ?>"
                                       placeholder="100"
                                       min="1"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Número máximo de players por servidor
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div>
                    <button type="button" class="btn btn-success" id="add-server">
                        <i class="ph ph-plus"></i> Adicionar Servidor
                    </button>
                </div>
            </div>

            <!-- ADMIN -->
            <div class="tab-content space-y-2" id="admin">
                <h3 class="subtitle">Acesso Administrativo</h3>

                <div>
                    <label>Login do Admin</label>
                    <input type="text"
                           name="admin[login]"
                           value="<?= htmlspecialchars($admin['login'] ?? '') ?>"
                           placeholder="admin"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Usuário para acessar o painel administrativo
                    </small>
                </div>

                <div>
                    <label>Senha do Admin</label>
                    <input type="text"
                           name="admin[password]"
                           value="<?= htmlspecialchars($admin['password'] ?? '') ?>"
                           placeholder="senha123"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Senha para acessar o painel administrativo (em texto plano)
                    </small>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <h3 class="subtitle">Staff</h3>

                <div>
                    <label>Código da Staff</label>
                    <input type="number"
                           name="staff_code"
                           value="<?= (int)($staff_code ?? 0) ?>"
                           placeholder="32"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Código numérico usado para identificar contas da equipe (staff) no banco de dados
                    </small>
                </div>
            </div>

            <!-- RANKINGS -->
            <div class="tab-content space-y-2" id="rankings">
                <!-- Configuração de Cache -->
                <div class="form space-y-1" style="background: var(--background-card); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--neutral-300); margin-bottom: 2rem;">
                    <h3 class="subtitle" style="margin-bottom: 1rem;">Configuração de Cache</h3>
                    
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
                            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                Use este botão após trocar de banco de dados ou quando os rankings estiverem desatualizados
                            </small>
                        </div>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <h3 class="subtitle">Rankings - Geral</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Rankings disponíveis na página de rankings completa
                </small>

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
                                       placeholder="Resets Diários"
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
                                           placeholder="Character"
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
                                           placeholder="ResetsDay"
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
                                           placeholder="RD"
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
                                           placeholder="resets-diarios"
                                           required>
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Identificador único usado na URL (ex: resets-diarios, pk-total)
                                    </small>
                                </div>
                            </div>

                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #333;">
                                <button type="button" class="btn btn-danger btn-sm remove-ranking-geral">
                                    <i class="ph ph-trash"></i> Remover
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

            <!-- USER -->
            <div class="tab-content space-y-2" id="user">
                <h3 class="subtitle">Coin</h3>

                <!-- COINS -->

                <!-- COINS -->
                <h4 class="subtitle">Coins</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure as moedas/coins disponíveis no servidor e suas tabelas no banco de dados
                </small>

                <div id="coins-container" class="space-y-1">
                    <?php foreach (($user['coins'] ?? []) as $i => $coin): ?>
                        <div class="form coin-item space-y-1">
                            <div style="display:flex; justify-content:space-between; align-items:center">
                                <strong class="sub-title coin-title-<?= $i ?>"><?= htmlspecialchars($coin['title'] ?? 'Coin') ?></strong>
                                <button type="button" class="btn btn-danger btn-sm remove-coin">
                                    <i class="ph ph-trash"></i> Remover
                                </button>
                            </div>

                            <div>
                                <label>Título</label>
                                <input type="text"
                                       name="user[coins][<?= $i ?>][title]"
                                       value="<?= htmlspecialchars($coin['title']) ?>"
                                       class="coin-title-input"
                                       data-coin-index="<?= $i ?>"
                                       placeholder="WCoinC"
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
                                       placeholder="CashShopData"
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
                                       placeholder="AccountID"
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
                                       placeholder="WCoinC"
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

            <!-- MAIL -->
            <div class="tab-content space-y-2" id="mail">
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
                               placeholder="smtp.gmail.com">
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Endereço do servidor SMTP (ex: smtp.gmail.com, smtp.outlook.com)
                        </small>
                    </div>

                    <div>
                        <label>Porta SMTP</label>
                        <input type="number" 
                               name="mail_port" 
                               value="<?= (int)$mail['port'] ?>" 
                               placeholder="587">
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Porta do servidor SMTP (587 para TLS, 465 para SSL, 25 para não criptografado)
                        </small>
                    </div>

                    <div>
                        <label>Usuário SMTP</label>
                        <input type="text" 
                               name="mail_username" 
                               value="<?= htmlspecialchars($mail['username']) ?>" 
                               placeholder="seuemail@gmail.com">
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
                               placeholder="noreply@seusite.com">
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            E-mail que aparecerá como remetente nas mensagens enviadas
                        </small>
                    </div>
                </div>
            </div>

            <!-- SEGURANÇA -->
            <div class="tab-content space-y-2" id="security">
                <h3 class="subtitle">Configurações de Segurança</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure as opções de segurança do sistema, incluindo criptografia de senhas e outras proteções
                </small>

                <!-- TIPO DE HASH DE SENHA -->
                <h4 class="subtitle">Criptografia de Senhas dos Players</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Escolha como as senhas dos players serão armazenadas no banco de dados
                </small>

                <div>
                    <label>Tipo de Hash de Senha</label>
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
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        <strong>Texto Puro:</strong> Senhas armazenadas sem criptografia (padrão MuOnline)<br>
                        <strong>MD5:</strong> Senhas criptografadas com MD5 (32 caracteres)<br>
                        <strong>SHA256:</strong> Senhas criptografadas com SHA256 (64 caracteres)<br>
                        <span style="color: #ff6b6b;">⚠️ Atenção: Alterar o tipo de hash afetará apenas novas senhas. Senhas antigas continuarão funcionando até serem alteradas.</span>
                    </small>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- PROTEÇÃO DDoS -->
                <h4 class="subtitle">Proteção DDoS</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure as opções de proteção contra ataques de negação de serviço (DDoS)
                </small>

                <!-- HABILITAR/DESABILITAR -->
                <div>
                    <label>
                        <input type="checkbox" 
                               name="ddos[enabled]" 
                               value="1" 
                               <?= ($ddos['enabled'] ?? false) ? 'checked' : '' ?>>
                        Habilitar Proteção DDoS
                    </label>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Ativa ou desativa todas as proteções DDoS do sistema
                    </small>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- RATE LIMITING GLOBAL -->
                <h4 class="subtitle">Rate Limiting Global</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Limite global de requisições por IP em um período de tempo
                </small>

                <div class="grid-2">
                    <div>
                        <label>Máximo de Requisições</label>
                        <input type="number" 
                               name="ddos[global_rate_limit][max_requests]" 
                               value="<?= htmlspecialchars($ddos['global_rate_limit']['max_requests'] ?? 300) ?>" 
                               min="1" 
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Número máximo de requisições permitidas por IP
                        </small>
                    </div>
                    <div>
                        <label>Janela de Tempo (segundos)</label>
                        <input type="number" 
                               name="ddos[global_rate_limit][window_seconds]" 
                               value="<?= htmlspecialchars($ddos['global_rate_limit']['window_seconds'] ?? 60) ?>" 
                               min="1" 
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Período em segundos para contar as requisições (ex: 60 = 1 minuto)
                        </small>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- LIMITES POR ROTA -->
                <h4 class="subtitle">Limites por Rota Sensível</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure limites específicos para rotas sensíveis (login, registro, etc.)
                </small>

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
                                       placeholder="/login" 
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
                        <button type="button" class="btn btn-danger btn-sm remove-ddos-route" style="margin-top: 8px;">
                            <i class="ph ph-trash"></i> Remover
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

                <hr style="margin:30px 0;border-color:#333">

                <!-- PADRÕES SUSPEITOS -->
                <h4 class="subtitle">Detecção de Padrões Suspeitos</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure a detecção de padrões suspeitos de ataque
                </small>

                <div>
                    <label>
                        <input type="checkbox" 
                               name="ddos[suspicious_patterns][enabled]" 
                               value="1" 
                               <?= ($ddos['suspicious_patterns']['enabled'] ?? false) ? 'checked' : '' ?>>
                        Habilitar Detecção de Padrões Suspeitos
                    </label>
                </div>

                <div class="grid-3" style="margin-top: 15px;">
                    <div>
                        <label>Comprimento Mínimo do User-Agent</label>
                        <input type="number" 
                               name="ddos[suspicious_patterns][min_user_agent_length]" 
                               value="<?= htmlspecialchars($ddos['suspicious_patterns']['min_user_agent_length'] ?? 10) ?>" 
                               min="1" 
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            User-Agents menores que este valor serão bloqueados
                        </small>
                    </div>
                    <div>
                        <label>Limite de Requisições Rápidas</label>
                        <input type="number" 
                               name="ddos[suspicious_patterns][rapid_request_threshold]" 
                               value="<?= htmlspecialchars($ddos['suspicious_patterns']['rapid_request_threshold'] ?? 50) ?>" 
                               min="1" 
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Número máximo de requisições rápidas permitidas
                        </small>
                    </div>
                    <div>
                        <label>Janela de Requisições Rápidas (segundos)</label>
                        <input type="number" 
                               name="ddos[suspicious_patterns][rapid_request_window]" 
                               value="<?= htmlspecialchars($ddos['suspicious_patterns']['rapid_request_window'] ?? 5) ?>" 
                               min="1" 
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Período em segundos para detectar requisições rápidas
                        </small>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- BLOQUEIO DE IP -->
                <h4 class="subtitle">Bloqueio Automático de IPs</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure o bloqueio automático de IPs suspeitos
                </small>

                <div>
                    <label>
                        <input type="checkbox" 
                               name="ddos[ip_blocking][enabled]" 
                               value="1" 
                               <?= ($ddos['ip_blocking']['enabled'] ?? false) ? 'checked' : '' ?>>
                        Habilitar Bloqueio Automático de IPs
                    </label>
                </div>

                <div style="margin-top: 15px;">
                    <label>Duração do Bloqueio (segundos)</label>
                    <input type="number" 
                           name="ddos[ip_blocking][block_duration]" 
                           value="<?= htmlspecialchars($ddos['ip_blocking']['block_duration'] ?? 3600) ?>" 
                           min="1" 
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Tempo em segundos que um IP ficará bloqueado (ex: 3600 = 1 hora)
                    </small>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- REQUISIÇÕES SIMULTÂNEAS -->
                <h4 class="subtitle">Requisições Simultâneas</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure a proteção contra requisições simultâneas (pode ser muito restritivo)
                </small>

                <div>
                    <label>
                        <input type="checkbox" 
                               name="ddos[concurrent_requests][enabled]" 
                               value="1" 
                               <?= ($ddos['concurrent_requests']['enabled'] ?? false) ? 'checked' : '' ?>>
                        Habilitar Proteção contra Requisições Simultâneas
                    </label>
                    <small style="color: #ff6b6b; font-size: 12px; display: block; margin-top: 4px;">
                        ⚠️ Atenção: Esta proteção pode bloquear usuários legítimos. Use com cautela.
                    </small>
                </div>

                <div class="grid-2" style="margin-top: 15px;">
                    <div>
                        <label>Máximo de Requisições Simultâneas</label>
                        <input type="number" 
                               name="ddos[concurrent_requests][max_concurrent]" 
                               value="<?= htmlspecialchars($ddos['concurrent_requests']['max_concurrent'] ?? 20) ?>" 
                               min="1" 
                               required>
                    </div>
                    <div>
                        <label>Janela (segundos)</label>
                        <input type="number" 
                               name="ddos[concurrent_requests][window_seconds]" 
                               value="<?= htmlspecialchars($ddos['concurrent_requests']['window_seconds'] ?? 5) ?>" 
                               min="1" 
                               required>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- RECAPTCHA -->
                <h4 class="subtitle">Google reCAPTCHA</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure o Google reCAPTCHA para proteger formulários contra bots e spam
                </small>

                <div>
                    <label>
                        <input type="checkbox" 
                               name="recaptcha[enabled]" 
                               value="1" 
                               <?= ($recaptcha['enabled'] ?? false) ? 'checked' : '' ?>
                               onchange="document.getElementById('recaptcha-config').style.display = this.checked ? 'block' : 'none';">
                        Habilitar reCAPTCHA
                    </label>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Ativa a proteção reCAPTCHA nos formulários de login, registro e recuperação de senha
                    </small>
                </div>

                <div id="recaptcha-config" style="display: <?= ($recaptcha['enabled'] ?? false) ? 'block' : 'none' ?>; margin-top: 20px;">
                    <div class="grid-2">
                        <div>
                            <label>Versão do reCAPTCHA</label>
                            <select name="recaptcha[version]" required>
                                <option value="v2" <?= ($recaptcha['version'] ?? 'v2') === 'v2' ? 'selected' : '' ?>>reCAPTCHA v2 (Checkbox "Não sou um robô")</option>
                                <option value="v3" <?= ($recaptcha['version'] ?? 'v2') === 'v3' ? 'selected' : '' ?>>reCAPTCHA v3 (Invisível, baseado em score)</option>
                            </select>
                            <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                                <strong>v2:</strong> Usuário precisa marcar checkbox "Não sou um robô"<br>
                                <strong>v3:</strong> Verificação invisível baseada em score (0.0 a 1.0)
                            </small>
                        </div>
                        <div id="recaptcha-score-config" style="display: <?= ($recaptcha['version'] ?? 'v2') === 'v3' ? 'block' : 'none' ?>;">
                            <label>Score Mínimo (apenas v3)</label>
                            <input type="number" 
                                   name="recaptcha[score_threshold]" 
                                   value="<?= htmlspecialchars($recaptcha['score_threshold'] ?? 0.5) ?>" 
                                   min="0" 
                                   max="1" 
                                   step="0.1">
                            <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                                Score mínimo para considerar válido (0.0 = bot, 1.0 = humano). Recomendado: 0.5
                            </small>
                        </div>
                    </div>

                    <div class="grid-2" style="margin-top: 15px;">
                        <div>
                            <label>Site Key (Chave do Site)</label>
                            <input type="text" 
                                   name="recaptcha[site_key]" 
                                   value="<?= htmlspecialchars($recaptcha['site_key'] ?? '') ?>" 
                                   placeholder="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI">
                            <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                                Chave pública do reCAPTCHA. Obtenha em: <a href="https://www.google.com/recaptcha/admin" target="_blank" style="color: #5865f2;">Google reCAPTCHA</a>
                            </small>
                        </div>
                        <div>
                            <label>Secret Key (Chave Secreta)</label>
                            <input type="text" 
                                   name="recaptcha[secret_key]" 
                                   value="<?= htmlspecialchars($recaptcha['secret_key'] ?? '') ?>" 
                                   placeholder="6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe">
                            <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                                Chave secreta do reCAPTCHA (não compartilhe esta chave)
                            </small>
                        </div>
                    </div>

                    <div style="margin-top: 20px; padding: 15px; background-color: #1a1a1a; border-left: 4px solid #2196F3; border-radius: 4px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <i class="ph ph-info" style="color: #2196F3; font-size: 1.2em;"></i>
                            <strong style="color: #fff;">Como obter as chaves reCAPTCHA:</strong>
                        </div>
                        <ol style="list-style: decimal; margin-left: 20px; color: #b9bbbe; font-size: 0.9em; line-height: 1.8;">
                            <li>Acesse <a href="https://www.google.com/recaptcha/admin" target="_blank" style="color: #5865f2;">https://www.google.com/recaptcha/admin</a></li>
                            <li>Faça login com sua conta Google</li>
                            <li>Clique em "+" para criar um novo site</li>
                            <li>Escolha o tipo: <strong>reCAPTCHA v2</strong> (checkbox) ou <strong>reCAPTCHA v3</strong> (invisível)</li>
                            <li>Adicione seu domínio (ex: localhost, seu-site.com)</li>
                            <li>Copie a <strong>Site Key</strong> e <strong>Secret Key</strong></li>
                            <li>Cole as chaves nos campos acima e salve</li>
                        </ol>
                        <p style="color: #b9bbbe; font-size: 0.9em; margin-top: 15px;">
                            <strong>Nota:</strong> Para testes locais, você pode usar as chaves de teste do Google (já preenchidas como exemplo), mas elas não oferecem proteção real.
                        </p>
                    </div>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- ÁREA PARA FUTURAS CONFIGURAÇÕES DE SEGURANÇA -->
                <h4 class="subtitle">Outras Configurações de Segurança</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Mais opções de segurança serão adicionadas aqui em breve
                </small>
            </div>

            <!-- DISCORD -->
            <div class="tab-content space-y-2" id="discord">
                <h3 class="subtitle">Configurações do Discord</h3>

                <div class="grid-2">
                    <div>
                        <label>ID do Servidor</label>
                        <input type="text" 
                               name="discord_server_id" 
                               value="<?= htmlspecialchars($discord['server_id']) ?>" 
                               placeholder="1442509489730359326">
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            O ID do servidor Discord (encontrado nas configurações do servidor)
                        </small>
                    </div>

                    <div>
                        <label>Link de Convite</label>
                        <input type="url" 
                               name="discord_invite" 
                               value="<?= htmlspecialchars($discord['invite']) ?>" 
                               placeholder="https://discord.gg/...">
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Link permanente de convite do servidor
                        </small>
                    </div>
                </div>

                <div>
                    <label>Total de Membros (Opcional)</label>
                    <input type="number" 
                           name="discord_member_count" 
                           value="<?= (int)($discord['member_count'] ?? 0) ?>" 
                           placeholder="Deixe em branco para usar automático"
                           min="0">
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Se preenchido, será usado este valor. Se vazio, tentará pegar automaticamente (pode não ser preciso).
                    </small>
                </div>

            </div>

            <!-- VIP -->
            <div class="tab-content space-y-2" id="vip">
                <h3 class="subtitle">Configurações VIP</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure o sistema VIP e os tipos disponíveis
                </small>

                <div>
                    <label>Coluna VIP</label>
                    <input type="text"
                           name="user[vip][column]"
                           value="<?= htmlspecialchars($user['vip']['column'] ?? '') ?>"
                           placeholder="VipType"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Nome da coluna no banco de dados que armazena o tipo VIP
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
                           placeholder="30"
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

            <!-- DONATE -->
            <div class="tab-content space-y-2" id="vip-packs">
                <h3 class="subtitle">Donate</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure as opções relacionadas a doações, VIP, Packs e conversão de moedas
                </small>

                <hr style="margin:20px 0;border-color:#333">

                <!-- DOAÇÕES -->
                <h4 class="subtitle">Doações</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure os gateways de pagamento para doações
                </small>

                <div>
                    <label>
                        <input type="hidden"
                               name="user[donate][mercadopago][is_active]"
                               value="0">
                        <input type="checkbox"
                               name="user[donate][mercadopago][is_active]"
                               value="1"
                               <?= !empty($user['donate']['mercadopago']['is_active']) ? 'checked' : '' ?>>
                        MercadoPago Ativo
                    </label>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Ative para permitir doações via MercadoPago
                    </small>
                </div>

                <div>
                    <label>Token MercadoPago</label>
                    <input type="text"
                           name="user[donate][mercadopago][token]"
                           value="<?= htmlspecialchars($user['donate']['mercadopago']['token'] ?? '') ?>"
                           placeholder="APP_USR-...">
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Token de acesso do MercadoPago (encontrado no painel do desenvolvedor)
                    </small>
                </div>

                <div>
                    <label>
                        <input type="hidden"
                               name="user[donate][stripe][is_active]"
                               value="0">
                        <input type="checkbox"
                               name="user[donate][stripe][is_active]"
                               value="1"
                               <?= !empty($user['donate']['stripe']['is_active']) ? 'checked' : '' ?>>
                        Stripe Ativo
                    </label>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Ative para permitir doações via Stripe
                    </small>
                </div>

                <div>
                    <label>Stripe Token</label>
                    <input type="text"
                           name="user[donate][stripe][token_stripe]"
                           value="<?= htmlspecialchars($user['donate']['stripe']['token_stripe'] ?? '') ?>"
                           placeholder="pk_test_...">
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Chave pública (Publishable Key) do Stripe
                    </small>
                </div>

                <div>
                    <label>Stripe Secret</label>
                    <input type="text"
                           name="user[donate][stripe][secret_stripe]"
                           value="<?= htmlspecialchars($user['donate']['stripe']['secret_stripe'] ?? '') ?>"
                           placeholder="sk_test_...">
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Chave secreta (Secret Key) do Stripe (mantenha em segurança)
                    </small>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- CONFIG DONATE (BANCO) -->
                <h4 class="subtitle">Config Donate (Banco)</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure a tabela e colunas do banco de dados para armazenar doações
                </small>

                <div>
                    <label>Tabela Donate</label>
                    <input type="text"
                           name="user[donate][table]"
                           value="<?= htmlspecialchars($user['donate']['table'] ?? '') ?>"
                           placeholder="Donate"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Nome da tabela onde as doações são registradas
                    </small>
                </div>

                <div>
                    <label>Coluna Conta (Donate)</label>
                    <input type="text"
                           name="user[donate][column_account]"
                           value="<?= htmlspecialchars($user['donate']['column_account'] ?? '') ?>"
                           placeholder="AccountID"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Nome da coluna que identifica a conta na tabela de doações
                    </small>
                </div>

                <div>
                    <label>Coluna Coin (Donate)</label>
                    <input type="text"
                           name="user[donate][column_coin]"
                           value="<?= htmlspecialchars($user['donate']['column_coin'] ?? '') ?>"
                           placeholder="Coin"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Nome da coluna que armazena o valor da moeda na tabela de doações
                    </small>
                </div>

                <div>
                    <label>
                        <input type="hidden" name="user[donate][active_multiplier]" value="0">
                        <input type="checkbox"
                               name="user[donate][active_multiplier]"
                               value="1"
                               <?= !empty($user['donate']['active_multiplier']) ? 'checked' : '' ?>>
                        Multiplicador Ativo
                    </label>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Se ativado, aplica multiplicadores de bônus baseados no valor da doação
                    </small>
                </div>

                <hr style="margin:20px 0;border-color:#333">

                <h4 class="subtitle">Multipliers</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure faixas de valores para aplicar multiplicadores de bônus nas doações
                </small>

                <?php $mults = $user['donate']['multiplier'] ?? []; ?>
                <div class="space-y-1">
                    <?php foreach ($mults as $i => $m): ?>
                        <div class="grid-3">
                            <div>
                                <label>Min</label>
                                <input type="number"
                                       name="user[donate][multiplier][<?= $i ?>][min]"
                                       value="<?= (int)($m['min'] ?? 0) ?>"
                                       required>
                            </div>

                            <div>
                                <label>Max</label>
                                <input type="number"
                                       name="user[donate][multiplier][<?= $i ?>][max]"
                                       value="<?= (int)($m['max'] ?? 0) ?>"
                                       required>
                            </div>

                            <div>
                                <label>Multiplier</label>
                                <input type="number"
                                       name="user[donate][multiplier][<?= $i ?>][multiplier]"
                                       value="<?= (int)($m['multiplier'] ?? 1) ?>"
                                       required>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <hr style="margin:30px 0;border-color:#333">

                <!-- CONVERSÃO DE CASH -->
                <h4 class="subtitle" style="font-size: 16px; margin-bottom: 1rem;">Conversão de Cash</h4>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Defina quantos Cash o jogador recebe por cada 1 Real (R$) pago via MercadoPago ou Stripe
                </small>

                <div class="grid-2">
                    <div>
                        <label>Valor de Cash por 1 Real (R$)</label>
                        <input type="number" 
                               name="cash[conversion_rate]" 
                               value="<?= (int)($cash['conversion_rate'] ?? 1) ?>" 
                               placeholder="10"
                               min="1"
                               step="1"
                               required>
                        <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                            Exemplo: Se definir 10, o jogador receberá 10 Cash ao pagar R$ 1,00. Se definir 1, receberá 1 Cash por R$ 1,00.
                        </small>
                    </div>
                </div>

                <div style="background: #2a2a2a; padding: 12px; border-radius: 6px; margin-top: 15px;">
                    <strong style="color: #fff; display: block; margin-bottom: 8px;">ℹ️ Como funciona:</strong>
                    <ul style="color: #ccc; font-size: 13px; margin: 0; padding-left: 20px;">
                        <li>Quando um jogador compra Cash via MercadoPago ou Stripe, o valor pago (em R$) é multiplicado pela taxa de conversão</li>
                        <li>Exemplo: Jogador paga R$ 5,00 com taxa de 10 → Recebe 50 Cash</li>
                        <li>Exemplo: Jogador paga R$ 5,00 com taxa de 1 → Recebe 5 Cash</li>
                    </ul>
                </div>
            </div>

            <!-- TERMOS E REGRAS -->
            <div class="tab-content space-y-2" id="terms">
                <h3 class="subtitle">Termos de Uso e Regras do Jogo</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure o conteúdo dos termos de uso e regras do jogo que aparecem no formulário de cadastro
                </small>

                <div>
                    <label>Termos de Uso</label>
                    <textarea 
                        name="terms[content]" 
                        id="terms-content"
                        rows="15"
                        style="width: 100%; padding: 12px; background: var(--background-card); border: 1px solid var(--neutral-300); border-radius: 8px; color: var(--white); font-family: 'Space Grotesk', sans-serif; font-size: 14px; resize: vertical;"
                        placeholder="Digite aqui o conteúdo dos termos de uso..."><?= htmlspecialchars(is_string($terms['content'] ?? '') ? $terms['content'] : '') ?></textarea>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Conteúdo dos termos de uso exibido na página de termos
                    </small>
                </div>

                <div>
                    <label>Regras do Jogo</label>
                    <textarea 
                        name="rules[content]" 
                        id="rules-content"
                        rows="15"
                        style="width: 100%; padding: 12px; background: var(--background-card); border: 1px solid var(--neutral-300); border-radius: 8px; color: var(--white); font-family: 'Space Grotesk', sans-serif; font-size: 14px; resize: vertical;"
                        placeholder="Digite aqui o conteúdo das regras do jogo..."><?= htmlspecialchars(is_string($rules['content'] ?? '') ? $rules['content'] : '') ?></textarea>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Conteúdo das regras do jogo exibido na página de regras
                    </small>
                </div>

                <div style="background: #2a2a2a; padding: 12px; border-radius: 6px; margin-top: 15px;">
                    <strong style="color: #fff; display: block; margin-bottom: 8px;">ℹ️ Informações:</strong>
                    <ul style="color: #ccc; font-size: 13px; margin: 0; padding-left: 20px;">
                        <li>O conteúdo será exibido nas páginas de termos e regras</li>
                        <li>Você pode usar HTML para formatar o texto</li>
                        <li>Os links aparecem no formulário de cadastro e abrem em nova aba</li>
                    </ul>
                </div>
            </div>

            <br>
            <button class="btn btn-primary" type="submit">
                <i class="ph ph-floppy-disk"></i> Salvar Configurações
            </button>

        </form>
    </div>
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
<script src="/template/admin/assets/js/custom.js?v=<?= time() ?>" defer></script>
