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
                <td colspan="4" align="center">Nenhum download encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h4 class="web-sub-title">Downloads Adicionais (não obrigatórios):</h4>
<table class="table">
    <thead>
        <tr>
            <th width="20%">Arquivo</th>
            <th width="60%">Descrição</th>
            <th width="20%">Download</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td align="center">Arquivo 1</td>
            <td align="center">Descrição do Arquivo 1</td>
            <td align="center"><a href="#">Download</a></td>
        </tr>
        <tr>
            <td align="center">Arquivo 2</td>
            <td align="center">Descrição do Arquivo 2</td>
            <td align="center"><a href="#">Download</a></td>
        </tr>
    </tbody>
</table>

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
            <td align="center">Single Core - 1.5 Ghz</td>
            <td align="center">Dual Core 2.0 Ghz (ou superior)</td>
        </tr>
        <tr>
            <td align="center">RAM (Memória)</td>
            <td align="center">1GB</td>
            <td align="center">2GB (ou superior)</td>
        </tr>
        <tr>
            <td align="center">OS (Sistema operacional)</td>
            <td align="center">Windows 7</td>
            <td align="center">Windows 10 ou 11</td>
        </tr>
        <tr>
            <td align="center">Placa de Vídeo</td>
            <td align="center">128MB / 64 Bits</td>
            <td align="center">256MB / 128 Bits (ou superior)</td>
        </tr>
    </tbody>
</table>

<div class="drive">
    <p>
        É importante conferir se os drivers de vídeo estão corretamente instalados e atualizados, caso esteja em dúvida, visite abaixo o site do fabricante da sua placa de vídeo e confira.
    </p>
    <table class="table">
        <thead>
            <tr>
                <th colspan="3">Drivers de vídeo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <a href="">
                        <img src="<?= public_path('images/drivers/nvidia.png') ?>" alt="">
                    </a>
                </td>
                <td>
                    <a href="">
                        <img src="<?= public_path('images/drivers/amd-radeon.png') ?>" alt="">
                    </a>
                </td>
                <td>
                    <a href="">
                        <img src="<?= public_path('images/drivers/intel-hd-graphics.jpg') ?>" alt="">
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>