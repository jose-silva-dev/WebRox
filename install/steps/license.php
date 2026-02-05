<?php
/**
 * Etapa 2: Verificação de Licença
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

// Verificar se a etapa anterior (requirements) foi completada
if (empty($_SESSION['install']['requirements_completed'])) {
    header('Location: ?step=requirements');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim($_POST['customer_name'] ?? '');
    
    // Validações
    if (empty($customerName)) {
        $errors[] = 'Customer Name é obrigatório';
    }
    
    // Verificar licença se o campo foi preenchido
    if (empty($errors) && !empty($customerName)) {
        // Detectar domínio corretamente
        $domain = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
        // Remover porta se houver
        $domain = preg_replace('/:\d+$/', '', $domain);
        
        // Extrair domínio principal (sem subdomínio)
        // Exemplo: web.roxgaming.net -> roxgaming.net
        $domainParts = explode('.', $domain);
        $mainDomain = $domain;
        if (count($domainParts) > 2) {
            // Tem subdomínio, extrair domínio principal
            $mainDomain = $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];
        }
        
        $licenseValid = false;
        $a1 = base64_decode('aHR0cHM6Ly9yb3hnYW1pbmcubmV0');
        $a2 = base64_decode('L2FwaS93ZWJyb3gv');
        $a3 = base64_decode('Y2hlY2stbGljZW5zZQ==');
        $apiUrl = $a1 . $a2 . $a3;
        
        // Tentar primeiro com o domínio completo (com subdomínio)
        $domainsToTry = [$domain];
        // Se tiver subdomínio, também tentar com o domínio principal
        if ($domain !== $mainDomain) {
            $domainsToTry[] = $mainDomain;
        }
        
        foreach ($domainsToTry as $domainToCheck) {
            try {
                $ch = curl_init();
                $p1 = base64_decode('Y3VzdG9tZXJfbmFtZQ==');
                $p2 = base64_decode('ZG9tYWlu');
                curl_setopt($ch, CURLOPT_URL, $apiUrl . "?" . $p1 . "=" . urlencode($customerName) . "&" . $p2 . "=" . urlencode($domainToCheck) . "&nocache=1");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlError = curl_error($ch);
                curl_close($ch);
                
                if ($httpCode === 200 && $response) {
                    $data = json_decode($response, true);
                    $v = base64_decode('dmFsaWQ=');
                    if ($data && isset($data[$v]) && $data[$v] === true) {
                        $licenseValid = true;
                        // Usar o domínio que funcionou
                        $domain = $domainToCheck;
                        break;
                    }
                }
            } catch (Exception $e) {
                // Erro na verificação, continuar para próximo domínio
                continue;
            }
        }
        
        if (!$licenseValid) {
            $errors[] = t('license_invalid');
        } else {
            // Licença válida - salvar e avançar
            $_SESSION['install']['license'] = [
                'customer_name' => $customerName,
                'domain' => $domain,
            ];
            $_SESSION['install']['license_completed'] = true;
            
            $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : '';
            header('Location: ?step=database' . $langParam);
            exit;
        }
    }
    
    // Se houver erro, manter o valor digitado
    if (!empty($errors)) {
        $_SESSION['install']['license'] = [
            'customer_name' => $customerName,
        ];
    }
}

// Recuperar valores da sessão ou usar padrões
if (isset($_SESSION['install']['started'])) {
    $customerName = $_SESSION['install']['license']['customer_name'] ?? '';
} else {
    $customerName = '';
}

// Detectar domínio para exibição
$domain = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
$domain = preg_replace('/:\d+$/', '', $domain);

// Extrair domínio principal para exibição
$domainParts = explode('.', $domain);
$mainDomain = $domain;
$hasSubdomain = false;
if (count($domainParts) > 2) {
    $mainDomain = $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];
    $hasSubdomain = true;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Verification - WebRox Installer V3.0</title>
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
            max-width: 600px;
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
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .form-card h2 {
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .form-card p {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group label .required {
            color: #e74c3c;
        }
        
        .form-group input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .form-group small {
            display: block;
            margin-top: 8px;
            color: #7f8c8d;
            font-size: 12px;
            text-align: center;
        }
        
        .domain-info {
            background: #ecf0f1;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #555;
        }
        
        .domain-info strong {
            color: #2c3e50;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
            font-size: 14px;
            text-align: left;
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
            <h2><?= htmlspecialchars(t('license_title')) ?></h2>
            <p><?= htmlspecialchars(t('license_description')) ?></p>
            
            <div class="domain-info">
                <strong><?= htmlspecialchars(t('license_domain_detected')) ?>:</strong> <?= htmlspecialchars($domain) ?>
            </div>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <input type="hidden" name="lang" value="<?= $currentLang ?>">
                <div class="form-group">
                    <label><?= htmlspecialchars(t('license_customer_name')) ?> <span class="required">*</span></label>
                    <input type="text" name="customer_name" value="<?= htmlspecialchars($customerName) ?>" required autofocus>
                </div>
                
                <div class="btn-container">
                    <a href="?step=requirements<?= $langParam ?>" class="btn btn-secondary"><?= htmlspecialchars(t('back')) ?></a>
                    <button type="submit" class="btn"><?= htmlspecialchars(t('license_verify')) ?></button>
                </div>
            </form>
        </div>
        
        <div style="text-align: center; margin-top: 30px; color: #7f8c8d; font-size: 12px;">
            <p><?= t('footer_link') ?></p>
        </div>
    </div>
</body>
</html>

