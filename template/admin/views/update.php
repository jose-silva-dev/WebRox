<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Sistema de Atualizações</h1>
    
    <!-- Versão Atual -->
    <div class="form" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background-color: #1a1a1a; border-left: 4px solid #2196F3; border-radius: 4px;">
            <div>
                <h3 class="subtitle" style="margin: 0; color: #2196F3;">Versão Atual</h3>
                <p style="color: #b9bbbe; margin: 5px 0 0 0; font-size: 14px;">
                    Você está usando a versão <strong style="color: #fff;"><?= htmlspecialchars($currentVersion) ?></strong>
                </p>
            </div>
            <button type="button" class="btn btn-primary" id="check-updates-btn" onclick="checkForUpdates()">
                <i class="ph ph-arrow-clockwise"></i> Verificar Atualizações
            </button>
        </div>
    </div>

    <!-- Informações de Atualização -->
    <?php if (isset($updateInfo) && $updateInfo['available']): ?>
        <div class="form" style="margin-bottom: 20px; border-left: 4px solid #4CAF50;">
            <div style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                    <div>
                        <h3 class="subtitle" style="margin: 0; color: #4CAF50;">
                            <i class="ph ph-download"></i> Atualização Disponível!
                        </h3>
                        <p style="color: #b9bbbe; margin: 10px 0;">
                            Nova versão: <strong style="color: #4CAF50;"><?= htmlspecialchars($updateInfo['latest_version']) ?></strong>
                        </p>
                        <?php if (!empty($updateInfo['release_date'])): ?>
                            <p style="color: #999; font-size: 12px; margin: 5px 0;">
                                Lançada em: <?= htmlspecialchars($updateInfo['release_date']) ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($updateInfo['critical'] ?? false): ?>
                            <p style="color: #ff6b6b; font-size: 12px; margin: 10px 0; font-weight: bold;">
                                ⚠️ Esta é uma atualização crítica de segurança!
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($updateInfo['changelog'])): ?>
                    <div style="background-color: #1a1a1a; padding: 15px; border-radius: 4px; margin-bottom: 15px;">
                        <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 14px;">Changelog:</h4>
                        <div style="color: #b9bbbe; font-size: 13px; line-height: 1.6; white-space: pre-wrap;">
                            <?= htmlspecialchars($updateInfo['changelog']) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= route('admin/update/apply') ?>" method="post" id="update-form" onsubmit="return confirmUpdate()">
                    <?= csrf_field() ?>
                    <input type="hidden" name="update_url" value="<?= htmlspecialchars($updateInfo['update_url'] ?? '') ?>">
                    <input type="hidden" name="target_version" value="<?= htmlspecialchars($updateInfo['latest_version']) ?>">
                    
                    <div style="background-color: #2a2a2a; padding: 15px; border-radius: 4px; margin-bottom: 15px; border-left: 4px solid #ffc107;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <i class="ph ph-info" style="color: #ffc107; font-size: 1.2em;"></i>
                            <strong style="color: #fff;">Importante antes de atualizar:</strong>
                        </div>
                        <ul style="list-style: disc; margin-left: 20px; color: #b9bbbe; font-size: 0.9em; line-height: 1.8;">
                            <li>Um backup automático será criado antes da atualização</li>
                            <li>O sistema pode ficar temporariamente indisponível durante a atualização</li>
                            <li>Certifique-se de ter espaço suficiente em disco</li>
                            <li>Recomendamos fazer backup manual adicional antes de continuar</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-success" id="apply-update-btn">
                        <i class="ph ph-download"></i> Aplicar Atualização
                    </button>
                </form>
            </div>
        </div>
    <?php elseif (isset($updateInfo) && !$updateInfo['available'] && empty($updateInfo['error'])): ?>
        <div class="form" style="margin-bottom: 20px; border-left: 4px solid #4CAF50;">
            <div style="padding: 20px; text-align: center;">
                <i class="ph ph-check-circle" style="font-size: 48px; color: #4CAF50; margin-bottom: 15px;"></i>
                <h3 class="subtitle" style="color: #4CAF50; margin: 0;">Sistema Atualizado</h3>
                <p style="color: #b9bbbe; margin: 10px 0;">
                    Você está usando a versão mais recente disponível.
                </p>
            </div>
        </div>
    <?php elseif (isset($updateInfo) && !empty($updateInfo['error'])): ?>
        <div class="form" style="margin-bottom: 20px; border-left: 4px solid #ff6b6b;">
            <div style="padding: 20px;">
                <h3 class="subtitle" style="color: #ff6b6b; margin: 0;">
                    <i class="ph ph-warning-circle"></i> Erro ao Verificar Atualizações
                </h3>
                <p style="color: #b9bbbe; margin: 10px 0;">
                    <?= htmlspecialchars($updateInfo['error']) ?>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Histórico de Atualizações -->
    <?php if (!empty($updateHistory)): ?>
        <div class="form" style="margin-top: 30px;">
            <h3 class="subtitle">Histórico de Atualizações</h3>
            <div style="background-color: #1a1a1a; padding: 15px; border-radius: 4px; max-height: 300px; overflow-y: auto;">
                <pre style="color: #b9bbbe; font-size: 12px; margin: 0; font-family: 'Courier New', monospace;"><?= htmlspecialchars(implode("\n", array_slice($updateHistory, -20))) ?></pre>
            </div>
        </div>
    <?php endif; ?>

    <!-- Backups -->
    <?php if (!empty($backups)): ?>
        <div class="form" style="margin-top: 30px;">
            <h3 class="subtitle">Backups Disponíveis</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Arquivo</th>
                            <th>Data</th>
                            <th>Tamanho</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($backups as $backup): ?>
                            <tr>
                                <td><code><?= htmlspecialchars($backup['filename']) ?></code></td>
                                <td><?= htmlspecialchars($backup['date']) ?></td>
                                <td><?= number_format($backup['size'] / 1024 / 1024, 2) ?> MB</td>
                                <td>
                                    <form action="<?= route('admin/update/restore-backup') ?>" method="post" style="display: inline-block;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="backup_path" value="<?= htmlspecialchars($backup['path']) ?>">
                                        <button type="submit" 
                                                class="btn btn-warning btn-sm" 
                                                onclick="return confirm('Tem certeza que deseja restaurar este backup? Esta ação não pode ser desfeita!');">
                                            <i class="ph ph-arrow-counter-clockwise"></i> Restaurar
                                        </button>
                                    </form>
                                    <a href="<?= route('admin/update/download-backup') ?>?filename=<?= urlencode($backup['filename']) ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="ph ph-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function checkForUpdates() {
    const btn = document.getElementById('check-updates-btn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="ph ph-spinner"></i> Verificando...';
    
    fetch('<?= route('admin/update/check') ?>')
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            
            if (data.available) {
                // Recarregar página para mostrar atualização disponível
                window.location.reload();
            } else if (data.error) {
                alert('Erro: ' + data.error);
            } else {
                alert('Você está usando a versão mais recente!');
                window.location.reload();
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            alert('Erro ao verificar atualizações: ' + error.message);
        });
}

function confirmUpdate() {
    return confirm(
        'Tem certeza que deseja aplicar esta atualização?\n\n' +
        'Um backup será criado automaticamente, mas recomendamos fazer um backup manual adicional.\n\n' +
        'O sistema pode ficar temporariamente indisponível durante o processo.'
    );
}

// Verificar atualizações automaticamente ao carregar a página (opcional)
// setTimeout(checkForUpdates, 2000);
</script>

