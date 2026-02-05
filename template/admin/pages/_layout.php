<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">

<head>
    <?= seo() ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="<?= assets('css/custom.css') ?>">
    <style>
        * {
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
        }

        body {
            background-color: #f8fafc;
            color: #1e293b;
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen flex w-full mx-auto p-4 md:p-8">

        <aside class="hidden md:flex sticky top-0 flex-col bg-white w-72 h-[calc(100vh-4rem)] gap-5 rounded-l-xl shadow-lg">
            <div class="p-6">
                <img src="<?= assets('images/logo.png') ?>" alt="<?= SERVER['name'] ?>" class="h-10 mx-auto">
            </div>

            <nav class="flex-1 flex flex-col px-4">
                <ul class="space-y-1">
                    <li>
                        <a data-redirect href="<?= url("padmin/home") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                            <i data-lucide="layout-grid" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a data-redirect href="<?= url("padmin/sliders") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                            <i data-lucide="images" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                            <span>Sliders</span>
                        </a>
                    </li>
                    <li>
                        <a data-redirect href="<?= url("padmin/zens") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                            <i data-lucide="gem" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                            <span>Adicionar Zen</span>
                        </a>
                    </li>
                    <li>
                        <a data-redirect href="<?= url("padmin/shoppings") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                            <i data-lucide="swords" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                            <span>Shoppings</span>
                        </a>
                    </li>
                    <li>
                        <a data-redirect href="<?= url("padmin/accounts") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                            <i data-lucide="user-cog" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                            <span>Contas</span>
                        </a>
                    </li>
                    <li>
                        <a data-redirect href="<?= url("padmin/characters") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                            <i data-lucide="user-round" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                            <span>Personagens</span>
                        </a>
                    </li>
                    <li>
                        <a data-redirect href="<?= url("padmin/package/vip") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                            <i data-lucide="crown" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                            <span>Pacotes de VIP</span>
                        </a>
                    </li>
                </ul>

                <div class="mt-auto mb-6">
                    <a href="<?= url("user/logout") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-rose-600 hover:bg-rose-50">
                        <i data-lucide="log-out" stroke-width="1.5" class="w-5 h-5"></i>
                        <span>Sair da conta</span>
                    </a>
                </div>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col w-full md:w-auto">

            <header class="md:hidden sticky top-0 z-40 bg-white shadow-md rounded-xl mb-4 p-4 flex items-center justify-between">
                <img src="<?= assets('images/logo.png') ?>" alt="<?= SERVER['name'] ?>" class="h-8">
                <button id="open-menu-btn" aria-label="Abrir menu">
                    <i data-lucide="menu" class="w-6 h-6 text-slate-600"></i>
                </button>
            </header>

            <main class="flex-1 bg-white rounded-xl md:rounded-r-xl md:rounded-l-none shadow-lg overflow-hidden relative">
                <div class="h-full overflow-y-auto">
                    <div id="preloader" style="display: none;" class="absolute inset-0 h-full p-12 z-50 backdrop-blur-sm bg-white/40 flex items-center justify-center">
                        <div class="flex flex-col items-center space-y-4">
                            <div class="w-10 h-10 border-4 border-slate-200 border-t-amber-500 rounded-full animate-spin"></div>
                            <span class="font-medium text-slate-700">Carregando...</span>
                        </div>
                    </div>

                    <div id="content" class="p-6">
                        <?= $this->section('content'); ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="mobile-menu" class="md:hidden fixed inset-0 bg-white z-50 p-4 flex flex-col gap-5 transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between pb-4 border-b">
            <img src="<?= assets('images/logo.png') ?>" alt="<?= SERVER['name'] ?>" class="h-8">
            <button id="close-menu-btn" aria-label="Fechar menu">
                <i data-lucide="x" class="w-6 h-6 text-slate-600"></i>
            </button>
        </div>

        <nav class="flex-1 flex flex-col pt-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a data-redirect href="<?= url("padmin/home") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                        <i data-lucide="layout-grid" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a data-redirect href="<?= url("padmin/sliders") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                        <i data-lucide="images" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                        <span>Sliders</span>
                    </a>
                </li>
                <li>
                    <a data-redirect href="<?= url("padmin/zens") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                        <i data-lucide="gem" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                        <span>Adicionar Zen</span>
                    </a>
                </li>
                <li>
                    <a data-redirect href="<?= url("padmin/shoppings") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                        <i data-lucide="swords" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                        <span>Shoppings</span>
                    </a>
                </li>
                <li>
                    <a data-redirect href="<?= url("padmin/accounts") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                        <i data-lucide="user-cog" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                        <span>Contas</span>
                    </a>
                </li>
                <li>
                    <a data-redirect href="<?= url("padmin/characters") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                        <i data-lucide="user-round" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                        <span>Personagens</span>
                    </a>
                </li>
                <li>
                    <a data-redirect href="<?= url("padmin/package/vip") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-slate-600 hover:bg-slate-100 hover:text-amber-600 group">
                        <i data-lucide="crown" stroke-width="1.5" class="w-5 h-5 text-slate-400 group-hover:text-amber-500"></i>
                        <span>Pacotes de VIP</span>
                    </a>
                </li>
            </ul>

            <div class="mt-auto">
                <a href="<?= url("user/logout") ?>" class="flex items-center gap-3 p-3 text-sm rounded-lg text-rose-600 hover:bg-rose-50">
                    <i data-lucide="log-out" stroke-width="1.5" class="w-5 h-5"></i>
                    <span>Sair da conta</span>
                </a>
            </div>
        </nav>
    </div>


    <script src="<?= resources("assets/js/jquery.js") ?>"></script>
    <script src="<?= resources("assets/js/sweet.js") ?>"></script>
    <script src="<?= resources("assets/js/web.js") ?>"></script>
    <?= $this->section('scripts'); ?>

    <script>
        $(document).ready(function() {
            // Garante que o lucide-icons seja renderizado
            lucide.createIcons();

            // Abre o menu
            $('#open-menu-btn').on('click', function() {
                $('#mobile-menu').removeClass('-translate-x-full');
            });

            // Fecha o menu
            $('#close-menu-btn').on('click', function() {
                $('#mobile-menu').addClass('-translate-x-full');
            });

            // Opcional: fechar o menu ao clicar em um link
            $('#mobile-menu a').on('click', function() {
                $('#mobile-menu').addClass('-translate-x-full');
            });
        });
    </script>
</body>

</html>