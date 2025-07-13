$(document).ready(function () {
  generarTablas();
  NuevoProcedimiento();
  continuarPago();
  //ASSETS
  btnTablas();
  calcularDeuda();
  numberFloat(".importe");
  generarDoctores();

  // DELET
  habilitarDelet();
  eliminarPago();

  // OBTENER PROCEDIMIENTOS
  getProcedimientos("general");
  getProcedimientos("ortodoncia");
  getProcedimientos("otros");
  getProcedimientos("presupuesto");

  //EDIT
  activarEdit();
  actualizarFilaData();
});
function generarTablas() {
  Presupuestos("general");
  Presupuestos("ortodoncia");
  Presupuestos("otros");
}
function btnTablas() {
  $(".modal").hide();
  $(".activate").click(function () {
    let idtabla = $(this).data("id");
    // console.log(idtabla);
    $(".modal").hide();
    $("#tabla-" + idtabla).show();
  });
  // borrar esta linea despues
  $("#tabla-presupuesto-total").show();
}
async function Presupuestos(type) {
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
function generarSelectPiezas() {
  let opciones = "";
  for (let i = 1; i <= 4; i++) {
    for (let j = 1; j <= 8; j++) {
      opciones += `<option value="${i}.${j}">${i}.${j}</option>`;
    }
  }
  return `<select name="pieza" id="pieza-tabla" class="pieza-tablas">${opciones}</select>`;
}
async function generarDoctores() {
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
// NUEVO PROCEDIMIENTO
async function NuevoProcedimiento() {
  try {
    let timeout;
    $(".importe, .procedimiento, .pieza, .doctor").on(
      "input change",
      function () {
        let fila = $(this).closest("tr");
        let procedimiento = fila.find(".procedimiento");
        let importe = fila.find(".importe");
        let total_pagar = fila.find(".monto-a-pagar");
        let pieza = fila.find(".pieza");
        let doctor = fila.find(".doctor");
        clearTimeout(fila.data("timeout"));
        //console.log("Nuevo procedimiento procesando...");
        // Esperar 2 segundo después de que todos los inputs estén llenos
        timeout = setTimeout(() => {
          const data = {
            idcliente: $("#idcliente").val(),
            idprocedimiento: procedimiento.val(),
            total_pagar: total_pagar.val(),
            importe: importe.val(),
            pieza: pieza.val(),
            doctor: doctor.val(),
          };
          //console.log(data);
          // Validar si los campos están llenos
          if (Object.values(data).every((value) => value.trim() !== "")) {
            insert(data, "pagos", "nuevoProcedimientoPago");
            //console.log(data, "Enviando datos al servidor");
            importe.val("");
            procedimiento.val("");
            pieza.val("");
            doctor.val("");
            generarTablas();
          }
        }, 2000); // Espera de 1 segundo
        fila.data("timeout", timeout); //Guardar timeout en la fila
      }
    );
  } catch (error) {
    console.log("ERror al insertar nuevo pago con su procedimiento" + error);
  }
}
// CONTINUAR CON EL PAGO DE UN PROCEDIMIENTO
async function continuarPago() {
  try {
    let timeout;
    $(document).on(
      "input change",
      ".importe-tabla, .pieza-tablas, .doctor-tablas",
      function () {
        numberFloat(".importe-tabla");
        let trfila = $(this).closest("tr");
        let importe = trfila.find("#importe-tabla");
        let pieza = trfila.find("#pieza-tabla");
        let doctor = trfila.find("#doctor");
        let idpago = trfila.data("idpago");
        let idpagodetalle = trfila.data("idpagodetalle");
        let total = trfila.data("total");
        let deuda = trfila.data("deuda");
        let monto = trfila.data("monto");
        // REINICIAR EL TIME
        clearTimeout(trfila.data("timeout"));
        // Esperar 1 segundo después de que todos los inputs estén llenos
        timeout = setTimeout(() => {
          const data = {
            idcliente: $("#idcliente").val(),
            idpago: `${idpago}`,
            importe: importe.val(),
            pieza: pieza.val(),
            doctor: doctor.val(),
            total: `${total}`,
            deuda: `${deuda}`,
            monto: monto,
          };
          //console.log(data);
          // Validar si los campos están llenos
          if (Object.values(data).every((value) => value.trim() !== "")) {
            insert(data, "pagos", "nuevoPago");
            //console.log(data, "Enviando datos al servidor");
            importe.val("");
            doctor.val("");
            pieza.val("");
            generarTablas();
          }
        }, 2000); // Espera de 2 segundo
        trfila.data("timeout", timeout); //Guardar timeout en la fila
      }
    );
  } catch (error) {
    console.log(
      "ERror al hacer un nuevo pago de un procedimiento ya creado" + error
    );
  }
}
// CALCULAR DEUDA
function calcularDeuda() {
  $(document).on("keyup", ".importe, .importe-tabla", function () {
    let fila = $(this).closest("tr");
    let montototal = fila.find("input").eq(0).val();
    let importe = $(this).val();
    let deuda = montototal - importe;
    // console.log(deuda,montototal,importe);
    if (fila.find("td").length == 4) {
      fila.find("td").eq(2).html(deuda.toFixed(2));
    } else {
      fila.find("td").eq(5).html(deuda.toFixed(2));
    }
  });
}
// HABILITAR ELIMINACION
function habilitarDelet() {
  $(document).on("click", ".btn-eliminar", function () {
    let fila = $(".row-trash");
    if (fila.css("display") == "block") {
      fila.css("display", "none");
    } else {
      fila.css("display", "block");
    }
  });
}
// ELIMINAR PAGO
async function eliminarPago() {
  $(document).on("click", ".btn-delete-row", function () {
    //console.log("eliminando esta fila"+$(this).data("idpagodetalle"));
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
    delet(data, "pagos", "deletePago");
    generarTablas();
  });
}

// OBTENER PROCEDIMIENTOS- se encargar de todo al seleccionar, mostrar precio de los procedimientos
async function getProcedimientos(type) {
  if (type == "general") {
    type = "general";
  } else if (type == "ortodoncia") {
    type = "ortodoncia";
  } else if (type == "otros") {
    type = "otros";
  } else if (type == "presupuesto") {
    type = "presupuesto";
  }
  try {
    const data = await get("pagos", `getProcedimientos${type}`);
    let html = "";
    data.forEach((element, index) => {
      html += `<option value="${element.idprocedimiento}">${element.procedimiento}</option>`;
    });
    $(`#procedimiento-${type}`).html(html);
    $(`#procedimiento-${type}`).val("");
    const idprocedimiento = data.length > 0 ? data[0].idprocedimiento : null;
    if (idprocedimiento) {
      //console.log("El primer valor es: firstValue "+idprocedimiento);
      procedimientoPrecio(idprocedimiento, type);
    }
    selectProcedimientos(type);
  } catch (error) {
    console.log("Error en obtener Procedimientos.." + error);
  }
}
function selectProcedimientos(type = null) {
  $(document).on("input change", `#procedimiento-${type}`, function () {
    let idprocedimiento = $(this).val();
    //console.log(idprocedimiento);
    procedimientoPrecio(idprocedimiento, type);
  });
  let fechaDate = new Date();
  const fecha = fechaDate.toLocaleDateString("es-MX", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
  });
  $(".mostrar-fecha").html(fecha);
}
// Muestra el Precio de procedimiento
async function procedimientoPrecio(idprocedimiento, type = null) {
  try {
    const data = await getOne(idprocedimiento, "procedimientos", "getOne");
    //console.log(data);
    $(`#monto-pagar-${type}`).val(data.precio);
  } catch (error) {
    console.log("ERror al obtener el precio del procedimiento" + error);
  }
}
// OBTENER PROCEDIMIENTOS FINAL

// EDITAR
async function activarEdit() {
  try {
    const data = await get("pagos", "getDoctores");
    $(document).on("click", ".btn-editar", function () {
      const input = $(".general-input-monto");

      if (input.prop("disabled")) {
        input.prop("disabled", false);
        $(this).html("Dejar de Editar");
        let html =
          '<select id="row-etiqueta-doctor" class="row-etiqueta-doctor">';
        data.forEach((element) => {
          html += `<option value="${element.idpersonal}" data-id="${element.etiqueta}">${element.nombre}</option>`;
        });
        html += "</select>";
        $(".row-etiqueta").html(html);
        let htmlpieza = `${generarSelectPiezas()}`;
        $(".row-pieza").html(htmlpieza);
        $(".pieza, .pieza-tablas, .doctor, .doctor-tablas").val("");
        $("#row-etiqueta-doctor, .pieza-tablas").val("");
      } else {
        input.prop("disabled", true);
        $(this).html("Editar");
        generarTablas();
        PresupuestoTotal();
      }
    });
  } catch (error) {
    console.log("Error en activar EDIT" + error);
  }
}
// update una fila, un pago_detalle
async function actualizarFilaData() {
  try {
    let timeout;
    $(document).on(
      "input change",
      ".general-input-monto,.pieza-tablas,.row-etiqueta-doctor",
      function () {
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
        timeout = setTimeout(() => {
          const data = {
            idcliente: $("#idcliente").val(),
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
          // Validar si los campos están llenos
          if (Object.values(data).every((value) => value.trim() !== "")) {
            insert(data, "pagos", "updatePago");
            console.log(data, "Enviando datos al servidor");
            generarTablas();
          }
        }, 2000); // Espera de 1 segundo
      }
    );
  } catch (error) {
    console.log(error + "ERROR EN ACTUALIZAR FILA");
  }
}

// PRESUPUESTO TOTAL TABLA, DIFERENTES A LAS DEMAS TABLAS
$(document).ready(function () {
  // NUEVO PRESUPUESTO TOTAL Y NUEVO PAGO DEL PRESUPUESTO
  NuevoPagoPresupuestoGeneral();
  // OBTENER DATOS DEL PRESUPUESTO GENERAL DE PAGOS
  // PresupuestoGeneralPagos();

  //deuda
  deudaPresupuestoTotal();
  // actualizar
  actualizarFilaPresupuesto();
  // Eliminar
  eliminarPresupuestoTotal();
  // MENSAJE
  mostrarInformacionPagos();
  // BOLETA
  mostrarImpresion();

  // PRESUPUESTO GENERAL
  getPresupuestoGeneral();
  agregarPresupuestoGeneral();
  guardarPresupuestoGeneral();
});

// -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
// PRESUPUESTO GENERAL - TOTAL
// FUNCIONA - tabla de pagos del presupuesto_pagos // falta habilitar edicion y eliminar, pero ya muestra la info

function deudaPresupuestoTotal() {
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
// FUNCIONA -> Nuevo pago de un presupuesto general, tan solo escribieendo en el importe(input)
async function NuevoPagoPresupuestoGeneral() {
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
        if (Object.values(data).every((value) => value.trim() !== "")) {
          insert(data, "pagos", "nuevoPagoPresupuestoGeneral");
          //console.log(data, "Enviando datos al servidor");
          importe.val("");
          getPresupuestoGeneral();
          PresupuestoGeneralPagos();
          generarTablas();
        }
      }, 2000); // Espera de 2 segundo
      trfila.data("timeout", timeout); //Guardar timeout en la fila
    });
  } catch (e) {
    console.log("Error al insertar nuevo pago con su procedimiento" + e);
  }
}
// ELIMINAR UN PRESUPUESTO TOTAL
function eliminarPresupuestoTotal() {
  $("#tbody-presupuesto-total").on(
    "click",
    ".btn-delete-row-presupuesto",
    function () {
      let idpresupuesto = $(this).data("idpresupuesto");
      let idpresupuestodetalle = $(this).data("idpresupuestodetalle");
      // console.log(idpresupuesto, idpresupuestodetalle);
      const data = {
        idpresupuesto: `${idpresupuesto}`,
        idpresupuestodetalle: `${idpresupuestodetalle}`,
      };
      delet(data, "pagos", "deletePresupuestoTotal");
      generarTablas();
      PresupuestoTotal();
    }
  );
}
// ACTUALIZAR DEL PRESUPUESTO TOTAL
async function actualizarFilaPresupuesto() {
  try {
    let timeout;
    $(document).on("input change", ".importe-editar", function () {
      numberFloat(".importe-editar");
      clearTimeout(timeout);
      let trfila = $(this).closest("tr");
      let idpresupuesto = trfila.data("idpresupuesto");
      let idpresupuestodetalle = trfila.data("idpresupuestodetalle");
      let importeActualizado = trfila.find(".importe-editar");
      let pieza = trfila.find(".pieza-tablas");
      timeout = setTimeout(() => {
        const data = {
          idcliente: $("#idcliente").val(),
          idpresupuesto: `${idpresupuesto}`,
          idpresupuestodetalle: `${idpresupuestodetalle}`,
          importe: `${importeActualizado.val()}`,
          pieza: pieza.val(),
        };
        //console.log(data);
        // Validar si los campos están llenos
        if (Object.values(data).every((value) => value.trim() !== "")) {
          insert(data, "pagos", "updatePresupuestoTotal");
          console.log(data, "Enviando datos al servidor");
          generarTablas();
          PresupuestoTotal();
        }
      }, 2000); // Espera de 1 segundo
    });
  } catch (error) {
    console.log(error + "ERROR EN ACTUALIZAR FILA");
  }
}
// VERIFICAR SI TIENE UN PRESUPUESTO, SI TIENE MOSTRAR LOS DATOS, SI NO MOSTRAR EL FORMULARIO
async function getPresupuestoGeneral() {
  // PRESUPUESTO GENERAL
  const tbody = $("#tbody-presupuesto-general");
  const tfoot = $("#total-presupuesto");
  let idpresupuestogeneraltest = 0;
  try {
    const id = $("#idcliente").val();
    const data = await getOne(id, "pagos", "getPresupuestoGeneral");
    let html = "";
    if (data.response === false) {
      return false;
    }
    tfoot.hide();
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
                <td></td>
                <td>Total: </td> 
                <td>${data[0].total}</td>
            </tr>`;
    //console.log(data[0].idpresupuestogeneral);
    $("#idpresupuestogeneral").val(data[0].idpresupuestogeneral);
    idpresupuestogeneral = data[0].idpresupuestogeneral;
    tbody.html(html);
  } catch (e) {
    console.log("Error en getPresupuestoGeneral", e);
  }
  // PRESUPUESTO PAGOS GENERAL
  try {
    const id = $("#idcliente").val();
    const fechaActual = new Date().toISOString().slice(0, 10);
    const data = await getOne(
      { id, idpresupuestogeneral },
      "pagos",
      "getPresupuestoPagos"
    );
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
          <tr data-idpresupuestodetalle="${pago.idpresupuestopago}" data-idpresupuesto="${pago.idpresupuestopago}">
            <td class="text-right">${total_index}</td>
            <td class="text-center"><input type="text" class="text-center importe-editar general-input-monto" value="${pago.importe}" disabled></td>
            <td>${deuda}</td>
            <td class="text-right">${pago.fecha}</td>
            <td class="row-trash" style="display:none;">
              <button class="btn-delete-row-presupuesto" data-idpresupuestopago="${pago.idpresupuestopago}" data-idpresupuestogeneral="${pago.idpresupuestopago}debeir presupuesto general aqui">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        `;
      total_index -= parseFloat(pago.importe);
      $("#monto_pagar").val(deuda);
      // html += `
      //   <tr class="fila-pago-pendiente" data-idpresupuesto="${presupuesto.idpresupuesto}">
      //     <td class="text-right">${fechaActual}</td>
      //     <td class="text-right">
      //       <input type="text" class="text-right presupuesto-monto" id="presupuesto-monto" value="${deudaPendiente}" disabled>
      //     </td>
      //     <td>
      //       <input type="text" class="importe-nuevo" placeholder="Nuevo importe" id='importe-nuevo'>
      //     </td>
      //     <td class="deuda-tabla-presupuesto">${deudaPendiente}</td>
      //   </tr>
      //   <tr>
      //       <td>-</td>
      //       <td>-</td>
      //       <td>-</td>
      //       <td>-</td>
      //   </tr>
      // `;
      // // Presupuesto completamente pagado
      // html += `<tr>
      //           <td class="cancelado">-</td>
      //           <td class="cancelado">Cancelado</td>
      //           <td class="cancelado">Cancelado</td>
      //           <td class="cancelado">Cancelado</td>
      //         </tr>`;
    });
    $("#tbody-presupuesto-total").html(html);
  } catch (e) {
    console.log("Error en presupuesto total: ", e);
  }
}
// Agrega un procedimiento para el presupuesto y tambien lo elimina de la eleccion
function agregarPresupuestoGeneral() {
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
                  <td>${precio}</td>
                  <td class="row-trash">
                    <button class="button btn-danger" id="echar-eleccion">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </td>
                </tr>`;
      tbody.append(html);
      $("#pieza-presupuesto,#procedimiento-presupuesto").val("");
      $("#mostrar-total-presupuesto").html(precio_total);
    }
  });
  // ELiminar la eleccion
  $(document).on("click", "#echar-eleccion", function () {
    const tr = $(this).closest("tr");
    tr.remove();
  });
}
// guarda en el presupuesto general con los procedimientos seleccionados
async function guardarPresupuestoGeneral() {
  try {
    $("#guardar-presupuesto-general").on("click", function () {
      const tbody = $("#tbody-presupuesto-general");
      const idcliente = $("#idcliente").val();
      const data = [{ idcliente: idcliente }, []];
      tbody.find("tr").each(function () {
        const idprocedimiento = $(this).data("idprocedimiento");
        const pieza = $(this).data("pieza");
        const precio = $(this).data("precio");
        if (validar(idprocedimiento) && validar(pieza) && validar(precio)) {
          data[1].push({
            idprocedimiento: idprocedimiento,
            pieza: pieza,
            precio: precio,
          });
        }
      });
      if (data.length > 0) {
        console.log("data", data);
        insert({ data: data }, "pagos", "nuevoPresupuestoGeneral");
        getPresupuestoGeneral();
        PresupuestoGeneralPagos();
      } else {
        console.log("No hay datos para guardar");
      }
      tbody.empty(); // Limpiar la tabla después de guardar
    });
  } catch (error) {
    console.log("Error al guardar el presupuesto general: ", error);
  }
}
// PRESUPUESTOS END *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
async function mostrarInformacionPagos() {
  try {
    const idcliente = $("#idcliente").val();
    const data = await getOne(idcliente, "pagos", "mostrarInformacionPagos");
    const presupuesto = data.presupuesto,
      general = data.general;
    const mensaje = $("#mensaje");
    const deuda = $("#deuda_total");
    const importe = $("#importe_total");
    const total = $("#total_total");
    deudaTotal =
      parseFloat(presupuesto.suma_total) - parseFloat(presupuesto.suma_importe);
    deuda.html(`S/. ${deudaTotal}`);
    importe.html(`S/. ${presupuesto.suma_importe}`);
    total.html(`S/. ${presupuesto.suma_total}`);
    if (general.suma_total != presupuesto.suma_total) {
      mensaje.html("El Presupuesto total no coincide con el General");
      mensaje.addClass("mensaje-rojo");
      return;
    }
    if (general.suma_monto < presupuesto.suma_importe) {
      mensaje.html("Los pagos estan desactualizados, actualice los pagos");
      mensaje.css("color: #ff0000");
      return;
    }
    mensaje.html("Datos Correctos");
  } catch (error) {
    console.log(error + "ERROR EN MOSTRAR INFORMACION DE PAGOS");
  }
}
1;
function mostrarImpresion() {
  $("#boletaparaimprimir").on("click", async function () {
    try {
      const idcliente = $("#idcliente").val();
      await getOne({ id: idcliente, status: "todo" }, "pagos", "DataBoleta");
    } catch (e) {
      console.log("No se pudo imprimri", e);
    }
    $("#contenidoticket").html(
      `<iframe id="frmticket" src="http://localhost/clinic/boleta.pdf" style="display:none;"></iframe>`
    );
    $("#frmticket").on("load", function () {
      this.contentWindow.focus();
      this.contentWindow.print();
    });
  });
  $("#boletaprint").on("click", async function () {
    try {
      const idcliente = $("#idcliente").val();
      await getOne({ id: idcliente, status: "actual" }, "pagos", "DataBoleta");
    } catch (e) {
      console.log("No se pudo imprimri", e);
    }
    $("#contenidoticket").html(
      `<iframe id="frmticket" src="http://localhost/clinic/boleta.pdf" style="display:none;"></iframe>`
    );
    $("#frmticket").on("load", function () {
      this.contentWindow.focus();
      this.contentWindow.print();
    });
  });
}
