<?= !isAjax() ? $this->layout('_layout') : ''; ?>

<div class="bg-white rounded-xl border border-neutral-100 rounded-md shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-gray-200">

        <div class="p-6">
            <h2 class="text-sm font-medium text-slate-600">
                Usuários
            </h2>
            <p class="mt-1 text-3xl font-bold text-slate-900">
                100
            </p>
        </div>

        <div class="p-6">
            <h2 class="text-sm font-medium text-slate-600">
                Contas Cadastradas
            </h2>
            <p class="mt-1 text-3xl font-bold text-slate-900">
                100
            </p>
        </div>

        <div class="p-6">
            <h2 class="text-sm font-medium text-slate-600">
                Jogadores Online
            </h2>
            <p class="mt-1 text-3xl font-bold text-slate-900">
                100
            </p>
        </div>

        <div class="p-6">
            <h2 class="text-sm font-medium text-slate-600">
                Contas Vip
            </h2>
            <p class="mt-1 text-3xl font-bold text-slate-900">
                100
            </p>
        </div>
    </div>
</div>