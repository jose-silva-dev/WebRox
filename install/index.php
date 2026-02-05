<?php

// Verificar se já está instalado (fonte única: web_installed em bootstrap/custom/installed.php)
$installedPhp = dirname(__DIR__) . '/bootstrap/custom/installed.php';
$webInstalled = false;
if (file_exists($installedPhp)) {
    $data = require $installedPhp;
    $webInstalled = ($data['web_installed'] ?? false) === true;
}
$installLockFile = __DIR__ . '/.installed';
$customConfigFile = dirname(__DIR__) . '/bootstrap/app.custom.php';
$currentStep = $_GET['step'] ?? 'requirements';

// Só redirecionar para / quando a app estiver marcada como instalada (evita loop ao testar com web_installed = false)
if ($webInstalled && file_exists($installLockFile) && $currentStep !== 'success') {
    header('Location: /');
    exit;
}

// Iniciar sessão para manter dados entre etapas
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carregar sistema de tradução
require __DIR__ . '/lang/translations.php';

// Verificar se é uma nova instalação (resetar sessão se necessário)
$resetSession = isset($_GET['reset']) && $_GET['reset'] == '1';
if ($resetSession) {
    // Limpar sessão de instalação anterior
    unset($_SESSION['install']);
    
    // Limpar todas as sessões e cookies de segurança ao reiniciar instalação
    // Limpar cookie "Remember me" se existir
    if (isset($_COOKIE['remember_token'])) {
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        setcookie('remember_token', '', time() - 3600, '/', '', $secure, true);
        unset($_COOKIE['remember_token']);
    }
    
    // Limpar arquivo de tokens "Remember me"
    $tokensFile = dirname(__DIR__) . '/storage/remember_tokens.json';
    if (file_exists($tokensFile)) {
        @unlink($tokensFile);
    }
    
    // Limpar sessões de usuário e admin
    if (session_status() === PHP_SESSION_ACTIVE) {
        unset($_SESSION['UserLoggedIn']);
        unset($_SESSION['isAdminLogged']);
    }
}

// Se não há sessão iniciada, criar uma nova (primeira vez acessando)
if (!isset($_SESSION['install']['started'])) {
    unset($_SESSION['install']); // Garantir que está limpo
    
    // Limpar sessões de usuário e admin na primeira vez
    if (session_status() === PHP_SESSION_ACTIVE) {
        unset($_SESSION['UserLoggedIn']);
        unset($_SESSION['isAdminLogged']);
    }
    
    // Limpar cookie "Remember me" se existir
    if (isset($_COOKIE['remember_token'])) {
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        setcookie('remember_token', '', time() - 3600, '/', '', $secure, true);
        unset($_COOKIE['remember_token']);
    }
    
    // Limpar arquivo de tokens "Remember me"
    $tokensFile = dirname(__DIR__) . '/storage/remember_tokens.json';
    if (file_exists($tokensFile)) {
        @unlink($tokensFile);
    }
    
    $_SESSION['install']['started'] = time();
}

// Determinar etapa atual
$step = $_GET['step'] ?? 'requirements';
$allowedSteps = ['requirements', 'license', 'database', 'columns', 'application', 'admin', 'database_check', 'install', 'success'];

if (!in_array($step, $allowedSteps)) {
    $step = 'requirements';
}

// Incluir arquivo da etapa
$stepFile = __DIR__ . '/steps/' . $step . '.php';

if (file_exists($stepFile)) {
    require $stepFile;
} else {
    die('Etapa não encontrada: ' . htmlspecialchars($step));
}

