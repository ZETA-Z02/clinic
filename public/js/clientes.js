$(document).ready(function () {
  //VALIDAR INPUTS
  numberLeght("#telefono", 9);
  numberLeght("#dni", 8);
  numberFloat("#totalpagar,#primerpago");
  
  //BUSCADOR
  search("search-clientes", "table-clientes-data");
  //VALIDAR INPUTS END
  dni();
  // MODAL CLIENTES
  getclientes();
  modalNuevoCliente();
  nuevocliente();
  getProcedimientos();
  // MODAL CLIENTES END
  /* MODAL NUEVO PAGO */
  // modalNuevoPago();
  // calcularPago();
  // nuevoPago();
  // boleta()
  //verificarPago();
  /* MODAL NUEVO PAGO END*/
});
function getclientes() {
  (async () => {
    try {
      const data = await get("clientes", "get");
      let html = "";
      //console.log(data);
      data.forEach((element) => {
        html += `                    
                    <tr>
                        <td><a class="button btn-success" href='http://${host}/${proyect}/clientes/rendernuevopago/${element.id}'>Nuevo Pago</a></td>
                        <td>${element.nombre}</td>
                        <td>${element.apellido}</td>
                        <td>${element.dni}</td>
                        <td>${element.telefono}</td>
                        <td><button class="button btn-primary" id-data='${element.id}'>Citas</button></td>
                        <td><a href='http://${host}/${proyect}/clientes/detalles/${element.id}' class="button btn-info">Detalles</a></td>
                    </tr>
                        `;
      });
      $("#clientes-data").html(html);
      initPaginador(5, "clientes-data", "paginador-clientes");
    } catch (error) {
      console.log("ERROR EN GET", error);
    }
  })();
}
// MODAL NUEVO CLIENTE --------------*-*-*-*-*-*-*-*-*-*-*-
function modalNuevoCliente() {
  $("#btn-nuevocliente").click(function () {
    $(".nuevocliente").css("display", "block");
    $(".overlay").css("display", "block");
  });
  $("#btn-cerrar-nuevocliente").click(function () {
    $(".nuevocliente").css("display", "none");
    $(".overlay").css("display", "none");
  });
}
function nuevocliente() {
  $("#form-nuevocliente").submit(function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    insert(data, "clientes", "nuevoCliente");
    getclientes();
    $(".nuevocliente").css("display", "none");
    $(".overlay").css("display", "none");
    e.target.reset();
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
// MODAL NUEVO CLIENTE END --------------*-*-*-*-*-*-*-*-*-*-*-



// // MODAL NUEVO PAGO -/--/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/
// function modalNuevoPago() {
//   var id = '';
//   $("#nuevopago-view").hide();
//   // ABRIR MODAL Y MOSTRAR LOS DATOS NECESARIOS
//   $("#clientes-main").on("click", "#btn-nuevopago", function () {
//     // Limpiar los inputs
//     $("#input-pago").val('');
//     $("#input-concepto").val('');
//     // MOSTRAR Y OCULTAR MODAL
//     $("#nuevopago-view").show();
//     $("#clientes-main").hide();
//     //id del cliente
//     id = $(this).attr("id-data");
//     $("#id-nuevopago-cliente").val(id);
//     (async () => {
//       try {
//         const data = await getOne(id, "clientes", "getProcedimientosOne");
//         const cliente = await getOne(id, "clientes", "getCliente");
//         //console.log(data);
//         let html = "";
//         data.forEach((element) => {
//           html += `<option value="${element.idpago}" id-data="${element.idprocedimiento}">${element.procedimiento}</option>`;
//         });
//         console.log(cliente);
//         $("#cliente-nombre").html(cliente.nombre + ' '+ cliente.apellido);
//         $("#tratamiento").html(html);
//         $("#tratamiento").trigger("updated");
//       } catch (error) {
//         console.error("ERROR", error);
//       }
//     })();
//   });
//   // CERRAR MODAL
//   $("#btn-nuevopago-volver").click(function () {
//     $("#nuevopago-view").hide();
//     $("#clientes-main").show();
//     getclientes();
//   });
//   // SELECCIONAR TRATAMIENTO
//   $("#tratamiento").on("updated", function () {
//     const options = $("#tratamiento option");
//     const idpago = options.first().val();
//     const idprocedimiento = options.first().attr("id-data");
//     //console.log(idpago, idprocedimiento);
//     $("#idprocedimiento").val(idprocedimiento);
//     tablaNuevoPago(idpago,idprocedimiento)
//     $("#tratamiento").change(function () {
//         const options = $("#tratamiento option:selected");
//         const idpago = options.val();
//         const idprocedimiento = options.attr("id-data");
//         // se inserta otra vez el id del cliente cada vez que cambia el select, ya que el formulario se resetea cuando se ingresa un neuvo registro
//         $("#id-nuevopago-cliente").val(id);
//         //console.log(idpago, idprocedimiento);
//         $("#idprocedimiento").val(idprocedimiento);
//         tablaNuevoPago(idpago,idprocedimiento)
//     });
//   });
// }
// // trae los datos del modal nuevo pago
// function tablaNuevoPago(idpago=null, idprocedimiento=null) {
//   if(idpago == null && idprocedimiento ==null){
//     idpago = $("#tratamiento").val();
//     idprocedimiento = $("#idprocedimiento").val();
//   }
//   (async () => {
//     try {
//       const data = await getOne(idpago,"clientes","getPagos");
//       let html = "";
//       const datapago = await getOne({idpago,idprocedimiento}, "clientes", "getPago");
//       $("#mostrar-totalpagar").val(datapago.total_pagar);
//       $("#mostrar-pagos").val(datapago.monto_pagado);
//       $("#mostrar-totaldeuda").val(datapago.saldo_pendiente);
//       if(datapago.saldo_pendiente == 0){
//         $("#nuevopago-footer").hide();
//       }
//       if(datapago.saldo_pendiente > 0){
//         $("#nuevopago-footer").show(); 
//       }
//       // console.log(data);
//       // console.log(datapago);
//       let total = parseFloat(datapago.total_pagar);
//       let montoacumulado = 0;
//       data.forEach((pago) => {
//         html += `
//                     <tr>
//                         <td>${pago.fecha}</td>
//                         <td>${total}</td>
//                         <td>${pago.monto}</td>
//                         <td>${(total-pago.monto).toFixed(2)}</td>
//                         <td>${pago.concepto}</td>
//                     </tr>
//                 `;
//                 //<td>${parseInt(pago.monto)}</td>
//         montoacumulado += parseFloat(pago.monto);
//         total = datapago.total_pagar - montoacumulado;
//         $("#mostrar-total").html(total);
//       });
//       $("#nuevopago-data").html(html);
//     } catch (error) {
//       console.log("ERROR", error);
//     }
//   })();
// }
// function calcularPago(){
//   $("#input-pago").keyup(function () {
//     let total = parseFloat($("#mostrar-total").html());
//     let pago = parseFloat($(this).val());
//     let deuda = total - pago;
//     $("#mostrar-deuda").html(deuda.toFixed(2));
//   })
// }
// function nuevoPago(){
//   $("#form-nuevo-pago").submit(function (e) {
//     e.preventDefault();
//     let monto = parseFloat($("#input-pago").val());
//     let deuda = parseFloat($("#mostrar-totaldeuda").val());
//     if(monto > deuda){
//       //console.log("Asi no se puede bro, esta webada esta mal");
//       modalError();
//       $("#input-pago").val('');
//       $("#input-concepto").val('');
//     }else{
//       let data = $(this).serialize();
//       insert(data, "clientes", "nuevoPago");
//       e.target.reset();
//       tablaNuevoPago();
//     }
//   });
// }
// function boleta(){
//   $("#btn-boleta-todo").click(function(){
//     let id = $("#id-nuevopago-cliente").val();
//     console.log(id)
//     window.open(`http://${host}/${proyect}/clientes/boletaPagos/${id}`);
//   });
// }
// MODAL NUEVO PAGO END -/--/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/
