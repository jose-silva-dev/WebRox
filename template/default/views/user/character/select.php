<?= $this->layout('components/layouts/web') ?>

<style>
    .characters-page {
        max-width: 700px;
        margin: 0 auto;
        padding: 24px;
    }
    .characters-page .page-header {
        margin-bottom: 32px;
    }
    .characters-page .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }
    .characters-page .user-characters {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .characters-page .warning {
        background: var(--yellow-10, rgba(255, 152, 0, 0.1));
        border: 1px solid var(--warning-color, #ff9800);
        border-radius: 8px;
        padding: 16px;
        color: var(--warning-color, #ff9800);
        text-align: center;
        font-size: 14px;
    }
</style>

<div class="characters-page">
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="page-title"><?= __("user.characters_title") ?></div>
                <div class="page-subtitle"><?= __("user.characters_subtitle") ?></div>
            </div>
            <a href="<?= route('user.info') ?>" class="btn-back">
                <i class="ph ph-arrow-left"></i>
                <?= __("user.back") ?>
            </a>
        </div>
    </div>

    <div class="user-characters">
        <?php if (!$characters): ?>
            <p class="warning"><?= __("user.no_characters") ?></p>
        <?php else: ?>
            <?php foreach ($characters as $character): ?>
                <?= $this->insert('components/web/user/box-select-char', [
                    'character' => $character,
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>