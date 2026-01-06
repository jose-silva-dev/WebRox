<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Alterar Senha
</div>

<?= $this->insert('user/partials/menu') ?>

<form action="<?= route('user.password.update') ?>" class="form" method="post">
    <?= csrf_field() ?>
    <div>
        <label for="old_password">Senha Antiga</label>
        <input type="password" id="old_password" name="old_password" required maxlength="50">
    </div>

    <div>
        <label for="new_password">Nova Senha</label>
        <input type="password" id="new_password" name="new_password" required maxlength="50">
    </div>

    <div>
        <label for="confirm_new_password">Confirmar Nova Senha</label>
        <input type="password" id="confirm_new_password" name="confirm_new_password" required maxlength="50">
    </div>

    <div>
        <button type="submit">Alterar</button>
    </div>
</form>