<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Sliders</h1>
    <div class="sliders">
        <?php if ($sliders): ?>
            <?php foreach ($sliders as $slider): ?>
                <div class="slider space-y-1">
                    <img src="<?= public_path("images/slider/{$slider->image}") ?>" alt="Sliders">
                    <h2><?= $slider->title ?></h2>
                    <a href="<?= route("admin.slider.delete.{$slider->id}") ?>" class="btn btn-danger"><i class="ph ph-trash"></i> Deletar</a>
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
            <input type="text" name="title" id="title" placeholder="Digite o título do slider">
        </div>
        <div>
            <label for="image">Imagem</label>
            <input type="file" name="image" id="image" required>
        </div>
        <div>
            <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Adicionar</button>
        </div>
    </form>
</div>