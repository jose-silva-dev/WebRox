<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Downloads</h1>

    <a href="<?= route("admin.download.create") ?>" class="btn btn-primary"><i class="ph ph-plus"></i> Adicionar novo Download</a>
    <a href="<?= route("admin.additional-download") ?>" class="btn btn-primary"><i class="ph ph-plus"></i> Gerenciar Downloads Adicionais</a>

    <?php if ($downloads): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>URL para Download</th>
                    <th>Tamanho</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($downloads as $download): ?>
                    <tr class="download space-y-1">
                        <td><?= $download->title ?></td>
                        <td><?= $download->description ?></td>
                        <td><a href="<?= $download->link ?>" target="_blank" class="btn btn-primary"><i class="ph ph-download"></i> Baixar</a></td>
                        <td><?= $download->size ?></td>
                        <td class="action">
                            <a href="<?= route("admin.download.edit.{$download->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Editar</a>
                            <a href="<?= route("admin.download.delete.{$download->id}") ?>" class="btn btn-danger"><i class="ph ph-trash"></i> Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="warning">Nenhum download encontrado.</p>
    <?php endif; ?>
</div>