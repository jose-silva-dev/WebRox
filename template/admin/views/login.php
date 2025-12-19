<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?= seo() ?>
    <link rel="stylesheet" href="<?= assets('css/login.css', 'admin') ?>">
    <link rel="stylesheet" href="<?= public_path("css/alert.css") ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <form action="<?= route('admin.login') ?>" method="post">
                    <div class="login__group">
                        <label for="login"><i class="ph ph-user"></i> Login</label>
                        <input type="text" id="login" name="login" placeholder="Digite seu login" required>
                    </div>

                    <div class="login__group">
                        <label for="password"><i class="ph ph-lock-key"></i> Senha</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <div class="login__actions">
                        <button type="submit" class="btn-mu">
                            <span>ENTRAR</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= public_path('js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= public_path('js/alert.js') ?>"></script>
    <script src="<?= public_path('js/app.js') ?>"></script>
</body>

</html>