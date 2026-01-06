<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    <?= $notice->title ?>
</div>

<div class="post-content">
    <?php if (!empty($notice->image)): ?>
    <div class="post-image">
        <img src="<?= htmlspecialchars($notice->image) ?>" alt="<?= htmlspecialchars($notice->title) ?>">
    </div>
    <?php endif; ?>

    <?php if (!empty($notice->video)): ?>
    <div class="post-video">
        <?php
        // Detectar se é YouTube e extrair o ID do vídeo
        $videoUrl = trim($notice->video);
        $isYouTube = false;
        $videoId = '';
        $embedUrl = '';
        
        // Verifica se é uma URL do YouTube
        if (preg_match('/youtube\.com|youtu\.be/', $videoUrl)) {
            $isYouTube = true;
            
            // Tenta extrair o ID do vídeo de diferentes formatos
            // Formato: youtube.com/watch?v=ID ou youtube.com/watch?v=ID&list=...
            if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                $videoId = $matches[1];
            }
            // Formato: youtu.be/ID
            elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                $videoId = $matches[1];
            }
            // Formato: youtube.com/embed/ID
            elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                $videoId = $matches[1];
            }
            
            if (!empty($videoId)) {
                // URL simples do embed do YouTube
                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
            } else {
                $isYouTube = false; // Não conseguiu extrair o ID
            }
        }
        ?>
        <?php if ($isYouTube && !empty($embedUrl)): ?>
            <div class="post-video-button" style="text-align: center; margin: 1.5rem 0;">
                <button type="button" class="btn btn-danger" onclick="openVideoPopup('<?= htmlspecialchars($videoId) ?>', '<?= htmlspecialchars($embedUrl) ?>')" style="padding: 12px 24px; font-size: 16px; cursor: pointer;">
                    ▶ Assistir o vídeo
                </button>
            </div>
            
            <!-- Video Popup -->
            <div class="video-popup" id="video-popup-<?= htmlspecialchars($videoId) ?>">
                <div class="video-popup-content">
                    <div class="video-popup-header">
                        <h3>Vídeo</h3>
                        <button type="button" class="video-popup-close" onclick="closeVideoPopup('<?= htmlspecialchars($videoId) ?>')">&times;</button>
                    </div>
                    <div class="video-popup-body">
                        <iframe 
                            id="video-iframe-<?= htmlspecialchars($videoId) ?>"
                            src="" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen
                            title="Vídeo do YouTube">
                        </iframe>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <video controls preload="metadata" style="width: 100%; height: auto; display: block;">
                <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/mp4">
                <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/webm">
                <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/ogg">
                Seu navegador não suporta o elemento de vídeo. 
                <a href="<?= htmlspecialchars($videoUrl) ?>" target="_blank">Clique aqui para baixar o vídeo</a>
            </video>
        <?php endif; ?>
    </div>
    <?php endif; ?>

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

<script>
    function openVideoPopup(videoId, embedUrl) {
        const popup = document.getElementById('video-popup-' + videoId);
        const iframe = document.getElementById('video-iframe-' + videoId);
        if (popup && iframe) {
            iframe.src = embedUrl;
            popup.classList.add('show');
        }
    }
    
    function closeVideoPopup(videoId) {
        const popup = document.getElementById('video-popup-' + videoId);
        const iframe = document.getElementById('video-iframe-' + videoId);
        if (popup && iframe) {
            popup.classList.remove('show');
            // Pausar o vídeo removendo o src
            iframe.src = '';
        }
    }
    
    // Fechar ao clicar fora
    document.addEventListener('DOMContentLoaded', function() {
        const videoPopups = document.querySelectorAll('.video-popup');
        videoPopups.forEach(function(popup) {
            popup.addEventListener('click', function(e) {
                if (e.target === this) {
                    const videoId = this.id.replace('video-popup-', '');
                    closeVideoPopup(videoId);
                }
            });
        });
        
        // Fechar com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openPopup = document.querySelector('.video-popup.show');
                if (openPopup) {
                    const videoId = openPopup.id.replace('video-popup-', '');
                    closeVideoPopup(videoId);
                }
            }
        });
    });
</script>