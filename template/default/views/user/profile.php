<?= $this->layout('components/layouts/web') ?>

<style>
    .profile-page {
        max-width: 700px;
        margin: 0 auto;
        padding: 24px;
    }
    .profile-page .page-header {
        margin-bottom: 32px;
    }
    .profile-page .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }
    .profile-page .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .profile-page .profile-action-info {
        flex: 1;
    }
</style>

<div class="profile-page">
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="page-title">Perfil</div>
                <div class="page-subtitle">Alterar senha, email, abrir ticket e mais.</div>
            </div>
            <a href="<?= route('user.info') ?>" class="btn-back">
                <i class="ph ph-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>

    <div class="profile-actions">
        <a href="javascript:void(0)" class="profile-action-card" onclick="openPasswordPopup(); return false;">
            <span class="profile-action-link">
                <span class="profile-action-icon"><i class="ph ph-key"></i></span>
                <span class="profile-action-info">
                    <span class="profile-action-title">Alterar senha</span>
                    <span class="profile-action-desc">Acessar</span>
                </span>
                <span class="profile-action-arrow"><i class="ph ph-caret-right"></i></span>
            </span>
        </a>
        <a href="javascript:void(0)" class="profile-action-card" onclick="openEmailPopup(); return false;">
            <span class="profile-action-link">
                <span class="profile-action-icon"><i class="ph ph-envelope"></i></span>
                <span class="profile-action-info">
                    <span class="profile-action-title">Alterar email</span>
                    <span class="profile-action-desc">Acessar</span>
                </span>
                <span class="profile-action-arrow"><i class="ph ph-caret-right"></i></span>
            </span>
        </a>
        <a href="javascript:void(0)" class="profile-action-card" onclick="openTicketPopup(); return false;">
            <span class="profile-action-link">
                <span class="profile-action-icon"><i class="ph ph-ticket"></i></span>
                <span class="profile-action-info">
                    <span class="profile-action-title">Abrir ticket</span>
                    <span class="profile-action-desc">Acessar</span>
                </span>
                <span class="profile-action-arrow"><i class="ph ph-caret-right"></i></span>
            </span>
        </a>
        <a href="<?= route('user.ticket') ?>" class="profile-action-card">
            <span class="profile-action-link">
                <span class="profile-action-icon"><i class="ph ph-chat-circle-dots"></i></span>
                <span class="profile-action-info">
                    <span class="profile-action-title">Mensagens / Chamados</span>
                    <span class="profile-action-desc">Acessar</span>
                </span>
                <span class="profile-action-arrow"><i class="ph ph-caret-right"></i></span>
            </span>
        </a>
        <a href="<?= route('user.logout') ?>" class="profile-action-card profile-action-danger">
            <span class="profile-action-link">
                <span class="profile-action-icon"><i class="ph ph-sign-out"></i></span>
                <span class="profile-action-info">
                    <span class="profile-action-title">Sair</span>
                    <span class="profile-action-desc">Encerrar sessão</span>
                </span>
                <span class="profile-action-arrow"><i class="ph ph-caret-right"></i></span>
            </span>
        </a>
    </div>
</div>
