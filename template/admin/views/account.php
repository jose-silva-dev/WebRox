<?= $this->layout('components/layouts/admin') ?>

<div class="adm-page">
    <form action="<?= route("admin.account.search") ?>" method="post" class="form">
        <?= csrf_field() ?>
        <div class="adm-inline-actions" style="align-items: flex-end;">
            <div class="adm-field" style="flex: 1; min-width: 200px;">
                <label for="account">Busca de Conta</label>
                <input type="text" name="account" id="account"  value="<?= $account ?? "" ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><i class="ph ph-magnifying-glass"></i> Buscar</button>
        </div>
    </form>
</div>

<?php if ($membInfo): ?>
    <div class="information">
        <div class="details">
            <p>Nome: <span><?= $membInfo['name'] ?></span></p>
            <p>Email: <span><?= $membInfo['email'] ?></span></p>
            <hr>
            <?php foreach ($membInfo['coins'] as $c): ?>
                <p><?= $c['title'] ?>: <span><?= $c['amount'] ?></span></p>
            <?php endforeach; ?>
            <hr>
            <p>Vip: <span><?= $membInfo['vip'] ?></span></p>
            <p>Expira em: <span><?= resolve('Geral')->getFormatDate($membInfo['expire_vip']) ?></span></p>
        </div>
        <div class="action" x-data="{ view: 'data' }">
            <div class="buttons">
                <button @click="view = 'data'">Dados</button>
                <button @click="view = 'coins'">Moedas</button>
                <button @click="view = 'vip'">Vip</button>
            </div>
            <div data-view="data" x-show="view === 'data'">
                <form action="<?= route("admin.account.update.data.$account") ?>" method="post" class="form space-y-1">
                    <?= csrf_field() ?>
                    <div class="sub-title">Atualizar Dados</div>
                    <div>
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" value="<?= $membInfo['name'] ?>" required>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $membInfo['email'] ?>" required>
                    </div>
                    <div>
                        <label for="password">Nova Senha</label>
                        <input type="password" name="password" id="password" value="">
                    </div>
                    <div>
                        <label for="status">Status da Conta</label>
                        <select name="status" id="status">
                            <option value="0" <?= $membInfo['status'] == 0 ? 'selected' : '' ?>>Ativo</option>
                            <option value="1" <?= $membInfo['status'] == 1 ? 'selected' : '' ?>>Bloqueado</option>
                            <option value="<?= config('staff_code') ?>" <?= $membInfo['status'] == 2 ? 'selected' : '' ?>>Staff
                            </option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger"> <i class="ph ph-arrows-clockwise"></i>
                            Atualizar</button>
                    </div>
                </form>
            </div>
            <div data-view="coins" x-show="view === 'coins'">
                <form action="<?= route("admin.account.update.coin.$account") ?>" method="post" class="form space-y-1">
                    <?= csrf_field() ?>
                    <div class="sub-title">Atualizar Moedas</div>
                    <div>
                        <label for="coin-select">Moeda</label>
                        <select name="coin" id="coin-select">
                            <?php foreach (resolve('User')->getConfigUser()['coins'] as $key => $c): ?>
                                <option value="<?= $key ?>"><?= $c['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="coin-action">Ação</label>
                        <select name="action" id="coin-action">
                            <option value="add">Adicionar</option>
                            <option value="remove">Remover</option>
                        </select>
                    </div>
                    <div>
                        <label for="coin-amount">Quantidade</label>
                        <input type="number" name="amount" id="coin-amount" value="0" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger"> <i class="ph ph-arrows-clockwise"></i>
                            Atualizar</button>
                    </div>
                </form>
            </div>
            <div data-view="vip" x-show="view === 'vip'">
                <form action="<?= route("admin.account.update.vip.$account") ?>" method="post" class="form space-y-1"
                    x-data="{ vipType: '<?= array_search($membInfo['vip'], resolve('User')->getConfigUser()['vip']['name']) ?>' }">
                    <?= csrf_field() ?>
                    <div class="sub-title">Atualizar Vip</div>
                    <div>
                        <label for="vip">Tipo da conta</label>
                        <select name="vip" id="vip" x-model="vipType" @change="vipType = $event.target.value">
                            <?php foreach (resolve('User')->getConfigUser()['vip']['name'] as $key => $c): ?>
                                <option value="<?= $key ?>" <?= $membInfo['vip'] == $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div x-show="vipType != '0'">
                        <label for="vip-action">Ação</label>
                        <select name="action" id="vip-action">
                            <option value="add">Adicionar</option>
                            <option value="remove">Remover</option>
                        </select>
                    </div>
                    <div x-show="vipType != '0'">
                        <label for="vip-amount">Quantidade (dias)</label>
                        <input type="number" name="amount" id="vip-amount" value="0" min="1" required
                            x-bind:disabled="vipType == '0'">
                    </div>
                    <input type="hidden" name="action" id="hidden-action" value="add">
                    <input type="hidden" name="amount" id="hidden-amount" value="0">
                    <div x-show="vipType == '0'" class="adm-note">
                        <i class="ph ph-info"></i> Ao selecionar Free, a conta será transferida para Free e a data de expiração será zerada.
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger"> <i class="ph ph-arrows-clockwise"></i>
                            Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>