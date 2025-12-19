<div class="sidebar space-y-1">
    <?php if (!user()): ?>
        <div class="login">
            <form action="<?= route("login") ?>" class="form" method="post">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <div class="action">
                    <button type="submit">Entrar</button>
                    <a href="<?= route("forgot") ?>">Recuperar Senha</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="user-info">
            <p>
                Nome:
                <span><?= resolve('User')->getUsername() ?></span>
            </p>
            <p>
                Vip:
                <span><?= resolve('User')->getVip() ?></span>
            </p>
            <p>
                Expiração Vip:
                <span><?= resolve('User')->getExpireVip() ?></span>
            </p>
            <?php foreach (resolve('User')->getCoins() as $key => $value): ?>
                <p>
                    <?= $value['title'] ?>:
                    <span><?= $value['amount'] ?></span>
                </p>
            <?php endforeach; ?>
            <ul>
                <li><a href="<?= route("user.info") ?>">Minha Conta</a></li>
                <li><a href="<?= route("user.ticket") ?>">Suporte</a></li>
                <li><a href="<?= route("user.characters") ?>">Meus Personagens</a></li>
                <li><a href="<?= route("user.logout") ?>">Sair</a></li>
            </ul>
        </div>
    <?php endif; ?>


    <div class="info">
        <h3>Informações</h3>
        <div>
            <p>
                <span>Nome:</span>
                <span><?= config('server.name') ?></span>
            </p>
            <p>
                <span>Versão:</span>
                <span><?= config('server.version') ?></span>
            </p>
            <p>
                <span>Experiência:</span>
                <span><?= config('server.experience') ?></span>
            </p>
            <p>
                <span>Drop:</span>
                <span><?= config('server.drop') ?></span>
            </p>
            <p>
                <span>Nível:</span>
                <span><?= config('server.level') ?></span>
            </p>
            <p>
                <span>Pontos de Atributo:</span>
                <span><?= config('server.points_attributes') ?></span>
            </p>
        </div>
    </div>

    <div class="info">
        <h3>Equipe <?= config('server.name') ?></h3>
        <div>
            <?php if ($staffs = resolve('Geral')->getStaffs()): ?>
                <?php foreach ($staffs as $data): ?>
                    <p>
                        <span><?= $data['name'] ?>:</span>
                        <span class="text-<?= $data['status'] == 'online' ? 'success' : 'danger' ?>"><?= ucfirst($data['status']) ?></span>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>