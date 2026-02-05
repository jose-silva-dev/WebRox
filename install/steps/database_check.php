<?php
/**
 * Etapa 7: Verificação do Banco de Dados
 */

// Iniciar sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se não há sessão de instalação iniciada, redirecionar para o início
if (!isset($_SESSION['install']['started'])) {
    header('Location: ?step=requirements');
    exit;
}

// Verificar se as etapas anteriores foram completadas
if (empty($_SESSION['install']['requirements_completed']) ||
    empty($_SESSION['install']['license_completed']) ||
    empty($_SESSION['install']['database_completed']) ||
    empty($_SESSION['install']['columns_completed']) ||
    empty($_SESSION['install']['application_completed']) ||
    empty($_SESSION['install']['admin_completed'])) {
    header('Location: ?step=requirements');
    exit;
}

$dbConfig = $_SESSION['install']['database'];
$columnsConfig = $_SESSION['install']['columns'];

$errors = [];
$existingTables = [];
$missingTables = [];
$existingColumns = [];
$missingColumns = [];
$pdo = null;

// Tabelas que devem existir
$requiredTables = [
    'rox_downloads',
    'rox_sliders',
    'rox_notices',
    'rox_notice_comments',
    'rox_additional_downloads',
    'rox_donations',
    'rox_tickets',
    'rox_ticket_answers',
];

// Colunas que devem existir
$requiredColumns = [
    ['table' => 'Character', 'column' => $columnsConfig['character_avatar'] ?? 'Avatar'],
    ['table' => 'Character', 'column' => 'Leadership'],
    ['table' => 'MEMB_INFO', 'column' => 'AccountExpireDate'],
    ['table' => 'rox_sliders', 'column' => 'link'],
    ['table' => 'rox_notices', 'column' => 'image'],
    ['table' => 'rox_notices', 'column' => 'video'],
];

// Verificar conexão e estrutura do banco
try {
    $dsn = "sqlsrv:Server={$dbConfig['host']}" . (!empty($dbConfig['port']) ? ",{$dbConfig['port']}" : "") . ";Database={$dbConfig['database']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Verificar tabelas existentes
    foreach ($requiredTables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '{$table}'");
        $result = $stmt->fetch();
        if ($result['count'] > 0) {
            $existingTables[] = $table;
        } else {
            $missingTables[] = $table;
        }
    }
    
    // Verificar colunas existentes
    foreach ($requiredColumns as $col) {
        $table = $col['table'];
        $column = $col['column'];
        try {
            $stmt = $pdo->query("SELECT COL_LENGTH('{$table}', '{$column}') as col_length");
            $result = $stmt->fetch();
            if ($result['col_length'] !== null) {
                $existingColumns[] = $col;
            } else {
                $missingColumns[] = $col;
            }
        } catch (PDOException $e) {
            // Tabela não existe, então a coluna também não existe
            $missingColumns[] = $col;
        }
    }
    
} catch (PDOException $e) {
    $errors[] = t('database_connection_error') . " " . $e->getMessage();
}

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reinstallAll = isset($_POST['reinstall_all']) && $_POST['reinstall_all'] == '1';
    $_SESSION['install']['reinstall_all'] = $reinstallAll;
    
    // Usar URL relativa
    $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : '';
    header('Location: ?step=install' . $langParam);
    exit;
}

$langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : '';
$hasExistingData = !empty($existingTables) || !empty($existingColumns);

?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(t('database_check_title')) ?> - WebRox Installer V3.0</title>
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
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }
        
        .form-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .form-card h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .summary-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 600px) {
            .summary-row { grid-template-columns: 1fr; }
        }
        .summary-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            border: 1px solid #e9ecef;
        }
        .summary-card h3 {
            font-size: 15px;
            color: #2c3e50;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        .status-section {
            margin-bottom: 0;
        }
        .status-section h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        .status-list {
            background: #f9f9f9;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        .status-list:last-child {
            margin-bottom: 0;
        }
        .status-list strong {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .status-item {
            padding: 4px 0;
            font-size: 13px;
            font-family: ui-monospace, monospace;
        }
        .status-item.existing {
            color: #27ae60;
        }
        .status-item.missing {
            color: #e74c3c;
        }
        .status-item::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }
        .status-item.existing::before {
            background: #27ae60;
        }
        .status-item.missing::before {
            background: #e74c3c;
        }
        .warning-box {
            background: #fff8e6;
            border: 1px solid #ffc107;
            border-radius: 6px;
            padding: 14px 16px;
            margin-bottom: 24px;
        }
        .warning-box strong {
            color: #856404;
        }
        .reinstall-box {
            background: #fff5f5;
            border: 1px solid #e74c3c;
            border-radius: 6px;
            padding: 16px;
            margin: 24px 0 20px 0;
        }
        .reinstall-box .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin: 0;
        }
        .reinstall-box input[type="checkbox"] {
            margin-top: 4px;
            flex-shrink: 0;
        }
        .reinstall-box label {
            font-size: 14px;
            line-height: 1.5;
            cursor: pointer;
        }
        .reinstall-box .danger-text {
            color: #c0392b;
            font-weight: 600;
            margin-top: 6px;
        }
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }
        .checkbox-group input[type="checkbox"] {
            margin-top: 3px;
        }
        .checkbox-group label {
            font-size: 14px;
            line-height: 1.5;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #2980b9;
        }
        
        .btn-secondary {
            background: #95a5a6;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn-container .btn {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include __DIR__ . '/../includes/header.php'; ?>
        
        <div class="form-card">
            <h2><?= htmlspecialchars(t('database_check_title')) ?></h2>
            <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 25px;">
                <?= htmlspecialchars(t('database_check_description')) ?>
            </p>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                
                <?php if ($hasExistingData): ?>
                <div class="warning-box">
                    <strong><?= htmlspecialchars(t('database_check_warning_title')) ?></strong> <?= htmlspecialchars(t('database_check_warning_message')) ?>
                </div>
                <?php endif; ?>
                
                <div class="summary-row">
                    <div class="summary-card">
                        <h3><?= htmlspecialchars(t('database_check_tables')) ?></h3>
                        <?php if (!empty($existingTables)): ?>
                        <div class="status-list">
                            <strong style="color: #27ae60;">✓ <?= htmlspecialchars(t('database_check_existing')) ?> (<?= count($existingTables) ?>)</strong>
                            <?php foreach ($existingTables as $table): ?>
                                <div class="status-item existing"><?= htmlspecialchars($table) ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($missingTables)): ?>
                        <div class="status-list">
                            <strong style="color: #e74c3c;">✗ <?= htmlspecialchars(t('database_check_missing')) ?> (<?= count($missingTables) ?>)</strong>
                            <?php foreach ($missingTables as $table): ?>
                                <div class="status-item missing"><?= htmlspecialchars($table) ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (empty($existingTables) && empty($missingTables)): ?>
                        <div class="status-list">
                            <div class="status-item missing"><?= htmlspecialchars(t('database_check_no_tables')) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="summary-card">
                        <h3><?= htmlspecialchars(t('database_check_columns')) ?></h3>
                        <?php if (!empty($existingColumns)): ?>
                        <div class="status-list">
                            <strong style="color: #27ae60;">✓ <?= htmlspecialchars(t('database_check_existing')) ?> (<?= count($existingColumns) ?>)</strong>
                            <?php foreach ($existingColumns as $col): ?>
                                <div class="status-item existing"><?= htmlspecialchars($col['table']) ?>.<?= htmlspecialchars($col['column']) ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($missingColumns)): ?>
                        <div class="status-list">
                            <strong style="color: #e74c3c;">✗ <?= htmlspecialchars(t('database_check_missing')) ?> (<?= count($missingColumns) ?>)</strong>
                            <?php foreach ($missingColumns as $col): ?>
                                <div class="status-item missing"><?= htmlspecialchars($col['table']) ?>.<?= htmlspecialchars($col['column']) ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <form method="POST">
                    <input type="hidden" name="lang" value="<?= $currentLang ?>">
                    
                    <?php if ($hasExistingData): ?>
                    <div class="reinstall-box">
                        <div class="checkbox-group">
                            <input type="checkbox" name="reinstall_all" id="reinstall_all" value="1">
                            <label for="reinstall_all">
                                <strong><?= htmlspecialchars(t('database_check_reinstall_all')) ?></strong>: <?= t('database_check_reinstall_warning') ?>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="btn-container">
                        <a href="?step=admin<?= $langParam ?>" class="btn btn-secondary"><?= htmlspecialchars(t('back')) ?></a>
                        <button type="submit" class="btn">
                            <?= $hasExistingData && empty($missingTables) && empty($missingColumns) ? htmlspecialchars(t('database_check_continue_anyway')) : htmlspecialchars(t('install')) ?>
                        </button>
                    </div>
                </form>
                
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

