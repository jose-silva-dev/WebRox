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
            <a href="">
                <strong>Nenhuma notícia encontrada</strong>
            </a>
        </li>
    <?php endif; ?>
</ul>