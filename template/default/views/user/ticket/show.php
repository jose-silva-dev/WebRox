<?= $this->layout('components/layouts/web') ?>

<div class="ticket-page ticket-show-page">
    <header class="ticket-page-header">
        <a href="<?= route('user.ticket') ?>" class="ticket-show-back">
            <i class="ph ph-arrow-left"></i> Voltar para chamados
        </a>
        <h1 class="ticket-page-title">Chamado #<?= (int) $ticket->id ?></h1>
        <div class="accent-line"></div>
        <p class="ticket-show-meta">
            <span class="ticket-show-status ticket-show-status--<?= e($ticket->status) ?>"><?= e(formatedStatus($ticket->status)) ?></span>
            <span class="ticket-show-date"><i class="ph ph-calendar"></i> <?= e(dateHuman($ticket->created_at)) ?></span>
        </p>
    </header>

    <section class="ticket-show-topic">
        <h2 class="ticket-show-topic-title"><?= e($ticket->title) ?></h2>
        <div class="ticket-show-topic-content">
            <?= $ticket->content ?>
        </div>
    </section>

    <div x-data="{ showAnswerForm: false }">
        <?php if ($ticket->status !== 'resolved'): ?>
            <div class="ticket-show-reply-toggle">
                <button type="button" class="btn btn-primary" @click="showAnswerForm = !showAnswerForm">
                    <i class="ph ph-chat-circle-dots"></i> <span x-text="showAnswerForm ? 'Fechar' : 'Adicionar nova resposta'">Adicionar nova resposta</span>
                </button>
            </div>

            <div class="ticket-show-reply-form" x-show="showAnswerForm" x-transition style="display: none;">
                <div class="ticket-show-card">
                    <h3 class="ticket-show-card-title">Responder</h3>
                    <form action="<?= route("user.ticket.{$ticket->id}.reply") ?>" method="post" class="form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e((string) $ticket->id) ?>">
                        <div>
                            <label for="ticket-answer">Sua mensagem</label>
                            <textarea id="ticket-answer" name="answer" rows="5" placeholder="Digite sua resposta aqui..." required minlength="10" maxlength="2000"></textarea>
                        </div>
                        <div class="ticket-show-form-actions">
                            <button type="button" class="btn" @click="showAnswerForm = false">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Enviar resposta</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <section class="ticket-show-answers">
        <h2 class="ticket-section-title">Respostas</h2>
        <?php if (!empty($answers)): ?>
            <div class="ticket-show-answers-list">
                <?php foreach ($answers as $answer): ?>
                    <div class="ticket-show-answer">
                        <div class="ticket-show-answer-content">
                            <?= $answer->body ?>
                        </div>
                        <div class="ticket-show-answer-meta">
                            <span class="ticket-show-answer-author"><?= $answer->account === user() ? 'Você' : e($answer->account) ?></span>
                            <span class="ticket-show-answer-date"><i class="ph ph-clock"></i> <?= e(dateHuman($answer->created_at)) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="ticket-section-empty">Nenhuma resposta ainda.</p>
        <?php endif; ?>
    </section>
</div>
