<?= !isAjax() ? $this->layout('_layout') : ''; ?>

<div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6 space-y-6">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Gerenciar personagem</h2>

    <form action="<?= url('padmin/characters/search') ?>" method="POST" class="space-y-5">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do personagem</label>
            <input
                type="text"
                id="name"
                name="name"
                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                placeholder="Ex: Admin"
                required>
        </div>

        <div class="pt-4">
            <button
                type="submit"
                class="flex justify-center items-center gap-2 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                <i data-lucide="search" class="w-5 h-5"></i>
                <span>Buscar Personagem</span>
            </button>
        </div>

    </form>
</div>