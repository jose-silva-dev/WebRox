<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    Equipe <?= config('server.name') ?>
</div>

<div class="warning">
    <p>
        A equipe <?= config('server.name') ?> é composta por jogadores que se dedicam ao servidor, fornecendo suporte, assistência e contribuições para o crescimento do servidor.
    </p>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th align="center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($staffs = resolve('Geral')->getStaffs()): ?>
            <?php foreach ($staffs as $data): ?>
                <tr>
                    <td width="50%"><?= $data['name'] ?></td>
                    <td align="center"><span class="text-<?= $data['status'] == 'online' ? 'success' : 'danger' ?>"><?= ucfirst($data['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="warning" style="margin: 0; background: transparent; border: none; padding: 1rem;">
                    Nenhum staff encontrado
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>