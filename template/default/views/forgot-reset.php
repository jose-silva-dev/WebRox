<?= $this->layout('components/layouts/web') ?>

<?php $token = $token ?? ''; ?>
<div class="forgot-page">
    <header class="forgot-page-header">
        <h1 class="forgot-page-title"><?= __("forgot.reset_title") ?></h1>
        <div class="accent-line"></div>
        <p class="forgot-page-subtitle">
            <?= __("forgot.reset_subtitle") ?>
        </p>
    </header>

    <div class="forgot-form-card">
        <form action="<?= rtrim(route(''), '/') ?>/forgot/reset" class="form" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div>
                <label for="password"><?= __("forgot.new_password") ?></label>
                <input type="password" id="password" name="password" required minlength="4" maxlength="32" placeholder="<?= __("forgot.new_password") ?>" autocomplete="new-password">
            </div>
            <div>
                <label for="confirm_password"><?= __("forgot.confirm_password") ?></label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="4" maxlength="32" placeholder="<?= __("forgot.confirm_password") ?>" autocomplete="new-password">
            </div>
            <div class="forgot-form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-key"></i>
                    <?= __("forgot.reset_submit") ?>
                </button>
            </div>
        </form>
    </div>
</div>
