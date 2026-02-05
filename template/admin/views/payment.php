<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Pagamentos</h1>

    <div class="cards">
        <?= $this->insert('components/card', [
            'title' => 'Total de Pagamentos Aprovados',
            'value' => resolve('Geral')->getRealBrazilianPrice($paymentApproved),
            'icon'  => 'ph-check',
        ]) ?>
        <?= $this->insert('components/card', [
            'title' => 'Total de Pagamentos Pendentes',
            'value' => resolve('Geral')->getRealBrazilianPrice($paymentPending),
            'icon'  => 'ph-warning',
        ]) ?>
    </div>

    <?php if ($payments["payments"]): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Banco</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments["payments"] as $payment): ?>
                    <tr class="notice space-y-1">
                        <td><?= resolve('Geral')->getLimit($payment->order_id, 10) ?></td>
                        <td><?= (['MercadoPago' => 'Mercado Pago', 'Stripe' => 'Stripe', 'PayPal' => 'PayPal'])[$payment->bank ?? ''] ?? $payment->bank ?? '—' ?></td>
                        <td><?= resolve('Geral')->getRealBrazilianPrice($payment->price) ?></td>
                        <td class="status"><?= $payment->status == 'approved' ? "<span class='text-success'>Aprovado</span>" : "<span class='text-warning'>Pendente</span>" ?></td>
                        <td><?= resolve('Geral')->getFormatDate($payment->created_at, 'd/m/Y H:i') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($payments['totalPages'] > 1): ?>
            <div class="payment-links">
                <ul>
                    <li><a class="btn btn-primary" href="?page=<?= $payments['prev'] ?>"><i class="ph ph-arrow-left"></i></a></li>
                    <p>
                        Página <?= $page ?> de <?= $payments['totalPages'] ?>
                    </p>
                    <li><a class="btn btn-primary" href="?page=<?= $payments['next'] ?>"><i class="ph ph-arrow-right"></i></a></li>
                </ul>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p class="warning">Nenhum pagamento encontrado.</p>
    <?php endif; ?>
</div>