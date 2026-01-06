<?= $this->layout('components/layouts/admin') ?>
<div class="space-y-1">
    <h1 class="title">Adicionar Download</h1>

    <a href="<?= route("admin.download") ?>" class="btn btn-primary"><i class="ph ph-list"></i> Todos os downloads</a>

    <form action="<?= route("admin.download.store") ?>" method="post" class="form space-y-2">
        <?= csrf_field() ?>
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title" placeholder="Digite o título do download" required>
        </div>

        <div>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" placeholder="Digite a descrição do download" required>
        </div>

        <div>
            <label for="link">URL para Download</label>
            <input type="url" name="link" id="link" placeholder="Digite o link do download" required>
        </div>

        <div>
            <label for="size">Tamanho</label>
            <input type="text" name="size" id="size" placeholder="Digite o tamanho do download" required>
        </div>

        <div>
            <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Adicionar</button>
        </div>
    </form>
</div>