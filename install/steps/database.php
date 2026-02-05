<?php
/**
 * Etapa 3: Configuração de Banco de Dados
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
if (empty($_SESSION['install']['requirements_completed'])) {
    header('Location: ?step=requirements');
    exit;
}

if (empty($_SESSION['install']['license_completed'])) {
    header('Location: ?step=license');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim($_POST['host'] ?? '');
    $port = trim($_POST['port'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $database = trim($_POST['database'] ?? '');
    
    // Tipo de hash: se marcar sha256 ou md5, usa aquele. Senão, fica plain (padrão)
    $passwordHashType = 'plain';
    if (isset($_POST['password_hash_sha256']) && $_POST['password_hash_sha256'] == '1') {
        $passwordHashType = 'sha256';
    } elseif (isset($_POST['password_hash_md5']) && $_POST['password_hash_md5'] == '1') {
        $passwordHashType = 'md5';
    }
    
    $useViCurrInfo = isset($_POST['use_vi_curr_info']);
    
    // Validações
    if (empty($host)) {
        $errors[] = 'Host é obrigatório';
    }
    if (empty($username)) {
        $errors[] = 'Username é obrigatório';
    }
    if (empty($password)) {
        $errors[] = 'Password é obrigatório';
    }
    if (empty($database)) {
        $errors[] = 'Database Name é obrigatório';
    }
    
    if (empty($errors)) {
        // Tentar conectar ao banco
        try {
            $dsn = "sqlsrv:Server={$host}" . (!empty($port) ? ",{$port}" : "") . ";Database={$database}";
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            
            // Salvar dados na sessão
            $_SESSION['install']['database'] = [
                'host' => $host,
                'port' => $port,
                'username' => $username,
                'password' => $password,
                'database' => $database,
                'password_hash_type' => $passwordHashType,
                'use_vi_curr_info' => $useViCurrInfo,
            ];
            $_SESSION['install']['database_completed'] = true;
            
            $success = true;
            $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : '';
            header('Location: ?step=columns' . $langParam);
            exit;
        } catch (PDOException $e) {
            // Mensagem de erro mais intuitiva
            $errorMsg = $e->getMessage();
            $friendlyError = 'Erro ao conectar ao banco de dados.';
            
            if (strpos($errorMsg, 'Login failed') !== false) {
                $friendlyError = t('database_login_error');
            } elseif (strpos($errorMsg, 'could not find driver') !== false) {
                $friendlyError = t('database_driver_error');
            } elseif (strpos($errorMsg, 'Network') !== false || strpos($errorMsg, 'timeout') !== false) {
                $friendlyError = t('database_network_error');
            } elseif (strpos($errorMsg, 'database') !== false && strpos($errorMsg, 'not exist') !== false) {
                $friendlyError = t('database_not_found');
            } else {
                $friendlyError = t('database_connection_error');
            }
            
            $errors[] = $friendlyError;
            
            // Manter valores digitados (exceto senha e username)
            $_SESSION['install']['database'] = [
                'host' => $host,
                'port' => $port,
                'username' => '', // Limpar username em caso de erro
                'password' => '', // Limpar senha em caso de erro
                'database' => $database,
                'password_hash_type' => $passwordHashType,
                'use_vi_curr_info' => $useViCurrInfo,
            ];
        }
    } else {
        // Se houver erros de validação, manter valores digitados (exceto senha e username)
        $_SESSION['install']['database'] = [
            'host' => $host,
            'port' => $port,
            'username' => '',
            'password' => '',
            'database' => $database,
            'password_hash_type' => $passwordHashType ?? 'plain',
            'use_vi_curr_info' => $useViCurrInfo,
        ];
    }
}

// Recuperar valores da sessão ou usar padrões
// Só usar valores da sessão se a sessão foi iniciada nesta instalação
if (isset($_SESSION['install']['started'])) {
    $host = $_SESSION['install']['database']['host'] ?? 'localhost';
    $port = $_SESSION['install']['database']['port'] ?? '';
    $username = $_SESSION['install']['database']['username'] ?? 'sa';
    $password = ''; // Sempre vazio para segurança
    $database = $_SESSION['install']['database']['database'] ?? 'MuOnline';
    $passwordHashType = $_SESSION['install']['database']['password_hash_type'] ?? 'plain';
    $useViCurrInfo = $_SESSION['install']['database']['use_vi_curr_info'] ?? false;
} else {
    // Se não há sessão iniciada, usar apenas valores padrão
    $host = 'localhost';
    $port = '';
    $username = 'sa';
    $password = '';
    $database = 'MuOnline';
    $passwordHashType = 'plain';
    $useViCurrInfo = false;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - WebRox Installer V3.0</title>
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
        
        .form-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-card h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-group label .required {
            color: #e74c3c;
        }
        
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background: white;
        }
        
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #7f8c8d;
            font-size: 12px;
        }
        
        .form-group .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-group .checkbox-group input[type="checkbox"] {
            width: auto;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
            font-size: 14px;
        }
        
        .error div {
            margin: 5px 0;
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
            <h2><?= htmlspecialchars(t('database_title')) ?></h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" autocomplete="off">
                <input type="hidden" name="lang" value="<?= $currentLang ?>">
                <div class="form-group">
                    <label><?= htmlspecialchars(t('database_host')) ?> <span class="required">*</span></label>
                    <input type="text" name="host" value="<?= htmlspecialchars($host) ?>" required>
                </div>
                
                <div class="form-group">
                    <label><?= htmlspecialchars(t('database_port')) ?></label>
                    <input type="text" name="port" value="<?= htmlspecialchars($port) ?>">
                </div>
                
                <div class="form-group">
                    <label><?= htmlspecialchars(t('database_username')) ?> <span class="required">*</span></label>
                    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required>
                </div>
                
                <div class="form-group">
                    <label><?= htmlspecialchars(t('database_password')) ?> <span class="required">*</span></label>
                    <input type="password" name="password" id="db_password" value="<?= htmlspecialchars($password) ?>" required autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                </div>
                
                <div class="form-group">
                    <label><?= htmlspecialchars(t('database_name')) ?> <span class="required">*</span></label>
                    <input type="text" name="database" value="<?= htmlspecialchars($database) ?>" required>
                </div>
                
                <div class="form-group">
                    <label><?= htmlspecialchars(t('database_password_hash')) ?></label>
                    <div style="margin-top: 8px;">
                        <div class="checkbox-group" style="margin-bottom: 8px;">
                            <input type="checkbox" name="password_hash_sha256" id="password_hash_sha256" value="1" 
                                   <?= $passwordHashType === 'sha256' ? 'checked' : '' ?>
                                   onchange="if(this.checked) document.getElementById('password_hash_md5').checked = false;">
                            <label for="password_hash_sha256"><?= htmlspecialchars(t('database_password_hash_sha256')) ?></label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" name="password_hash_md5" id="password_hash_md5" value="1"
                                   <?= $passwordHashType === 'md5' ? 'checked' : '' ?>
                                   onchange="if(this.checked) document.getElementById('password_hash_sha256').checked = false;">
                            <label for="password_hash_md5"><?= htmlspecialchars(t('database_password_hash_md5')) ?></label>
                        </div>
                    </div>
                    <small style="color: #7f8c8d; font-size: 12px; display: block; margin-top: 5px;">
                        <?= htmlspecialchars(t('database_password_hash_help')) ?>
                    </small>
                </div>
                
                <div class="btn-container">
                    <a href="?step=license<?= $langParam ?>" class="btn btn-secondary"><?= htmlspecialchars(t('back')) ?></a>
                    <button type="submit" class="btn"><?= htmlspecialchars(t('continue')) ?></button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

