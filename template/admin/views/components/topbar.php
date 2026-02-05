<?php
$currentObj = redirect()->current();
$currentPath = is_object($currentObj) ? (string) ($currentObj->path ?? '') : (string) $currentObj;
$title = 'Painel';
if (strpos($currentPath, 'admin/dashboard') !== false) $title = 'Dashboard';
elseif (strpos($currentPath, 'admin/payment') !== false) $title = 'Pagamentos';
elseif (strpos($currentPath, 'admin/download') !== false || strpos($currentPath, 'admin/additional-download') !== false) $title = 'Downloads';
elseif (strpos($currentPath, 'admin/ticket') !== false) $title = 'Tickets';
elseif (strpos($currentPath, 'admin/account') !== false) $title = 'Contas';
elseif (strpos($currentPath, 'admin/character') !== false) $title = 'Personagens';
elseif (strpos($currentPath, 'admin/plugins') !== false) $title = 'Plugins';
elseif (strpos($currentPath, 'admin/settings') !== false) $title = 'Configuração';
elseif (strpos($currentPath, 'admin/blocked') !== false) $title = 'IPs Bloqueados';
elseif (strpos($currentPath, 'admin/notice') !== false) $title = 'Notícias';
elseif (strpos($currentPath, 'admin/slider') !== false) $title = 'Slider';
?>
<header class="dashboard-topbar">
    <div class="topbar-left">
        <button type="button" class="menu-toggle admin-menu-toggle" aria-label="Abrir menu">
            <i class="ph ph-list"></i>
        </button>
        <div class="topbar-brand">
            <span class="topbar-page-title"><?= htmlspecialchars($title) ?></span>
        </div>
    </div>
    <div class="topbar-right">
        <a href="<?= route('/') ?>" class="topbar-link" target="_blank" rel="noopener">
            <i class="ph ph-globe"></i>
            <span>Ver site</span>
        </a>
        <a href="<?= route('admin/logout') ?>" class="topbar-link topbar-link--danger">
            <i class="ph ph-sign-out"></i>
            <span>Sair</span>
        </a>
    </div>
</header>
