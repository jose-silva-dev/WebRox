/**
 * PlayStackAlert Plugin - Custom Alert/Modal Library for Web Applications
 * * @version 1.0.0
 * @author Play Stack
 * @company Play Stack Development
 * @profile https://devkavod.com.br/profile/play-stack
 * @license MIT or Commercial (Depende da sua licença, use a que for correta)
 * * ------------------------------------------------------------------------
 * * Descrição:
 * Uma solução leve e personalizável para exibir alertas, confirmações e
 * mensagens de notificação que substitui as caixas de alerta nativas do navegador.
 * * Uso:
 * A instância global é acessada via 'Alert'.
 * - Exibir Mensagem: Alert.show(title, message, type);
 * - Confirmação: Alert.show(title, message, 'warning', { showCancelButton: true }).then(result => { ... });
 */

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

  /**
   * @param {string} title
   * @param {string} message
   * @param {string} type
   * @param {object} options
   * @returns {Promise<boolean>}
   */
  show(title, message, type = "info", options = {}) {
    const defaults = {
      showCancelButton: false,
      confirmButtonText: "OK",
      cancelButtonText: "Cancelar",
    };
    const settings = { ...defaults, ...options };

    this.remove();

    return new Promise((resolve, reject) => {
      this.resolver = resolve;
      this.rejecter = reject;

      const modal = document.createElement("div");
      modal.classList.add("custom-alert-modal");

      modal.innerHTML = `
                <div class="custom-alert-header alert-${type}">
                    <h3 class="custom-alert-title">${title}</h3>
                    <button class="custom-alert-close">&times;</button> 
                </div>
                <div class="custom-alert-content">${message}</div>
                <div class="custom-alert-actions">
                    <button class="custom-alert-confirm alert-${type}">${
        settings.confirmButtonText
      }</button>
                    ${
                      settings.showCancelButton
                        ? `<button class="custom-alert-cancel">${settings.cancelButtonText}</button>`
                        : ""
                    }
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
