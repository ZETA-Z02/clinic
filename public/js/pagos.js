$(document).ready(function(){
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

    //EDIT
    activarEdit();
    actualizarFilaData();
});
function generarTablas(){
    Presupuestos('general');
    Presupuestos('ortodoncia');
    Presupuestos('otros');
}
function btnTablas() {
    $(".modal").hide();
    $(".activate").click(function () {
      let idtabla = $(this).data("id");
      // console.log(idtabla);
      $(".modal").hide();
      $("#tabla-" + idtabla).show();
    });
}
async function Presupuestos(type) {
  try {
    // Obteniendo el id del cliente
    let idcliente = $("#idcliente").val();
    const data = await getOne({id:idcliente,tipo:type}, "pagos", "presupuestos");//SOlicitud al servidor
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
        <tr data-idpago="${element.idpago}" data-idpagodetalle="${element.idpagodetalle}" data-total="${total}" data-deuda="${deuda}" data-monto="${element.monto_pagado}" data-importeactual="${element.monto}">
                  <td>${element.fecha}</td>
                  <td class="row-pieza">${element.pieza}</td>
                  <td>${element.procedimiento}</td>
                  <td>${total - monto}</td>
                  <td>
                    <input type="text" class="general-input-monto" id="input-importe-data" value="${element.monto}" disabled>
                  </td>
                  <td>${restante}</td>
                  <td class="row-etiqueta">${element.etiqueta}</td>
                  <td class="row-trash" style="display:none;">
                    <button class="btn-delete-row" data-idpagodetalle="${element.idpagodetalle}">
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
                          <td>${generarSelectPiezas()}</td>
                          <td>${element.procedimiento}</td>
                          <td><input type="text" value="${total - monto}" disabled></td>
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
      }
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
      }
    });
    tbody.append(html);
  } catch (error) {
    console.log(error+"AL OBTENER DATOS EN LA TABLAS PAGOS");
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
      $(".importe, .procedimiento, .pieza, .doctor").on("input change",function () {
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
            console.log(data);
            // Validar si los campos están llenos
            if (Object.values(data).every((value) => value.trim() !== "")) {
              insert(data, "pagos", "nuevoProcedimientoPago");
              console.log(data, "Enviando datos al servidor");
              importe.val("");
              procedimiento.val("");
              pieza.val("");
              doctor.val("");
              generarTablas();
            }
          }, 2000); // Espera de 1 segundo
          fila.data("timeout",timeout); //Guardar timeout en la fila
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
      $(document).on("input change",".importe-tabla, .pieza-tablas, .doctor-tablas",function () {
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
          trfila.data("timeout",timeout); //Guardar timeout en la fila
        }
      );
    } catch (error) {
      console.log("ERror al hacer un nuevo pago de un procedimiento ya creado" + error);
    }
}
// CALCULAR DEUDA
function calcularDeuda() {
    $(document).on("keyup", '.importe, .importe-tabla', function () {
        let fila = $(this).closest("tr");
        let montototal = fila.find("input").eq(0).val();
        let importe = $(this).val();
        let deuda = montototal - importe;
        // console.log(deuda,montototal,importe);
        fila.find("td").eq(4).html(deuda.toFixed(2));
    });
}
// HABILITAR ELIMINACION
function habilitarDelet(){
    $(document).on('click','.btn-eliminar',function(){
        let fila = $(".row-trash");
        if(fila.css("display") == "block"){
            fila.css("display","none");
        }else{
            fila.css("display","block");
        }
    });
}
// ELIMINAR PAGO
async function eliminarPago(){
    $(document).on("click",".btn-delete-row",function(){
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
        importeActual: importeActual
      }
      console.log(data);
      delet(data, 'pagos', 'deletePago');
      generarTablas();
    });
}

// OBTENER PROCEDIMIENTOS
async function getProcedimientos(type) {
    if(type=="general"){
        type = "general";
    }else if(type=="ortodoncia"){
        type = "ortodoncia";
    }else if(type=="otros"){
        type = "otros";
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
            procedimientoPrecio(idprocedimiento,type);
        }
        selectProcedimientos(type);
    } catch (error) {
        console.log("Error en obtener Procedimientos.." + error);
    }
}
function selectProcedimientos(type=null) {
    $(document).on("input change", `#procedimiento-${type}`, function () {
        let idprocedimiento = $(this).val();
        //console.log(idprocedimiento);
        procedimientoPrecio(idprocedimiento,type);
    });
    let fecha = new Date().toISOString().slice(0, 10);
    $(".mostrar-fecha").html(fecha);
}
// Muestra el Precio de procedimiento
async function procedimientoPrecio(idprocedimiento,type=null) {
    try {
        const data = await getOne(idprocedimiento, "procedimientos", "getOne");
        //console.log(data);
        $(`#monto-pagar-${type}`).val(data.precio);
    } catch (error) {
        console.log("ERror al obtener el precio del procedimiento" + error);
    }
}

// EDITAR
async function activarEdit() {
    try {
        const data = await get("pagos", "getDoctores");
        $(document).on("click", ".btn-editar", function () {
        const input = $(".general-input-monto");

        if (input.prop("disabled")) {
            input.prop("disabled", false);
            $(this).html("Dejar de Editar");
            let html = '<select id="row-etiqueta-doctor" class="row-etiqueta-doctor">';
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
        }
        });
    } catch (error) {
        console.log("Error en activar EDIT" + error);
    }
}
  // update una fila, un pago_detalle
async function actualizarFilaData() {
    try{
        let timeout;
        $(document).on("input change",".general-input-monto,.pieza-tablas,.row-etiqueta-doctor",function () {
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
                console.log(data);
                // Validar si los campos están llenos
                if (Object.values(data).every((value) => value.trim() !== "")) {
                    insert(data, "pagos", "updatePago");
                    console.log(data, "Enviando datos al servidor");
                    generarTablas();
                }
            }, 2000); // Espera de 1 segundo
        });
    }catch(error){
        console.log(error+"ERROR EN ACTUALIZAR FILA");
    }
}