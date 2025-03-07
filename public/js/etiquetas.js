$(document).ready(function () {
    getEtiquetas();
    getPersonal();
    nuevaetiqueta();
    modalesetiquetas();
    eliminarEtiqueta();
    editaretiqueta();
    nombreEtiqueta()
});

function getEtiquetas() {
  (async () => {
    try {
      const data = await get("etiquetas", "get");
      let html = "";
      //console.log(data);
      data.forEach((element) => {
        html += `                    
                    <tr>
                        <td><i class="fa-solid fa-tags" style='color:${element.color}'></i></td>
                        <td>${element.personal}</td>
                        <td>${element.nombre}</td>
                        <td><button class="button btn-warning" id-data='${element.id}' id="btn-editar"><i class="fa-solid fa-pen-to-square"></i></button></td>
                        <td><button class="button btn-danger" id="btn-eliminar" id-data="${element.id}"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                        `;
      });
      $("#tbody-etiquetas").html(html);
      initPaginador(5, "tbody-etiquetas", "paginador-etiquetas");
    } catch (error) {
        console.log("error en obtener etiquetas"+error);
    }
  })();
}
function nuevaetiqueta(){
    $("#form-etiquetas").submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        //console.log(data);
        insert(data,'etiquetas','create');
        e.target.reset();
        getEtiquetas();
    })
}
function editaretiqueta(){
    $(document).on('click',"#btn-editar",function(){
        let id = $(this).attr('id-data');
        (async () => {
            try{
                const data = await getOne(id,'etiquetas','getOne');
                //console.log(data);
                $("#id").val(data.idetiqueta);
                $("#color").val(data.color);
                $("#nombre").val(data.nombre);
                $("#select-personal").val(data.idpersonal);    
            }catch(error){
                console.log("ERROR al obtener etiqueta"+error);
            }
        })();
    });
}
function getPersonal(){
    (async () => {
        try{
            const data = await get('etiquetas','getPersonal');
            //console.log(data);
            let html = '';
            data.forEach((element) => {
                html += `
                <option value="${element.id}" data-nombre="${element.nombres}">${element.nombres}</option>        
                `;
            });
            $("#select-personal").html(html);
        }catch(error){
            console.log("ERROR al obtener personal"+error);
        }
    })();
}
function eliminarEtiqueta(){
    $(document).on("click","#btn-eliminar",function(){
        let id = $(this).attr('id-data');
        delet(id,'etiquetas','delete');
        getEtiquetas();
    });
}
function nombreEtiqueta(){
    $("#select-personal").change(function(){
        let personal = $("#select-personal option:selected").data('nombre').split(" ");
        let iniciales = personal[0][0]+personal[1][0];
        $("#nombre").val(iniciales);
    });
}
function modalesetiquetas() {
    $("#formulario-etiquetas").hide();
    $(document).on("click","#btn-editar,#btn-nuevaetiqueta",function(){
        $("#formulario-etiquetas").show();
        $("#table-etiquetas").hide();
    });
    $("#btn-guardar,#btn-cancelar").click(function(){
        $("#formulario-etiquetas").hide();
        $("#table-etiquetas").show();
    })
}
