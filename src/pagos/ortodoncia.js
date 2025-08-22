import ApiService from "../../public/js/api/apiservice.js";

export default class PresupuestoOrtodoncia extends ApiService{
    constructor(){
        super();
        this.controller = "pagos";
    }
    async init(){
        
    }
    async Presupuestos(type) {
        try {
            let total_mostrar = 0,
                pagado_mostrar = 0,
                deuda_mostrar = 0;
            // Obteniendo el id del cliente
            let idcliente = $("#idcliente").val();
            const data = await getOne(
                { id: idcliente, tipo: type },
                "pagos",
                "presupuestos"
            ); //SOlicitud al servidor
            const tbody = $(`#tbody-${type}`); // ID de la tabla
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
                    html += `<tr class="fila-pago" data-idpago="${
                        element.idpago
                    }" data-total="${total}" data-monto="${
                        element.monto_pagado
                    }" data-deuda="${deuda}">
                          <td>${fechaActual}</td>
                          <td>${generarSelectPiezas()}</td>
                          <td>${element.procedimiento}</td>
                          <td><input type="text" class="text-right" value="${
                              total - monto
                          }" disabled></td>
                          <td>
                            <input type="text" class="importe-tabla" placeholder="Nuevo importe" id='importe-tabla'>
                          </td>
                          <td id='deuda-tabla'>-</td>
                          <td><select name="doctor" id="doctor" class="doctor-tablas">${generarDoctores()}</select></td>
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
            $(`#${type}-total`).html(`s/. ${total_mostrar}`);
            $(`#${type}-deuda`).html(`s/. ${deuda_mostrar}`);
            $(`#${type}-pagado`).html(`s/. ${pagado_mostrar}`);
            tbody.append(html);
        } catch (error) {
            console.log(error + "AL OBTENER DATOS EN LA TABLAS PAGOS");
        }
    }
    generarSelectPiezas() {
        let opciones = "";
        for (let i = 1; i <= 4; i++) {
            for (let j = 1; j <= 8; j++) {
            opciones += `<option value="${i}.${j}">${i}.${j}</option>`;
            }
        }
        return `<select name="pieza" id="pieza-tabla" class="pieza-tablas">${opciones}</select>`;
    }
    async generarDoctores() {
        try {
            const data = await get("pagos", "getDoctores");
            let html = "";
            data.forEach((element) => {
            html += `<option value="${element.idpersonal}" data-id="${element.etiqueta}">${element.nombre}</option>`;
            });
            $(".doctor-tablas, .doctor").html(html);
            $(".pieza, .pieza-tablas, .doctor, .doctor-tablas").val("");
            //return html;
            // $("#pieza, #pieza-tabla-general").val("");
        } catch (error) {
            console.log("Error en obtener Doctores.." + error);
        }
    }
}
