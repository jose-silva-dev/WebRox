<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Suporte
</div>

<div class="go_back">
    <a href="<?= route("user.ticket.create") ?>">Abrir novo chamado</a>
</div>

<div class="web-sub-title">
    Chamados em aberto
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($opens): ?>
            <?php foreach ($opens as $ticket): ?>
                <tr>
                    <td align="center"><?= $ticket->id ?></td>
                    <td align="center"><?= $ticket->title ?></td>
                    <td align="center"><?= formatedStatus($ticket->status) ?></td>
                    <td align="center">
                        <a href="<?= route("user.ticket.show.{$ticket->id}") ?>">Visualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="warning" style="margin: 0; background: transparent; border: none; padding: 1rem;">
                    Nenhum chamado aberto
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="web-sub-title">
    Chamados Respondidos
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($answered): ?>
            <?php foreach ($answered as $ticket): ?>
                <tr>
                    <td align="center"><?= e((string)$ticket->id) ?></td>
                    <td align="center"><?= e($ticket->title) ?></td>
                    <td align="center"><?= e(formatedStatus($ticket->status)) ?></td>
                    <td align="center">
                        <a href="<?= route("user.ticket.show.{$ticket->id}") ?>">Visualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="warning" style="margin: 0; background: transparent; border: none; padding: 1rem;">
                    Nenhum chamado respondido
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="web-sub-title">
    Chamados resolvidos
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resolved): ?>
            <?php foreach ($resolved as $ticket): ?>
                <tr>
                    <td align="center"><?= e((string)$ticket->id) ?></td>
                    <td align="center"><?= e($ticket->title) ?></td>
                    <td align="center"><?= e(formatedStatus($ticket->status)) ?></td>
                    <td align="center">
                        <a href="<?= route("user.ticket.show.{$ticket->id}") ?>">Visualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="warning" style="margin: 0; background: transparent; border: none; padding: 1rem;">
                    Nenhum chamado resolvido
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>