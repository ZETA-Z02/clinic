$(document).ready(function () {
  // Validadores
  numberFloat("#monto-pagar,#importe");

  btnTablas();
  ObtenerPresupuestoGeneral();

  // OBTENER DATOS Y DEMAS
//  getDoctores();
  getProcedimientos();
  selectProcedimientos();

  //INSERTA DATOS
  NuevoProcedimiento();
  continuarPago(); // Pago de un procedimiento ya creado
  // Mas
  calcularDeuda('#importe-tabla','#importe','#monto-pagar','#mostrar-deuda');
  activarEdit();
  actualizarFilaData();
  // ELIMINAR
  habilitarDelet();
  eliminarPago();
});

// PRESUPUESTO GENERAL -**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--*-*-
async function ObtenerPresupuestoGeneral() {
  try {
    let idcliente = $("#idcliente").val();
    const data = await getOne(idcliente, "pagos", "getPresupuestoGeneral");
    //console.log(data);
    const tbody = $("#tabla-procedimientos");
    tbody.empty();
    let fechaActual = new Date().toISOString().slice(0, 10);
    let monto = 0;
    let deuda = 0;
    let total = 0;
    data.forEach((element) => {
      deuda = parseFloat(element.saldo_pendiente);
      total = parseFloat(element.total_pagar);
      tbody.append(`
        <tr data-idpago="${element.idpago}" data-idpagodetalle="${element.idpagodetalle}" data-total="${total}" data-deuda="${deuda}" data-monto="${element.monto_pagado}" data-importeactual="${element.monto}">
                    <td>${element.fecha}</td>
                    <td>${element.procedimiento}</td>
                    <td>${total - monto}</td>
                    <td><input type="text" class="general-input-monto" id="input-importe-data" value="${
                      element.monto
                    }" disabled></td>
                    <td>${total - monto - element.monto}</td>
                    <td class="row-pieza">${element.pieza}</td>
                    <td class="row-etiqueta">${element.etiqueta}</td>
                    <td class="row-trash" style="display:none;"><button class="btn-delete-row" data-idpagodetalle="${element.idpagodetalle}"><i class="fa-solid fa-trash"></i></button></td>
                </tr>
            `);
      monto += parseFloat(element.monto);
      //console.log(deuda,monto,total);
      if (deuda > 0 && monto + deuda === total) {
        //console.log("entro");
        tbody.append(`
          <tr class="fila-pago" data-idpago="${element.idpago}" data-total="${total}" data-monto="${element.monto_pagado}" data-deuda="${deuda}">
                        <td>${fechaActual}</td>
                        <td>${element.procedimiento}</td>
                        <td>${total - monto}</td>
                        <td><input type="text" class="input-importe" placeholder="Nuevo importe" id='importe-tabla'></td>
                        <td id='deuda-tabla'>-</td>
                        <td>
                            <select name="pieza" id="pieza-tabla-general">
                                <option value="1.1">1.1</option>
                                <option value="1.2">1.2</option>
                                <option value="1.3">1.3</option>
                                <option value="1.4">1.4</option>
                                <option value="1.5">1.5</option>
                                <option value="1.6">1.6</option>
                                <option value="1.7">1.7</option>
                                <option value="1.8">1.8</option>
                                <option value="2.1">2.1</option>
                                <option value="2.2">2.2</option>
                                <option value="2.3">2.3</option>
                                <option value="2.4">2.4</option>
                                <option value="2.5">2.5</option>
                                <option value="2.6">2.6</option>
                                <option value="2.7">2.7</option>
                                <option value="2.8">2.8</option>
                                <option value="3.1">3.1</option>
                                <option value="3.2">3.2</option>
                                <option value="3.3">3.3</option>
                                <option value="3.4">3.4</option>
                                <option value="3.5">3.5</option>
                                <option value="3.6">3.6</option>
                                <option value="3.7">3.7</option>
                                <option value="3.8">3.8</option>
                                <option value="4.1">4.1</option>
                                <option value="4.2">4.2</option>
                                <option value="4.3">4.3</option>
                                <option value="4.4">4.4</option>
                                <option value="4.5">4.5</option>
                                <option value="4.6">4.6</option>
                                <option value="4.7">4.7</option>
                                <option value="4.8">4.8</option>
                            </select>
                        </td>
                        <td><select name="doctor" id="doctor" class='doctor'></select></td>
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
                `);
        monto = 0;
        deuda = 0;
        total = 0;
      }
      if(deuda==0 && monto===total && total>0){
        //console.log(monto,total)
        tbody.append(`<tr>
          <td>-</td>
          <td>${element.procedimiento}</td>
          <td>Cancelado</td>
          <td>Cancelado</td>
          <td>Cancelado</td>
          <td>-</td>
          <td>-</td>
        </tr>`);  
        monto = 0;
        deuda = 0;
        total = 0;
      }
    });
  } catch (error) {
    console.log(error);
  }
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
async function getDoctores() {
  try {
    const data = await get("pagos", "getDoctores");
    let html = "";
    data.forEach((element) => {
      html += `<option value="${element.idpersonal}" data-id="${element.etiqueta}">${element.nombre}</option>`;
    });
    //$("#doctores,#doctor,#doctores-ortodoncia,#doctor-ortodoncia").html(html);
    $(".doctor").html(html);
    $(".doctor").val("");
    //$("#doctores,#doctor,#doctores-ortodoncia,#doctor-ortodoncia").val("");
    $("#pieza, #pieza-tabla-general").val("");
  } catch (error) {
    console.log("Error en obtener Doctores.." + error);
  }
}
async function getProcedimientos() {
  try {
    const data = await get("pagos", "getProcedimientos");
    let html = "";
    data.forEach((element, index) => {
      html += `<option value="${element.idprocedimiento}">${element.procedimiento}</option>`;
    });
    $("#procedimiento").html(html);
    $("#procedimiento").val("");
    const idprocedimiento = data.length > 0 ? data[0].idprocedimiento : null;
    if (idprocedimiento) {
      //console.log("El primer valor es: firstValue "+idprocedimiento);
      procedimientoPrecio(idprocedimiento);
    }
  } catch (error) {
    console.log("Error en obtener Doctores.." + error);
  }
}
function selectProcedimientos() {
  $(document).on("input change", "#procedimiento", function () {
    let idprocedimiento = $(this).val();
    //console.log(idprocedimiento);
    procedimientoPrecio(idprocedimiento);
  });
  let fecha = new Date().toISOString().slice(0, 10);
  $("#mostrar-fecha").html(fecha);
}
// Muestra el Precio de procedimiento
async function procedimientoPrecio(idprocedimiento) {
  try {
    const data = await getOne(idprocedimiento, "procedimientos", "getOne");
    //console.log(data);
    $("#monto-pagar").val(data.precio);
  } catch (error) {
    console.log("ERror al obtener el precio del procedimiento" + error);
  }
}
function calcularDeuda(idimportetabla, idimporte, idmontototal, idmostrardeuda) {
  $(document).on("keyup", idimportetabla, function () {
    let montototal = parseFloat($(this).closest("tr").find("td").eq(2).html()) || 0;
    let importe = $(this).val();
    let deuda = montototal - importe;
    //console.log(deuda,montototal,importe)
    $(this).closest("tr").find("td").eq(4).html(deuda.toFixed(2));
  });
  $(document).on("keyup", idimporte, function () {
    let monto = $(idmontototal).val();
    let deuda = $(this).val();
    let total = monto - deuda;
    $(idmostrardeuda).html(total);
  });
}
async function NuevoProcedimiento() {
  try {
    let timeout;
    $("#importe, #procedimiento, #pieza, #doctores").on(
      "input change",
      function () {
        clearTimeout(timeout);
        //console.log("Nuevo procedimiento procesando...");
        // Esperar 1 segundo después de que todos los inputs estén llenos
        timeout = setTimeout(() => {
          const data = {
            idcliente: $("#idcliente").val(),
            idprocedimiento: $("#procedimiento").val(),
            total_pagar: $("#monto-pagar").val(),
            importe: $("#importe").val(),
            pieza: $("#pieza").val(),
            doctores: $("#doctores").val(),
          };
          //console.log(data);
          // Validar si los campos están llenos
          if (Object.values(data).every((value) => value.trim() !== "")) {
            insert(data, "pagos", "nuevoProcedimientoPago");
            console.log(data, "Enviando datos al servidor");
            $("#importe").val("");
            $("#procedimiento").val("");
            $("#pieza").val("");
            $("#doctores").val("");
            ObtenerPresupuestoGeneral();
            getDoctores();
          }
        }, 2000); // Espera de 1 segundo
      }
    );
  } catch (error) {
    console.log("ERror al insertar nuevo pago con su procedimiento" + error);
  }
}
async function activarEdit() {
  try {
    const data = await get("pagos", "getDoctores");
    $(document).on("click", ".btn-editar", function () {
      const input = $(".general-input-monto");
      let htmlinput = input.html();
      if (input.prop("disabled")) {
        input.prop("disabled", false);
        $(this).html("Dejar de Editar");
        let html = '<select id="row-etiqueta-doctor" class="row-etiqueta-doctor">';
        data.forEach((element) => {
          html += `<option value="${element.idpersonal}" data-id="${element.etiqueta}">${element.nombre}</option>`;
        });
        html += "</select>";
        $(".row-etiqueta").html(html);
        let htmlpieza = `<select name="pieza" id="row-pieza" class="row-pieza-edit">
                                <option value="1.1">1.1</option>
                                <option value="1.2">1.2</option>
                                <option value="1.3">1.3</option>
                                <option value="1.4">1.4</option>
                                <option value="1.5">1.5</option>
                                <option value="1.6">1.6</option>
                                <option value="1.7">1.7</option>
                                <option value="1.8">1.8</option>
                                <option value="2.1">2.1</option>
                                <option value="2.2">2.2</option>
                                <option value="2.3">2.3</option>
                                <option value="2.4">2.4</option>
                                <option value="2.5">2.5</option>
                                <option value="2.6">2.6</option>
                                <option value="2.7">2.7</option>
                                <option value="2.8">2.8</option>
                                <option value="3.1">3.1</option>
                                <option value="3.2">3.2</option>
                                <option value="3.3">3.3</option>
                                <option value="3.4">3.4</option>
                                <option value="3.5">3.5</option>
                                <option value="3.6">3.6</option>
                                <option value="3.7">3.7</option>
                                <option value="3.8">3.8</option>
                                <option value="4.1">4.1</option>
                                <option value="4.2">4.2</option>
                                <option value="4.3">4.3</option>
                                <option value="4.4">4.4</option>
                                <option value="4.5">4.5</option>
                                <option value="4.6">4.6</option>
                                <option value="4.7">4.7</option>
                                <option value="4.8">4.8</option>
                            </select>`;
        $(".row-pieza").html(htmlpieza);
        $("#pieza,#pieza-tabla-general,#row-etiqueta-doctor,#row-pieza").val("");
      } else {
        input.prop("disabled", true);
        $(this).html("Editar");
        ObtenerPresupuestoGeneral();
        ObtenerPresupuestoOrtodoncia();
      }
    });
  } catch (error) {
    console.log("Error en obtener Doctores.." + error);
  }
}
// update una fila, un pago_detalle
async function actualizarFilaData() {
  try{
		let timeout;
		$(document).on("input change",".general-input-monto,.row-pieza-edit,.row-etiqueta-doctor",function () {
			numberFloat(".general-input-monto");
			clearTimeout(timeout);
			let trfila = $(this).closest("tr");
			let idpago = trfila.data("idpago");
			let idpagodetalle = trfila.data("idpagodetalle");
			let importeActualizado = trfila.find(".general-input-monto");
			let importeActual = trfila.data("importeactual");
			let pieza = trfila.find(".row-pieza-edit");
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
				// Validar si los campos están llenos
				if (Object.values(data).every((value) => value.trim() !== "")) {
            insert(data, "pagos", "updatePago");
            console.log(data, "Enviando datos al servidor");
            //   importe.val("");
            //   doctor.val("");
            //   pieza.val("");
            ObtenerPresupuestoGeneral();
            ObtenerPresupuestoOrtodoncia();
            //   getDoctores();
				}
			}, 2000); // Espera de 1 segundo
		}
	);
  }catch(error){
	console.log(error+"ERROR EN ACTUALIZAR FILA");
  }
}
async function continuarPago() {
  try {
    let timeout;
    $(document).on("input change","#importe-tabla, #pieza-tabla-general, #doctor",function () {
        numberFloat(".input-importe");
        clearTimeout(timeout);
        let trfila = $(this).closest("tr");
        let importe = trfila.find("#importe-tabla");
        let pieza = trfila.find("#pieza-tabla-general");
        let doctor = trfila.find("#doctor");
        let idpago = trfila.data("idpago");
        let idpagodetalle = trfila.data("idpagodetalle");
        let total = trfila.data("total");
        let deuda = trfila.data("deuda");
        let monto = trfila.data("monto");
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
            ObtenerPresupuestoGeneral();
            getDoctores();
          }
        }, 2000); // Espera de 2 segundo
      }
    );
  } catch (error) {
    console.log(
      "ERror al hacer un nuevo pago de un procedimiento ya creado" + error
    );
  }
}
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
async function eliminarPago(){
  $(document).on("click",".btn-delete-row",function(){
    console.log("eliminando esta fila"+$(this).data("idpagodetalle"));
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
    delet(data, 'pagos', 'deletePagoGeneral');
    ObtenerPresupuestoGeneral();
    ObtenerPresupuestoOrtodoncia();
  })
}

// PRESUPUESTO GENERAL END -**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--*-*-

// Presupuesto Ortodoncia -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
$(document).ready(function (){
  calcularDeuda('#importe-tabla-ortodoncia','#importe-ortodoncia','#monto-pagar-ortodoncia','#mostrar-deuda-ortodoncia');
  ObtenerPresupuestoOrtodoncia();
  SelectOrtodoncia();
  // POST
  NuevaOrtodoncia();
  continuarPagoOrtodoncia(); 


  // buttons

});
async function ObtenerPresupuestoOrtodoncia() {
  try {
    let idcliente = $("#idcliente").val();
    const data = await getOne(idcliente, "pagos", "getPresupuestoOrtodoncia");
    //console.log(data);
    const tbody = $("#tbody-ortodoncia");
    tbody.empty();
    let fechaActual = new Date().toISOString().slice(0, 10);
    let monto = 0;
    let deuda = 0;
    let total = 0;
    data.forEach((element) => {
      deuda = parseFloat(element.saldo_pendiente);
      total = parseFloat(element.total_pagar);
      tbody.append(`
              <tr data-idpago="${element.idpago}" data-idpagodetalle="${element.idpagodetalle}" data-total="${total}" data-deuda="${deuda}" data-monto="${element.monto_pagado}" data-importeactual="${element.monto}">
                    <td>${element.fecha}</td>
                    <td>${element.procedimiento}</td>
                    <td>${total - monto}</td>
                    <td><input type="text" class="general-input-monto" id="input-importe-data" value="${
                      element.monto
                    }" disabled></td>
                    <td>${total - monto - element.monto}</td>
                    <td class="row-pieza">${element.pieza}</td>
                    <td class="row-etiqueta">${element.etiqueta}</td>
                    <td class="row-trash" style="display:none;"><button class="btn-delete-row" data-idpagodetalle="${element.idpagodetalle}"><i class="fa-solid fa-trash"></i></button></td>
                </tr>
            `);
      monto += parseFloat(element.monto);
      //console.log(deuda,monto,total);
      if (deuda > 0 && monto + deuda === total) {
        //console.log("entro al if de ortodoncia");
        tbody.append(`<tr class="fila-pago" data-idpago="${element.idpago}" data-total="${total}" data-monto="${element.monto_pagado}" data-deuda="${deuda}">
                        <td>${fechaActual}</td>
                        <td>${element.procedimiento}</td>
                        <td>${total - monto}</td>
                        <td>
                          <input type="text" class="input-importe" placeholder="Nuevo importe" id='importe-tabla-ortodoncia'>
                        </td>
                        <td id='deuda-tabla-ortodoncia'>-</td>
                        <td>
                            <select name="pieza" id="pieza-tabla-ortodoncia">
                                <option value="1.1">1.1</option>
                                <option value="1.2">1.2</option>
                                <option value="1.3">1.3</option>
                                <option value="1.4">1.4</option>
                                <option value="1.5">1.5</option>
                                <option value="1.6">1.6</option>
                                <option value="1.7">1.7</option>
                                <option value="1.8">1.8</option>
                                <option value="2.1">2.1</option>
                                <option value="2.2">2.2</option>
                                <option value="2.3">2.3</option>
                                <option value="2.4">2.4</option>
                                <option value="2.5">2.5</option>
                                <option value="2.6">2.6</option>
                                <option value="2.7">2.7</option>
                                <option value="2.8">2.8</option>
                                <option value="3.1">3.1</option>
                                <option value="3.2">3.2</option>
                                <option value="3.3">3.3</option>
                                <option value="3.4">3.4</option>
                                <option value="3.5">3.5</option>
                                <option value="3.6">3.6</option>
                                <option value="3.7">3.7</option>
                                <option value="3.8">3.8</option>
                                <option value="4.1">4.1</option>
                                <option value="4.2">4.2</option>
                                <option value="4.3">4.3</option>
                                <option value="4.4">4.4</option>
                                <option value="4.5">4.5</option>
                                <option value="4.6">4.6</option>
                                <option value="4.7">4.7</option>
                                <option value="4.8">4.8</option>
                            </select>
                        </td>
                        <td><select name="doctor" id="doctor-ortodoncia" class="doctor"></select></td>
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
                `);
        monto = 0;
        deuda = 0;
        total = 0;
      }
      if(deuda==0 && monto===total && total>0){
        //console.log(monto,total)
        tbody.append(`<tr>
          <td>-</td>
          <td>${element.procedimiento}</td>
          <td>Cancelado</td>
          <td>Cancelado</td>
          <td>Cancelado</td>
          <td>-</td>
          <td>-</td>
        </tr>`);  
        monto = 0;
        deuda = 0;
        total = 0;
      }
    });
  } catch (error) {
    console.log(error);
  }
}
async function NuevaOrtodoncia(){
  try {
    let timeout;
    $("#importe-ortodoncia, #procedimiento-ortodoncia, #pieza-ortodoncia, #doctores-ortodoncia").on("input change", function () {
        clearTimeout(timeout);
        //console.log("Nuevo procedimiento procesando...");
        // Esperar 1 segundo después de que todos los inputs estén llenos
        timeout = setTimeout(() => {
          const data = {
            idcliente: $("#idcliente").val(),
            idprocedimiento: $("#procedimiento-ortodoncia").val(),
            total_pagar: $("#monto-pagar-ortodoncia").val(),
            importe: $("#importe-ortodoncia").val(),
            pieza: $("#pieza-ortodoncia").val(),
            doctores: $("#doctores-ortodoncia").val(),
          };
          console.log(data);
          // Validar si los campos están llenos
          if (Object.values(data).every((value) => value.trim() !== "")) {
            insert(data, "pagos", "nuevoProcedimientoPago");
            //console.log(data, "Enviando datos al servidor");
            $("#importe-ortodoncia").val("");
            $("#procedimiento-ortodoncia").val("");
            $("#pieza-ortodoncia").val("");
            $("#doctor-ortodoncia").val("");
            ObtenerPresupuestoOrtodoncia();
            getDoctores();
          }
        }, 2000); // Espera de 1 segundo
      }
    );
  } catch (error) {
    console.log("ERror al insertar nuevo pago con su procedimiento" + error);
  }  
}
async function SelectOrtodoncia(){
  try {
    const data = await get("pagos", "getProcedimientoOrtodoncia");
    let html = "";
    data.forEach((element, index) => {
      html += `<option value="${element.idprocedimiento}">${element.procedimiento}</option>`;
      $("#monto-pagar-ortodoncia").val(element.precio);
    });
    $("#procedimiento-ortodoncia").html(html);
    $("#pieza-ortodoncia").val("");
  } catch (error) {
    console.log("Error en obtener Doctores.." + error);
  } 
}
async function continuarPagoOrtodoncia() {
  try {
    let timeout;
    $(document).on("input change","#importe-tabla-ortodoncia, #pieza-tabla-ortodoncia, #doctor-ortodoncia",function () {
        console.log("cambios en inputs ed ortodoncia");
        numberFloat(".input-importe");
        clearTimeout(timeout);
        let trfila = $(this).closest("tr");
        let importe = trfila.find("#importe-tabla-ortodoncia");
        let pieza = trfila.find("#pieza-tabla-ortodoncia");
        let doctor = trfila.find("#doctor-ortodoncia");
        let idpago = trfila.data("idpago");
        let idpagodetalle = trfila.data("idpagodetalle");
        let total = trfila.data("total");
        let deuda = trfila.data("deuda");
        let monto = trfila.data("monto");
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
            ObtenerPresupuestoOrtodoncia();
            getDoctores();
          }
        }, 2000); // Espera de 2 segundo
      }
    );
  } catch (error) {
    console.log(
      "ERror al hacer un nuevo pago de un procedimiento ya creado" + error
    );
  }
}
// Presupuesto Ortodoncia END -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

// PRESUPUESTO OTROS /*/*/*/*/*/*/*/*/*/*/*/*/**/*/*/*/*/*/*/*/*/**/*/*/*/*/*/*/*/*/ */ */
$(document).ready(function () {
  calcularDeuda('#importe-tabla-otros','#importe-otros','#monto-pagar-otros','#mostrar-deuda-otros');
  SelectOtros();
  ObtenerPresupuestoOtros();
  NuevoOtros();
  continuarPagoOtros();
  // DOctores
  getDoctores();
})
async function ObtenerPresupuestoOtros() {
  try {
    let idcliente = $("#idcliente").val();
    const data = await getOne(idcliente, "pagos", "getPresupuestoOtros");
    //console.log(data);
    const tbody = $("#tbody-otros");
    tbody.empty();
    let fechaActual = new Date().toISOString().slice(0, 10);
    let monto = 0;
    let deuda = 0;
    let total = 0;
    data.forEach((element) => {
      deuda = parseFloat(element.saldo_pendiente);
      total = parseFloat(element.total_pagar);
      tbody.append(`
              <tr data-idpago="${element.idpago}" data-idpagodetalle="${element.idpagodetalle}" data-total="${total}" data-deuda="${deuda}" data-monto="${element.monto_pagado}" data-importeactual="${element.monto}">
                    <td>${element.fecha}</td>
                    <td>${element.procedimiento}</td>
                    <td>${total - monto}</td>
                    <td><input type="text" class="general-input-monto" id="input-importe-data" value="${
                      element.monto
                    }" disabled></td>
                    <td>${total - monto - element.monto}</td>
                    <td class="row-pieza">${element.pieza}</td>
                    <td class="row-etiqueta">${element.etiqueta}</td>
                    <td class="row-trash" style="display:none;"><button class="btn-delete-row" data-idpagodetalle="${element.idpagodetalle}"><i class="fa-solid fa-trash"></i></button></td>
                </tr>
            `);
      monto += parseFloat(element.monto);
      //console.log(deuda,monto,total);
      if (deuda > 0 && monto + deuda === total) {
        //console.log("entro al if de ortodoncia");
        tbody.append(`<tr class="fila-pago" data-idpago="${element.idpago}" data-total="${total}" data-monto="${element.monto_pagado}" data-deuda="${deuda}">
                        <td>${fechaActual}</td>
                        <td>${element.procedimiento}</td>
                        <td>${total - monto}</td>
                        <td>
                          <input type="text" class="input-importe" placeholder="Nuevo importe" id='importe-tabla-otros'>
                        </td>
                        <td id='deuda-tabla-ortodoncia'>-</td>
                        <td>
                            <select name="pieza" id="pieza-tabla-otros">
                                <option value="1.1">1.1</option>
                                <option value="1.2">1.2</option>
                                <option value="1.3">1.3</option>
                                <option value="1.4">1.4</option>
                                <option value="1.5">1.5</option>
                                <option value="1.6">1.6</option>
                                <option value="1.7">1.7</option>
                                <option value="1.8">1.8</option>
                                <option value="2.1">2.1</option>
                                <option value="2.2">2.2</option>
                                <option value="2.3">2.3</option>
                                <option value="2.4">2.4</option>
                                <option value="2.5">2.5</option>
                                <option value="2.6">2.6</option>
                                <option value="2.7">2.7</option>
                                <option value="2.8">2.8</option>
                                <option value="3.1">3.1</option>
                                <option value="3.2">3.2</option>
                                <option value="3.3">3.3</option>
                                <option value="3.4">3.4</option>
                                <option value="3.5">3.5</option>
                                <option value="3.6">3.6</option>
                                <option value="3.7">3.7</option>
                                <option value="3.8">3.8</option>
                                <option value="4.1">4.1</option>
                                <option value="4.2">4.2</option>
                                <option value="4.3">4.3</option>
                                <option value="4.4">4.4</option>
                                <option value="4.5">4.5</option>
                                <option value="4.6">4.6</option>
                                <option value="4.7">4.7</option>
                                <option value="4.8">4.8</option>
                            </select>
                        </td>
                        <td><select name="doctor" id="doctor-otros" class="doctor"></select></td>
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
                `);
        monto = 0;
        deuda = 0;
        total = 0;
      }
      if(deuda==0 && monto===total && total>0){
        //console.log(monto,total)
        tbody.append(`<tr>
          <td>-</td>
          <td>${element.procedimiento}</td>
          <td>Cancelado</td>
          <td>Cancelado</td>
          <td>Cancelado</td>
          <td>-</td>
          <td>-</td>
        </tr>`);  
        monto = 0;
        deuda = 0;
        total = 0;
      }
    });
  } catch (error) {
    console.log(error);
  }
}
async function NuevoOtros(){
  try {
    let timeout;
    $("#importe-otros, #procedimiento-otros, #pieza-otros, #doctores-otros").on("input change", function () {
        clearTimeout(timeout);
        //console.log("Nuevo procedimiento procesando...");
        // Esperar 1 segundo después de que todos los inputs estén llenos
        timeout = setTimeout(() => {
          const data = {
            idcliente: $("#idcliente").val(),
            idprocedimiento: $("#procedimiento-otros").val(),
            total_pagar: $("#monto-pagar-otros").val(),
            importe: $("#importe-otros").val(),
            pieza: $("#pieza-otros").val(),
            doctores: $("#doctores-otros").val(),
          };
          //console.log(data);
          // Validar si los campos están llenos
          if (Object.values(data).every((value) => value.trim() !== "")) {
            insert(data, "pagos", "nuevoProcedimientoPago");
            //console.log(data, "Enviando datos al servidor");
            $("#importe-otros").val("");
            $("#procedimiento-otros").val("");
            $("#pieza-otros").val("");
            $("#doctores-otros").val("");
            ObtenerPresupuestoOtros();
            getDoctores();
          }
        }, 2000); // Espera de 1 segundo
      }
    );
  } catch (error) {
    console.log("ERror al insertar nuevo pago con su procedimiento" + error);
  }  
}
async function SelectOtros(){
  try {
    const data = await get("pagos", "getProcedimientoOtros");
    let html = "";
    data.forEach((element, index) => {
      html += `<option value="${element.idprocedimiento}">${element.procedimiento}</option>`;
    });
    $("#procedimiento-otros").html(html);
    $("#pieza-otros").val("");
    const idprocedimiento = data.length > 0 ? data[0].idprocedimiento : null;
    if (idprocedimiento) {
      //console.log("El primer valor es: firstValue "+idprocedimiento);
      (async()=>{
        try {
          const data = await getOne(idprocedimiento, "procedimientos", "getOne");
          //console.log(data);
          $("#monto-pagar-otros").val(data.precio);
        } catch (error) {
          console.log("ERror al obtener el precio del procedimiento" + error);
        }
      })()
    }
  } catch (error) {
    console.log("Error en obtener Procedimientos.." + error);
  }
  $(document).on("input change", "#procedimiento-otros", function () {
    let idprocedimiento = $(this).val();
    //console.log(idprocedimiento);
    (async()=>{
      try {
        const data = await getOne(idprocedimiento, "procedimientos", "getOne");
        //console.log(data);
        $("#monto-pagar-otros").val(data.precio);
      } catch (error) {
        console.log("ERror al obtener el precio del procedimiento" + error);
      }
    })()
  });
  let fecha = new Date().toISOString().slice(0, 10);
  $("#mostrar-fecha-otros").html(fecha);
}
async function continuarPagoOtros() {
  try {
    let timeout;
    $(document).on("input change","#importe-tabla-otros, #pieza-tabla-otros, #doctor-otros",function () {
        console.log("cambios en inputs ed ortodoncia");
        numberFloat(".input-importe");
        clearTimeout(timeout);
        let trfila = $(this).closest("tr");
        let importe = trfila.find("#importe-tabla-otros");
        let pieza = trfila.find("#pieza-tabla-otros");
        let doctor = trfila.find("#doctor-otros");
        let idpago = trfila.data("idpago");
        let idpagodetalle = trfila.data("idpagodetalle");
        let total = trfila.data("total");
        let deuda = trfila.data("deuda");
        let monto = trfila.data("monto");
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
            ObtenerPresupuestoOtros();
            getDoctores();
          }
        }, 2000); // Espera de 2 segundo
      }
    );
  } catch (error) {
    console.log(
      "ERror al hacer un nuevo pago de un procedimiento ya creado" + error
    );
  }
}


// PRESUPUESTO OTROS END /*/*/*/*/*/*/*/*/*/*/*/*/**/*/*/*/*/*/*/*/*/**/*/*/*/*/*/*/*/*/