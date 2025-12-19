document.addEventListener("DOMContentLoaded", function () {
  $("form").on("submit", function (e) {
    e.preventDefault();

    const form = $(this);

    if (!form.length) return;

    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      data: new FormData(form[0]),
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

        if (response && response.redirect) {
          setTimeout(() => {
            window.location.href = response.redirect;
          }, 200);
        }
        if (response && response.refresh) {
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      },
      error: function (xhr) {
        RoxAlert.remove();
        RoxAlert.show(
          "Erro de Conexão",
          `Não foi possível processar a requisição. Status: ${xhr.status}.`,
          "error"
        );
        console.error("Erro AJAX:", xhr);
      },
    });
  });
});
