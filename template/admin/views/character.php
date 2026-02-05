<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <form action="<?= route("admin.character.search") ?>" method="post" class="form">
        <?= csrf_field() ?>
        <div style="display: flex; gap: 0.5rem; align-items: end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label for="character">Buscas Personagem</label>
                <input type="text" name="character" id="character"  value="<?= $character ?? "" ?>" required>
            </div>
            <div>
                <button type="submit" class="btn btn-danger btn-sm"><i class="ph ph-magnifying-glass"></i> Buscar</button>
            </div>
        </div>
    </form>
</div>

<?php if ($characterInfo): ?>
    <div class="information">
        <div class="details">
            <img src="<?= resolve('Geral')->getAvatar($characterInfo->avatar) ?>" alt="Avatar" class="avatar">
            <p>Nome: <span><?= $characterInfo->name ?></span></p>
            <p>Level: <span><?= $characterInfo->level ?></span></p>
            <p>Classe: <span><?= resolve('Geral')->getClass($characterInfo->class)->name ?></span></p>
        </div>
        <div class="action">
            <div>
                <form action="<?= route("admin.character.update.data.$character") ?>" method="post" class="form space-y-1">
                    <?= csrf_field() ?>
                    <div class="sub-title">Atualizar Dados</div>
                    <div>
                        <label for="class">Classe</label>
                        <select name="class" id="class">
                            <?php foreach (resolve('Geral')->getClasses() as $key => $class): ?>
                                <option value="<?= $key ?>" <?= $characterInfo->class == $key ? 'selected' : '' ?>><?= $class['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="name">Level</label>
                        <input type="text" name="level" id="level" value="<?= $characterInfo->level ?>" required>
                    </div>
                    <div>
                        <label for="name">Força</label>
                        <input type="text" name="strength" id="strength" value="<?= $characterInfo->strength ?>" required>
                    </div>
                    <div>
                        <label for="dexterity">Dexteridade</label>
                        <input type="text" name="dexterity" id="dexterity" value="<?= $characterInfo->dexterity ?>" required>
                    </div>
                    <div>
                        <label for="energy">Energia</label>
                        <input type="text" name="energy" id="energy" value="<?= $characterInfo->energy ?>" required>
                    </div>
                    <div>
                        <label for="vitality">Vitalidade</label>
                        <input type="text" name="vitality" id="vitality" value="<?= $characterInfo->vitality ?>" required>
                    </div>
                    <div>
                        <label for="leadership">Comando</label>
                        <input type="text" name="leadership" id="leadership" value="<?= $characterInfo->leadership ?>" required>
                    </div>
                    <div>
                        <label for="status">Status da Personagem</label>
                        <select name="status" id="status">
                            <option value="0" <?= $characterInfo->status == 0 ? 'selected' : '' ?>>Ativo</option>
                            <option value="1" <?= $characterInfo->status == 1 ? 'selected' : '' ?>>Bloqueado</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger"> <i class="ph ph-arrows-clockwise"></i> Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>