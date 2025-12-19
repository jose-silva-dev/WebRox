<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Assunto: <?= $ticket->title ?>
</div>

<div class="go_back">
    <a href="<?= route("user.ticket") ?>">Voltar para chamados</a>
</div>

<div x-data="{ showAnswerForm: false }">
    <div class="topic">
        <div class="topic-content">
            <p><?= $ticket->content ?></p>
            <span>Status: <?= formatedStatus($ticket->status) ?> | Criado em: <?= dateHuman($ticket->created_at) ?></span>
        </div>
    </div>

    <div class="button-answer">
        <button @click="showAnswerForm = true">Adicionar nova resposta</button>
    </div>

    <?php if ($ticket->status !== "resolved"): ?>
        <div class="form-answer" :class="{'show': showAnswerForm}">
            <div class="form-answer-content space-y-1">
                <button type="button" @click="showAnswerForm = false">Fechar</button>
                <div class="web-sub-title">
                    Responder
                </div>
                <form action="<?= route("user.ticket.{$ticket->id}.reply") ?>" method="post" class="form">
                    <input type="hidden" name="id" value="<?= $ticket->id ?>">
                    <textarea name="answer" id="" cols="30" rows="10" placeholder="Digite sua resposta aqui..."></textarea>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="answers space-y-1">
    <div class="web-sub-title">
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