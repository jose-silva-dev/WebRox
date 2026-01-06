<div class="navigation">
    <nav class="nav">
        <ul class="nav-list">
            <li class="nav-item"><a href="<?= route("") ?>">Inicio</a></li>
            <?php if (!user()): ?>
            <li class="nav-item">
                <button type="button" class="btn-login" onclick="openRegisterPopup()">
                    Cadastro
                </button>
            </li>
            <?php endif; ?>
            <li class="nav-item"><a href="<?= route("downloads") ?>">Downloads</a></li>
            <li class="nav-item"><a href="<?= route("rankings") ?>">Rankings</a></li>
            <li class="nav-item"><a href="<?= route("vip") ?>">Vip</a></li>
            <li class="nav-item"><a href="<?= route("coins") ?>">Moedas</a></li>
            <li class="nav-item"><a href="<?= route("staff") ?>">Equipe</a></li>
            <?php if (!user()): ?>
            <li class="nav-item">
                <button type="button" class="btn-login" onclick="openLoginPopup()">
                    Entrar
                </button>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>