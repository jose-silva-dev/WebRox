/**
 * Escapa HTML para evitar XSS quando o conteúdo é inserido no DOM.
 * Deve ser usado em todo conteúdo dinâmico (título, mensagem, textos de botões).
 */
function escapeHtml(str) {
  if (str == null || typeof str !== "string") return "";
  const div = document.createElement("div");
  div.textContent = str;
  return div.innerHTML;
}

class PlayStackAlert {
  constructor() {
    this.overlay = document.createElement("div");
    this.overlay.classList.add("custom-alert-overlay");

    this.overlay.addEventListener("click", (e) => {
      if (e.target.classList.contains("custom-alert-overlay")) {
        if (this.resolver) {
          this.resolver(false);
        }
        this.close();
      }
    });
    document.body.appendChild(this.overlay);
  }

show(title, message, type = "info", options = {}) {
    const defaults = {
      showCancelButton: false,
      confirmButtonText: "OK",
      cancelButtonText: "Cancelar",
    };
    const settings = { ...defaults, ...options };

    if (window.Toast && !settings.showCancelButton && settings.confirmButtonText === "OK") {
      Toast.show(title, message, type);
      return Promise.resolve(true);
    }

    this.remove();

    return new Promise((resolve, reject) => {
      this.resolver = resolve;
      this.rejecter = reject;

      const modal = document.createElement("div");
      modal.classList.add("custom-alert-modal");

      const safeTitle = escapeHtml(title);
      const safeMessage = escapeHtml(message);
      const safeConfirm = escapeHtml(settings.confirmButtonText);
      const safeCancel = escapeHtml(settings.cancelButtonText);
      const safeType = (typeof type === "string" && /^[a-zA-Z0-9_-]+$/.test(type)) ? type : "info";

      modal.innerHTML = `
                <div class="custom-alert-header alert-${safeType}">
                    <h3 class="custom-alert-title">${safeTitle}</h3>
                    <button class="custom-alert-close">&times;</button>
                </div>
                <div class="custom-alert-content">${safeMessage}</div>
                <div class="custom-alert-actions">
                    <button class="custom-alert-confirm alert-${safeType}">${safeConfirm}</button>
                    ${settings.showCancelButton ? `<button class="custom-alert-cancel">${safeCancel}</button>` : ""}
                </div>
            `;

      this.overlay.appendChild(modal);
      this.overlay.style.display = "flex";

      const confirmBtn = modal.querySelector(".custom-alert-confirm");
      confirmBtn.addEventListener("click", () => {
        this.close();
        if (this.resolver) {
          this.resolver(true);
        }
      });

      if (settings.showCancelButton) {
        const cancelBtn = modal.querySelector(".custom-alert-cancel");
        cancelBtn.addEventListener("click", () => {
          this.close();
          if (this.resolver) {
            this.resolver(false);
          }
        });
      }

      const closeBtn = modal.querySelector(".custom-alert-close");
      closeBtn.addEventListener("click", () => {
        this.close();
        if (this.resolver) {
          this.resolver(false);
        }
      });
    });
  }

  close() {
    this.overlay.style.display = "none";
    this.overlay.innerHTML = "";

    this.resolver = null;
    this.rejecter = null;
  }

  remove() {
    this.close();
  }
}

const ALERT_INSTANCE = new PlayStackAlert();
window.Alert = ALERT_INSTANCE;
