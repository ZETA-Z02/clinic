var host = 'localhost';
var proyect = 'clinic';

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