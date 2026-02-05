<?= $this->layout('components/layouts/web') ?>

<div class="row" style="display: flex; gap: 24px; margin-bottom: 24px; align-items: flex-start;">

    <div style="flex: 1.5; min-width: 300px; display: flex; flex-direction: column; gap: 24px;">

        <div class="card server-info-card">
            <div class="card-header">
                <h2><?= __("home.info") ?></h2>
            </div>
            <div class="server-info-grid">
                <div class="info-item">
                    <span class="info-label"><?= __("home.name") ?></span>
                    <span class="info-value"><?= htmlspecialchars(config('server.name', 'WebRox')) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><?= __("home.version") ?></span>
                    <span class="info-value"><?= htmlspecialchars(config('server.version', 'Season X')) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><?= __("home.experience") ?></span>
                    <span class="info-value"><?= htmlspecialchars(config('server.experience', '1000x')) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><?= __("home.drop") ?></span>
                    <span class="info-value"><?= htmlspecialchars(config('server.drop', '50%')) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><?= __("home.level") ?></span>
                    <span class="info-value"><?= htmlspecialchars(config('server.level', '400')) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><?= __("home.points") ?></span>
                    <span class="info-value"><?= htmlspecialchars(config('server.points_attributes', '32767')) ?></span>
                </div>
            </div>
        </div>

        <?= $this->insert('plugins/donate/home_widget', [
            'donatePluginEnabled' => $donatePluginEnabled,
            'donatePlans' => $donatePlans
        ]) ?>

        <?php if (config('plugins.discord.enabled')): ?>
            <div class="card discord-card">
                <a href="<?= config('plugins.discord.config.invite', '#') ?>" target="_blank" class="discord-content">
                    <div class="discord-header">
                        <i class="ph-fill ph-discord-logo"></i>
                        <span><?= __("home.discord") ?></span>
                    </div>
                    <div class="discord-status" id="discord-status"
                        data-guild-id="<?= config('plugins.discord.config.server_id', '') ?>"
                        data-fake-count="<?= config('plugins.discord.config.member_count', 0) ?>"
                        data-label-online="<?= htmlspecialchars(__("server.online_now")) ?>"
                        data-label-join="<?= htmlspecialchars(__("server.join_us")) ?>">
                        <?= __("server.loading") ?>
                    </div>
                    <div class="discord-avatars" id="discord-avatars"></div>
                </a>
            </div>
        <?php endif; ?>

        <script>
            // Discord Widget Status (só corre na home; sair se os elementos não existirem)
            (function () {
                const statusEl = document.getElementById('discord-status');
                const avatarsEl = document.getElementById('discord-avatars');
                if (!statusEl || !avatarsEl) return;

                const guildId = statusEl.getAttribute('data-guild-id');
                const fakeCount = parseInt(statusEl.getAttribute('data-fake-count') || '0', 10);

                const labelOnline = statusEl.getAttribute('data-label-online') || 'Online agora';
                const labelJoin = statusEl.getAttribute('data-label-join') || 'Junte-se a nós';
                const updateUI = (onlineCount, members = []) => {
                    const count = onlineCount > 0 ? onlineCount : (fakeCount > 0 ? fakeCount : 0);

                    if (count > 0) {
                        statusEl.innerHTML = `
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                <div><span style="color:#10b981">●</span> ${labelOnline}: ${count}</div>
                                <div class="text-xs" style="color: #9ca3af; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">${labelJoin}</div>
                            </div>
                        `;
                    } else {
                        statusEl.textContent = labelJoin;
                    }

                    if (members.length > 0) {
                        const avatarList = members.slice(0, 5);
                        avatarsEl.innerHTML = avatarList.map(member => {
                            const avatar = member.avatar_url || 'https://cdn.discordapp.com/embed/avatars/0.png';
                            return `<img src="${avatar}" alt="${member.username}" class="discord-avatar" title="${member.username}">`;
                        }).join('');
                    } else if (count > 0) {
                        // Se não houver membros da API, mostrar alguns placeholders circulares para manter o visual
                        avatarsEl.innerHTML = Array(5).fill(0).map((_, i) =>
                            `<div class="discord-avatar text-xs" style="background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.2);">
                                <i class="ph ph-user"></i>
                            </div>`
                        ).join('');
                    }
                };

                if (!guildId) {
                    updateUI(fakeCount);
                    return;
                }

                fetch(`https://discord.com/api/guilds/${guildId}/widget.json`)
                    .then(res => res.json())
                    .then(data => {
                        updateUI(data.presence_count || 0, data.members || []);
                    })
                    .catch(() => {
                        updateUI(fakeCount);
                    });
            })();
        </script>
    </div>

    <div style="flex: 3.5; min-width: 0;">
        <?php if (!empty($sliderPluginEnabled)): ?>
            <div class="card slider-card" style="margin-bottom: 24px;">
                <?php if (!empty($sliders)): ?>
                    <?= $this->insert('plugins/slider/index', ['sliders' => $sliders]) ?>
                <?php else: ?>
                    <div class="slider-empty-state">
                        <i class="ph ph-images text-5xl slider-empty-icon" aria-hidden="true"></i>
                        <p class="text-md slider-empty-title"><?= __("slider.empty_message") ?></p>
                        <p class="text-base slider-empty-desc"><?= __("slider.empty_config") ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($hallfamePluginEnabled) && !empty($rankings)): ?>
            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h2>Hall da Fama</h2>
                </div>
                <?= $this->insert('plugins/hallfame/box', ['rankings' => $rankings]) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($noticePluginEnabled)): ?>
            <div class="card">
                <div class="card-header">
                    <h2><?= __("notice.latest") ?></h2>
                    <a href="<?= route('notices') ?>" class="btn btn-primary text-sm" style="padding: 6px 12px;"><?= __("notice.view_all") ?></a>
                </div>
                <?php if (!empty($notices)): ?>
                    <?= $this->insert('plugins/notice/home', ['notices' => $notices]) ?>
                <?php else: ?>
                    <div style="padding: 40px; text-align: center; color: #999;">
                        <i class="ph ph-newspaper text-5xl" style="margin-bottom: 10px; opacity: 0.3;"></i>
                        <p style="margin: 0;"><?= __("notice.none_published") ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div style="flex: 1.5; display: flex; flex-direction: column; gap: 24px; min-width: 300px;">
        <?php if (!empty($castlesiegePluginEnabled) && $castle !== null): ?>
            <div class="card" style="margin-bottom: 0;">
                <?= $this->insert('plugins/castlesiege/box', ['castle' => $castle]) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($events) || !empty($invasions)): ?>
            <?= $this->insert('plugins/event/widget', [
                'events' => $events ?? [],
                'invasions' => $invasions ?? [],
                'serverSod' => $serverSod ?? 0
            ]) ?>
        <?php endif; ?>
    </div>
</div>
</div>

