<div class="settings-card">
    <h3 class="subtitle">Configurações do Site</h3>
    <div class="settings-field">
        <label>Timezone</label>
        <input type="text"
               name="timezone"
               value="<?= htmlspecialchars($site['timezone']) ?>"
               required>
        <small>Fuso horário do servidor (ex: America/Sao_Paulo, UTC, Europe/London)</small>
    </div>
    <div class="settings-field">
        <label>Licença (Customer Name)</label>
        <input type="text"
               name="license[customer_name]"
               value="<?= htmlspecialchars($license['customer_name'] ?? '') ?>"
              >
        <small>Código de licença fornecido pela desenvolvedora (não altere sem autorização)</small>
    </div>
</div>

<div class="settings-card">
    <h3 class="subtitle">Informações do Site</h3>
    <p class="settings-desc">Escolha se a marca no cabeçalho será texto (título) ou imagem (logo). Descrição pode ser ativada separadamente.</p>
    <?php $brandType = $site['brand_type'] ?? (!empty($site['logo']['enabled']) ? 'logo' : 'title'); ?>
    <div class="settings-field">
        <label class="block">Marca no cabeçalho</label>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 0.875rem;">
                <input type="radio" name="site[brand_type]" value="title" <?= $brandType === 'title' ? 'checked' : '' ?> id="site-brand-type-title">
                <span>Título (texto como marca)</span>
            </label>
            <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 0.875rem;">
                <input type="radio" name="site[brand_type]" value="logo" <?= $brandType === 'logo' ? 'checked' : '' ?> id="site-brand-type-logo">
                <span>Logo (imagem)</span>
            </label>
        </div>
    </div>
    <div id="site-title-group" class="settings-field" style="display: <?= $brandType === 'title' ? 'block' : 'none' ?>;">
        <label>Título do Site</label>
        <input type="text"
               name="site[title][value]"
               value="<?= htmlspecialchars(!empty($site['title']['value']) ? $site['title']['value'] : 'Web Roxmu') ?>"
               id="site-title-value">
        <small>Texto exibido como marca no cabeçalho (quando não for imagem)</small>
    </div>
    <div id="site-logo-group" class="settings-field" style="display: <?= $brandType === 'logo' ? 'block' : 'none' ?>;">
        <label>Caminho do Logo</label>
        <input type="text"
               name="site[logo][value]"
               id="site-logo-value"
               value="<?= htmlspecialchars(!empty($site['logo']['value']) ? $site['logo']['value'] : 'images/logo.png') ?>"
               >
        <small>Caminho relativo ao diretório de assets. Ou envie uma nova imagem abaixo.</small>
        <div class="settings-field" style="margin-top: 0.5rem;">
            <label>Enviar nova imagem (substitui o logo atual)</label>
            <input type="file" name="site_logo_upload" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp">
            <small>Formatos: PNG, JPG, GIF, WebP.</small>
        </div>
        <?php if (!empty($site['logo']['value']) && function_exists('assets')): ?>
            <div style="margin-top: 0.5rem;"><span class="small" style="font-size: 0.7rem;">Preview:</span>
                <div style="margin-top: 4px;"><img src="<?= assets($site['logo']['value']) ?>?v=<?= time() ?>" alt="Logo" style="max-height: 50px; max-width: 160px; object-fit: contain; border: 1px solid var(--border-color); border-radius: 4px;" onerror="this.style.display='none'"></div>
            </div>
        <?php endif; ?>
    </div>
    <div class="settings-field">
        <label>
            <input type="hidden" name="site[description][enabled]" value="0">
            <input type="checkbox" name="site[description][enabled]" value="1" <?= !empty($site['description']['enabled']) ? 'checked' : '' ?> id="site-description-enabled">
            Ativar Descrição
        </label>
        <div id="site-description-group" style="display: <?= !empty($site['description']['enabled']) ? 'block' : 'none' ?>;">
            <label>Descrição do Site</label>
            <textarea name="site[description][value]"
                      rows="2"
                      <?= !empty($site['description']['enabled']) ? 'required' : '' ?>><?= htmlspecialchars(!empty($site['description']['value']) ? $site['description']['value'] : '') ?></textarea>
            <small>Descrição exibida no cabeçalho do site</small>
        </div>
    </div>
    <div class="settings-field">
        <label>
            <input type="hidden" name="site[page_title][enabled]" value="0">
            <input type="checkbox" name="site[page_title][enabled]" value="1" <?= !empty($site['page_title']['enabled']) ? 'checked' : '' ?> id="site-page-title-enabled">
            Ativar Título da Página
        </label>
        <div id="site-page-title-group" style="display: <?= !empty($site['page_title']['enabled']) ? 'block' : 'none' ?>;">
            <label>Título da Página (tag &lt;title&gt;)</label>
            <input type="text"
                   name="site[page_title][value]"
                   value="<?= htmlspecialchars(!empty($site['page_title']['value']) ? $site['page_title']['value'] : 'Web Roxmu - Servidor de Mu Online') ?>"
                   <?= !empty($site['page_title']['enabled']) ? 'required' : '' ?>>
            <small>Título exibido na aba do navegador</small>
        </div>
    </div>
    <div class="settings-field">
        <label>
            <input type="hidden" name="site[footer][enabled]" value="0">
            <input type="checkbox" name="site[footer][enabled]" value="1" <?= !empty($site['footer']['enabled']) ? 'checked' : '' ?> id="site-footer-enabled">
            Ativar Footer
        </label>
        <div id="site-footer-group" style="display: <?= !empty($site['footer']['enabled']) ? 'block' : 'none' ?>;">
            <label>Texto do Footer</label>
            <input type="text"
                   name="site[footer][value]"
                   value="<?= htmlspecialchars(!empty($site['footer']['value']) ? $site['footer']['value'] : 'Web Roxmu') ?>"
                   <?= !empty($site['footer']['enabled']) ? 'required' : '' ?>>
            <small>Texto no rodapé (o ano será adicionado automaticamente)</small>
        </div>
    </div>
</div>

<div class="settings-card">
    <h3 class="subtitle">Fontes do site</h3>
    <p class="settings-desc">Nome exato da fonte no Google Fonts. Padrão: Space Grotesk e Inter.</p>
    <div class="grid-2">
        <div class="settings-field">
            <label>Fonte 1 – Site principal</label>
            <input type="text" name="site[font_primary]" value="<?= htmlspecialchars($site['font_primary'] ?? 'Space Grotesk') ?>" >
            <small>Ex.: Space Grotesk</small>
        </div>
        <div class="settings-field">
            <label>Fonte 2 – Site principal</label>
            <input type="text" name="site[font_secondary]" value="<?= htmlspecialchars($site['font_secondary'] ?? 'Inter') ?>" >
            <small>Ex.: Inter</small>
        </div>
        <div class="settings-field">
            <label>Fonte 1 – Admin</label>
            <input type="text" name="site[font_admin_primary]" value="<?= htmlspecialchars($site['font_admin_primary'] ?? 'Space Grotesk') ?>" >
            <small>Ex.: Space Grotesk</small>
        </div>
        <div class="settings-field">
            <label>Fonte 2 – Admin</label>
            <input type="text" name="site[font_admin_secondary]" value="<?= htmlspecialchars($site['font_admin_secondary'] ?? 'Inter') ?>" >
            <small>Ex.: Inter</small>
        </div>
    </div>
</div>

<div class="settings-card">
    <h3 class="subtitle">Requisitos Mínimos do Sistema</h3>
    <p class="settings-desc">Exibidos na página de downloads.</p>
    <div class="grid-2">
        <div class="settings-field">
            <label>CPU - Mínimo</label>
            <input type="text" name="download_requirements[cpu_min]" value="<?= htmlspecialchars(config('download_requirements.cpu_min', 'Single Core - 1.5 Ghz')) ?>" >
        </div>
        <div class="settings-field">
            <label>CPU - Recomendado</label>
            <input type="text" name="download_requirements[cpu_recommended]" value="<?= htmlspecialchars(config('download_requirements.cpu_recommended', 'Dual Core 2.0 Ghz (ou superior)')) ?>" >
        </div>
        <div class="settings-field">
            <label>RAM - Mínimo</label>
            <input type="text" name="download_requirements[ram_min]" value="<?= htmlspecialchars(config('download_requirements.ram_min', '1GB')) ?>" >
        </div>
        <div class="settings-field">
            <label>RAM - Recomendado</label>
            <input type="text" name="download_requirements[ram_recommended]" value="<?= htmlspecialchars(config('download_requirements.ram_recommended', '2GB (ou superior)')) ?>" >
        </div>
        <div class="settings-field">
            <label>OS - Mínimo</label>
            <input type="text" name="download_requirements[os_min]" value="<?= htmlspecialchars(config('download_requirements.os_min', 'Windows 7')) ?>" >
        </div>
        <div class="settings-field">
            <label>OS - Recomendado</label>
            <input type="text" name="download_requirements[os_recommended]" value="<?= htmlspecialchars(config('download_requirements.os_recommended', 'Windows 10 ou 11')) ?>" >
        </div>
        <div class="settings-field">
            <label>Placa de Vídeo - Mínimo</label>
            <input type="text" name="download_requirements[video_min]" value="<?= htmlspecialchars(config('download_requirements.video_min', '128MB / 64 Bits')) ?>" >
        </div>
        <div class="settings-field">
            <label>Placa de Vídeo - Recomendado</label>
            <input type="text" name="download_requirements[video_recommended]" value="<?= htmlspecialchars(config('download_requirements.video_recommended', '256MB / 128 Bits (ou superior)')) ?>" >
        </div>
    </div>
</div>

<div class="settings-card">
    <h3 class="subtitle">Template</h3>
    <div class="settings-field">
        <label>Nome do Tema (pasta)</label>
        <input type="text" name="template[theme]" value="<?= htmlspecialchars($template['theme'] ?? '') ?>" >
        <small>Nome da pasta em <code>template/</code> (ex: default)</small>
    </div>
</div>

<script>
(function() {
    var titleGroup = document.getElementById('site-title-group');
    var logoGroup = document.getElementById('site-logo-group');
    var titleRadio = document.getElementById('site-brand-type-title');
    var logoRadio = document.getElementById('site-brand-type-logo');
    if (titleRadio) titleRadio.addEventListener('change', function() { titleGroup.style.display = 'block'; logoGroup.style.display = 'none'; });
    if (logoRadio) logoRadio.addEventListener('change', function() { titleGroup.style.display = 'none'; logoGroup.style.display = 'block'; });
    var descEnabled = document.getElementById('site-description-enabled');
    var descGroup = document.getElementById('site-description-group');
    if (descEnabled && descGroup) descEnabled.addEventListener('change', function() { descGroup.style.display = this.checked ? 'block' : 'none'; });
    var pageTitleEnabled = document.getElementById('site-page-title-enabled');
    var pageTitleGroup = document.getElementById('site-page-title-group');
    if (pageTitleEnabled && pageTitleGroup) pageTitleEnabled.addEventListener('change', function() { pageTitleGroup.style.display = this.checked ? 'block' : 'none'; });
    var footerEnabled = document.getElementById('site-footer-enabled');
    var footerGroup = document.getElementById('site-footer-group');
    if (footerEnabled && footerGroup) footerEnabled.addEventListener('change', function() { footerGroup.style.display = this.checked ? 'block' : 'none'; });
})();
</script>
