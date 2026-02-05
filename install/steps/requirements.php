<?php
/**
 * Etapa 1: Verificação de Requisitos
 */

// Iniciar sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se está na primeira etapa e não há sessão iniciada, limpar qualquer sessão anterior
if (!isset($_SESSION['install']['started'])) {
    unset($_SESSION['install']);
    $_SESSION['install']['started'] = time();
}

// Exigir PHP 8.3+ e ionCube em todas as instalações (produção e desenvolvimento)
$phpMinVersion = '8.3.0';
$phpVersionOk = version_compare(PHP_VERSION, $phpMinVersion, '>=');
$requirements = [
    'php_version' => [
        'name' => t('requirement_php_version'),
        'required' => '8.3+',
        'current' => PHP_VERSION,
        'status' => $phpVersionOk,
        'error_message' => !$phpVersionOk ? (t('requirement_php_version') . ': mínimo 8.3. ' . t('requirement_current') . ': ' . PHP_VERSION) : '',
    ],
    'pdo' => [
        'name' => t('requirement_pdo'),
        'required' => 'pdo_sqlsrv, pdo_dblib ou pdo_odbc',
        'current' => '',
        'status' => false,
    ],
    'curl' => [
        'name' => t('requirement_curl'),
        'required' => t('requirement_required'),
        'current' => extension_loaded('curl') ? t('requirement_status_ok') : 'Not Found',
        'status' => extension_loaded('curl'),
    ],
    'zip' => [
        'name' => t('requirement_zip'),
        'required' => t('requirement_required'),
        'current' => extension_loaded('zip') ? t('requirement_status_ok') : 'Not Found',
        'status' => extension_loaded('zip'),
    ],
    'mbstring' => [
        'name' => t('requirement_mbstring'),
        'required' => t('requirement_required'),
        'current' => extension_loaded('mbstring') ? t('requirement_status_ok') : 'Not Found',
        'status' => extension_loaded('mbstring'),
    ],
    'openssl' => [
        'name' => t('requirement_openssl'),
        'required' => t('requirement_required'),
        'current' => extension_loaded('openssl') ? t('requirement_status_ok') : 'Not Found',
        'status' => extension_loaded('openssl'),
    ],
    'json' => [
        'name' => t('requirement_json'),
        'required' => t('requirement_required'),
        'current' => extension_loaded('json') ? t('requirement_status_ok') : 'Not Found',
        'status' => extension_loaded('json'),
    ],
    'ioncube' => [
        'name' => t('requirement_ioncube'),
        'required' => t('requirement_required'),
        'current' => '',
        'status' => false,
    ],
    'allow_url_fopen' => [
        'name' => 'allow_url_fopen',
        'required' => 'Enabled',
        'current' => ini_get('allow_url_fopen') ? 'OK' : 'Disabled',
        'status' => ini_get('allow_url_fopen'),
    ],
];

// Verificar PDO drivers
$pdoDrivers = [];
if (extension_loaded('pdo_sqlsrv')) {
    $pdoDrivers[] = 'pdo_sqlsrv';
}
if (extension_loaded('pdo_dblib')) {
    $pdoDrivers[] = 'pdo_dblib';
}
if (extension_loaded('pdo_odbc')) {
    $pdoDrivers[] = 'pdo_odbc';
}

$requirements['pdo']['current'] = !empty($pdoDrivers) ? implode(', ', $pdoDrivers) : 'Not Found';
$requirements['pdo']['status'] = !empty($pdoDrivers);

// Verificar ionCube Loader - método mais confiável
$ioncubeLoaded = false;
$ioncubeVersion = 'Not Found';

// Usar get_loaded_extensions() que é mais confiável que extension_loaded()
$loadedExtensions = get_loaded_extensions();

foreach ($loadedExtensions as $ext) {
    $extLower = strtolower(trim($ext));
    // Verificar nomes exatos que o ionCube pode ter
    if ($extLower === 'ioncube loader' || 
        $extLower === 'ioncube' || 
        (stripos($ext, 'ioncube') !== false && stripos($ext, 'loader') !== false)) {
        $ioncubeLoaded = true;
        // Tentar obter versão
        if (function_exists('ioncube_loader_version')) {
            try {
                $ioncubeVersion = 'v' . ioncube_loader_version();
            } catch (Exception $e) {
                $ioncubeVersion = 'Loaded';
            }
        } elseif (defined('IONCUBE_LOADER_VERSION')) {
            $ioncubeVersion = 'v' . IONCUBE_LOADER_VERSION;
        } else {
            $ioncubeVersion = 'Loaded';
        }
        break;
    }
}

$requirements['ioncube']['current'] = $ioncubeLoaded ? $ioncubeVersion : 'Not loaded (obrigatório)';
$requirements['ioncube']['status'] = $ioncubeLoaded;
$requirements['ioncube']['optional'] = false;

// Verificar se todos os requisitos estão OK
$allRequirementsMet = true;
foreach ($requirements as $req) {
    if (!$req['status']) {
        $allRequirementsMet = false;
        break;
    }
}

// Obter IP do servidor
$serverIp = $_SERVER['SERVER_ADDR'] ?? 'Unknown';
if ($serverIp === '::1' || $serverIp === '127.0.0.1') {
    $serverIp = $_SERVER['HTTP_HOST'] ?? 'localhost';
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebRox Installer - V3.0</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        
        .requirements-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .requirements-card h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .requirement-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        
        .requirement-item:last-child {
            border-bottom: none;
        }
        
        .requirement-label {
            font-weight: 500;
            display: block;
        }
        
        .requirement-value {
            color: #666;
        }
        
        .requirement-status {
            font-weight: bold;
        }
        
        .requirement-status.ok {
            color: #27ae60;
        }
        
        .requirement-status.fail {
            color: #e74c3c;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 30px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #2980b9;
        }
        
        .btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }
        
        .btn-container {
            text-align: center;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include __DIR__ . '/../includes/header.php'; ?>
        
        <div class="requirements-card">
            <h2><?= htmlspecialchars(t('requirements_title')) ?></h2>
            <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 20px;"><?= htmlspecialchars(t('requirements_description')) ?></p>
            
            <div class="requirement-item">
                <span class="requirement-label">Your IPs Address:</span>
                <span class="requirement-value"><?= htmlspecialchars($serverIp) ?></span>
            </div>
            
            <?php foreach ($requirements as $key => $req): ?>
            <div class="requirement-item">
                <div style="flex: 1;">
                    <span class="requirement-label"><?= htmlspecialchars($req['name']) ?>:</span>
                    <?php if (!$req['status'] && isset($req['error_message']) && !empty($req['error_message'])): ?>
                        <div style="color: #e74c3c; font-size: 12px; margin-top: 4px; font-weight: normal;">
                            <?= htmlspecialchars($req['error_message']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <span class="requirement-status <?= $req['status'] ? 'ok' : 'fail' ?>">
                    <?= $req['status'] ? t('requirement_status_ok') : t('requirement_status_fail') ?>
                </span>
            </div>
            <?php endforeach; ?>
            
            <div class="btn-container">
                <?php if ($allRequirementsMet): ?>
                    <?php
                    // Marcar requirements como completado
                    $_SESSION['install']['requirements_completed'] = true;
                    ?>
                    <a href="?step=license<?= $langParam ?>" class="btn"><?= htmlspecialchars(t('lets_go')) ?></a>
                <?php else: ?>
                    <button class="btn" disabled><?= htmlspecialchars(t('fix_requirements')) ?></button>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="footer">
            <p><?= t('footer_link') ?></p>
        </div>
    </div>
</body>
</html>

