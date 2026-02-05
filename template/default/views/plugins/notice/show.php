<?= $this->layout('components/layouts/web') ?>

<div class="notice-page notice-show-page">
    <header class="notice-page-header">
        <a href="<?= route('notices') ?>" class="notice-show-back">
            <i class="ph ph-arrow-left"></i> <?= __("notice.back_to_list") ?>
        </a>
        <h1 class="notice-page-title"><?= e($notice->title) ?></h1>
        <div class="accent-line"></div>
        <p class="notice-show-meta">
            <span class="notice-show-author"><i class="ph ph-user"></i> <?= e($notice->author) ?></span>
            <span class="notice-show-date"><i class="ph ph-clock"></i> <?= e(dateHuman($notice->date)) ?></span>
        </p>
    </header>

    <section class="notice-show-topic">
        <?php if (!empty($notice->image)): ?>
            <div class="notice-show-image">
                <img src="<?= htmlspecialchars(function_exists('public_path') ? public_path($notice->image) : $notice->image) ?>" alt="<?= htmlspecialchars($notice->title) ?>">
            </div>
        <?php endif; ?>

        <?php if (!empty($notice->video)): ?>
            <div class="notice-show-video">
                <?php
                $videoUrl = trim($notice->video);
                $isYouTube = false;
                $videoId = '';
                $embedUrl = '';
                if (preg_match('/youtube\.com|youtu\.be/', $videoUrl)) {
                    $isYouTube = true;
                    if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                        $videoId = $matches[1];
                    } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                        $videoId = $matches[1];
                    } elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                        $videoId = $matches[1];
                    }
                    if (!empty($videoId)) {
                        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                    } else {
                        $isYouTube = false;
                    }
                }
                ?>
                <?php if ($isYouTube && !empty($embedUrl)): ?>
                    <div class="notice-show-video-wrap">
                        <button type="button" class="notice-show-video-btn" onclick="openVideoPopup('<?= htmlspecialchars($videoId) ?>', '<?= htmlspecialchars($embedUrl) ?>')" aria-label="<?= __("common.watch_video") ?>">
                            <i class="ph ph-play-circle"></i>
                            <span><?= __("common.watch_video") ?></span>
                        </button>
                    </div>
                    <div class="video-popup" id="video-popup-<?= htmlspecialchars($videoId) ?>">
                        <div class="video-popup-content">
                            <div class="video-popup-header">
                                <span><?= __("common.video") ?></span>
                                <button type="button" class="video-popup-close" onclick="closeVideoPopup('<?= htmlspecialchars($videoId) ?>')" aria-label="<?= __("common.close_label") ?>"><i class="ph ph-x"></i></button>
                            </div>
                            <div class="video-popup-body">
                                <iframe id="video-iframe-<?= htmlspecialchars($videoId) ?>" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen title="Vídeo"></iframe>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <video controls preload="metadata" class="notice-show-video-native">
                        <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/mp4">
                        <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/webm">
                        <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/ogg">
                        <a href="<?= htmlspecialchars($videoUrl) ?>" target="_blank" rel="noopener"><?= __("common.open_video") ?></a>
                    </video>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="notice-show-topic-content">
            <?= $notice->body ?>
        </div>
        <div class="notice-show-topic-meta">
            <span class="notice-show-topic-author"><i class="ph ph-user"></i> <?= e($notice->author) ?></span>
            <span class="notice-show-topic-date"><i class="ph ph-clock"></i> <?= e(dateHuman($notice->date)) ?></span>
        </div>
    </section>

    <?php if ($notice->active_comment): ?>
        <?= $this->insert('plugins/notice/comments', ['notice' => $notice, 'comments' => $comments]) ?>
    <?php endif; ?>
</div>

<script>
function openVideoPopup(videoId, embedUrl) {
    var popup = document.getElementById('video-popup-' + videoId);
    var iframe = document.getElementById('video-iframe-' + videoId);
    if (popup && iframe) {
        iframe.src = embedUrl;
        popup.classList.add('show');
    }
}
function closeVideoPopup(videoId) {
    var popup = document.getElementById('video-popup-' + videoId);
    var iframe = document.getElementById('video-iframe-' + videoId);
    if (popup && iframe) {
        popup.classList.remove('show');
        iframe.src = '';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.video-popup').forEach(function(popup) {
        popup.addEventListener('click', function(e) {
            if (e.target === this) {
                var id = this.id.replace('video-popup-', '');
                closeVideoPopup(id);
            }
        });
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            var openPopup = document.querySelector('.video-popup.show');
            if (openPopup) closeVideoPopup(openPopup.id.replace('video-popup-', ''));
        }
    });
});
</script>
