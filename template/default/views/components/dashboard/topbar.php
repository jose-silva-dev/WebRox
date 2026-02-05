<?php
use Source\Services\PlayerOnlineService;
$userName = user() ? resolve('User')->getUsername() : __('auth.guest');
$userEmail = user() ? resolve('User')->getEmail() : __('auth.login_placeholder');
$cashback = 'R$ 0,00';
$currentLang = locale();
?>
<header class="dashboard-topbar">
    <div class="topbar-left">
        <button class="menu-toggle">
            <i class="ph ph-list"></i>
        </button>
        <nav class="font-size-accessibility" aria-label="<?= __("accessibility.font_size") ?>">
            <button type="button" class="font-size-btn font-size-down" id="font-size-down" title="<?= __("accessibility.decrease_font") ?>" aria-label="<?= __("accessibility.decrease_font_label") ?>">A-</button>
            <button type="button" class="font-size-btn font-size-up" id="font-size-up" title="<?= __("accessibility.increase_font") ?>" aria-label="<?= __("accessibility.increase_font_label") ?>">A+</button>
        </nav>
        <nav class="lang-dropdown-wrap" aria-label="<?= __("lang.choose") ?>" x-data="{ open: false }" @click.away="open = false">
            <button type="button" class="lang-dropdown-trigger" @click="open = !open" :aria-expanded="open" aria-haspopup="true">
                <span class="lang-dropdown-label"><?= __("lang.{$currentLang}") ?></span>
                <i class="ph ph-caret-down lang-dropdown-arrow" :class="{ 'is-open': open }" aria-hidden="true"></i>
            </button>
            <div class="lang-dropdown-menu" x-show="open" x-transition x-cloak>
                <a href="<?= route('lang/en') ?>" class="lang-dropdown-item <?= $currentLang === 'en' ? 'active' : '' ?>" hreflang="en"><?= __("lang.name_en") ?></a>
                <a href="<?= route('lang/pt') ?>" class="lang-dropdown-item <?= $currentLang === 'pt' ? 'active' : '' ?>" hreflang="pt"><?= __("lang.name_pt") ?></a>
                <a href="<?= route('lang/es') ?>" class="lang-dropdown-item <?= $currentLang === 'es' ? 'active' : '' ?>" hreflang="es"><?= __("lang.name_es") ?></a>
            </div>
        </nav>
        <nav class="theme-toggle-wrap" aria-label="<?= __("theme.aria_label") ?>">
            <button type="button" class="theme-toggle-btn" id="theme-light" title="<?= __("theme.light") ?>" aria-pressed="false">
                <i class="ph ph-sun" aria-hidden="true"></i>
            </button>
            <button type="button" class="theme-toggle-btn" id="theme-dark" title="<?= __("theme.dark") ?>" aria-pressed="false">
                <i class="ph ph-moon" aria-hidden="true"></i>
            </button>
        </nav>
    </div>

    <div class="topbar-right">
        <?php if (user()): ?>
            <div class="currency-display">

                <?php
                $userResolver = resolve('User');
                // Exibir outras moedas configuradas
                if ($userResolver):
                    $coins = $userResolver->getCoins();
                foreach ($coins as $coin):
                    ?>
                    <span class="currency-item dimmed" title="<?= $coin['title'] ?>">
                        <?= $coin['title'] ?>
                        <?= number_format($coin['amount'], 0, ',', '.') ?>
                    </span>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="user-profile" x-data="{ open: false }" @click.away="open = false">
                <div class="user-info text-right" @click="open = !open" style="cursor: pointer;">
                    <span class="name">
                        <?= $userName ?>
                    </span>
                    <span class="email">
                        <?= $userEmail ?>
                    </span>
                </div>
                <div class="avatar" @click="open = !open" style="cursor: pointer;">
                    <img src="<?= assets('images/logo.png') ?>" alt="User">
                </div>

                <div x-show="open" x-transition x-cloak class="user-dropdown">
                    <a href="<?= route('user.info') ?>" class="user-dropdown-item">
                        <i class="ph ph-user" aria-hidden="true"></i> <?= __("auth.my_account") ?>
                    </a>
                    <a href="<?= route('user.logout') ?>" class="user-dropdown-item user-dropdown-item--danger">
                        <i class="ph ph-sign-out" aria-hidden="true"></i> <?= __("auth.logout") ?>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="auth-buttons">
                <button onclick="openLoginPopup()" class="btn-login-top"><?= __("auth.login") ?></button>
                <button onclick="openRegisterPopup()" class="btn-register-top"><?= __("auth.register") ?></button>
            </div>
        <?php endif; ?>
    </div>
</header>