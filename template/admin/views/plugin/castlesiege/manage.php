<?= $this->layout('components/layouts/admin') ?>

<div class="adm-dashboard">
    <form id="castlesiege-form"
          action="<?= route('admin/plugins/castlesiege/save') ?>"
          method="post"
          class="settings-form">
        <?= csrf_field() ?>

        <div class="adm-dashboard__grid" style="grid-template-columns: 1fr;">
            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Plugin Castle Siege</p>
                        <h2 class="adm-card__title">Configuração Geral</h2>
                    </div>
                    <a href="<?= route('admin/plugins') ?>" class="btn btn-secondary btn-sm">
                        <i class="ph ph-arrow-left"></i> Voltar
                    </a>
                </header>
                <div class="adm-card__body">
                    <div class="form-group">
                        <label for="castlesiege-title">Título</label>
                        <input type="text"
                               name="castlesiege[title]"
                               id="castlesiege-title"
                               value="<?= htmlspecialchars($plugin['config']['title'] ?? 'Castle Siege') ?>">
                        <small class="form-hint">Título principal exibido no card do Castle Siege</small>
                    </div>
                    <div class="form-group">
                        <label for="castlesiege-subtitle">Subtítulo</label>
                        <input type="text"
                               name="castlesiege[subtitle]"
                               id="castlesiege-subtitle"
                               value="<?= htmlspecialchars($plugin['config']['subtitle'] ?? 'Apenas uma guild reinará sobre o castelo') ?>">
                        <small class="form-hint">Subtítulo descritivo exibido abaixo do título</small>
                    </div>
                </div>
            </section>

            <section class="adm-card adm-card--full">
                <header class="adm-card__header">
                    <div>
                        <p class="adm-eyebrow">Banco de dados</p>
                        <h2 class="adm-card__title">Estrutura do Banco (Editável)</h2>
                    </div>
                </header>
                <p class="settings-desc" style="margin-bottom: 1rem;">
                    Use quando sua versão do Mu/DB usa tabelas/colunas diferentes. Aceita <code>dbo.Tabela</code> e nomes com <code>_</code>.
                </p>
                <div class="adm-card__body">
                    <div class="grid-2">
                        <div class="form-group">
                            <label>Tabela do Castelo</label>
                            <input type="text"
                                   name="castlesiege[castle_table]"
                                   value="<?= htmlspecialchars($plugin['config']['castle_table'] ?? 'MuCastle_DATA') ?>">
                            <small class="form-hint">Tabela que contém os dados do Castle Siege</small>
                        </div>
                        <div class="form-group">
                            <label>Coluna: Guild Dona</label>
                            <input type="text"
                                   name="castlesiege[castle_column_owner]"
                                   value="<?= htmlspecialchars($plugin['config']['castle_column_owner'] ?? 'OWNER_GUILD') ?>">
                        </div>
                        <div class="form-group">
                            <label>Coluna: Início</label>
                            <input type="text"
                                   name="castlesiege[castle_column_start]"
                                   value="<?= htmlspecialchars($plugin['config']['castle_column_start'] ?? 'SIEGE_START_DATE') ?>">
                        </div>
                        <div class="form-group">
                            <label>Coluna: Fim</label>
                            <input type="text"
                                   name="castlesiege[castle_column_end]"
                                   value="<?= htmlspecialchars($plugin['config']['castle_column_end'] ?? 'SIEGE_END_DATE') ?>">
                        </div>
                    </div>
                    <hr style="margin: 20px 0; border-color: var(--adm-border-soft);">
                    <div class="grid-2">
                        <div class="form-group">
                            <label>Tabela de Guild</label>
                            <input type="text"
                                   name="castlesiege[guild_table]"
                                   value="<?= htmlspecialchars($plugin['config']['guild_table'] ?? 'Guild') ?>">
                            <small class="form-hint">Tabela com os dados das guilds</small>
                        </div>
                        <div class="form-group">
                            <label>Coluna: Nome da Guild</label>
                            <input type="text"
                                   name="castlesiege[guild_column_name]"
                                   value="<?= htmlspecialchars($plugin['config']['guild_column_name'] ?? 'G_Name') ?>">
                        </div>
                        <div class="form-group">
                            <label>Coluna: Master</label>
                            <input type="text"
                                   name="castlesiege[guild_column_master]"
                                   value="<?= htmlspecialchars($plugin['config']['guild_column_master'] ?? 'G_Master') ?>">
                        </div>
                        <div class="form-group">
                            <label>Coluna: Mark</label>
                            <input type="text"
                                   name="castlesiege[guild_column_mark]"
                                   value="<?= htmlspecialchars($plugin['config']['guild_column_mark'] ?? 'G_Mark') ?>">
                        </div>
                    </div>
                </div>
            </section>

            <section class="adm-card adm-card--full settings-card--submit">
                <button type="submit" class="btn btn-primary">
                    <i class="ph ph-floppy-disk"></i> Salvar Configurações
                </button>
            </section>
        </div>
    </form>
</div>
