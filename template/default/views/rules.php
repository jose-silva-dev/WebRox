<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    Regras do Jogo
</div>

<div class="form" style="padding: 1rem;">
    <?php 
    $rulesContent = config('rules.content') ?? '';
    if (!empty($rulesContent)): 
    ?>
        <div style="color: var(--neutral-50); line-height: 1.8; margin: 0; padding: 0;">
            <?= nl2br(htmlspecialchars($rulesContent)) ?>
        </div>
    <?php else: ?>
        <p style="color: var(--neutral-50); line-height: 1.8;">
            As regras do jogo serão configuradas aqui.
        </p>
    <?php endif; ?>
</div>



