<h3 class="web-sub-title">Comentários</h3>
<div class="post_comments space-y-1">
    <?php if ($comments): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="post_comment">
                <?= $comment->body ?>
                <div class="bottom">
                    <p class="post_comment_name">
                        <?= $comment->user_name ?>
                    </p>
                    <p class="post_comment_created">
                        <?= dateHuman($comment->date) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="warning">Não há comentários no momento.</p>
    <?php endif; ?>
</div>

<?php if (user()): ?>
    <form action="<?= route("/notice/{$notice->slug}/comment") ?>" class="form" method="post">
        <textarea name="body" placeholder="Write a comment..."></textarea>
        <button type="submit">Send</button>
    </form>
<?php else: ?>
    <p class="warning">Você precisa estar logado para comentar.</p>
<?php endif; ?>