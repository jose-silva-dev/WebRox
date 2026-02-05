<?php
/**
 * Etapa 6: Processo de Instalação
 */

// Carregar traduções
if (!function_exists('t')) {
    require __DIR__ . '/../lang/translations.php';
}
$currentLang = $_SESSION['install']['language'] ?? 'pt';

// Verificar se todas as etapas anteriores foram completadas
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
$appConfig = $_SESSION['install']['application'];
$adminConfig = $_SESSION['install']['admin'];

$errors = [];
$success = false;
$messages = [];

try {
    // Conectar ao banco
    $dsn = "sqlsrv:Server={$dbConfig['host']}" . (!empty($dbConfig['port']) ? ",{$dbConfig['port']}" : "") . ";Database={$dbConfig['database']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    $messages[] = "✓ Conectado ao banco de dados";
    
    $reinstallAll = $_SESSION['install']['reinstall_all'] ?? false;
    
    // Ler e executar query.sql
    $queryFile = __DIR__ . '/../sql/query.sql';
    if (file_exists($queryFile)) {
        $sql = file_get_contents($queryFile);
        
        // Remover comentários de linha
        $sql = preg_replace('/--.*$/m', '', $sql);
        
        // Se não for reinstalar tudo, remover os DROP TABLE
        if (!$reinstallAll) {
            $sql = preg_replace('/IF OBJECT_ID\([^)]+\) IS NOT NULL DROP TABLE [^;]+;/i', '', $sql);
        }
        
        // Dividir em comandos individuais
        $statements = preg_split('/;\s*(?=IF|CREATE|ALTER|DROP)/i', $sql);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (empty($statement) || strlen($statement) < 10) {
                continue;
            }
            
            // Se não for reinstalar tudo, verificar se a tabela já existe antes de criar
            if (!$reinstallAll && preg_match('/CREATE TABLE\s+(\w+)/i', $statement, $matches)) {
                $tableName = $matches[1];
                $checkTable = $pdo->query("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '{$tableName}'");
                $tableExists = $checkTable->fetch()['count'] > 0;
                if ($tableExists) {
                    $messages[] = "⊘ Tabela {$tableName} já existe, pulando...";
                    continue;
                }
            }
            
            try {
                $pdo->exec($statement);
                if (preg_match('/CREATE TABLE\s+(\w+)/i', $statement, $matches)) {
                    $messages[] = "✓ Tabela {$matches[1]} criada";
                } elseif (preg_match('/ALTER TABLE\s+(\w+)\s+ADD\s+(\w+)/i', $statement, $matches)) {
                    $messages[] = "✓ Coluna {$matches[2]} adicionada à tabela {$matches[1]}";
                }
            } catch (PDOException $e) {
                // Ignorar erros de "já existe" ou "não existe" ou "coluna já existe"
                $errorMsg = $e->getMessage();
                if (strpos($errorMsg, 'already exists') === false && 
                    strpos($errorMsg, 'does not exist') === false &&
                    strpos($errorMsg, 'Invalid object name') === false &&
                    strpos($errorMsg, 'duplicate column name') === false &&
                    strpos($errorMsg, 'Cannot drop') === false &&
                    strpos($errorMsg, 'There is already an object named') === false) {
                    $messages[] = "⚠ " . substr($errorMsg, 0, 100);
                }
            }
        }
        
        $messages[] = "✓ Tabelas processadas";
    }
    
    // Criar/atualizar colunas customizadas
    $avatarColumn = $columnsConfig['character_avatar'];
    $resetsColumn = $columnsConfig['character_resets'];
    $masterResetsColumn = $columnsConfig['character_master_resets'];
    $pkColumn = $columnsConfig['character_pk'];
    $heroColumn = $columnsConfig['character_hero'];
    
    // Verificar e criar colunas customizadas apenas se não existirem (ou se for reinstalar tudo)
    $avatarColumn = $columnsConfig['character_avatar'];
    try {
        $checkAvatar = $pdo->query("SELECT COUNT(*) as col_count FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Character' AND COLUMN_NAME = '{$avatarColumn}'");
        $avatarExists = $checkAvatar && $checkAvatar->fetch()['col_count'] > 0;
        
        if (!$avatarExists || $reinstallAll) {
            if ($avatarExists && $reinstallAll) {
                // Se reinstalar, primeiro remover a coluna
                try {
                    $pdo->exec("ALTER TABLE Character DROP COLUMN {$avatarColumn}");
                    $messages[] = "⊘ Coluna {$avatarColumn} removida (reinstalação)";
                } catch (PDOException $e) {
                    // Ignorar erro se não conseguir remover
                }
            }
            if (!$avatarExists || $reinstallAll) {
                try {
                    $pdo->exec("ALTER TABLE Character ADD {$avatarColumn} VARCHAR(255)");
                    $messages[] = "✓ Coluna {$avatarColumn} criada na tabela Character";
                } catch (PDOException $e) {
                    // Se der erro de coluna duplicada, verificar novamente
                    if (strpos($e->getMessage(), 'duplicate') !== false || strpos($e->getMessage(), 'already exists') !== false || strpos($e->getMessage(), 'specified more than once') !== false) {
                        $messages[] = "⊘ Coluna {$avatarColumn} já existe, mantendo...";
                    } else {
                        throw $e;
                    }
                }
            }
        } else {
            $messages[] = "⊘ Coluna {$avatarColumn} já existe, mantendo...";
        }
    } catch (PDOException $e) {
        // Se a verificação falhar, tentar adicionar com tratamento de erro
        try {
            $pdo->exec("ALTER TABLE Character ADD {$avatarColumn} VARCHAR(255)");
            $messages[] = "✓ Coluna {$avatarColumn} criada na tabela Character";
        } catch (PDOException $e2) {
            if (strpos($e2->getMessage(), 'duplicate') !== false || strpos($e2->getMessage(), 'already exists') !== false || strpos($e2->getMessage(), 'specified more than once') !== false) {
                $messages[] = "⊘ Coluna {$avatarColumn} já existe, mantendo...";
            } else {
                $messages[] = "⚠ Não foi possível verificar/criar coluna {$avatarColumn}: " . substr($e2->getMessage(), 0, 100);
            }
        }
    }
    
    // Verificar e criar coluna Leadership se necessário
    try {
        $checkLeadership = $pdo->query("SELECT COUNT(*) as col_count FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Character' AND COLUMN_NAME = 'Leadership'");
        $leadershipExists = $checkLeadership && $checkLeadership->fetch()['col_count'] > 0;
        
        if (!$leadershipExists || $reinstallAll) {
            if ($leadershipExists && $reinstallAll) {
                try {
                    $pdo->exec("ALTER TABLE Character DROP COLUMN Leadership");
                    $messages[] = "⊘ Coluna Leadership removida (reinstalação)";
                } catch (PDOException $e) {
                    // Ignorar erro se não conseguir remover
                }
            }
            if (!$leadershipExists || $reinstallAll) {
                try {
                    $pdo->exec("ALTER TABLE Character ADD Leadership INT NOT NULL DEFAULT(0)");
                    $messages[] = "✓ Coluna Leadership criada na tabela Character";
                } catch (PDOException $e) {
                    // Se der erro de coluna duplicada, verificar novamente
                    if (strpos($e->getMessage(), 'duplicate') !== false || strpos($e->getMessage(), 'already exists') !== false) {
                        $messages[] = "⊘ Coluna Leadership já existe, mantendo...";
                    } else {
                        throw $e;
                    }
                }
            }
        } else {
            $messages[] = "⊘ Coluna Leadership já existe, mantendo...";
        }
    } catch (PDOException $e) {
        // Se a verificação falhar, tentar adicionar com tratamento de erro
        try {
            $pdo->exec("ALTER TABLE Character ADD Leadership INT NOT NULL DEFAULT(0)");
            $messages[] = "✓ Coluna Leadership criada na tabela Character";
        } catch (PDOException $e2) {
            if (strpos($e2->getMessage(), 'duplicate') !== false || strpos($e2->getMessage(), 'already exists') !== false || strpos($e2->getMessage(), 'specified more than once') !== false) {
                $messages[] = "⊘ Coluna Leadership já existe, mantendo...";
            } else {
                $messages[] = "⚠ Não foi possível verificar/criar coluna Leadership: " . substr($e2->getMessage(), 0, 100);
            }
        }
    }
    
    // Verificar e criar coluna cash se necessário
    try {
        $checkCash = $pdo->query("SELECT COUNT(*) as col_count FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'MEMB_INFO' AND COLUMN_NAME = 'cash'");
        $cashExists = $checkCash && $checkCash->fetch()['col_count'] > 0;
        
        if (!$cashExists || $reinstallAll) {
            if ($cashExists && $reinstallAll) {
                try {
                    $pdo->exec("ALTER TABLE MEMB_INFO DROP COLUMN cash");
                    $messages[] = "⊘ Coluna cash removida (reinstalação)";
                } catch (PDOException $e) {
                    // Ignorar erro se não conseguir remover
                }
            }
            if (!$cashExists || $reinstallAll) {
                try {
                    $pdo->exec("ALTER TABLE MEMB_INFO ADD cash INT NOT NULL DEFAULT(0)");
                    $messages[] = "✓ Coluna cash criada na tabela MEMB_INFO";
                } catch (PDOException $e) {
                    // Se der erro de coluna duplicada, verificar novamente
                    if (strpos($e->getMessage(), 'duplicate') !== false || strpos($e->getMessage(), 'already exists') !== false || strpos($e->getMessage(), 'specified more than once') !== false) {
                        $messages[] = "⊘ Coluna cash já existe, mantendo...";
                    } else {
                        throw $e;
                    }
                }
            }
        } else {
            $messages[] = "⊘ Coluna cash já existe, mantendo...";
        }
    } catch (PDOException $e) {
        // Se a verificação falhar, tentar adicionar com tratamento de erro
        try {
            $pdo->exec("ALTER TABLE MEMB_INFO ADD cash INT NOT NULL DEFAULT(0)");
            $messages[] = "✓ Coluna cash criada na tabela MEMB_INFO";
        } catch (PDOException $e2) {
            if (strpos($e2->getMessage(), 'duplicate') !== false || strpos($e2->getMessage(), 'already exists') !== false || strpos($e2->getMessage(), 'specified more than once') !== false) {
                $messages[] = "⊘ Coluna cash já existe, mantendo...";
            } else {
                $messages[] = "⚠ Não foi possível verificar/criar coluna cash: " . substr($e2->getMessage(), 0, 100);
            }
        }
    }
    
    // Verificar e criar coluna AccountExpireDate se necessário
    try {
        $checkExpire = $pdo->query("SELECT COUNT(*) as col_count FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'MEMB_INFO' AND COLUMN_NAME = 'AccountExpireDate'");
        $expireExists = $checkExpire && $checkExpire->fetch()['col_count'] > 0;
        
        if (!$expireExists || $reinstallAll) {
            if ($expireExists && $reinstallAll) {
                try {
                    $pdo->exec("ALTER TABLE MEMB_INFO DROP COLUMN AccountExpireDate");
                    $messages[] = "⊘ Coluna AccountExpireDate removida (reinstalação)";
                } catch (PDOException $e) {
                    // Ignorar erro se não conseguir remover
                }
            }
            if (!$expireExists || $reinstallAll) {
                try {
                    $pdo->exec("ALTER TABLE MEMB_INFO ADD AccountExpireDate DATETIME");
                    $messages[] = "✓ Coluna AccountExpireDate criada na tabela MEMB_INFO";
                } catch (PDOException $e) {
                    // Se der erro de coluna duplicada, verificar novamente
                    if (strpos($e->getMessage(), 'duplicate') !== false || strpos($e->getMessage(), 'already exists') !== false || strpos($e->getMessage(), 'specified more than once') !== false) {
                        $messages[] = "⊘ Coluna AccountExpireDate já existe, mantendo...";
                    } else {
                        throw $e;
                    }
                }
            }
        } else {
            $messages[] = "⊘ Coluna AccountExpireDate já existe, mantendo...";
        }
    } catch (PDOException $e) {
        // Se a verificação falhar, tentar adicionar com tratamento de erro
        try {
            $pdo->exec("ALTER TABLE MEMB_INFO ADD AccountExpireDate DATETIME");
            $messages[] = "✓ Coluna AccountExpireDate criada na tabela MEMB_INFO";
        } catch (PDOException $e2) {
            if (strpos($e2->getMessage(), 'duplicate') !== false || strpos($e2->getMessage(), 'already exists') !== false || strpos($e2->getMessage(), 'specified more than once') !== false) {
                $messages[] = "⊘ Coluna AccountExpireDate já existe, mantendo...";
            } else {
                $messages[] = "⚠ Não foi possível verificar/criar coluna AccountExpireDate: " . substr($e2->getMessage(), 0, 100);
            }
        }
    }
    
    // Criar arquivo de configuração
    $configContent = "<?php\n\nreturn [\n";
    $configContent .= "    'database' => [\n";
    $configContent .= "        'connection' => [\n";
    $configContent .= "            'type'   => 'PDO::ConnectionSQLSRV',\n";
    $configContent .= "            'ip_vps' => '" . addslashes($dbConfig['host']) . "',\n";
    $configContent .= "            'port'   => '" . addslashes($dbConfig['port'] ?? '') . "',\n";
    $configContent .= "            'dbname' => '" . addslashes($dbConfig['database']) . "',\n";
    $configContent .= "            'user'   => '" . addslashes($dbConfig['username']) . "',\n";
    $configContent .= "            'passwd' => '" . addslashes($dbConfig['password']) . "',\n";
    $configContent .= "        ],\n";
    $configContent .= "    ],\n";
    $configContent .= "    'site' => [\n";
    $configContent .= "        'timezone' => '" . addslashes($appConfig['timezone']) . "',\n";
    $configContent .= "    ],\n";
    $configContent .= "    'admin' => [\n";
    $configContent .= "        'login'    => '" . addslashes($adminConfig['username']) . "',\n";
    $configContent .= "        'password' => '" . addslashes(password_hash($adminConfig['password'], PASSWORD_BCRYPT)) . "',\n";
    $configContent .= "    ],\n";
    $configContent .= "    'user' => [\n";
    $configContent .= "        'password_hash_type' => '" . addslashes($dbConfig['password_hash_type'] ?? 'plain') . "',\n";
    $configContent .= "    ],\n";
    $configContent .= "    'license' => [\n";
    $licenseConfig = $_SESSION['install']['license'] ?? [];
    $configContent .= "        'customer_name' => '" . addslashes($licenseConfig['customer_name'] ?? '') . "',\n";
    $configContent .= "    ],\n";
    $configContent .= "    'server' => [\n";
    $configContent .= "        'name' => 'MuRox Premium',\n";
    $configContent .= "        'version' => 'Season 6.3',\n";
    $configContent .= "        'experience' => '500 XP',\n";
    $configContent .= "        'drop' => '20%',\n";
    $configContent .= "        'level' => '400',\n";
    $configContent .= "        'points_attributes' => '32767',\n";
    $configContent .= "        'pvp' => 'Balanceado',\n";
    $configContent .= "        'online_base' => 0,\n";
    $configContent .= "        'online_multiplier' => 0,\n";
    $configContent .= "        'status' => [\n";
    $configContent .= "            'timeout' => 1,\n";
    $configContent .= "            'servers' => [],\n";
    $configContent .= "        ],\n";
    $configContent .= "    ],\n";
    
    // Ativar todos os plugins por padrão
    $configContent .= "    'plugins' => [\n";
    $configContent .= "        'vip' => [\n";
    $configContent .= "            'enabled' => true,\n";
    $configContent .= "        ],\n";
    $configContent .= "        'events' => [\n";
    $configContent .= "            'enabled' => true,\n";
    $configContent .= "        ],\n";
    $configContent .= "        'hallfame' => [\n";
    $configContent .= "            'enabled' => true,\n";
    $configContent .= "        ],\n";
    $configContent .= "        'notice' => [\n";
    $configContent .= "            'enabled' => true,\n";
    $configContent .= "        ],\n";
    $configContent .= "        'slider' => [\n";
    $configContent .= "            'enabled' => true,\n";
    $configContent .= "        ],\n";
    $configContent .= "        'castlesiege' => [\n";
    $configContent .= "            'enabled' => true,\n";
    $configContent .= "        ],\n";
    $configContent .= "    ],\n";
    
    // Pré-ativar todos os rankings configurados
    $baseRankings = require dirname(__DIR__, 2) . '/bootstrap/rankings.php';
    $configContent .= "    'rankings' => [\n";
    $configContent .= "        'rankings' => [\n";
    $configContent .= "            'cache' => [\n";
    $configContent .= "                'enabled' => 0,\n";
    $configContent .= "                'interval' => 30,\n";
    $configContent .= "            ],\n";
    $configContent .= "            'geral' => [\n";
    if (!empty($baseRankings['rankings']['geral'])) {
        foreach ($baseRankings['rankings']['geral'] as $index => $ranking) {
            $configContent .= "                [\n";
            $configContent .= "                    'title' => " . var_export($ranking['title'], true) . ",\n";
            $configContent .= "                    'table' => " . var_export($ranking['table'], true) . ",\n";
            $configContent .= "                    'column' => " . var_export($ranking['column'], true) . ",\n";
            $configContent .= "                    'tag' => " . var_export($ranking['tag'], true) . ",\n";
            $configContent .= "                    'slug' => " . var_export($ranking['slug'], true) . ",\n";
            $configContent .= "                    'enabled' => 1,\n";
            $configContent .= "                ],\n";
        }
    }
    $configContent .= "            ],\n";
    $configContent .= "        ],\n";
    $configContent .= "    ],\n";
    $configContent .= "];\n";
    
    $configPath = dirname(__DIR__, 2) . '/bootstrap/app.custom.php';
    if (file_put_contents($configPath, $configContent)) {
        $messages[] = "✓ Arquivo de configuração criado";
    } else {
        $errors[] = "Erro ao criar arquivo de configuração";
    }

    // Sempre remover cache de config para o site usar o app.custom.php recém-escrito (com a licença correta)
    $cacheFile = dirname(__DIR__, 2) . '/storage/framework/config.php';
    if (file_exists($cacheFile)) {
        @unlink($cacheFile);
        $messages[] = "✓ Cache de configuração removido";
    }

    // IMPORTANTE: security.php é mesclado POR ÚLTIMO no index; se tiver customer_name vazio, SOBRESCREVE a licença do app.custom e o site dá "Sistema bloqueado". Gravar a licença aqui.
    $customDir = dirname(__DIR__, 2) . '/bootstrap/custom';
    $securityPath = $customDir . '/security.php';
    $licenseCustomer = addslashes($licenseConfig['customer_name'] ?? '');
    if (file_exists($securityPath)) {
        $secContent = file_get_contents($securityPath);
        $secContent = preg_replace("/'customer_name'\s*=>\s*'[^']*'/", "'customer_name' => '" . $licenseCustomer . "'", $secContent, 1);
        if ($secContent !== null && file_put_contents($securityPath, $secContent)) {
            $messages[] = "✓ Licença gravada em security.php";
        }
    }

    // Custom dir para plugins e (se reinstall) limpar cache
    if (!is_dir($customDir)) {
        @mkdir($customDir, 0775, true);
    }
    $pluginsCustomPath = $customDir . '/plugins.php';

    // Se "reinstalar tudo": limpar cache de config e zerar plugins (eventos, invasões, donate, VIP)
    if ($reinstallAll) {
        $cacheFile = dirname(__DIR__, 2) . '/storage/framework/config.php';
        if (file_exists($cacheFile)) {
            @unlink($cacheFile);
            $messages[] = "✓ Cache de configuração removido";
        }
        $pluginsCustomContent = "<?php\n\nreturn [\n    'plugins' => [\n        'events' => [\n            'enabled' => true,\n            'config' => [\n                'Eventos' => [],\n                'invasions' => [],\n            ],\n        ],\n        'donate' => [\n            'enabled' => true,\n            'config' => [\n                'plans' => [],\n            ],\n        ],\n        'vip' => [\n            'enabled' => true,\n            'config' => [\n                'plans' => [],\n            ],\n        ],\n    ],\n];\n";
        if (file_put_contents($pluginsCustomPath, $pluginsCustomContent)) {
            $messages[] = "✓ Eventos, invasões, donate e VIP zerados (reinstalação)";
        }
    } elseif (!file_exists($pluginsCustomPath)) {
        $pluginsCustomContent = "<?php\n\nreturn [\n    'plugins' => [\n        'events' => [\n            'enabled' => true,\n            'config' => [\n                'Eventos' => [],\n                'invasions' => [],\n            ],\n        ],\n    ],\n];\n";
        if (file_put_contents($pluginsCustomPath, $pluginsCustomContent)) {
            $messages[] = "✓ Eventos e invasões inicializados vazios";
        }
    }

    // Criar arquivo .installed
    $lockFile = __DIR__ . '/../.installed';
    if (file_put_contents($lockFile, date('Y-m-d H:i:s'))) {
        $messages[] = "✓ Arquivo de instalação criado";
    }

    // NÃO marcar web_installed aqui – será marcado na página success (etapa 8) para evitar redirect para o site antes de mostrar os parabéns

    // Limpar cookie "Remember me" se existir
    if (isset($_COOKIE['remember_token'])) {
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        setcookie('remember_token', '', time() - 3600, '/', '', $secure, true);
        unset($_COOKIE['remember_token']);
    }
    
    // Limpar arquivo de tokens "Remember me"
    $tokensFile = dirname(__DIR__, 2) . '/storage/remember_tokens.json';
    if (file_exists($tokensFile)) {
        @unlink($tokensFile);
        $messages[] = "✓ Tokens de autenticação limpos";
    }
    
    // Limpar outras sessões relacionadas (mas manter $_SESSION['install'] para success.php)
    if (session_status() === PHP_SESSION_ACTIVE) {
        // Limpar apenas sessões de usuário/admin, mas manter install
        $installData = $_SESSION['install'] ?? null;
        $_SESSION = [];
        if ($installData) {
            $_SESSION['install'] = $installData;
        }
    }

    if (empty($errors)) {
        $success = true;
        // NÃO limpar sessão aqui - success.php precisa dos dados do admin
        $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : '';
        // Usar URL absoluta para garantir que o browser vai para /install (etapa 8) e não para /
        header('Location: /install?step=success' . $langParam);
        exit;
    }
    
} catch (Exception $e) {
    $errors[] = "Erro: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(t('install_title')) ?> - WebRox Installer V3.0</title>
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
        
        .install-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .install-card h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .messages {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .message {
            padding: 5px 0;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include __DIR__ . '/../includes/header.php'; ?>
        
        <div class="install-card">
            <h2><?= htmlspecialchars(t('install_title')) ?></h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <ul style="margin-left: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div class="messages">
                <?php foreach ($messages as $message): ?>
                    <div class="message"><?= htmlspecialchars($message) ?></div>
                <?php endforeach; ?>
                
                <?php if (empty($errors) && !$success): ?>
                    <div class="spinner"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php if ($success): ?>
        <script>
            setTimeout(function() {
                window.location.href = '?step=success';
            }, 2000);
        </script>
    <?php endif; ?>
</body>
</html>

