<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Downloads Adicionais</h1>

    <a href="<?= route("admin.additional-download.create") ?>" class="btn btn-primary"><i class="ph ph-plus"></i> Adicionar novo Download Adicional</a>

    <?php if ($additionalDownloads): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>URL para Download</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($additionalDownloads as $additionalDownload): ?>
                    <tr class="additional-download space-y-1">
                        <td><?= $additionalDownload->title ?></td>
                        <td><?= $additionalDownload->description ?></td>
                        <td><a href="<?= $additionalDownload->link ?>" target="_blank" class="btn btn-primary"><i class="ph ph-download"></i> Baixar</a></td>
                        <td class="action">
                            <a href="<?= route("admin.additional-download.edit.{$additionalDownload->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Editar</a>
                            <a href="<?= route("admin.additional-download.delete.{$additionalDownload->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="warning">Nenhum download adicional encontrado.</p>
    <?php endif; ?>
</div>






