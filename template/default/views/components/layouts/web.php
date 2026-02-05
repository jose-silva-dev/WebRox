<!DOCTYPE html>
<html lang="<?= locale() === 'pt' ? 'pt-BR' : (locale() === 'es' ? 'es' : 'en') ?>">

<head>
    <script>
    (function(){
      var k='webrox_font_size_step',min=-3,max=3,base=16;var v=localStorage.getItem(k);var step=0;if(v!==null){var n=parseInt(v,10);if(!isNaN(n)&&n>=min&&n<=max)step=n;}document.documentElement.style.fontSize=(base+step)+'px';
      var t=localStorage.getItem('webrox_theme');if(t!=='dark'&&t!=='light')t='light';document.documentElement.setAttribute('data-theme',t);
    })();
    </script>
    <?= seo() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
    $fontPrimary = config('site.font_primary') ?: 'Space Grotesk';
    $fontSecondary = config('site.font_secondary') ?: 'Inter';
    $url1 = google_font_url($fontPrimary);
    $url2 = google_font_url($fontSecondary);
    if ($url1 !== '') { ?>
    <link href="<?= htmlspecialchars($url1) ?>" rel="stylesheet">
    <?php }
    if ($url2 !== '' && $url2 !== $url1) { ?>
    <link href="<?= htmlspecialchars($url2) ?>" rel="stylesheet">
    <?php } ?>
    <style>:root { --font-primary: "<?= htmlspecialchars($fontPrimary) ?>"; --font-secondary: "<?= htmlspecialchars($fontSecondary) ?>"; }</style>
    <link rel="stylesheet" href="<?= asset_versioned('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset_versioned('css/news-detail.css') ?>">
    <link rel="stylesheet" href="<?= public_path("css/alert.css") ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= public_path("css/swiper.css") ?>?v=<?= time() ?>">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <div class="dashboard-wrapper">
        <?= $this->insert("components/dashboard/sidebar") ?>

        <main class="dashboard-main">
            <?= $this->insert("components/dashboard/topbar") ?>

            <div class="dashboard-content">
                <?= $this->section("content") ?>
            </div>

            <footer class="dashboard-footer">
                <?= copyright() ?>
            </footer>
        </main>
    </div>

    <?php if (!user()): ?>
        <div class="login-popup" id="login-popup">
            <div class="login-popup-content">
                <div class="login-popup-header">
                    <h3><?= __("auth.login") ?></h3>
                    <button type="button" class="login-popup-close" onclick="closeLoginPopup()">&times;</button>
                </div>
                <form action="<?= route("login") ?>" class="form" method="post" id="login-form-popup">
                    <?= csrf_field() ?>
                    <label for="username-popup"><?= __("auth.username") ?></label>
                    <input type="text" id="username-popup" name="username" required>
                    <label for="password-popup"><?= __("auth.password") ?></label>
                    <div class="password-toggle-wrap" style="position: relative; display: block; width: 100%;">
                        <input type="password" id="password-popup" name="password" required style="padding-right: 44px; width: 100%; box-sizing: border-box; display: block;">
                        <button type="button" class="password-toggle-btn" onclick="toggleLoginPassword()" aria-label="<?= __("auth.reveal_password") ?>" title="<?= __("auth.reveal_password") ?>" style="position: absolute; top: 0; right: 0; bottom: 0; width: 44px; margin: 0; padding: 0; background: none; border: none; color: #9ca3af; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                            <i class="ph ph-eye" id="password-popup-eye-icon" style="font-size: 18px;"></i>
                        </button>
                    </div>
                    <script>
                    function toggleLoginPassword() {
                        var input = document.getElementById('password-popup');
                        var icon = document.getElementById('password-popup-eye-icon');
                        if (!input || !icon) return;
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.className = 'ph ph-eye-slash';
                            icon.parentElement.setAttribute('aria-label', '<?= addslashes(__("auth.hide_password")) ?>');
                            icon.parentElement.setAttribute('title', '<?= addslashes(__("auth.hide_password")) ?>');
                        } else {
                            input.type = 'password';
                            icon.className = 'ph ph-eye';
                            icon.parentElement.setAttribute('aria-label', '<?= addslashes(__("auth.reveal_password")) ?>');
                            icon.parentElement.setAttribute('title', '<?= addslashes(__("auth.reveal_password")) ?>');
                        }
                    }
                    </script>
                    <?= recaptcha_field() ?>
                    <div class="checkbox" style="margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" id="remember-me-popup" name="remember_me" value="1"
                            style="width: auto; margin: 0;">
                        <label for="remember-me-popup"
                            style="margin: 0; font-size: 13px; font-weight: normal; text-transform: none; letter-spacing: normal; cursor: pointer;"><?= __("auth.remember_me") ?></label>
                    </div>
                    <div class="action">
                        <button type="submit" class="btn btn-danger"><?= __("auth.submit_login") ?></button>
                    </div>
                    <?php $discordPluginEnabled = config('plugins.discord.enabled'); ?>
                    <?php if ($discordPluginEnabled): ?>
                    <p style="margin: 14px 0 8px; font-size: 12px; color: #9ca3af; text-align: center;"><?= __("auth.or") ?></p>
                    <div style="text-align: center; margin-bottom: 12px;">
                        <a href="<?= rtrim(route(''), '/') ?>/auth/discord?state=login" class="btn" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #5865F2; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 14px; width: 100%; max-width: 100%; box-sizing: border-box;">
                            <i class="ph ph-discord-logo" style="font-size: 22px;"></i>
                            <?= __("auth.login_with_discord") ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    <p style="text-align: center; margin: 0; font-size: 13px;">
                        <a href="<?= route("forgot") ?>"><?= __("auth.forgot_password") ?></a>
                    </p>
                </form>
                <?php if (recaptcha_version() === 'v3'): ?>
                    <script>
                        // Para v3, regenerar token antes de submit
                        document.getElementById('login-form-popup')?.addEventListener('submit', function (e) {
                            if (<?= recaptcha_enabled() ? 'true' : 'false' ?>) {
                                grecaptcha.ready(function () {
                                    grecaptcha.execute('<?= recaptcha_site_key() ?>', { action: 'login' }).then(function (token) {
                                        document.getElementById('g-recaptcha-response').value = token;
                                    });
                                });
                            }
                        });
                    </script>
                <?php endif; ?>
            </div>
        </div>

        <div class="login-popup" id="register-popup">
            <div class="login-popup-content" style="max-width: 500px; max-height: 90vh; overflow-y: auto;">
                <div class="login-popup-header">
                    <h3><?= __("page.register") ?></h3>
                    <button type="button" class="login-popup-close" onclick="closeRegisterPopup()">&times;</button>
                </div>
                <form action="<?= route('register.store') ?>" class="form" method="post" id="register-form-popup">
                    <?= csrf_field() ?>
                    <label for="name-popup"><?= __("auth.name") ?></label>
                    <input type="text" id="name-popup" name="name" required maxlength="10">

                    <label for="email-popup"><?= __("auth.email") ?></label>
                    <input type="email" id="email-popup" name="email" required maxlength="50">

                    <label for="login-register-popup"><?= __("auth.username") ?></label>
                    <input type="text" id="login-register-popup" name="login" required maxlength="10">

                    <label for="password-register-popup"><?= __("auth.password") ?></label>
                    <input type="password" id="password-register-popup" name="password" required maxlength="10">

                    <label for="confirm_password-register-popup"><?= __("auth.confirm_password") ?></label>
                    <input type="password" id="confirm_password-register-popup" name="confirm_password" required
                        maxlength="10">

                    <?= recaptcha_field() ?>

                    <div class="checkbox" style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 8px;">
                        <input type="checkbox" id="terms-popup" name="terms" value="1" required
                            style="width: auto; margin: 0; margin-top: 4px;">
                        <label for="terms-popup"
                            style="margin: 0; font-size: 13px; font-weight: normal; text-transform: none; letter-spacing: normal; cursor: pointer; line-height: 1.5;">
                            <?= __("auth.terms_agree", ['terms' => '<a href="' . route('terms') . '" target="_blank" style="color: #5865f2; text-decoration: underline;">' . __("auth.terms") . '</a>', 'rules' => '<a href="' . route('rules') . '" target="_blank" style="color: #5865f2; text-decoration: underline;">' . __("auth.rules") . '</a>']) ?>
                        </label>
                    </div>

                    <div class="action">
                        <button type="submit" class="btn btn-danger"><?= __("auth.submit_register") ?></button>
                    </div>
                </form>
                <?php if (recaptcha_version() === 'v3'): ?>
                    <script>
                        // Para v3, regenerar token antes de submit
                        document.getElementById('register-form-popup')?.addEventListener('submit', function (e) {
                            if (<?= recaptcha_enabled() ? 'true' : 'false' ?>) {
                                grecaptcha.ready(function () {
                                    grecaptcha.execute('<?= recaptcha_site_key() ?>', { action: 'register' }).then(function (token) {
                                        document.getElementById('g-recaptcha-response').value = token;
                                    });
                                });
                            }
                        });
                    </script>
                <?php endif; ?>
            </div>
        </div>

        <script>
            function openLoginPopup() {
                document.getElementById('login-popup').classList.add('show');
            }
            function closeLoginPopup() {
                document.getElementById('login-popup').classList.remove('show');
            }
            function openRegisterPopup() {
                document.getElementById('register-popup').classList.add('show');
            }
            function closeRegisterPopup() {
                document.getElementById('register-popup').classList.remove('show');
            }
            // Fechar ao clicar fora
            document.getElementById('login-popup')?.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeLoginPopup();
                }
            });
            document.getElementById('register-popup')?.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeRegisterPopup();
                }
            });
            // Fechar com ESC
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeLoginPopup();
                    closeRegisterPopup();
                }
            });
        </script>
    <?php endif; ?>

    <?php if (user()): ?>
    <div class="login-popup" id="password-popup">
        <div class="login-popup-content">
            <div class="login-popup-header">
                <h3><?= __("auth.change_password") ?></h3>
                <button type="button" class="login-popup-close" onclick="closePasswordPopup()">&times;</button>
            </div>
            <form action="<?= route('user.password.update') ?>" class="form" method="post">
                <?= csrf_field() ?>
                <div>
                    <label for="popup-old_password"><?= __("auth.old_password") ?></label>
                    <input type="password" id="popup-old_password" name="old_password" required maxlength="50">
                </div>
                <div>
                    <label for="popup-new_password"><?= __("auth.new_password") ?></label>
                    <input type="password" id="popup-new_password" name="new_password" required maxlength="50">
                </div>
                <div>
                    <label for="popup-confirm_new_password"><?= __("auth.confirm_new_password") ?></label>
                    <input type="password" id="popup-confirm_new_password" name="confirm_new_password" required maxlength="50">
                </div>
                <div class="action">
                    <button type="submit" class="btn btn-primary" style="width: 100%;"><?= __("auth.change") ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="login-popup" id="email-popup-global">
        <div class="login-popup-content">
            <div class="login-popup-header">
                <h3><?= __("auth.change_email") ?></h3>
                <button type="button" class="login-popup-close" onclick="closeEmailPopup()">&times;</button>
            </div>
            <form action="<?= route('user.mail.update') ?>" class="form" method="post">
                <?= csrf_field() ?>
                <div>
                    <label for="popup-email"><?= __("auth.new_email") ?></label>
                    <input type="email" id="popup-email" name="email" required maxlength="50" placeholder="<?= htmlspecialchars(__("auth.new_email_placeholder")) ?>">
                </div>
                <div>
                    <label for="popup-confirm_email"><?= __("auth.confirm_email") ?></label>
                    <input type="email" id="popup-confirm_email" name="confirm_email" required maxlength="50" placeholder="<?= htmlspecialchars(__("auth.confirm_email_placeholder")) ?>">
                </div>
                <div class="action">
                    <button type="submit" class="btn btn-primary" style="width: 100%;"><?= __("auth.change_email") ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="login-popup" id="ticket-popup">
        <div class="login-popup-content" style="max-width: 480px;">
            <div class="login-popup-header">
                <h3><?= __("auth.open_ticket") ?></h3>
                <button type="button" class="login-popup-close" onclick="closeTicketPopup()">&times;</button>
            </div>
            <form action="<?= route('user.ticket.store') ?>" class="form" method="post">
                <?= csrf_field() ?>
                <div>
                    <label for="popup-ticket-title"><?= __("auth.ticket_subject") ?></label>
                    <input type="text" id="popup-ticket-title" name="title" required maxlength="80" placeholder="<?= htmlspecialchars(__("auth.ticket_subject_placeholder")) ?>">
                </div>
                <div>
                    <label for="popup-ticket-content"><?= __("auth.ticket_message") ?></label>
                    <textarea id="popup-ticket-content" name="content" required maxlength="2000" rows="5" placeholder="<?= htmlspecialchars(__("auth.ticket_message_placeholder")) ?>"></textarea>
                </div>
                <div class="action">
                    <button type="submit" class="btn btn-primary" style="width: 100%;"><?= __("auth.send") ?></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPasswordPopup() { document.getElementById('password-popup').classList.add('show'); }
        function closePasswordPopup() { document.getElementById('password-popup').classList.remove('show'); }
        function openEmailPopup() { document.getElementById('email-popup-global').classList.add('show'); }
        function closeEmailPopup() { document.getElementById('email-popup-global').classList.remove('show'); }
        function openTicketPopup() { document.getElementById('ticket-popup').classList.add('show'); }
        function closeTicketPopup() { document.getElementById('ticket-popup').classList.remove('show'); }
        function closeProfilePopups() {
            closePasswordPopup();
            closeEmailPopup();
            closeTicketPopup();
        }
        document.getElementById('password-popup')?.addEventListener('click', function(e) { if (e.target === this) closePasswordPopup(); });
        document.getElementById('email-popup-global')?.addEventListener('click', function(e) { if (e.target === this) closeEmailPopup(); });
        document.getElementById('ticket-popup')?.addEventListener('click', function(e) { if (e.target === this) closeTicketPopup(); });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeProfilePopups();
        });
    </script>
    <?php endif; ?>

    <script src="<?= public_path('js/jquery-3.7.1.min.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/swiper.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/toast.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/alert.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= public_path('js/app.js') ?>?v=<?= time() ?>"></script>
    <script>
        // Configurações do Slider
        window.SLIDER_CONFIG = {
            autoplayEnabled: <?= config('slider.autoplay.enabled', true) ? 'true' : 'false' ?>,
            autoplayDelay: <?= (int) config('slider.autoplay.delay', 5000) ?>
        };
    </script>
    <script src="<?= asset_versioned('js/custom.js') ?>"></script>
    <script src="<?= asset_versioned('js/events.js') ?>"></script>
    <script>
    (function() {
        var STORAGE_KEY = 'webrox_font_size_step';
        var MIN_STEP = -3;
        var MAX_STEP = 3;
        var BASE_PX = 16;

        function getStep() {
            var v = localStorage.getItem(STORAGE_KEY);
            if (v === null) return 0;
            var n = parseInt(v, 10);
            if (isNaN(n) || n < MIN_STEP || n > MAX_STEP) return 0;
            return n;
        }

        function setStep(step) {
            step = Math.max(MIN_STEP, Math.min(MAX_STEP, step));
            localStorage.setItem(STORAGE_KEY, String(step));
            document.documentElement.style.fontSize = (BASE_PX + step) + 'px';
            var down = document.getElementById('font-size-down');
            var up = document.getElementById('font-size-up');
            if (down) down.disabled = (step <= MIN_STEP);
            if (up) up.disabled = (step >= MAX_STEP);
        }

        function init() {
            var step = getStep();
            /* Tamanho já aplicado no <head> para evitar flash; aqui só sincronizamos botões e eventos */
            var down = document.getElementById('font-size-down');
            var up = document.getElementById('font-size-up');
            if (down) {
                down.disabled = (step <= MIN_STEP);
                down.addEventListener('click', function() { setStep(getStep() - 1); });
            }
            if (up) {
                up.disabled = (step >= MAX_STEP);
                up.addEventListener('click', function() { setStep(getStep() + 1); });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();

    (function() {
        var THEME_KEY = 'webrox_theme';
        function getTheme() { return localStorage.getItem(THEME_KEY) || 'light'; }
        function setTheme(t) {
            t = t === 'dark' ? 'dark' : 'light';
            localStorage.setItem(THEME_KEY, t);
            document.documentElement.setAttribute('data-theme', t);
            var lightBtn = document.getElementById('theme-light');
            var darkBtn = document.getElementById('theme-dark');
            if (lightBtn) lightBtn.setAttribute('aria-pressed', t === 'light' ? 'true' : 'false');
            if (darkBtn) darkBtn.setAttribute('aria-pressed', t === 'dark' ? 'true' : 'false');
        }
        function initTheme() {
            var lightBtn = document.getElementById('theme-light');
            var darkBtn = document.getElementById('theme-dark');
            var current = getTheme();
            if (lightBtn) {
                lightBtn.setAttribute('aria-pressed', current === 'light' ? 'true' : 'false');
                lightBtn.addEventListener('click', function() { setTheme('light'); });
            }
            if (darkBtn) {
                darkBtn.setAttribute('aria-pressed', current === 'dark' ? 'true' : 'false');
                darkBtn.addEventListener('click', function() { setTheme('dark'); });
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTheme);
        } else {
            initTheme();
        }
    })();
    </script>
</body>

</html>