<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Alterar Apelido: <span><?= $character->name ?></span>
</div>

<div class="go_back">
    <a href="<?= route("user.character.{$character->name}") ?>">Voltar</a>
</div>

<div class="character-info">
    <?= $this->insert('components/web/user/avatar-box', ['character' => $character]) ?>
</div>

<form action="<?= route("user.character.{$character->name}.nick.update") ?>" class="form" method="post">
    <div>
        <label for="nick">Novo Apelido:</label>
        <input type="text" id="nick" name="nick" required maxlength="10">
    </div>

    <div>
        <button type="submit">Atualizar</button>
    </div>
</form>