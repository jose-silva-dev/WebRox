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
        <a href="javascript:void(0)" onclick="openRegisterPopup(); return false;" class="sidebar-banner banner-register"></a>
        <a href="<?= route('downloads') ?>" class="sidebar-banner banner-download"></a>
    </div>
<?php endif; ?>

    <?php if (!user()): ?>
        <!-- Login removido da sidebar - agora é popup -->
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
                <li><a href="<?= route("user.characters") ?>">Meus Personagens</a></li>
                <li><a href="<?= route("user.logout") ?>">Sair</a></li>
            </ul>
        </div>
    <?php endif; ?>

<?php if (config('online_servers.list') && !empty(config('online_servers.list'))): ?>
    <div class="server-status">
        <h3 class="server-status-title">
            <i class="ph ph-globe"></i> SALAS
        </h3>

        <?php 
        $totalPlayers = PlayerOnlineService::total();
        $realPlayers = PlayerOnlineService::real(); // Players reais sem multiplicador
        $servers = config('online_servers.list') ?? [];
        $serverCount = count($servers);
        
        foreach ($servers as $server): 
            $online = ServerStatusService::isOnline(
                $server['ip'],
                $server['port'],
                config('online_servers.timeout')
            );
            
            $maxPlayers = (int)($server['max_players'] ?? 100);
            $serverName = trim($server['server_name'] ?? '');
            
            // Tentar obter players por servidor específico usando o ServerName
            $playersOnServer = null;
            if (!empty($serverName)) {
                $playersOnServer = PlayerOnlineService::getByServer($serverName);
                // Se retornou 0, pode ser que não encontrou ou realmente não tem players
                // Vamos considerar como encontrado se não for null
            }
            
            // Se não conseguir obter diretamente (null), usar estimativa
            if ($playersOnServer === null) {
                // Estima players por servidor (divide o total real pelo número de servidores online)
                $onlineServers = [];
                $currentServerIndex = -1;
                foreach ($servers as $idx => $s) {
                    if (ServerStatusService::isOnline($s['ip'], $s['port'], config('online_servers.timeout'))) {
                        $onlineServers[] = $idx;
                        if ($s['ip'] === $server['ip'] && $s['port'] === $server['port']) {
                            $currentServerIndex = count($onlineServers) - 1;
                        }
                    }
                }
                
                $onlineServersCount = count($onlineServers);
                
                if ($onlineServersCount > 0 && $currentServerIndex >= 0) {
                    // Distribui os players entre os servidores online
                    // Se houver poucos players, coloca no primeiro servidor online
                    if ($realPlayers <= $onlineServersCount) {
                        // Se este é o primeiro servidor online, mostra os players
                        $playersOnServer = ($currentServerIndex === 0) ? $realPlayers : 0;
                    } else {
                        // Divide igualmente entre os servidores
                        $playersPerServer = (int)($realPlayers / $onlineServersCount);
                        $remainder = $realPlayers % $onlineServersCount;
                        
                        // Distribui o resto nos primeiros servidores
                        if ($currentServerIndex < $remainder) {
                            $playersOnServer = $playersPerServer + 1;
                        } else {
                            $playersOnServer = $playersPerServer;
                        }
                    }
                } else {
                    $playersOnServer = 0;
                }
            }
            
            // Aplicar multiplicador e base se necessário (para manter consistência com o total)
            // Só aplica se playersOnServer foi encontrado no banco (não é null)
            if ($playersOnServer !== null) {
                $base = (int) (config('server.online_base') ?? 0);
                $multiplier = (int) (config('server.online_multiplier') ?? 1);
                if ($multiplier < 1) {
                    $multiplier = 1; // Garantir que não seja 0
                }
                $playersOnServer = $base + ($playersOnServer * $multiplier);
            }
            
            // Garantir que não ultrapasse o máximo
            if ($playersOnServer > $maxPlayers) {
                $playersOnServer = $maxPlayers;
            }
            
            // Garantir que não seja negativo
            if ($playersOnServer < 0) {
                $playersOnServer = 0;
            }
            
            // Calcular porcentagem
            $percentage = $maxPlayers > 0 ? ($playersOnServer / $maxPlayers) * 100 : 0;
            $percentage = min(100, max(0, $percentage)); // Limitar entre 0 e 100
            
            // Determinar se está full (>= 95% para considerar full)
            $isFull = $percentage >= 95;
        ?>

            <?php if ($online): ?>
                <div class="server-line">
                    <div class="server-header">
                        <span class="server-name"><?= htmlspecialchars($server['name']) ?></span>
                        <span class="status <?= $isFull ? 'full' : 'online' ?>"><?= $isFull ? 'cheio' : 'online' ?></span>
                    </div>
                    <div class="server-progress-container">
                        <div class="server-progress-bar <?= $isFull ? 'full' : 'normal' ?>" style="width: <?= $percentage ?>%"></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="server-line">
                    <div class="server-header">
                        <span class="server-name"><?= htmlspecialchars($server['name']) ?></span>
                        <span class="status offline">Offline</span>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="players-online">
    <h3>Total de Players Online</h3>
    <div class="players-count">
        <?= PlayerOnlineService::total() ?>
    </div>
</div>

<?php if ($eventsPluginEnabled && (!empty($events) || !empty($invasions))): ?>
<div class="info">
    <h3>Eventos</h3>

    <!-- RELÓGIOS -->
    <div class="server-time">
        SERVER:
        <span id="server-clock"
              data-server-sod="<?= ((int)date('H') * 3600) + ((int)date('i') * 60) + (int)date('s') ?>">
            <?= date('H:i:s') ?>
        </span>
    </div>

    <div class="server-time">
        LOCAL:
        <span id="local-clock">--:--:--</span>
    </div>

    <!-- SELECT DE CATEGORIA -->
    <div class="event-tabs">
        <select id="event-category">
            <option value="events">Eventos</option>
            <option value="invasions">Invasões</option>
        </select>
    </div>

    <!-- EVENTOS -->
    <div id="events-tab" class="tab-content active">
        <?php foreach ($events as $event): ?>
            <p class="event-line">
                <span class="event-left">
                    <span class="event-clock">--:--</span>
                    - <?= $event['name'] ?>
                </span>

                <span
                    class="event-countdown"
                    data-times='<?= json_encode($event["times"]) ?>'
                    data-duration="<?= $event["duration"] ?>"
                >
                    --:--:--
                </span>
            </p>
        <?php endforeach; ?>
    </div>

    <!-- INVASÕES -->
    <div id="invasions-tab" class="tab-content">
        <?php foreach ($invasions as $inv): ?>
            <p class="event-line invasion">
                <span class="event-left">
                    <span class="event-clock">--:--</span>
                    - <?= $inv['name'] ?>
                </span>

                <span
                    class="event-countdown"
                    data-times='<?= json_encode($inv["times"]) ?>'
                    data-duration="<?= $inv["duration"] ?>"
                >
                    --:--:--
                </span>
            </p>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

    <div class="info">
        <h3>Informações</h3>
        <div>
            <p>
                <span>Nome:</span>
                <span><?= config('server.name') ?></span>
            </p>
            <p>
                <span>Versão:</span>
                <span><?= config('server.version') ?></span>
            </p>
            <p>
                <span>Experiência:</span>
                <span><?= config('server.experience') ?></span>
            </p>
            <p>
                <span>Drop:</span>
                <span><?= config('server.drop') ?></span>
            </p>
            <p>
                <span>Nível:</span>
                <span><?= config('server.level') ?></span>
            </p>
            <p>
                <span>Pontos de Atributo:</span>
                <span><?= config('server.points_attributes') ?></span>
            </p>
        </div>
    </div>
    
    <?php if (!empty($discord) && !empty(config('discord.invite'))): ?>
        <?php
        $onlineCount = (int)($discord['presence_count'] ?? 0);
        $members = $discord['members'] ?? [];
        // Limitar a 5 avatares como na imagem
        $displayMembers = array_slice($members, 0, 5);
        // Total de membros: se configurado no admin, usa; senão, usa online como estimativa
        $memberCountConfig = config('discord.member_count');
        if ($memberCountConfig !== null && is_numeric($memberCountConfig) && $memberCountConfig > 0) {
            $memberCount = (int)$memberCountConfig;
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
            
            <?php if (!empty($displayMembers)): ?>
            <div class="discord-widget-avatars">
                <?php foreach ($displayMembers as $member): 
                    // A API do widget retorna avatar_url diretamente
                    $avatarUrl = $member['avatar_url'] ?? null;
                    $username = $member['username'] ?? 'User';
                    
                    // Se não tiver avatar_url, usar avatar padrão do Discord
                    if (!$avatarUrl) {
                        $discriminator = $member['discriminator'] ?? '0';
                        $discriminatorNum = (int)$discriminator;
                        $avatarUrl = "https://cdn.discordapp.com/embed/avatars/" . ($discriminatorNum % 5) . ".png";
                    }
                ?>
                    <div class="discord-avatar" title="<?= htmlspecialchars($username) ?>">
                        <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="<?= htmlspecialchars($username) ?>" onerror="this.onerror=null; this.src='https://cdn.discordapp.com/embed/avatars/0.png'">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <a href="<?= config('discord.invite') ?>" target="_blank" rel="noopener noreferrer" class="discord-widget-invite">
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
                        <span class="text-<?= $data['status'] == 'online' ? 'success' : 'danger' ?>"><?= ucfirst($data['status']) ?></span>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>