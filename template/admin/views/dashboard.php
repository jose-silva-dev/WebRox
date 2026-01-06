<?= $this->layout('components/layouts/admin') ?>

<?php if ($installExists ?? false): ?>
<div style="background: #fff3cd; border: 2px solid #ffc107; border-left: 4px solid #ff9800; border-radius: 6px; padding: 16px 20px; margin-bottom: 24px; position: relative; z-index: 1000;">
    <div style="display: flex; align-items: flex-start; gap: 12px;">
        <div style="flex: 1;">
            <strong style="color: #856404; font-size: 16px; display: block; margin-bottom: 8px;">
                ⚠️ Aviso de Segurança Importante
            </strong>
            <p style="color: #856404; margin: 0; font-size: 14px; line-height: 1.6;">
                A pasta <code style="background: rgba(133, 100, 4, 0.15); padding: 4px 8px; border-radius: 4px; color: #856404; font-family: 'Courier New', monospace; font-size: 13px;">/install</code> ainda existe no servidor. 
                Por segurança, você <strong>DEVE remover ou renomear esta pasta</strong> imediatamente após a instalação para evitar que outras pessoas possam reinstalar ou acessar o sistema.
            </p>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="information">
    <div class="donations space-y-1">
        <div class="approve">
            <h2>
                Pagamentos Aprovados
                <a href="<?= route('admin/payment') ?>">Ver Detalhes <i class="ph ph-arrow-right"></i></a>
            </h2>
            <h4><?= resolve('Geral')->getRealBrazilianPrice($paymentAproved) ?></h4>
        </div>
        <div class="pending">
            <h2>
                Pagamentos Pendentes
                <a href="<?= route('admin/payment') ?>">Ver Detalhes <i class="ph ph-arrow-right"></i></a>
            </h2>
            <h4><?= resolve('Geral')->getRealBrazilianPrice($paymentPending) ?></h4>
        </div>
    </div>
    <div class="cards">
        <?= $this->insert('components/card', ['title' => 'Jogadores Online', 'value' => $playersOnline, 'icon' => 'ph-users-three']) ?>
        <?= $this->insert('components/card', ['title' => 'Total de Contas', 'value' => $totalAccounts, 'icon' => 'ph-user']) ?>
        <?= $this->insert('components/card', ['title' => 'Total de Personagens', 'value' => $totalCharacters, 'icon' => 'ph-users']) ?>
        <?= $this->insert('components/card', ['title' => 'Total de Guilds', 'value' => $totalGuilds, 'icon' => 'ph-shield']) ?>
    </div>
</div>

<div id="graphic" class="graphic"></div>



<?= $this->start('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        colors: ['#28a745', '#ffc107'],

        series: [{
            name: 'Aprovados',
            data: <?= json_encode($graphicData['monthApproved']) ?>
        }, {
            name: 'Pendentes',
            data: <?= json_encode($graphicData['monthPending']) ?>
        }],

        chart: {
            height: 500,
            type: 'area',
            fontFamily: 'Poppins, sans-serif',
            background: 'transparent',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },

        dataLabels: {
            enabled: false
        },

        stroke: {
            curve: 'smooth',
            width: 3,
            dropShadow: {
                enabled: true,
                top: 0,
                left: 0,
                blur: 3,
                opacity: 0.5
            }
        },

        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },

        grid: {
            show: true,
            borderColor: 'rgba(255, 255, 255, 0.08)',
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: false
                }
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 10
            }
        },

        xaxis: {
            type: 'category',
            categories: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#9ca3af',
                    fontSize: '12px'
                }
            },
            tooltip: {
                enabled: false
            }
        },

        yaxis: {
            labels: {
                style: {
                    colors: '#9ca3af',
                    fontSize: '12px'
                },
                formatter: (value) => {
                    return value.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                        maximumFractionDigits: 0
                    });
                }
            }
        },

        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(value) {
                    return value.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }
            }
        },

        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            labels: {
                colors: '#9ca3af'
            },
            markers: {
                radius: 12
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#graphic"), options);
    chart.render();
</script>

<?= $this->end('scripts') ?>