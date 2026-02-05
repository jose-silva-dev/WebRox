<?= $this->layout('components/layouts/web') ?>

<section class="staff-page">
    <header class="staff-header">
        <h1 class="staff-title"><?= __("staff.title") ?> <?= htmlspecialchars(config('server.name')) ?></h1>
        <div class="accent-line"></div>
        <p class="staff-page-desc"><?= __("staff.subtitle") ?></p>
    </header>

    <div class="staff-grid">
        <?php if ($staffs = resolve('Geral')->getStaffs()): ?>
            <?php foreach ($staffs as $data): ?>
                <?php
                $isOnline = ($data['status'] ?? '') === 'online';
                $statusLabel = $isOnline ? __('common.online') : __('common.offline');
                $statusClass = $isOnline ? 'staff-status--online' : 'staff-status--offline';
                ?>
                <article class="staff-card">
                    <div class="staff-card-avatar">
                        <i class="ph ph-user"></i>
                    </div>
                    <div class="staff-card-body">
                        <h3 class="staff-card-name"><?= htmlspecialchars($data['name'] ?? '') ?></h3>
                        <span class="staff-status <?= $statusClass ?>">
                            <span class="staff-status-dot"></span>
                            <?= htmlspecialchars($statusLabel) ?>
                        </span>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="staff-empty">
                <i class="ph ph-users-three"></i>
                <p><?= __("staff.no_staff") ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
