<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div class="admin-page-header">
        <div>
            <h1 class="title">Gerenciar Plugin:
                <?= htmlspecialchars($plugin['name'] ?? 'Donate') ?>
            </h1>
            <div class="admin-accent-line"></div>
        </div>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <h3 class="subtitle">Pacotes de Doação</h3>
        <small class="form-hint" style="margin-bottom: 10px;">
            Configure os pacotes disponíveis. Adicione imagem, nome, quantidade de moedas, bônus e valor.
        </small>

        <form action="<?= route('admin/plugins/donate/save') ?>" method="post" enctype="multipart/form-data"
            class="space-y-2">
            <?= csrf_field() ?>

            <div id="plans-container" class="space-y-2">
                <?php
                $plans = $plugin['config']['plans'] ?? [];
                $planIndex = 0;
                $allCoins = userConfig('coins') ?? [];
                foreach ($plans as $plan):
                    ?>
                    <div class="plan-item admin-plan-card">
                        <div class="admin-plan-header">
                            <strong class="sub-title">Pacote #
                                <?= ($planIndex + 1) ?>
                            </strong>
                            <button type="button" class="btn btn-danger btn-sm remove-plan" title="Remover">
                                <i class="ph ph-x" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="admin-plan-grid">
                            <div>
                                <label>Nome do Pacote</label>
                                <input type="text" name="plans[<?= $planIndex ?>][name]"
                                    value="<?= htmlspecialchars($plan['name'] ?? '') ?>"                                     required>
                            </div>

                            <div>
                                <label>Categoria</label>
                                <input type="text" name="plans[<?= $planIndex ?>][category]"
                                    value="<?= htmlspecialchars($plan['category'] ?? '') ?>"                                     required>
                            </div>

                            <div>
                                <label>Valor (R$)</label>
                                <small class="form-hint" style="display: block;">Use 0 para pacote grátis (resgate com um clique na página de doação).</small>
                                <input type="number" name="plans[<?= $planIndex ?>][price]"
                                    value="<?= (float) ($plan['price'] ?? 0) ?>"  step="0.01" min="0"
                                    required>
                            </div>

                            <div>
                                <label>Moeda Principal</label>
                                <select name="plans[<?= $planIndex ?>][main_coin]" required>
                                    <?php foreach ($allCoins as $coin): ?>
                                        <option value="<?= $coin['title'] ?>" <?= ($plan['main_coin'] ?? '') === $coin['title'] ? 'selected' : '' ?>>
                                            <?= $coin['title'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label>Quantidade da Moeda</label>
                                <input type="number" name="plans[<?= $planIndex ?>][coin_amount]"
                                    value="<?= (int) ($plan['coin_amount'] ?? 0) ?>"  min="1" required>
                            </div>

                            <div>
                                <label>Bônus (%)</label>
                                <input type="number" name="plans[<?= $planIndex ?>][bonus_percent]"
                                    value="<?= (int) ($plan['bonus_percent'] ?? 0) ?>"  min="0" required>
                            </div>

                            <div>
                                <label>Imagem do Produto</label>
                                <input type="file" name="plan_images[<?= $planIndex ?>]" accept="image/*">
                                <?php if (!empty($plan['image'])): ?>
                                    <div style="margin-top: 5px;">
                                        <img src="<?= public_path('images/donate/' . basename(trim($plan['image']))) ?>" alt="Preview"
                                            style="max-height: 50px; border-radius: 4px;">
                                        <input type="hidden" name="plans[<?= $planIndex ?>][image]"
                                            value="<?= $plan['image'] ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="admin-plan-actions">
                            <label>Moedas Extras (Bônus Adicional)</label>
                            <div class="grid-3" style="margin-top: 10px;">
                                <?php foreach ($allCoins as $coin): ?>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <input type="checkbox"
                                            name="plans[<?= $planIndex ?>][bonus_coins_list][<?= $coin['title'] ?>][enabled]"
                                            value="1" <?= isset($plan['bonus_coins'][$coin['title']]) ? 'checked' : '' ?>>
                                        <label style="margin: 0;">
                                            <?= $coin['title'] ?>
                                        </label>
                                        <input type="number"
                                            name="plans[<?= $planIndex ?>][bonus_coins_list][<?= $coin['title'] ?>][value]"
                                            value="<?= $plan['bonus_coins'][$coin['title']] ?? 0 ?>" style="width: 80px;"
>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $planIndex++;
                endforeach;
                ?>
            </div>

            <button type="button" class="btn btn-secondary btn-sm" id="add-plan" style="margin-top: 10px;">
                <i class="ph ph-plus"></i> Adicionar Pacote
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
    const allCoins = <?= json_encode($allCoins) ?>;

    document.getElementById('add-plan')?.addEventListener('click', function () {
        const container = document.getElementById('plans-container');
        if (!container) return;

        const planItem = document.createElement('div');
        planItem.className = 'plan-item admin-plan-card';

        let coinOptions = '';
        allCoins.forEach(coin => {
            coinOptions += `<option value="${coin.title}">${coin.title}</option>`;
        });

        let bonusCoinsHtml = '';
        allCoins.forEach(coin => {
            bonusCoinsHtml += `
                <div style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="plans[${planIndex}][bonus_coins_list][${coin.title}][enabled]" value="1">
                    <label style="margin: 0;">${coin.title}</label>
                    <input type="number" name="plans[${planIndex}][bonus_coins_list][${coin.title}][value]" value="0" style="width: 80px;" >
                </div>
            `;
        });

        planItem.innerHTML = `
            <div class="admin-plan-header">
                <strong class="sub-title">Novo Pacote</strong>
                <button type="button" class="btn btn-danger btn-sm remove-plan" title="Remover">
                    <i class="ph ph-x" aria-hidden="true"></i>
                </button>
            </div>

            <div class="admin-plan-grid">
                <div>
                    <label>Nome do Pacote</label>
                    <input type="text" name="plans[${planIndex}][name]"  required>
                </div>

                <div>
                    <label>Categoria</label>
                    <input type="text" name="plans[${planIndex}][category]"  required>
                </div>

                <div>
                    <label>Valor (R$)</label>
                    <input type="number" name="plans[${planIndex}][price]"  step="0.01" min="0" required>
                </div>

                <div>
                    <label>Moeda Principal</label>
                    <select name="plans[${planIndex}][main_coin]" required>
                        ${coinOptions}
                    </select>
                </div>

                <div>
                    <label>Quantidade da Moeda</label>
                    <input type="number" name="plans[${planIndex}][coin_amount]"  min="1" required>
                </div>

                <div>
                    <label>Bônus (%)</label>
                    <input type="number" name="plans[${planIndex}][bonus_percent]" value="0"  min="0" required>
                </div>

                <div>
                    <label>Imagem do Produto</label>
                    <input type="file" name="plan_images[${planIndex}]" accept="image/*">
                </div>
            </div>

            <div class="admin-plan-actions">
                <label>Moedas Extras (Bônus Adicional)</label>
                <div class="grid-3" style="margin-top: 10px;">
                    ${bonusCoinsHtml}
                </div>
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