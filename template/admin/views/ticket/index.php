<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <h1 class="title">Tickets</h1>
    <div class="space-y-2">
        <div class="sub-title">Tickets Abertos</div>
        <?php if ($opens): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Usuário</th>
                        <th>Criado Em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($opens as $ticket): ?>
                        <tr class="ticket space-y-1">
                            <td><?= $ticket->title ?></td>
                            <td><?= $ticket->account ?></td>
                            <td><?= resolve("Geral")->getFormatDate($ticket->created_at, "d/m/Y H:i") ?></td>
                            <td class="action">
                                <a href="<?= route("admin.ticket.show.{$ticket->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Responder</a>
                                <a href="<?= route("admin.ticket.resolve.{$ticket->id}") ?>" class="btn btn-success"><i class="ph ph-check-circle"></i> Marcar como resolvido</a>
                                <a href="<?= route("admin.ticket.delete.{$ticket->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="warning">Nenhum ticket aberto encontrado.</p>
        <?php endif; ?>

        <div class="sub-title">Tickets Respondidos</div>
        <?php if ($answered): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Usuário</th>
                        <th>Criado Em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($answered as $ticket): ?>
                        <tr class="ticket space-y-1">
                            <td><?= $ticket->title ?></td>
                            <td><?= $ticket->account ?></td>
                            <td><?= resolve("Geral")->getFormatDate($ticket->created_at, "d/m/Y H:i") ?></td>
                            <td class="action">
                                <a href="<?= route("admin.ticket.show.{$ticket->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Responder</a>
                                <a href="<?= route("admin.ticket.resolve.{$ticket->id}") ?>" class="btn btn-success"><i class="ph ph-check-circle"></i> Marcar como resolvido</a>
                                <a href="<?= route("admin.ticket.delete.{$ticket->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="warning">Nenhum ticket respondido encontrado.</p>
        <?php endif; ?>

        <div class="sub-title">Tickets Resolvidos</div>
        <?php if ($resolved): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Usuário</th>
                        <th>Criado Em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resolved as $ticket): ?>
                        <tr class="ticket space-y-1">
                            <td><?= $ticket->title ?></td>
                            <td><?= $ticket->account ?></td>
                            <td><?= resolve("Geral")->getFormatDate($ticket->created_at, "d/m/Y H:i") ?></td>
                            <td class="action">
                                <a href="<?= route("admin.ticket.show.{$ticket->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i> Responder</a>
                                <a href="<?= route("admin.ticket.delete.{$ticket->id}") ?>" class="btn btn-danger" title="Deletar"><i class="ph ph-x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="warning">Nenhum ticket resolvido encontrado.</p>
        <?php endif; ?>
    </div>

</div>