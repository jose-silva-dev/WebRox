<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    Moedas
</div>

<?php if (user()): ?>
    <div class="donation" x-data="{bank: '<?= userConfig("donate.mercadopago.is_active") ? 'mp' : 'stripe' ?>'}">
        <div class="buttons">
            <?php if (userConfig("donate.mercadopago.is_active")): ?>
                <button type="button" class="mp" :class="{'active': bank === 'mp'}" @click="bank = 'mp'" title="Doar com Mercado Pago"></button>
            <?php endif; ?>
            <?php if (userConfig("donate.stripe.is_active")): ?>
                <button type="button" class="stripe" :class="{'active': bank === 'stripe'}" @click="bank = 'stripe'" title="Doar com Stripe"></button>
            <?php endif; ?>
        </div>
        <?php if (userConfig("donate.mercadopago.is_active")): ?>
            <form action="<?= route("user.donate.mercadopago.store") ?>" class="form" method="post" x-show="bank === 'mp'">
                <div class="web-sub-title">Doar com Mercado Pago</div>
                <div>
                    <label for="donate">Valor da doação:</label>
                    <input type="number" id="donate" name="price" required min="1" max="1000000">
                </div>
                <div>
                    <button type="submit">Doar</button>
                </div>
            </form>
        <?php endif; ?>
        <?php if (userConfig("donate.stripe.is_active")): ?>
            <form action="<?= route("user.donate.stripe.store") ?>" class="form" method="post" x-show="bank === 'stripe'">
                <div class="web-sub-title">Doar com Stripe</div>
                <div>
                    <label for="donate">Valor da doação:</label>
                    <input type="number" id="donate" name="price" required min="1" max="1000000">
                </div>
                <div>
                    <button type="submit">Doar</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="warning">
        Você precisa estar logado para doar!
    </div>
<?php endif; ?>

<div class="box-info">
    <h3>O que é moeda?</h3>
    <p>
        As moedas são um recurso que permite aos jogadores ganhar dinheiro e fazer compras.
    </p>
</div>

<div class="box-info">
    <h3>Como ganhar moedas?</h3>
    <p>
        Existem várias maneiras de ganhar moedas, como completar missões, derrotar jogadores e ganhar recompensas.
    </p>
</div>