function dni() {
  $("#dni").on("keyup", function () {
    var dni = $("#dni").val();
    //console.log(dni.length);
    if (dni.length == 8) {
      $.ajax({
        url: `http://${host}/${proyect}/services/dni`,
        type: "POST",
        data: { dni: dni },
        success: function (response) {
          let data = JSON.parse(response);
          if (data == 1) {
            alert("El DNI debe tener 8 dígitos");
          } else {
            //console.log(data);
            $("#nombre").val(data.nombres);
            $("#apellido").val(
              data.apellidoPaterno + " " + data.apellidoMaterno
            );
          }
        },
        error: function (xhr, status, error) {
          console.log(error + "->No se pudo hacer la solicitud a la API");
        },
      });
    } else {
      console.log("no hay dni");
    }
  });
}
