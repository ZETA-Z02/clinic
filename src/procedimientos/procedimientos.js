import ApiService from "../../public/js/api/apiservice.js";
import { search } from "../../public/js/utils/search.js";
import { dni } from "../../public/js/services/dni.js";
class Procedimientos extends ApiService {
    constructor() {
        super();
        this.controller = "procedimientos";
    }
    async init(){
        try{
            this.modalnuevoprocedimiento();
            await this.getProcedimientos();
            this.nuevoProcedimiento();
            this.editarProcedimiento();
            this.eliminarProcedimiento();
        } catch(error){
            console.error("Error en init procedimientos",error);
        }
    }
    async getProcedimientos() {
        try {
            const data = await this.read(this.controller, "get");
            let html = "";
            data.forEach((element) => {
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
            $("#tbody-procedimientos").html(html);
            initPaginador(5,"tbody-procedimientos","paginador-procedimientos");
        } catch (e) {
            console.log("ERROR en obtener procedimientos", e);
        }
    }
    nuevoProcedimiento() {
        $("#form-procedimiento").submit(async (e) => {
            e.preventDefault();
            let data = {
                procedimiento: $("#procedimiento").val(),
                descripcion: $("#descripcion").val(),
                precio: $("#precio").val(),
                iniciales: $("#iniciales").val(),
                color: $("#color").val(),
                id: $("#id").val(),
            };
            await this.create(data, this.controller, "nuevoProcedimiento");
            await this.getProcedimientos();
            e.target.reset();
            $("#procedimiento").val("");
            $("#descripcion").val("");
            $("#precio").val("");
            $("#iniciales").val("");
            $("#color").val("");
            $("#id").val("");
        });
    }
    editarProcedimiento() {
        const that = this;
        $(document).on("click", "#btn-editar", async function() {
            let id = $(this).attr("id-data");
            $("#titule").html("Editar Procedimiento");
            console.log(id);
            try {
                const data = await that.readOne(id, that.controller, "getOne");
                //console.log(data);
                $("#procedimiento").val(data.procedimiento);
                $("#descripcion").val(data.descripcion);
                $("#precio").val(data.precio);
                $("#iniciales").val(data.iniciales);
                $("#color").val(data.color);
                $("#id").val(data.idprocedimiento);
            } catch (error) {
                console.error("ERROR en obtener el procedimiento para editar",error);
            }
        });
    }
    eliminarProcedimiento() {
        const that = this;
        $(document).on("click", "#btn-eliminar", async function () {
            let id = $(this).attr("id-data");
            console.log(id);
            await that.delete(id, that.controller, "delete");
            await that.getProcedimientos();
        });
    }
    modalnuevoprocedimiento() {
        $("#formulario-procedimiento").hide();
        $("#titule").html("Nuevo Procedimiento");
        $(document).on("click", "#btn-nuevoprocedimiento", function () {
            $("#procedimiento").val("");
            $("#descripcion").val("");
            $("#precio").val("");
            $("#iniciales").val("");
            $("#color").val("");
            $("#formulario-procedimiento").show();
            $("#tabla-procedimientos").hide();
        });
        $(document).on("click", "#btn-editar", function () {
            $("#formulario-procedimiento").show();
            $("#tabla-procedimientos").hide();
        });
        $("#btn-guardar,#btn-cancelar").click(function () {
            $("#formulario-procedimiento").hide();
            $("#tabla-procedimientos").show();
        });
    }
}

document.addEventListener("DOMContentLoaded", async()=>{
    const procedimientos = new Procedimientos();
    await procedimientos.init();
});
