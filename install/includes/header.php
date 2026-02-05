<?php
// Header comum com seletor de idioma
// Garantir que as traduções estejam carregadas
if (!function_exists('t')) {
    require __DIR__ . '/../lang/translations.php';
}
$currentLang = $_SESSION['install']['language'] ?? 'pt';
$currentStep = $_GET['step'] ?? 'requirements';
$langParam = isset($_SESSION['install']['language']) ? '&lang=' . $_SESSION['install']['language'] : (isset($_GET['lang']) ? '&lang=' . $_GET['lang'] : '');

// Mapear etapas para números (install é automática, não conta como etapa visível)
$stepNumbers = [
    'requirements' => 1,
    'license' => 2,
    'database' => 3,
    'columns' => 4,
    'application' => 5,
    'admin' => 6,
    'database_check' => 7,
    'install' => 7, // Install é automática, mesma etapa que database_check
    'success' => 8,
];

$totalSteps = 8; // Total de etapas visíveis (install não conta)
$currentStepNumber = $stepNumbers[$currentStep] ?? 1;

// Se for a página success, não mostrar o header padrão (ela tem seu próprio layout)
if ($currentStep === 'success') {
    return; // Não renderizar o header na página de sucesso
}
?>
<div class="language-selector" style="position: fixed; top: 10px; right: 10px; z-index: 1000; background: white; padding: 8px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <select onchange="window.location.href='?step=<?= $currentStep ?>&lang=' + this.value" style="padding: 5px 10px; border: 1px solid #ddd; border-radius: 3px; font-size: 14px; cursor: pointer;">
        <option value="pt" <?= $currentLang === 'pt' ? 'selected' : '' ?>>🇧🇷 PT</option>
        <option value="en" <?= $currentLang === 'en' ? 'selected' : '' ?>>🇺🇸 EN</option>
        <option value="es" <?= $currentLang === 'es' ? 'selected' : '' ?>>🇪🇸 ES</option>
    </select>
</div>
<div class="header">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="flex: 1;"></div>
        <div style="text-align: center; flex: 1;">
            <h1><?= htmlspecialchars(t('installer_title')) ?></h1>
            <p><strong><?= htmlspecialchars(t('installer_subtitle')) ?></strong></p>
            <p style="font-size: 14px; color: #7f8c8d;"><?= htmlspecialchars(t('installer_brand')) ?></p>
            <div style="margin-top: 15px; padding: 8px 16px; background: #ecf0f1; border-radius: 20px; display: inline-block; font-size: 14px; color: #2c3e50; font-weight: 500;">
                <?= htmlspecialchars(t('step')) ?> <?= $currentStepNumber ?> <?= htmlspecialchars(t('of')) ?> <?= $totalSteps ?>
            </div>
        </div>
        <div style="flex: 1; text-align: right;">
            <?php if ($currentStep !== 'requirements'): ?>
            <a href="?step=requirements&reset=1<?= $langParam ?>" class="btn" style="background: #95a5a6; padding: 8px 16px; font-size: 14px; text-decoration: none;">
                <?= htmlspecialchars(t('restart_installation')) ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
