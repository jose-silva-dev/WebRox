<?= $this->layout('components/layouts/web') ?>


<div class="web-title">
    <?= __("user.create_ticket") ?>
</div>

<div class="go_back">
    <a href="<?= route("user.ticket") ?>"><?= __("user.back") ?></a>
</div>

<form action="<?= route("user.ticket.store") ?>" class="form" method="POST">
    <?= csrf_field() ?>
    <div>
        <label for="title"><?= __("auth.ticket_subject") ?></label>
        <input type="text" id="title" name="title" required maxlength="80">
    </div>

    <div>
        <label for="content"><?= __("auth.ticket_message") ?></label>

        <textarea id="content" name="content" required maxlength="2000"></textarea>
    </div>

    <div>
        <button type="submit"><?= __("auth.send") ?></button>
    </div>
</form>