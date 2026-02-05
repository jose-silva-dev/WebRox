<?= $this->layout('components/layouts/web') ?>

<div class="ticket-page">
    <div class="ticket-page-top">
        <a href="<?= route('user.info') ?>" class="btn-back">
            <i class="ph ph-arrow-left"></i>
            <?= __("user.back") ?>
        </a>
    </div>
    <header class="ticket-page-header">
        <h1 class="ticket-page-title"><?= __("user.support") ?></h1>
        <div class="accent-line"></div>
        <p class="ticket-page-subtitle">
            <?= __("user.support_subtitle") ?>
        </p>
        <a href="javascript:void(0)" onclick="typeof openTicketPopup === 'function' && openTicketPopup(); return false;" class="btn btn-primary ticket-page-cta">
            <i class="ph ph-plus"></i> <?= __("user.open_ticket") ?>
        </a>
    </header>

    <section class="ticket-section">
        <h2 class="ticket-section-title"><?= __("user.tickets_open") ?></h2>
        <?php if (!empty($opens)): ?>
            <div class="ticket-grid">
                <?php foreach ($opens as $ticket): ?>
                    <article class="ticket-card">
                        <div class="ticket-card-header">
                            <span class="ticket-card-id">#<?= (int) $ticket->id ?></span>
                            <span class="ticket-card-status ticket-card-status--open"><?= e(formatedStatus($ticket->status)) ?></span>
                        </div>
                        <h3 class="ticket-card-title"><?= e($ticket->title) ?></h3>
                        <a href="<?= route("user.ticket.show.{$ticket->id}") ?>" class="btn btn-primary ticket-card-btn">
                            <i class="ph ph-eye"></i> <?= __("user.view") ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="ticket-section-empty"><?= __("user.no_open") ?></p>
        <?php endif; ?>
    </section>

    <section class="ticket-section">
        <h2 class="ticket-section-title"><?= __("user.tickets_answered") ?></h2>
        <?php if (!empty($answered)): ?>
            <div class="ticket-grid">
                <?php foreach ($answered as $ticket): ?>
                    <article class="ticket-card">
                        <div class="ticket-card-header">
                            <span class="ticket-card-id">#<?= (int) $ticket->id ?></span>
                            <span class="ticket-card-status ticket-card-status--answered"><?= e(formatedStatus($ticket->status)) ?></span>
                        </div>
                        <h3 class="ticket-card-title"><?= e($ticket->title) ?></h3>
                        <a href="<?= route("user.ticket.show.{$ticket->id}") ?>" class="btn btn-primary ticket-card-btn">
                            <i class="ph ph-eye"></i> <?= __("user.view") ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="ticket-section-empty"><?= __("user.no_answered") ?></p>
        <?php endif; ?>
    </section>

    <section class="ticket-section">
        <h2 class="ticket-section-title"><?= __("user.tickets_closed") ?></h2>
        <?php if (!empty($resolved)): ?>
            <div class="ticket-grid">
                <?php foreach ($resolved as $ticket): ?>
                    <article class="ticket-card">
                        <div class="ticket-card-header">
                            <span class="ticket-card-id">#<?= (int) $ticket->id ?></span>
                            <span class="ticket-card-status ticket-card-status--resolved"><?= e(formatedStatus($ticket->status)) ?></span>
                        </div>
                        <h3 class="ticket-card-title"><?= e($ticket->title) ?></h3>
                        <a href="<?= route("user.ticket.show.{$ticket->id}") ?>" class="btn btn-primary ticket-card-btn">
                            <i class="ph ph-eye"></i> <?= __("user.view") ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="ticket-section-empty"><?= __("user.no_closed") ?></p>
        <?php endif; ?>
    </section>
</div>
