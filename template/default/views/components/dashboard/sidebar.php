<?php
$siteConfig = config('site') ?? [];
$brandType = $siteConfig['brand_type'] ?? (!empty($siteConfig['logo']['enabled']) ? 'logo' : 'title');
$logoConfig = $siteConfig['logo'] ?? ['enabled' => 1, 'value' => 'images/logo.png'];
$titleConfig = $siteConfig['title'] ?? ['enabled' => 1, 'value' => 'Web Roxmu'];
$descriptionConfig = $siteConfig['description'] ?? ['enabled' => 0, 'value' => ''];
$showDescription = !empty($descriptionConfig['enabled']) && trim($descriptionConfig['value'] ?? '') !== '';
?>
<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <a href="<?= route('/') ?>" class="brand">
            <?php if ($brandType === 'logo' && !empty($logoConfig['value'])): ?>
                <img src="<?= assets($logoConfig['value']) ?>" alt="<?= htmlspecialchars($titleConfig['value']) ?>">
            <?php else: ?>
                <span><?= htmlspecialchars(trim($titleConfig['value']) !== '' ? $titleConfig['value'] : 'Web Roxmu') ?></span>
            <?php endif; ?>
        </a>
        <?php if ($showDescription): ?>
            <p class="sidebar-header-description"><?= htmlspecialchars(trim($descriptionConfig['value'])) ?></p>
        <?php endif; ?>
    </div>

    <?php if (config('plugins.serverstatus.enabled') && !empty(config('online_servers.list', []))): ?>
    <?php
    $servers = config('online_servers.list', []);
    $totalOnline = \Source\Services\PlayerOnlineService::total();
    $timeout = config('online_servers.timeout');
    if (!is_numeric($timeout)) {
        $timeout = config('server.status.timeout', 1);
    }
    $timeout = (float) ($timeout ?: 1);
    $firstServerName = count($servers) > 0 ? $servers[0]['name'] : __('server.select_server');
    $firstServer = $servers[0] ?? null;
    $firstIconClass = '';
    if ($firstServer) {
        $ik = trim($firstServer['icon'] ?? '');
        if ($ik !== '') {
            $firstIconClass = 'ph ph-' . $ik;
        }
    }
    ?>
    <div class="sidebar-server-status">
        <div class="server-select-wrap" id="server-select-wrap">
            <button type="button" class="server-select-trigger" id="server-select-trigger" aria-expanded="false" aria-haspopup="listbox" aria-label="<?= htmlspecialchars(__("server.open_server_list")) ?>">
                <?php if ($firstIconClass !== ''): ?><span class="server-select-icon"><i class="<?= htmlspecialchars($firstIconClass) ?>"></i></span><?php endif; ?>
                <span class="server-select-label"><?= htmlspecialchars($firstServerName) ?></span>
                <span class="server-select-count"><?= (int) $totalOnline ?></span>
                <span class="server-select-caret" aria-hidden="true"><i class="ph ph-caret-down"></i></span>
            </button>
            <div class="server-select-dropdown" id="server-select-dropdown" role="listbox" aria-hidden="true">
                <div class="server-select-dropdown-title"><?= __("server.select_server_title") ?></div>
                <?php
                foreach ($servers as $index => $server):
                    $isOnline = \Source\Services\ServerStatusService::isOnline($server['ip'] ?? '', $server['port'] ?? 0, $timeout);
                    // Contagem real por MEMB_STAT.ServerName: usa Nome da Sala (ou Nome do Servidor se quiser contagem por servidor)
                    $serverIdentifier = trim($server['room_name'] ?? ($server['server_name'] ?? $server['name'] ?? ''));
                    $playerCount = \Source\Services\PlayerOnlineService::getDisplayCountByServer($serverIdentifier, $index, $servers);
                    $isNew = !empty($server['is_new']);
                    $legend = trim($server['legend'] ?? '');
                    $iconKey = trim($server['icon'] ?? '');
                    $iconClass = $iconKey === '' ? '' : 'ph ph-' . $iconKey;
                ?>
                <div class="server-select-item <?= $isNew ? 'featured' : '' ?> <?= $isOnline ? 'online' : 'offline' ?>" role="option" data-server-index="<?= $index ?>">
                    <?php if ($iconClass !== ''): ?><span class="server-select-item-icon"><i class="<?= htmlspecialchars($iconClass) ?>"></i></span><?php endif; ?>
                    <div class="server-select-item-body">
                        <span class="server-select-item-name"><?= htmlspecialchars($server['name']) ?></span>
                        <?php if ($isNew): ?><span class="server-select-item-badge"><?= __("server.new_badge") ?></span><?php endif; ?>
                        <?php if ($legend !== ''): ?><span class="server-select-item-desc"><?= htmlspecialchars($legend) ?></span><?php endif; ?>
                    </div>
                    <span class="server-select-item-count"><i class="ph ph-users"></i> <?= (int) $playerCount ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="total-online-sidebar">
            <?= __("server.total_online") ?>: <span class="online-count"><?= $totalOnline ?></span>
        </div>
    </div>

    <script>
    (function() {
        var wrap = document.getElementById('server-select-wrap');
        var trigger = document.getElementById('server-select-trigger');
        var dropdown = document.getElementById('server-select-dropdown');
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

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-header"><?= __("nav.navigation") ?></span>
            <ul>
                <li class="<?= (redirect()->current() == '/' || redirect()->current() == '') ? 'active' : '' ?>">
                    <a href="<?= route('/') ?>">
                        <i class="ph ph-house-line"></i>
                        <span><?= __("nav.home_upper") ?></span>
                    </a>
                </li>

                <li class="<?= (redirect()->current() == '/downloads') ? 'active' : '' ?>">
                    <a href="<?= route('downloads') ?>">
                        <i class="ph ph-download"></i>
                        <span><?= __("nav.downloads_upper") ?></span>
                    </a>
                </li>

                <?php if (config('plugins.hallfame.enabled')): ?>
                    <li class="<?= (redirect()->current() == '/rankings') ? 'active' : '' ?>">
                        <a href="<?= route('rankings') ?>">
                            <i class="ph ph-trophy"></i>
                            <span><?= __("nav.rankings_upper") ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (config('plugins.vip.enabled')): ?>
                    <li class="<?= (redirect()->current() == '/vip') ? 'active' : '' ?>">
                        <a href="<?= route('vip') ?>">
                            <i class="ph ph-crown"></i>
                            <span><?= __("nav.vip_upper") ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (config('plugins.donate.enabled')): ?>
                    <li class="<?= (redirect()->current() == '/user/donate') ? 'active' : '' ?>">
                        <a href="<?= route('user.donate') ?>">
                            <i class="ph ph-hand-coins"></i>
                            <span><?= __("nav.donate_upper") ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <li
                    class="<?= (redirect()->current() == '/staff' || redirect()->current() == '/team') ? 'active' : '' ?>">
                    <a href="<?= route('staff') ?>">
                        <i class="ph ph-shield-star"></i>
                        <span><?= __("nav.staff_upper") ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>