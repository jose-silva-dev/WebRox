<?= $this->layout('components/layouts/admin') ?>

<?php
// Carregar configurações de moedas (movido para o topo para estar disponível no loop PHP)
$userConfigRaw = require __DIR__ . '/../../../../../bootstrap/user.php';
$customUserConfig = config('user') ?? [];
$finalUserConfig = array_replace_recursive($userConfigRaw, $customUserConfig);
$coinsConfig = $finalUserConfig['coins'] ?? [];
?>

<div class="space-y-1">
    <div class="admin-page-header">
        <div>
            <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'VIP') ?></h1>
            <div class="admin-accent-line"></div>
        </div>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <h3 class="subtitle">Planos VIP</h3>
        <small class="form-hint" style="margin-bottom: 10px;">
            Configure os planos VIP disponíveis. Adicione nome, preço em Cash, duração em dias e benefícios de cada
            plano.
        </small>

        <form action="<?= route('admin/plugins/vip/save') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>

            <div id="plans-container" class="space-y-2">
                <?php
                $plans = $plugin['config']['plans'] ?? [];
                $planIndex = 0;
                foreach ($plans as $plan):
                    ?>
                    <div class="plan-item admin-plan-card">
                        <div class="admin-plan-header">
                            <strong class="sub-title">Plano VIP</strong>
                            <button type="button" class="btn btn-danger btn-sm remove-plan" title="Remover">
                                <i class="ph ph-x" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="admin-plan-grid">
                            <div>
                                <label>Nome do Plano</label>
                                <input type="text" name="plans[<?= $planIndex ?>][name]"
                                    value="<?= htmlspecialchars($plan['name'] ?? '') ?>"                                     required>
                            </div>

                            <div>
                                <label>Preço</label>
                                <input type="number" name="plans[<?= $planIndex ?>][price]"
                                    value="<?= (int) ($plan['price'] ?? 0) ?>"  min="0" required>
                            </div>

                            <div>
                                <label>Moeda</label>
                                <select name="plans[<?= $planIndex ?>][currency_type]" required>
                                    <?php
                                    $currentCurrency = $plan['currency_type'] ?? 'WCoinC';
                                    foreach ($coinsConfig as $coin):
                                        $selected = ($coin['title'] === $currentCurrency) ? 'selected' : '';
                                        ?>
                                        <option value="<?= $coin['title'] ?>" <?= $selected ?>>
                                            <?= $coin['title'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label>Duração (Dias)</label>
                                <input type="number" name="plans[<?= $planIndex ?>][days]"
                                    value="<?= (int) ($plan['days'] ?? 30) ?>"  min="1" required>
                            </div>

                            <div>
                                <label>Bônus Exp (%)</label>
                                <input type="number" name="plans[<?= $planIndex ?>][exp_rate]"
                                    value="<?= max(0, (int) ($plan['exp_rate'] ?? 100) - 100) ?>"  min="0" required>
                                <small class="form-hint">Ex: 20 = Exp +20% (total 120%)</small>
                            </div>

                            <div>
                                <label>Bônus Master Exp (%)</label>
                                <input type="number" name="plans[<?= $planIndex ?>][master_exp_rate]"
                                    value="<?= max(0, (int) ($plan['master_exp_rate'] ?? 100) - 100) ?>"  min="0"
                                    required>
                                <small class="form-hint">Ex: 30 = Master +30%</small>
                            </div>

                            <div>
                                <label>Bônus Drop (%)</label>
                                <input type="number" name="plans[<?= $planIndex ?>][drop_rate]"
                                    value="<?= max(0, (int) ($plan['drop_rate'] ?? 100) - 100) ?>"  min="0" required>
                                <small class="form-hint">Ex: 700 = Drop +700% (total 800%)</small>
                            </div>

                            <div>
                                <label>Tipo VIP</label>
                                <select name="plans[<?= $planIndex ?>][vip_type]" required>
                                    <?php foreach ($vipTypes as $typeIndex => $typeName): ?>
                                        <option value="<?= $typeIndex ?>" <?= ((int) ($plan['vip_type'] ?? 0) === (int) $typeIndex) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($typeName) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-hint">
                                    Tipo de VIP que será atribuído ao comprar este plano
                                </small>
                            </div>
                        </div>

                        <div class="admin-plan-actions">
                            <label>Descrição/Benefícios</label>
                            <textarea name="plans[<?= $planIndex ?>][description]" rows="3"
><?= htmlspecialchars($plan['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <?php
                    $planIndex++;
                endforeach;
                ?>
            </div>

            <button type="button" class="btn btn-secondary btn-sm" id="add-plan">
                <i class="ph ph-plus"></i> Adicionar Plano
            </button>

            <hr style="margin: 16px 0; border-color: var(--border-color);">

            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let planIndex = <?= $planIndex ?>;
    const vipTypes = <?= json_encode($vipTypes, JSON_FORCE_OBJECT) ?>;

    // Configurações de moedas dinâmicas

    const availableCoins = <?= json_encode($coinsConfig) ?>;

    function generateCurrencyOptions(selectedValue = '') {
        let options = '';
        availableCoins.forEach(coin => {
            // Usar o título como valor identificador (ex: 'WCoinC')
            const selected = (coin.title === selectedValue) ? 'selected' : '';
            options += `<option value="${coin.title}" ${selected}>${coin.title}</option>`;
        });
        return options;
    }

    function generateVipTypeOptions(selectedValue = 0) {
        let options = '';
        Object.keys(vipTypes).forEach(index => {
            const typeName = vipTypes[index];
            const selected = (parseInt(index) === parseInt(selectedValue)) ? 'selected' : '';
            options += `<option value="${index}" ${selected}>${typeName}</option>`;
        });
        return options;
    }

    document.getElementById('add-plan')?.addEventListener('click', function () {
        const container = document.getElementById('plans-container');
        if (!container) return;

        const planItem = document.createElement('div');
        planItem.className = 'plan-item admin-plan-card';

        planItem.innerHTML = `
            <div class="admin-plan-header">
                <strong class="sub-title">Plano VIP</strong>
                <button type="button" class="btn btn-danger btn-sm remove-plan" title="Remover">
                    <i class="ph ph-x" aria-hidden="true"></i>
                </button>
            </div>

            <div class="admin-plan-grid">
                <div>
                    <label>Nome do Plano</label>
                    <input type="text"
                           name="plans[${planIndex}][name]"
                           required>
                </div>

                <div>
                    <label>Preço</label>
                    <input type="number"
                           name="plans[${planIndex}][price]"
                           min="0"
                           required>
                </div>

                <div>
                    <label>Moeda</label>
                    <select name="plans[${planIndex}][currency_type]" required>
                        ${generateCurrencyOptions('WCoinC')}
                    </select>
                </div>



                <div>
                    <label>Duração (Dias)</label>
                    <input type="number"
                           name="plans[${planIndex}][days]"
                           min="1"
                           required>
                </div>

                <div>
                    <label>Bônus Exp (%)</label>
                    <input type="number"
                           name="plans[${planIndex}][exp_rate]"
                           value="0"
                           min="0"
                           required>
                </div>

                <div>
                    <label>Bônus Master Exp (%)</label>
                    <input type="number"
                           name="plans[${planIndex}][master_exp_rate]"
                           value="0"
                           min="0"
                           required>
                </div>

                <div>
                    <label>Bônus Drop (%)</label>
                    <input type="number"
                           name="plans[${planIndex}][drop_rate]"
                           value="0"
                           min="0"
                           required>
                </div>

                <div>
                    <label>Tipo VIP</label>
                    <select name="plans[${planIndex}][vip_type]" required>
                        ${generateVipTypeOptions(0)}
                    </select>
                    <small class="form-hint">
                        Tipo de VIP que será atribuído ao comprar este plano
                    </small>
                </div>
            </div>

            <div class="admin-plan-actions">
                <label>Descrição/Benefícios</label>
                <textarea name="plans[${planIndex}][description]"
                          rows="3"
></textarea>
            </div>
        `;

        container.appendChild(planItem);
        planIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-plan') || e.target.closest('.remove-plan')) {
            e.target.closest('.plan-item')?.remove();
        }
    });
</script>