function dni() {
  let timeout; // Variable para controlar el tiempo de espera

  $("#dni").on("keyup", function () {
    clearTimeout(timeout); // Cancela el timeout anterior si el usuario sigue escribiendo
    let dni = $(this).val().trim(); // Obtener el DNI sin espacios extra

    if (dni.length === 8) {
      timeout = setTimeout(() => {
        $.ajax({
          url: `${url}/services/dni`,
          type: "POST",
          data: { dni: dni },
          dataType: "json", // Indicar que la respuesta es JSON
          success: function (data) {
            if (data === 1) {
              //alert("El DNI debe tener 8 dígitos");
            } else if (data.nombres && data.apellidoPaterno && data.apellidoMaterno) {
              $("#nombre").val(data.nombres);
              $("#apellido").val(`${data.apellidoPaterno} ${data.apellidoMaterno}`);
              $("#nombrecompleto").val(`${data.nombres} ${data.apellidoPaterno} ${data.apellidoMaterno}`);
            } else {
              console.warn("Datos incompletos en la respuesta de la API");
            }
          },
          error: function (xhr, status, error) {
            console.error(`Error en la API: ${error}`);
            //alert("No se pudo obtener la información del DNI. Inténtalo más tarde.");
          },
        });
      }, 500); // Reducir el tiempo de espera a 500ms
    }
  });
}
