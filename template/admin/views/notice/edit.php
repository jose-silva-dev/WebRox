<?= $this->layout('components/layouts/admin') ?>
<?= $this->start('styles'); ?>
<link href="<?= assets("css/summernote-lite.min.css", "admin") ?>" rel="stylesheet">
<?= $this->end(); ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">Editar Notícia</h1>
        <?php if (!empty($fromPlugin)): ?>
            <a href="<?= route("admin/plugins/manage?plugin=notice") ?>" class="btn btn-secondary">
                <i class="ph ph-arrow-left"></i> Voltar ao Plugin
            </a>
        <?php else: ?>
            <a href="<?= route("admin.notice") ?>" class="btn btn-secondary">
                <i class="ph ph-arrow-left"></i> Voltar
            </a>
        <?php endif; ?>
    </div>

    <form action="<?= route("admin.notice.update.{$notice->id}") ?>" method="post" class="form space-y-2">
        <?php if (!empty($fromPlugin)): ?>
            <input type="hidden" name="from_plugin" value="notice">
        <?php endif; ?>
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title" value="<?= $notice->title ?>" placeholder="Digite o título da notícia" required>
        </div>

        <div>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" value="<?= $notice->description ?>" placeholder="Digite a descrição da notícia" required>
        </div>

        <div>
            <label for="image">Imagem (URL) - Opcional</label>
            <input type="url" name="image" id="image" value="<?= $notice->image ?? '' ?>" placeholder="https://exemplo.com/imagem.jpg">
        </div>

        <div>
            <label for="video">Vídeo (URL) - Opcional</label>
            <input type="url" name="video" id="video" value="<?= $notice->video ?? '' ?>" placeholder="https://www.youtube.com/watch?v=... ou https://exemplo.com/video.mp4">
        </div>

        <div>
            <label for="body">Conteúdo</label>
            <textarea name="body" id="body" placeholder="Digite o conteúdo da notícia" required><?= $notice->body ?></textarea>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="active_comment" id="active_comment" <?= $notice->active_comment ? "checked" : "" ?>>
            <label for="active_comment">Permitir comentários</label>
        </div>
        <div>
            <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Atualizar</button>
        </div>
    </form>
</div>

<?= $this->start('scripts'); ?>

<script src="<?= assets("js/summernote-lite.min.js", "admin") ?>"></script>
<script src="<?= assets("js/summernote-ptbr.min.js", "admin") ?>"></script>

<script>
    $(document).ready(function() {
        $('#body').summernote({
            placeholder: 'Digite aqui o conteúdo',
            height: 300,
            lang: 'pt-BR',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', ]]
            ]
        });
    });
</script>
<?= $this->end(); ?>