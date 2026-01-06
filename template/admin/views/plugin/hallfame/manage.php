<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Hall of Fame') ?></h1>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <form id="hallfame-form" action="<?= route('admin/plugins/hallfame/save') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            
            <!-- Configuração de Exibição -->
            <div class="form space-y-1" style="background: var(--background-card); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--neutral-300); margin-bottom: 2rem;">
                <h3 class="subtitle" style="margin-bottom: 1rem;">Configuração de Exibição</h3>
                
                <div>
                    <label for="hallfame-top-count">Quantos Rankings Aparecem no Topo</label>
                    <input type="number" 
                           name="hallfame[home][top_count]" 
                           id="hallfame-top-count"
                           value="<?= htmlspecialchars($plugin['config']['home']['top_count'] ?? 3) ?>"
                           min="1"
                           max="10"
                           required>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Quantidade de jogadores que aparecem destacados no topo do Hall da Fama (ex: 3 para mostrar 1º, 2º e 3º lugar)
                    </small>
                </div>
            </div>

            <!-- Rankings - Home -->
            <div class="space-y-2">
                <h3 class="subtitle">Rankings - Home</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
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
                        <div class="form ranking-item space-y-1" data-ranking-index="<?= $i ?>">
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
                                       placeholder="Resets">
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Título exibido no ranking
                                </small>
                            </div>

                            <div class="grid-2">
                                <div>
                                    <label>Tabela</label>
                                    <input type="text"
                                           name="hallfame[home][display][<?= $i ?>][table]"
                                           value="<?= htmlspecialchars($rank['table'] ?? '') ?>"
                                           placeholder="Character">
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Nome da tabela no banco de dados
                                    </small>
                                </div>

                                <div>
                                    <label>Coluna</label>
                                    <input type="text"
                                           name="hallfame[home][display][<?= $i ?>][column]"
                                           value="<?= htmlspecialchars($rank['column'] ?? '') ?>"
                                           placeholder="ResetCount">
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
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
                                           placeholder="RR">
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Abreviação/tag do ranking (ex: RR, MR, PK)
                                    </small>
                                </div>

                                <div>
                                    <label>Slug</label>
                                    <input type="text"
                                           name="hallfame[home][display][<?= $i ?>][slug]"
                                           value="<?= htmlspecialchars($rank['slug'] ?? '') ?>"
                                           placeholder="resets">
                                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                        Identificador único usado na URL (ex: resets, master-resets)
                                    </small>
                                </div>
                            </div>

                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #333;">
                                <button type="button" class="btn btn-danger btn-sm remove-hallfame-home">
                                    <i class="ph ph-trash"></i> Remover
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="space-y-1">
                    <button type="button" class="btn btn-success" id="add-hallfame-home">
                        <i class="ph ph-plus"></i> Adicionar Ranking
                    </button>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-danger">
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



