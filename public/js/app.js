document.addEventListener("DOMContentLoaded", function () {
  // Usar event delegation para garantir que funciona mesmo com Alpine.js
  $(document).on("submit", "form", function (e) {
    const form = $(this);

    if (!form.length) return;

    // Se o formulário tem data-ajax="false", permitir submit normal
    const dataAjaxAttr = form.attr('data-ajax');
    if (dataAjaxAttr === 'false') {
      return true; // Permitir submit normal
    }

    e.preventDefault();
    e.stopPropagation();

    // Preparar campos hidden para VIP Free antes do submit
    const vipSelect = form.find('#vip');
    const hiddenAction = form.find('#hidden-action');
    const hiddenAmount = form.find('#hidden-amount');
    const vipAmountInput = form.find('#vip-amount');
    const vipActionSelect = form.find('#vip-action');
    
    if (vipSelect.length && hiddenAction.length && hiddenAmount.length) {
      const vipType = vipSelect.val();
      
      if (vipType == '0') {
        // Se Free, garantir valores corretos
        hiddenAction.val('add');
        hiddenAmount.val('0');
        // Desabilitar e remover required do campo amount para evitar validação do navegador
        if (vipAmountInput.length) {
          vipAmountInput.prop('required', false);
          vipAmountInput.removeAttr('required');
          vipAmountInput.prop('disabled', true);
          vipAmountInput.removeAttr('name'); // Remover name para não ser enviado no form
        }
      } else {
        // Para outros VIPs, usar valores dos campos visíveis
        // Reabilitar campo amount se estava desabilitado
        if (vipAmountInput.length) {
          vipAmountInput.prop('disabled', false);
          vipAmountInput.prop('required', true);
          vipAmountInput.attr('name', 'amount'); // Restaurar name
        }
        
        if (vipActionSelect.length) {
          hiddenAction.val(vipActionSelect.val());
        }
        if (vipAmountInput.length) {
          hiddenAmount.val(vipAmountInput.val() || '0');
        }
      }
    }

    const formData = new FormData(form[0]);
    
    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      beforeSend: function () {
        Alert.show("Enviando...", "Por favor, aguarde.", "info");
      },

      success: function (response) {
        Alert.remove();

        if (response && response.title && response.message && response.class) {
          Alert.show(response.title, response.message, response.class);
        }

        // Processar redirect: se houver redirect, sempre redirecionar
        // Se não houver redirect mas refresh for true, recarregar página
        if (response && response.redirect) {
          setTimeout(() => {
            // Usar replace() em vez de href para evitar loops de redirecionamento
            window.location.replace(response.redirect);
          }, response.class === 'success' ? 1500 : 2000);
        } else if (response && response.refresh) {
          setTimeout(() => {
            window.location.reload();
          }, response.class === 'success' ? 1500 : 2000);
        }
      },
      error: function (xhr, status, error) {
        Alert.remove();
        Alert.show(
          "Erro de Conexão",
          `Não foi possível processar a requisição. Status: ${xhr.status}.`,
          "error"
        );
      },
    });
    
    return false;
  });
});
