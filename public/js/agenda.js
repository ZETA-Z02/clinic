// CALENDAR --------------------------------
$(document).ready(function () {
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    selectable: true,
    editable: true,
    initialView: "dayGridMonth",
    height: "100%",
    headerToolbar: {
      center: "dayGridMonth,timeGridWeek",
      left: "prev,next today",
      right: "title",
    },
    locale: "es",
    eventSources: [
      {
        url: `${url}/agenda/get`,
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
  CerrarModal();
  infoCitaModalMore(calendar);
  /*formulario de citas, obteniendo datos para los selects */
  getPersonal();
  getProcedimientos();
  //Duplicar cita
  arrastrarCita(calendar);

  // AJUSTAR HORA
  ajustarHora();

  // EDITAR CITA
  buttonsEdit();
  editarCita(calendar);
});

function SeleccionFecha(calendar) {
  calendar.on("dateClick", function (info) {
    let date = info.dateStr;
    //console.log(date);
    $("#fecha-inicio,#fecha-fin").val(date);
    cargarHorasDisponibles(date);
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
          const data = await getOne({ query: query },"agenda","searchCustomers");
          // console.log(data);
          sugerenciasBox.empty();
          data.forEach((element) => {
            sugerenciasBox.append(
              `<li data-id="${element.id}">${element.nombre}</li>`
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
    // Obtener el `data-id` de la opción seleccionada
    let idetiqueta = $("#personal-procedimiento option:selected").data("id");
    // Agregar el idetiqueta a los datos serializados
    data += `&idetiqueta=${idetiqueta}`;
    insert(data, "agenda", "guardarCita");
    e.target.reset();
    $("#cliente_id").val('');
    calendar.refetchEvents();
    calendar.render();
    tags()
    // Cerrar el formulario
    $("#calendar-forms").css("display", "none");
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
    let fecha = cita.extendedProps.fecha_ini;
    let hora_ini = cita.extendedProps.hora_ini;
    let hora_fin = cita.extendedProps.hora_fin;
    console.log(hora_ini);
    //console.log(id);
    (async () => {
      try {
        const data = await getOne(id, "agenda", "infoCita");
        //console.log(data);
        let nombres = data.nombre + " " + data.apellido;
        $("#cita-title").html(data.titulo);
        $("#cita-nombre").html(nombres);
        $("#cita-fecha-inicio").html(data.fecha_ini);
        $("#cita-hora-inicio").html(convertirHora24a12(data.hora_ini));
        $("#cita-fecha-fin").html(data.fecha_fin);
        $("#cita-hora-fin").html(convertirHora24a12(data.hora_fin));
        $("#cita-mensaje").html(data.mensaje);
        $("#btn-eliminar-cita").attr("id-data", data.idcita);
        $("#info-idcita").val(data.idcita);
        colorInfo(data.color);
        $("#info-titleupdate").val(data.titulo);
        mostrarCita(calendar);
        cargarHorasDisponibles(fecha);
      } catch (error) {
        console.error("ERROR", error);
      }
    })();
  });
}
// EDITAR CITA
function buttonsEdit(){
  $(".info-hora,.info-title,#btn-enviaredit-cita").hide();
  $("#btn-editar-cita").on('click',function(){
    $(".info-hora,.info-title,#btn-enviaredit-cita").show();
    $("#btn-editar-cita").hide();
  })
}
function editarCita(calendar){
  //$("#btn-enviaredit-cita").on('click',function(){
    $("#btn-enviaredit-cita").click(function(){
    let idcita = $("#info-idcita").val();
    let titulo = $("#info-titleupdate").val();
    let horaini = $("#hora-update").val();
    let horafin = $("#info-hora-fin").val();    
    const data = {
      idcita: idcita,
      titulo: titulo,
      horaini: horaini,
      horafin: horafin
    }
    insert(data,'agenda','editarCita');
    calendar.render();
    calendar.refetchEvents();
  });
}

function eliminarCita(calendar) {
  $("#info-citas").on("click", "#btn-eliminar-cita", function () {
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
  $("#cita-title").css("color",color);
  $("#cita-flecha-icon").css("color",color);
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
// Mostrar un modal con todas las citas del día al hacer clic en "más"
function masInfoCitas(info) {
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
        colorInfo(data.color);
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

function getPersonal(){
  (async () => {
    try{
      const data = await get('agenda','getPersonal');
      let html = '';
      data.forEach(element => {
        html += `<option value="${element.iniciales}" data-id="${element.id}">${element.iniciales}-${element.nombre}</option>`;
      });
      $("#personal-procedimiento,#personal-creador").html(html);
    }catch(error){
      console.log("ERROR al obtener personal"+error);
    }
  })();
}

function getProcedimientos(){
  (async () => {
    try{
      const data = await get('agenda','getProcedimientos');
      //console.log(data);
      let html = '';
      data.forEach(element => {
        html += `<option value="${element.iniciales}">${element.iniciales}-${element.procedimiento}</option>`;
      });
      $("#procedimientos").html(html);
    }catch(error){
      console.log("ERROR al obtener personal"+error);
    }
  })();  
}

async function arrastrarCita(calendar){
  calendar.on("eventDrop", function (info) {
    // Confirmar si se desea duplicar
    if (confirm("¿Deseas duplicar esta cita en la nueva fecha?")) {
      const originalEvent = info.oldEvent; // Evento original
      const newStartDate = info.event.start; // Nueva fecha de inicio
  
      // Crear un objeto con los datos para duplicar
      const newEventData = {
        idcliente: originalEvent.extendedProps.idcliente, // Datos del cliente
        idetiqueta: originalEvent.extendedProps.idetiqueta, // Procedimiento
        fecha_inicio: newStartDate.toISOString().split("T")[0], // Nueva fecha
        fecha_fin: newStartDate.toISOString().split("T")[0], // fecha fin
        hora_inicio: originalEvent.extendedProps.hora_ini,
        hora_fin: originalEvent.extendedProps.hora_fin,
        titulo: originalEvent.title, // Título
      };
  
      // Enviar los datos al servidor para guardar la nueva cita
        try {
          console.log(newEventData);
          insert(newEventData, "agenda", "duplicarCita");
          calendar.refetchEvents(); // Recargar eventos en el calendario
          alert("La cita ha sido duplicada exitosamente.");
        } catch (error) {
          console.error("Error al duplicar la cita:", error);
          alert("Hubo un error al duplicar la cita.");
        }
    } else {
      // Si no se confirma, restaurar la posición original del evento
      info.revert();
    }
  });
}

// ajusta la hora segun el tiempo seleccionado
function ajustarHora(){
  $("#calendario-formulario").on('change', '#hora-inicio,#duracion', function () {
    let hora = $("#hora-inicio").val();
    let duracion = $("#duracion").val();
    let [horas,minutos] = hora.split(":").map(Number);
    if(duracion == '30M'){
      duracion = 0.5;
    }else if(duracion == '1H'){
      duracion = 1;
    }else if(duracion == '1H30M'){
      duracion = 1.5;
    }else if(duracion == '2H'){
      duracion = 2;
    }
    let minutosTotales = horas * 60 + minutos + duracion * 60;
    let nuevaHora = Math.floor(minutosTotales / 60);
    let nuevosMinutos = minutosTotales % 60;
    let horafin = `${nuevaHora.toString().padStart(2, "0")}:${nuevosMinutos.toString().padStart(2, "0")}`;
    console.log(hora,duracion,horafin);
    $("#hora-fin").val(horafin);
  });
}
//muestra las horas disponibles del dia seleccionado
async function cargarHorasDisponibles(date) {
  try{
    let data = await getOne({fecha:date},'agenda','getHoras');
    let select = document.getElementById("hora-inicio");
    let selectupdate = document.getElementById("hora-update");
    //let select = $("#hora-inicio");
    select.innerHTML = ""; // Limpiar opciones previas
    //console.log(data);
    data.forEach(hora => {
        //console.log(data);
        let option = document.createElement("option");
        option.value = hora;
        option.textContent = hora;
        let option2 = document.createElement("option");
        option2.value = hora;
        option2.textContent = hora;
        select.appendChild(option);
        selectupdate.appendChild(option2);
    });
  }catch(e){
    console.log("No llegan las horas correctamente: "+e);
  }
}