// CALENDAR --------------------------------
$(document).ready(function () {
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
    // editable: true,
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
    },
    dayMaxEventRows: true,
    moreLinkContent: masNumInfoCita,
    moreLinkClick: masInfoCitas,
    
  });
  calendar.render();
  SeleccionFecha(calendar);
  cancelarCita(calendar);
  GuardarCita(calendar);
  infoCita(calendar);
  //Funcionaes
  sugerencias();
  tags();
  eliminarCita(calendar);
  cerrarCita(calendar);
  /*Modal todas las citas */
  CerrarModal()
  infoCitaModalMore(calendar);
});

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
  //$("#calendar-forms").css("display", "block");
  abrirModal("calendar-forms");
  tags()
}
function cancelarCita(calendar) {
  $("#btn-cerrar-agenda").on("click", function () {
    $("#calendar-forms").css("display", "none");
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
    tags()
    // Cerrar el formulario
    $("#calendar-forms").css("display", "none");
    $("#calendar-forms").removeClass("large-3");
    $("#calendario").removeClass("large-9");
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
function infoCita(calendar) {
  calendar.on("eventClick", function (info) {
    let cita = info.event;
    let id = cita.id;
    //console.log(id);
    (async () => {
      try {
        const data = await getOne(id, "agenda", "infoCita");
        //console.log(data);
        let nombres = data.nombre + " " + data.apellido;
        $("#cita-title").html(data.titulo);
        $("#cita-nombre").html(nombres);
        $("#cita-etiqueta").html(data.etiqueta);
        $("#cita-fecha-inicio").html(data.fecha_ini);
        $("#cita-hora-inicio").html(convertirHora24a12(data.hora_ini));
        $("#cita-fecha-fin").html(data.fecha_fin);
        $("#cita-hora-fin").html(convertirHora24a12(data.hora_fin));
        $("#cita-mensaje").html(data.mensaje);
        $("#btn-eliminar-cita").attr("id-data", data.idcita);
        colorInfo(data.etiqueta);
        mostrarCita(calendar);
      } catch (error) {
        console.error("ERROR", error);
      }
    })();
  });
}
function eliminarCita(calendar) {
  $("#info-cita").on("click", "#btn-eliminar-cita", function () {
    let id = $(this).attr("id-data");
    console.log(id);
    delet(id, "agenda", "delete");
    calendar.refetchEvents();
  });
}

function cerrarCita(calendar) {
  $("#btn-cerrar-info-cita").click(function () {
    $("#info-citas").css("display", "none");
    calendar.render();
  });
}
function mostrarCita(calendar) {
  // Mostrar el modal
  //$("#info-citas").css("display", "block");
  abrirModal("info-citas");
  calendar.render();
}

function colorInfo(color) {
  if (color == "verde") {
    $("#cita-title").addClass("green");
    $("#cita-flecha-icon").addClass("verde");
    $("#cita-flecha-icon,#cita-title").removeClass("rojo azul");
  } else if (color == "rojo") {
    $("#cita-flecha-icon,#cita-title").addClass("rojo");
    $("#cita-flecha-icon,#cita-title").removeClass("green azul verde");
  } else if (color == "azul") {
    $("#cita-flecha-icon,#cita-title").addClass("azul");
    $("#cita-flecha-icon,#cita-title").removeClass("rojo green verde");
  }
}
function convertirHora24a12(hora24) {
  // Separar las horas, minutos y segundos
  let [hora, minutos] = hora24.split(":").map(Number);
  // Determinar si es AM o PM
  let periodo = hora >= 12 ? "PM" : "AM";
  // Convertir la hora a formato de 12 horas
  hora = hora % 12 || 12;
  // Si la hora es 0 (medianoche), mostrar como 12
  // Devolver el formato final
  return `${hora}:${minutos.toString().padStart(2, "0")} ${periodo}`;
}
/* Configuracion de calendario -> mas informacion de la cita*/
function masNumInfoCita(args) {
  // Personalizar el contenido del "más" link
  return `+${args.num}`;
}
function masInfoCitas(info) {
  // Mostrar un modal con todas las citas del día al hacer clic en "más"
  console.log(info);
  const eventos = info.allSegs.map((seg) => seg.event); // Todas las citas de ese día
  let html = '';
  eventos.forEach(event => {
    let date = event.start.toLocaleDateString("es-ES", { 
      month: "long",
      day: "numeric"
    });
    $("#modal-title").html(date)
    let fecha = event.start.toLocaleDateString("es-ES", { 
      weekday: "long",
      year: "numeric", 
      month: "long",
      day: "numeric" 
    });
    let hora = event.start.toLocaleDateString("es-ES", { 
      hour: "2-digit",
      minute: "2-digit",
      hour12: true
    });
    hora = hora.split(",")[1];
    html += 
    `<div class="box--cita" data-id="${event.id}" id="modal-info-cita">
			 <span class="box--cita--title lead">${fecha}, ${hora}</span>
			 <p>${event.title}</p>
		</div>`;
  });
  //document.getElementById("modal-content").innerHTML = modalContent;
  $("#modal-content").html(html);
  abrirModal("modal");
  return false;
}
function infoCitaModalMore(calendar){
  $(document).on("click", "#modal-info-cita", function(){
    let id = $(this).attr("data-id");
    (async () => {
      try {
        const data = await getOne(id, "agenda", "infoCita");
        //console.log(data);
        let nombres = data.nombre + " " + data.apellido;
        $("#cita-title").html(data.titulo);
        $("#cita-nombre").html(nombres);
        $("#cita-etiqueta").html(data.etiqueta);
        $("#cita-fecha-inicio").html(data.fecha_ini);
        $("#cita-hora-inicio").html(convertirHora24a12(data.hora_ini));
        $("#cita-fecha-fin").html(data.fecha_fin);
        $("#cita-hora-fin").html(convertirHora24a12(data.hora_fin));
        $("#cita-mensaje").html(data.mensaje);
        $("#btn-eliminar-cita").attr("id-data", data.idcita);
        colorInfo(data.etiqueta);
        mostrarCita(calendar);
      } catch (error) {
        console.error("ERROR", error);
      }
    })();
  })
}
function abrirModal(modalId){
  $(".modales").hide();
  $(`#${modalId}`).show();
}
function CerrarModal(){
  $("#btn-cerrar-modal").click(function(){
    $('#modal').hide();
  })
}