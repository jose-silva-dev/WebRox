<?= !isAjax() ? $this->layout('_layout') : ''; ?>

<div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6 space-y-6">

    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Adicionar Novo Slider</h2>
        <form action="<?= url('padmin/sliders/store') ?>" method="POST" enctype="multipart/form-data" class="p-4 border border-dashed rounded-lg flex flex-col md:flex-row items-center gap-4">
            <div class="flex-grow w-full">
                <label for="slider-image" class="block text-sm font-medium text-gray-700 mb-1">Imagem do Slider</label>
                <input type="file" id="slider-image" name="image" class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-amber-50 file:text-amber-700
                    hover:file:bg-amber-100" required />
                <p class="text-xs text-gray-500 mt-1">PNG, JPG ou WEBP.</p>
            </div>
            <button type="submit" class="w-full md:w-auto mt-4 md:mt-0 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-lg flex items-center justify-center gap-2 transition-colors">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Adicionar</span>
            </button>
        </form>
    </div>

    <hr>

    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Gerenciar Sliders Atuais</h2>
        <?php if ($sliders): ?>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <?php foreach ($sliders as $slider): ?>

                    <div class="group relative rounded-lg overflow-hidden border">
                        <img src="<?= resources('slider/' . $slider->image) ?>" alt="Slider 1" class="w-full h-40 object-cover">
                        <form action="<?= url('padmin/sliders/delete/' . $slider->id) ?>" method="POST" class="absolute top-2 right-2">
                            <button type="submit" class="bg-black/50 hover:bg-red-600 p-2 rounded-full transition-colors" aria-label="Excluir slider">
                                <i data-lucide="trash" class="w-5 h-5 text-white"></i>
                            </button>
                        </form>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Nenhum slider encontrado. Adicione um novo slider acima.</p>
        <?php endif; ?>
    </div>
</div>