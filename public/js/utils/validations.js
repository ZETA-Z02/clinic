// VALIDA INPUTS NUMERICOS FLOTANTES
export function numberFloat(selector) {
  $(selector).on("input", function () {
    $(this).val(
      $(this)
        .val()
        .replace(/[^0-9.]/g, "")
    );
  });
}
// VALIDA INPUTS ALFANUMERICOS
export function justStrings(selector) {
  $(selector).on("input", function () {
    $(this).val(
      $(this)
        .val()
        .replace(/[^a-zA-Z\s.,&-]/g, "")
    );
  });
}
// VALIDA INPUTS NUMERICOS
export function numberLeght(selector, maxLength) {
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
// VALIDA UNA VARIABLE PARA QUE NO SEA NULL, UNDEFINED, UN STRING VACIO
export function validar(variable){
    return typeof variable !== 'undefined' && variable !== null && variable !== '';
}

