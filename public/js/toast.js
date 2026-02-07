/**
 * Escapa HTML para evitar XSS quando o conteúdo é inserido no DOM.
 */
function escapeHtml(str) {
    if (str == null || typeof str !== "string") return "";
    const div = document.createElement("div");
    div.textContent = str;
    return div.innerHTML;
}

class PlayStackToast {
    constructor() {
        this.container = null;
    }

    createContainer() {
        if (this.container) return;

        this.container = document.createElement('div');
        this.container.id = 'toast-container';
        this.container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        `;
        document.body.appendChild(this.container);
    }

    show(title, message, type = 'info', duration = 3000) {
        this.createContainer();
        const toast = document.createElement('div');
        const safeTitle = escapeHtml(title);
        const safeMessage = escapeHtml(message);
        const safeType = (typeof type === "string" && /^[a-zA-Z0-9_-]+$/.test(type)) ? type : "info";

        toast.className = `toast-item toast-${safeType}`;
        toast.innerHTML = `
            <div class="toast-content">
                <div class="toast-header">
                    <span class="toast-title">${safeTitle}</span>
                    <button type="button" class="toast-close" aria-label="Fechar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="toast-body">${safeMessage}</div>
            </div>
            <div class="toast-progress"></div>
        `;

        this.container.appendChild(toast);

        const timer = setTimeout(() => {
            this.remove(toast);
        }, duration);

        toast.querySelector('.toast-close').onclick = () => {
            clearTimeout(timer);
            this.remove(toast);
        };
    }

    remove(toast) {
        toast.classList.add('toast-leaving');
        toast.addEventListener('animationend', () => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        });
    }
}

window.Toast = new PlayStackToast();
