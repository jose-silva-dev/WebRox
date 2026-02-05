document.addEventListener("DOMContentLoaded", function () {

  $(document).on("submit", "form", function (e) {
    const form = $(this);

    if (!form.length) return;

    const dataAjaxAttr = form.attr('data-ajax');
    if (dataAjaxAttr === 'false') {
      return true; // Permitir submit normal
    }

    e.preventDefault();
    e.stopPropagation();

    const vipSelect = form.find('#vip');
    const hiddenAction = form.find('#hidden-action');
    const hiddenAmount = form.find('#hidden-amount');
    const vipAmountInput = form.find('#vip-amount');
    const vipActionSelect = form.find('#vip-action');

    if (vipSelect.length && hiddenAction.length && hiddenAmount.length) {
      const vipType = vipSelect.val();

      if (vipType == '0') {

        hiddenAction.val('add');
        hiddenAmount.val('0');

        if (vipAmountInput.length) {
          vipAmountInput.prop('required', false);
          vipAmountInput.removeAttr('required');
          vipAmountInput.prop('disabled', true);
          vipAmountInput.removeAttr('name'); // Remover name para não ser enviado no form
        }
      } else {


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

    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      data: new FormData(form[0]),
      processData: false,
      contentType: false,
      dataType: "json",
      beforeSend: function () {

      },

      success: function (response) {
        if (response && response.title && response.message && response.class) {
          if (window.Toast) {
            Toast.show(response.title, response.message, response.class);
          } else if (window.Alert) {
            Alert.show(response.title, response.message, response.class);
          }
        }

        if (response && (response.redirect || response.refresh)) {
          const waitTime = response.class === 'success' ? 1500 : 2500;

          setTimeout(() => {
            if (response.redirect) {
              window.location.replace(response.redirect);
            } else if (response.refresh) {
              window.location.reload();
            }
          }, waitTime);
        }
      },
      error: function (xhr) {
        const errorMsg = `Não foi possível processar a requisição. Status: ${xhr.status}.`;

        if (window.Toast) {
          Toast.show("Erro de Conexão", errorMsg, "error");
        } else if (window.Alert) {
          Alert.show("Erro de Conexão", errorMsg, "error");
        }

        console.error("Erro AJAX:", xhr);
      },
    });

    return false;
  });
});
