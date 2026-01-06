<ul class="posts">
    <?php if ($notices): ?>
        <?php foreach ($notices as $notice): ?>
            <li>
                <a href="<?= route("notice/{$notice->slug}") ?>">
                    <strong><?= $notice->title ?></strong>
                    <?= $notice->description ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>
            <div class="warning" style="margin: 0;">
                Nenhuma notícia encontrada
            </div>
        </li>
    <?php endif; ?>
</ul>