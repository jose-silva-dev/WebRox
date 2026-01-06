<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Configuração de Mapas</h1>

    <div class="form">
        <form action="<?= route('admin/settings/map/update') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            <div id="maps-container" class="space-y-1">
                <?php foreach ($maps as $id => $map): ?>
                    <div class="form map-item space-y-1" data-id="<?= (int)$id ?>">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <strong class="sub-title map-id-title-<?= (int)$id ?>">ID <?= (int)$id ?></strong>
                            <button type="button" class="btn btn-danger btn-sm remove-map">
                                <i class="ph ph-trash"></i> Remover
                            </button>
                        </div>

                        <div>
                            <label>ID do Mapa</label>
                            <input type="number"
                                   name="map[<?= (int)$id ?>][id]"
                                   value="<?= (int)$id ?>"
                                   class="map-id-input"
                                   data-map-index="<?= (int)$id ?>"
                                   required>
                        </div>

                        <div>
                            <label>Nome do Mapa</label>
                            <input type="text"
                                   name="map[<?= (int)$id ?>][name]"
                                   value="<?= htmlspecialchars($map['name']) ?>"
                                   required>
                        </div>

                        <div class="grid-2">
                            <div>
                                <label>Posição X</label>
                                <input type="number"
                                       name="map[<?= (int)$id ?>][position][x]"
                                       value="<?= (int)$map['position']['x'] ?>"
                                       required>
                            </div>
                            <div>
                                <label>Posição Y</label>
                                <input type="number"
                                       name="map[<?= (int)$id ?>][position][y]"
                                       value="<?= (int)$map['position']['y'] ?>"
                                       required>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div>
                <button type="button" class="btn btn-success" id="add-map">
                    <i class="ph ph-plus"></i> Adicionar Mapa
                </button>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar Mapas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.MAPS_ENABLED = true;
</script>

<script src="/template/admin/assets/js/custom.js?v=<?= time() ?>" defer></script>