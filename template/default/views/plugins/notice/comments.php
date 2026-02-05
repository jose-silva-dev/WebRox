<section class="notice-show-comments">
    <h2 class="notice-section-title"><?= __("notice.comments") ?></h2>
    <?php if (!empty($comments)): ?>
        <div class="notice-show-comments-list">
            <?php foreach ($comments as $comment): ?>
                <div class="notice-show-comment">
                    <div class="notice-show-comment-content">
                        <?= $comment->body ?>
                    </div>
                    <div class="notice-show-comment-meta">
                        <span class="notice-show-comment-author"><?= e($comment->user_name) ?></span>
                        <span class="notice-show-comment-date"><i class="ph ph-clock"></i> <?= e(dateHuman($comment->date)) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="notice-section-empty"><?= __("notice.no_comments") ?></p>
    <?php endif; ?>

    <?php if (user()): ?>
        <div class="notice-show-comment-form-card">
            <h3 class="notice-show-comment-form-title"><?= __("notice.write_comment") ?></h3>
            <form action="<?= route("/notice/{$notice->slug}/comment") ?>" method="post" class="form">
                <?= csrf_field() ?>
                <div>
                    <label for="notice-comment-body"><?= __("notice.your_message") ?></label>
                    <textarea id="notice-comment-body" name="body" rows="4" placeholder="<?= htmlspecialchars(__("notice.comment_placeholder")) ?>" required minlength="3" maxlength="2000"></textarea>
                </div>
                <div class="notice-show-form-actions">
                    <button type="submit" class="btn btn-primary"><i class="ph ph-paper-plane-tilt"></i> <?= __("auth.send") ?></button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <p class="notice-section-empty"><?= __("notice.login_to_comment") ?></p>
    <?php endif; ?>
</section>
