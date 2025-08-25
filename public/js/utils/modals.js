export function modal(){
    $(document).click(function(){
        $(".modal__message").css('display', 'none');
    });
}
export function modalError(){
    $("#modal-error").css('display', 'block');
}
export function modalSuccess(){
    $("#modal-success").css('display', 'block');
}