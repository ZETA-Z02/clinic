import ApiService from "../../public/js/api/apiservice.js";
import { search } from "../../public/js/utils/search.js";
import { dni } from "../../public/js/services/dni.js";

class Etiquetas extends ApiService {
    constructor() {
        super();
        this.controller = "etiquetas";
    }
    async init(){
        try{
            await this.getEtiquetas();
            this.nuevaEtiqueta();
            this.editarEtiqueta();
            this.eliminarEtiqueta();
            await this.getPersonal();
            this.nombreEtiqueta();
            this.modalesEtiquetas();
        } catch(error){
            console.error("Error en init etiquetas",error);
        }
    }
    async getEtiquetas() {
        try {
            const data = await this.read(this.controller, "get");
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
            console.log("error en obtener etiquetas" + error);
        }
    }
    nuevaEtiqueta() {
        $("#form-etiquetas").submit(async (e) => {
            e.preventDefault();
            let data = {
                id: $("#id").val(),
                color: $("#color").val(),
                nombre: $("#nombre").val(),
                idpersonal: $("#select-personal").val(),  
            };
            
            //console.log(data);
            await this.create(data, this.controller, "create");
            e.target.reset();
            await this.getEtiquetas();
        });
    }
    editarEtiqueta() {
        const that = this;
        $(document).on("click", "#btn-editar", async function () {
            let id = $(this).attr("id-data");
            try {
                const data = await that.readOne(id, that.controller, "getOne");
                //console.log(data);
                $("#id").val(data.idetiqueta);
                $("#color").val(data.color);
                $("#nombre").val(data.nombre);
                $("#select-personal").val(data.idpersonal);
            } catch (error) {
                console.log("ERROR al obtener ONE etiqueta" + error);
            }
        });
    }
    async getPersonal() {
        try {
            const data = await this.read(this.controller, "getPersonal");
            //console.log(data);
            let html = "";
            data.forEach((element) => {
                html += `<option value="${element.id}" data-nombre="${element.nombres}">${element.nombres}</option>`;
            });
            $("#select-personal").html(html);
        } catch (error) {
            console.log("ERROR al obtener personal" + error);
        }
    }
    eliminarEtiqueta() {
        const that = this;
        $(document).on("click", "#btn-eliminar", async function () {
            let id = $(this).attr("id-data");
            await that.delete(id, that.controller, "delete");
            await that.getEtiquetas();
        });
    }
    nombreEtiqueta() {
        $("#select-personal").change(function () {
            let personal = $("#select-personal option:selected")
                .data("nombre")
                .split(" ");
            let iniciales = personal[0][0] + personal[1][0];
            $("#nombre").val(iniciales);
        });
    }
    modalesEtiquetas() {
        $("#formulario-etiquetas").hide();
        $(document).on("click", "#btn-editar,#btn-nuevaetiqueta", function () {
            $("#formulario-etiquetas").show();
            $("#table-etiquetas").hide();
        });
        $("#btn-guardar,#btn-cancelar").click(function () {
            $("#formulario-etiquetas").hide();
            $("#table-etiquetas").show();
        });
    }
}

document.addEventListener("DOMContentLoaded", async()=>{
    const etiquetas = new Etiquetas();
    await etiquetas.init();
});