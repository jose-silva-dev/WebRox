<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SERVER['name'] ?> - Painel administrativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-r via-neutral-900 from-neutral-600 to-neutral-500">
    <div class="w-full max-w-md rounded-lg shadow-lg overflow-hidden p-8 bg-white">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-neutral-600"><?= SERVER['name'] ?></h1>
            <p class="text-neutral-400 mt-2">Gerencia seu painel administrativo!</p>
        </div>

        <form action="<?= url('padmin/auth') ?>" class="space-y-6" method="post" autocomplete="off">
            <div>
                <label for="username" class="block text-sm font-medium text-neutral-400 mb-1">Usuário</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    autocomplete="off"
                    class="w-full px-4 py-3 bg-darklight border border-neutral-400 text-sm outline-none rounded-md placeholder-neutral-200"
                    placeholder="Digite seu usuário">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-neutral-400 mb-1">Senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    readonly
                    data-readonly-password
                    class="w-full px-4 py-3 bg-darklight border border-neutral-400 text-sm outline-none rounded-md placeholder-neutral-200"
                    placeholder="Digite sua senha">
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full bg-amber-500 flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium hover:bg-amber-400 transition-colors">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</body>
<script src="<?= resources("assets/js/jquery.js") ?>"></script>
<script src="<?= resources("assets/js/sweet.js") ?>"></script>
<script src="<?= resources("assets/js/web.js") ?>"></script>
<script>
(function() {
    var pw = document.querySelector('[data-readonly-password]');
    if (!pw) return;
    function allowInput() {
        pw.removeAttribute('readonly');
        pw.removeEventListener('focus', allowInput);
        pw.removeEventListener('click', allowInput);
    }
    pw.addEventListener('focus', allowInput);
    pw.addEventListener('click', allowInput);
})();
</script>

</html>