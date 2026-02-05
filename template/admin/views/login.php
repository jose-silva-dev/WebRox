<!DOCTYPE html>
<html lang="pt-br">

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
    <link rel="stylesheet" href="<?= assets('css/root.css', 'admin') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= assets('css/login.css', 'admin') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= public_path("css/alert.css") ?>?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <?= $this->section('styles') ?>
</head>

<body>
    <div class="login-wrapper">
        <div class="login__container">
            <div class="login__ornament-top"></div>

            <div class="login__container__header">
                <h1>Painel Administrativo</h1>
                <p>O Continente Perdido espera por você</p>
            </div>

            <div class="login__container__body">
                <form action="<?= rtrim(base_url ?? '', '/') ?>/auth/admin" method="post" id="admin-login-form" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="login__group">
                        <label for="login"><i class="ph ph-user"></i> Login</label>
                        <input type="text" id="login" name="login" autocomplete="off" required>
                    </div>

                    <div class="login__group">
                        <label for="password"><i class="ph ph-lock-key"></i> Senha</label>
                        <input type="password" id="password" name="password" autocomplete="off" readonly data-no-autofill required>
                    </div>

                    <?= recaptcha_field() ?>

                    <div class="login__actions">
                        <button type="submit" class="btn-mu">
                            <span>ENTRAR</span>
                        </button>
                    </div>
                </form>
                <script>
                    (function() {
                        var p = document.getElementById('password');
                        if (!p) return;
                        function removeReadonly() {
                            p.removeAttribute('readonly');
                            p.removeEventListener('focus', removeReadonly);
                            p.removeEventListener('click', removeReadonly);
                        }
                        p.addEventListener('focus', removeReadonly);
                        p.addEventListener('click', removeReadonly);
                    })();
                </script>
                <?php if (recaptcha_version() === 'v3'): ?>
                    <script>
                        // Para v3, regenerar token antes de submit
                        document.getElementById('admin-login-form')?.addEventListener('submit', function (e) {
                            if (<?= recaptcha_enabled() ? 'true' : 'false' ?>) {
                                grecaptcha.ready(function () {
                                    grecaptcha.execute('<?= recaptcha_site_key() ?>', { action: 'admin_login' }).then(function (token) {
                                        document.getElementById('g-recaptcha-response').value = token;
                                    });
                                });
                            }
                        });
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="<?= public_path('js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= public_path('js/toast.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/alert.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/app.js') ?>?v=<?= time() ?>"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>