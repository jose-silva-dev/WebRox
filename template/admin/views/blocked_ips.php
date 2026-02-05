<?= $this->layout('components/layouts/admin') ?>

<?php
$reasonLabels = [
    'manual_block' => 'Bloqueio Manual',
    'rate_limit_exceeded' => 'Limite de Requisições',
    'suspicious_pattern' => 'Padrão Suspeito',
    'concurrent_requests' => 'Requisições Simultâneas',
    'suspicious_user_agent' => 'User-Agent Suspeito',
    'route_rate_limit' => 'Limite de Rota',
];
?>

<div class="adm-dashboard">
    <div class="adm-dashboard__grid" style="grid-template-columns: 1fr;">
        <section class="adm-card adm-card--full ips-section ips-section--allowed">
            <header class="adm-card__header">
                <div>
                    <p class="adm-eyebrow">Whitelist</p>
                    <h2 class="adm-card__title">IPs Permitidos</h2>
                </div>
            </header>
            <div class="ips-section__content">
                <p class="ips-section__hint">IPs com acesso total. Use para servidores, admins, etc.</p>
                <form action="<?= route('admin/blocked-ips/allowed/add') ?>" method="post">
                <?= csrf_field() ?>
                <div class="ips-form-row">
                    <div>
                        <label for="allowed-ip">IP</label>
                        <input type="text" id="allowed-ip" name="ip" value="<?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '') ?>" required>
                    </div>
                    <div>
                        <label for="allowed-note">Observação (opcional)</label>
                        <input type="text" id="allowed-note" name="note">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="ph ph-plus"></i> Adicionar</button>
                    </div>
                </div>
                <small class="ips-section__small">Seu IP atual: <strong><?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'N/A') ?></strong></small>
            </form>

            <?php if (!empty($allowedIps)): ?>
            <div class="ips-grid">
                <?php foreach ($allowedIps as $ip => $info): ?>
                <div class="ip-card ip-card--allowed">
                    <div class="ip-card__header">
                        <code><?= htmlspecialchars($ip) ?></code>
                        <form action="<?= route('admin/blocked-ips/allowed/remove') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="ip" value="<?= htmlspecialchars($ip) ?>">
                            <button type="submit" class="btn btn-danger btn-sm" title="Remover" onclick="return confirm('Remover este IP da whitelist?');">
                                <i class="ph ph-x" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                    <div class="ip-card__meta"><?= !empty($info['note']) ? htmlspecialchars($info['note']) : '—' ?></div>
                    <div class="ip-card__meta"><?= date('d/m/Y H:i', $info['added_at'] ?? time()) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="ips-section__empty">
                <i class="ph ph-shield-check ips-section__icon ips-section__icon--allowed"></i>
                Nenhum IP permitido
            </p>
            <?php endif; ?>
            </div>
        </section>

        <section class="adm-card adm-card--full ips-section ips-section--block">
            <header class="adm-card__header">
                <div>
                    <p class="adm-eyebrow">Bloqueio manual</p>
                    <h2 class="adm-card__title">Bloquear IP</h2>
                </div>
            </header>
            <div class="ips-section__content">
            <p class="ips-section__hint">Bloqueie um IP específico. Ações são registradas nos logs.</p>

            <form action="<?= route('admin/blocked-ips/block') ?>" method="post">
                <?= csrf_field() ?>
                <div class="ips-form-row">
                    <div>
                        <label for="block-ip">IP</label>
                        <input type="text" id="block-ip" name="ip" value="<?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '') ?>" required>
                    </div>
                    <div>
                        <label for="block-duration">Duração</label>
                        <select id="block-duration" name="duration" required>
                            <option value="60">1 min</option>
                            <option value="300">5 min</option>
                            <option value="600">10 min</option>
                            <option value="3600" selected>1 h</option>
                            <option value="86400">24 h</option>
                            <option value="9999999999">Para sempre</option>
                        </select>
                    </div>
                    <div>
                        <label for="block-reason">Motivo</label>
                        <select id="block-reason" name="reason" required>
                            <?php foreach ($reasonLabels as $val => $lbl): ?>
                            <option value="<?= htmlspecialchars($val) ?>" <?= $val === 'manual_block' ? 'selected' : '' ?>><?= htmlspecialchars($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="ph ph-shield-slash"></i> Bloquear</button>
                    </div>
                </div>
                <div class="ips-form-row ips-form-row--custom-duration">
                    <span class="ips-section__small">Ou segundos:</span>
                    <input type="number" name="duration_custom" min="1" max="86400" class="ips-duration-custom" onchange="if(this.value) document.querySelector('form[action*=\'block\'] select[name=duration]').value = this.value;">
                </div>
                <p class="ips-section__warning"><i class="ph ph-warning"></i> Bloquear seu próprio IP remove seu acesso até expirar.</p>
            </form>
            </div>
        </section>

        <?php if (empty($blockedIps)): ?>
        <section class="adm-card adm-card--full ips-section ips-section--empty-state">
            <i class="ph ph-shield-slash ips-section__icon ips-section__icon--block"></i>
            <p>Nenhum IP bloqueado</p>
        </section>
        <?php else: ?>
        <section class="adm-card adm-card--full">
            <header class="adm-card__header">
                <div>
                    <p class="adm-eyebrow">Lista</p>
                    <h2 class="adm-card__title">IPs Bloqueados</h2>
                </div>
                <form action="<?= route('admin/blocked-ips/unblock-all') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja desbloquear TODOS os IPs?');" title="Desbloquear todos">
                        <i class="ph ph-trash"></i> Desbloquear Todos
                    </button>
                </form>
            </header>
            <div class="ips-grid">
                <?php
                $durationForever = 9999999999;
                foreach ($blockedIps as $ip => $info):
                    $now = time();
                    $blockedAt = $info['blocked_at'] ?? $now;
                    $until = $info['until'] ?? $now;
                    $duration = (int)($info['duration'] ?? 0);
                    $isForever = $duration >= $durationForever;
                    $remaining = $isForever ? 1 : max(0, $until - $now);
                    $remainingHours = floor($remaining / 3600);
                    $remainingMinutes = floor(($remaining % 3600) / 60);
                    $remainingSeconds = $remaining % 60;
                    $reasonLabel = $reasonLabels[$info['reason'] ?? 'rate_limit_exceeded'] ?? 'Desconhecido';
                ?>
                <div class="ip-card ip-card--blocked">
                    <div class="ip-card__header">
                        <code><?= htmlspecialchars($ip) ?></code>
                        <form action="<?= route('admin/blocked-ips/unblock') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="ip" value="<?= htmlspecialchars($ip) ?>">
                            <button type="submit" class="btn btn-primary btn-sm" title="Desbloquear">
                                <i class="ph ph-check"></i>
                            </button>
                        </form>
                    </div>
                    <div class="ip-card__meta"><?= htmlspecialchars($reasonLabel) ?></div>
                    <div class="ip-card__meta"><?= date('d/m/Y H:i', $blockedAt) ?><?= $isForever ? ' → Para sempre' : ' → ' . date('d/m/Y H:i', $until) ?></div>
                    <div class="ip-card__meta">
                        <?php if ($isForever): ?>
                        <span class="ip-card__meta--forever">Para sempre</span>
                        <?php elseif ($remaining > 0): ?>
                        <span class="ip-card__meta--remaining">
                            <?= $remainingHours > 0 ? "{$remainingHours}h {$remainingMinutes}m" : ($remainingMinutes > 0 ? "{$remainingMinutes}m {$remainingSeconds}s" : "{$remainingSeconds}s") ?>
                        </span>
                        <?php else: ?>
                        <span class="ip-card__meta--expired">Expirado</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <p class="settings-desc">IPs em <code>storage/blocked_ips.json</code>. Expirados são removidos ao abrir esta página.</p>
        </section>
        <?php endif; ?>
    </div>
</div>
