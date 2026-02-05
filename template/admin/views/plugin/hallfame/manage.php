<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div class="admin-page-header">
        <div>
            <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Hall of Fame') ?></h1>
            <div class="admin-accent-line"></div>
        </div>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <form id="hallfame-form" action="<?= route('admin/plugins/hallfame/save') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            
            <div class="form space-y-1" style="background: var(--bg-card); padding: 1rem; border-radius: 10px; border: 1px solid var(--border-color); margin-bottom: 1rem;">
                <h3 class="subtitle" style="margin-bottom: 0.75rem;">Configuração de Exibição</h3>
                
                <div>
                    <label for="hallfame-top-count">Quantos Rankings Aparecem no Topo</label>
                    <input type="number" 
                           name="hallfame[home][top_count]" 
                           id="hallfame-top-count"
                           value="<?= htmlspecialchars($plugin['config']['home']['top_count'] ?? 3) ?>"
                           min="1"
                           max="10"
                           required>
                    <small class="form-hint">
                        Quantidade de jogadores que aparecem destacados no topo do Hall da Fama (ex: 3 para mostrar 1º, 2º e 3º lugar)
                    </small>
                </div>
            </div>

            <div class="space-y-2">
                <h3 class="subtitle">Rankings - Home</h3>
                <small class="form-hint" style="margin-bottom: 10px;">
                    Rankings exibidos na página inicial (homepage)
                </small>

                <?php
                $homeDisplay = $plugin['config']['home']['display'] ?? [];
                if (!is_array($homeDisplay) || isset($homeDisplay['enabled'])) {
                    $homeDisplay = [];
                }
                ?>

                <div id="hallfame-home-container" class="space-y-1">
                    <?php foreach ($homeDisplay as $i => $rank): ?>
                        <div class="form ranking-item space-y-1 admin-plan-card" data-ranking-index="<?= $i ?>">
                            <label>
                                <input type="hidden"
                                       name="hallfame[home][display][<?= $i ?>][enabled]"
                                       value="0">
                                <input type="checkbox"
                                       name="hallfame[home][display][<?= $i ?>][enabled]"
                                       value="1"
                                       <?= !empty($rank['enabled']) ? 'checked' : '' ?>>
                                Ativo
                            </label>

                            <div>
                                <label>Título</label>
                                <input type="text"
                                       name="hallfame[home][display][<?= $i ?>][title]"
                                       value="<?= htmlspecialchars($rank['title'] ?? '') ?>"
>
                                <small class="form-hint">
                                    Título exibido no ranking
                                </small>
                            </div>

                            <div class="grid-2">
                                <div>
                                    <label>Tabela</label>
                                    <input type="text"
                                           name="hallfame[home][display][<?= $i ?>][table]"
                                           value="<?= htmlspecialchars($rank['table'] ?? '') ?>"
>
                                    <small class="form-hint">
                                        Nome da tabela no banco de dados
                                    </small>
                                </div>

                                <div>
                                    <label>Coluna</label>
                                    <input type="text"
                                           name="hallfame[home][display][<?= $i ?>][column]"
                                           value="<?= htmlspecialchars($rank['column'] ?? '') ?>"
>
                                    <small class="form-hint">
                                        Nome da coluna que será ordenada
                                    </small>
                                </div>
                            </div>

                            <div class="grid-2">
                                <div>
                                    <label>Tag</label>
                                    <input type="text"
                                           name="hallfame[home][display][<?= $i ?>][tag]"
                                           value="<?= htmlspecialchars($rank['tag'] ?? '') ?>"
>
                                    <small class="form-hint">
                                        Abreviação/tag do ranking (ex: RR, MR, PK)
                                    </small>
                                </div>

                                <div>
                                    <label>Slug</label>
                                    <input type="text"
                                           name="hallfame[home][display][<?= $i ?>][slug]"
                                           value="<?= htmlspecialchars($rank['slug'] ?? '') ?>"
>
                                    <small class="form-hint">
                                        Identificador único usado na URL (ex: resets, master-resets)
                                    </small>
                                </div>
                            </div>

                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border-color);">
                                <button type="button" class="btn btn-danger btn-sm remove-hallfame-home" title="Remover">
                                    <i class="ph ph-x" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="space-y-1">
                    <button type="button" class="btn btn-success btn-sm" id="add-hallfame-home">
                        <i class="ph ph-plus"></i> Adicionar Ranking
                    </button>
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="ph ph-check"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.HALLFAME_HOME_INDEX = <?= count($plugin['config']['home']['display'] ?? []) ?>;
</script>
<script src="/template/admin/assets/js/custom.js?v=<?= time() ?>" defer></script>



