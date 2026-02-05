<!-- Modal admin: edições em popup (estilo principal). Use class "admin-edit-popup" em links para abrir no popup. -->
<div class="admin-modal-overlay" id="admin-modal-overlay" aria-hidden="true">
    <div class="admin-modal" role="dialog" aria-modal="true" aria-labelledby="admin-modal-title" id="admin-modal">
        <div class="admin-modal-header">
            <h2 class="admin-modal-title" id="admin-modal-title">Editar</h2>
            <button type="button" class="admin-modal-close" id="admin-modal-close" aria-label="Fechar">
                <i class="ph ph-x"></i>
            </button>
        </div>
        <div class="admin-modal-body">
            <iframe id="admin-modal-iframe" title="Conteúdo de edição" style="width:100%; min-height:380px; border:0; border-radius:6px; background:var(--bg-input);"></iframe>
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="btn btn-secondary" id="admin-modal-btn-close">
                <i class="ph ph-x"></i> Fechar
            </button>
        </div>
    </div>
</div>
<script>
(function() {
    var overlay = document.getElementById('admin-modal-overlay');
    var titleEl = document.getElementById('admin-modal-title');
    var iframe = document.getElementById('admin-modal-iframe');
    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
    }
    function openModal(t, url) {
        titleEl.textContent = t || 'Editar';
        iframe.src = url || '';
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
    }
    document.getElementById('admin-modal-close').addEventListener('click', closeModal);
    document.getElementById('admin-modal-btn-close').addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e) { if (e.target === overlay) closeModal(); });
    document.addEventListener('click', function(e) {
        var a = e.target.closest('a.admin-edit-popup');
        if (a && a.href) { e.preventDefault(); openModal(a.getAttribute('data-modal-title') || 'Editar', a.href); }
    });
    window.closeAdminModal = closeModal;
    window.openAdminModal = openModal;
})();
</script>
