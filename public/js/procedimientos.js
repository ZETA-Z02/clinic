$(document).ready(function(){
   nuevoProcedimiento(); 
   get();
   editarProcedimiento();
   eliminarProcedimiento();
});
function get(){
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
                        <td>${element.fecha}</td>
                        <td><button class="button btn-info" id="btn-editar" id-data="${element.id}">Editar</button></td>
                        <td><button class="button btn-danger" id="btn-eliminar" id-data="${element.id}">Eliminar</button></td>
                    </tr>
                `;
            });
            $('#tbody-procedimientos').html(html);
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
        e.target.reset();
        get();
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
        get();
    });
}