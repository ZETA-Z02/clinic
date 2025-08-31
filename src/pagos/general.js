import ApiService from "../../public/js/api/apiservice.js";
import { numberFloat, validar } from "../../public/js/utils/validations.js";

export default class PresupuestoGeneral extends ApiService {
    constructor() {
        super();
        this.idcliente = $("#idcliente").val();
        this.controller = "pagos";
        this.$contenedor = $("#tabla-general");
        this.datapresupuesto = false;
        this.idpresupuestogeneral = null;
        // Procedimientos a eliminar
        this.idpresupuestoprocedimientos = [];
    }
    async init() {
        await this.getPresupuestoGeneral();
        await this.getPresupuestoPagos();
        this.NuevoPagoPresupuestoGeneral();
        this.eliminarPagoPresupuestoTotal();
        this.editarPago();
        this.actulizarPresupuestoGeneral();
        this.agregarPresupuestoGeneral();
        this.quitarProcedimiento();
        this.guardarPresupuestoGeneral();
        this.actulizarPresupuestoGeneral();
        this.marcarPresupuestoPagado();
        await this.getPresupuestoHistorial();
        // Data extra
        await this.getProcedimientos();
        this.selectProcedimientos();
        // Events
        this.calcularDeuda(
            "#monto_pagar",
            "#importe-presupuesto",
            "#mostrar-deuda-presupuesto"
        );
        this.descuento();
        // Habilitar
        this.habilitarModificarPagos();
        this.habilitarModificarPresupuestoGeneral();
        // MAS
        this.formatearFecha();
        $("#guardar-presupuesto-general").show();
        $("#modificar-presupuesto-general").show();
    }
    // OBTIENE EL PRESUPUESTO GENERAL DE UN CLIENTE -> EN ESTADO 0-> no pagado
    async getPresupuestoGeneral() {
        // PRESUPUESTO GENERAL -> detalles del presupuesto, procedimientos y precios
        const tbodyGeneral = this.$contenedor.find(
            "#tbody-presupuesto-general"
        );
        const tfoot = this.$contenedor.find("#nuevo-procedimiento");
        const tfootguardar = this.$contenedor.find(
            "#tfoot-guardar-presupuesto-general"
        );
        const tfootModificar = this.$contenedor.find(
            "#tr-modificar-presupuesto"
        );
        try {
            const id = this.idcliente;
            const data = await this.readOne(
                id,
                this.controller,
                "getPresupuestoGeneral"
            );
            // console.log(data);
            let html = "";
            this.datapresupuesto = false;
            if (data.response !== false) {
                this.datapresupuesto = true;
                tfoot.hide();
                tfootguardar.hide();
                tfootModificar.hide();
            }
            if (this.datapresupuesto === false) {
                tbodyGeneral.empty();
                tfoot.show();
                tfootguardar.show();
                tfootModificar.hide();
                return;
            }
            data.forEach((element) => {
                let fechaProcedimiento = "";
                if(validar(element.fechaProcedimiento)){
                    fechaProcedimiento = element.fechaProcedimiento;
                }
                html += `<tr>
                            <td>${fechaProcedimiento}</td>
                            <td>${element.pieza}</td>
                            <td>${element.procedimiento}</td> 
                            <td>${element.precio}</td>
                        </tr>`;
            });
            html += `<tr style="border-top: 1px solid black; font-weight: 600">
                        <td></td>
                        <td></td>
                        <td>Descuento:  </td> 
                        <td>${data[0].descuento}</td>
                    </tr>`;
            html += `<tr style="border-top: 1px solid black; color: #000; font-weight: 900">
                        <td>${data[0].fecha.split(" ")[0]}</td>
                        <td id="idpresupuestogeneral" data-idpresupuestogeneral="${
                            data[0].idpresupuestogeneral
                        }"></td>
                        <td>Total: </td> 
                        <td>${data[0].total}</td>
                    </tr>`;
            if (data[0].deuda == 0 || data[0].deuda == null) {
                $("#monto_pagar").val(data[0].total);
            }
            this.idpresupuestogeneral = data[0].idpresupuestogeneral;
            tbodyGeneral.html(html);
        } catch (e) {
            console.log("Error en getPresupuestoGeneral", e);
        }
    }
    // OBTIENE LOS PAGOS DE UN PRESUPUESTO GENERAL
    async getPresupuestoPagos() {
        // Presupuesto total -> Pagos del presupuesto
        const tbodyTotal = this.$contenedor.find("#tbody-presupuesto-total");
        const montopagar = this.$contenedor.find("#monto_pagar");
        const tfootPago = this.$contenedor.find(
            "#tfoot-agregar-pago-presupuesto"
        );
        // Verificar si hay presupuesto activo -> sin terminar de pagar
        if (this.datapresupuesto === false) {
            tbodyTotal.empty();
            return false;
        }
        // PAGOS -> PRESUPUESTO GENERAL
        try {
            const id = this.idcliente;
            const idpresupuestogeneral = this.idpresupuestogeneral;
            const fechaActual = new Date().toISOString().slice(0, 10);
            const data = await this.readOne(
                { id, idpresupuestogeneral },
                this.controller,
                "getPresupuestoPagos"
            );
            //console.log(data);
            if (!validar(data)) {
                return false;
            }
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
                        <td class="text-center"><input type="text" class="text-center importe-editar" value="${pago.importe}" disabled></td>
                        <td>${deuda}</td>
                        <td class="text-right">${pago.fecha}</td>
                        <td class="row-trash" style="display:none;">
                        <button class="btn-delete" data-idpresupuestopago="${pago.idpresupuestopago}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        </td>
                    </tr>
                    `;
                total_index -= parseFloat(pago.importe);
                montopagar.val(deuda);
            });
            tbodyTotal.html(html);
            tfootPago.show();
            // AGREGAR ROW DE PAGADO SI MONTO ES IGUAL AL TOTAL
            if (data[0].total == importe) {
                tfootPago.hide();
                tbodyTotal.append(`
                    <tr>
                        <td class="cancelado">Cancelado</td>
                        <td class="cancelado text-center">Cancelado</td>
                        <td class="cancelado">Cancelado</td>
                        <td class="cancelado text-center">-</td>
                    </tr>
                    `);
            }
        } catch (error) {
            // $("#monto_pagar").val(deudaData);
            console.log("Error en getPresupuestoPagos", error);
        }
    }
    // PAGOS DEL PRESUPUESTO *-*-*-*-*-*-*-*-*--*--
    // NUEVO PAGO DEL PRESUPUESTO GENERAL -> PAGOS
    NuevoPagoPresupuestoGeneral() {
        const importe = this.$contenedor.find("#importe-presupuesto");
        const importeNuevo = this.$contenedor.find("#importe-nuevo");
        const that = this;
        this.$contenedor.on(
            "input change",
            "#importe-presupuesto",
            async function () {
                try {
                    let timeout;
                    numberFloat("#importe-presupuesto");
                    let trfila = $(this).closest("tr");
                    // REINICIAR EL TIME
                    clearTimeout(trfila.data("timeout"));
                    const data = {};
                    // Esperar 2 segundo después de que todos los inputs estén llenos
                    timeout = setTimeout(async () => {
                        data.idcliente = that.idcliente;
                        data.importe = importe.val();
                        // Validar si los campos están llenos
                        if (
                            Object.values(data).every(
                                (value) => value.trim() !== ""
                            )
                        ) {
                            await that.create(
                                data,
                                that.controller,
                                "nuevoPagoPresupuestoGeneral"
                            );
                            importe.val("");
                            await that.getPresupuestoPagos();
                        }
                    }, 2000);
                    trfila.data("timeout", timeout); //Guardar timeout en la fila
                } catch (error) {
                    console.log("Error en NuevoPagoPresupuestoGeneral", error);
                }
            }
        );
    }
    // ELIMINAR UN PAGO DEL PRESUPUESTO
    eliminarPagoPresupuestoTotal() {
        const that = this;
        const tbodyTotal = this.$contenedor.find("#tbody-presupuesto-total");
        this.$contenedor.on("click", ".btn-delete", async function () {
            let idpresupuestopago = $(this).data("idpresupuestopago");
            const data = {
                idpresupuestopago: `${idpresupuestopago}`,
            };
            await that.delete(data, that.controller, "deletePresupuestoPagos");
            tbodyTotal.empty();
            await that.getPresupuestoGeneral();
            await that.getPresupuestoPagos();
        });
    }
    // EDITAR UN PAGO DEL PRESUPUESTO
    editarPago() {
        const that = this;
        this.$contenedor.on("input change", ".importe-editar", function () {
            try {
                let timeout;
                numberFloat(".importe-editar");
                clearTimeout(timeout);
                let trfila = $(this).closest("tr");
                let idpresupuestogeneral = trfila.data("idpresupuestogeneral");
                let idpresupuestopago = trfila.data("idpresupuestopago");
                let importeActualizado = $(this);
                timeout = setTimeout(async () => {
                    const data = {
                        idcliente: that.idcliente,
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
                        await that.create(
                            data,
                            that.controller,
                            "updatePresupuestoPagos"
                        );
                        await that.getPresupuestoPagos();
                    }
                }, 2000);
            } catch (error) {
                console.log("Error en editarPago", error);
            }
        });
    }
    // PAGOS DEL PRESUPUESTO -END *-*-*-*-*-*-*-*-*--*--
    // AGREGAR UN PROCEDIMIENTO Y PRECIO AL PRESUPUESTO GENERAL
    agregarPresupuestoGeneral() {
        let precio_total = 0;
        let html = "";
        this.$contenedor.on("click", "#confirmar-procedimiento", () => {
            const tbody = $("#tbody-presupuesto-general");
            const pieza = $("#pieza-presupuesto").val();
            const procedimiento = $(
                "#procedimiento-presupuesto option:selected"
            ).text();
            const idprocedimiento = $("#procedimiento-presupuesto").val();
            const precio = $("#monto-pagar-presupuesto").val();
            precio_total += parseFloat(precio);
            if (validar(pieza) && validar(idprocedimiento) && validar(precio)) {
                // TABLA
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
                $(
                    "#pieza-presupuesto,#procedimiento-presupuesto,#monto-pagar-presupuesto"
                ).val("");
                this.actualizarTotalPagar();
            }
        });
    }
    //
    // QUITAR UN PROCEDIMIENTO DEL PRESUPUESTO GENERAL-> AL CREAR EL PRESUPUESTO
    quitarProcedimiento() {
        const that = this;
        $(document).on("click", "#echar-eleccion", function () {
            const tr = $(this).closest("tr");
            tr.remove();
            that.actualizarTotalPagar();
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
        this.$contenedor.off("click", "#guardar-presupuesto-general");
        this.$contenedor.on(
            "click",
            "#guardar-presupuesto-general",
            async () => {
                $("#guardar-presupuesto-general").hide();
                try {
                    let descuento;
                    if (!validar($("#descuento").val())) {
                        descuento = 0;
                    }
                    const tbody = $("#tbody-presupuesto-general");
                    const data = {
                        idcliente: this.idcliente,
                        descuento: descuento,
                        precio_total: 0,
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
                            data.precio_total += parseFloat(precio);
                        }
                    });
                    if (data.procedimientos.length > 0) {
                        console.log("data", data);
                        await this.create(
                            { data: data },
                            this.controller,
                            "nuevoPresupuestoGeneral",
                            "guardar-presupuesto-general"
                        );
                        await this.init();
                    } else {
                        console.log("No hay datos para guardar");
                    }
                    // tbody.empty();
                } catch (error) {
                    console.log(
                        "Error al guardar el presupuesto general: ",
                        error
                    );
                }
            }
        );
    }
    actulizarPresupuestoGeneral() {
        this.$contenedor.off("click", "#modificar-presupuesto-general");
        this.$contenedor.on(
            "click",
            "#modificar-presupuesto-general",
            async () => {
                $("#modificar-presupuesto-general").hide();
                try {
                    const tbody = $("#tbody-presupuesto-general");
                    // Procedimientos nuevos: toda la data, procedimientos eliminados solo su id
                    let data = {
                        idcliente: $("#idcliente").val(),
                        idpresupuestogeneral: this.idpresupuestogeneral,
                        procedimientosnuevos: [],
                        procedimientoseliminados: [],
                    };
                    const that = this;
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
                        if (
                            that.idpresupuestoprocedimientos.includes(
                                idpresupuestoprocedimiento
                            )
                        ) {
                            that.idpresupuestoprocedimientos =
                                that.idpresupuestoprocedimientos.filter(
                                    (element) =>
                                        element != idpresupuestoprocedimiento
                                );
                        }
                    });
                    data.procedimientoseliminados =
                        this.idpresupuestoprocedimientos;
                    if (
                        data.procedimientosnuevos.length > 0 ||
                        data.procedimientoseliminados.length > 0
                    ) {
                        console.log("Actulizare data con: ", data);
                        await this.update(
                            { data: data },
                            this.controller,
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
                    const tfootModificar = this.$contenedor.find(
                        "#tr-modificar-presupuesto-general"
                    );
                    tfootModificar.hide();
                    this.idpresupuestoprocedimientos = [];
                    await this.init();
                }
            }
        );
    }
    // Marcar presupuesto como pagado y mostrar otro formulario para el cliente, Marca el estado del presupuesto en 1 si los pagos igualan al total a pagar, si falta pagar no lo cambia a 1
    marcarPresupuestoPagado() {
        this.$contenedor.off("click", "#nuevo-presupuesto");
        this.$contenedor.on("click", "#nuevo-presupuesto", async () => {
            try {
                await this.create(
                    {
                        idpresupuestogeneral: this.idpresupuestogeneral,
                        idcliente: this.idcliente,
                    },
                    this.controller,
                    "marcarPresupuestoPagado"
                );
                this.idpresupuestogeneral = null;
            } catch (error) {
                console.log("ERROR EN MARCAR PRESUPUESTO PAGADO", error);
            } finally {
                await this.init();
                const tfootPago = this.$contenedor.find(
                    "#tfoot-agregar-pago-presupuesto"
                );
                tfootPago.show();
            }
        });
    }
    // HABILITAR MODIFICAR PRESUPUESTO
    habilitarModificarPresupuestoGeneral() {
        if (this.idpresupuestogeneral === null) {
            return false;
        }
        let editing = false;
        this.$contenedor.on(
            "click",
            "#mostrar-modifica-presupuesto",
            async () => {
                const tbody = $("#tbody-presupuesto-general");
                const tfootModificar = this.$contenedor.find(
                    "#tr-modificar-presupuesto"
                );
                const tfootAgregar = this.$contenedor.find(
                    "#nuevo-procedimiento"
                );
                if (!editing) {
                    editing = true;
                    const id = this.idcliente;
                    const data = await this.readOne(
                        id,
                        this.controller,
                        "mostrarModificarPresupuestoGeneral"
                    );
                    tbody.empty();
                    tfootModificar.show();
                    tfootAgregar.show();
                    let html = "";
                    // SE USA THIS.IDPRESUPUESTOPROCEDIMIENTOS -> ATRIBUTO DE LA CLASE PARA QUE SEA UTILIZADA EN CUALQUIER PARTE DEL CODIGO
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
                        this.idpresupuestoprocedimientos.push(
                            parseInt(element.idpresupuestoprocedimiento)
                        );
                    });
                    $("#monto-pagar-presupuesto").val("");
                    $("#modificar-mostrar-total-presupuesto").html(
                        data[0].totalpagar
                    );
                    tbody.html(html);
                    // this.actulizarPresupuestoGeneral(idpresupuestogeneral,idprocedimientos);
                } else {
                    editing = false;
                    tfootModificar.hide();
                    await this.getPresupuestoGeneral();
                }
            }
        );
    }
    // HABILITAR MODIFICACION DE LOS PAGOS: EDITAR - ELIMINAR
    habilitarModificarPagos() {
        this.$contenedor.on("click", "#modificar-pagos", function () {
            // Eliminar
            const input = $(".importe-editar");
            if (input.prop("disabled")) {
                input.prop("disabled", false);
            } else {
                input.prop("disabled", true);
            }
            // Editar
            let fila = $(".row-trash");
            if (fila.css("display") == "block") {
                fila.css("display", "none");
            } else {
                fila.css("display", "block");
            }
        });
    }
    // OBTENER PROCEDIMIENTOS- se encargar de todo al seleccionar, mostrar precio de los procedimientos
    async getProcedimientos() {
        const type = "presupuesto";
        try {
            const data = await this.read(
                this.controller,
                `getProcedimientos${type}`
            );
            let html = "";
            data.forEach((element, index) => {
                html += `<option value="${element.idprocedimiento}">${element.procedimiento}</option>`;
            });
            $(`#procedimiento-${type}`).html(html);
            $(`#procedimiento-${type}`).val("");
        } catch (error) {
            console.log("Error en obtener Procedimientos..", error);
        }
    }
    selectProcedimientos() {
        const type = "presupuesto";
        const that = this;
        this.$contenedor.on(
            "input change",
            `#procedimiento-${type}`,
            async function () {
                let idprocedimiento = $(this).val();
                try {
                    const data = await that.readOne(
                        idprocedimiento,
                        "procedimientos",
                        "getOne"
                    );
                    // console.log(data);
                    $(`#monto-pagar-${type}`).val(data.precio);
                } catch (error) {
                    console.log(
                        "ERror al obtener el precio del procedimiento" + error
                    );
                }
            }
        );
    }
    formatearFecha() {
        let fechaDate = new Date();
        const fecha = fechaDate.toLocaleDateString("es-MX", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        });
        $(".mostrar-fecha").html(fecha);
    }
    // CALCULA LA DEUDA, RECIBE 3 PARAMETROS
    calcularDeuda(montoTotal, inputImporte, deudaMostrar) {
        const monto = $(montoTotal);
        const importe = $(inputImporte);
        const deuda = $(deudaMostrar);
        this.$contenedor.on("input change", importe, function () {
            deuda.html(parseFloat(monto.val()) - parseFloat(importe.val()));
        });
    }
    descuento() {
        this.total = 0;
        this.$contenedor.on("input change", "#descuento", () => {
            if (this.total == 0) {
                this.total = parseFloat($("#mostrar-total-presupuesto").html());
            }
            const descuento = parseFloat($("#descuento").val());
            const total = this.total - descuento;
            $("#mostrar-total-presupuesto").html(total);
        });
    }
    // HISTORIAL -> SOLO GET
    async getPresupuestoHistorial() {
        const container = $("#presupuesto_historial");
        try {
            const data = await this.readOne(
                { idcliente: this.idcliente },
                this.controller,
                "getPresupuestoHistorial"
            );
            container.html(""); // Limpiamos el contenedor antes de renderizar
            let html = "";
            data.forEach((presupuesto) => {
                let tratamientosHTML = "";
                let fecha = "";
                presupuesto.general.forEach((element) => {
                    let fechaProcedimiento = "";
                    if(validar(element.fechaProcedimiento)){
                        fechaProcedimiento = element.fechaProcedimiento;
                    }
                    fecha = element.fecha;
                    tratamientosHTML += `
                    <tr>
                        <td>${fechaProcedimiento}</td>
                        <td>${element.pieza}</td>
                        <td>${element.procedimiento}</td>
                        <td class="text-right">${element.precio}</td>
                    </tr>`;
                });

                // Fila de descuento y total
                tratamientosHTML += `
                <tr style="border-top: 1px solid black">
                    <td></td>
                    <td></td>
                    <td>Descuento:</td>
                    <td class="text-right">${
                        presupuesto.general[0]?.descuento ?? 0
                    }</td>
                </tr>
                <tr style="border-top: 1px solid black">
                    <td>${fecha}</td>
                    <td></td>
                    <td><b>Total:</b></td>
                    <td class="text-right"><b>${
                        presupuesto.general[0]?.total ?? 0
                    }</b></td>
                </tr>`;

                // Pagos
                let pagosHTML = "";
                if (presupuesto.pagos.length > 0) {
                    presupuesto.pagos.forEach((pago) => {
                        pagosHTML += `
                        <tr>
                            <td class="text-right">${pago.total}</td>
                            <td class="text-center">${pago.importe}</td>
                            <td class="text-right">${pago.monto_pagado}</td>
                            <td class="text-center">${pago.fecha}</td>
                        </tr>`;
                    });
                } else {
                    pagosHTML = `
                    <tr>
                        <td colspan="4" class="text-center">Sin pagos registrados</td>
                    </tr>`;
                }

                // Si está cancelado, mostramos fila especial
                pagosHTML += `
                <tr>
                    <td class="cancelado">Cancelado</td>
                    <td class="cancelado text-center">Cancelado</td>
                    <td class="cancelado">Cancelado</td>
                    <td class="cancelado text-center">-</td>
                </tr>`;

                // Render final de cada presupuesto
                html += `
                <div class="cell grid-x grid-margin-x">
                    <div class="cell large-6">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Pieza</th>
                                    <th>Tratamientos</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tratamientosHTML}
                            </tbody>
                        </table>
                    </div>
                    <div class="cell large-6">
                        <table>
                            <thead>
                                <tr>
                                    <th>Total</th>
                                    <th>Adelanto</th>
                                    <th>Pagado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${pagosHTML}
                            </tbody>
                        </table>
                    </div>
                </div>
                `;
                //container.append(html);
            });
            container.html(html);
            console.log("Presupuesto historial:", data);
        } catch (error) {
            console.log("Error al obtener presupuesto historial", error);
        }
    }
}
