<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    Assunto: <?= e($ticket->title) ?>
</div>

<div class="go_back">
    <a href="<?= route("user.ticket") ?>">Voltar para chamados</a>
</div>

<div x-data="{ showAnswerForm: false }">
    <div class="topic">
        <div class="topic-content">
            <p><?= e($ticket->content) ?></p>
            <span>Status: <?= e(formatedStatus($ticket->status)) ?> | Criado em: <?= e(dateHuman($ticket->created_at)) ?></span>
        </div>
    </div>

    <?php if ($ticket->status !== "resolved"): ?>
        <div class="button-answer">
            <button @click="showAnswerForm = true">Adicionar nova resposta</button>
        </div>

        <div class="form-answer" :class="{'show': showAnswerForm}" @click.self="showAnswerForm = false">
            <div class="form-answer-content">
                <button type="button" @click="showAnswerForm = false">Fechar</button>
                <div class="web-sub-title">
                    Responder
                </div>
                <form action="<?= route("user.ticket.{$ticket->id}.reply") ?>" method="post" class="form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= e((string)$ticket->id) ?>">
                    <textarea name="answer" id="answer" cols="30" rows="10" placeholder="Digite sua resposta aqui..." required></textarea>
                    <button type="submit" style="padding: 12px 24px; background: var(--red-100); color: var(--white); border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(192, 34, 34, 0.3); width: fit-content;">Enviar</button>
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