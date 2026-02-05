<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div class="admin-page-header">
        <div>
            <h1 class="title">Plugins</h1>
            <div class="admin-accent-line"></div>
        </div>
    </div>

    <div class="form">
        <h3 class="subtitle">Instalar novo plugin</h3>
        <small class="form-hint">Selecione um arquivo .zip contendo o código e o arquivo <code>plugin.php</code>.</small>
        <form action="<?= route('admin/plugins/upload') ?>" method="post" enctype="multipart/form-data"
            class="form-inline" style="display: flex; gap: 8px; align-items: center; margin-top: 8px;">
            <?= csrf_field() ?>
            <input type="file" name="plugin" accept=".zip" required class="input" style="padding: 6px;">
            <button type="submit" class="btn btn-warning btn-sm">
                <i class="ph ph-upload"></i> Enviar
            </button>
        </form>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Plugin</th>
                    <th>Descrição</th>
                    <th>Versão</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($plugins)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            <div class="warning">
                                Nenhum plugin encontrado
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($plugins as $key => $plugin): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($plugin['name'] ?? $key) ?></strong>
                            </td>
                            <td>
                                <?= htmlspecialchars($plugin['description'] ?? 'Sem descrição') ?>
                            </td>
                            <td>
                                <span class="badge badge-orange">
                                    <?= htmlspecialchars($plugin['version'] ?? '1.0.0') ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $pluginType = strtoupper($plugin['type'] ?? 'FREE');
                                if ($pluginType === 'PREMIUM'):
                                    ?>
                                    <span class="badge"
                                        style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: var(--neutral-900);">
                                        PREMIUM
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-success">
                                        FREE
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($plugin['enabled'] ?? false): ?>
                                    <span class="badge badge-success">
                                        Ativado
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">
                                        Desativado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <?php if ($plugin['enabled'] ?? false): ?>
                                        <form action="<?= route('admin/plugins/toggle') ?>" method="post" class="inline-form">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="plugin" value="<?= htmlspecialchars($key) ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="ph ph-x"></i> Desativar
                                            </button>
                                        </form>
                                        <form action="<?= route("admin/plugins/manage") ?>" method="get" class="inline-form"
                                            data-ajax="false">
                                            <input type="hidden" name="plugin" value="<?= htmlspecialchars($key) ?>">
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                <i class="ph ph-gear"></i> Gerenciar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?= route('admin/plugins/toggle') ?>" method="post" class="inline-form">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="plugin" value="<?= htmlspecialchars($key) ?>">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="ph ph-check"></i> Ativar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>