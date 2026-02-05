<?= $this->layout('components/layouts/admin') ?>


<div class="title">
    Assunto: <?= $ticket->title ?>
</div>

<a href="<?= route("admin.ticket") ?>" class="btn btn-primary"><i class="ph ph-list"></i> Todos os tickets</a>


<div x-data="{ showAnswerForm: false }">
    <div class="topic">
        <div class="topic-content">
            <p><?= $ticket->content ?></p>
            <span>Status: <?= formatedStatus($ticket->status) ?> | Criado em: <?= dateHuman($ticket->created_at) ?></span>
        </div>
    </div>

    <div class="button-answer">
        <button @click="showAnswerForm = true" class="btn btn-primary">Adicionar nova resposta</button>
    </div>

    <div class="form-answer" :class="{'show': showAnswerForm}">
        <div class="form-answer-content space-y-1">
            <button type="button" class="btn btn-danger" @click="showAnswerForm = false">Fechar</button>
            <div class="sub-title">
                Responder
            </div>
            <form action="<?= route("admin.ticket.{$ticket->id}.reply") ?>" method="post" class="form space-y-1">
                <input type="hidden" name="id" value="<?= $ticket->id ?>">
                <textarea name="answer" id="" cols="30" rows="10" ></textarea>
                <button type="submit" class="btn btn-danger">Enviar</button>
            </form>
        </div>
    </div>
</div>

<div class="answers space-y-1">
    <div class="sub-title">
        Respostas
    </div>

    <?php if ($answers): ?>
        <?php foreach ($answers as $answer): ?>
            <div class="answer">
                <div class="answer-content">
                    <p><?= $answer->body ?></p>
                </div>
                <div class="answer-info">
                    <span>Respondido por: <?= $answer->account ?> | <?= dateHuman($answer->created_at) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="answer">
            <div class="answer-content">
                <p>Não há respostas para este chamado.</p>
            </div>
        </div>
    <?php endif; ?>
</div>