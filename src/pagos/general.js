import ApiService from "../../public/js/api/apiservice.js";

export default class PresupuestoGeneral extends ApiService {
    constructor() {
        super();
        this.idcliente = $("#idcliente").val();
        this.controller = "pagos";
        this.$contenedor = $("#tabla-general");
        this.datapresupuesto = false;
        this.idpresupuestogeneral = null;
    }
    async init() {
        await this.getPresupuestoGeneral();
        //await this.getPresupuestoPagos();
    }
    async getPresupuestoGeneral() {
        // PRESUPUESTO GENERAL -> detalles del presupuesto, procedimientos y precios
        const tbodyGeneral = this.$contenedor.find("#tbody-presupuesto-general");
        const tfoot = this.$contenedor.find("#tfoot-agregar-total-presupuesto");
        let deudaData = 0; // Se verifica si hay deuda en el presupuesto, si ya hay se muestra si no, se muestra el total a pagar en el presupuesto
        try {
            const id = this.idcliente;
            const data = await this.readOne(id, this.controller, "getPresupuestoGeneral");
            console.log(data);
            let html = "";
            if (data.response !== false) {
                this.datapresupuesto = true;
                tfoot.hide();
            }
            if (this.datapresupuesto === false){
                tbodyGeneral.empty();
                tfoot.show();
                return;
            }
            data.forEach((element) => {
                html += `<tr>
                            <td></td>
                            <td>${element.pieza}</td>
                            <td>${element.procedimiento}</td> 
                            <td>${element.precio}</td>
                        </tr>`;
            });
            html += `<tr style="border-top: 1px solid black">
                        <td>${data[0].fecha.split(" ")[0]}</td>
                        <td id="idpresupuestogeneral" data-idpresupuestogeneral="${data[0].idpresupuestogeneral}"></td>
                        <td>Total: </td> 
                        <td>${data[0].total}</td>
                    </tr>`;
            //console.log(data[0].idpresupuestogeneral);
            deudaData = data[0].total;
            $("#idpresupuestogeneral").val(data[0].idpresupuestogeneral);
            this.idpresupuestogeneral = data[0].idpresupuestogeneral;
            tbodyGeneral.html(html);
        } catch (e) {
            console.log("Error en getPresupuestoGeneral", e);
        }
    }
    async getPresupuestoPagos() {
        // Presupuesto total -> Pagos del presupuesto
        const tbodyTotal = this.$contenedor.find("#tbody-presupuesto-total");
        const tfootModificar = $("#tfoot-modificar-presupuesto-general");
        // Verificar si hay presupuesto activo -> sin terminar de pagar
        if (this.datapresupuesto === false) {
            tbodyTotal.empty();
            tfootModificar.hide();
            return false;
        }
        // PRESUPUESTO PAGOS GENERAL
        try {
            const id = this.idcliente;
            const fechaActual = new Date().toISOString().slice(0, 10);
            const data = await getOne({ id, idpresupuestogeneral }, "pagos", "getPresupuestoPagos");
            console.log(data);
            let html = "";
            let importe = 0;
            let total_index = parseFloat(data[0].total);
            let deuda = 0;
            data.forEach((pago) => {
                //console.log(pago);
                importe += parseFloat(pago.importe);
                deuda = parseFloat(pago.total) - importe;
                html += `
                    <tr data-idpresupuestopago="${pago.idpresupuestopago}" data-idpresupuestogeneral="${idpresupuestogeneral}">
                        <td class="text-right">${total_index}</td>
                        <td class="text-center"><input type="text" class="text-center importe-editar general-input-monto" value="${pago.importe}" disabled></td>
                        <td>${deuda}</td>
                        <td class="text-right">${pago.fecha}</td>
                        <td class="row-trash" style="display:none;">
                        <button class="btn-delete-row-presupuesto" data-idpresupuestopago="${pago.idpresupuestopago}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        </td>
                    </tr>
                    `;
                total_index -= parseFloat(pago.importe);
                $("#monto_pagar").val(deuda);
            });
            $("#tbody-presupuesto-total").html(html);
        } catch (error) {
            $("#monto_pagar").val(deudaData);
            console.log("Error en getPresupuestoPagos",error);
        }
    }
    deudaPresupuestoTotal() {
        $("#tbody-presupuesto-total").on(
            "input change",
            "#importe-nuevo",
            function () {
                let importeNuevo = $(this).val();
                let monto = $(".presupuesto-monto").val();
                let deuda = $("#deuda-tabla-presupuesto");
                deuda.html(monto - importeNuevo);
            }
        );
    }
    async NuevoPagoPresupuestoGeneral() {
        try {
            let timeout;
            $(document).on("input change", "#importe-presupuesto", function () {
                numberFloat("#importe-nuevo");
                let trfila = $(this).closest("tr");
                let importe = trfila.find("#importe-presupuesto");
                // REINICIAR EL TIME
                clearTimeout(trfila.data("timeout"));
                // Esperar 1 segundo después de que todos los inputs estén llenos
                timeout = setTimeout(() => {
                    const data = {
                        idcliente: $("#idcliente").val(),
                        importe: importe.val(),
                    };
                    //console.log(data);
                    // Validar si los campos están llenos
                    if (
                        Object.values(data).every(
                            (value) => value.trim() !== ""
                        )
                    ) {
                        insert(data, "pagos", "nuevoPagoPresupuestoGeneral");
                        //console.log(data, "Enviando datos al servidor");
                        importe.val("");
                        getPresupuestoGeneral();
                        //PresupuestoGeneralPagos();
                        generarTablas();
                    }
                }, 2000); // Espera de 2 segundo
                trfila.data("timeout", timeout); //Guardar timeout en la fila
            });
        } catch (e) {
            console.log(
                "Error al insertar nuevo pago con su procedimiento" + e
            );
        }
    }
    eliminarPresupuestoTotal() {
        $("#tbody-presupuesto-total").on(
            "click",
            ".btn-delete-row-presupuesto",
            function () {
                let idpresupuestopago = $(this).data("idpresupuestopago");
                const data = {
                    idpresupuestopago: `${idpresupuestopago}`,
                };
                delet(data, "pagos", "deletePresupuestoPagos");
                generarTablas();
                getPresupuestoGeneral();
            }
        );
    }
    async actualizarFilaPresupuesto() {
        try {
            let timeout;
            $(document).on("input change", ".importe-editar", function () {
                numberFloat(".importe-editar");
                clearTimeout(timeout);
                let trfila = $(this).closest("tr");
                let idpresupuestogeneral = trfila.data("idpresupuestogeneral");
                let idpresupuestopago = trfila.data("idpresupuestopago");
                let importeActualizado = trfila.find(".importe-editar");
                timeout = setTimeout(() => {
                    const data = {
                        idcliente: $("#idcliente").val(),
                        idpresupuestogeneral: `${idpresupuestogeneral}`,
                        idpresupuestopago: `${idpresupuestopago}`,
                        importe: `${importeActualizado.val()}`,
                    };
                    // Validar si los campos están llenos
                    if (
                        Object.values(data).every(
                            (value) => value.trim() !== ""
                        )
                    ) {
                        insert(data, "pagos", "updatePresupuestoPagos");
                        //console.log(data, "Enviando datos al servidor");
                        $(".btn-editar").html("Editar");
                        generarTablas();
                        getPresupuestoGeneral();
                    }
                }, 2000); // Espera de 1 segundo
            });
        } catch (error) {
            console.log(error + "ERROR EN ACTUALIZAR FILA");
        }
    }
    agregarPresupuestoGeneral() {
        let precio_total = 0;
        $("#confirmar-procedimiento").on("click", function () {
            const pieza = $("#pieza-presupuesto").val();
            const procedimiento = $(
                "#procedimiento-presupuesto option:selected"
            ).text();
            const idprocedimiento = $("#procedimiento-presupuesto").val();
            const precio = $("#monto-pagar-presupuesto").val();
            precio_total += parseFloat(precio);
            if (validar(pieza) && validar(idprocedimiento) && validar(precio)) {
                // TABLA
                const tbody = $("#tbody-presupuesto-general");
                html = `<tr data-idprocedimiento="${idprocedimiento}" data-pieza="${pieza}" data-precio="${precio}">
                  <td class="mostrar-fecha"></td>
                  <td>${pieza}</td>
                  <td>${procedimiento}</td>
                  <td class="precio-procedimiento-presupuesto">${precio}</td>
                  <td class="row-trash">
                    <button class="button btn-danger" id="echar-eleccion">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </td>
                </tr>`;
                tbody.append(html);
                $("#pieza-presupuesto,#procedimiento-presupuesto").val("");
                actualizarTotalPagar();
            }
        });
        // ELiminar la eleccion
        $(document).on("click", "#echar-eleccion", function () {
            const tr = $(this).closest("tr");
            tr.remove();
            actualizarTotalPagar();
        });
    }
    actualizarTotalPagar() {
        const tbody = $("#tbody-presupuesto-general");
        let total = 0;
        tbody.find("tr").each(function () {
            const precio = $(this)
                .find(".precio-procedimiento-presupuesto")
                .text();
            total += parseFloat(precio);
        });
        $("#mostrar-total-presupuesto").html(total);
        $("#modificar-mostrar-total-presupuesto").html(total);
    }
    guardarPresupuestoGeneral() {
        $("#guardar-presupuesto-general").on("click", async function () {
            try {
                const tbody = $("#tbody-presupuesto-general");
                const idcliente = $("#idcliente").val();
                const data = {
                    idcliente: idcliente,
                    procedimientos: [],
                };
                tbody.find("tr").each(function () {
                    const idprocedimiento = $(this).data("idprocedimiento");
                    const pieza = $(this).data("pieza");
                    const precio = $(this).data("precio");
                    if (
                        validar(idprocedimiento) &&
                        validar(pieza) &&
                        validar(precio)
                    ) {
                        data.procedimientos.push({
                            idprocedimiento: idprocedimiento,
                            pieza: pieza,
                            precio: precio,
                        });
                    }
                });
                if (data.procedimientos.length > 0) {
                    console.log("data", data);
                    await insertFetch(
                        { data: data },
                        "pagos",
                        "nuevoPresupuestoGeneral",
                        "guardar-presupuesto-general"
                    );
                    getPresupuestoGeneral();
                } else {
                    console.log("No hay datos para guardar");
                }
                tbody.empty(); // Limpiar la tabla después de guardar
            } catch (error) {
                console.log("Error al guardar el presupuesto general: ", error);
            }
        });
    }
    mostrarModificarPresupuestoGeneral() {
        let editing = false;
        $("#mostrar-modifica-presupuesto").on("click", async function () {
            if (!editing) {
                editing = true;
                const tbody = $("#tbody-presupuesto-general");
                const tfoot = $("#total-presupuesto");
                const idpresupuestogeneral = $("#idpresupuestogeneral").data(
                    "idpresupuestogeneral"
                );
                const id = $("#idcliente").val();
                const data = await getOne(
                    id,
                    "pagos",
                    "mostrarModificarPresupuestoGeneral"
                );
                //console.log(data);
                console.log(idpresupuestogeneral, id);
                tfoot.find("#tfoot-guardar-presupuesto-general").hide();
                tfoot.show();
                tbody.empty();
                let html = "";
                let idprocedimientos = [];
                data.forEach((element) => {
                    html += `<tr data-idpresupuestoprocedimiento="${element.idpresupuestoprocedimiento}" data-pieza="${element.pieza}" data-precio="${element.precio}">
                    <td class="mostrar-fecha"></td>
                    <td>${element.pieza}</td>
                    <td>${element.procedimiento}</td>
                    <td class="precio-procedimiento-presupuesto">${element.precio}</td>
                    <td class="row-trash">
                      <button class="button btn-danger" id="echar-eleccion">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </td>
                  </tr>`;
                    idprocedimientos.push(
                        parseInt(element.idpresupuestoprocedimiento)
                    );
                });
                $("#monto-pagar-presupuesto").val("");
                $("#modificar-mostrar-total-presupuesto").html(
                    data[0].totalpagar
                );
                tbody.html(html);
                actulizarPresupuestoGeneral(
                    idpresupuestogeneral,
                    idprocedimientos
                );
            } else {
                editing = false;
                getPresupuestoGeneral();
                mostrarInformacionPagos();
            }
        });
    }
    actulizarPresupuestoGeneral(idpresupuestogeneral, idprocedimientos) {
        $("#modificar-presupuesto-general").on("click", async function () {
            try {
                const tbody = $("#tbody-presupuesto-general");
                const idgeneral = idpresupuestogeneral;
                let idpresupuestoprocedimientos = idprocedimientos;
                // Procedimientos nuevos: toda la data, procedimientos eliminados solo su id
                let data = {
                    idcliente: $("#idcliente").val(),
                    idpresupuestogeneral: idgeneral,
                    procedimientosnuevos: [],
                    procedimientoseliminados: [],
                };
                tbody.find("tr").each(function () {
                    const idpresupuestoprocedimiento = $(this).data(
                        "idpresupuestoprocedimiento"
                    );
                    const idprocedimiento = $(this).data("idprocedimiento");
                    const pieza = $(this).data("pieza");
                    const precio = $(this).data("precio");
                    if (
                        validar(idprocedimiento) &&
                        validar(pieza) &&
                        validar(precio)
                    ) {
                        data.procedimientosnuevos.push({
                            idprocedimiento: idprocedimiento,
                            pieza: pieza,
                            precio: precio,
                        });
                    }
                    console.log(
                        idpresupuestoprocedimiento,
                        idpresupuestoprocedimientos.includes(
                            idpresupuestoprocedimiento
                        )
                    );
                    if (
                        idpresupuestoprocedimientos.includes(
                            idpresupuestoprocedimiento
                        )
                    ) {
                        idpresupuestoprocedimientos =
                            idpresupuestoprocedimientos.filter(
                                (element) =>
                                    element != idpresupuestoprocedimiento
                            );
                    }
                });
                data.procedimientoseliminados = idpresupuestoprocedimientos;
                if (
                    data.procedimientosnuevos.length > 0 ||
                    data.procedimientoseliminados.length > 0
                ) {
                    console.log("Actulizare data con: ", data);
                    await insertFetch(
                        { data: data },
                        "pagos",
                        "actualizarPresupuestoGeneral",
                        "modificar-presupuesto-general"
                    );
                } else {
                    console.log("No hay datos para Actualizar");
                }
            } catch (error) {
                console.log(
                    "ERROR EN ACTUALIZAR EL PRESUPUESTO GENERAL",
                    error
                );
            } finally {
                getPresupuestoGeneral();
                mostrarInformacionPagos();
            }
        });
    }
    // Marcar presupuesto como pagado y mostrar otro formulario para el cliente, Marca el estado del presupuesto en 1 si los pagos igualan al total a pagar, si falta pagar no lo cambia a 1
    async marcarPresupuestoPagado() {
        try {
            $("#nuevo-presupuesto").on("click", async function () {
                console.log("Marcar presupuesto como pagado");
                const idpresupuestogeneral = $("#idpresupuestogeneral").data(
                    "idpresupuestogeneral"
                );
                const idcliente = $("#idcliente").val();
                console.log(idpresupuestogeneral, idcliente);
                const result = await insertFetch(
                    {
                        idpresupuestogeneral: idpresupuestogeneral,
                        idcliente: idcliente,
                    },
                    "pagos",
                    "marcarPresupuestoPagado"
                );
                //console.log(result);
                await getPresupuestoGeneral();
                await mostrarInformacionPagos();
                //location.reload();
            });
        } catch (error) {
            console.log("ERROR EN MARCAR PRESUPUESTO PAGADO", error);
        }
    }
}
