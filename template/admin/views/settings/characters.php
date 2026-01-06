<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Configuração de Classes</h1>

    <div class="form">
        <form action="<?= route('admin/settings/characters/update') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            <div id="characters-container" class="space-y-1">
                <?php foreach ($characters as $id => $char): ?>
                    <div class="form character-item space-y-1" data-id="<?= (int)$id ?>">
                        <strong class="sub-title character-id-title-<?= (int)$id ?>">ID <?= (int)$id ?></strong>

                        <div>
                            <label>ID da Classe</label>
                            <input type="number"
                                   name="characters[<?= (int)$id ?>][id]"
                                   value="<?= (int)$id ?>"
                                   class="character-id-input"
                                   data-character-index="<?= (int)$id ?>"
                                   required>
                            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                ID numérico da classe
                            </small>
                        </div>

                        <div>
                            <label>Nome</label>
                            <input type="text"
                                   name="characters[<?= (int)$id ?>][name]"
                                   value="<?= htmlspecialchars($char['name']) ?>"
                                   placeholder="Dark Wizard"
                                   required>
                            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                Nome completo da classe
                            </small>
                        </div>

                        <div>
                            <label>Sigla</label>
                            <input type="text"
                                   name="characters[<?= (int)$id ?>][short_name]"
                                   value="<?= htmlspecialchars($char['short_name']) ?>"
                                   placeholder="DW"
                                   required>
                            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                Abreviação/sigla da classe
                            </small>
                        </div>

                        <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #333;">
                            <button type="button" class="btn btn-danger btn-sm remove-character">
                                <i class="ph ph-trash"></i> Remover
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="space-y-1">
                <button type="button" class="btn btn-success" id="add-character">
                    <i class="ph ph-plus"></i> Adicionar Classe
                </button>
            </div>

            <div class="space-y-1">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar Classes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.CHARACTERS_ENABLED = true;
</script>

<script src="/template/admin/assets/js/custom.js?v=<?= time() ?>" defer></script>
