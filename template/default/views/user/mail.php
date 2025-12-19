<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Alterar Email
</div>

<?= $this->insert('user/partials/menu') ?>

<form action="<?= route('user.mail.update') ?>" class="form" method="post">
    <div>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" required maxlength="50">
    </div>

    <div>
        <label for="confirm_email">Confirmar Email</label>
        <input type="email" id="confirm_email" name="confirm_email" required maxlength="50">
    </div>

    <div>
        <button type="submit">Alterar</button>
    </div>
</form>