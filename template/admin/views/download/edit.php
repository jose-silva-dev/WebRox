<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Editar Download</h1>

    <a href="<?= route("admin.download") ?>" class="btn btn-primary"><i class="ph ph-list"></i> Todos os downloads</a>

    <form action="<?= route("admin.download.update.{$download->id}") ?>" method="post" class="form space-y-2" id="download-edit-form">
        <?= csrf_field() ?>
        <div>
            <label for="category">Categoria</label>
            <select name="category" id="category" required>
                <option value="main" selected>Download (principal)</option>
                <option value="additional">Download adicional</option>
            </select>
        </div>
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($download->title ?? '') ?>"  required>
        </div>

        <div>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" value="<?= htmlspecialchars($download->description ?? '') ?>"  required>
        </div>

        <div>
            <label for="link">URL para Download</label>
            <input type="url" name="link" id="link" value="<?= htmlspecialchars($download->link ?? '') ?>"  required>
        </div>

        <div>
            <label for="icon">Ícone</label>
            <select name="icon" id="icon">
                <option value="">— Escolher ícone —</option>
                <?php if (!empty($icons)): foreach ($icons as $iconValue => $iconLabel): ?>
                    <option value="<?= htmlspecialchars($iconValue) ?>" <?= (isset($download->icon) && (string)$download->icon === $iconValue) ? 'selected' : '' ?>><?= htmlspecialchars($iconLabel) ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>

        <div id="size-wrap">
            <label for="size">Tamanho</label>
            <input type="text" name="size" id="size" value="<?= htmlspecialchars($download->size ?? '') ?>" >
        </div>

        <div>
            <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Atualizar</button>
        </div>
    </form>
</div>
<script>
(function() {
    var category = document.getElementById('category');
    var sizeWrap = document.getElementById('size-wrap');
    var sizeInput = document.getElementById('size');
    function toggleSize() {
        var isMain = category.value === 'main';
        sizeWrap.style.display = isMain ? 'block' : 'none';
        sizeInput.required = isMain;
        if (!isMain) sizeInput.value = '';
    }
    category.addEventListener('change', toggleSize);
    toggleSize();
})();
</script>