<?= $this->layout('components/layouts/web') ?>

<link rel="stylesheet" href="<?= assets('css/plugins/vip/style.css') ?>">

<div class="web-title">
    VIP'S
</div>

<div class="box-info">
    <h3>O que é VIP?</h3>
    <p>
        O VIP é um status que concede acesso a comandos exclusivos, como resetar a senha, ganhar moedas e verificar o status do staff.
    </p>
</div>

<div class="box-info">
    <h3>Como se tornar VIP?</h3>
    <p>
        Para se tornar VIP, você precisa adquirir um dos planos abaixo. Após o pagamento, você terá acesso a todos os benefícios VIP.
    </p>
</div>

<?php if (!empty($plans)): ?>
    <div class="web-sub-title">Planos VIP Disponíveis:</div>
    
    <div class="vip-plans-container">
        <?php foreach ($plans as $planIndex => $plan): ?>
            <div class="vip-plan-card">
                <div class="vip-plan-header">
                    <h3 class="vip-plan-name"><?= htmlspecialchars($plan['name'] ?? 'Plano VIP') ?></h3>
                    <div class="vip-plan-price">
                        <?= number_format((int)($plan['price'] ?? 0), 0, ',', '.') ?> Cash
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <p style="color: var(--neutral-50); margin-bottom: 10px;">
                        <strong>Duração:</strong> <?= (int)($plan['days'] ?? 0) ?> dias
                    </p>
                </div>
                
                <?php if (!empty($plan['description'])): ?>
                    <div class="vip-plan-benefits">
                        <?php 
                        $benefits = explode("\n", trim($plan['description']));
                        foreach ($benefits as $benefit):
                            $benefit = trim($benefit);
                            if (!empty($benefit)):
                        ?>
                            <li><?= htmlspecialchars($benefit) ?></li>
                        <?php 
                            endif;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php 
                // Calcular bonuses e verificar quais mostrar
                $expRate = (int)($plan['exp_rate'] ?? 100);
                $masterExpRate = (int)($plan['master_exp_rate'] ?? 100);
                $dropRate = (int)($plan['drop_rate'] ?? 100);
                
                $expBonus = $expRate - 100;
                $masterBonus = $masterExpRate - 100;
                $dropBonus = $dropRate - 100;
                
                $showExp = $expRate > 0;
                $showMaster = $masterExpRate > 0;
                $showDrop = $dropRate > 0;
                
                $ratesCount = ($showExp ? 1 : 0) + ($showMaster ? 1 : 0) + ($showDrop ? 1 : 0);
                ?>
                
                <?php if ($ratesCount > 0): ?>
                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--neutral-500);">
                    <div style="display: grid; grid-template-columns: repeat(<?= $ratesCount ?>, 1fr); gap: 10px; margin-bottom: 15px; font-size: 13px;">
                        <?php if ($showExp): ?>
                        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                            <strong style="color: var(--white); margin-bottom: 4px;">Exp:</strong>
                            <span style="color: var(--blue-100); font-size: 14px; font-weight: 600;">+<?= $expBonus ?>%</span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($showMaster): ?>
                        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                            <strong style="color: var(--white); margin-bottom: 4px;">Master:</strong>
                            <span style="color: var(--yellow-100); font-size: 14px; font-weight: 600;">+<?= $masterBonus ?>%</span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($showDrop): ?>
                        <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                            <strong style="color: var(--white); margin-bottom: 4px;">Drop:</strong>
                            <span style="color: var(--red-100); font-size: 14px; font-weight: 600;">+<?= $dropBonus ?>%</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <form action="<?= route('/vip/purchase') ?>" method="post" style="margin: 0;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="plan_index" value="<?= $planIndex ?>">
                    <button type="submit" class="vip-plan-button">
                        Comprar Agora
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="box-info">
        <p style="text-align: center; color: var(--neutral-400);">
            Nenhum plano VIP disponível no momento. Entre em contato com a administração.
        </p>
    </div>
<?php endif; ?>

<div class="web-sub-title" style="margin-top: 40px;">Vantagens de ser um vip:</div>

<table class="table">
    <thead>
        <tr>
            <th>Comando</th>
            <th align="center">Free</th>
            <th align="center">Vip</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>/resets</td>
            <td align="center"><span class="text-success">Sim</span></td>
            <td align="center"><span class="text-danger">Sim</span></td>
        </tr>
        <tr>
            <td>/coin</td>
            <td align="center"><span class="text-success">Sim</span></td>
            <td align="center"><span class="text-danger">Sim</span></td>
        </tr>
        <tr>
            <td>/staff</td>
            <td align="center"><span class="text-success">Sim</span></td>
            <td align="center"><span class="text-danger">Sim</span></td>
        </tr>
        <tr>
            <td>/vip</td>
            <td align="center"><span class="text-success">Sim</span></td>
            <td align="center"><span class="text-danger">Sim</span></td>
        </tr>
    </tbody>
</table>