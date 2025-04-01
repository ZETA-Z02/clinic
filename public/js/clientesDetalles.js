$(document).ready(function(){
    update();
});
function update(){
    $("#form-cliente").submit(function(e){
        e.preventDefault();
        let respuestas = {};
        document.querySelectorAll("input[type='radio']:checked").forEach((input)=>{
            respuestas[input.name] = input.value;
        });
        let data = $(this).serialize();
        //console.log(data);
        insert(data,'clientes','actualizarCliente');
    });
}