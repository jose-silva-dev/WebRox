<?= $this->layout('components/layouts/admin') ?>

<div class="adm-page">
    <header class="adm-page__header">
        <div>
            <h1 class="adm-page__title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Slider') ?></h1>
            <div class="admin-accent-line"></div>
        </div>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </header>

    <div class="form">
        <h3 class="adm-section__title">Gerenciar Sliders</h3>

        <div class="adm-slider-grid">
            <?php
            $sliderModel = new \Source\Models\Slider();
            $sliders = $sliderModel->getSliders();
            ?>
            <?php if ($sliders): ?>
                <?php foreach ($sliders as $slider): ?>
                    <div class="adm-slider-card">
                        <img src="<?= public_path("images/slider/{$slider->image}") ?>" alt="Slider" class="adm-slider-card__img">
                        <h2 class="adm-slider-card__title"><?= htmlspecialchars($slider->title ?? 'Sem título') ?></h2>
                        <?php if (!empty($slider->link)): ?>
                            <p class="adm-slider-card__link">
                                <a href="<?= htmlspecialchars($slider->link) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($slider->link) ?></a>
                            </p>
                        <?php endif; ?>
                        <a href="<?= route("admin.slider.delete.{$slider->id}") ?>" class="btn btn-danger btn-sm adm-slider-card__btn" title="Deletar">
                            <i class="ph ph-x" aria-hidden="true"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="adm-note" style="grid-column: 1 / -1;">Nenhum slider encontrado</p>
            <?php endif; ?>
        </div>

        <hr class="adm-divider">

        <h3 class="adm-section__title">Adicionar Novo Slider</h3>
        <form action="<?= route("admin.slider.store") ?>" method="post" class="form space-y-2" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div>
                <label for="title">Título</label>
                <input type="text" name="title" id="title" >
            </div>
            <div>
                <label for="link">Link (opcional)</label>
                <input type="url" name="link" id="link" >
                <small class="form-hint">Deixe em branco se não quiser que o slide seja clicável</small>
            </div>
            <div>
                <label for="image">Imagem</label>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" required>
                <small class="form-hint">Tamanho padrão recomendado: 823 × 500 px. Formatos: JPEG, PNG, GIF.</small>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ph ph-plus"></i> Adicionar Slider
                </button>
            </div>
        </form>

        <hr class="adm-divider">

        <h3 class="adm-section__title">Configurações do Slider</h3>
        <form action="<?= route("admin.settings.update") ?>" method="post" class="form space-y-2">
            <?= csrf_field() ?>
            <input type="hidden" name="return_url" value="<?= route("admin/plugins/manage?plugin=slider") ?>">
            <div class="checkbox">
                <input type="checkbox" name="slider[autoplay][enabled]" id="slider-autoplay-enabled" <?= config('slider.autoplay.enabled', true) ? 'checked' : '' ?>>
                <label for="slider-autoplay-enabled">Ativar autoplay (passar automaticamente)</label>
            </div>
            <div>
                <label for="slider-autoplay-delay">Intervalo entre slides (milissegundos)</label>
                <input type="number" name="slider[autoplay][delay]" id="slider-autoplay-delay" value="<?= config('slider.autoplay.delay', 5000) ?>" min="1000" step="500" >
                <small class="form-hint">Padrão: 5000ms (5 segundos)</small>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>



