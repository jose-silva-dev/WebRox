<h3 class="subtitle">Segurança</h3>
<h4 class="subtitle">Criptografia de senhas (players)</h4>
<div class="form-group">
    <label>Tipo de hash</label>
    <select name="user[password_hash_type]" required>
        <?php
        $hashTypes = ['plain' => 'Texto Puro (sem hash)', 'md5' => 'MD5', 'sha256' => 'SHA256'];
        $currentHashType = $user['password_hash_type'] ?? 'plain';
        foreach ($hashTypes as $value => $label): ?>
            <option value="<?= htmlspecialchars($value) ?>" <?= $currentHashType === $value ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
        <?php endforeach; ?>
    </select>
    <small class="form-hint" style="color: var(--text-warning, #f59e0b);">Alterar afeta apenas novas senhas; as antigas seguem válidas até serem trocadas.</small>
</div>
<hr style="margin:30px 0;border-color:var(--border-color)">
<h4 class="subtitle">Proteção DDoS</h4>
<div class="form-group">
    <label>
        <input type="checkbox" name="ddos[enabled]" value="1" <?= ($ddos['enabled'] ?? true) ? 'checked' : '' ?>>
        Habilitar proteção DDoS
    </label>
</div>
<hr style="margin:30px 0;border-color:var(--border-color)">
<h4 class="subtitle">Rate limiting global</h4>
<div class="grid-2">
    <div class="form-group">
        <label>Máximo de requisições por IP</label>
        <input type="number" name="ddos[global_rate_limit][max_requests]" value="<?= htmlspecialchars($ddos['global_rate_limit']['max_requests'] ?? 300) ?>" min="1" required>
    </div>
    <div class="form-group">
        <label>Janela (segundos)</label>
        <input type="number" name="ddos[global_rate_limit][window_seconds]" value="<?= htmlspecialchars($ddos['global_rate_limit']['window_seconds'] ?? 60) ?>" min="1" required>
        <small class="form-hint">ex.: 60 = 1 minuto</small>
    </div>
</div>
<hr style="margin:30px 0;border-color:var(--border-color)">
<h4 class="subtitle">Limites por rota sensível</h4>
<div id="ddos-routes-container" class="space-y-1">
    <?php $routeIndex = 0; foreach ($ddos['route_limits'] ?? [] as $route => $config): ?>
    <div class="ddos-route-item" data-index="<?= $routeIndex ?>">
        <div class="grid-3">
            <div>
                <label>Rota</label>
                <input type="text" name="ddos[route_limits][<?= $routeIndex ?>][route]" value="<?= htmlspecialchars($route) ?>"  required>
            </div>
            <div>
                <label>Máximo</label>
                <input type="number" name="ddos[route_limits][<?= $routeIndex ?>][max]" value="<?= htmlspecialchars($config['max'] ?? 10) ?>" min="1" required>
            </div>
            <div>
                <label>Janela (segundos)</label>
                <input type="number" name="ddos[route_limits][<?= $routeIndex ?>][window]" value="<?= htmlspecialchars($config['window'] ?? 60) ?>" min="1" required>
            </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm remove-ddos-route" style="margin-top: 8px;" title="Remover"><i class="ph ph-x" aria-hidden="true"></i></button>
    </div>
    <?php $routeIndex++; endforeach; ?>
</div>
<button type="button" class="btn btn-primary btn-sm" id="add-ddos-route" style="margin-top: 10px;"><i class="ph ph-plus"></i> Adicionar Rota</button>
<hr style="margin:30px 0;border-color:var(--border-color)">
<h4 class="subtitle">Padrões suspeitos</h4>
<div class="form-group">
    <label>
        <input type="checkbox" name="ddos[suspicious_patterns][enabled]" value="1" <?= ($ddos['suspicious_patterns']['enabled'] ?? false) ? 'checked' : '' ?>>
        Habilitar detecção
    </label>
</div>
<div class="grid-3">
    <div class="form-group">
        <label>User-Agent mínimo (caracteres)</label>
        <input type="number" name="ddos[suspicious_patterns][min_user_agent_length]" value="<?= htmlspecialchars($ddos['suspicious_patterns']['min_user_agent_length'] ?? 10) ?>" min="1" required>
    </div>
    <div class="form-group">
        <label>Limite requisições rápidas</label>
        <input type="number" name="ddos[suspicious_patterns][rapid_request_threshold]" value="<?= htmlspecialchars($ddos['suspicious_patterns']['rapid_request_threshold'] ?? 120) ?>" min="1" required>
    </div>
    <div class="form-group">
        <label>Janela (segundos)</label>
        <input type="number" name="ddos[suspicious_patterns][rapid_request_window]" value="<?= htmlspecialchars($ddos['suspicious_patterns']['rapid_request_window'] ?? 5) ?>" min="1" required>
    </div>
</div>
<hr style="margin:30px 0;border-color:var(--border-color)">
<h4 class="subtitle">Bloqueio automático de IPs</h4>
<div class="form-group">
    <label>
        <input type="checkbox" name="ddos[ip_blocking][enabled]" value="1" <?= ($ddos['ip_blocking']['enabled'] ?? true) ? 'checked' : '' ?>>
        Habilitar bloqueio
    </label>
</div>
<div class="form-group">
    <label>Duração do bloqueio (segundos)</label>
    <input type="number" name="ddos[ip_blocking][block_duration]" value="<?= htmlspecialchars($ddos['ip_blocking']['block_duration'] ?? 1800) ?>" min="1" required>
    <small class="form-hint">ex.: 1800 = 30 min (recomendado para jogos), 3600 = 1 hora</small>
</div>
<hr style="margin:30px 0;border-color:var(--border-color)">
<h4 class="subtitle">Requisições simultâneas</h4>
<div class="form-group">
    <label>
        <input type="checkbox" name="ddos[concurrent_requests][enabled]" value="1" <?= ($ddos['concurrent_requests']['enabled'] ?? false) ? 'checked' : '' ?>>
        Habilitar (pode bloquear usuários legítimos)
    </label>
</div>
<div class="grid-2">
    <div class="form-group">
        <label>Máximo simultâneas</label>
        <input type="number" name="ddos[concurrent_requests][max_concurrent]" value="<?= htmlspecialchars($ddos['concurrent_requests']['max_concurrent'] ?? 50) ?>" min="1" required>
    </div>
    <div class="form-group">
        <label>Janela (segundos)</label>
        <input type="number" name="ddos[concurrent_requests][window_seconds]" value="<?= htmlspecialchars($ddos['concurrent_requests']['window_seconds'] ?? 5) ?>" min="1" required>
    </div>
</div>
<hr style="margin:30px 0;border-color:var(--border-color)">
<h4 class="subtitle">Google reCAPTCHA</h4>
<div class="form-group">
    <label>
        <input type="checkbox" name="recaptcha[enabled]" value="1" <?= ($recaptcha['enabled'] ?? false) ? 'checked' : '' ?> onchange="document.getElementById('recaptcha-config').style.display = this.checked ? 'block' : 'none';">
        Habilitar reCAPTCHA (login, registro, recuperação de senha)
    </label>
</div>
<div id="recaptcha-config" style="display: <?= ($recaptcha['enabled'] ?? false) ? 'block' : 'none' ?>; margin-top: 20px;">
    <div class="grid-2">
        <div class="form-group">
            <label>Versão</label>
            <select name="recaptcha[version]" required>
                <option value="v2" <?= ($recaptcha['version'] ?? 'v2') === 'v2' ? 'selected' : '' ?>>v2 (checkbox)</option>
                <option value="v3" <?= ($recaptcha['version'] ?? 'v2') === 'v3' ? 'selected' : '' ?>>v3 (invisível)</option>
            </select>
        </div>
        <div id="recaptcha-score-config" class="form-group" style="display: <?= ($recaptcha['version'] ?? 'v2') === 'v3' ? 'block' : 'none' ?>;">
            <label>Score mínimo (v3)</label>
            <input type="number" name="recaptcha[score_threshold]" value="<?= htmlspecialchars($recaptcha['score_threshold'] ?? 0.5) ?>" min="0" max="1" step="0.1">
            <small class="form-hint">0 = bot, 1 = humano. Recomendado: 0,5</small>
        </div>
    </div>
    <div class="grid-2" style="margin-top: 15px;">
        <div class="form-group">
            <label>Site Key</label>
            <input type="text" name="recaptcha[site_key]" value="<?= htmlspecialchars($recaptcha['site_key'] ?? '') ?>" >
            <small class="form-hint"><a href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener" style="color: var(--primary-color);">Obter chaves</a></small>
        </div>
        <div class="form-group">
            <label>Secret Key</label>
            <input type="text" name="recaptcha[secret_key]" value="<?= htmlspecialchars($recaptcha['secret_key'] ?? '') ?>" >
        </div>
    </div>
</div>

<script>window.ddosRouteIndex = <?= isset($routeIndex) ? $routeIndex : count($ddos['route_limits'] ?? []) ?>;</script>
