import ApiService from "../../public/js/api/apiservice.js";
import { search } from "../../public/js/utils/search.js";
import { dni } from "../../public/js/services/dni.js";
import { numberLeght, numberFloat } from "../../public/js/utils/validations.js";
class Clientes extends ApiService {
    constructor() {
        super();
        this.controller = "clientes";
    }
    async init() {        
        // MODAL CLIENTES
        await this.getClientes();
        this.modalNuevoCliente();
        this.nuevoCliente();
        
    }
    async getClientes() {
        try {
            const data = await this.read(this.controller, "get");
            let html = "";
            //console.log(data);
            data.forEach((element) => {
                html += `                    
                            <tr>
                                <td><a class="button btn-success" href='${this.url}/pagos/render/${element.id}'>Nuevo Pago</a></td>
                                <td>${element.apellido}</td>
                                <td>${element.nombre}</td>
                                <td>${element.dni}</td>
                                <td>${element.telefono}</td>
                                <td><a class="button btn-primary" id-data='${element.id}' href='${this.url}/clientes/citas/${element.id}'>Citas</a></td>
                                <td><a href='${this.url}/clientes/detalles/${element.id}' class="button btn-info">Detalles</a></td>
                            </tr>
                                `;
            });
            $("#clientes-data").html(html);
            initPaginador(5, "clientes-data", "paginador-clientes");
        } catch (error) {
            console.error("Error en obtener clientes", error);
        }
    }
    modalNuevoCliente() {
        $("#btn-nuevocliente").click(function () {
            $(".nuevocliente").css("display", "block");
            $(".overlay").css("display", "block");
        });
        $("#btn-cerrar-nuevocliente").click(function () {
            $(".nuevocliente").css("display", "none");
            $(".overlay").css("display", "none");
        });
    }
    nuevoCliente() {
        $("#form-nuevocliente").submit(async (e) => {
            e.preventDefault();
            let data = {
                dni: $("#dni").val(),
                telefono: $("#telefono").val(),
                nombre: $("#nombre").val(),
                apellido: $("#apellido").val(),
                direccion: $("#direccion").val(),
            };
            await this.create(data, this.controller, "nuevoCliente");
            await this.getClientes();
            $(".nuevocliente").css("display", "none");
            $(".overlay").css("display", "none");
            e.target.reset();
        });
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    const clientes = new Clientes();
    await clientes.init();
    //VALIDAR INPUTS
    numberLeght("#telefono", 9);
    numberLeght("#dni", 8);
    numberFloat("#totalpagar,#primerpago");
    //VALIDAR INPUTS END
    dni();
    search("search-clientes", "table-clientes-data");

});
