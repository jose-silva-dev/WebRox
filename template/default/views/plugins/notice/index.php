<?= $this->layout('components/layouts/web') ?>

<section class="notice-list-page">
    <header class="notice-list-header">
        <h1 class="notice-list-title"><?= __("notice.title") ?></h1>
        <p class="notice-list-subtitle"><?= __("notice.subtitle") ?></p>
    </header>

    <?php if (!empty($notices)): ?>
        <div class="notice-list">
            <?php foreach ($notices as $notice): ?>
                <a href="<?= route("notice/{$notice->slug}") ?>" class="notice-card">
                    <?php if (!empty($notice->image)): ?>
                        <div class="notice-card-image">
                            <img src="<?= htmlspecialchars(function_exists('public_path') ? public_path($notice->image) : $notice->image) ?>" alt="<?= htmlspecialchars($notice->title) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="notice-card-body">
                        <h2 class="notice-card-title"><?= htmlspecialchars($notice->title) ?></h2>
                        <?php if (!empty($notice->description)): ?>
                            <p class="notice-card-desc"><?= htmlspecialchars($notice->description) ?></p>
                        <?php endif; ?>
                        <div class="notice-card-meta">
                            <?php if (!empty($notice->author)): ?>
                                <span class="notice-card-author"><i class="ph ph-user"></i> <?= htmlspecialchars($notice->author) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($notice->date)): ?>
                                <span class="notice-card-date"><i class="ph ph-calendar"></i> <?= function_exists('dateHuman') ? dateHuman($notice->date) : date('d/m/Y', strtotime($notice->date)) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="notice-card-arrow"><i class="ph ph-caret-right"></i></span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="notice-list-empty">
            <i class="ph ph-newspaper"></i>
            <p><?= __("notice.none_published") ?></p>
            <a href="<?= route('/') ?>" class="btn btn-secondary"><?= __("notice.back_home") ?></a>
        </div>
    <?php endif; ?>
</section>
