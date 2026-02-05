<?= $this->layout('components/layouts/admin') ?>
<?= $this->start('styles'); ?>
<link href="<?= assets("css/summernote-lite.min.css", "admin") ?>" rel="stylesheet">
<link href="<?= assets("css/summernote-admin-dark.css", "admin") ?>" rel="stylesheet">
<?= $this->end(); ?>

<div class="adm-page">
    <header class="adm-page__header">
        <h1 class="adm-page__title">Editar Notícia</h1>
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

    <form action="<?= route("admin.notice.update.{$notice->id}") ?>" method="post" class="form space-y-2" enctype="multipart/form-data">
        <?php if (!empty($fromPlugin)): ?>
            <input type="hidden" name="from_plugin" value="notice">
        <?php endif; ?>
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title" value="<?= $notice->title ?>"  required>
        </div>

        <div>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" value="<?= $notice->description ?>"  required>
        </div>

        <div class="form-group">
            <label for="image">Imagem da notícia</label>
            <?php if (!empty($notice->image)): ?>
                <div class="settings-preview" style="margin-bottom: 12px;">
                    <span class="settings-preview__label">Imagem atual</span>
                    <div class="settings-preview__frame">
                        <img src="<?= function_exists('public_path') ? public_path($notice->image) : $notice->image ?>" alt="" style="max-width: 280px; max-height: 160px; object-fit: contain;" onerror="this.parentElement.style.display='none'">
                    </div>
                </div>
            <?php endif; ?>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp">
        </div>

        <div>
            <label for="video">Vídeo (URL) - Opcional</label>
            <input type="url" name="video" id="video" value="<?= $notice->video ?? '' ?>" >
        </div>

        <div>
            <label for="body">Conteúdo</label>
            <textarea name="body" id="body"  required><?= $notice->body ?></textarea>
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