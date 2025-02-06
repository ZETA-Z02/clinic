$(document).ready(function(){
    var idcliente = $("#idcliente").val();
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        editable: true,
        initialView: "dayGridMonth",
        headerToolbar: {
          center: "dayGridMonth,timeGridWeek",
          left: "prev,next today",
          right: "title",
        },
        locale: "es",
        eventSources: [
          {
            url: `http://${host}/${proyect}/clientes/onecita/${idcliente}`,
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
      });
      calendar.render();
})