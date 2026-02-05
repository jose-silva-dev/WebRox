<?= $this->layout('components/layouts/web') ?>

<div class="content-page">
    <header class="content-page-header">
        <h1 class="content-page-title"><?= __("page.rules") ?></h1>
        <div class="accent-line"></div>
    </header>

    <section class="content-page-section">
        <div class="card content-page-card">
            <div class="content-page-body">
                <?php
                $rulesContent = config('rules.content') ?? '';
                if (!empty(trim($rulesContent))):
                ?>
                    <div class="content-page-prose">
                        <?= nl2br(htmlspecialchars($rulesContent)) ?>
                    </div>
                <?php else: ?>
                    <p class="content-page-empty"><?= __("page.rules_placeholder") ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
