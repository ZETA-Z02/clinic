$(document).ready(function(){
    modalnuevoprocedimiento();
   nuevoProcedimiento(); 
   getProcedimientos();
   editarProcedimiento();
   eliminarProcedimiento();
});
function getProcedimientos(){
    $.ajax({
        type: "GET",
        url: `http://${host}/${proyect}/procedimientos/get`,
        dataType: "json",
        success: function (response) {
            //console.log(response);
            let html = '';
            response.forEach((element) => {
                html += `
                    <tr>
                        <td>${element.procedimiento}</td>
                        <td>${element.descripcion}</td>
                        <td>${element.precio}</td>
                        <td>${element.fecha}</td>
                        <td><button class="button btn-info" id="btn-editar" id-data="${element.id}"><i class="fa-solid fa-pen-to-square"></i></button></td>
                        <td><button class="button btn-danger" id="btn-eliminar" id-data="${element.id}"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                `;
            });
            $('#tbody-procedimientos').html(html);
            initPaginador(5,'tbody-procedimientos','paginador-procedimientos');
        },error: function (error){
            console.log('ERROR',error);
        }
    });
}
function nuevoProcedimiento(){
    $("#form-procedimiento").submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        insert(data,'procedimientos','nuevoProcedimiento');
        getProcedimientos();
        e.target.reset();
        $("#procedimiento").val('');
        $("#descripcion").val('');
        $("#precio").val('');
        $("#iniciales").val('');
        $("#id").val('');
    });
}
function editarProcedimiento(){
    $(document).on("click","#btn-editar",function(){
        let id = $(this).attr('id-data');
        //console.log(id);
        (async () => {
            try{
                const data = await getOne(id,'procedimientos','getOne');
                //console.log(data);
                $("#procedimiento").val(data.procedimiento);
                $("#descripcion").val(data.descripcion);
                $("#precio").val(data.precio);
                $("#iniciales").val(data.iniciales);
                $("#id").val(data.idprocedimiento);
            } catch (error){
                console.error("ERROR",error);
            }
        })();
    });
}
function eliminarProcedimiento(){
    $(document).on("click","#btn-eliminar",function(){
        let id = $(this).attr('id-data');
        delet(id,'procedimientos','delete');
        getProcedimientos();
    });
}
function modalnuevoprocedimiento(){
    $("#formulario-procedimiento").hide();
    $(document).on("click","#btn-editar,#btn-nuevoprocedimiento",function(){
        $("#formulario-procedimiento").show();
        $("#tabla-procedimientos").hide();
    });
    $("#btn-guardar,#btn-cancelar").click(function(){
        $("#formulario-procedimiento").hide();
        $("#tabla-procedimientos").show();
    })
}