document.addEventListener('DOMContentLoaded', () => {

const rankingCacheEnabled = document.getElementById('ranking-cache-enabled');
    const rankingCacheSettings = document.getElementById('ranking-cache-settings');
    
    if (rankingCacheEnabled && rankingCacheSettings) {
        rankingCacheEnabled.addEventListener('change', function() {
            rankingCacheSettings.style.display = this.checked ? 'block' : 'none';
        });
    }

function setupRankingToggle() {

        const geralContainer = document.getElementById('rankings-geral-container');
        if (geralContainer) {
            geralContainer.querySelectorAll('input[name*="[geral]"][name*="[enabled]"]').forEach(checkbox => {
                const rankingItem = checkbox.closest('.ranking-item');
                if (!rankingItem) return;


            });
        }
    }

    setupRankingToggle();

    const observer = new MutationObserver(function() {
        setupRankingToggle();
    });
    
    const geralContainer = document.getElementById('rankings-geral-container');
    if (geralContainer) observer.observe(geralContainer, { childList: true, subtree: true });

const siteTitleEnabled = document.getElementById('site-title-enabled');
    const siteTitleGroup = document.getElementById('site-title-group');
    if (siteTitleEnabled && siteTitleGroup) {
        siteTitleEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            siteTitleGroup.style.display = isEnabled ? 'block' : 'none';

            const inputs = siteTitleGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;

                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');
                }
            });
        });

        const titleInputs = siteTitleGroup.querySelectorAll('input, textarea');
        titleInputs.forEach(input => {
            input.disabled = !siteTitleEnabled.checked;
            if (!siteTitleEnabled.checked) {
                input.removeAttribute('required');
            } else {
                input.setAttribute('required', 'required');
            }
        });
    }

    const siteLogoEnabled = document.getElementById('site-logo-enabled');
    const siteLogoGroup = document.getElementById('site-logo-group');
    if (siteLogoEnabled && siteLogoGroup) {
        siteLogoEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            siteLogoGroup.style.display = isEnabled ? 'block' : 'none';

            const inputs = siteLogoGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;

                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');

                    if (input.value.trim() === '') {
                        input.value = 'images/logo.png';
                    }
                }
            });
        });

        const logoInputs = siteLogoGroup.querySelectorAll('input, textarea');
        logoInputs.forEach(input => {
            const isEnabled = siteLogoEnabled.checked;
            input.disabled = !isEnabled;
            if (!isEnabled) {
                input.removeAttribute('required');
            } else {
                input.setAttribute('required', 'required');

                if (input.value.trim() === '') {
                    input.value = 'images/logo.png';
                }
            }
        });
    }

    const siteDescriptionEnabled = document.getElementById('site-description-enabled');
    const siteDescriptionGroup = document.getElementById('site-description-group');
    if (siteDescriptionEnabled && siteDescriptionGroup) {
        siteDescriptionEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            siteDescriptionGroup.style.display = isEnabled ? 'block' : 'none';

            const inputs = siteDescriptionGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;

                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');
                }
            });
        });

        const descInputs = siteDescriptionGroup.querySelectorAll('input, textarea');
        descInputs.forEach(input => {
            input.disabled = !siteDescriptionEnabled.checked;
            if (!siteDescriptionEnabled.checked) {
                input.removeAttribute('required');
            } else {
                input.setAttribute('required', 'required');
            }
        });
    }

    const sitePageTitleEnabled = document.getElementById('site-page-title-enabled');
    const sitePageTitleGroup = document.getElementById('site-page-title-group');
    if (sitePageTitleEnabled && sitePageTitleGroup) {
        sitePageTitleEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            sitePageTitleGroup.style.display = isEnabled ? 'block' : 'none';
            const inputs = sitePageTitleGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;
                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');
                    if (input.value.trim() === '') {
                        input.value = 'Web Roxmu - Servidor de Mu Online';
                    }
                }
            });
        });
        const pageTitleInputs = sitePageTitleGroup.querySelectorAll('input, textarea');
        pageTitleInputs.forEach(input => {
            const isEnabled = sitePageTitleEnabled.checked;
            input.disabled = !isEnabled;
            if (!isEnabled) {
                input.removeAttribute('required');
            } else {
                input.setAttribute('required', 'required');
                if (input.value.trim() === '') {
                    input.value = 'Web Roxmu - Servidor de Mu Online';
                }
            }
        });
    }

    const siteFooterEnabled = document.getElementById('site-footer-enabled');
    const siteFooterGroup = document.getElementById('site-footer-group');
    if (siteFooterEnabled && siteFooterGroup) {
        siteFooterEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            siteFooterGroup.style.display = isEnabled ? 'block' : 'none';
            const inputs = siteFooterGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;
                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');
                    if (input.value.trim() === '') {
                        input.value = 'Web Roxmu';
                    }
                }
            });
        });
        const footerInputs = siteFooterGroup.querySelectorAll('input, textarea');
        footerInputs.forEach(input => {
            const isEnabled = siteFooterEnabled.checked;
            input.disabled = !isEnabled;
            if (!isEnabled) {
                input.removeAttribute('required');
            } else {
                input.setAttribute('required', 'required');
                if (input.value.trim() === '') {
                    input.value = 'Web Roxmu';
                }
            }
        });
    }

window.clearRankingCache = function() {
        const csrfToken = document.querySelector('input[name="_token"]');
        const resultEl = document.getElementById('clear-ranking-cache-result');
        function showResult(success, message) {
            if (resultEl) {
                resultEl.classList.remove('settings-feedback--success', 'settings-feedback--error');
                resultEl.classList.add(success ? 'settings-feedback--success' : 'settings-feedback--error');
                resultEl.textContent = message;
                resultEl.style.display = 'block';
            }
        }
        if (!csrfToken) {
            showResult(false, 'Token CSRF não encontrado. Recarregue a página.');
            return;
        }

        const formData = new FormData();
        formData.append('_token', csrfToken.value);

        fetch(window.CLEAR_RANKING_CACHE_URL || '/admin/settings/clear-ranking-cache', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(function(response) {
            if (!response.ok) throw new Error('Resposta ' + response.status);
            return response.json();
        })
        .then(function(data) {
            var isSuccess = (data.class || '') === 'success';
            showResult(isSuccess, data.message || (isSuccess ? 'Cache limpo com sucesso.' : 'Erro ao limpar o cache.'));
            if (data.refresh && data.redirect) {
                setTimeout(function() { window.location.href = data.redirect; }, 1500);
            }
        })
        .catch(function(error) {
            console.error('Erro ao limpar cache:', error);
            showResult(false, 'Erro ao limpar o cache. Tente novamente.');
        });
    };

const settingsNavItems = document.querySelectorAll('.settings-tabs__item');
    const settingsPanels = document.querySelectorAll('.settings-panel');
    if (settingsNavItems.length) {
        settingsNavItems.forEach(btn => {
            btn.addEventListener('click', () => {
                settingsNavItems.forEach(b => { b.classList.remove('active'); b.classList.remove('is-selected'); });
                settingsPanels.forEach(panel => panel.classList.remove('active'));

                btn.classList.add('active', 'is-selected');
                const target = document.getElementById(btn.dataset.tab);
                if (target) {
                    target.classList.add('active');
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

window.toggleDbPassword = function () {
        const input = document.getElementById('db_pass');
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    };

window.testDbConnection = function () {
        const data = new FormData();

        data.append(
    'type',
    document.querySelector('input[name="db_type"]:checked')?.value || ''
);
        data.append('ip', document.querySelector('[name=db_ip]')?.value || '');
        data.append('port', document.querySelector('[name=db_port]')?.value || '');
        data.append('dbname', document.querySelector('[name=db_name]')?.value || '');
        data.append('user', document.querySelector('[name=db_user]')?.value || '');
        data.append('pass', document.getElementById('db_pass')?.value || '');

        fetch(window.TEST_DB_URL, {
            method: 'POST',
            body: data
        })
        .then(r => r.json())
        .then(res => {
            const box = document.getElementById('db-test-result');
            if (!box) return;

            box.innerHTML = `
                <span style="
                    padding:6px 10px;
                    border-radius:6px;
                    background:${res.success ? '#1f7a3f' : '#7a1f1f'};
                    color:#fff;
                    font-size:13px;
                ">
                    ${res.message}
                </span>
            `;
        })
        .catch(() => {
            const box = document.getElementById('db-test-result');
            if (box) {
                box.innerHTML = '<span style="color:#ff6b6b">Erro ao testar conexão</span>';
            }
        });
    };

let eventIndex = window.EVENT_INDEX || 0;

    const addEventBtn = document.getElementById('add-event');
    const eventsContainer = document.getElementById('events-container');

    if (addEventBtn && eventsContainer) {
        addEventBtn.addEventListener('click', () => {
            eventsContainer.insertAdjacentHTML('beforeend', `
                <div class="admin-plan-card event-item">
                    <div class="admin-plan-header">
                        <input type="text"
                               name="events[Eventos][${eventIndex}][name]"
                               class="admin-plan-title-input"
                               required>

                        <button type="button"
                                class="btn btn-danger btn-sm remove-event" title="Remover">
                            <i class="ph ph-x" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="adm-field adm-field--inline">
                        <input type="hidden"
                               name="events[Eventos][${eventIndex}][enabled]"
                               value="0">
                        <label>
                            <input type="checkbox"
                                   name="events[Eventos][${eventIndex}][enabled]"
                                   value="1"
                                   checked>
                            <span>Evento ativo</span>
                        </label>
                    </div>

                    <div class="adm-fields">
                        <div class="adm-field">
                            <label>Duração (minutos)</label>
                            <input type="number"
                                   name="events[Eventos][${eventIndex}][eventTime]"
                                   value="10"
                                   required>
                            <small class="form-hint">
                                Tempo total em minutos em que o evento permanecerá ativo.
                            </small>
                        </div>

                        <div class="adm-field">
                            <label>Horários (HH:MM, separados por vírgula)</label>
                            <input type="text"
                                   name="events[Eventos][${eventIndex}][times]"
>
                            <small class="form-hint">
                                Utilize horário 24h. Ex.: 08:00,14:00,20:00.
                            </small>
                        </div>
                    </div>
                </div>
            `);
            eventIndex++;
        });
    }

    document.addEventListener('click', e => {
        const removeEventBtn = e.target.closest('.remove-event');
        if (removeEventBtn) {
            removeEventBtn.closest('.event-item')?.remove();
        }
    });

let invasionIndex = window.INVASION_INDEX || 0;

    const addInvasionBtn = document.getElementById('add-invasion');
    const invasionsContainer = document.getElementById('invasions-container');

    if (addInvasionBtn && invasionsContainer) {
        addInvasionBtn.addEventListener('click', () => {
            invasionsContainer.insertAdjacentHTML('beforeend', `
                <div class="admin-plan-card invasion-item">
                    <div class="admin-plan-header">
                        <input type="text"
                               name="invasions[${invasionIndex}][name]"
                               class="admin-plan-title-input"
                               required>

                        <button type="button"
                                class="btn btn-danger btn-sm remove-invasion" title="Remover">
                            <i class="ph ph-x" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="adm-field adm-field--inline">
                        <input type="hidden"
                               name="invasions[${invasionIndex}][enabled]"
                               value="0">
                        <label>
                            <input type="checkbox"
                                   name="invasions[${invasionIndex}][enabled]"
                                   value="1"
                                   checked>
                            <span>Invasão ativa</span>
                        </label>
                    </div>

                    <div class="adm-fields">
                        <div class="adm-field">
                            <label>Duração (minutos)</label>
                            <input type="number"
                                   name="invasions[${invasionIndex}][duration]"
                                   value="10"
                                   required>
                            <small class="form-hint">
                                Tempo total em minutos em que a invasão permanece ativa.
                            </small>
                        </div>

                        <div class="adm-field">
                            <label>Horários (HH:MM, separados por vírgula)</label>
                            <input type="text"
                                   name="invasions[${invasionIndex}][times]"
>
                            <small class="form-hint">
                                Utilize horário 24h. Ex.: 08:00,14:00,20:00.
                            </small>
                        </div>
                    </div>
                </div>
            `);
            invasionIndex++;
        });
    }

    document.addEventListener('click', e => {
        const removeInvasionBtn = e.target.closest('.remove-invasion');
        if (removeInvasionBtn) {
            removeInvasionBtn.closest('.invasion-item')?.remove();
        }
    });

let coinIndex = window.COIN_INDEX || 0;

    const coinsContainer = document.getElementById('coins-container');
    const addCoinBtn = document.getElementById('add-coin');

    if (addCoinBtn && coinsContainer) {
        addCoinBtn.addEventListener('click', () => {
            const coinId = `coin-${coinIndex}`;
            coinsContainer.insertAdjacentHTML('beforeend', `
                <div class="form coin-item space-y-1" data-coin-id="${coinId}">
                    <div style="display:flex; justify-content:space-between; align-items:center">
                        <strong class="sub-title coin-title-${coinIndex}">Coin</strong>
                        <button type="button"
                                class="btn btn-danger btn-sm remove-coin" title="Remover">
                            <i class="ph ph-x" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div>
                        <label>Título</label>
                        <input type="text"
                               name="user[coins][${coinIndex}][title]"
                               class="coin-title-input"
                               data-coin-index="${coinIndex}"
                               required>
                    </div>

                    <div>
                        <label>Tabela</label>
                        <input type="text"
                               name="user[coins][${coinIndex}][table]"
                               required>
                    </div>

                    <div>
                        <label>Coluna Conta</label>
                        <input type="text"
                               name="user[coins][${coinIndex}][column_account]"
                               required>
                    </div>

                    <div>
                        <label>Coluna Coin</label>
                        <input type="text"
                               name="user[coins][${coinIndex}][column_coin]"
                               required>
                    </div>
                </div>
            `);

            const titleInput = coinsContainer.querySelector(`.coin-title-input[data-coin-index="${coinIndex}"]`);
            if (titleInput) {
                titleInput.addEventListener('input', function() {
                    const titleElement = coinsContainer.querySelector(`.coin-title-${coinIndex}`);
                    if (titleElement) {
                        titleElement.textContent = this.value || 'Coin';
                    }
                });
            }
            
            coinIndex++;
        });
    }

    document.addEventListener('input', e => {
        if (e.target.classList.contains('coin-title-input') || 
            (e.target.closest('.coin-item') && e.target.name && e.target.name.includes('[title]'))) {
            const coinItem = e.target.closest('.coin-item');
            if (coinItem) {
                const titleInput = coinItem.querySelector('input[name*="[title]"]');
                const titleElement = coinItem.querySelector('.sub-title');
                if (titleInput && titleElement) {
                    titleElement.textContent = titleInput.value || 'Coin';
                }
            }
        }

        if (e.target.classList.contains('map-id-input')) {
            const mapIndex = e.target.dataset.mapIndex;
            const titleElement = document.querySelector(`.map-id-title-${mapIndex}`);
            const mapItem = e.target.closest('.map-item');
            
            if (titleElement) {
                const idValue = e.target.value || '0';
                titleElement.textContent = `ID ${idValue}`;
            }


            if (mapItem && !mapItem.dataset.new) {
                const idValue = e.target.value || '0';
                mapItem.dataset.id = idValue;
            }
        }

        if (e.target.classList.contains('character-id-input')) {
            const charIndex = e.target.dataset.characterIndex;
            const titleElement = document.querySelector(`.character-id-title-${charIndex}`);
            const charItem = e.target.closest('.character-item');
            
            if (titleElement) {
                const idValue = e.target.value || '0';
                titleElement.textContent = `ID ${idValue}`;
            }

            if (charItem && !charItem.dataset.new) {
                const idValue = e.target.value || '0';
                charItem.dataset.id = idValue;
            }
        }
    });

document.addEventListener('click', function (e) {

        if (e.target.classList.contains('remove-coin') || e.target.closest('.remove-coin')) {
            e.target.closest('.coin-item')?.remove();
            return;
        }

        if (e.target.closest('.remove-ranking-geral')) {
            e.preventDefault();
            e.stopPropagation();
            const item = e.target.closest('.ranking-item');
            if (item) {
                const index = item.dataset.rankingIndex;
                if (index !== undefined) {
                    const form = item.closest('form');
                    if (form) {
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'remove_ranking[geral][' + index + ']';
                        hidden.value = '1';
                        form.appendChild(hidden);
                    }
                }
                item.remove();
            }
            return;
        }

        if (e.target.closest('.remove-map')) {
            e.preventDefault();
            e.stopPropagation();
            
            const item = e.target.closest('.map-item');
            if (!item) return;

            const id = item.dataset.id;

            if (id !== undefined && !item.dataset.new) {
                const form = item.closest('form');
                if (form) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'remove[' + id + ']';
                    hidden.value = '1';
                    form.appendChild(hidden);
                }
            }

            item.remove();
            return;
        }

        if (e.target.closest('.remove-character')) {
            e.preventDefault();
            e.stopPropagation();
            
            const item = e.target.closest('.character-item');
            if (!item) return;

            const id = item.dataset.id;

            if (id !== undefined && !item.dataset.new) {
                const form = item.closest('form');
                if (form) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'remove_character[' + id + ']';
                    hidden.value = '1';
                    form.appendChild(hidden);
                }
            }
            item.remove();
            return;
        }

        if (e.target.closest('#add-map')) {
            e.preventDefault();
            e.stopPropagation();
            
            const container = document.getElementById('new-maps-container') || document.getElementById('maps-container');
            if (!container) {
                console.error('Container maps-container não encontrado');
                return;
            }

            const idInputs = document.querySelectorAll('.map-id-input');
            const ids = Array.from(idInputs)
                .map(i => parseInt(i.value, 10))
                .filter(n => !isNaN(n));
            const nextId = ids.length > 0 ? Math.max(...ids) + 1 : 0;
            const nextMapIndex = document.querySelectorAll('#new-maps-container .map-item').length;

            const block = document.createElement('div');
            block.className = 'map-card map-item';
            block.dataset.new = '1';
            block.dataset.id = nextId;

            block.innerHTML = `
                <div class="map-card__header">
                    <strong class="sub-title map-id-title-new-${nextMapIndex}">ID ${nextId}</strong>
                    <button type="button" class="btn btn-danger btn-sm remove-map" title="Remover mapa"><i class="ph ph-x" aria-hidden="true"></i></button>
                </div>
                <div class="map-card__fields">
                    <div class="field-id">
                        <label>ID</label>
                        <input type="number"
                               name="new_map[${nextMapIndex}][id]"
                               value="${nextId}"
                               class="map-id-input"
                               data-map-index="new-${nextMapIndex}"
                               required>
                    </div>
                    <div class="field-name">
                        <label>Nome</label>
                        <input type="text"
                               name="new_map[${nextMapIndex}][name]"
                               required>
                    </div>
                    <div class="field-x">
                        <label>X</label>
                        <input type="number"
                               name="new_map[${nextMapIndex}][position][x]"
                               value="0"
                               required>
                    </div>
                    <div class="field-y">
                        <label>Y</label>
                        <input type="number"
                               name="new_map[${nextMapIndex}][position][y]"
                               value="0"
                               required>
                    </div>
                </div>
            `;

            container.appendChild(block);
        }

        if (e.target.closest('#add-character')) {
            e.preventDefault();
            e.stopPropagation();
            
            const container = document.getElementById('new-characters-container') || document.getElementById('characters-container');
            if (!container) {
                console.error('Container characters-container não encontrado');
                return;
            }

            const idInputs = document.querySelectorAll('.character-id-input');
            const ids = Array.from(idInputs)
                .map(i => parseInt(i.value, 10))
                .filter(n => !isNaN(n));
            const nextId = ids.length > 0 ? Math.max(...ids) + 1 : 0;

            const block = document.createElement('div');
            block.className = 'character-card character-item';
            block.dataset.new = '1';
            block.dataset.id = nextId;
            
            block.innerHTML = `
                <div class="character-card__header">
                    <strong class="sub-title character-id-title-${nextId}">Novo (ID: ${nextId})</strong>
                    <button type="button" class="btn btn-danger btn-sm remove-character" title="Remover classe"><i class="ph ph-x" aria-hidden="true"></i></button>
                </div>
                <div class="character-card__fields">
                    <div class="field-id">
                        <label>ID</label>
                        <input type="number"
                               name="new_character[${nextId}][id]"
                               value="${nextId}"
                               class="character-id-input"
                               data-character-index="${nextId}"
                               required
                               title="ID numérico da classe">
                    </div>
                    <div class="field-name">
                        <label>Nome</label>
                        <input type="text"
                               name="new_character[${nextId}][name]"
                               required
                               title="Nome completo da classe">
                    </div>
                    <div class="field-short">
                        <label>Sigla</label>
                        <input type="text"
                               name="new_character[${nextId}][short_name]"
                               required
                               title="Abreviação da classe">
                    </div>
                </div>
            `;

            container.appendChild(block);
            
            const newCharIdInput = block.querySelector('.character-id-input');
            const newCharIdTitle = block.querySelector('.character-id-title-' + nextId);
            if (newCharIdInput && newCharIdTitle) {
                newCharIdInput.addEventListener('input', function() {
                    newCharIdTitle.textContent = this.value ? `ID ${this.value}` : `Novo (ID: ${nextId})`;
                });
            }
            return;
        }

        if (e.target.closest('#add-ranking-geral')) {
            e.preventDefault();
            e.stopPropagation();
            
            const container = document.getElementById('rankings-geral-container');
            if (!container) return;

            let rankingIndex = container.querySelectorAll('.ranking-item').length;
            
            const block = document.createElement('div');
            block.className = 'form ranking-item space-y-1';
            block.dataset.rankingIndex = rankingIndex;
            
            block.innerHTML = `
                <div class="flex-between-center">
                    <label>
                        <input type="hidden" name="new_rankings[geral][${rankingIndex}][enabled]" value="0">
                        <input type="checkbox" name="new_rankings[geral][${rankingIndex}][enabled]" value="1" checked>
                        Ativo
                    </label>
                    <button type="button" class="btn btn-danger btn-sm remove-ranking-geral" title="Remover">
                        <i class="ph ph-x" aria-hidden="true"></i>
                    </button>
                </div>

                <div>
                    <label>Título</label>
                    <input type="text"
                           name="new_rankings[geral][${rankingIndex}][title]"
                           required>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Título exibido no ranking
                    </small>
                </div>

                <div class="grid-2">
                    <div>
                        <label>Tabela</label>
                        <input type="text"
                               name="new_rankings[geral][${rankingIndex}][table]"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Nome da tabela no banco de dados
                        </small>
                    </div>

                    <div>
                        <label>Coluna</label>
                        <input type="text"
                               name="new_rankings[geral][${rankingIndex}][column]"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Nome da coluna que será ordenada
                        </small>
                    </div>
                </div>

                <div class="grid-2">
                    <div>
                        <label>Tag</label>
                        <input type="text"
                               name="new_rankings[geral][${rankingIndex}][tag]"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Abreviação/tag do ranking (ex: RD, RS, PK, HR)
                        </small>
                    </div>

                    <div>
                        <label>Slug</label>
                        <input type="text"
                               name="new_rankings[geral][${rankingIndex}][slug]"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Identificador único usado na URL (ex: resets-diarios, pk-total)
                        </small>
                    </div>
                </div>
            `;

            container.appendChild(block);
            return;
        }
    });

const serversContainer = document.getElementById('servers-container');

    function reindexOnlineServers() {
        if (!serversContainer) return;

        const items = serversContainer.querySelectorAll('.server-item');
        items.forEach((item, idx) => {
            item.querySelectorAll('input[name]').forEach((input) => {
                input.name = input.name.replace(/online_servers\\[list\\]\\[\\d+\\]/g, `online_servers[list][${idx}]`);
            });
        });
    }

    let serverIndex = serversContainer ? (serversContainer.querySelectorAll('.server-item').length || 0) : 0;

    const addServerBtn = document.getElementById('add-server');

    if (addServerBtn && serversContainer) {
        addServerBtn.addEventListener('click', () => {
            serversContainer.insertAdjacentHTML('beforeend', `
                <div class="form server-item" style="margin-bottom:15px">
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <strong>Servidor</strong>
                        <button type="button" class="btn btn-danger btn-sm remove-server" title="Remover">
                            <i class="ph ph-x" aria-hidden="true"></i>
                        </button>
                    </div>

                    <label>Nome do Servidor</label>
                    <input type="text" name="online_servers[list][${serverIndex}][name]" >
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome exibido no site</small>

                    <label>Nome da Sala</label>
                    <input type="text" name="online_servers[list][${serverIndex}][room_name]" >
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome no banco de dados (MEMB_STAT.ServerName) para buscar players online</small>

                    <label>IP do Servidor</label>
                    <input type="text" name="online_servers[list][${serverIndex}][ip]" >
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Endereço IP do servidor do jogo</small>

                    <label>Porta</label>
                    <input type="number" name="online_servers[list][${serverIndex}][port]" >

                    <label>Máximo de Players</label>
                    <input type="number" name="online_servers[list][${serverIndex}][max_players]"  min="1">

                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="online_servers[list][${serverIndex}][is_new]" value="1">
                        <span>Marcar como "Novo"</span>
                    </label>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Exibe o badge "NOVO" e destaque no dropdown</small>

                    <label>Legenda</label>
                    <input type="text" name="online_servers[list][${serverIndex}][legend]" >
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Texto abaixo do nome do servidor no site</small>

                    <label>Ícone</label>
                    <select name="online_servers[list][${serverIndex}][icon]">
                        <option value="">Padrão (automático)</option>
                        <option value="fire">Fogo</option>
                        <option value="sword">Espada</option>
                        <option value="shield">Escudo</option>
                        <option value="crown">Coroa</option>
                        <option value="trophy">Troféu</option>
                        <option value="game-controller">Controle / Jogo</option>
                        <option value="lightning">Raio</option>
                        <option value="star">Estrela</option>
                        <option value="skull">Caveira</option>
                        <option value="flag">Bandeira</option>
                        <option value="gem">Diamante</option>
                        <option value="book-open-text">Livro / Clássico</option>
                        <option value="crosshair">Mira</option>
                        <option value="planet">Planeta</option>
                        <option value="sword-cross">Espadas cruzadas</option>
                        <option value="shield-checkered">Escudo xadrez</option>
                    </select>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Ícone ao lado do nome no site</small>
                </div>
            `);

            serverIndex++;
            reindexOnlineServers();
        });
    }

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-server') || e.target.closest('.remove-server')) {
            e.target.closest('.server-item')?.remove();
            reindexOnlineServers();
        }
    });

let ddosRouteIndex = window.ddosRouteIndex || 0;

    const addDdosRouteBtn = document.getElementById('add-ddos-route');
    if (addDdosRouteBtn) {
        addDdosRouteBtn.addEventListener('click', () => {
            const container = document.getElementById('ddos-routes-container');
            if (!container) return;
            
            const newRoute = document.createElement('div');
            newRoute.className = 'ddos-route-item space-y-1';
            newRoute.setAttribute('data-index', ddosRouteIndex);
            
            newRoute.innerHTML = `
                <div class="grid-3">
                    <div>
                        <label>Rota</label>
                        <input type="text" 
                               name="ddos[route_limits][${ddosRouteIndex}][route]" 
                               required>
                    </div>
                    <div>
                        <label>Máximo</label>
                        <input type="number" 
                               name="ddos[route_limits][${ddosRouteIndex}][max]" 
                               value="10" 
                               min="1" 
                               required>
                    </div>
                    <div>
                        <label>Janela (segundos)</label>
                        <input type="number" 
                               name="ddos[route_limits][${ddosRouteIndex}][window]" 
                               value="60" 
                               min="1" 
                               required>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-ddos-route" style="margin-top: 8px;" title="Remover">
                    <i class="ph ph-x" aria-hidden="true"></i>
                </button>
            `;
            
            container.appendChild(newRoute);
            ddosRouteIndex++;
        });
    }

    document.addEventListener('click', e => {
        if (e.target.closest('.remove-ddos-route')) {
            e.preventDefault();
            e.stopPropagation();
            const item = e.target.closest('.ddos-route-item');
            if (item) {
                item.remove();
            }
        }
    });

const recaptchaVersionSelect = document.querySelector('select[name="recaptcha[version]"]');
    const recaptchaScoreConfig = document.getElementById('recaptcha-score-config');
    
    if (recaptchaVersionSelect && recaptchaScoreConfig) {
        recaptchaVersionSelect.addEventListener('change', function() {
            if (this.value === 'v3') {
                recaptchaScoreConfig.style.display = 'block';
            } else {
                recaptchaScoreConfig.style.display = 'none';
            }
        });
    }

let hallfameHomeIndex = window.HALLFAME_HOME_INDEX || 0;
    const addHallfameHomeBtn = document.getElementById('add-hallfame-home');
    if (addHallfameHomeBtn) {
        addHallfameHomeBtn.addEventListener('click', () => {
            const container = document.getElementById('hallfame-home-container');
            if (!container) return;
            
            const newRanking = document.createElement('div');
            newRanking.className = 'form ranking-item space-y-1';
            newRanking.setAttribute('data-ranking-index', hallfameHomeIndex);
            
            newRanking.innerHTML = `
                <label>
                    <input type="hidden" name="hallfame[home][display][${hallfameHomeIndex}][enabled]" value="0">
                    <input type="checkbox" name="hallfame[home][display][${hallfameHomeIndex}][enabled]" value="1"> Ativo
                </label>
                <div>
                    <label>Título</label>
                    <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][title]" >
                </div>
                <div class="grid-2">
                    <div>
                        <label>Tabela</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][table]" >
                    </div>
                    <div>
                        <label>Coluna</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][column]" >
                    </div>
                </div>
                <div class="grid-2">
                    <div>
                        <label>Tag</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][tag]" >
                    </div>
                    <div>
                        <label>Slug</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][slug]" >
                    </div>
                </div>
                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #333;">
                    <button type="button" class="btn btn-danger btn-sm remove-hallfame-home" title="Remover">
                        <i class="ph ph-x" aria-hidden="true"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(newRanking);
            hallfameHomeIndex++;
        });
    }

    document.addEventListener('click', e => {
        if (e.target.closest('.remove-hallfame-home')) {
            e.preventDefault();
            e.stopPropagation();
            const item = e.target.closest('.ranking-item');
            if (item) {
                item.remove();
            }
        }
    });
});

