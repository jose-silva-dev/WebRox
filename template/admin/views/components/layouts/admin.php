<!DOCTYPE html>
<html lang="en">

<head>
    <?= seo() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= assets('css/style.css', 'admin') ?>">
    <link rel="stylesheet" href="<?= public_path("css/alert.css") ?>">
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->section('styles') ?>



</head>

<body>
    <div class="container">
        <?= $this->insert("components/sidebar") ?>
        <div class="content space-y-4">
            <?= $this->section("content") ?>
        </div>
    </div>

    <script src="<?= public_path('js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= public_path('js/alert.js') ?>"></script>
    <script src="<?= public_path('js/app.js') ?>"></script>
    <?= $this->section("scripts") ?>
</body>

</html>