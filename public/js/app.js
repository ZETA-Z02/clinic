var host = 'localhost';
var proyect = 'clinic';
var protocol = 'http';
var url = `${protocol}://${host}/${proyect}`;

$(document).ready(function(){
   modal();
});
function modal(){
    $(document).click(function(){
        $(".modal__message").css('display', 'none');
    });
}
function modalError(){
    $("#modal-error").css('display', 'block');
}
function modalSuccess(){
    $("#modal-success").css('display', 'block');
}
// ABRIR MODAL-> FUNCTION GLOBAL
// FALTA DARLE ESTILO AL MODAL PARA QUE SE VEAN
function abrirModal(modalId){
    $(".modal").hide();
    $(`#${modalId}`).show();
}
function cerrarModal(modalId){
    $(`#${modalId}`).hide();
}

function validar(variable){
    return typeof variable !== 'undefined' && variable !== null && variable !== '';
}