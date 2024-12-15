$(document).ready(function(){
    search("search-personal", "table-personal-data");
    getpersonal();
    modalNuevoCLiente();
    nuevopersonal();
    dni();
});
// MODAL NUEVO PERSONAL BUTTONS
function modalNuevoCLiente() {
    $("#btn-nuevopersonal").click(function () {
      $(".nuevopersonal").css("display", "block");
      $(".overlay").css("display", "block");
    });
    $("#btn-cerrar-nuevopersonal").click(function () {
      $(".nuevopersonal").css("display", "none");
      $(".overlay").css("display", "none");
    });
    $("#nuevologin").hide();
    $("#btn-guardar").hide();
    $("#btn-siguiente").click(function(){
        $("#nuevologin").show();
        $("#btn-guardar").show();
        $("#btn-siguiente").hide();
        $("#nuevopersonal").hide();
    });
  }
function getpersonal(){
    (async () => {
        try{
            const data = await get('personal','get');
            console.log(data);
            let html = '';
            data.forEach((element) => {
                html += `
                    <tr>
                        <td>${element.nombre}</td>
                        <td>${element.apellido}</td>
                        <td>${element.dni}</td>
                        <td>${element.telefono}</td>
                        <td><a href="http://${host}/${proyect}/personal/detalles/${element.id}" class="button btn-info">Detalles</a></td>
                        <td><a href="http://${host}/${proyect}/personal/login/${element.id}" class="button btn-success">Login</a></td>
                    </tr>
                `;
            });
            $("#data-personal").html(html);
            initPaginador(5, "data-personal", "paginador");
        } catch (error){
            console.error("ERROR en obtener personal",error);
        }
    })();
}
function nuevopersonal(){
    $("#form-nuevopersonal").submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        insert(data,'personal','nuevoPersonal');
        e.target.reset();
        $(".nuevopersonal").css("display", "none");
        $(".overlay").css("display", "none");
        getpersonal();
    })
}
function updatepersonal(){
    $("#form-updatepersonal").submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        insert(data,'personal','updatePersonal');
        e.target.reset();
    })
}