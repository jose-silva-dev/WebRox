<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    Termos de Uso
</div>

<div class="form" style="padding: 1rem;">
    <?php 
    $termsContent = config('terms.content') ?? '';
    if (!empty($termsContent)): 
    ?>
        <div style="color: var(--neutral-50); line-height: 1.8; margin: 0; padding: 0;">
            <?= nl2br(htmlspecialchars($termsContent)) ?>
        </div>
    <?php else: ?>
        <p style="color: var(--neutral-50); line-height: 1.8;">
            Os termos de uso serão configurados aqui.
        </p>
    <?php endif; ?>
</div>



