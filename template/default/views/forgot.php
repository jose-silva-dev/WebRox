<?= $this->layout('components/layouts/web') ?>

<div class="forgot-page">
    <header class="forgot-page-header">
        <h1 class="forgot-page-title"><?= __("forgot.title") ?></h1>
        <div class="accent-line"></div>
        <p class="forgot-page-subtitle">
            <?= __("forgot.subtitle") ?>
        </p>
    </header>

    <div class="forgot-form-card">
        <form action="<?= route('forgot.send.mail') ?>" class="form" method="post">
            <?= csrf_field() ?>
            <div>
                <label for="email"><?= __("forgot.email_label") ?></label>
                <input type="email" id="email" name="email" required maxlength="50" placeholder="<?= __("forgot.email_label") ?>">
            </div>

            <?= recaptcha_field() ?>

            <div class="forgot-form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-paper-plane-tilt"></i>
                    <?= __("forgot.submit") ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php if (recaptcha_version() === 'v3'): ?>
<script>
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
