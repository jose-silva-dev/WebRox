<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Notícias') ?></h1>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 class="subtitle">Gerenciar Notícias</h3>
            <a href="<?= route("admin.notice.create") ?>?from_plugin=notice" class="btn btn-primary">
                <i class="ph ph-plus"></i> Adicionar Nova Notícia
            </a>
        </div>

        <?php
        $noticeModel = new \Source\Models\Notice();
        $notices = $noticeModel->getNotices();
        ?>

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
                            <td><?= htmlspecialchars($notice->title) ?></td>
                            <td class="status">
                                <?= $notice->active_comment == 1 ? "<span class='text-success'>Ativado</span>" : "<span class='text-danger'>Desativado</span>" ?>
                            </td>
                            <td>Adicionado em: <?= resolve('Geral')->getFormatDate($notice->date) ?></td>
                            <td class="action">
                                <a href="<?= route("admin.notice.edit.{$notice->id}") ?>?from_plugin=notice" class="btn btn-warning">
                                    <i class="ph ph-pencil"></i> Editar
                                </a>
                                <a href="<?= route("admin.notice.delete.{$notice->id}") ?>?from_plugin=notice" class="btn btn-danger">
                                    <i class="ph ph-trash"></i> Deletar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="warning">Nenhuma notícia encontrada.</p>
        <?php endif; ?>
    </div>
</div>

