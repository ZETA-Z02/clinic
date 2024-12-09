$(document).ready(function () {
  getCards();
  chartBarras();
  chartLineas();
  elegirfecha();
});
function getCards() {
  (async () => {
    try {
      const data = await get("estadisticas", "get");
      //console.log(data);
      $("#card-clientes").html(data.clientes);
      $("#card-citas").html(data.citas);
      $("#card-recaudado").html(data.dinero);
    } catch (error) {
      console.log("ERROR en cards", error);
    }
  })();
}
var BarrasInstance;
var linesInstance;
function chartBarras(fecha=new Date().getFullYear()) {
  const ctx = document.getElementById("chart-barras").getContext("2d");
  // Si ya existe una instancia previa del gráfico, destrúyela
  if (BarrasInstance) {
    BarrasInstance.destroy();
  }
  const setdata = [];
  // Inicializa los datos
  // Obtén la fecha seleccionada
  //const fecha = $("#fecha-year").val();
  (async () => {
    try {
      const data = await getOne({ fecha: fecha }, "estadisticas", "getBarras");
      setdata.push(
        data.enero,
        data.febrero,
        data.marzo,
        data.abril,
        data.mayo,
        data.junio,
        data.julio,
        data.agosto,
        data.septiembre,
        data.octubre,
        data.noviembre,
        data.diciembre
      );
      // Crea una nueva instancia del gráfico
      BarrasInstance = new Chart(ctx, {
        type: "bar",
        data: {
          labels: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
          ],
          datasets: [{ label: "# de clientes", data: setdata, borderWidth: 1 }],
        },
        options: { scales: { y: { beginAtZero: true } } },
      });
    } catch (error) {
      console.error("Error al obtener los datos:", error);
    }
  })();
}
// Evento para detectar cambios en el año seleccionado
$(document).on("change", "#fecha-year", function () {
    let fecha = $(this).val();
  chartBarras(fecha);
  chartLineas(fecha);
  // Llama a la función cada vez que cambie el año
});
function chartLineas(fecha=new Date().getFullYear()) {
    const ctx = document.getElementById("chart-line").getContext("2d");
    // Si ya existe una instancia previa del gráfico, destrúyela
    if (linesInstance) {
      linesInstance.destroy();
    }
  var setdata = [];
  (async () => {
    try {
      const data = await getOne({ fecha: fecha }, "estadisticas", "getLine");
      //console.log(data);
      setdata.push(
        data.enero,
        data.febrero,
        data.marzo,
        data.abril,
        data.mayo,
        data.junio,
        data.julio,
        data.agosto,
        data.septiembre,
        data.octubre,
        data.noviembre,
        data.diciembre
      );
    } catch (error) {
      console.log("error en line", error);
    }
  })();
  linesInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      datasets: [
        {
          label: "recaudado",
          data: setdata,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
function elegirfecha() {
  let actual = new Date();
  let anioactual = actual.getFullYear();
  anio = anioactual - 2;
  let html = "";
  for (let i = 0; i < 5; i++) {
    if (anioactual == anio + i) {
      html += `<option value="${anio + i}" selected>${anio + i}</option>`;
      continue;
    }
    html += `<option value="${anio + i}">${anio + i}</option>`;
  }
  $("#fecha-year").html(html);
}
