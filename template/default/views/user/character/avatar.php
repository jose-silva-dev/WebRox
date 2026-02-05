<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Alterar Avatar: <span><?= $character->name ?></span>
</div>

<div class="go_back">
    <a href="<?= route("user.character.{$character->name}") ?>">Voltar</a>
</div>

<div class="character-info">
    <?= $this->insert('components/web/user/avatar-box', ['character' => $character]) ?>
</div>

<form action="<?= route("user.character.{$character->name}.avatar.update") ?>" class="form" method="post" enctype="multipart/form-data">
    <div>
        <label for="avatar">Selecione a imagem:</label>
        <input type="file" id="avatar" name="avatar" required maxlength="10">
    </div>

    <div>
        <button type="submit">Atualizar</button>
    </div>
</form>