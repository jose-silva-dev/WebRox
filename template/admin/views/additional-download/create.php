<?= $this->layout('components/layouts/admin') ?>
<div class="space-y-1">
    <h1 class="title">Adicionar Download Adicional</h1>

    <a href="<?= route("admin.additional-download") ?>" class="btn btn-primary"><i class="ph ph-list"></i> Todos os downloads adicionais</a>

    <form action="<?= route("admin.additional-download.store") ?>" method="post" class="form space-y-2">
        <?= csrf_field() ?>
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title"  required>
        </div>

        <div>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description"  required>
        </div>

        <div>
            <label for="link">URL para Download</label>
            <input type="url" name="link" id="link"  required>
        </div>

        <div>
            <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Adicionar</button>
        </div>
    </form>
</div>






