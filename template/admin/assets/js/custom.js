document.addEventListener('DOMContentLoaded', () => {

    /* ==========================
       RANKING CACHE TOGGLE
    ========================== */
    const rankingCacheEnabled = document.getElementById('ranking-cache-enabled');
    const rankingCacheSettings = document.getElementById('ranking-cache-settings');
    
    if (rankingCacheEnabled && rankingCacheSettings) {
        rankingCacheEnabled.addEventListener('change', function() {
            rankingCacheSettings.style.display = this.checked ? 'block' : 'none';
        });
    }

    /* ==========================
       RANKING FIELDS - REMOVE REQUIRED WHEN DISABLED
    ========================== */
    // Remover required de campos quando ranking está desativado
    function setupRankingToggle() {
            // Para rankings geral
        const geralContainer = document.getElementById('rankings-geral-container');
        if (geralContainer) {
            geralContainer.querySelectorAll('input[name*="[geral]"][name*="[enabled]"]').forEach(checkbox => {
                const rankingItem = checkbox.closest('.ranking-item');
                if (!rankingItem) return;
                
                // Removido: não adicionar required automaticamente
                // Os campos não são mais obrigatórios
            });
        }
    }
    
    // Executar ao carregar
    setupRankingToggle();
    
    // Observar novos rankings adicionados dinamicamente
    const observer = new MutationObserver(function() {
        setupRankingToggle();
    });
    
    const geralContainer = document.getElementById('rankings-geral-container');
    if (geralContainer) observer.observe(geralContainer, { childList: true, subtree: true });

    /* ==========================
       SITE SETTINGS TOGGLES
    ========================== */
    // Título
    const siteTitleEnabled = document.getElementById('site-title-enabled');
    const siteTitleGroup = document.getElementById('site-title-group');
    if (siteTitleEnabled && siteTitleGroup) {
        siteTitleEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            siteTitleGroup.style.display = isEnabled ? 'block' : 'none';
            // Desabilitar campos quando ocultos para não enviar no formulário
            const inputs = siteTitleGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;
                // Se desabilitado, remover required; se habilitado, adicionar required
                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');
                }
            });
        });
        // Aplicar estado inicial
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

    // Logo
    const siteLogoEnabled = document.getElementById('site-logo-enabled');
    const siteLogoGroup = document.getElementById('site-logo-group');
    if (siteLogoEnabled && siteLogoGroup) {
        siteLogoEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            siteLogoGroup.style.display = isEnabled ? 'block' : 'none';
            // Desabilitar campos quando ocultos para não enviar no formulário
            const inputs = siteLogoGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;
                // Se desabilitado, remover required; se habilitado, adicionar required e garantir valor padrão
                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');
                    // Se o campo estiver vazio quando ativado, preencher com valor padrão
                    if (input.value.trim() === '') {
                        input.value = 'images/logo.png';
                    }
                }
            });
        });
        // Aplicar estado inicial
        const logoInputs = siteLogoGroup.querySelectorAll('input, textarea');
        logoInputs.forEach(input => {
            const isEnabled = siteLogoEnabled.checked;
            input.disabled = !isEnabled;
            if (!isEnabled) {
                input.removeAttribute('required');
            } else {
                input.setAttribute('required', 'required');
                // Se o campo estiver vazio, preencher com valor padrão
                if (input.value.trim() === '') {
                    input.value = 'images/logo.png';
                }
            }
        });
    }

    // Descrição
    const siteDescriptionEnabled = document.getElementById('site-description-enabled');
    const siteDescriptionGroup = document.getElementById('site-description-group');
    if (siteDescriptionEnabled && siteDescriptionGroup) {
        siteDescriptionEnabled.addEventListener('change', function() {
            const isEnabled = this.checked;
            siteDescriptionGroup.style.display = isEnabled ? 'block' : 'none';
            // Desabilitar campos quando ocultos para não enviar no formulário
            const inputs = siteDescriptionGroup.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = !isEnabled;
                // Se desabilitado, remover required; se habilitado, adicionar required
                if (!isEnabled) {
                    input.removeAttribute('required');
                } else {
                    input.setAttribute('required', 'required');
                }
            });
        });
        // Aplicar estado inicial
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

    // Título da Página
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

    // Footer
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

    /* ==========================
       CLEAR RANKING CACHE
    ========================== */
    window.clearRankingCache = function() {
        if (!confirm('Tem certeza que deseja limpar o cache de rankings? Isso forçará uma atualização de todos os rankings na próxima visualização.')) {
            return;
        }

        const csrfToken = document.querySelector('input[name="_token"]');
        if (!csrfToken) {
            alert('Token CSRF não encontrado. Recarregue a página.');
            return;
        }

        const formData = new FormData();
        formData.append('_token', csrfToken.value);

        fetch(window.CLEAR_RANKING_CACHE_URL || '/admin/settings/clear-ranking-cache', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (typeof Alert !== 'undefined' && typeof Alert.show === 'function') {
                Alert.show(data.title, data.message, data.class || 'info');
            } else {
                alert(data.message);
            }
            
            if (data.refresh) {
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                }, data.class === 'success' ? 1500 : 2000);
            }
        })
        .catch(error => {
            console.error('Erro ao limpar cache:', error);
            alert('Erro ao limpar o cache. Tente novamente.');
        });
    };

    /* ==========================
       TABS
    ========================== */
    document.querySelectorAll('.tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            btn.classList.add('active');
            const target = document.getElementById(btn.dataset.tab);
            if (target) target.classList.add('active');
        });
    });

    /* ==========================
       TOGGLE SENHA DB
    ========================== */
    window.toggleDbPassword = function () {
        const input = document.getElementById('db_pass');
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    };

    /* ==========================
       TESTE CONEXÃO DB
    ========================== */
    window.testDbConnection = function () {
        const data = new FormData();

        data.append(
    'type',
    document.querySelector('input[name="db_type"]:checked')?.value || ''
);
        data.append('ip', document.querySelector('[name=db_ip]')?.value || '');
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

    /* ==========================
       EVENTOS
    ========================== */
    let eventIndex = window.EVENT_INDEX || 0;

    const addEventBtn = document.getElementById('add-event');
    const eventsContainer = document.getElementById('events-container');

    if (addEventBtn && eventsContainer) {
        addEventBtn.addEventListener('click', () => {
            eventsContainer.insertAdjacentHTML('beforeend', `
                <div class="form event-item space-y-1" style="border: 1px solid var(--neutral-300); padding: 15px; border-radius: 8px; background: var(--neutral-700);">
                    <div style="display:flex; justify-content:space-between; align-items:center">
                        <input type="text"
                               name="events[Eventos][${eventIndex}][name]"
                               placeholder="Nome do evento"
                               style="font-weight:bold; flex:1; margin-right:10px;"
                               required>

                        <button type="button"
                                class="btn btn-danger btn-sm remove-event">
                            <i class="ph ph-trash"></i> Remover
                        </button>
                    </div>

                    <div>
                        <label>
                            <input type="hidden"
                                   name="events[Eventos][${eventIndex}][enabled]"
                                   value="0">
                            <input type="checkbox"
                                   name="events[Eventos][${eventIndex}][enabled]"
                                   value="1"
                                   checked>
                            Ativo
                        </label>
                    </div>

                    <div>
                        <label>Duração (minutos)</label>
                        <input type="number"
                               name="events[Eventos][${eventIndex}][eventTime]"
                               value="10"
                               placeholder="10"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Tempo de duração do evento em minutos
                        </small>
                    </div>

                    <div>
                        <label>Horários (HH:MM, separados por vírgula)</label>
                        <input type="text"
                               name="events[Eventos][${eventIndex}][times]"
                               placeholder="08:00, 14:00, 20:00">
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Horários em que o evento será executado (formato 24h)
                        </small>
                    </div>
                </div>
            `);
            eventIndex++;
        });
    }

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-event')) {
            e.target.closest('.event-item')?.remove();
        }
    });

    /* ==========================
       INVASÕES
    ========================== */
    let invasionIndex = window.INVASION_INDEX || 0;

    const addInvasionBtn = document.getElementById('add-invasion');
    const invasionsContainer = document.getElementById('invasions-container');

    if (addInvasionBtn && invasionsContainer) {
        addInvasionBtn.addEventListener('click', () => {
            invasionsContainer.insertAdjacentHTML('beforeend', `
                <div class="form invasion-item space-y-1" style="border: 1px solid var(--neutral-300); padding: 15px; border-radius: 8px; background: var(--neutral-700);">
                    <div style="display:flex; justify-content:space-between; align-items:center">
                        <input type="text"
                               name="invasions[${invasionIndex}][name]"
                               placeholder="Nome da invasão"
                               style="font-weight:bold; flex:1; margin-right:10px;"
                               required>

                        <button type="button"
                                class="btn btn-danger btn-sm remove-invasion">
                            <i class="ph ph-trash"></i> Remover
                        </button>
                    </div>

                    <div>
                        <label>
                            <input type="hidden"
                                   name="invasions[${invasionIndex}][enabled]"
                                   value="0">
                            <input type="checkbox"
                                   name="invasions[${invasionIndex}][enabled]"
                                   value="1"
                                   checked>
                            Ativa
                        </label>
                    </div>

                    <div>
                        <label>Duração (minutos)</label>
                        <input type="number"
                               name="invasions[${invasionIndex}][duration]"
                               value="10"
                               placeholder="10"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Tempo de duração da invasão em minutos
                        </small>
                    </div>

                    <div>
                        <label>Horários (HH:MM, separados por vírgula)</label>
                        <input type="text"
                               name="invasions[${invasionIndex}][times]"
                               placeholder="08:00, 14:00, 20:00">
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Horários em que a invasão será executada (formato 24h)
                        </small>
                    </div>
                </div>
            `);
            invasionIndex++;
        });
    }

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-invasion')) {
            e.target.closest('.invasion-item')?.remove();
        }
    });

    /* ==========================
       USER - COINS
    ========================== */
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
                                class="btn btn-danger btn-sm remove-coin">
                            <i class="ph ph-trash"></i> Remover
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
            
            // Atualizar título quando o usuário digitar
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
    
    // Atualizar títulos dos coins existentes quando o campo título for alterado
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

        // Atualizar título do ID do mapa quando o campo ID for alterado
        if (e.target.classList.contains('map-id-input')) {
            const mapIndex = e.target.dataset.mapIndex;
            const titleElement = document.querySelector(`.map-id-title-${mapIndex}`);
            const mapItem = e.target.closest('.map-item');
            
            if (titleElement) {
                const idValue = e.target.value || '0';
                titleElement.textContent = `ID ${idValue}`;
            }
            
            // Atualizar data-id do elemento para que a remoção funcione corretamente
            if (mapItem) {
                const idValue = e.target.value || '0';
                mapItem.dataset.id = idValue;
            }
        }

        // Atualizar título do ID do character quando o campo ID for alterado
        if (e.target.classList.contains('character-id-input')) {
            const charIndex = e.target.dataset.characterIndex;
            const titleElement = document.querySelector(`.character-id-title-${charIndex}`);
            const charItem = e.target.closest('.character-item');
            
            if (titleElement) {
                const idValue = e.target.value || '0';
                titleElement.textContent = `ID ${idValue}`;
            }
            
            // Atualizar data-id do elemento para que a remoção funcione corretamente
            if (charItem) {
                const idValue = e.target.value || '0';
                charItem.dataset.id = idValue;
            }
        }
    });

    /* ==========================
       MAPAS
    ========================== */
    let mapIndex = document.querySelectorAll('.map-item').length || 0;

    // Event listener único para mapas
    document.addEventListener('click', function (e) {
        // REMOVER COIN
        if (e.target.classList.contains('remove-coin') || e.target.closest('.remove-coin')) {
            e.target.closest('.coin-item')?.remove();
            return;
        }

        // REMOVER RANKING GERAL
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

        // REMOVER MAPA
        if (e.target.closest('.remove-map')) {
            e.preventDefault();
            e.stopPropagation();
            
            const item = e.target.closest('.map-item');
            if (!item) return;

            const id = item.dataset.id;

            // mapa existente → marca para remoção
            if (id !== undefined) {
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

        // REMOVER CHARACTER
        if (e.target.closest('.remove-character')) {
            e.preventDefault();
            e.stopPropagation();
            
            const item = e.target.closest('.character-item');
            if (!item) return;

            const id = item.dataset.id;

            if (id !== undefined) {
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

        // ADICIONAR MAPA
        if (e.target.closest('#add-map')) {
            e.preventDefault();
            e.stopPropagation();
            
            const container = document.getElementById('maps-container');
            if (!container) {
                console.error('Container maps-container não encontrado');
                return;
            }

            const block = document.createElement('div');
            block.className = 'form map-item space-y-1';
            
            // Calcular próximo ID (pegar o maior ID existente + 1)
            const existingMaps = container.querySelectorAll('.map-item[data-id]');
            let nextId = 0;
            if (existingMaps.length > 0) {
                const ids = Array.from(existingMaps).map(item => {
                    const id = parseInt(item.dataset.id);
                    return isNaN(id) ? 0 : id;
                });
                nextId = Math.max(...ids) + 1;
            }

            block.setAttribute('data-id', nextId);

            block.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong class="sub-title map-id-title-new-${mapIndex}">ID ${nextId}</strong>
                    <button type="button" class="btn btn-danger btn-sm remove-map">
                        <i class="ph ph-trash"></i> Remover
                    </button>
                </div>

                <div>
                    <label>ID do Mapa</label>
                    <input type="number"
                           name="new_map[${mapIndex}][id]"
                           value="${nextId}"
                           class="map-id-input"
                           data-map-index="new-${mapIndex}"
                           required>
                </div>

                <div>
                    <label>Nome do Mapa</label>
                    <input type="text"
                           name="new_map[${mapIndex}][name]"
                           required>
                </div>

                <div class="grid-2">
                    <div>
                        <label>Posição X</label>
                        <input type="number"
                               name="new_map[${mapIndex}][position][x]"
                               value="0"
                               required>
                    </div>
                    <div>
                        <label>Posição Y</label>
                        <input type="number"
                               name="new_map[${mapIndex}][position][y]"
                               value="0"
                               required>
                    </div>
                </div>
            `;

            container.appendChild(block);
            mapIndex++;
        }

        // ADICIONAR CHARACTER
        if (e.target.closest('#add-character')) {
            e.preventDefault();
            e.stopPropagation();
            
            const container = document.getElementById('characters-container');
            if (!container) {
                console.error('Container characters-container não encontrado');
                return;
            }

            const block = document.createElement('div');
            block.className = 'form character-item space-y-1';
            
            const existingCharacters = container.querySelectorAll('.character-item[data-id]');
            let nextId = 0;
            if (existingCharacters.length > 0) {
                const ids = Array.from(existingCharacters).map(item => {
                    const id = parseInt(item.dataset.id);
                    return isNaN(id) ? 0 : id;
                });
                nextId = Math.max(...ids) + 1;
            }

            block.dataset.id = nextId;
            
            block.innerHTML = `
                <div class="flex-between-center">
                    <strong class="sub-title character-id-title-${nextId}">Novo (ID: ${nextId})</strong>
                    <button type="button" class="btn btn-danger btn-sm remove-character">
                        <i class="ph ph-trash"></i> Remover
                    </button>
                </div>

                <div>
                    <label>ID da Classe</label>
                    <input type="number"
                           name="new_character[${nextId}][id]"
                           value="${nextId}"
                           class="character-id-input"
                           data-character-index="${nextId}"
                           required>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        ID numérico da classe
                    </small>
                </div>

                <div>
                    <label>Nome</label>
                    <input type="text"
                           name="new_character[${nextId}][name]"
                           placeholder="Dark Wizard"
                           required>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Nome completo da classe
                    </small>
                </div>

                <div>
                    <label>Sigla</label>
                    <input type="text"
                           name="new_character[${nextId}][short_name]"
                           placeholder="DW"
                           required>
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                        Abreviação/sigla da classe
                    </small>
                </div>
            `;

            container.appendChild(block);
            
            const newCharIdInput = block.querySelector('.character-id-input');
            const newCharIdTitle = block.querySelector('.character-id-title-' + nextId);
            if (newCharIdInput && newCharIdTitle) {
                newCharIdInput.addEventListener('input', function() {
                    newCharIdTitle.textContent = `ID ${this.value}` || 'Novo (ID: )';
                    block.dataset.id = this.value; // Update data-id for removal
                });
            }
            return;
        }

        // ADICIONAR RANKING GERAL
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
                    <button type="button" class="btn btn-danger btn-sm remove-ranking-geral">
                        <i class="ph ph-trash"></i> Remover
                    </button>
                </div>

                <div>
                    <label>Título</label>
                    <input type="text"
                           name="new_rankings[geral][${rankingIndex}][title]"
                           placeholder="Resets Diários"
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
                               placeholder="Character"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Nome da tabela no banco de dados
                        </small>
                    </div>

                    <div>
                        <label>Coluna</label>
                        <input type="text"
                               name="new_rankings[geral][${rankingIndex}][column]"
                               placeholder="ResetsDay"
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
                               placeholder="RD"
                               required>
                        <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">
                            Abreviação/tag do ranking (ex: RD, RS, PK, HR)
                        </small>
                    </div>

                    <div>
                        <label>Slug</label>
                        <input type="text"
                               name="new_rankings[geral][${rankingIndex}][slug]"
                               placeholder="resets-diarios"
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

    /* ==========================
       SERVERS STATUS
    ========================== */
    let serverIndex = document.querySelectorAll('.server-item').length || 0;

    const addServerBtn = document.getElementById('add-server');
    const serversContainer = document.getElementById('servers-container');

    if (addServerBtn && serversContainer) {
        addServerBtn.addEventListener('click', () => {
            serversContainer.insertAdjacentHTML('beforeend', `
                <div class="form server-item" style="margin-bottom:15px">
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <strong>Servidor</strong>
                        <button type="button" class="btn btn-danger btn-sm remove-server">
                            Remover
                        </button>
                    </div>

                    <label>Nome do Servidor</label>
                    <input type="text" name="online_servers[list][${serverIndex}][name]" placeholder="Servidor Easy">
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome exibido no site</small>

                    <label>Nome da Sala</label>
                    <input type="text" name="online_servers[list][${serverIndex}][server_name]" placeholder="Server01">
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Nome do servidor no banco de dados (ServerName)</small>

                    <label>IP do Servidor</label>
                    <input type="text" name="online_servers[list][${serverIndex}][ip]" placeholder="127.0.0.1">
                    <small style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Endereço IP do servidor do jogo</small>

                    <label>Porta</label>
                    <input type="number" name="online_servers[list][${serverIndex}][port]" placeholder="55901">

                    <label>Máximo de Players</label>
                    <input type="number" name="online_servers[list][${serverIndex}][max_players]" placeholder="100" min="1">
                </div>
            `);

            serverIndex++;
        });
    }

    // Função para reindexar os servidores após remoção
    function reindexServers() {
        const serverItems = document.querySelectorAll('.server-item');
        serverItems.forEach((item, index) => {
            // Atualizar todos os inputs dentro deste item
            const inputs = item.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name && input.name.includes('online_servers[list][')) {
                    // Substituir o índice antigo pelo novo índice
                    input.name = input.name.replace(/online_servers\[list\]\[\d+\]/, `online_servers[list][${index}]`);
                }
            });
        });
        // Atualizar o serverIndex para o próximo servidor adicionado
        serverIndex = serverItems.length;
    }

    // Adicionar remover servidor
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-server') || e.target.closest('.remove-server')) {
            const serverItem = e.target.closest('.server-item');
            if (serverItem) {
                serverItem.remove();
                // Reindexar os servidores restantes para evitar gaps nos índices
                reindexServers();
            }
        }
    });

    // Reindexar servidores antes de enviar o formulário
    const settingsForm = document.querySelector('form[action*="settings"]');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function() {
            reindexServers();
        });
    }

    /* ==========================
       DDOS ROUTES (ADICIONAR/REMOVER)
    ========================== */
    let ddosRouteIndex = window.ddosRouteIndex || 0;
    
    // Adicionar rota DDoS
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
                               placeholder="/login" 
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
                <button type="button" class="btn btn-danger btn-sm remove-ddos-route" style="margin-top: 8px;">
                    <i class="ph ph-trash"></i> Remover
                </button>
            `;
            
            container.appendChild(newRoute);
            ddosRouteIndex++;
        });
    }
    
    // Remover rota DDoS
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

    /* ==========================
       RECAPTCHA VERSION TOGGLE
    ========================== */
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

    /* ==========================
       HALL OF FAME (PLUGIN)
    ========================== */
    
    // Adicionar ranking home (hallfame)
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
                    <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][title]" placeholder="Resets">
                </div>
                <div class="grid-2">
                    <div>
                        <label>Tabela</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][table]" placeholder="Character">
                    </div>
                    <div>
                        <label>Coluna</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][column]" placeholder="ResetCount">
                    </div>
                </div>
                <div class="grid-2">
                    <div>
                        <label>Tag</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][tag]" placeholder="RR">
                    </div>
                    <div>
                        <label>Slug</label>
                        <input type="text" name="hallfame[home][display][${hallfameHomeIndex}][slug]" placeholder="resets">
                    </div>
                </div>
                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #333;">
                    <button type="button" class="btn btn-danger btn-sm remove-hallfame-home">
                        <i class="ph ph-trash"></i> Remover
                    </button>
                </div>
            `;
            
            container.appendChild(newRanking);
            hallfameHomeIndex++;
        });
    }

    // Remover ranking home (hallfame)
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

