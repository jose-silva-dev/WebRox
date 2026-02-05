<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    <?= __("page.register") ?>
</div>

<form action="<?= route('register.store') ?>" class="form" method="post">
    <?= csrf_field() ?>
    <div>
        <label for="name"><?= __("auth.name") ?></label>
        <input type="text" id="name" name="name" required maxlength="10">
    </div>

    <div>
        <label for="email"><?= __("auth.email") ?></label>
        <input type="email" id="email" name="email" required maxlength="50">
    </div>

    <div>
        <label for="login"><?= __("auth.username") ?></label>
        <input type="text" id="login" name="login" required maxlength="10">
    </div>

    <div>
        <label for="password"><?= __("auth.password") ?></label>
        <input type="password" id="password" name="password" required maxlength="32">
    </div>

    <div>
        <label for="confirm_password"><?= __("auth.confirm_password") ?></label>
        <input type="password" id="confirm_password" name="confirm_password" required maxlength="32">
    </div>

    <?= recaptcha_field() ?>

    <div>
        <button type="submit"><?= __("auth.submit_register") ?></button>
    </div>
</form>
<?php if (recaptcha_version() === 'v3'): ?>
    <script>
        // Para v3, regenerar token antes de submit
        document.querySelector('form[action="<?= route('register.store') ?>"]')?.addEventListener('submit', function (e) {
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