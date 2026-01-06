<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Castle Siege') ?></h1>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <form id="castlesiege-form" action="<?= route('admin/plugins/castlesiege/save') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            
            <!-- Configuração Geral -->
            <div class="form space-y-1" style="background: var(--background-card); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--neutral-300); margin-bottom: 2rem;">
                <h3 class="subtitle" style="margin-bottom: 1rem;">Configuração Geral</h3>
                
                <div>
                    <label for="castlesiege-title">Título</label>
                    <input type="text" 
                           name="castlesiege[title]" 
                           id="castlesiege-title"
                           value="<?= htmlspecialchars($plugin['config']['title'] ?? 'Castle Siege') ?>"
                           placeholder="Castle Siege">
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Título principal exibido no card do Castle Siege
                    </small>
                </div>

                <div>
                    <label for="castlesiege-subtitle">Subtítulo</label>
                    <input type="text" 
                           name="castlesiege[subtitle]" 
                           id="castlesiege-subtitle"
                           value="<?= htmlspecialchars($plugin['config']['subtitle'] ?? 'Apenas uma guild reinará sobre o castelo') ?>"
                           placeholder="Apenas uma guild reinará sobre o castelo">
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Subtítulo descritivo exibido abaixo do título
                    </small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

