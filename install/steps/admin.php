<?php
/**
 * Etapa 6: Credenciais de Admin
 */

// Carregar traduções
if (!function_exists('t')) {
    require __DIR__ . '/../lang/translations.php';
}
$currentLang = $_SESSION['install']['language'] ?? 'pt';

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

if (empty($_SESSION['install']['database_completed'])) {
    header('Location: ?step=database');
    exit;
}

if (empty($_SESSION['install']['columns_completed'])) {
    header('Location: ?step=columns');
    exit;
}

if (empty($_SESSION['install']['application_completed'])) {
    header('Location: ?step=application');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminUsername = trim($_POST['admin_username'] ?? '');
    $adminPassword = trim($_POST['admin_password'] ?? '');
    
    // Validações
    if (empty($adminUsername)) {
        $errors[] = t('admin_username_required');
    }
    if (empty($adminPassword)) {
        $errors[] = t('admin_password_required');
    }
    if (strlen($adminPassword) < 6) {
        $errors[] = t('admin_password_min_length');
    }
    
    if (empty($errors)) {
        // Salvar dados na sessão
        $_SESSION['install']['admin'] = [
            'username' => $adminUsername,
            'password' => $adminPassword,
        ];
        $_SESSION['install']['admin_completed'] = true;
        
        $success = true;
        $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : '';
        header('Location: ?step=database_check' . $langParam);
        exit;
    }
}

// Recuperar valores da sessão ou usar padrões
// Só usar valores da sessão se a sessão foi iniciada nesta instalação
if (isset($_SESSION['install']['started'])) {
    $adminUsername = $_SESSION['install']['admin']['username'] ?? '';
    $adminPassword = $_SESSION['install']['admin']['password'] ?? '';
} else {
    // Se não há sessão iniciada, usar apenas valores padrão
    $adminUsername = '';
    $adminPassword = '';
}

?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(t('admin_title')) ?> - WebRox Installer V3.0</title>
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
        
        .error {
            background: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
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
            <h2><?= htmlspecialchars(t('admin_title')) ?></h2>
            <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 25px;">
                <?= htmlspecialchars(t('admin_description')) ?>
            </p>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <ul style="margin-left: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <input type="hidden" name="lang" value="<?= $currentLang ?>">
                <div class="form-group">
                    <label><?= htmlspecialchars(t('admin_login')) ?> <span class="required">*</span></label>
                    <input type="text" name="admin_username" value="<?= htmlspecialchars($adminUsername) ?>" required>
                    <small style="color: #7f8c8d; font-size: 12px; display: block; margin-top: 5px;">
                        <?= htmlspecialchars(t('admin_login_help')) ?>
                    </small>
                </div>
                
                <div class="form-group">
                    <label><?= htmlspecialchars(t('admin_password')) ?> <span class="required">*</span></label>
                    <input type="password" name="admin_password" value="<?= htmlspecialchars($adminPassword) ?>" required>
                    <small style="color: #7f8c8d; font-size: 12px; display: block; margin-top: 5px;">
                        <?= htmlspecialchars(t('admin_password_help')) ?>
                    </small>
                </div>
                
                <div class="btn-container">
                    <?php $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : ''; ?>
                    <a href="?step=application<?= $langParam ?>" class="btn btn-secondary"><?= htmlspecialchars(t('back')) ?></a>
                    <button type="submit" class="btn"><?= htmlspecialchars(t('install')) ?></button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

