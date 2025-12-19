<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Recuperar Conta
</div>

<form action="<?= route('forgot.send.mail') ?>" class="form" method="post">
    <div>
        <label for="email">Digite seu email</label>
        <input type="text" id="email" name="email" required maxlength="50">
    </div>
    <div>
        <button type="submit">Enviar Email</button>
    </div>
</form>