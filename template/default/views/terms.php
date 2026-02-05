<?= $this->layout('components/layouts/web') ?>

<div class="content-page">
    <header class="content-page-header">
        <h1 class="content-page-title"><?= __("page.terms") ?></h1>
        <div class="accent-line"></div>
    </header>

    <section class="content-page-section">
        <div class="card content-page-card">
            <div class="content-page-body">
                <?php
                $termsContent = config('terms.content') ?? '';
                if (!empty(trim($termsContent))):
                ?>
                    <div class="content-page-prose">
                        <?= nl2br(htmlspecialchars($termsContent)) ?>
                    </div>
                <?php else: ?>
                    <p class="content-page-empty"><?= __("page.terms_placeholder") ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
