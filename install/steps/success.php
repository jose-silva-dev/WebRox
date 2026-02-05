<?php
/**
 * Etapa 9: Instalação Concluída
 */

// Verificar se realmente está instalado
$installLockFile = __DIR__ . '/../.installed';
if (!file_exists($installLockFile)) {
    header('Location: ?step=requirements');
    exit;
}

// Marcar web_installed = true só aqui (etapa 8), para o botão "Ir ao site" / "Admin" funcionar
$customDir = dirname(__DIR__, 2) . '/bootstrap/custom';
$installedPhp = $customDir . '/installed.php';
$installedContent = "<?php\n\n/** Flag de instalação - gerado pelo instalador */\nreturn ['web_installed' => true];\n";
if (is_dir($customDir)) {
    file_put_contents($installedPhp, $installedContent);
}

// Carregar traduções
if (!function_exists('t')) {
    require __DIR__ . '/../lang/translations.php';
}
$currentLang = $_SESSION['install']['language'] ?? 'pt';

// Construir URLs completas
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$adminLoginUrl = "{$protocol}://{$host}/auth/admin";
$homeUrl = "{$protocol}://{$host}/";

// Obter credenciais do admin da sessão
$adminUsername = $_SESSION['install']['admin']['username'] ?? '';
$adminPassword = $_SESSION['install']['admin']['password'] ?? '';

// Limpar sessão após alguns segundos (para mostrar a página de sucesso)
// O redirecionamento será feito via JavaScript após 5 segundos

?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(t('success_title')) ?> - WebRox V3</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 700px;
            width: 100%;
        }
        
        .success-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .success-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .success-card h1 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #27ae60;
        }
        
        .success-message {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .warning-box strong {
            color: #856404;
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }
        
        .warning-box p {
            color: #856404;
            margin: 0;
            line-height: 1.6;
        }
        
        .warning-box code {
            background: rgba(133, 100, 4, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #856404;
            font-size: 14px;
        }
        
        .btn-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
            min-width: 180px;
        }
        
        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-secondary {
            background: #95a5a6;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: rgba(255,255,255,0.9);
        }
        
        .footer a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        .credentials-box {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .credentials-box strong {
            color: #2e7d32;
            font-size: 16px;
            display: block;
            margin-bottom: 15px;
        }
        
        .credentials-item {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .credentials-item label {
            color: #2e7d32;
            font-weight: 600;
            min-width: 80px;
        }
        
        .credentials-item code {
            background: rgba(46, 125, 50, 0.1);
            padding: 6px 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #2e7d32;
            font-size: 14px;
            flex: 1;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="success-icon">🎉</div>
            <h1><?= htmlspecialchars(t('success_title')) ?></h1>
            <p class="success-message">
                <?= htmlspecialchars(t('success_message')) ?>
            </p>
            
            <div class="warning-box">
                <strong>⚠️ <?= htmlspecialchars(t('security_warning_title')) ?></strong>
                <p>
                    <?= htmlspecialchars(t('security_warning_message')) ?>
                    <br><br>
                    <code>/install</code>
                </p>
            </div>
            
            <?php if (!empty($adminUsername) && !empty($adminPassword)): ?>
            <div class="credentials-box">
                <strong>🔐 <?= htmlspecialchars(t('admin_credentials_title')) ?></strong>
                <div class="credentials-item">
                    <label><?= htmlspecialchars(t('admin_username')) ?>:</label>
                    <code><?= htmlspecialchars($adminUsername) ?></code>
                </div>
                <div class="credentials-item">
                    <label><?= htmlspecialchars(t('admin_password')) ?>:</label>
                    <code><?= htmlspecialchars($adminPassword) ?></code>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="btn-container">
                <a href="<?= htmlspecialchars($adminLoginUrl) ?>" class="btn" id="adminBtn">
                    <?= htmlspecialchars(t('go_to_admin')) ?>
                </a>
                <a href="<?= htmlspecialchars($homeUrl) ?>" class="btn btn-secondary">
                    <?= htmlspecialchars(t('go_to_homepage')) ?>
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>WebRox V3 by <a href="https://roxgaming.net" target="_blank"><strong>RoxGaming</strong></a></p>
        </div>
    </div>
    
    <script>
        const adminUrl = '<?= htmlspecialchars($adminLoginUrl) ?>';
        
        // Redirecionar ao clicar no botão "Ir para o Admin"
        document.getElementById('adminBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = adminUrl;
        });
    </script>
</body>
</html>

<?php
// Limpar sessão após exibir a página
unset($_SESSION['install']);
?>
