<?= $this->layout('components/layouts/admin') ?>
<?= $this->start('styles'); ?>
<link href="<?= assets("css/summernote-lite.min.css", "admin") ?>" rel="stylesheet">
<?= $this->end(); ?>

<div class="space-y-1">
    <h1 class="title">Adicionar Notícia</h1>

    <a href="<?= route("admin.notice") ?>" class="btn btn-primary"><i class="ph ph-list"></i> Todas as notíciais</a>

    <form action="<?= route("admin.notice.store") ?>" method="post" class="form space-y-2">
        <div>
            <label for="title">Título</label>
            <input type="text" name="title" id="title" placeholder="Digite o título da notícia" required>
        </div>

        <div>
            <label for="description">Descrição</label>
            <input type="text" name="description" id="description" placeholder="Digite a descrição da notícia" required>
        </div>

        <div>
            <label for="body">Conteúdo</label>
            <textarea name="body" id="body" placeholder="Digite o conteúdo da notícia" required></textarea>
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