<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    Minha Conta
</div>

<?= $this->insert("user/partials/menu") ?>


<table class="table">
    <tbody>
        <tr>
            <td>Nome</td>
            <td><?= resolve('User')->getUsername() ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= resolve('User')->getEmail() ?></td>
        </tr>
        <tr>
            <td>VIP</td>
            <td><?= resolve('User')->getVip() ?></td>
        </tr>
        <tr>
            <td>Expiração do VIP</td>
            <td><?= resolve('User')->getExpireVip() ?></td>
        </tr>
    </tbody>
</table>

<div class="web-sub-title">
    Moedas
</div>

<table class="table">
    <tbody>
        <?php foreach (resolve('User')->getCoins() as $coin): ?>
            <tr>
                <td><?= $coin['title'] ?></td>
                <td><?= $coin['amount'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>