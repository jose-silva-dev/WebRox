<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    Download
</div>

<h4 class="web-sub-title">Downloads do cliente com som e sem som:</h4>
<table class="table">
    <thead>
        <tr>
            <th width="20%">Arquivo</th>
            <th width="60%">Descrição</th>
            <th width="10%">Tamanho</th>
            <th width="10%">Download</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($downloads)): ?>
            <?php foreach ($downloads as $download): ?>
                <tr>
                    <td align="center"><?= $download->title ?></td>
                    <td align="center"><?= $download->description ?></td>
                    <td align="center"><?= $download->size ?></td>
                    <td align="center"><a href="<?= $download->link ?>" target="_blank">Download</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="warning" style="margin: 0; background: transparent; border: none; padding: 1rem;">
                    Nenhum download encontrado.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h4 class="web-sub-title">Downloads Adicionais:</h4>
<table class="table">
    <thead>
        <tr>
            <th width="20%">Arquivo</th>
            <th width="60%">Descrição</th>
            <th width="20%">Download</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($additionalDownloads)): ?>
            <?php foreach ($additionalDownloads as $additionalDownload): ?>
                <tr>
                    <td align="center"><?= htmlspecialchars($additionalDownload->title) ?></td>
                    <td align="center"><?= htmlspecialchars($additionalDownload->description) ?></td>
                    <td align="center"><a href="<?= htmlspecialchars($additionalDownload->link) ?>" target="_blank">Download</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="warning" style="margin: 0; background: transparent; border: none; padding: 1rem;">
                    Nenhum download adicional encontrado.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// Buscar requisitos mínimos das configurações
$requirements = config('download_requirements', []);
$cpuMin = $requirements['cpu_min'] ?? 'Single Core - 1.5 Ghz';
$cpuRecommended = $requirements['cpu_recommended'] ?? 'Dual Core 2.0 Ghz (ou superior)';
$ramMin = $requirements['ram_min'] ?? '1GB';
$ramRecommended = $requirements['ram_recommended'] ?? '2GB (ou superior)';
$osMin = $requirements['os_min'] ?? 'Windows 7';
$osRecommended = $requirements['os_recommended'] ?? 'Windows 10 ou 11';
$videoMin = $requirements['video_min'] ?? '128MB / 64 Bits';
$videoRecommended = $requirements['video_recommended'] ?? '256MB / 128 Bits (ou superior)';
?>

<h4 class="web-sub-title">Requisitos Mínimos:</h4>
<table class="table">
    <thead>
        <tr>
            <th width="25%">Requisitos Mínimos</th>
            <th width="25%">Mínimo requerido</th>
            <th width="25%">Recomendado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td align="center">CPU</td>
            <td align="center"><?= htmlspecialchars($cpuMin) ?></td>
            <td align="center" style="color: var(--red-100);"><?= htmlspecialchars($cpuRecommended) ?></td>
        </tr>
        <tr>
            <td align="center">RAM (Memória)</td>
            <td align="center"><?= htmlspecialchars($ramMin) ?></td>
            <td align="center" style="color: var(--red-100);"><?= htmlspecialchars($ramRecommended) ?></td>
        </tr>
        <tr>
            <td align="center">OS (Sistema operacional)</td>
            <td align="center"><?= htmlspecialchars($osMin) ?></td>
            <td align="center" style="color: var(--red-100);"><?= htmlspecialchars($osRecommended) ?></td>
        </tr>
        <tr>
            <td align="center">Placa de Vídeo</td>
            <td align="center"><?= htmlspecialchars($videoMin) ?></td>
            <td align="center" style="color: var(--red-100);"><?= htmlspecialchars($videoRecommended) ?></td>
        </tr>
    </tbody>
</table>

<div class="drive" style="margin-top: 2rem;">
    <h4 class="web-sub-title">Drivers de Vídeo</h4>
    <p style="color: var(--neutral-50); font-size: 14px; line-height: 1.6; margin-bottom: 1.5rem; text-align: center;">
        É importante conferir se os drivers de vídeo estão corretamente instalados e atualizados. 
        Caso esteja em dúvida, visite o site do fabricante da sua placa de vídeo abaixo e confira.
    </p>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; max-width: 800px; margin: 0 auto;">
        <div style="text-align: center;">
            <a href="https://www.nvidia.com/drivers" target="_blank" rel="noopener noreferrer" style="display: block; text-decoration: none; transition: transform 0.2s ease;">
                <div style="background: var(--background-card); border-radius: 12px; padding: 1.5rem; border: 2px solid var(--neutral-300); transition: all 0.2s ease; height: 100%;">
                    <img src="<?= public_path('images/drivers/nvidia.png') ?>" alt="NVIDIA Drivers" style="max-width: 100%; height: auto; margin-bottom: 1rem; display: block;">
                    <p style="color: var(--white); font-weight: 600; font-size: 14px; margin: 0;">NVIDIA</p>
                </div>
            </a>
        </div>
        <div style="text-align: center;">
            <a href="https://www.amd.com/support" target="_blank" rel="noopener noreferrer" style="display: block; text-decoration: none; transition: transform 0.2s ease;">
                <div style="background: var(--background-card); border-radius: 12px; padding: 1.5rem; border: 2px solid var(--neutral-300); transition: all 0.2s ease; height: 100%;">
                    <img src="<?= public_path('images/drivers/amd-radeon.png') ?>" alt="AMD Radeon Drivers" style="max-width: 100%; height: auto; margin-bottom: 1rem; display: block;">
                    <p style="color: var(--white); font-weight: 600; font-size: 14px; margin: 0;">AMD Radeon</p>
                </div>
            </a>
        </div>
        <div style="text-align: center;">
            <a href="https://www.intel.com/content/www/us/en/download-center/home.html" target="_blank" rel="noopener noreferrer" style="display: block; text-decoration: none; transition: transform 0.2s ease;">
                <div style="background: var(--background-card); border-radius: 12px; padding: 1.5rem; border: 2px solid var(--neutral-300); transition: all 0.2s ease; height: 100%;">
                    <img src="<?= public_path('images/drivers/intel-hd-graphics.jpg') ?>" alt="Intel HD Graphics Drivers" style="max-width: 100%; height: auto; margin-bottom: 1rem; display: block;">
                    <p style="color: var(--white); font-weight: 600; font-size: 14px; margin: 0;">Intel HD Graphics</p>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.drive a:hover > div {
    transform: translateY(-4px);
    border-color: var(--red-100);
    box-shadow: 0 4px 12px rgba(192, 34, 34, 0.3);
}
</style>