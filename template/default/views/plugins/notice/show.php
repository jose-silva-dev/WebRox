<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    <?= $notice->title ?>
</div>

<div class="post-content">
    <div class="post-body">
        <?= $notice->body ?>
    </div>
    <div class="post-created">
        <p class="post_created_name">
            <?= $notice->author ?>
        </p>
        <p class="post_created_date">
            <?= dateHuman($notice->date) ?>
        </p>
    </div>
</div>

<?php if ($notice->active_comment): ?>
    <?= $this->insert('plugins/notice/comments', ['notice' => $notice, 'comments' => $comments]) ?>
<?php endif; ?>