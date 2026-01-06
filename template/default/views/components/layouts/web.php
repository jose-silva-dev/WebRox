<!DOCTYPE html>
<html lang="en">

<head>
    <?= seo() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= assets('css/style.css') ?>">
    <link rel="stylesheet" href="<?= public_path("css/alert.css") ?>">
    <link rel="stylesheet" href="<?= public_path("css/swiper.css") ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <header>
        <?php 
        $siteConfig = config('site') ?? [];
        $logoConfig = $siteConfig['logo'] ?? ['enabled' => 1, 'value' => 'images/logo.png'];
        $titleConfig = $siteConfig['title'] ?? ['enabled' => 1, 'value' => 'Web Roxmu'];
        $descriptionConfig = $siteConfig['description'] ?? ['enabled' => 1, 'value' => 'Web Roxmu is a web application that provides a platform for users to interact with each other.'];
        ?>
        <?php if (!empty($logoConfig['enabled'])): ?>
            <img src="<?= assets($logoConfig['value']) ?>" alt="<?= htmlspecialchars($titleConfig['value'] ?? 'Logo') ?>">
        <?php endif; ?>
        <?php if (!empty($titleConfig['enabled'])): ?>
            <h1><?= htmlspecialchars($titleConfig['value']) ?></h1>
        <?php endif; ?>
        <?php if (!empty($descriptionConfig['enabled'])): ?>
            <p><?= htmlspecialchars($descriptionConfig['value']) ?></p>
        <?php endif; ?>
    </header>
    <?= $this->insert("components/web/navigation") ?>
    <div class="web-content">
        <div class="content space-y-1">
            <?= $this->section("content") ?>
        </div>
        <?= $this->insert("components/web/sidebar") ?>
    </div>

    <footer>
        <?php 
        $siteConfig = config('site') ?? [];
        $footerConfig = $siteConfig['footer'] ?? ['enabled' => 1, 'value' => 'Web Roxmu'];
        $titleConfig = $siteConfig['title'] ?? ['enabled' => 1, 'value' => 'Web Roxmu'];
        $currentYear = date('Y');
        $footerText = !empty($footerConfig['enabled']) && !empty($footerConfig['value']) ? $footerConfig['value'] : 'Web Roxmu';
        $siteTitle = !empty($titleConfig['enabled']) && !empty($titleConfig['value']) ? $titleConfig['value'] : 'Web Roxmu';
        ?>
        <div class="footer-content">
            <?php if (!empty($footerConfig['enabled'])): ?>
                <p class="company"><?= htmlspecialchars($footerText) ?> &copy; <?= $currentYear ?></p>
            <?php endif; ?>
            
            <p class="description">
                <?= htmlspecialchars($siteTitle) ?> é um MMORPG 3D grátis para jogar. Se aventure em um continente repleto de mundos para explorar e milhares de itens para colecionar e negociar.
            </p>
            
            <p class="copyright">
                Todos os direitos reservados a <a href="https://roxgaming.net" target="_blank" rel="noopener noreferrer">RoxGaming</a>.
            </p>
        </div>
    </footer>

    <!-- Login Popup -->
    <?php if (!user()): ?>
    <div class="login-popup" id="login-popup">
        <div class="login-popup-content">
            <div class="login-popup-header">
                <h3>Entrar</h3>
                <button type="button" class="login-popup-close" onclick="closeLoginPopup()">&times;</button>
            </div>
            <form action="<?= route("login") ?>" class="form" method="post" id="login-form-popup">
                <?= csrf_field() ?>
                <label for="username-popup">Usuário</label>
                <input type="text" id="username-popup" name="username" required>
                <label for="password-popup">Senha</label>
                <input type="password" id="password-popup" name="password" required>
                <?= recaptcha_field() ?>
                <div class="checkbox" style="margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="remember-me-popup" name="remember_me" value="1" style="width: auto; margin: 0;">
                    <label for="remember-me-popup" style="margin: 0; font-size: 13px; font-weight: normal; text-transform: none; letter-spacing: normal; cursor: pointer;">Lembrar-me</label>
                </div>
                <div class="action">
                    <button type="submit" class="btn btn-danger">Entrar</button>
                    <a href="<?= route("forgot") ?>">Recuperar Senha</a>
                </div>
            </form>
            <?php if (recaptcha_version() === 'v3'): ?>
            <script>
                // Para v3, regenerar token antes de submit
                document.getElementById('login-form-popup')?.addEventListener('submit', function(e) {
                    if (<?= recaptcha_enabled() ? 'true' : 'false' ?>) {
                        grecaptcha.ready(function() {
                            grecaptcha.execute('<?= recaptcha_site_key() ?>', {action: 'login'}).then(function(token) {
                                document.getElementById('g-recaptcha-response').value = token;
                            });
                        });
                    }
                });
            </script>
            <?php endif; ?>
        </div>
    </div>

    <!-- Register Popup -->
    <div class="login-popup" id="register-popup">
        <div class="login-popup-content" style="max-width: 500px; max-height: 90vh; overflow-y: auto;">
            <div class="login-popup-header">
                <h3>Cadastro</h3>
                <button type="button" class="login-popup-close" onclick="closeRegisterPopup()">&times;</button>
            </div>
            <form action="<?= route('register.store') ?>" class="form" method="post" id="register-form-popup">
                <?= csrf_field() ?>
                <label for="name-popup">Nome</label>
                <input type="text" id="name-popup" name="name" required maxlength="10">
                
                <label for="email-popup">Email</label>
                <input type="email" id="email-popup" name="email" required maxlength="50">
                
                <label for="confirm_email-popup">Confirmar Email</label>
                <input type="email" id="confirm_email-popup" name="confirm_email" required maxlength="50">
                
                <label for="login-register-popup">Login</label>
                <input type="text" id="login-register-popup" name="login" required maxlength="10">
                
                <label for="password-register-popup">Senha</label>
                <input type="password" id="password-register-popup" name="password" required maxlength="10">
                
                <label for="confirm_password-register-popup">Confirmar Senha</label>
                <input type="password" id="confirm_password-register-popup" name="confirm_password" required maxlength="10">
                
                <?= recaptcha_field() ?>
                
                <div class="checkbox" style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 8px;">
                    <input type="checkbox" id="terms-popup" name="terms" value="1" required style="width: auto; margin: 0; margin-top: 4px;">
                    <label for="terms-popup" style="margin: 0; font-size: 13px; font-weight: normal; text-transform: none; letter-spacing: normal; cursor: pointer; line-height: 1.5;">
                        Li e concordo com os <a href="<?= route('terms') ?>" target="_blank" style="color: #5865f2; text-decoration: underline;">termos</a> e <a href="<?= route('rules') ?>" target="_blank" style="color: #5865f2; text-decoration: underline;">regras do jogo</a>
                    </label>
                </div>
                
                <div class="action">
                    <button type="submit" class="btn btn-danger">Cadastrar</button>
                </div>
            </form>
            <?php if (recaptcha_version() === 'v3'): ?>
            <script>
                // Para v3, regenerar token antes de submit
                document.getElementById('register-form-popup')?.addEventListener('submit', function(e) {
                    if (<?= recaptcha_enabled() ? 'true' : 'false' ?>) {
                        grecaptcha.ready(function() {
                            grecaptcha.execute('<?= recaptcha_site_key() ?>', {action: 'register'}).then(function(token) {
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
        document.getElementById('login-popup')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginPopup();
            }
        });
        document.getElementById('register-popup')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterPopup();
            }
        });
        // Fechar com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginPopup();
                closeRegisterPopup();
            }
        });
    </script>
    <?php endif; ?>

    <script src="<?= public_path('js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= public_path('js/swiper.js') ?>"></script>
    <script src="<?= public_path('js/alert.js') ?>"></script>
    <script src="<?= public_path('js/app.js') ?>"></script>
    <script>
        // Configurações do Slider
        window.SLIDER_CONFIG = {
            autoplayEnabled: <?= config('slider.autoplay.enabled', true) ? 'true' : 'false' ?>,
            autoplayDelay: <?= (int)config('slider.autoplay.delay', 5000) ?>
        };
    </script>
    <script src="<?= assets('js/custom.js') ?>"></script>
    <script src="/template/default/assets/js/events.js"></script>
</body>

</html>