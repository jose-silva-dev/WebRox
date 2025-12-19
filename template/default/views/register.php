<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Cadastro
</div>

<form action="<?= route('register.store') ?>" class="form" method="post">
    <div>
        <label for="name">Nome</label>
        <input type="text" id="name" name="name" required maxlength="10">
    </div>

    <div>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" required maxlength="50">
    </div>

    <div>
        <label for="confirm_email">Confirmar Email</label>
        <input type="email" id="confirm_email" name="confirm_email" required maxlength="50">
    </div>

    <div>
        <label for="login">Login</label>
        <input type="text" id="login" name="login" required maxlength="10">
    </div>

    <div>
        <label for="password">Senha</label>
        <input type="password" id="password" name="password" required maxlength="10">
    </div>

    <div>
        <label for="confirm_password">Confirmar Senha</label>
        <input type="password" id="confirm_password" name="confirm_password" required maxlength="10">
    </div>

    <div>
        <button type="submit">Cadastrar</button>
    </div>
</form>