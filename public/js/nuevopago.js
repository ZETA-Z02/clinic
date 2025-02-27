$(document).ready(function () {
  numberFloat("#input-pago");
  NuevoPago();
  nuevoPago();
  calcularPago();
  boleta();
  modalNuevoCliente();
  getProcedimientos();
  nuevoProcedimiento()

  $("#btn-nuevopago-volver").attr(
    "href",
    `${url}/clientes/`
  );
});

// MODAL NUEVO PAGO -/--/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/
function NuevoPago() {
  id = $("#id-nuevopago-cliente").val();
  (async () => {
    try {
      const data = await getOne(id, "clientes", "getProcedimientosOne");
      const cliente = await getOne(id, "clientes", "getCliente");
      //console.log(data);
      let html = "";
      data.forEach((element) => {
        html += `<option value="${element.idpago}" id-data="${element.idprocedimiento}">${element.procedimiento}</option>`;
      });
      console.log(cliente);
      $("#cliente-nombre").html(cliente.nombre + " " + cliente.apellido);
      $("#tratamiento").html(html);
      $("#tratamiento").trigger("updated");
    } catch (error) {
      console.error("ERROR", error);
    }
  })();
  // SELECCIONAR TRATAMIENTO
  $("#tratamiento").on("updated", function () {
    const options = $("#tratamiento option");
    const idpago = options.first().val();
    const idprocedimiento = options.first().attr("id-data");
    //console.log(idpago, idprocedimiento);
    $("#idprocedimiento").val(idprocedimiento);
    tablaNuevoPago(idpago, idprocedimiento);
    $("#tratamiento").change(function () {
      $("#input-pago").val("");
      $("#mostrar-deuda").html("0");
      $("#input-concepto").val("");
      const options = $("#tratamiento option:selected");
      const idpago = options.val();
      const idprocedimiento = options.attr("id-data");
      // se inserta otra vez el id del cliente cada vez que cambia el select, ya que el formulario se resetea cuando se ingresa un neuvo registro
      $("#id-nuevopago-cliente").val(id);
      //console.log(idpago, idprocedimiento);
      $("#idprocedimiento").val(idprocedimiento);
      tablaNuevoPago(idpago, idprocedimiento);
    });
  });
}
// trae los datos del modal nuevo pago
function tablaNuevoPago(idpago = null, idprocedimiento = null) {
  if (idpago == null && idprocedimiento == null) {
    idpago = $("#tratamiento").val();
    idprocedimiento = $("#idprocedimiento").val();
  }
  (async () => {
    try {
      const data = await getOne(idpago, "clientes", "getPagos");
      let html = "";
      const datapago = await getOne(
        { idpago, idprocedimiento },
        "clientes",
        "getPago"
      );
      $("#mostrar-totalpagar").val(datapago.total_pagar);
      $("#mostrar-pagos").val(datapago.monto_pagado);
      $("#mostrar-totaldeuda").val(datapago.saldo_pendiente);
      if (datapago.saldo_pendiente == 0) {
        $("#nuevopago-footer").hide();
      }
      if (datapago.saldo_pendiente > 0) {
        $("#nuevopago-footer").show();
      }
      // console.log(data);
      // console.log(datapago);
      let total = parseFloat(datapago.total_pagar);
      let montoacumulado = 0;
      data.forEach((pago) => {
        html += `
                      <tr>
                          <td>${pago.fecha}</td>
                          <td>${total}</td>
                          <td>${pago.monto}</td>
                          <td>${(total - pago.monto).toFixed(2)}</td>
                          <td>${pago.concepto}</td>
                      </tr>
                  `;
        //<td>${parseInt(pago.monto)}</td>
        montoacumulado += parseFloat(pago.monto);
        total = datapago.total_pagar - montoacumulado;
        $("#mostrar-total").html(total);
      });
      $("#nuevopago-data").html(html);
    } catch (error) {
      console.log("ERROR", error);
    }
  })();
}
function calcularPago() {
  $("#input-pago").keyup(function () {
    let total = parseFloat($("#mostrar-total").html());
    let pago = parseFloat($(this).val());
    let deuda = total - pago;
    $("#mostrar-deuda").html(deuda.toFixed(2));
  });
}
function nuevoPago() {
  $("#form-nuevo-pago").submit(function (e) {
    e.preventDefault();
    let monto = parseFloat($("#input-pago").val());
    let deuda = parseFloat($("#mostrar-totaldeuda").val());
    if (monto > deuda) {
      //console.log("Asi no se puede bro, esta webada esta mal");
      modalError();
      $("#input-pago").val("");
      $("#input-concepto").val("");
    } else {
      let data = $(this).serialize();
      insert(data, "clientes", "nuevoPago");
      let select = $("#tratamiento").val();
      e.target.reset();
      $("#tratamiento").val(select);
      tablaNuevoPago();
    }
  });
}
function boleta() {
  $("#btn-boleta-todo").click(function () {
    let id = $("#id-nuevopago-cliente").val();
    console.log(id);
    window.open(`${url}/clientes/boletaPagos/${id}`);
  });
}

// NUEVO PROCEDIMIENTO DE UN MISMO CLIENTE
function modalNuevoCliente() {
  $("#btn-nuevotratamiento").click(function () {
    $(".nuevocliente").css("display", "block");
    $(".overlay").css("display", "block");
  });
  $("#btn-cerrar-nuevocliente").click(function () {
    $(".nuevocliente").css("display", "none");
    $(".overlay").css("display", "none");
  });
}
function getProcedimientos() {
  (async () => {
    try {
      const data = await get("clientes", "getProcedimientos");
      let html = "";
      //console.log(data);
      data.forEach((element) => {
        html += `<option value="${element.id}">${element.procedimiento}</option>`;
      });
      $("#procedimiento").html(html);
    } catch (error) {
      console.error("ERROR", error);
    }
  })();
}
function nuevoProcedimiento(){
  $("#form-nuevocliente").submit(function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    insert(data, "clientes", "nuevoCliente");
    $(".nuevocliente").css("display", "none");
    $(".overlay").css("display", "none");
    e.target.reset();
    NuevoPago()
  });
}
// MODAL NUEVO PAGO END -/--/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/
