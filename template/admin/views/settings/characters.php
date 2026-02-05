<?= $this->layout('components/layouts/admin') ?>

<div class="adm-dashboard">
    <form action="<?= route('admin/settings/characters/update') ?>" method="post" class="settings-form">
        <?= csrf_field() ?>

        <div class="adm-dashboard__grid" style="grid-template-columns: 1fr;">
            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Configurações do Sistema</p>
                        <h2 class="adm-card__title">Classes Existentes</h2>
                    </div>
                </header>
                <div id="characters-container" class="characters-grid">
                    <?php foreach ($characters as $id => $char): ?>
                        <?php
                        $charName = is_array($char) ? ($char['name'] ?? '') : '';
                        $charShort = is_array($char) ? ($char['short_name'] ?? '') : '';
                        ?>
                        <div class="character-card character-item" data-id="<?= (int)$id ?>">
                            <div class="character-card__header">
                                <strong class="sub-title character-id-title-<?= (int)$id ?>">ID <?= (int)$id ?></strong>
                                <button type="button" class="btn btn-danger btn-sm remove-character" title="Remover classe">
                                    <i class="ph ph-x" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="character-card__fields">
                                <div class="field-id">
                                    <label for="char-id-<?= (int)$id ?>">ID</label>
                                    <input type="number"
                                           id="char-id-<?= (int)$id ?>"
                                           name="characters[<?= (int)$id ?>][id]"
                                           value="<?= (int)$id ?>"
                                           class="character-id-input"
                                           data-character-index="<?= (int)$id ?>"
                                           required
                                           title="ID numérico da classe">
                                </div>
                                <div class="field-name">
                                    <label for="char-name-<?= (int)$id ?>">Nome</label>
                                    <input type="text"
                                           id="char-name-<?= (int)$id ?>"
                                           name="characters[<?= (int)$id ?>][name]"
                                           value="<?= htmlspecialchars($charName) ?>"
                                           required
                                           title="Nome completo da classe">
                                </div>
                                <div class="field-short">
                                    <label for="char-short-<?= (int)$id ?>">Sigla</label>
                                    <input type="text"
                                           id="char-short-<?= (int)$id ?>"
                                           name="characters[<?= (int)$id ?>][short_name]"
                                           value="<?= htmlspecialchars($charShort) ?>"
                                           required
                                           title="Abreviação da classe">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Novas classes</p>
                        <h2 class="adm-card__title">Adicionar Novas Classes</h2>
                    </div>
                    <button type="button" class="btn btn-success" id="add-character">
                        <i class="ph ph-plus"></i> Adicionar
                    </button>
                </header>
                <p class="settings-desc">Novas classes adicionadas aqui serão salvas ao clicar em <strong>Salvar Classes</strong>.</p>
                <div id="new-characters-container" class="characters-grid"></div>
            </section>

            <section class="adm-card adm-card--full settings-card--submit">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar Classes
                </button>
            </section>
        </div>
    </form>
</div>

<script>window.CHARACTERS_ENABLED = true;</script>
<script src="<?= assets('js/custom.js', 'admin') ?>?v=<?= time() ?>" defer></script>
