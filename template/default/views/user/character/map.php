<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Alterar Mapa: <span><?= $character->name ?></span>
</div>

<div class="go_back">
    <a href="<?= route("user.character.{$character->name}") ?>">Voltar</a>
</div>

<div class="character-info">
    <?= $this->insert('components/web/user/avatar-box', ['character' => $character]) ?>
</div>

<form action="<?= route("user.character.{$character->name}.map.update") ?>" class="form" method="post">
    <div>
        <label for="map">Selecione o mapa:</label>
        <select name="map" id="map">
            <?php foreach (resolve('Geral')->getMaps() as $mapnumber => $map): ?>
                <option value="<?= $mapnumber ?>" <?= $mapnumber == $character->mapnumber ? 'selected' : '' ?>><?= $map['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <button type="submit">Atualizar</button>
    </div>
</form>