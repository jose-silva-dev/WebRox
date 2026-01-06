<?= !isAjax() ? $this->layout('_layout') : ''; ?>

<div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6 space-y-6">

    <div class="border-b border-gray-200">
        <nav aria-label="Breadcrumb">
            <ol class="flex items-center gap-1.5 text-sm text-gray-500">
                <li>
                    <a href="<?= url('padmin/shoppings') ?>" class="hover:text-amber-600 transition-colors">
                        Shoppings
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="<?= url("padmin/shoppings/categories/{$shopping->id}") ?>" class="hover:text-amber-600 transition-colors">
                        <?= $shopping->name ?>
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="<?= url("padmin/shoppings/{$shopping->id}/categories/{$category->id}/items") ?>" class="hover:text-amber-600 transition-colors">
                        <?= $category->name ?>
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <span class="font-medium text-gray-700">Adicionar</span>
                </li>
            </ol>
        </nav>

        <h1 class="text-2xl font-bold text-gray-800 mt-2">
            Adicionar Novo Shopping
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Preencha o campo abaixo para cadastrar um novo item no shopping.
        </p>
    </div>

    <form action="<?= url("padmin/shoppings/{$shopping->id}/categories/{$category->id}/items/store") ?>" method="POST" class="space-y-5">

        <div class="grid md:grid-cols-2 gap-5 grid-cols-1">
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imagem do Item</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                    required>
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                    placeholder="Ex: Helm Leather"
                    required>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-5 grid-cols-1">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Preço</label>
                <input
                    type="number"
                    id="price"
                    name="price"
                    min="0"
                    max="1000000"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                    placeholder="Ex: 100"
                    required>
            </div>
            <div>
                <label for="attribute" class="block text-sm font-medium text-gray-700 mb-1">Atributo Life</label>
                <input
                    type="number"
                    id="attribute"
                    name="attribute"
                    min="0"
                    max="28"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                    placeholder="0 à 28"
                    required>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-5 grid-cols-1">
            <div>
                <label for="section" class="block text-sm font-medium text-gray-700 mb-1">Seção do Item</label>
                <input
                    type="number"
                    id="section"
                    name="section"
                    min="0"
                    max="1000"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                    placeholder="Ex: 100"
                    required>
            </div>
            <div>
                <label for="index" class="block text-sm font-medium text-gray-700 mb-1">Index do Item</label>
                <input
                    type="number"
                    id="index"
                    name="index"
                    min="0"
                    max="1000"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                    placeholder="Ex: 100"
                    required>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-5 grid-cols-1">
            <div>
                <label for="durabillity" class="block text-sm font-medium text-gray-700 mb-1">Durabilidade</label>
                <input
                    type="number"
                    id="durabillity"
                    name="durabillity"
                    min="0"
                    max="255"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                    placeholder="Ex: 255"
                    required>
            </div>
            <div>
                <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Level do Item</label>
                <select name="level" id="level" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <?php for ($i = 0; $i <= 15; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-5 grid-cols-1">
            <div>
                <label for="skill" class="block text-sm font-medium text-gray-700 mb-1">Skill do Item</label>
                <select name="skill" id="skill" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
            <div>
                <label for="luck" class="block text-sm font-medium text-gray-700 mb-1">Luck do Item</label>
                <select name="luck" id="luck" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-5 grid-cols-1">
            <div>
                <label for="excelent_01" class="block text-sm font-medium text-gray-700 mb-1">Excelente 01</label>
                <select name="excelent_01" id="excelent_01" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="1"> - Sim</option>
                    <option value="0"> - Não</option>
                </select>
            </div>
            <div>
                <label for="excelent_02" class="block text-sm font-medium text-gray-700 mb-1">Excelente 02</label>
                <select name="excelent_02" id="excelent_02" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="1"> - Sim</option>
                    <option value="0"> - Não</option>
                </select>
            </div>
            <div>
                <label for="excelent_03" class="block text-sm font-medium text-gray-700 mb-1">Excelente 03</label>
                <select name="excelent_03" id="excelent_03" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="1"> - Sim</option>
                    <option value="0"> - Não</option>
                </select>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-5 grid-cols-1">
            <div>
                <label for="excelent_04" class="block text-sm font-medium text-gray-700 mb-1">Excelente 04</label>
                <select name="excelent_04" id="excelent_04" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="1"> - Sim</option>
                    <option value="0"> - Não</option>
                </select>
            </div>
            <div>
                <label for="excelent_05" class="block text-sm font-medium text-gray-700 mb-1">Excelente 05</label>
                <select name="excelent_05" id="excelent_05" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="1"> - Sim</option>
                    <option value="0"> - Não</option>
                </select>
            </div>
            <div>
                <label for="excelent_06" class="block text-sm font-medium text-gray-700 mb-1">Excelente 06 <sup class="text-red-500">Se for asa desabilite para vir com recuperação de vida</sup></label>
                <select name="excelent_06" id="excelent_06" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="1"> - Sim</option>
                    <option value="0"> - Não</option>
                </select>
            </div>
        </div>
        <div>
            <div>
                <label for="random_option" class="block text-sm font-medium text-gray-700 mb-1">Atributos aleatório <sup class="text-red-500">Somente se o item for semi-full</sup></label>
                <select name="random_option" id="random_option" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    <option value="0"> - Não</option>
                    <option value="1"> - Sim</option>
                </select>
            </div>
        </div>
        <div class="pt-4">
            <button
                type="submit"
                class="flex justify-center items-center gap-2 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>Adicionar Item</span>
            </button>
        </div>

    </form>
</div>