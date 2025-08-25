import ApiService from "../../public/js/api/apiservice.js";
import { numberFloat, validar } from "../../public/js/utils/validations.js";

export default class PresupuestoOrtodoncia extends ApiService {
    constructor() {
        super();
        this.idcliente = $("#idcliente").val();
        this.controller = "pagos";
        this.$contenedor = $("#tabla-ortodoncia");
    }
    async init() {
        await this.getPresupuestoOrtodoncia();
        this.NuevoProcedimiento();
        this.nuevoPago();
        this.eliminarPago();
        this.actualizarFilaData();

        // MAS
        this.getProcedimientos();
        // Eventos
        this.selectProcedimientos();
        this.calcularDeuda("#monto-pagar-ortodoncia", "#importe-ortodoncia", "#mostrar-deuda-ortodoncia");
        this.calcularDeudaTabla();
        // Habilitar modificaciones
        this.habilitarModificacion();
        await this.generarDoctores();
    }
    async getPresupuestoOrtodoncia() {
        try {
            let total_mostrar = 0,
                pagado_mostrar = 0,
                deuda_mostrar = 0;
            const data = await this.readOne({ id: this.idcliente, tipo: "ortodoncia" },this.controller,"presupuestos");
            const tbody = this.$contenedor.find("#tbody-ortodoncia");
            tbody.empty(); // Vaciamos la tabla
            let fechaActual = new Date().toISOString().slice(0, 10);
            let monto = 0; //Variables para los calculos
            let deuda = 0; //Variables para los calculos
            let total = 0; //Variables para los calculos
            let html = ""; //Codigo HTML
            // Recorremos los datos que llegaron
            data.forEach((element) => {
                //console.log(element);
                // variables que se asignan de la tabla PAGOS
                deuda = parseFloat(element.saldo_pendiente); // la deuda es el saldo pendiente
                total = parseFloat(element.total_pagar); // el total es el total a pagar
                let restante = total - monto - parseFloat(element.monto);
                html += `
                <tr data-idpago="${element.idpago}" data-idpagodetalle="${
                    element.idpagodetalle
                }" data-total="${total}" data-deuda="${deuda}" data-monto="${
                    element.monto_pagado
                }" data-importeactual="${element.monto}">
                    <td>${element.fecha}</td>
                    <td class="row-pieza">${element.pieza}</td>
                    <td>${element.procedimiento}</td>
                    <td class="text-right">${total - monto}</td>
                    <td>
                        <input type="text" class="general-input-monto text-center" id="input-importe-data" value="${
                            element.monto
                        }" disabled>
                    </td>
                    <td>${restante}</td>
                    <td class="row-etiqueta">${element.etiqueta}</td>
                    <td class="row-trash" style="display:none;">
                        <button class="btn-delete-row" data-idpagodetalle="${
                            element.idpagodetalle
                        }">
                        <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
              `;
                monto += parseFloat(element.monto); // Suma el monto a la variable monto
                //console.log('antes de ingresar al primer if: ',deuda,monto,total);
                // SI LA DEUDA ES MAYOR A CERO Y EL MONTO MAS LA DEUDA ES IGUAL AL TOTAL
                // SE AGREGA UNA FILA PARA UN NUEVO PAGO DEL MISMO PROCEDIMIENTO Y DE UN MISMO PAGO
                if (deuda > 0 && monto + deuda === total) {
                    html += `<tr class="fila-pago" data-idpago="${element.idpago}" data-total="${total}" data-monto="${element.monto_pagado}" data-deuda="${deuda}">
                          <td>${fechaActual}</td>
                          <td>${this.generarSelectPiezas()}</td>
                          <td>${element.procedimiento}</td>
                          <td><input type="text" class="text-right" id="detallado-monto-pagar" value="${total - monto}" disabled></td>
                          <td>
                            <input type="text" class="importe-tabla" placeholder="Nuevo importe" id='importe-tabla'>
                          </td>
                          <td class="deuda-tabla" id="deuda-tabla">-</td>
                          <td><select name="doctor" id="doctor" class="doctor-tablas"></select></td>
                      </tr>
                      <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                      </tr>
                  `;
                    // SI INGRESA SE REINICIA LAS VARIABLES PARA EL SIGUIENTE PAGO Y EL SIGUIENTE CALCULO
                    monto = 0;
                    deuda = 0;
                    total = 0;
                    // TOTALES PARA MOSTRAR-> TOTAL DE TODA LA TABLA
                    deuda_mostrar += parseFloat(element.saldo_pendiente);
                    total_mostrar += parseFloat(element.total_pagar);
                }
                pagado_mostrar += parseFloat(element.monto);
                // SI NO TIENE DEUDA Y EL MONTO PAGADO ES IGUAL AL TOTAL SE AGREGA FILA DE CANCELADO
                if (deuda == 0 && monto === total && total > 0) {
                    //console.log(monto,total)
                    html += `<tr>
                                <td class="cancelado">-</td>
                                <td class="cancelado">-</td>
                                <td class="cancelado">${element.procedimiento}</td>
                                <td class="cancelado">Cancelado</td>
                                <td class="cancelado">Cancelado</td>
                                <td class="cancelado">Cancelado</td>
                                <td class="cancelado">-</td>
                            </tr>`;
                    monto = 0;
                    deuda = 0;
                    total = 0;
                    total_mostrar += parseFloat(element.total_pagar);
                }
            });
            //console.log(total_mostrar,deuda_mostrar,pagado_mostrar);
            $(`#ortodoncia-total`).html(`s/. ${total_mostrar}`);
            $(`#ortodoncia-deuda`).html(`s/. ${deuda_mostrar}`);
            $(`#ortodoncia-pagado`).html(`s/. ${pagado_mostrar}`);
            tbody.append(html);
        } catch (error) {
            console.log(error + "AL OBTENER DATOS EN LA TABLAS PAGOS");
        }
    }
    // NUEVO PROCEDIMIENTO -> Para Iniciar los pagos
    NuevoProcedimiento() {
        let timeout;
        const that = this;
        this.$contenedor.on("input change",".importe, .procedimiento, .pieza, .doctor", async function () {
            try{
              let fila = $(this).closest("tr");
              let procedimiento = fila.find(".procedimiento");
              let importe = fila.find(".importe");
              let total_pagar = fila.find(".monto-a-pagar");
              let pieza = fila.find(".pieza");
              let doctor = fila.find(".doctor");
              clearTimeout(fila.data("timeout"));
              //console.log("Nuevo procedimiento procesando...");
              // Esperar 2 segundo después de que todos los inputs estén llenos
              timeout = setTimeout(async () => {
                  const data = {
                      idcliente: that.idcliente,
                      idprocedimiento: procedimiento.val(),
                      total_pagar: total_pagar.val(),
                      importe: importe.val(),
                      pieza: pieza.val(),
                      doctor: doctor.val(),
                  };
                  console.log(data);
                  // Validar si los campos están llenos
                  if (Object.values(data).every((value) => value.trim() !== "")) {
                      await that.create(data, that.controller, "nuevoProcedimientoPago");
                      //console.log(data, "Enviando datos al servidor");
                      importe.val("");
                      procedimiento.val("");
                      pieza.val("");
                      doctor.val("");
                      await that.getPresupuestoOrtodoncia();
                      await that.generarDoctores();
                  }
              }, 2000); // Espera de 1 segundo
              fila.data("timeout", timeout); //Guardar timeout en la fila
          } catch (error) {
              console.log("ERror al insertar nuevo pago con su procedimiento", error);
          }
      });
    }
    // Nuevo Pago de un procedimiento
    nuevoPago() {
      let timeout;
      const that = this;
      this.$contenedor.on("input change",".importe-tabla, .pieza-tablas, .doctor-tablas",async function () {
        try{
          numberFloat(".importe-tabla");
              let trfila = $(this).closest("tr");
              let importe = trfila.find("#importe-tabla");
              let pieza = trfila.find("#pieza-tabla");
              let doctor = trfila.find("#doctor");
              let idpago = trfila.data("idpago");
              let total = trfila.data("total");
              let deuda = trfila.data("deuda");
              let monto = trfila.data("monto");
              // REINICIAR EL TIME
              clearTimeout(trfila.data("timeout"));
              // Esperar 1 segundo después de que todos los inputs estén llenos
              timeout = setTimeout(async () => {
                  const data = {
                      idcliente: that.idcliente,
                      idpago: `${idpago}`,
                      importe: importe.val(),
                      pieza: pieza.val(),
                      doctor: doctor.val(),
                      total: `${total}`,
                      deuda: `${deuda}`,
                      monto: monto,
                  };
                  //console.log(data);
                  if (Object.values(data).every((value) => value.trim() !== "")) {
                      await that.create(data, that.controller, "nuevoPago");
                      //console.log(data, "Enviando datos al servidor");
                      importe.val("");
                      doctor.val("");
                      pieza.val("");
                      await that.getPresupuestoOrtodoncia();
                      await that.generarDoctores();
                  }
              }, 2000); // Espera de 2 segundo
              trfila.data("timeout", timeout); //Guardar timeout en la fila  
        } catch (error) {
          console.log("Error al hacer un nuevo pago de un procedimiento ya creado", error);
        }        
      });
    }
    eliminarPago() {
      const that = this;
      this.$contenedor.on("click", ".btn-delete-row", async function () {
          try{
            let idpagodetalle = $(this).data("idpagodetalle");
            let fila = $(this).closest("tr");
            let idpago = fila.data("idpago");
            let monto = fila.data("monto");
            let deuda = fila.data("deuda");
            let total = fila.data("total");
            let importeActual = fila.data("importeactual");
            const data = {
                idpagodetalle: `${idpagodetalle}`,
                idpago: `${idpago}`,
                monto: monto,
                deuda: `${deuda}`,
                total: `${total}`,
                importeActual: importeActual,
            };
            console.log(data);
            await that.delete(data, that.controller, "deletePago");
            await that.getPresupuestoOrtodoncia();
            await that.generarDoctores();
          }catch(error){
            console.log("Error al eliminar un pago", error);
          }
      });
    }
    // update una fila, un pago_detalle
    actualizarFilaData() {
      let timeout;
      const that = this;
      this.$contenedor.on("input change", ".general-input-monto,.pieza-tablas,.row-etiqueta-doctor", async function () {
        numberFloat(".general-input-monto");
        clearTimeout(timeout);
        let trfila = $(this).closest("tr");
        let idpago = trfila.data("idpago");
        let idpagodetalle = trfila.data("idpagodetalle");
        let importeActualizado = trfila.find(".general-input-monto");
        let importeActual = trfila.data("importeactual");
        let pieza = trfila.find(".pieza-tablas");
        let doctor = trfila.find(".row-etiqueta-doctor");
        let total = trfila.data("total");
        let deuda = trfila.data("deuda");
        let monto = trfila.data("monto");
        timeout = setTimeout(async () => {
            try{
                const data = {
                  idcliente: that.idcliente,
                  idpago: `${idpago}`,
                  idpagodetalle: `${idpagodetalle}`,
                  importeActual: `${importeActual}`,
                  pieza: pieza.val(),
                  doctor: doctor.val(),
                  total: `${total}`,
                  deuda: `${deuda}`,
                  montoPagado: `${monto}`,
                  importeActualizado: importeActualizado.val(),
                };
                //console.log(data);
                if (Object.values(data).every((value) => value.trim() !== "")) {
                    await that.update(data, that.controller, "updatePago");
                    await that.getPresupuestoOrtodoncia();
                    await that.generarDoctores();
                }
            } catch (error) {
              console.log(error + "ERROR EN ACTUALIZAR FILA");
            }
        }, 2000);
      });
    }
    // HABILITAR DELETE Y EDIT
    habilitarModificacion(){
      this.$contenedor.on("click","#btn-modificar-ortodoncia", async () => {
        // HABILITAR DELETE
        let fila = $(".row-trash");
        if (fila.css("display") == "block") {
            fila.css("display", "none");
        } else {
            fila.css("display", "block");
        }
        // HABILITA EDIT
        try{
          const doctores = await this.generarDoctores();
          const input = $(".general-input-monto");
          if (input.prop("disabled")) {
              input.prop("disabled", false);
              let html =`<select id="row-etiqueta-doctor" class="row-etiqueta-doctor">
                      ${doctores}
                      </select>`;
              $(".row-etiqueta").html(html);
              $(".row-pieza").html(this.generarSelectPiezas());
              $(".pieza-tablas, .row-etiqueta-doctor").val("");
          } else {
              input.prop("disabled", true);
              await this.getPresupuestoOrtodoncia();
              await this.generarDoctores();
          }
        } catch(error){
          console.log("Error en activar EDIT", error);
        }
      });
    }
    // GENERA LAS PIEZAS DE LOS DIENTES PARA LOS NUEVOS PAGOS DE UN MISMO PROCEDIMIENTO
    generarSelectPiezas() {
        let opciones = "";
        for (let i = 1; i <= 4; i++) {
            for (let j = 1; j <= 8; j++) {
                opciones += `<option value="${i}.${j}">${i}.${j}</option>`;
            }
        }
        return `<select name="pieza" id="pieza-tabla" class="pieza-tablas">${opciones}</select>`;
    }
    // GENERA LOS DOCTORES PARA LOS NUEVOS PAGOS DE UN MISMO PROCEDIMIENTO
    async generarDoctores() {
        try {
            const data = await this.read(this.controller, "getDoctores");
            let html = "";
            data.forEach((element) => {
                html += `<option value="${element.idpersonal}" data-id="${element.etiqueta}">${element.nombre}</option>`;
            });
            $(".doctor-tablas, #doctor").html(html);
            $(".pieza, .pieza-tablas, #doctor, .doctor-tablas").val("");
            return html;
            // $("#pieza, #pieza-tabla-general").val("");
        } catch (error) {
            console.log("Error en obtener Doctores.." + error);
        }
    }
    // OBTENER PROCEDIMIENTOS- se encargar de todo al seleccionar, mostrar precio de los procedimientos
    async getProcedimientos() {
        const type = "ortodoncia"
        try {
            const data = await this.read(this.controller, `getProcedimientos${type}`);
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
        const type = "ortodoncia";
        const that = this;
        this.$contenedor.on("input change", `#procedimiento-${type}`, async function () {
            let idprocedimiento = $(this).val();
            try {
                const data = await that.readOne(idprocedimiento, "procedimientos", "getOne");
                // console.log(data);
                $(`#monto-pagar-${type}`).val(data.precio);
            } catch (error) {
                console.log("ERror al obtener el precio del procedimiento" + error);
            }
        });
    }
    // Calcula la deuda recibe 3 parametros
    calcularDeuda(montoTotal, inputImporte, deudaMostrar){
        const monto = $(montoTotal);
        const importe = $(inputImporte);
        const deuda = $(deudaMostrar);
        this.$contenedor.on("input change", importe, function(){
            deuda.html(parseFloat(monto.val()) - parseFloat(importe.val()));
        });
    }
    calcularDeudaTabla() {
      this.$contenedor.on("keyup", ".importe, .importe-tabla", function () {
        let fila = $(this).closest("tr");
        let montototal = fila.find("#detallado-monto-pagar").val();
        let importe = $(this).val();
        let mostrarDeuda = fila.find("#deuda-tabla");
        mostrarDeuda.html(montototal - importe);
      });
    }
}
