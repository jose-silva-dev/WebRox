<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">IPs Bloqueados</h1>
        <div style="display: flex; gap: 10px;">
            <?php if (!empty($blockedIps)): ?>
            <form action="<?= route('admin/blocked-ips/unblock-all') ?>" method="post" style="display: inline-block;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja desbloquear TODOS os IPs?');">
                    <i class="ph ph-trash"></i> Desbloquear Todos
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Seção de IPs Permitidos (Whitelist) -->
    <div class="form" style="margin-bottom: 30px; padding: 20px; background-color: #1a1a1a; border-left: 4px solid #4CAF50; border-radius: 4px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
            <i class="ph ph-shield-check" style="color: #4CAF50; font-size: 1.5em;"></i>
            <h3 class="subtitle" style="margin: 0;">IPs Permitidos (Whitelist)</h3>
        </div>
        <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
            IPs nesta lista têm acesso total e não podem ser bloqueados automaticamente ou manualmente. Use para adicionar IPs confiáveis (servidores, administradores, etc).
        </small>
        <form action="<?= route('admin/blocked-ips/allowed/add') ?>" method="post" class="space-y-2" style="margin-bottom: 20px;">
            <?= csrf_field() ?>
            <div class="grid-2">
                <div>
                    <label>Endereço IP</label>
                    <input type="text" 
                           name="ip" 
                           placeholder="192.168.1.1" 
                           value="<?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '') ?>"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Seu IP atual: <strong><?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'N/A') ?></strong>
                    </small>
                </div>
                <div>
                    <label>Observação (opcional)</label>
                    <input type="text" 
                           name="note" 
                           placeholder="Ex: Servidor principal, Admin, etc.">
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Descrição opcional para identificar o IP
                    </small>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-plus"></i> Adicionar IP Permitido
                </button>
            </div>
        </form>

        <?php if (!empty($allowedIps)): ?>
            <div style="margin-top: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #333; background-color: #1a1a1a;">
                            <th style="text-align: left; padding: 12px; color: #fff;">IP</th>
                            <th style="text-align: left; padding: 12px; color: #fff;">Observação</th>
                            <th style="text-align: center; padding: 12px; color: #fff;">Adicionado em</th>
                            <th style="text-align: center; padding: 12px; color: #fff;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allowedIps as $ip => $info): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px;">
                                <code style="color: #4CAF50; font-size: 14px;"><?= htmlspecialchars($ip) ?></code>
                            </td>
                            <td style="padding: 12px; color: #b9bbbe;">
                                <?= !empty($info['note']) ? htmlspecialchars($info['note']) : '<em style="color: #666;">Sem observação</em>' ?>
                            </td>
                            <td style="padding: 12px; text-align: center; color: #b9bbbe;">
                                <?= date('d/m/Y H:i:s', $info['added_at'] ?? time()) ?>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <form action="<?= route('admin/blocked-ips/allowed/remove') ?>" method="post" style="display: inline-block;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="ip" value="<?= htmlspecialchars($ip) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja remover este IP da lista de permitidos?');">
                                        <i class="ph ph-trash"></i> Remover
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 20px; color: #999;">
                <i class="ph ph-shield-check" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                <p>Nenhum IP permitido cadastrado</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Formulário para bloquear IP manualmente -->
    <div class="form" style="margin-bottom: 30px; padding: 20px; background-color: #1a1a1a; border-left: 4px solid #ff6b6b; border-radius: 4px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
            <i class="ph ph-shield-slash" style="color: #ff6b6b; font-size: 1.5em;"></i>
            <h3 class="subtitle" style="margin: 0;">Bloquear IP Manualmente</h3>
        </div>
        <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
            Use esta opção para bloquear um IP específico manualmente. Útil para bloquear IPs maliciosos ou fazer testes.
        </small>
        <form action="<?= route('admin/blocked-ips/block') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            <div class="grid-3">
                <div>
                    <label>Endereço IP</label>
                    <input type="text" 
                           name="ip" 
                           placeholder="127.0.0.1" 
                           value="<?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '') ?>"
                           required>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Seu IP atual: <strong><?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'N/A') ?></strong>
                    </small>
                </div>
                <div>
                    <label>Duração do Bloqueio</label>
                    <select name="duration" required>
                        <option value="60">1 minuto (60 segundos)</option>
                        <option value="300">5 minutos (300 segundos)</option>
                        <option value="600">10 minutos (600 segundos)</option>
                        <option value="1800">30 minutos (1800 segundos)</option>
                        <option value="3600" selected>1 hora (3600 segundos)</option>
                        <option value="7200">2 horas (7200 segundos)</option>
                        <option value="14400">4 horas (14400 segundos)</option>
                        <option value="86400">24 horas (86400 segundos)</option>
                    </select>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Ou digite um valor personalizado (1-86400 segundos):
                    </small>
                    <input type="number" 
                           name="duration_custom" 
                           placeholder="Personalizado" 
                           min="1" 
                           max="86400" 
                           style="margin-top: 5px;"
                           onchange="if(this.value) document.querySelector('select[name=duration]').value = this.value;">
                </div>
                <div>
                    <label>Motivo do Bloqueio</label>
                    <select name="reason" required>
                        <option value="manual_block" selected>Bloqueio Manual</option>
                        <option value="rate_limit_exceeded">Limite de Requisições Excedido</option>
                        <option value="suspicious_pattern">Padrão Suspeito Detectado</option>
                        <option value="concurrent_requests">Muitas Requisições Simultâneas</option>
                        <option value="suspicious_user_agent">User-Agent Suspeito</option>
                        <option value="route_rate_limit">Limite de Rota Excedido</option>
                    </select>
                    <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">
                        Motivo será registrado nos logs de auditoria
                    </small>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <button type="submit" class="btn btn-danger">
                    <i class="ph ph-shield-slash"></i> Bloquear IP
                </button>
            </div>
            <div style="margin-top: 15px; padding: 12px; background-color: #2a2a2a; border-radius: 4px; border-left: 3px solid #ffc107;">
                <div style="display: flex; align-items: start; gap: 8px;">
                    <i class="ph ph-warning" style="color: #ffc107; font-size: 1.2em; margin-top: 2px;"></i>
                    <div>
                        <strong style="color: #ffc107; display: block; margin-bottom: 5px;">⚠️ Atenção Importante:</strong>
                        <ul style="color: #b9bbbe; font-size: 0.9em; line-height: 1.6; margin: 0; padding-left: 20px;">
                            <li>Ao bloquear seu próprio IP, você perderá acesso ao admin até o bloqueio expirar</li>
                            <li>Use outro dispositivo/rede para desbloquear ou aguarde o tempo configurado</li>
                            <li>O bloqueio é imediato e afeta todas as requisições do IP bloqueado</li>
                            <li>Todas as ações são registradas nos logs de auditoria</li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php if (empty($blockedIps)): ?>
        <div class="form" style="text-align: center; padding: 40px;">
            <i class="ph ph-shield-check" style="font-size: 48px; color: #4CAF50; margin-bottom: 15px;"></i>
            <h3 style="color: #fff; margin-bottom: 10px;">Nenhum IP Bloqueado</h3>
            <p style="color: #999;">Não há IPs bloqueados no momento.</p>
        </div>
    <?php else: ?>
        <div class="form">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #333; background-color: #1a1a1a;">
                        <th style="text-align: left; padding: 12px; color: #fff;">IP</th>
                        <th style="text-align: left; padding: 12px; color: #fff;">Motivo</th>
                        <th style="text-align: center; padding: 12px; color: #fff;">Bloqueado em</th>
                        <th style="text-align: center; padding: 12px; color: #fff;">Expira em</th>
                        <th style="text-align: center; padding: 12px; color: #fff;">Tempo Restante</th>
                        <th style="text-align: center; padding: 12px; color: #fff;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blockedIps as $ip => $info): 
                        $now = time();
                        $blockedAt = $info['blocked_at'] ?? $now;
                        $until = $info['until'] ?? $now;
                        $remaining = max(0, $until - $now);
                        $duration = $info['duration'] ?? 3600;
                        
                        $remainingHours = floor($remaining / 3600);
                        $remainingMinutes = floor(($remaining % 3600) / 60);
                        $remainingSeconds = $remaining % 60;
                        
                        $reasonLabels = [
                            'rate_limit_exceeded' => 'Limite de Requisições Excedido',
                            'suspicious_pattern' => 'Padrão Suspeito Detectado',
                            'concurrent_requests' => 'Muitas Requisições Simultâneas',
                            'suspicious_user_agent' => 'User-Agent Suspeito',
                            'route_rate_limit' => 'Limite de Rota Excedido',
                        ];
                        $reasonLabel = $reasonLabels[$info['reason'] ?? 'rate_limit_exceeded'] ?? 'Desconhecido';
                    ?>
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 12px;">
                            <code style="color: #ff6b6b; font-size: 14px;"><?= htmlspecialchars($ip) ?></code>
                        </td>
                        <td style="padding: 12px; color: #b9bbbe;">
                            <?= htmlspecialchars($reasonLabel) ?>
                        </td>
                        <td style="padding: 12px; text-align: center; color: #b9bbbe;">
                            <?= date('d/m/Y H:i:s', $blockedAt) ?>
                        </td>
                        <td style="padding: 12px; text-align: center; color: #b9bbbe;">
                            <?= date('d/m/Y H:i:s', $until) ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?php if ($remaining > 0): ?>
                                <span style="color: #ffc107; font-weight: bold;">
                                    <?php if ($remainingHours > 0): ?>
                                        <?= $remainingHours ?>h <?= $remainingMinutes ?>m
                                    <?php elseif ($remainingMinutes > 0): ?>
                                        <?= $remainingMinutes ?>m <?= $remainingSeconds ?>s
                                    <?php else: ?>
                                        <?= $remainingSeconds ?>s
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span style="color: #4CAF50;">Expirado</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <form action="<?= route('admin/blocked-ips/unblock') ?>" method="post" style="display: inline-block;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="ip" value="<?= htmlspecialchars($ip) ?>">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="ph ph-check"></i> Desbloquear
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px; padding: 15px; background-color: #1a1a1a; border-left: 4px solid #2196F3; border-radius: 4px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                <i class="ph ph-info" style="color: #2196F3; font-size: 1.2em;"></i>
                <strong style="color: #fff;">Informações</strong>
            </div>
            <ul style="list-style: disc; margin-left: 20px; color: #b9bbbe; font-size: 0.9em; line-height: 1.8;">
                <li>IPs bloqueados são armazenados em <code>storage/blocked_ips.json</code></li>
                <li>IPs expirados são removidos automaticamente ao visualizar esta página</li>
                <li>O tempo restante é atualizado em tempo real</li>
                <li>Você pode desbloquear IPs individualmente ou todos de uma vez</li>
            </ul>
        </div>
    <?php endif; ?>
</div>

