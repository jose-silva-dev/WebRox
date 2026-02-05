<script>
    window.SITE_TIMEZONE = "<?= config('site.timezone') ?>";
</script>

<div class="sidebar space-y-1">

    <?php
    use Source\Services\ServerStatusService;
    use Source\Services\PlayerOnlineService;
    use Source\Services\EventService;
    use Source\Services\InvasionService;
    use Source\Services\DiscordService;

    // Verificar se plugin events está ativado antes de carregar
// sidebar.php está em template/default/views/components/web/
// Sobe 5 níveis: web -> components -> views -> default -> template -> raiz
    $root = dirname(__DIR__, 5);
    $basePlugins = require $root . '/bootstrap/plugins.php';
    $customPlugins = config('plugins') ?? [];
    $plugins = array_replace_recursive($basePlugins, $customPlugins);
    $eventsPluginEnabled = !empty($plugins['events']['enabled']);

    $events = [];
    $invasions = [];

    if ($eventsPluginEnabled) {
        $eventService = new EventService();
        $events = $eventService->get('Eventos');

        $invasionService = new InvasionService();
        $invasions = $invasionService->get();
    }

    $discord = DiscordService::getWidget();
    ?>

    <?php if (!user()): ?>
        <div class="sidebar-banners">
            <a href="javascript:void(0)" onclick="openRegisterPopup(); return false;" class="sidebar-banner banner-register"
                style="background-image: url('<?= assets('images/banner-register.png') ?>');"></a>
            <a href="<?= route('downloads') ?>" class="sidebar-banner banner-download"
                style="background-image: url('<?= assets('images/banner-download.png') ?>');"></a>
        </div>
    <?php endif; ?>

    <?php if (!user()): ?>
    <?php else: ?>
        <div class="user-info">
            <p>
                Nome:
                <span><?= resolve('User')->getUsername() ?></span>
            </p>
            <p>
                Cash:
                <span><?= resolve('User')->getCash() ?></span>
            </p>
            <p>
                Vip:
                <span><?= resolve('User')->getVip() ?></span>
            </p>
            <?php if (resolve('User')->getExpireVip() !== null): ?>
                <p>
                    Expiração Vip:
                    <span><?= resolve('User')->getExpireVip() ?></span>
                </p>
            <?php endif; ?>
            <?php foreach (resolve('User')->getCoins() as $key => $value): ?>
                <p>
                    <?= $value['title'] ?>:
                    <span><?= $value['amount'] ?></span>
                </p>
            <?php endforeach; ?>
            <ul>
                <li><a href="<?= route("user.info") ?>">Minha Conta</a></li>
                <li><a href="<?= route("user.ticket") ?>">Suporte</a></li>
                <li><a href="<?= route("user.characters") ?>"><?= __("user.characters_title") ?></a></li>
                <li><a href="<?= route("user.logout") ?>">Sair</a></li>
            </ul>
        </div>
    <?php endif; ?>

    <?php
    $serverstatusEnabled = config('plugins.serverstatus.enabled');
    $servers = [];
    $timeout = 1;
    if ($serverstatusEnabled) {
        $servers = config('online_servers.list');
        if (!is_array($servers) || empty($servers)) {
            $servers = config('server.status.servers') ?? [];
        }
        $timeout = config('online_servers.timeout');
    if (!is_numeric($timeout)) {
        $timeout = config('server.status.timeout');
    }
        if (!is_numeric($timeout)) {
            $timeout = 1;
        }
        $timeout = (float) $timeout;
    }

    // Calcular status online apenas 1x por request (evita vários fsockopen repetidos)
    $onlineMap = [];
    $onlineServersIdx = [];
    foreach ($servers as $idx => $srv) {
        $online = ServerStatusService::isOnline($srv['ip'] ?? '', $srv['port'] ?? 0, $timeout);
        $onlineMap[$idx] = $online;
        if ($online) {
            $onlineServersIdx[] = $idx;
        }
    }
    ?>

    <?php if ($serverstatusEnabled && !empty($servers)): ?>
        <?php
        $totalOnlineWeb = PlayerOnlineService::total();
        $firstWeb = $servers[0];
        $firstServerNameWeb = $firstWeb['name'] ?? 'Selecionar servidor';
        $firstIconWeb = trim($firstWeb['icon'] ?? '');
        $firstIconClassWeb = $firstIconWeb === '' ? '' : 'ph ph-' . $firstIconWeb;
        ?>
        <div class="sidebar-server-status">
            <div class="server-select-wrap" id="web-server-select-wrap">
                <button type="button" class="server-select-trigger" id="web-server-select-trigger" aria-expanded="false" aria-haspopup="listbox" aria-label="Abrir lista de servidores">
                    <?php if ($firstIconClassWeb !== ''): ?><span class="server-select-icon"><i class="<?= htmlspecialchars($firstIconClassWeb) ?>"></i></span><?php endif; ?>
                    <span class="server-select-label"><?= htmlspecialchars($firstServerNameWeb) ?></span>
                    <span class="server-select-count"><?= (int) $totalOnlineWeb ?></span>
                    <span class="server-select-caret" aria-hidden="true"><i class="ph ph-caret-down"></i></span>
                </button>
                <div class="server-select-dropdown" id="web-server-select-dropdown" role="listbox" aria-hidden="true">
                    <div class="server-select-dropdown-title">SELECIONAR SERVIDOR</div>
                    <?php foreach ($servers as $index => $server): ?>
                        <?php
                        $isOnline = $onlineMap[$index] ?? false;
                        // Contagem real por MEMB_STAT.ServerName: usa Nome da Sala (ou Nome do Servidor se quiser contagem por servidor)
                        $serverIdentifier = trim($server['room_name'] ?? ($server['server_name'] ?? $server['name'] ?? ''));
                        $playerCount = PlayerOnlineService::getDisplayCountByServer($serverIdentifier, $index, $servers);
                        $isNew = !empty($server['is_new']);
                        $legend = trim($server['legend'] ?? '');
                        $iconKey = trim($server['icon'] ?? '');
                        $iconClass = $iconKey === '' ? '' : 'ph ph-' . $iconKey;
                        ?>
                        <div class="server-select-item <?= $isNew ? 'featured' : '' ?> <?= $isOnline ? 'online' : 'offline' ?>" role="option" data-server-index="<?= $index ?>">
                            <?php if ($iconClass !== ''): ?><span class="server-select-item-icon"><i class="<?= htmlspecialchars($iconClass) ?>"></i></span><?php endif; ?>
                            <div class="server-select-item-body">
                                <span class="server-select-item-name"><?= htmlspecialchars($server['name']) ?></span>
                                <?php if ($isNew): ?><span class="server-select-item-badge">NOVO</span><?php endif; ?>
                                <?php if ($legend !== ''): ?><span class="server-select-item-desc"><?= htmlspecialchars($legend) ?></span><?php endif; ?>
                            </div>
                            <span class="server-select-item-count"><i class="ph ph-users"></i> <?= (int) $playerCount ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="total-online-sidebar">
                Total Online: <span class="online-count"><?= $totalOnlineWeb ?></span>
            </div>
        </div>
        <script>
        (function() {
            var wrap = document.getElementById('web-server-select-wrap');
            var trigger = document.getElementById('web-server-select-trigger');
            var dropdown = document.getElementById('web-server-select-dropdown');
            if (!wrap || !trigger || !dropdown) return;
            function open() {
                dropdown.classList.add('open');
                dropdown.setAttribute('aria-hidden', 'false');
                trigger.setAttribute('aria-expanded', 'true');
                var caret = trigger.querySelector('.server-select-caret i');
                if (caret) caret.className = 'ph ph-caret-up';
            }
            function close() {
                dropdown.classList.remove('open');
                dropdown.setAttribute('aria-hidden', 'true');
                trigger.setAttribute('aria-expanded', 'false');
                var caret = trigger.querySelector('.server-select-caret i');
                if (caret) caret.className = 'ph ph-caret-down';
            }
            function toggle() {
                if (dropdown.classList.contains('open')) close(); else open();
            }
            trigger.addEventListener('click', function(e) { e.stopPropagation(); toggle(); });
            document.addEventListener('click', function() { close(); });
            wrap.addEventListener('click', function(e) { e.stopPropagation(); });
        })();
        </script>
    <?php endif; ?>

    <?php if ($eventsPluginEnabled && (!empty($events) || !empty($invasions))): ?>
        <div class="event-widget-ref event-widget-sidebar">
            <h3 class="event-widget-title">EVENTOS</h3>
            <div class="event-time-box">
                <div class="event-time-row">
                    <span class="event-time-label">SERVER:</span>
                    <span id="sidebar-server-clock" class="event-time-val server" data-server-sod="<?= ((int) date('H') * 3600) + ((int) date('i') * 60) + (int) date('s') ?>"><?= date('H:i:s') ?></span>
                </div>
                <div class="event-time-row">
                    <span class="event-time-label">LOCAL:</span>
                    <span id="sidebar-local-clock" class="event-time-val local">--:--:--</span>
                </div>
            </div>
            <div class="event-category-ref">
                <select id="sidebar-event-category" class="event-select-ref">
                    <option value="events">EVENTOS</option>
                    <option value="invasions">INVASÕES</option>
                </select>
                <i class="ph ph-caret-down"></i>
            </div>
            <div id="sidebar-events-tab" class="event-list-ref tab-content active">
                <?php foreach ($events as $event): ?>
                    <div class="event-item-ref event-line">
                        <span class="event-item-time event-clock">--:--</span>
                        <span class="event-item-name"> - <?= e($event['name']) ?></span>
                        <span class="event-countdown" data-times='<?= json_encode($event["times"]) ?>' data-duration="<?= $event["duration"] ?>">--:--:--</span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="sidebar-invasions-tab" class="event-list-ref tab-content">
                <?php foreach ($invasions as $inv): ?>
                    <div class="event-item-ref event-line">
                        <span class="event-item-time event-clock">--:--</span>
                        <span class="event-item-name"> - <?= e($inv['name']) ?></span>
                        <span class="event-countdown" data-times='<?= json_encode($inv["times"]) ?>' data-duration="<?= $inv["duration"] ?>">--:--:--</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="sidebar-info-block">
        <h3>Informações</h3>
        <div class="server-info-grid server-info-sidebar">
            <div class="info-item">
                <span class="info-label">Nome</span>
                <span class="info-value"><?= htmlspecialchars(config('server.name', 'WebRox')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Versão</span>
                <span class="info-value"><?= htmlspecialchars(config('server.version', 'Season X')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Experiência</span>
                <span class="info-value"><?= htmlspecialchars(config('server.experience', '1000x')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Drop</span>
                <span class="info-value"><?= htmlspecialchars(config('server.drop', '50%')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Nível</span>
                <span class="info-value"><?= htmlspecialchars(config('server.level', '400')) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Pontos</span>
                <span class="info-value"><?= htmlspecialchars(config('server.points_attributes', '32767')) ?></span>
            </div>
        </div>
    </div>

    <?php if (!empty($discord) && !empty(config('discord.invite'))): ?>
        <?php
        $onlineCount = (int) ($discord['presence_count'] ?? 0);
        $members = $discord['members'] ?? [];
        // Limitar a 5 avatares como na imagem
        $displayMembers = array_slice($members, 0, 5);
        // Total de membros: se configurado no admin, usa; senão, usa online como estimativa
        $memberCountConfig = config('discord.member_count');
        if ($memberCountConfig !== null && is_numeric($memberCountConfig) && $memberCountConfig > 0) {
            $memberCount = (int) $memberCountConfig;
        } else {
            $memberCount = $onlineCount; // Usa online como estimativa
        }
        ?>
        <div class="discord-widget">
            <div class="discord-widget-header">
                <img src="<?= assets('images/discord-logo.png') ?>" alt="Discord" class="discord-widget-logo">
            </div>

            <div class="discord-widget-online">
                Online agora: <?= number_format($onlineCount, 0, ',', '.') ?>
            </div>

            <div class="discord-widget-members">
                Total de membros: <?= number_format($memberCount, 0, ',', '.') ?>
            </div>

            <?php if (!empty($displayMembers)): ?>
                <div class="discord-widget-avatars">
                    <?php foreach ($displayMembers as $member):
                        // A API do widget retorna avatar_url diretamente
                        $avatarUrl = $member['avatar_url'] ?? null;
                        $username = $member['username'] ?? 'User';

                        // Se não tiver avatar_url, usar avatar padrão do Discord
                        if (!$avatarUrl) {
                            $discriminator = $member['discriminator'] ?? '0';
                            $discriminatorNum = (int) $discriminator;
                            $avatarUrl = "https://cdn.discordapp.com/embed/avatars/" . ($discriminatorNum % 5) . ".png";
                        }
                        ?>
                        <div class="discord-avatar" title="<?= htmlspecialchars($username) ?>">
                            <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="<?= htmlspecialchars($username) ?>"
                                onerror="this.onerror=null; this.src='https://cdn.discordapp.com/embed/avatars/0.png'">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <a href="<?= config('discord.invite') ?>" target="_blank" rel="noopener noreferrer"
                class="discord-widget-invite">
                <?= htmlspecialchars(config('discord.invite')) ?>
            </a>
        </div>
    <?php else: ?>
        <div class="discord-widget discord-widget-offline">
            <div class="discord-widget-header">
                <img src="<?= assets('images/discord-logo.png') ?>" alt="Discord" class="discord-widget-logo">
            </div>
            <div class="discord-widget-online">
                Servidor Indisponível
            </div>
        </div>
    <?php endif; ?>


    <div class="info">
        <h3>Equipe <?= config('server.name') ?></h3>
        <div>
            <?php if ($staffs = resolve('Geral')->getStaffs()): ?>
                <?php foreach ($staffs as $data): ?>
                    <p>
                        <span><?= $data['name'] ?>:</span>
                        <span
                            class="text-<?= $data['status'] == 'online' ? 'success' : 'danger' ?>"><?= ucfirst($data['status']) ?></span>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>