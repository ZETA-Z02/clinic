import ApiService from "../../public/js/api/apiservice.js";
import { search } from "../../public/js/utils/search.js";
import { dni } from "../../public/js/services/dni.js";
class Personal extends ApiService {
    constructor() {
        super();
        this.controller = "personal";
        // console.log(this.url, this.controller);
    }
    async init(){
        try{
            this.modalNuevoCliente();
            await this.getPersonal();
            this.nuevoPersonal();
        }catch (error){
            console.error("Error en init personal",error);
        }
    }
    async getPersonal() {
        try {
            const data = await this.read(this.controller, "get");
            // console.log(data);
            let html = "";
            data.forEach((element) => {
                html += `
                <tr>
                    <td>${element.nombre}</td>
                    <td>${element.apellido}</td>
                    <td>${element.dni}</td>
                    <td>${element.telefono}</td>
                    <td><a href="${this.url}/personal/detalles/${element.id}" class="button btn-info">Detalles</a></td>
                    <td><a href="${this.url}/personal/login/${element.id}" class="button btn-success">Login</a></td>
                </tr>
            `;
            });
            $("#data-personal").html(html);
            initPaginador(5, "data-personal", "paginador");
        } catch (error) {
            console.error("ERROR en obtener personal", error);
        }
    }
    nuevoPersonal() {
        $("#form-nuevopersonal").submit(async (e)=> {
            e.preventDefault();
            let data = {
                dni: $("#dni").val(),
                telefono: $("#telefono").val(),
                nombre: $("#nombre").val(),
                apellido: $("#apellido").val(),
                nombre_etiqueta: $("#nombre_etiqueta").val(),
                color: $("#color").val(),
                username: $("#username").val(),
                password: $("#password").val(),
            };
            await this.create(data, "personal", "nuevoPersonal");
            e.target.reset();
            $(".nuevopersonal").css("display", "none");
            $(".overlay").css("display", "none");
            $("#nuevologin").hide();
            $("#btn-guardar").hide();
            // $("#nuevopersonal").show();
            this.getpersonal();
            $("#form-nuevopersonal").trigger("reset");
        });
    }
    modalNuevoCliente() {
        $("#btn-nuevopersonal").click(function () {
            $(".nuevopersonal").css("display", "block");
            $(".overlay").css("display", "block");
            $("#btn-siguiente").show();
        });
        $("#btn-cerrar-nuevopersonal").click(function () {
            $(".nuevopersonal").css("display", "none");
            $(".overlay").css("display", "none");
        });
        $("#nuevologin").hide();
        $("#btn-guardar").hide();
        $("#btn-siguiente").click(function () {
            $("#nuevologin").show();
            $("#btn-guardar").show();
            $("#btn-siguiente").hide();
            //$("#nuevopersonal").hide();
            // Nombre de la etiqueta
            let nombre = $("#nombre").val();
            let apellido = $("#apellido").val();
            let nombreEtiqueta = nombre[0] + apellido[0];
            $("#nombre_etiqueta").val(nombreEtiqueta);
            //console.log(nombre[0], apellido[0]);
        });
    }    
}

document.addEventListener("DOMContentLoaded", async()=>{
    const personal = new Personal();
    await personal.init();
    // Plugins
    search("search-personal", "table-personal-data");
    dni();
});
