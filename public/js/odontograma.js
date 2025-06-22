// SUBIR IMAGEN
document.getElementById("file").addEventListener("change", function() {
    let file = this.files[0];
    let fileName = this.files[0] ? this.files[0].name : "Ningún archivo seleccionado";
    document.getElementById("file-name").textContent = fileName;
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let img = document.getElementById("imagen-pieza");
            img.src = e.target.result;
            //img.style.display = "block"; // Mostrar la imagen
        };
        reader.readAsDataURL(file);
    }
});
// SUBIR IMAGEN END 
$(document).ready(function(){
    $("#info-diente").hide();
    InfoPieza();
    getProcedimientos();
    ColorPieza();
});

function InfoPieza(){
    $(".btn-pieza").on("click",async function(){
        $("#info-diente").show();
        ColorPieza();
        let pieza = $(this).data("pieza");
        let diente = $(this).attr("title");
        let idcliente = $("#idcliente").val();
        $("#diente-seleccionado").text(diente);
        $("#diente-input").val(pieza);
        try{
            const data = await getOne({idcliente:idcliente,pieza:pieza},'odontograma','infoPieza');
            console.log(data);
            if(data!==0){
                $("#procedimientos-select").val(data.idprocedimiento);
                $("#diente-input").val();
                $("#idcliente").val();
                $("#observaciones").val(data.observaciones);
                $("#estado").val(data.estado);
                $("#condicion").val(data.condicion);
                $("#imagen-pieza").attr("src",data.imagen);
                Guardar('update');
                //console.log("se debe actualizar el registro");
            }else{
                $("#procedimientos-select").val('');
                //$("#diente-input").val('');
                //$("#idcliente").val('');
                $("#observaciones").val('');
                $("#estado").val('');
                $("#condicion").val('');
                $("#imagen-pieza").attr("src",'');
                Guardar('create');
                //console.log('se debe insertar nuevo registro sobre el diente seleccionado');
            }
        }catch(e){
            console.log("ERROR al obtener un registro o insertarlo",e);
        }
        console.log(diente,idcliente);
    });
}
function Guardar(metodo='create'){
    $("#guardar").off('click').on("click",function(){
        let data = new FormData();
        data.append("procedimiento",$("#procedimientos-select").val());
        data.append("pieza",$("#diente-input").val());
        data.append("idcliente",$("#idcliente").val());
        data.append("observaciones",$("#observaciones").val());
        data.append("estado",$("#estado").val());
        data.append("condicion",$("#condicion").val());
        data.append("imagen",$("#file")[0].files[0]);
        //console.log(data);
        insertWithFiles(data,'odontograma',metodo);
        ColorPieza();
    });
}

async function getProcedimientos(){
    try{
        const data = await get('procedimientos','get');
        let select = $("#procedimientos-select");
        let html = '';
        //console.log(data);
        data.forEach((element)=>{
            html += `<option value="${element.id}">${element.procedimiento}</option>`;
        });
        select.html(html);
    }catch(e){
        console.log("ERROR al obtener procedimientos",e);
    }
}
async function ColorPieza() {
    let idcliente = $("#idcliente").val();
    let piezas = $(".btn-pieza");
    for (let element of piezas) {
        let pieza = $(element).data("pieza");
        try {
            const data = await getOne({ idcliente: idcliente, pieza: pieza }, 'odontograma', 'colorPieza');
            //console.log(data);
            if (data !== 0) {
                $(element).attr("style", `stroke: ${data.color} !important;`);
                $(element).hover(
                    function(){
                    $(this).css(`fill`, `${data.color}99`)
                },function(){
                    $(this).css(`fill`, ``)
                })
            }
        } catch (e) {
            console.log("ERROR obtener colores", e);
        }
    }
}