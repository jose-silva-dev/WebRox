<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?= seo() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
    $fontAdminPrimary = config('site.font_admin_primary') ?: 'Space Grotesk';
    $fontAdminSecondary = config('site.font_admin_secondary') ?: 'Inter';
    $urlAdmin1 = google_font_url($fontAdminPrimary);
    $urlAdmin2 = google_font_url($fontAdminSecondary);
    if ($urlAdmin1 !== '') { ?>
    <link href="<?= htmlspecialchars($urlAdmin1) ?>" rel="stylesheet">
    <?php }
    if ($urlAdmin2 !== '' && $urlAdmin2 !== $urlAdmin1) { ?>
    <link href="<?= htmlspecialchars($urlAdmin2) ?>" rel="stylesheet">
    <?php } ?>
    <style>:root { --font-primary: "<?= htmlspecialchars($fontAdminPrimary) ?>"; --font-secondary: "<?= htmlspecialchars($fontAdminSecondary) ?>"; }</style>
    <link rel="stylesheet" href="<?= assets('css/style.css', 'admin') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= public_path("css/alert.css") ?>?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />
    <?= $this->section('styles') ?>
</head>

<body>
    <div class="dashboard-wrapper">
        <?= $this->insert("components/sidebar") ?>
        <?= $this->insert("components/modal") ?>
        <main class="dashboard-main">
            <?= $this->insert("components/topbar") ?>
            <div class="dashboard-content">
                <div class="dashboard-content-inner">
                    <?= $this->section("content") ?>
                </div>
            </div>
            <footer class="dashboard-footer">
                <p>Web Roxmu &copy; <?= date('Y') ?> · Painel Administrativo</p>
            </footer>
        </main>
    </div>

    <script src="<?= public_path('js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= public_path('js/toast.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/alert.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/app.js') ?>?v=<?= time() ?>"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <?= $this->section("scripts") ?>
</body>

</html>
