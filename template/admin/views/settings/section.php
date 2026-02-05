<?= $this->layout('components/layouts/admin') ?>
<?php
$current = $currentSection ?? 'site';
$base = route('admin/settings');
$links = [
    'site' => ['url' => $base . '/site', 'label' => 'Site', 'icon' => 'ph-globe'],
    'server' => ['url' => $base . '/server', 'label' => 'Servidor', 'icon' => 'ph-server'],
    'admin' => ['url' => $base . '/admin', 'label' => 'Admin', 'icon' => 'ph-user-circle'],
    'rankings' => ['url' => $base . '/rankings', 'label' => 'Rankings', 'icon' => 'ph-trophy'],
    'user' => ['url' => $base . '/coin', 'label' => 'Coin', 'icon' => 'ph-currency-circle-dollar'],
    'security' => ['url' => $base . '/security', 'label' => 'Segurança', 'icon' => 'ph-shield-check'],
    'mail' => ['url' => $base . '/mail', 'label' => 'E-mail', 'icon' => 'ph-envelope'],
    'vip' => ['url' => $base . '/vip', 'label' => 'Vip', 'icon' => 'ph-crown'],
    'vip-packs' => ['url' => $base . '/donate', 'label' => 'Donate', 'icon' => 'ph-hand-coins'],
    'terms' => ['url' => $base . '/terms', 'label' => 'Termos e Regras', 'icon' => 'ph-file-text'],
];
?>
<style>
.settings-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    padding: 0.25rem;
    background: var(--bg-card, #1a1d24);
    border-radius: 12px;
    border: 1px solid var(--border-color, #2d3139);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.03);
}
.settings-nav a {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.8125rem;
    font-weight: 500;
    background: transparent;
    border: 1px solid transparent;
    color: var(--text-muted, #9ca3af);
    transition: background 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
}
.settings-nav a:hover {
    background: rgba(255,255,255,0.05);
    color: var(--text-primary, #e5e7eb);
}
.settings-nav a.active {
    background: rgba(255, 255, 255, 0.14);
    border-color: transparent;
    color: #fff;
    box-shadow: none;
}
.settings-nav a i {
    font-size: 1.1rem;
    opacity: 0.9;
}
.settings-nav a.active i {
    opacity: 1;
    color: #fff;
}
</style>
<div class="space-y-1 settings-page">
    <h1 class="title">Configuração</h1>
    <p class="page-subtitle" style="font-size: 0.875rem; color: var(--text-muted); margin: -0.25rem 0 0 0;">Configurações do Sistema</p>

    <nav class="settings-nav" aria-label="Seções de configuração">
        <?php foreach ($links as $key => $item): ?>
            <a href="<?= htmlspecialchars($item['url']) ?>" class="<?= $key === $current ? 'active' : '' ?>">
                <i class="ph <?= $item['icon'] ?>" aria-hidden="true"></i>
                <?= htmlspecialchars($item['label']) ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="form">
        <form action="<?= route('admin/settings/update') ?>" method="post" enctype="multipart/form-data" class="space-y-2">
            <?= csrf_field() ?>
            <input type="hidden" name="section" value="<?= htmlspecialchars($current) ?>">

            <?php
            $partialName = str_replace('-', '_', $current);
            echo $this->insert('settings/partials/' . $partialName, get_defined_vars());
            ?>

            <button class="btn btn-primary" type="submit">
                <i class="ph ph-floppy-disk"></i> Salvar
            </button>
        </form>
    </div>
</div>
<script>window.TEST_DB_URL = "<?= route('admin/settings/test-db') ?>"; window.DISABLE_APP_JS_INTERCEPT = true;</script>
<script src="<?= assets('js/custom.js', 'admin') ?>?v=<?= time() ?>" defer></script>
