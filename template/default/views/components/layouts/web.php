<!DOCTYPE html>
<html lang="en">

<head>
    <?= seo() ?>
    <link rel="stylesheet" href="<?= assets('css/style.css') ?>">
    <link rel="stylesheet" href="<?= public_path("css/alert.css") ?>">
    <link rel="stylesheet" href="<?= public_path("css/swiper.css") ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <header>
        <img src="<?= assets('images/logo.png') ?>" alt="Web Roxmu">
        <h1>Web Roxmu</h1>
        <p>Web Roxmu is a web application that provides a platform for users to interact with each other.</p>
    </header>
    <?= $this->insert("components/web/navigation") ?>
    <div class="web-content">
        <div class="content space-y-1">
            <?= $this->section("content") ?>
        </div>
        <?= $this->insert("components/web/sidebar") ?>
    </div>

    <footer>
        <p class="company">Web Roxmu &copy; 2025</p>
        <p class="copyright">All rights reserved.</p>
    </footer>

    <script src="<?= public_path('js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= public_path('js/swiper.js') ?>"></script>
    <script src="<?= public_path('js/alert.js') ?>"></script>
    <script src="<?= public_path('js/app.js') ?>"></script>
    <script src="<?= assets('js/custom.js') ?>"></script>
</body>

</html>