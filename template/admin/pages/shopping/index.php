<?= !isAjax() ? $this->layout('_layout') : ''; ?>

<div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6 space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Gerenciar Shoppings
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Adicione, edite ou remova as categorias de shopping do seu servidor.
            </p>
        </div>

        <a href="<?= url("padmin/shoppings/create") ?>"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 border border-transparent rounded-lg shadow-sm 
                      text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 
                      outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Adicionar Shopping</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        <?php if ($shoppings): ?>
            <?php foreach ($shoppings as $shopping): ?>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col transition-all hover:shadow-lg">
                    <div class="p-5 flex-grow">
                        <h3 class="text-lg font-semibold text-gray-800 truncate" title="<?= $shopping->name ?>">
                            <?= $shopping->name ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 h-10 overflow-hidden">
                            <?= $shopping->description ?? 'Nenhuma descrição fornecida.' ?>
                        </p>
                    </div>

                    <div class="p-3 bg-gray-50 border-t border-gray-200 rounded-b-xl flex justify-end items-center gap-2">
                        <a href="<?= url("padmin/shoppings/edit/{$shopping->id}") ?>"
                            class="p-2 text-gray-500 hover:bg-gray-200 hover:text-gray-800 rounded-full transition-colors"
                            title="Editar">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>
                        <a href="<?= url("padmin/shoppings/categories/{$shopping->id}") ?>"
                            class="p-2 text-gray-500 hover:bg-gray-200 hover:text-gray-800 rounded-full transition-colors"
                            title="Categorias">
                            <i data-lucide="logs" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
                <div class="max-w-xs mx-auto">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-800">Nenhum shopping encontrado</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Comece adicionando uma nova categoria de shopping para o seu servidor.
                    </p>
                    <div class="mt-6">
                        <a href="<?= url("padmin/shoppings/create") ?>"
                            class="inline-flex items-center gap-2 px-4 py-2 border border-transparent rounded-md shadow-sm 
                                       text-sm font-medium text-white bg-amber-500 hover:bg-amber-600
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Adicionar Primeiro Shopping
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>