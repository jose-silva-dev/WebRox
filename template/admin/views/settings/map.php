<?= $this->layout('components/layouts/admin') ?>

<div class="adm-dashboard">
    <form action="<?= route('admin/settings/map/update') ?>" method="post" class="settings-form">
        <?= csrf_field() ?>

        <div class="adm-dashboard__grid" style="grid-template-columns: 1fr;">
            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Configurações do Sistema</p>
                        <h2 class="adm-card__title">Mapas Existentes</h2>
                    </div>
                </header>
                <div id="maps-container" class="maps-grid">
                    <?php foreach ($maps as $id => $map): ?>
                        <div class="map-card map-item" data-id="<?= (int)$id ?>">
                            <div class="map-card__header">
                                <strong class="sub-title map-id-title-<?= (int)$id ?>">ID <?= (int)$id ?></strong>
                                <button type="button" class="btn btn-danger btn-sm remove-map" title="Remover mapa">
                                    <i class="ph ph-x" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="map-card__fields">
                                <div class="field-id">
                                    <label for="map-id-<?= (int)$id ?>">ID</label>
                                    <input type="number"
                                           id="map-id-<?= (int)$id ?>"
                                           name="map[<?= (int)$id ?>][id]"
                                           value="<?= (int)$id ?>"
                                           class="map-id-input"
                                           data-map-index="<?= (int)$id ?>"
                                           required>
                                </div>
                                <div class="field-name">
                                    <label for="map-name-<?= (int)$id ?>">Nome</label>
                                    <input type="text"
                                           id="map-name-<?= (int)$id ?>"
                                           name="map[<?= (int)$id ?>][name]"
                                           value="<?= htmlspecialchars($map['name']) ?>"
                                           required>
                                </div>
                                <div class="field-x">
                                    <label for="map-x-<?= (int)$id ?>">X</label>
                                    <input type="number"
                                           id="map-x-<?= (int)$id ?>"
                                           name="map[<?= (int)$id ?>][position][x]"
                                           value="<?= (int)($map['position']['x'] ?? 0) ?>"
                                           required>
                                </div>
                                <div class="field-y">
                                    <label for="map-y-<?= (int)$id ?>">Y</label>
                                    <input type="number"
                                           id="map-y-<?= (int)$id ?>"
                                           name="map[<?= (int)$id ?>][position][y]"
                                           value="<?= (int)($map['position']['y'] ?? 0) ?>"
                                           required>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Novos mapas</p>
                        <h2 class="adm-card__title">Adicionar Novos Mapas</h2>
                    </div>
                    <button type="button" class="btn btn-success" id="add-map">
                        <i class="ph ph-plus"></i> Adicionar
                    </button>
                </header>
                <p class="settings-desc">Novos mapas adicionados aqui serão salvos ao clicar em <strong>Salvar Mapas</strong>.</p>
                <div id="new-maps-container" class="maps-grid"></div>
            </section>

            <section class="adm-card adm-card--full settings-card--submit">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar Mapas
                </button>
            </section>
        </div>
    </form>
</div>

<script>window.MAPS_ENABLED = true;</script>
<script src="<?= assets('js/custom.js', 'admin') ?>?v=<?= time() ?>" defer></script>
