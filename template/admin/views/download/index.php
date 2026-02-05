<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Downloads</h1>

    <a href="<?= route("admin.download.create") ?>" class="btn btn-primary"><i class="ph ph-plus"></i> Adicionar novo</a>

    <?php $hasAny = ($downloads && count($downloads) > 0) || ($additionalDownloads && count($additionalDownloads) > 0); ?>
    <?php if ($hasAny): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>URL para Download</th>
                    <th>Tamanho</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($downloads): ?>
                    <?php foreach ($downloads as $download): ?>
                        <tr>
                            <td>Download</td>
                            <td><?= htmlspecialchars($download->title ?? '') ?></td>
                            <td><?= htmlspecialchars($download->description ?? '') ?></td>
                            <td><a href="<?= htmlspecialchars($download->link ?? '#') ?>" target="_blank" class="btn btn-primary"><i class="ph ph-download"></i> Baixar</a></td>
                            <td><?= htmlspecialchars($download->size ?? '-') ?></td>
                            <td class="action">
                                <a href="<?= route("admin.download.edit.{$download->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Editar</a>
                                <a href="<?= route("admin.download.delete.{$download->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($additionalDownloads): ?>
                    <?php foreach ($additionalDownloads as $additionalDownload): ?>
                        <tr>
                            <td>Download adicional</td>
                            <td><?= htmlspecialchars($additionalDownload->title ?? '') ?></td>
                            <td><?= htmlspecialchars($additionalDownload->description ?? '') ?></td>
                            <td><a href="<?= htmlspecialchars($additionalDownload->link ?? '#') ?>" target="_blank" class="btn btn-primary"><i class="ph ph-download"></i> Baixar</a></td>
                            <td>—</td>
                            <td class="action">
                                <a href="<?= route("admin.additional-download.edit.{$additionalDownload->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Editar</a>
                                <a href="<?= route("admin.additional-download.delete.{$additionalDownload->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="warning">Nenhum download encontrado. Adicione um novo escolhendo a categoria (Download ou Download adicional).</p>
    <?php endif; ?>
</div>
