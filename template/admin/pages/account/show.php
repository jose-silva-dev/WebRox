<?= !isAjax() ? $this->layout('_layout') : ''; ?>

<div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-6 lg:p-8">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Gerenciar Conta do Usuário</h2>

    <form action="<?= url('padmin/accounts/update') ?>" method="POST" class="space-y-6">

        <div class="grid md:grid-cols-2 grid-cols-1 gap-6">

            <div class="bg-gray-50 border p-5 rounded-lg space-y-4">
                <h3 class="text-lg font-semibold text-gray-700">Dados de Acesso</h3>

                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Login</label>
                    <input type="text" id="login" name="login" value="<?= $account->login ?>"
                        class="block w-full px-3 py-2 bg-gray-200 border border-gray-300 outline-none rounded-md shadow-sm cursor-not-allowed sm:text-sm"
                        readonly>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nova Senha</label>
                    <input type="password" id="password" name="password"
                        class="block w-full px-3 py-2 border border-gray-300 outline-none rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                        placeholder="Deixe em branco para não alterar">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="<?= $account->email ?>"
                        class="block w-full px-3 py-2 border border-gray-300 outline-none rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                        required>
                </div>
            </div>

            <div class="bg-gray-50 border p-5 rounded-lg space-y-4">
                <h3 class="text-lg font-semibold text-gray-700">Moedas</h3>

                <div>
                    <label for="cash" class="block text-sm font-medium text-gray-700 mb-1">Cashs</label>
                    <input type="number" id="cash" name="cash" value="<?= $account->cash ?>"
                        class="block w-full px-3 py-2 border border-gray-300 outline-none rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                        required>
                </div>

                <div>
                    <label for="gold" class="block text-sm font-medium text-gray-700 mb-1">Golds</label>
                    <input type="number" id="gold" name="gold" value="<?= $account->gold ?>"
                        class="block w-full px-3 py-2 border border-gray-300 outline-none rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                        required>
                </div>
            </div>

            <div class="bg-gray-50 border p-5 rounded-lg space-y-4 md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-700">Privilégios e Status</h3>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label for="vip_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo de VIP</label>
                        <select id="vip_type" name="vip_type" class="block w-full px-3 py-2 border border-gray-300 outline-none bg-white rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                            <option value="0" <?= $account->vip_type == 0 ? 'selected' : '' ?>>Nenhum</option>
                            <option value="1" <?= $account->vip_type == 1 ? 'selected' : '' ?>>VIP Bronze</option>
                            <option value="2" <?= $account->vip_type == 2 ? 'selected' : '' ?>>VIP Prata</option>
                        </select>
                    </div>

                    <div>
                        <label for="vip_expiration" class="block text-sm font-medium text-gray-700 mb-1">Expiração do VIP</label>
                        <input type="date" id="vip_expiration" name="vip_expiration" value="<?= date("Y-m-d", strtotime($account->expire_date)) ?>"
                            class="block w-full px-3 py-2 border border-gray-300 outline-none rounded-md shadow-sm placeholder-gray-400 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="account_status" class="block text-sm font-medium text-gray-700 mb-1">Situação da Conta</label>
                        <select id="account_status" name="account_status" class="block w-full px-3 py-2 border border-gray-300 outline-none bg-white rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                            <option value="0" <?= $account->bloc_code == 0 ? 'selected' : '' ?>>Ativa</option>
                            <option value="1" <?= $account->bloc_code == 1 ? 'selected' : '' ?>>Banida</option>
                        </select>
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