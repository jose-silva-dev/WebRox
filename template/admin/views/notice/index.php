<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Notice</h1>

    <a href="<?= route("admin.notice.create") ?>" class="btn btn-primary"><i class="ph ph-plus"></i> Adicionar nova Notícia</a>

    <?php if ($notices): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Comentários</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notices as $notice): ?>
                    <tr class="notice space-y-1">
                        <td><?= $notice->title ?></td>
                        <td class="status"><?= $notice->active_comment == 1 ? "<span class='text-success'>Ativado</span>" : "<span class='text-danger'>Desativado</span>" ?></td>
                        <td>Adicionado em: <?= resolve('Geral')->getFormatDate($notice->date) ?></td>
                        <td class="action">
                            <a href="<?= route("admin.notice.edit.{$notice->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Editar</a>
                            <a href="<?= route("admin.notice.delete.{$notice->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="warning">Nenhuma notícia encontrada.</p>
    <?php endif; ?>
</div>