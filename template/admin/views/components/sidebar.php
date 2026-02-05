<?php
$siteName = config('site.title.value') ?? config('site.title.value') ?? 'Web Roxmu';
$currentObj = redirect()->current();
$currentPath = is_object($currentObj) ? (string) ($currentObj->path ?? '') : (string) $currentObj;
$isActive = function ($path) use ($currentPath) {
    $path = trim($path, '/');
    if ($path === 'admin' || $path === 'admin/dashboard') {
        return $currentPath === '' || $currentPath === '/admin' || $currentPath === '/admin/dashboard';
    }
    return strpos($currentPath, $path) !== false;
};
?>
<aside class="dashboard-sidebar" id="admin-sidebar">
    <div class="sidebar-header">
        <a href="<?= route('admin/dashboard') ?>" class="brand">
            <span><?= htmlspecialchars($siteName) ?></span>
        </a>
        <p class="sidebar-header-description">Painel Administrativo</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-header">Principal</span>
            <ul>
                <li class="<?= $isActive('admin/dashboard') ? 'active' : '' ?>">
                    <a href="<?= route('admin/dashboard') ?>"><i class="ph ph-game-controller"></i><span>Dashboard</span></a>
                </li>
                <li class="<?= $isActive('admin/payment') ? 'active' : '' ?>">
                    <a href="<?= route('admin/payment') ?>"><i class="ph ph-currency-circle-dollar"></i><span>Pagamentos</span></a>
                </li>
                <li class="<?= $isActive('admin/download') ? 'active' : '' ?>">
                    <a href="<?= route('admin/download') ?>"><i class="ph ph-package"></i><span>Downloads</span></a>
                </li>
                <li class="<?= $isActive('admin/ticket') ? 'active' : '' ?>">
                    <a href="<?= route('admin/ticket') ?>"><i class="ph ph-chat-circle-dots"></i><span>Tickets</span></a>
                </li>
            </ul>
        </div>
        <div class="nav-section">
            <span class="nav-header">Conteúdo</span>
            <ul>
                <li class="<?= $isActive('admin/notice') ? 'active' : '' ?>">
                    <a href="<?= route('admin/notice') ?>"><i class="ph ph-scroll"></i><span>Notícias</span></a>
                </li>
                <li class="<?= $isActive('admin/slider') ? 'active' : '' ?>">
                    <a href="<?= route('admin/slider') ?>"><i class="ph ph-images-square"></i><span>Slider</span></a>
                </li>
            </ul>
        </div>
        <div class="nav-section">
            <span class="nav-header">Usuários</span>
            <ul>
                <li class="<?= $isActive('admin/account') ? 'active' : '' ?>">
                    <a href="<?= route('admin/account') ?>"><i class="ph ph-identification-card"></i><span>Contas</span></a>
                </li>
                <li class="<?= $isActive('admin/character') ? 'active' : '' ?>">
                    <a href="<?= route('admin/character') ?>"><i class="ph ph-users-three"></i><span>Personagens</span></a>
                </li>
            </ul>
        </div>
        <div class="nav-section">
            <span class="nav-header">Sistema</span>
            <ul>
                <li class="<?= $isActive('admin/plugins') ? 'active' : '' ?>">
                    <a href="<?= route('admin/plugins') ?>"><i class="ph ph-puzzle-piece"></i><span>Plugins</span></a>
                </li>
                <li class="<?= $isActive('admin/settings') && !$isActive('admin/settings/characters') && !$isActive('admin/settings/map') ? 'active' : '' ?>">
                    <a href="<?= route('admin/settings') ?>"><i class="ph ph-sliders-horizontal"></i><span>Configuração</span></a>
                </li>
                <li class="<?= $isActive('admin/settings/characters') ? 'active' : '' ?>">
                    <a href="<?= route('admin/settings/characters') ?>"><i class="ph ph-sword"></i><span>Classes</span></a>
                </li>
                <li class="<?= $isActive('admin/settings/map') ? 'active' : '' ?>">
                    <a href="<?= route('admin/settings/map') ?>"><i class="ph ph-map-trifold"></i><span>Mapas</span></a>
                </li>
                <li class="<?= $isActive('admin/blocked') ? 'active' : '' ?>">
                    <a href="<?= route('admin/blocked-ips') ?>"><i class="ph ph-shield-warning"></i><span>IPs Bloqueados</span></a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer-link">
            <a href="<?= route('admin/logout') ?>"><i class="ph ph-door-open"></i><span>Sair do painel</span></a>
        </div>
    </nav>
</aside>

<script>
(function() {
    var toggle = document.querySelector('.admin-menu-toggle');
    var sidebar = document.getElementById('admin-sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 900 && !sidebar.contains(e.target) && !toggle.contains(e.target))
                sidebar.classList.remove('active');
        });
    }
})();
</script>
