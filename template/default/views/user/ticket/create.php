<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Abrir Chamado
</div>

<div class="go_back">
    <a href="<?= route("user.ticket") ?>">Voltar</a>
</div>

<form action="<?= route("user.ticket.store") ?>" class="form" method="POST">
    <div>
        <label for="title">Assunto</label>
        <input type="text" id="title" name="title" required maxlength="80">
    </div>

    <div>
        <label for="content">Mensagem</label>

        <textarea id="content" name="content" required maxlength="2000"></textarea>
    </div>

    <div>
        <button type="submit">Enviar</button>
    </div>
</form>