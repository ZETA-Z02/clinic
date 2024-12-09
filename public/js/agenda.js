// CALENDAR --------------------------------
$(document).ready(function () {
  //Funcionaes
  sugerencias();
  tags();

  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    selectable: true,
    initialView: "dayGridMonth",
    height: "100%",
    headerToolbar: {
      center: "dayGridMonth,timeGridWeek",
      left: "prev,next today",
      right: "title",
    },
    editable: true,
    locale: "es",
    eventSources: [
      {
        url: `http://${host}/${proyect}/agenda/get`,
        method: "POST",
      },
    ],
    eventTimeFormat: {
      hour: "numeric",
      minute: "2-digit",
      meridiem: true,
      hour12: true,
    }
    // eventContent: function (info) {
    //   // Crear elementos para la estructura visual
    //   let dot = document.createElement("span");
    //   dot.classList.add("fc-dot");
    //   dot.style.backgroundColor = info.event.backgroundColor;
    //   let title = document.createElement("span");
    //   title.textContent = info.event.title;
    //   let time = document.createElement("span");
    //   time.textContent = info.timeText; // Hora del evento
    //   // Contenedor principal
    //   let container = document.createElement("div");
    //   container.classList.add("fc-event-custom");
    //   container.append(dot, title, time);
    //   return { domNodes: [container] }; // Retorna el nodo DOM personalizado
    // },
  });
  calendar.render();
  SeleccionFecha(calendar);
  cancelarCita(calendar);
  GuardarCita(calendar);
});
//console.log('fecha: '+info.dateStr);
// console.log('fecha: '+info.date);
// console.log('todo el dia '+info.allDay);
// console.log('day El '+info.dayEl);
// console.log('Cordinales: '+info.jsEvent.pageX+','+info.jsEvent.pageY);
// console.log('Current view type: '+info.view.type);
// console.log('Current view: '+info.view);
// console.log('Current view title: '+info.view.title);
// console.log('Current view activeStart: '+info.view.activeStart);
// console.log('Current view activeEnd: '+info.view.activeEnd);
// console.log('Current view currentStart: '+info.view.currentStart);
// console.log('Current view currentEnd: '+info.view.currentEnd);

function SeleccionFecha(calendar) {
  calendar.on("dateClick", function (info) {
    let date = info.dateStr;
    // console.log(date);
    $("#fecha-inicio,#fecha-fin").val(date);
    mostrarFormulario();
    // let fecha = date.toISOString().split("T")[0];
    // const events = calendar.getEvents();
    calendar.render();
  });
}
function mostrarFormulario() {
  // Mostrar el formulario y ajustar tamaños
  $("#calendar-forms").css("display", "block");
  $("#calendario").addClass("large-9");
  $("#calendar-forms").addClass("large-3");
}
function cancelarCita(calendar) {
  $("#btn-cerrar-agenda").on("click", function () {
    $("#calendar-forms").css("display", "none");
    $("#calendar-forms").removeClass("large-3");
    $("#calendario").removeClass("large-9");
    $("#calendario-formulario")[0].reset();
    calendar.render();
  });
}

// SUGERENCIAS DE CLIENTES
function sugerencias() {
  let clienteInput = $("#cliente");
  let sugerenciasBox = $("#cliente-sugerencias");
  let clienteId = $("#cliente_id");
  clienteInput.on("input", function () {
    let query = $(this).val();
    // if(query.length >= 2){// Va buscar a partir de 2 letras
    if (true) {
      // Va buscar a partir de 2 letras
      (async () => {
        try {
          const data = await getOne(
            { query: query },
            "agenda",
            "searchCustomers"
          );
          // console.log(data);
          sugerenciasBox.empty();
          data.forEach((element) => {
            sugerenciasBox.append(
              `<li data-id="${element.id}">${element.nombre} ${element.apellido}</li>`
            );
          });
          sugerenciasBox.show();
        } catch (error) {
          console.log("Error al traer clientes", error);
        }
      })();
    } else {
      sugerenciasBox.empty().hide();
    }
  });
  sugerenciasBox.on("click", "li", function () {
    let nombre = $(this).text();
    let id = $(this).attr("data-id"); // ESTOS HACEN LO MISMO
    // let id = $(this).data("id"); // ESTOS HACEN LO MISMO
    clienteInput.val(nombre);
    clienteId.val(id);
    sugerenciasBox.empty().hide();
  });
  $(document).on("click", function (e) {
    if (!$(e.target).closest("#cliente,#cliente-sugerencias").length) {
      sugerenciasBox.hide();
    }
  });
}
function GuardarCita(calendar) {
  $("#calendario-formulario").submit(function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    insert(data, "agenda", "guardarCita");
    e.target.reset();
    calendar.refetchEvents();
  });
}

function tags() {
  let tags = $("#etiqueta");
  var tag = tags.val();
  if (tag == "verde") {
    $("#etiqueta-icon").addClass("verde");
  }
  tags.change(function () {
    tag = $(this).val();
    $("#etiqueta-icon").removeClass("verde rojo azul");
    if (tag == "verde") {
      $("#etiqueta-icon").addClass("verde");
    } else if (tag == "rojo") {
      $("#etiqueta-icon").addClass("rojo");
    } else if (tag == "azul") {
      $("#etiqueta-icon").addClass("azul");
    }
  });
}
function infoCita(calendar){
  calendar.on("eventClick",function(info){
    let cita = info.event;
    let id = cita.id;
    console.log(id);
  });
}
