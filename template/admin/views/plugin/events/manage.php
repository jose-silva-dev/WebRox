<?= $this->layout('components/layouts/admin') ?>

<div class="adm-dashboard">
    <form id="events-form"
          action="<?= route('admin/plugins/events/save') ?>"
          method="post"
          class="settings-form">
        <?= csrf_field() ?>

        <div class="adm-dashboard__grid" style="grid-template-columns: 1fr;">
            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Plugin Eventos</p>
                        <h2 class="adm-card__title">Programação recorrente</h2>
                    </div>
                    <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
                        <i class="ph ph-arrow-left"></i> Voltar
                    </a>
                </header>
                <p class="settings-desc" style="margin-bottom: 1rem;">
                    Defina eventos automatizados com nome, duração e horários. Ex.: 08:00,14:00,20:00 (24h).
                </p>
                <div id="events-container" class="adm-list events-grid">
                    <?php
                    $eventsList = $plugin['config']['Eventos'] ?? [];
                    foreach ($eventsList as $i => $event):
                    ?>
                        <div class="admin-plan-card event-item">
                            <div class="admin-plan-header">
                                <input type="text"
                                       name="events[Eventos][<?= $i ?>][name]"
                                       value="<?= htmlspecialchars($event['name'] ?? '') ?>"
                                       class="admin-plan-title-input"
                                       required>
                                <button type="button" class="btn btn-danger btn-sm remove-event" title="Remover">
                                    <i class="ph ph-x" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="adm-field adm-field--inline">
                                <input type="hidden" name="events[Eventos][<?= $i ?>][enabled]" value="0">
                                <label>
                                    <input type="checkbox"
                                           name="events[Eventos][<?= $i ?>][enabled]"
                                           value="1"
                                           <?= !empty($event['enabled']) ? 'checked' : '' ?>>
                                    <span>Evento ativo</span>
                                </label>
                            </div>
                            <div class="adm-fields">
                                <div class="adm-field">
                                    <label>Duração (minutos)</label>
                                    <input type="number"
                                           name="events[Eventos][<?= $i ?>][eventTime]"
                                           value="<?= (int)($event['eventTime'] ?? 0) ?>"
                                           required>
                                </div>
                                <div class="adm-field">
                                    <label>Horários (HH:MM, vírgula)</label>
                                    <input type="text"
                                           name="events[Eventos][<?= $i ?>][times]"
                                           value="<?= htmlspecialchars(implode(',', (array)($event['times'] ?? []))) ?>"
                                           placeholder="08:00,14:00,20:00">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div style="margin-top: 12px;">
                    <button type="button" class="btn btn-success btn-sm" id="add-event">
                        <i class="ph ph-plus"></i> Adicionar evento
                    </button>
                </div>
            </section>

            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Invasões</p>
                        <h2 class="adm-card__title">Invasões de monstros</h2>
                    </div>
                </header>
                <p class="settings-desc" style="margin-bottom: 1rem;">
                    Configure horários, duração e ative/desative cada invasão.
                </p>
                <div id="invasions-container" class="adm-list events-grid">
                    <?php
                    $invasionsList = $plugin['config']['invasions'] ?? [];
                    foreach ($invasionsList as $i => $inv):
                    ?>
                        <div class="admin-plan-card invasion-item">
                            <div class="admin-plan-header">
                                <input type="text"
                                       name="invasions[<?= $i ?>][name]"
                                       value="<?= htmlspecialchars($inv['name'] ?? '') ?>"
                                       class="admin-plan-title-input"
                                       required>
                                <button type="button" class="btn btn-danger btn-sm remove-invasion" title="Remover">
                                    <i class="ph ph-x" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="adm-field adm-field--inline">
                                <input type="hidden" name="invasions[<?= $i ?>][enabled]" value="0">
                                <label>
                                    <input type="checkbox"
                                           name="invasions[<?= $i ?>][enabled]"
                                           value="1"
                                           <?= !empty($inv['enabled']) ? 'checked' : '' ?>>
                                    <span>Invasão ativa</span>
                                </label>
                            </div>
                            <div class="adm-fields">
                                <div class="adm-field">
                                    <label>Duração (minutos)</label>
                                    <input type="number"
                                           name="invasions[<?= $i ?>][duration]"
                                           value="<?= (int)($inv['duration'] ?? 0) ?>"
                                           required>
                                </div>
                                <div class="adm-field">
                                    <label>Horários (HH:MM, vírgula)</label>
                                    <input type="text"
                                           name="invasions[<?= $i ?>][times]"
                                           value="<?= htmlspecialchars(implode(',', (array)($inv['times'] ?? []))) ?>"
                                           placeholder="08:00,14:00,20:00">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div style="margin-top: 12px;">
                    <button type="button" class="btn btn-success btn-sm" id="add-invasion">
                        <i class="ph ph-plus"></i> Adicionar invasão
                    </button>
                </div>
            </section>

            <section class="adm-card adm-card--full settings-card--submit">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar configurações
                </button>
            </section>
        </div>
    </form>
</div>

<script>
    window.EVENT_INDEX = <?= count($plugin['config']['Eventos'] ?? []) ?>;
    window.INVASION_INDEX = <?= count($plugin['config']['invasions'] ?? []) ?>;
</script>
<script src="<?= assets('js/custom.js', 'admin') ?>?v=<?= time() ?>" defer></script>
