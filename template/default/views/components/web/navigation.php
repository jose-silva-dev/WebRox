<div class="navigation">
    <nav class="nav">
        <ul class="nav-list">
            <li class="nav-item"><a href="<?= route("") ?>"><?= __("nav.home") ?></a></li>
            <?php if (!user()): ?>
            <li class="nav-item">
                <button type="button" class="btn-login" onclick="openRegisterPopup()">
                    <?= __("nav.register") ?>
                </button>
            </li>
            <?php endif; ?>
            <li class="nav-item"><a href="<?= route("downloads") ?>"><?= __("nav.downloads") ?></a></li>
            <li class="nav-item"><a href="<?= route("rankings") ?>"><?= __("nav.rankings") ?></a></li>
            <li class="nav-item"><a href="<?= route("vip") ?>"><?= __("nav.vip") ?></a></li>
            <li class="nav-item"><a href="<?= route("coins") ?>"><?= __("nav.coins") ?></a></li>
            <li class="nav-item"><a href="<?= route("staff") ?>"><?= __("nav.staff") ?></a></li>
            <?php if (!user()): ?>
            <li class="nav-item">
                <button type="button" class="btn-login" onclick="openLoginPopup()">
                    <?= __("auth.login") ?>
                </button>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>