// VALIDA INPUTS NUMERICOS FLOTANTES
function numberFloat(selector) {
  $(selector).on("input", function () {
    $(this).val(
      $(this)
        .val()
        .replace(/[^0-9.]/g, "")
    );
  });
}
// VALIDA INPUTS ALFANUMERICOS
function justStrings(selector) {
  $(selector).on("input", function () {
    $(this).val(
      $(this)
        .val()
        .replace(/[^a-zA-Z\s.,&-]/g, "")
    );
  });
}
// VALIDA INPUTS NUMERICOS
function numberLeght(selector, maxLength) {
  $(selector).on("input", function () {
    let valor = $(this)
      .val()
      .replace(/[^0-9]/g, "");
    if (valor.length > maxLength) {
      valor = valor.slice(0, maxLength);
    }
    $(this).val(valor);
  });
}



