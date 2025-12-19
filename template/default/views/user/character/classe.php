<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Alterar Classe: <span><?= $character->name ?></span>
</div>

<div class="go_back">
    <a href="<?= route("user.character.{$character->name}") ?>">Voltar</a>
</div>

<div class="character-info">
    <?= $this->insert('components/web/user/avatar-box', ['character' => $character]) ?>
</div>

<form action="<?= route("user.character.{$character->name}.classe.update") ?>" class="form" method="post">
    <div>
        <label for="class">Selecione a classe:</label>
        <select name="class" id="class">
            <?php foreach (resolve('Geral')->getClasses() as $classnumber => $class): ?>
                <option value="<?= $classnumber ?>" <?= $classnumber == $character->class ? 'selected' : '' ?>><?= $class['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <button type="submit">Atualizar</button>
    </div>
</form>