<?= $this->layout('components/layouts/admin') ?>

<div class="space-y-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="title">Gerenciar Plugin: <?= htmlspecialchars($plugin['name'] ?? 'Eventos') ?></h1>
        <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form">
        <form id="events-form" action="<?= route('admin/plugins/events/save') ?>" method="post" class="space-y-2">
            <?= csrf_field() ?>
            
            <!-- EVENTOS -->
            <div class="space-y-2">
                <h3 class="subtitle">Eventos</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure eventos automáticos que serão executados em horários específicos
                </small>

                <div id="events-container" class="space-y-1">
                    <?php 
                    $eventsList = $plugin['config']['Eventos'] ?? [];
                    foreach ($eventsList as $i => $event): 
                    ?>
                        <div class="form event-item space-y-1" style="border: 1px solid var(--neutral-300); padding: 15px; border-radius: 8px; background: var(--neutral-700);">
                            <div style="display:flex; justify-content:space-between; align-items:center">
                                <input type="text"
                                       name="events[Eventos][<?= $i ?>][name]"
                                       value="<?= htmlspecialchars($event['name'] ?? '') ?>"
                                       placeholder="Nome do evento"
                                       style="font-weight:bold; flex:1; margin-right:10px;"
                                       required>

                                <button type="button" class="btn btn-danger btn-sm remove-event">
                                    <i class="ph ph-trash"></i> Remover
                                </button>
                            </div>

                            <div>
                                <label>
                                    <input type="hidden"
                                           name="events[Eventos][<?= $i ?>][enabled]"
                                           value="0">
                                    <input type="checkbox"
                                           name="events[Eventos][<?= $i ?>][enabled]"
                                           value="1"
                                           <?= !empty($event['enabled']) ? 'checked' : '' ?>>
                                    Ativo
                                </label>
                            </div>

                            <div>
                                <label>Duração (minutos)</label>
                                <input type="number"
                                       name="events[Eventos][<?= $i ?>][eventTime]"
                                       value="<?= (int)($event['eventTime'] ?? 0) ?>"
                                       placeholder="10"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Tempo de duração do evento em minutos
                                </small>
                            </div>

                            <div>
                                <label>Horários (HH:MM, separados por vírgula)</label>
                                <input type="text"
                                       name="events[Eventos][<?= $i ?>][times]"
                                       value="<?= implode(',', (array)($event['times'] ?? [])) ?>"
                                       placeholder="08:00, 14:00, 20:00">
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Horários em que o evento será executado (formato 24h)
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div>
                    <button type="button" class="btn btn-success" id="add-event">
                        <i class="ph ph-plus"></i> Adicionar Evento
                    </button>
                </div>
            </div>

            <hr style="margin:30px 0;border-color:#333">

            <!-- INVASÕES -->
            <div class="space-y-2">
                <h3 class="subtitle">Invasões</h3>
                <small style="color: #999; font-size: 12px; display: block; margin-bottom: 15px;">
                    Configure invasões de monstros que ocorrerão automaticamente
                </small>

                <div id="invasions-container" class="space-y-1">
                    <?php 
                    $invasionsList = $plugin['config']['invasions'] ?? [];
                    foreach ($invasionsList as $i => $inv): 
                    ?>
                        <div class="form invasion-item space-y-1" style="border: 1px solid var(--neutral-300); padding: 15px; border-radius: 8px; background: var(--neutral-700);">
                            <div style="display:flex; justify-content:space-between; align-items:center">
                                <input type="text"
                                       name="invasions[<?= $i ?>][name]"
                                       value="<?= htmlspecialchars($inv['name'] ?? '') ?>"
                                       placeholder="Nome da invasão"
                                       style="font-weight:bold; flex:1; margin-right:10px;"
                                       required>

                                <button type="button" class="btn btn-danger btn-sm remove-invasion">
                                    <i class="ph ph-trash"></i> Remover
                                </button>
                            </div>

                            <div>
                                <label>
                                    <input type="hidden"
                                           name="invasions[<?= $i ?>][enabled]"
                                           value="0">
                                    <input type="checkbox"
                                           name="invasions[<?= $i ?>][enabled]"
                                           value="1"
                                           <?= !empty($inv['enabled']) ? 'checked' : '' ?>>
                                    Ativa
                                </label>
                            </div>

                            <div>
                                <label>Duração (minutos)</label>
                                <input type="number"
                                       name="invasions[<?= $i ?>][duration]"
                                       value="<?= (int) ($inv['duration'] ?? 0) ?>"
                                       placeholder="10"
                                       required>
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Tempo de duração da invasão em minutos
                                </small>
                            </div>

                            <div>
                                <label>Horários (HH:MM, separados por vírgula)</label>
                                <input type="text"
                                       name="invasions[<?= $i ?>][times]"
                                       value="<?= implode(',', (array) ($inv['times'] ?? [])) ?>"
                                       placeholder="08:00, 14:00, 20:00">
                                <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                                    Horários em que a invasão será executada (formato 24h)
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div>
                    <button type="button" class="btn btn-success" id="add-invasion">
                        <i class="ph ph-plus"></i> Adicionar Invasão
                    </button>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-danger">
                    <i class="ph ph-check"></i> Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.EVENT_INDEX = <?= count($plugin['config']['Eventos'] ?? []) ?>;
    window.INVASION_INDEX = <?= count($plugin['config']['invasions'] ?? []) ?>;
</script>
<script src="/template/admin/assets/js/custom.js?v=<?= time() ?>" defer></script>

