<?= $this->layout('components/layouts/admin') ?>
<?= $this->start('styles'); ?>
<link href="<?= assets("css/summernote-lite.min.css", "admin") ?>" rel="stylesheet">
<link href="<?= assets("css/summernote-admin-dark.css", "admin") ?>" rel="stylesheet">
<?= $this->end(); ?>

<div class="adm-page">
    <header class="adm-page__header">
        <h1 class="adm-page__title">Adicionar Notícia</h1>
        <div class="adm-page__actions">
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
    </header>

    <form action="<?= route("admin.notice.store") ?>" method="post" class="form space-y-2" enctype="multipart/form-data">
        <?php if (!empty($fromPlugin)): ?>
            <input type="hidden" name="from_plugin" value="notice">
        <?php endif; ?>
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title"  required>
        </div>

        <div>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description"  required>
        </div>

        <div class="form-group">
            <label for="image">Imagem da notícia</label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp">
        </div>

        <div>
            <label for="video">Vídeo (URL) - Opcional</label>
            <input type="url" name="video" id="video" >
        </div>

        <div>
            <label for="body">Conteúdo</label>
            <textarea name="body" id="body"  required></textarea>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="active_comment" id="active_comment">
            <label for="active_comment">Permitir comentários</label>
        </div>
        <div>
            <button type="submit" class="btn btn-danger"><i class="ph ph-check"></i> Adicionar</button>
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