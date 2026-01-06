<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'VIP') ?></h1>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <h3 class="subtitle">Planos VIP</h3>
        <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
            Configure os planos VIP disponíveis. Adicione nome, preço em Cash, duração em dias e benefícios de cada plano.
        </small>

        <form action="<?= route('admin/plugins/vip/save') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            
            <div id="plans-container" class="space-y-2">
                <?php 
                $plans = $plugin['config']['plans'] ?? [];
                $planIndex = 0;
                foreach ($plans as $plan): 
                ?>
                    <div class="plan-item" style="border: 1px solid var(--neutral-300); padding: 20px; border-radius: 8px; background: var(--neutral-700);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <strong class="sub-title">Plano VIP</strong>
                            <button type="button" class="btn btn-danger btn-sm remove-plan">
                                <i class="ph ph-trash"></i> Remover
                            </button>
                        </div>

                        <div class="grid-2 space-y-1">
                            <div>
                                <label>Nome do Plano</label>
                                <input type="text"
                                       name="plans[<?= $planIndex ?>][name]"
                                       value="<?= htmlspecialchars($plan['name'] ?? '') ?>"
                                       placeholder="Plano Premium">
                            </div>

                            <div>
                                <label>Preço (Cash)</label>
                                <input type="number"
                                       name="plans[<?= $planIndex ?>][price]"
                                       value="<?= (int)($plan['price'] ?? 0) ?>"
                                       placeholder="1000"
                                       min="0">
                            </div>

                            <div>
                                <label>Duração (Dias)</label>
                                <input type="number"
                                       name="plans[<?= $planIndex ?>][days]"
                                       value="<?= (int)($plan['days'] ?? 30) ?>"
                                       placeholder="30"
                                       min="1">
                            </div>

                            <div>
                                <label>Experiência (%)</label>
                                <input type="number"
                                       name="plans[<?= $planIndex ?>][exp_rate]"
                                       value="<?= (int)($plan['exp_rate'] ?? 100) ?>"
                                       placeholder="115"
                                       min="0">
                            </div>

                            <div>
                                <label>Master Exp (%)</label>
                                <input type="number"
                                       name="plans[<?= $planIndex ?>][master_exp_rate]"
                                       value="<?= (int)($plan['master_exp_rate'] ?? 100) ?>"
                                       placeholder="130"
                                       min="0">
                            </div>

                            <div>
                                <label>Drop Rate (%)</label>
                                <input type="number"
                                       name="plans[<?= $planIndex ?>][drop_rate]"
                                       value="<?= (int)($plan['drop_rate'] ?? 100) ?>"
                                       placeholder="150"
                                       min="0">
                            </div>

                            <div>
                                <label>Tipo VIP</label>
                                <select name="plans[<?= $planIndex ?>][vip_type]">
                                    <?php foreach ($vipTypes as $typeIndex => $typeName): ?>
                                        <option value="<?= $typeIndex ?>"
                                            <?= ((int)($plan['vip_type'] ?? 0) === (int)$typeIndex) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($typeName) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Tipo de VIP que será atribuído ao comprar este plano
                                </small>
                            </div>
                        </div>

                        <div style="margin-top: 15px;">
                            <label>Descrição/Benefícios</label>
                            <textarea name="plans[<?= $planIndex ?>][description]"
                                      rows="3"
                                      placeholder="Descreva os benefícios deste plano..."><?= htmlspecialchars($plan['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                <?php 
                    $planIndex++;
                endforeach; 
                ?>
            </div>

            <button type="button" class="btn btn-secondary" id="add-plan">
                <i class="ph ph-plus"></i> Adicionar Plano
            </button>

            <hr style="margin: 30px 0; border-color: var(--neutral-300);">

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let planIndex = <?= $planIndex ?>;
    const vipTypes = <?= json_encode($vipTypes, JSON_FORCE_OBJECT) ?>;
    
    function generateVipTypeOptions(selectedValue = 0) {
        let options = '';
        Object.keys(vipTypes).forEach(index => {
            const typeName = vipTypes[index];
            const selected = (parseInt(index) === parseInt(selectedValue)) ? 'selected' : '';
            options += `<option value="${index}" ${selected}>${typeName}</option>`;
        });
        return options;
    }

    document.getElementById('add-plan')?.addEventListener('click', function() {
        const container = document.getElementById('plans-container');
        if (!container) return;

        const planItem = document.createElement('div');
        planItem.className = 'plan-item';
        planItem.style.cssText = 'border: 1px solid var(--neutral-300); padding: 20px; border-radius: 8px; background: var(--neutral-700); margin-bottom: 15px;';

        planItem.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <strong class="sub-title">Plano VIP</strong>
                <button type="button" class="btn btn-danger btn-sm remove-plan">
                    <i class="ph ph-trash"></i> Remover
                </button>
            </div>

            <div class="grid-2 space-y-1">
                <div>
                    <label>Nome do Plano</label>
                    <input type="text"
                           name="plans[${planIndex}][name]"
                           placeholder="Plano Premium">
                </div>

                <div>
                    <label>Preço (Cash)</label>
                    <input type="number"
                           name="plans[${planIndex}][price]"
                           placeholder="1000"
                           min="0">
                </div>

                <div>
                    <label>Duração (Dias)</label>
                    <input type="number"
                           name="plans[${planIndex}][days]"
                           placeholder="30"
                           min="1">
                </div>

                <div>
                    <label>Experiência (%)</label>
                    <input type="number"
                           name="plans[${planIndex}][exp_rate]"
                           placeholder="115"
                           min="0">
                </div>

                <div>
                    <label>Master Exp (%)</label>
                    <input type="number"
                           name="plans[${planIndex}][master_exp_rate]"
                           placeholder="130"
                           min="0">
                </div>

                <div>
                    <label>Drop Rate (%)</label>
                    <input type="number"
                           name="plans[${planIndex}][drop_rate]"
                           placeholder="150"
                           min="0">
                </div>

                <div>
                    <label>Tipo VIP</label>
                    <select name="plans[${planIndex}][vip_type]">
                        ${generateVipTypeOptions(0)}
                    </select>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Tipo de VIP que será atribuído ao comprar este plano
                    </small>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <label>Descrição/Benefícios</label>
                <textarea name="plans[${planIndex}][description]"
                          rows="3"
                          placeholder="Descreva os benefícios deste plano..."></textarea>
            </div>
        `;

        container.appendChild(planItem);
        planIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-plan') || e.target.closest('.remove-plan')) {
            e.target.closest('.plan-item')?.remove();
        }
    });
</script>

