<?= $this->layout('components/layouts/web') ?>

<div class="downloads-page">
    <header class="downloads-page-header">
        <h1 class="downloads-page-title"><?= __("download.title") ?></h1>
        <div class="accent-line"></div>
        <p class="downloads-page-subtitle">
            <?= __("download.subtitle") ?>
        </p>
    </header>

    <?php
    $hasMain = !empty($downloads);
    $hasAdditional = !empty($additionalDownloads);
    $hasAny = $hasMain || $hasAdditional;
    ?>

    <section class="downloads-section">
        <h2 class="downloads-section-title"><?= __("download.client_section") ?></h2>
        <?php if ($hasMain): ?>
            <div class="downloads-grid">
                <?php foreach ($downloads as $item):
                    $title = $item->title ?? '';
                    $description = $item->description ?? '';
                    $link = $item->link ?? '#';
                    $size = $item->size ?? '';
                    $iconClass = !empty($item->icon) && preg_match('/^ph\s+ph-[a-z0-9-]+$/i', trim($item->icon)) ? trim($item->icon) : 'ph ph-package';
                    ?>
                    <article class="download-card">
                        <div class="download-card-icon">
                            <i class="<?= htmlspecialchars($iconClass) ?>"></i>
                        </div>
                        <div class="download-card-body">
                            <h3 class="download-card-title"><?= htmlspecialchars($title) ?></h3>
                            <?php if ($description !== ''): ?>
                                <p class="download-card-desc"><?= htmlspecialchars($description) ?></p>
                            <?php endif; ?>
                            <?php if ($size !== ''): ?>
                                <p class="download-card-meta"><i class="ph ph-hard-drives"></i> <?= htmlspecialchars($size) ?></p>
                            <?php endif; ?>
                            <a href="<?= htmlspecialchars($link) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary download-card-btn">
                                <i class="ph ph-download-simple"></i> <?= __("download.download_btn") ?>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="downloads-section-empty"><?= __("download.no_downloads") ?></p>
        <?php endif; ?>
    </section>

    <section class="downloads-section">
        <h2 class="downloads-section-title"><?= __("download.additional_section") ?></h2>
        <?php if ($hasAdditional): ?>
            <div class="downloads-grid">
                <?php foreach ($additionalDownloads as $item):
                    $title = $item->title ?? '';
                    $description = $item->description ?? '';
                    $link = $item->link ?? '#';
                    $size = $item->size ?? '';
                    $iconClass = !empty($item->icon) && preg_match('/^ph\s+ph-[a-z0-9-]+$/i', trim($item->icon)) ? trim($item->icon) : 'ph ph-file-zip';
                    ?>
                    <article class="download-card">
                        <div class="download-card-icon">
                            <i class="<?= htmlspecialchars($iconClass) ?>"></i>
                        </div>
                        <div class="download-card-body">
                            <h3 class="download-card-title"><?= htmlspecialchars($title) ?></h3>
                            <?php if ($description !== ''): ?>
                                <p class="download-card-desc"><?= htmlspecialchars($description) ?></p>
                            <?php endif; ?>
                            <?php if ($size !== ''): ?>
                                <p class="download-card-meta"><i class="ph ph-hard-drives"></i> <?= htmlspecialchars($size) ?></p>
                            <?php endif; ?>
                            <a href="<?= htmlspecialchars($link) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary download-card-btn">
                                <i class="ph ph-download-simple"></i> <?= __("download.download_btn") ?>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="downloads-section-empty"><?= __("download.no_downloads") ?></p>
        <?php endif; ?>
    </section>

    <?php if (!empty($requirements)): ?>
            <section class="downloads-requirements">
                <h2 class="downloads-section-title"><?= __("download.requirements_title") ?></h2>
                <div class="downloads-requirements-card">
                    <div class="downloads-requirements-grid">
                        <div class="downloads-req-item downloads-req-header">
                            <span class="downloads-req-label"><?= __("download.component") ?></span>
                            <span class="downloads-req-min"><?= __("download.minimum") ?></span>
                            <span class="downloads-req-rec"><?= __("download.recommended") ?></span>
                        </div>
                        <div class="downloads-req-item">
                            <span class="downloads-req-label"><?= __("download.cpu") ?></span>
                            <span class="downloads-req-min"><?= htmlspecialchars($requirements['cpu_min'] ?? '-') ?></span>
                            <span class="downloads-req-rec"><?= htmlspecialchars($requirements['cpu_recommended'] ?? '-') ?></span>
                        </div>
                        <div class="downloads-req-item">
                            <span class="downloads-req-label"><?= __("download.ram") ?></span>
                            <span class="downloads-req-min"><?= htmlspecialchars($requirements['ram_min'] ?? '-') ?></span>
                            <span class="downloads-req-rec"><?= htmlspecialchars($requirements['ram_recommended'] ?? '-') ?></span>
                        </div>
                        <div class="downloads-req-item">
                            <span class="downloads-req-label"><?= __("download.os") ?></span>
                            <span class="downloads-req-min"><?= htmlspecialchars($requirements['os_min'] ?? '-') ?></span>
                            <span class="downloads-req-rec"><?= htmlspecialchars($requirements['os_recommended'] ?? '-') ?></span>
                        </div>
                        <div class="downloads-req-item">
                            <span class="downloads-req-label"><?= __("download.video") ?></span>
                            <span class="downloads-req-min"><?= htmlspecialchars($requirements['video_min'] ?? '-') ?></span>
                            <span class="downloads-req-rec"><?= htmlspecialchars($requirements['video_recommended'] ?? '-') ?></span>
                        </div>
                    </div>
                </div>
            </section>
    <?php endif; ?>
</div>
