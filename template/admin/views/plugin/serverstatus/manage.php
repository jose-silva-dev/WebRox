<?= $this->layout('components/layouts/admin') ?>
<?php
$online_servers = $online_servers ?? ['timeout' => 1, 'list' => []];
$serverIcons = [
    '' => 'Padrão (automático)',
    'fire' => 'Fogo',
    'sword' => 'Espada',
    'shield' => 'Escudo',
    'crown' => 'Coroa',
    'trophy' => 'Troféu',
    'game-controller' => 'Controle / Jogo',
    'lightning' => 'Raio',
    'star' => 'Estrela',
    'skull' => 'Caveira',
    'flag' => 'Bandeira',
    'gem' => 'Diamante',
    'book-open-text' => 'Livro / Clássico',
    'crosshair' => 'Mira',
    'planet' => 'Planeta',
    'sword-cross' => 'Espadas cruzadas',
    'shield-checkered' => 'Escudo xadrez',
];
?>
<div class="space-y-1">
    <div class="admin-page-header">
        <div>
            <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Servidores Online') ?></h1>
            <div class="admin-accent-line"></div>
        </div>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <small class="form-hint" style="margin-bottom: 10px;">
            Configure as salas/servidores do jogo para exibir status online e Total Online no site (sidebar). Isso é <u>separado</u> de Configurações do Servidor → Nome do Servidor. O <strong>Nome da Sala</strong> é usado somente para buscar players online (MEMB_STAT.ServerName).
        </small>

        <form action="<?= route('admin/plugins/serverstatus/save') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>

            <div class="grid-2" style="margin-bottom: 10px;">
                <div>
                    <label>Timeout de Status (segundos)</label>
                    <input type="number" name="serverstatus[timeout]" value="<?= (float)($online_servers['timeout'] ?? 1) ?>"  min="0.1" step="0.1">
                    <small class="form-hint">Tempo máximo para checar se a sala está online.</small>
                </div>
            </div>

            <div id="serverstatus-servers-container" class="space-y-1">
                <?php foreach (($online_servers['list'] ?? []) as $i => $srv): ?>
                    <div class="form server-item space-y-1 admin-plan-card">
                        <div class="admin-plan-header">
                            <strong class="sub-title">Servidor</strong>
                            <button type="button" class="btn btn-danger btn-sm remove-serverstatus-server" title="Remover"><i class="ph ph-x" aria-hidden="true"></i></button>
                        </div>
                        <div><label>Nome do Servidor</label><input type="text" name="serverstatus[list][<?= $i ?>][name]" value="<?= htmlspecialchars($srv['name']) ?>" placeholder="Servidor Easy"><small class="form-hint">Nome exibido no site</small></div>
                        <div><label>Nome da Sala</label><input type="text" name="serverstatus[list][<?= $i ?>][room_name]" value="<?= htmlspecialchars($srv['room_name'] ?? ($srv['server_name'] ?? '')) ?>" ><small class="form-hint">Nome no banco (MEMB_STAT.ServerName)</small></div>
                        <div><label>Host do Servidor</label><input type="text" name="serverstatus[list][<?= $i ?>][ip]" value="<?= htmlspecialchars($srv['ip']) ?>" ><small class="form-hint">Você pode informar host e porta juntos: 127.0.0.1:55901</small></div>
                        <div><label>Porta</label><input type="number" name="serverstatus[list][<?= $i ?>][port]" value="<?= (int)$srv['port'] ?>" ></div>
                        <div><label>Máximo de Players</label><input type="number" name="serverstatus[list][<?= $i ?>][max_players]" value="<?= (int)($srv['max_players'] ?? 100) ?>"  min="1"></div>
                        <div><label style="display:flex;align-items:center;gap:8px;cursor:pointer;"><input type="checkbox" name="serverstatus[list][<?= $i ?>][is_new]" value="1" <?= !empty($srv['is_new']) ? 'checked' : '' ?>><span>Marcar como &quot;Novo&quot;</span></label><small class="form-hint">Badge NOVO e destaque no dropdown</small></div>
                        <div><label>Legenda</label><input type="text" name="serverstatus[list][<?= $i ?>][legend]" value="<?= htmlspecialchars($srv['legend'] ?? '') ?>" ></div>
                        <div><label>Ícone</label><select name="serverstatus[list][<?= $i ?>][icon]"><?php foreach ($serverIcons as $val => $lbl): ?><option value="<?= htmlspecialchars($val) ?>" <?= ($srv['icon'] ?? '') === $val ? 'selected' : '' ?>><?= htmlspecialchars($lbl) ?></option><?php endforeach; ?></select></div>
                        <div><label>Parte do Online Base (%)</label><input type="number" name="serverstatus[list][<?= $i ?>][online_share]" value="<?= (float)($srv['online_share'] ?? 0) ?>" min="0" max="100" step="0.5" placeholder="Ex: 70"><small class="form-hint">Percentagem do &quot;Online Base&quot; (Configurações → Servidor) que aparece nesta sala. Ex: 70 e 30 para duas salas. Se 0 ou vazio, reparte igual.</small></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div>
                <button type="button" class="btn btn-success btn-sm" id="serverstatus-add-server"><i class="ph ph-plus"></i> Adicionar Servidor</button>
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" class="btn btn-primary btn-sm"><i class="ph ph-floppy-disk"></i> Salvar Configurações</button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    const container = document.getElementById('serverstatus-servers-container');
    if (!container) return;
    const serverIconsOptions = `<option value="">Padrão (automático)</option><option value="fire">Fogo</option><option value="sword">Espada</option><option value="shield">Escudo</option><option value="crown">Coroa</option><option value="trophy">Troféu</option><option value="game-controller">Controle / Jogo</option><option value="lightning">Raio</option><option value="star">Estrela</option><option value="skull">Caveira</option><option value="flag">Bandeira</option><option value="gem">Diamante</option><option value="book-open-text">Livro / Clássico</option><option value="crosshair">Mira</option><option value="planet">Planeta</option><option value="sword-cross">Espadas cruzadas</option><option value="shield-checkered">Escudo xadrez</option>`;
    function reindex() {
        container.querySelectorAll('.server-item').forEach((item, idx) => {
            item.querySelectorAll('input[name], select[name]').forEach(el => {
                el.name = el.name.replace(/serverstatus\\[list\\]\\[\\d+\\]/g, 'serverstatus[list][' + idx + ']');
            });
        });
    }
    document.getElementById('serverstatus-add-server')?.addEventListener('click', function() {
        const idx = container.querySelectorAll('.server-item').length;
        const div = document.createElement('div');
        div.className = 'form server-item space-y-1 admin-plan-card';
        div.innerHTML = `
            <div class="admin-plan-header"><strong class="sub-title">Servidor</strong><button type="button" class="btn btn-danger btn-sm remove-serverstatus-server" title="Remover"><i class="ph ph-x" aria-hidden="true"></i></button></div>
            <div><label>Nome do Servidor</label><input type="text" name="serverstatus[list][${idx}][name]" placeholder="Servidor Easy"><small class="form-hint">Nome exibido no site</small></div>
            <div><label>Nome da Sala</label><input type="text" name="serverstatus[list][${idx}][room_name]" ><small class="form-hint">Nome no banco (MEMB_STAT.ServerName)</small></div>
            <div><label>Host do Servidor</label><input type="text" name="serverstatus[list][${idx}][ip]" ><small class="form-hint">Você pode informar host e porta juntos: 127.0.0.1:55901</small></div>
            <div><label>Porta</label><input type="number" name="serverstatus[list][${idx}][port]" ></div>
            <div><label>Máximo de Players</label><input type="number" name="serverstatus[list][${idx}][max_players]"  min="1"></div>
            <div><label style="display:flex;align-items:center;gap:8px;cursor:pointer;"><input type="checkbox" name="serverstatus[list][${idx}][is_new]" value="1"><span>Marcar como "Novo"</span></label><small class="form-hint">Badge NOVO e destaque</small></div>
            <div><label>Legenda</label><input type="text" name="serverstatus[list][${idx}][legend]" ></div>
            <div><label>Ícone</label><select name="serverstatus[list][${idx}][icon]">${serverIconsOptions}</select></div>
            <div><label>Parte do Online Base (%)</label><input type="number" name="serverstatus[list][${idx}][online_share]" min="0" max="100" step="0.5" placeholder="Ex: 70"><small class="form-hint">% do Online Base que aparece nesta sala. Ex: 70 e 30. Se 0, reparte igual.</small></div>
        `;
        container.appendChild(div);
        reindex();
    });
    document.addEventListener('click', function(e) {
        if (e.target.closest?.('.remove-serverstatus-server')) {
            e.target.closest('.server-item')?.remove();
            reindex();
        }
    });
})();
</script>
