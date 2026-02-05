<?php
/**
 * Etapa 5: Configuração da Aplicação
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

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $timezone = trim($_POST['timezone'] ?? 'America/Sao_Paulo');
    
    // Validações
    if (empty($timezone)) {
        $errors[] = t('application_timezone_required');
    }
    
    if (empty($errors)) {
        // Salvar dados na sessão
        $_SESSION['install']['application'] = [
            'timezone' => $timezone,
        ];
        $_SESSION['install']['application_completed'] = true;
        
        $success = true;
        $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : '';
        header('Location: ?step=admin' . $langParam);
        exit;
    }
}

// Recuperar valores da sessão ou usar padrões
// Só usar valores da sessão se a sessão foi iniciada nesta instalação
if (isset($_SESSION['install']['started'])) {
    $timezone = $_SESSION['install']['application']['timezone'] ?? 'America/Sao_Paulo';
} else {
    // Se não há sessão iniciada, usar apenas valores padrão
    $timezone = 'America/Sao_Paulo';
}

// Lista completa de timezones (sem nomes de países)
$allTimezones = timezone_identifiers_list();

?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(t('application_title')) ?> - WebRox Installer V3.0</title>
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
        
        .form-group select,
        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-group select:focus,
        .form-group input:focus {
            outline: none;
            border-color: #3498db;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #7f8c8d;
            font-size: 12px;
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
        
        .autocomplete {
            position: relative;
        }
        
        .autocomplete-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 4px 4px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .autocomplete-suggestion {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .autocomplete-suggestion:last-child {
            border-bottom: none;
        }
        
        .autocomplete-suggestion:hover {
            background: #f0f0f0;
        }
        
        .autocomplete-suggestion.highlight {
            background: #e3f2fd;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include __DIR__ . '/../includes/header.php'; ?>
        
        <div class="form-card">
            <h2><?= htmlspecialchars(t('application_title')) ?></h2>
            
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
                    <label><?= htmlspecialchars(t('application_timezone')) ?></label>
                    <div class="autocomplete">
                        <input type="text" name="timezone" value="<?= htmlspecialchars($timezone) ?>" 
                               placeholder="America/Sao_Paulo" required id="timezone_input">
                        <div class="autocomplete-suggestions" id="timezone_suggestions">
                            <?php foreach ($allTimezones as $tz): ?>
                                <div class="autocomplete-suggestion" data-value="<?= htmlspecialchars($tz) ?>">
                                    <?= htmlspecialchars($tz) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <small style="color: #7f8c8d; font-size: 12px; display: block; margin-top: 5px;">
                        <?= htmlspecialchars(t('application_timezone_help')) ?>
                    </small>
                </div>
                
                <div class="btn-container">
                    <?php $langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : ''; ?>
                    <a href="?step=columns<?= $langParam ?>" class="btn btn-secondary"><?= htmlspecialchars(t('back')) ?></a>
                    <button type="submit" class="btn"><?= htmlspecialchars(t('continue')) ?></button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Autocomplete para Timezone com filtro
        const timezoneInput = document.getElementById('timezone_input');
        const timezoneSuggestions = document.getElementById('timezone_suggestions');
        const allTimezoneOptions = Array.from(timezoneSuggestions.querySelectorAll('.autocomplete-suggestion'));
        
        if (timezoneInput && timezoneSuggestions) {
            function filterTimezones(searchTerm) {
                const term = searchTerm.toLowerCase();
                const filtered = allTimezoneOptions.filter(option => {
                    return option.textContent.toLowerCase().includes(term);
                });
                
                // Limpar sugestões
                timezoneSuggestions.innerHTML = '';
                
                // Mostrar até 20 resultados
                filtered.slice(0, 20).forEach(option => {
                    timezoneSuggestions.appendChild(option.cloneNode(true));
                });
                
                // Adicionar event listeners aos novos elementos
                timezoneSuggestions.querySelectorAll('.autocomplete-suggestion').forEach(suggestion => {
                    suggestion.addEventListener('click', function() {
                        timezoneInput.value = this.dataset.value;
                        timezoneSuggestions.style.display = 'none';
                    });
                });
            }
            
            timezoneInput.addEventListener('focus', function() {
                filterTimezones(this.value);
                timezoneSuggestions.style.display = 'block';
            });
            
            timezoneInput.addEventListener('input', function() {
                filterTimezones(this.value);
                timezoneSuggestions.style.display = this.value.length > 0 ? 'block' : 'none';
            });
            
            timezoneInput.addEventListener('blur', function() {
                setTimeout(() => {
                    timezoneSuggestions.style.display = 'none';
                }, 200);
            });
        }
    </script>
</body>
</html>

