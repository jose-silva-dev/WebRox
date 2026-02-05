<?php
/**
 * Translation Helper Functions
 */

// Iniciar sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Idiomas disponíveis
$availableLanguages = ['pt' => 'Português', 'en' => 'English', 'es' => 'Español'];

// Detectar idioma
if (!function_exists('getLanguage')) {
    function getLanguage() {
        // Verificar se foi selecionado um idioma
        if (isset($_GET['lang']) && in_array($_GET['lang'], ['pt', 'en', 'es'])) {
            $_SESSION['install']['language'] = $_GET['lang'];
            return $_GET['lang'];
        }
        
        // Verificar se há idioma salvo na sessão
        if (isset($_SESSION['install']['language']) && in_array($_SESSION['install']['language'], ['pt', 'en', 'es'])) {
            return $_SESSION['install']['language'];
        }
        
        // Detectar idioma do navegador
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (in_array($lang, ['pt', 'en', 'es'])) {
                return $lang;
            }
        }
        
        // Padrão: Português
        return 'pt';
    }
}

// Carregar traduções
if (!function_exists('loadTranslations')) {
    function loadTranslations($lang) {
        $langFile = __DIR__ . '/' . $lang . '.php';
        if (file_exists($langFile)) {
            return require $langFile;
        }
        // Fallback para português
        return require __DIR__ . '/pt.php';
    }
}

// Obter tradução
if (!function_exists('t')) {
    function t($key, $default = '') {
        global $translations;
        return $translations[$key] ?? $default ?? $key;
    }
}

// Obter idioma atual
$currentLang = getLanguage();
$translations = loadTranslations($currentLang);
