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
                        <td><a class="button btn-success" href='${url}/pagos/render/${element.id}'>Nuevo Pago</a></td>
                        <td>${element.nombre}</td>
                        <td>${element.apellido}</td>
                        <td>${element.dni}</td>
                        <td>${element.telefono}</td>
                        <td><a class="button btn-primary" id-data='${element.id}' href='${url}/clientes/citas/${element.id}'>Citas</a></td>
                        <td><a href='${url}/clientes/detalles/${element.id}' class="button btn-info">Detalles</a></td>
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
function boleta(){
  $("#btn-boleta-todo").click(function(){
    let id = $("#id-nuevopago-cliente").val();
    console.log(id)
    window.open(`${url}/clientes/boletaPagos/${id}`);
  });
}

