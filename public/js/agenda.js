// CALENDAR --------------------------------
$(document).ready(function () {
  dni();
  $("#modal").hide();
  $("#datos-cita").hide();
  $("#enviar").hide();
  $("#btn-cerrar").on("click", function () {
    $("#modal").hide();
  });
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    headerToolbar: {
      center: "dayGridMonth,timeGridWeek",
    },
    locale: "es",
    // events: "http://localhost/veterinaria/citas/get",
    eventSources: [
      {
        url: "http://localhost/veterinariapuno/main/Get",
        method: "POST",
      },
    ],
  });
  calendar.render();
  reservar(calendar);
  insert(calendar);
});
function reservar(calendar) {
  calendar.on("dateClick", function (info) {
    let date = info.date;
    let hoy = new Date();
    //DESCOMENTAR ESTA LINEA:
    if (new Date(date) >= hoy) {
      // if (true) {
      let fecha = date.toISOString().split("T")[0];
      const events = calendar.getEvents();
      const totalReservas = events.filter((event) => {
        return event.start.toISOString().split("T")[0] === fecha;
      }).length;
      if (totalReservas < 4) {
        $("#modal").show();
        $("#fecha").val(fecha);
      } else {
        alert("El dia seleccionado ya tiene una cita reservada");
      }
    } else {
      alert("No se puede seleccionar fechas anteriores a hoy");
    }
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
}
function insert(calendar) {
  var calendar = calendar;
  $("#form-reservar").on("submit", function (e) {
    e.preventDefault();
    let data = $(this).serialize();
    console.log(data);
    $.ajax({
      type: "POST",
      url: "http://localhost/veterinariapuno/main/reservar",
      data: data,
      success: function (response) {
        if (response == 1 || response == true) {
          alert("Ya tiene cita, no puede reservar otra");
          $("#modal").hide();
          e.target.reset();
          return;
        }
        console.log(response);
        $("#modal").hide();
        $("#datos-cita").hide();
        $("#enviar").hide();
        $("#siguiente").show();
        $("#boleta").show();
        e.target.reset();
        //calendar.render();
        calendar.refetchEvents();
        alert(
          "Cita Reservada, Lleve su dni a la cita. Gracias por su preferencia"
        );
      },
      error: function (error) {
        console.log("error POST");
      },
    });
  });
}
