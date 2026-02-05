<?= !isAjax() ? $this->layout('_layout') : ''; ?>

<div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6 lg:p-8">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">
        Gerenciar o Personagem: <span class="text-amber-600"><?= $char->name ?></span>
    </h2>

    <form action="<?= url('padmin/characters/update/' . $char->name) ?>" method="POST" class="space-y-6">

        <div class="grid lg:grid-cols-3 grid-cols-1 gap-6">

            <div class="lg:col-span-1 bg-gray-50 border p-5 rounded-lg space-y-4 h-fit">
                <h3 class="text-lg font-semibold text-gray-700">Informações Gerais</h3>

                <div>
                    <label for="class" class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                    <select id="class" name="class" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        <?php foreach (CHARACTERS['CLASSES'] as $key => $value): ?>
                            <option value="<?= $key ?>" <?= $char->class == $key ? 'selected' : '' ?>><?= $value['NAME'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="char_status" class="block text-sm font-medium text-gray-700 mb-1">Situação</label>
                    <select id="char_status" name="char_status" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        <option value="0" <?= $char->ctl_code == 0 ? 'selected' : '' ?>>Normal</option>
                        <option value="1" <?= $char->ctl_code == 1 ? 'selected' : '' ?>>Banido</option>
                        <option value="32" <?= $char->ctl_code == 32 ? 'selected' : '' ?>>Staff</option>
                    </select>
                </div>
            </div>

            <div class="lg:col-span-2 bg-gray-50 border p-5 rounded-lg space-y-4">
                <h3 class="text-lg font-semibold text-gray-700">Atributos</h3>
                <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">

                    <div>
                        <label for="strength" class="block text-sm font-medium text-gray-700 mb-1">Força</label>
                        <input type="number" id="strength" name="strength" value="<?= $char->strength ?>"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                            required>
                    </div>

                    <div>
                        <label for="dexterity" class="block text-sm font-medium text-gray-700 mb-1">Agilidade</label>
                        <input type="number" id="dexterity" name="dexterity" value="<?= $char->dexterity ?>"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                            required>
                    </div>

                    <div>
                        <label for="vitality" class="block text-sm font-medium text-gray-700 mb-1">Vitalidade</label>
                        <input type="number" id="vitality" name="vitality" value="<?= $char->vitality ?>"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                            required>
                    </div>

                    <div>
                        <label for="energy" class="block text-sm font-medium text-gray-700 mb-1">Energia</label>
                        <input type="number" id="energy" name="energy" value="<?= $char->energy ?>"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                            required>
                    </div>
                </div>
            </div>

        </div>

        <div class="pt-6 flex justify-end">
            <button type="submit"
                class="flex justify-center items-center gap-2 py-2 px-6 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>Salvar Alterações</span>
            </button>
        </div>

    </form>
</div>