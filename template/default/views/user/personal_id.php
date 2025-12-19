<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Alterar Personal ID
</div>

<?= $this->insert('user/partials/menu') ?>

<form action="<?= route('user.personal_id.update') ?>" class="form" method="post">
    <div>
        <label for="personal_id">Personal ID Antigo</label>
        <input type="number" id="personal_id" name="personal_id" required maxlength="50">
    </div>
    <div>
        <button type="submit">Alterar</button>
    </div>
</form>