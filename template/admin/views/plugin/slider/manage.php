<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Slider') ?></h1>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <h3 class="subtitle" style="margin-bottom: 1rem;">Gerenciar Sliders</h3>
        
        <div class="sliders" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <?php
            $sliderModel = new \Source\Models\Slider();
            $sliders = $sliderModel->getSliders();
            ?>
            <?php if ($sliders): ?>
                <?php foreach ($sliders as $slider): ?>
                    <div class="slider space-y-1" style="background: var(--background-card); padding: 1rem; border-radius: 8px; border: 1px solid var(--neutral-300);">
                        <img src="<?= public_path("images/slider/{$slider->image}") ?>" alt="Slider" style="width: 100%; height: auto; border-radius: 8px; margin-bottom: 0.5rem;">
                        <h2 style="font-size: 14px; margin-bottom: 0.5rem;"><?= htmlspecialchars($slider->title ?? 'Sem título') ?></h2>
                        <?php if (!empty($slider->link)): ?>
                            <p style="font-size: 12px; color: var(--neutral-50); margin-bottom: 0.5rem;">
                                <a href="<?= htmlspecialchars($slider->link) ?>" target="_blank" style="color: var(--red-100);"><?= htmlspecialchars($slider->link) ?></a>
                            </p>
                        <?php endif; ?>
                        <a href="<?= route("admin.slider.delete.{$slider->id}") ?>" class="btn btn-danger" style="width: 100%;">
                            <i class="ph ph-trash"></i> Deletar
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="warning" style="grid-column: 1 / -1;">Nenhum slider encontrado</p>
            <?php endif; ?>
        </div>

        <hr style="margin: 2rem 0; border-color: var(--neutral-300);">

        <h3 class="subtitle" style="margin-bottom: 1rem;">Adicionar Novo Slider</h3>
        <form action="<?= route("admin.slider.store") ?>" method="post" class="form space-y-2" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="return_url" value="<?= route("admin/plugins/manage?plugin=slider") ?>">
            <div>
                <label for="title">Título</label>
                <input type="text" name="title" id="title" placeholder="Digite o título do slider">
            </div>
            <div>
                <label for="link">Link (opcional)</label>
                <input type="url" name="link" id="link" placeholder="https://exemplo.com">
                <small style="color: var(--neutral-50); font-size: 12px;">Deixe em branco se não quiser que o slide seja clicável</small>
            </div>
            <div>
                <label for="image">Imagem</label>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" required>
                <small style="color: var(--neutral-50); font-size: 12px;">Formatos aceitos: JPEG, PNG, GIF</small>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-plus"></i> Adicionar Slider
                </button>
            </div>
        </form>

        <hr style="margin: 2rem 0; border-color: var(--neutral-300);">

        <h3 class="subtitle" style="margin-bottom: 1rem;">Configurações do Slider</h3>
        <form action="<?= route("admin.settings.update") ?>" method="post" class="form space-y-2">
            <?= csrf_field() ?>
            <input type="hidden" name="return_url" value="<?= route("admin/plugins/manage?plugin=slider") ?>">
            <div class="checkbox">
                <input type="checkbox" name="slider[autoplay][enabled]" id="slider-autoplay-enabled" <?= config('slider.autoplay.enabled', true) ? 'checked' : '' ?>>
                <label for="slider-autoplay-enabled">Ativar autoplay (passar automaticamente)</label>
            </div>
            <div>
                <label for="slider-autoplay-delay">Intervalo entre slides (milissegundos)</label>
                <input type="number" name="slider[autoplay][delay]" id="slider-autoplay-delay" value="<?= config('slider.autoplay.delay', 5000) ?>" min="1000" step="500" placeholder="5000">
                <small style="color: var(--neutral-50); font-size: 12px;">Padrão: 5000ms (5 segundos)</small>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

