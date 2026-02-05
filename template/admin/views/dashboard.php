<?= $this->layout('components/layouts/admin') ?>

<div class="adm-dashboard">
    <?php if ($installExists ?? false): ?>
        <div class="adm-callout adm-callout--warning">
            <div class="adm-callout__icon">
                <i class="ph ph-warning"></i>
            </div>
            <div class="adm-callout__body">
                <span class="adm-callout__title">Atenção de segurança</span>
                <p>As pastas <strong>/install</strong> ou <strong>/install_test</strong> ainda estão no servidor. Remova-as imediatamente após concluir a instalação.</p>
            </div>
            <code class="adm-callout__code">/install ou /install_test</code>
        </div>
    <?php endif; ?>

    <div class="adm-dashboard__grid">

        <section class="adm-card adm-card--full">
            <header class="adm-card__header">
                <div>
                    <p class="adm-eyebrow">Finanças</p>
                    <h2 class="adm-card__title">Resumo geral</h2>
                </div>
                <a href="<?= route('admin/payment') ?>" class="adm-link">Ver pagamentos</a>
            </header>
            <div class="adm-summary">
                <div class="adm-summary__item is-positive">
                    <div class="adm-summary__icon"><i class="ph ph-chart-line-up"></i></div>
                    <div class="adm-summary__content">
                        <span class="adm-summary__label">Pagamentos aprovados</span>
                        <strong class="adm-summary__value"><?= resolve('Geral')->getRealBrazilianPrice($paymentAproved) ?></strong>
                        <span class="adm-summary__hint">Últimos 30 dias</span>
                    </div>
                </div>
                <div class="adm-summary__item is-warning">
                    <div class="adm-summary__icon"><i class="ph ph-hourglass"></i></div>
                    <div class="adm-summary__content">
                        <span class="adm-summary__label">Pagamentos pendentes</span>
                        <strong class="adm-summary__value"><?= resolve('Geral')->getRealBrazilianPrice($paymentPending) ?></strong>
                        <span class="adm-summary__hint">Aguardando confirmação</span>
                    </div>
                </div>
            </div>
        </section>

        <?php
        $metrics = [
            ['title' => 'Jogadores Online', 'value' => $playersOnline, 'icon' => 'ph-users-three', 'tone' => 'positive'],
            ['title' => 'Total de Contas', 'value' => $totalAccounts, 'icon' => 'ph-user', 'tone' => 'neutral'],
            ['title' => 'Total de Personagens', 'value' => $totalCharacters, 'icon' => 'ph-users', 'tone' => 'neutral'],
            ['title' => 'Total de Guilds', 'value' => $totalGuilds, 'icon' => 'ph-shield', 'tone' => 'neutral'],
        ];
        ?>
        <section class="adm-card">
            <header class="adm-card__header">
                <div>
                    <p class="adm-eyebrow">Visão rápida</p>
                    <h2 class="adm-card__title">Indicadores principais</h2>
                </div>
            </header>
            <div class="adm-metrics">
                <?php foreach ($metrics as $metric): ?>
                    <div class="adm-metric adm-metric--<?= $metric['tone'] ?>">
                        <div class="adm-metric__icon">
                            <i class="ph <?= $metric['icon'] ?>"></i>
                        </div>
                        <div class="adm-metric__content">
                            <span class="adm-metric__label"><?= htmlspecialchars($metric['title']) ?></span>
                            <strong class="adm-metric__value"><?= htmlspecialchars($metric['value']) ?></strong>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="adm-card adm-card--chart">
            <header class="adm-card__header">
                <div>
                    <p class="adm-eyebrow">Performance</p>
                    <h2 class="adm-card__title">Pagamentos por mês</h2>
                </div>
            </header>
            <div class="adm-chart" id="graphic"></div>
        </section>

    </div>
</div>

<?= $this->start('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        colors: ['#10b981', '#f59e0b'],
        series: [{
            name: 'Aprovados',
            data: <?= json_encode($graphicData['monthApproved']) ?>
        }, {
            name: 'Pendentes',
            data: <?= json_encode($graphicData['monthPending']) ?>
        }],
        chart: {
            height: 320,
            type: 'area',
            fontFamily: 'var(--font-primary), sans-serif',
            background: 'transparent',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 2,
            dropShadow: { enabled: true, top: 0, left: 0, blur: 3, opacity: 0.3 }
        },
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05, stops: [0, 100] }
        },
        grid: {
            show: true,
            borderColor: 'rgba(255, 255, 255, 0.06)',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } },
            padding: { top: 10, right: 10, bottom: 0, left: 10 }
        },
        xaxis: {
            type: 'category',
            categories: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: '#9ca3af', fontSize: '11px' } }
        },
        yaxis: {
            labels: {
                style: { colors: '#9ca3af', fontSize: '11px' },
                formatter: function(value) {
                    return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL', maximumFractionDigits: 0 });
                }
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(value) {
                    return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                }
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            labels: { colors: '#9ca3af' },
            markers: { radius: 8 }
        }
    };
    var chart = new ApexCharts(document.querySelector("#graphic"), options);
    chart.render();
</script>
<?= $this->end('scripts') ?>
