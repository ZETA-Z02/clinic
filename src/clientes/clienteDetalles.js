import ApiService from "../../public/js/api/apiservice.js";

class ClientesDetalles extends ApiService {
    constructor() {
        super();
        this.controller = "clientes";
    }
    async init(){
        this.update();
    }
    update() {
        $("#btn-actualizar-detalles").on("click", async () => {

            let data = {
                idcliente: $("#idcliente").val(),
                nombre: $("#nombre").val(),
                apellido: $("#apellido").val(),
                dni: $("#dni").val(),
                telefono: $("#telefono").val(),
                email: $("#email").val(),
                sexo: $("#genero").val(),
                ciudad: $("#ciudad").val(),
                direccion: $("#direccion").val(),

                antecedente: $("#antecedente:checked").val(),
                antecedente_observacion: $("#antecedente_observacion").val(),

                medicamento: $("#medicamento:checked").val(),
                medicado_observacion: $("#medicado_observacion").val(),

                anestesia: $("#anestesia:checked").val(),
                anestesia_observacion: $("#anestesia_observacion").val(),

                alergiamedicamento: $("#alergia_medicamento:checked").val(),
                alergiamedicamento_observacion: $("#alergiamedicamento_observacion").val(),

                hemorragias: $("#hemorragias:checked").val(),
                hemorragias_observacion: $("#hemorragias_observacion").val(),

                enfermedad: $("#enfermedad").val(),
                observaciones: $("#observaciones").val(),
            };
            console.log(data);
            await this.create(data, this.controller, "actualizarCliente");
            window.location.reload();
        });
    }
}
document.addEventListener("DOMContentLoaded", async() => {
    const clienteDetalles = new ClientesDetalles();
    await clienteDetalles.init();
});
