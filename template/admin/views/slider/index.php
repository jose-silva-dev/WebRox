<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Sliders</h1>
    <div class="sliders">
        <?php if ($sliders): ?>
            <?php foreach ($sliders as $slider): ?>
                <div class="slider space-y-1">
                    <img src="<?= public_path("images/slider/{$slider->image}") ?>" alt="Sliders">
                    <h2><?= $slider->title ?></h2>
                    <a href="<?= route("admin.slider.delete.{$slider->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="warning">Nenhum slider encontrado</p>
        <?php endif; ?>
    </div>

    <hr>

    <form action="<?= route("admin.slider.store") ?>" method="post" class="form space-y-2" enctype="multipart/form-data">
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title" >
        </div>
        <div>
            <label for="link">Link (opcional)</label>
            <input type="url" name="link" id="link" >
            <small style="color: var(--neutral-50); font-size: 12px;">Deixe em branco se não quiser que o slide seja clicável</small>
        </div>
        <div>
            <label for="image">Imagem</label>
            <input type="file" name="image" id="image" required>
            <small class="form-hint">Tamanho padrão recomendado: 823 × 500 px.</small>
        </div>
        <div>
            <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Adicionar</button>
        </div>
    </form>

    <hr>

    <div class="space-y-1">
        <h2 class="title">Configurações do Slider</h2>
        <form action="<?= route("admin.settings.update") ?>" method="post" class="form space-y-2">
            <?= csrf_field() ?>
            <input type="hidden" name="return_url" value="<?= route("admin/slider") ?>">
            <div class="checkbox">
                <input type="checkbox" name="slider[autoplay][enabled]" id="slider-autoplay-enabled" <?= config('slider.autoplay.enabled', true) ? 'checked' : '' ?>>
                <label for="slider-autoplay-enabled">Ativar autoplay (passar automaticamente)</label>
            </div>
            <div>
                <label for="slider-autoplay-delay">Intervalo entre slides (milissegundos)</label>
                <input type="number" name="slider[autoplay][delay]" id="slider-autoplay-delay" value="<?= config('slider.autoplay.delay', 5000) ?>" min="1000" step="500" >
                <small style="color: var(--neutral-50); font-size: 12px;">Padrão: 5000ms (5 segundos)</small>
            </div>
            <div>
                <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Salvar Configurações</button>
            </div>
        </form>
    </div>
</div>