<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    Ops!
</div>

<div class="error">
    <?php if ($data['error'] == 404): ?>
        <h1>Erro 404</h1>
        <p> Página não encontrada.</p>
    <?php elseif ($data['error'] == 500): ?>
        <h1>Erro 500</h1>
        <p> Erro interno do servidor.</p>
    <?php elseif ($data['error'] == 403): ?>
        <h1>Erro 403</h1>
        <p> Acesso negado.</p>
    <?php elseif ($data['error'] == 305): ?>
        <h1>Erro 305</h1>
        <p> Redirecionamento necessário.</p>
    <?php else: ?>
        <h1>Erro desconhecido</h1>
        <p> <?php echo $data['error']; ?></p>
    <?php endif; ?>
</div>