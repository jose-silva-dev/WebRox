<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Recuperar Conta
</div>

<form action="<?= route('forgot.send.mail') ?>" class="form" method="post">
    <?= csrf_field() ?>
    <div>
        <label for="email">Digite seu email</label>
        <input type="text" id="email" name="email" required maxlength="50">
    </div>
    
    <?= recaptcha_field() ?>
    
    <div>
        <button type="submit">Enviar Email</button>
    </div>
</form>
<?php if (recaptcha_version() === 'v3'): ?>
<script>
    // Para v3, regenerar token antes de submit
    document.querySelector('form[action="<?= route('forgot.send.mail') ?>"]')?.addEventListener('submit', function(e) {
        if (<?= recaptcha_enabled() ? 'true' : 'false' ?>) {
            grecaptcha.ready(function() {
                grecaptcha.execute('<?= recaptcha_site_key() ?>', {action: 'forgot'}).then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                });
            });
        }
    });
</script>
<?php endif; ?>