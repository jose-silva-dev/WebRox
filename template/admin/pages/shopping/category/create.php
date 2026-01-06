<?= !isAjax() ? $this->layout('_layout') : ''; ?>


<div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6 space-y-6">

    <div class="p-6 border-b border-gray-200">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center gap-1.5 text-sm text-gray-500">
                <li>
                    <a href="<?= url('padmin/shoppings') ?>" class="hover:text-amber-600 transition-colors">
                        Shoppings
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="<?= url('padmin/shoppings') ?>" class="hover:text-amber-600 transition-colors">
                        <?= $shopping->name ?>
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <span class="font-medium text-gray-700">Adicionar</span>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">
            Adicionar Nova Categoria
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Preencha o campo abaixo para cadastrar uma nova categoria de shopping.
        </p>
    </div>

    <form action="<?= url("padmin/shoppings/categories/{$shopping->id}/store") ?>" method="POST" class="p-6">
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome do Shopping
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 
                                   outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 
                                   transition-shadow sm:text-sm"
                    placeholder="Ex: Cash"
                    required>
            </div>
        </div>

        <div class="mt-8 flex justify-start">
            <button
                type="submit"
                class="inline-flex justify-center items-center gap-2 py-2.5 px-6 border border-transparent rounded-lg shadow-sm 
                               text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 
                               outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>Adicionar Categoria</span>
            </button>
        </div>
    </form>
</div>