<h3 class="subtitle">Coin</h3>
<h4 class="subtitle">Coins</h4>
<small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
    Configure as moedas/coins disponíveis no servidor e suas tabelas no banco de dados
</small>
<div id="coins-container" class="space-y-1">
    <?php foreach (($user['coins'] ?? []) as $i => $coin): ?>
        <div class="form coin-item space-y-1">
            <div style="display:flex; justify-content:space-between; align-items:center">
                <strong class="sub-title coin-title-<?= $i ?>"><?= htmlspecialchars($coin['title'] ?? 'Coin') ?></strong>
                <button type="button" class="btn btn-danger btn-sm remove-coin" title="Remover"><i class="ph ph-x" aria-hidden="true"></i></button>
            </div>
            <div>
                <label>Título</label>
                <input type="text" name="user[coins][<?= $i ?>][title]" value="<?= htmlspecialchars($coin['title']) ?>" class="coin-title-input" data-coin-index="<?= $i ?>"  required>
                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome da moeda exibido no site</small>
            </div>
            <div>
                <label>Tabela</label>
                <input type="text" name="user[coins][<?= $i ?>][table]" value="<?= htmlspecialchars($coin['table']) ?>"  required>
                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome da tabela no banco de dados onde a moeda está armazenada</small>
            </div>
            <div>
                <label>Coluna Conta</label>
                <input type="text" name="user[coins][<?= $i ?>][column_account]" value="<?= htmlspecialchars($coin['column_account']) ?>"  required>
                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome da coluna que identifica a conta (ex: AccountID, memb___id)</small>
            </div>
            <div>
                <label>Coluna Coin</label>
                <input type="text" name="user[coins][<?= $i ?>][column_coin]" value="<?= htmlspecialchars($coin['column_coin']) ?>"  required>
                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome da coluna que armazena o valor da moeda</small>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div>
    <button type="button" class="btn btn-success" id="add-coin"><i class="ph ph-plus"></i> Adicionar Coin</button>
</div>

<script>window.COIN_INDEX = <?= count($user['coins'] ?? []) ?>;</script>
