<div class="settings-card">
    <h3 class="subtitle">Configuração de Cache</h3>
    <div>
        <label>
            <input type="hidden" name="rankings[cache][enabled]" value="0">
            <input type="checkbox"
                   name="rankings[cache][enabled]"
                   value="1"
                   <?= !empty($rankings['cache']['enabled']) ? 'checked' : '' ?>
                   id="ranking-cache-enabled">
            Ativar Cache de Rankings
        </label>
        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
            Quando ativado, os rankings serão armazenados em cache para melhorar a performance
        </small>
    </div>
    <div id="ranking-cache-settings" style="<?= empty($rankings['cache']['enabled']) ? 'display: none;' : '' ?>">
        <div>
            <label for="ranking-cache-interval">Intervalo de Atualização (minutos)</label>
            <input type="number"
                   name="rankings[cache][interval]"
                   id="ranking-cache-interval"
                   value="<?= htmlspecialchars($rankings['cache']['interval'] ?? 30) ?>"
                   min="5"
                   max="1440"
                   required>
            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                Tempo em minutos que o cache será mantido antes de atualizar (mínimo: 5, máximo: 1440)
            </small>
        </div>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--neutral-300);">
            <button type="button" class="btn btn-danger btn-sm" id="clear-ranking-cache" onclick="clearRankingCache()">
                <i class="ph ph-trash"></i> Limpar Cache de Rankings
            </button>
            <div id="clear-ranking-cache-result" class="settings-feedback" style="margin-top: 8px; display: none;"></div>
            <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                Use este botão após trocar de banco de dados ou quando os rankings estiverem desatualizados
            </small>
        </div>
    </div>
</div>

<div class="settings-card">
    <h3 class="subtitle">Rankings - Geral</h3>
    <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
        Rankings disponíveis na página de rankings completa. Por padrão vêm os rankings padrão; a opção <strong>Remover</strong> funciona normalmente. Se quiser remover todos e alterar à sua maneira, pode fazer — a escolha é sua.
    </small>
    <div class="form" style="margin-bottom: 15px;">
        <label style="display:flex; gap:10px; align-items:center;">
            <input type="checkbox" name="rankings[geral_prune_disabled]" value="1">
            Limpar rankings desativados antigos ao salvar (remove do arquivo e não volta mais)
        </label>
        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
            Útil para "limpar sujeira" de configurações antigas. Se marcar e salvar, os itens com <strong>Ativo</strong> desmarcado serão removidos.
        </small>
    </div>
    <?php $geralRankings = $rankings['geral'] ?? []; if (!is_array($geralRankings)) $geralRankings = []; ?>
    <div id="rankings-geral-container" class="space-y-1">
        <?php foreach ($geralRankings as $i => $rank): ?>
            <?php if (!is_array($rank)) continue; ?>
            <div class="form ranking-item space-y-1" data-ranking-index="<?= $i ?>">
                <label>
                    <input type="hidden" name="rankings[geral][<?= $i ?>][enabled]" value="0">
                    <input type="checkbox" name="rankings[geral][<?= $i ?>][enabled]" value="1" <?= !empty($rank['enabled']) ? 'checked' : '' ?>>
                    Ativo
                </label>
                <div>
                    <label>Título</label>
                    <input type="text" name="rankings[geral][<?= $i ?>][title]" value="<?= htmlspecialchars($rank['title'] ?? '') ?>"  required>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Título exibido no ranking</small>
                </div>
                <div class="grid-2">
                    <div>
                        <label>Tabela</label>
                        <input type="text" name="rankings[geral][<?= $i ?>][table]" value="<?= htmlspecialchars($rank['table'] ?? '') ?>"  required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome da tabela no banco de dados</small>
                    </div>
                    <div>
                        <label>Coluna</label>
                        <input type="text" name="rankings[geral][<?= $i ?>][column]" value="<?= htmlspecialchars($rank['column'] ?? '') ?>"  required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome da coluna que será ordenada</small>
                    </div>
                </div>
                <div class="grid-2">
                    <div>
                        <label>Tag</label>
                        <input type="text" name="rankings[geral][<?= $i ?>][tag]" value="<?= htmlspecialchars($rank['tag'] ?? '') ?>"  required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Abreviação/tag do ranking (ex: RD, RS, PK, HR)</small>
                    </div>
                    <div>
                        <label>Slug</label>
                        <input type="text" name="rankings[geral][<?= $i ?>][slug]" value="<?= htmlspecialchars($rank['slug'] ?? '') ?>"  required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Identificador único usado na URL (ex: resets-diarios, pk-total)</small>
                    </div>
                </div>
                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #333;">
                    <button type="button" class="btn btn-danger btn-sm remove-ranking-geral" title="Remover"><i class="ph ph-x" aria-hidden="true"></i></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="space-y-1">
        <button type="button" class="btn btn-success" id="add-ranking-geral"><i class="ph ph-plus"></i> Adicionar Ranking</button>
    </div>
</div>

<script>window.CLEAR_RANKING_CACHE_URL = "<?= route('admin/settings/clear-ranking-cache') ?>";</script>
