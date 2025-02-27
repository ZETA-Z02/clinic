$(document).ready(function () {
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
        url: `${url}/clientes/onecita/${idcliente}`,
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

  // FUNCTIONS
  // Buscador
  search("search-citas", "tabla-citas");
  getCitasCliente();
});

async function getCitasCliente(){
  var idcliente = $("#idcliente").val();
  try{
    const data = await getOne(idcliente,'clientes','citasCliente');
    let html = '';
    data.forEach(element => {
      if(element.mensaje == ''){
        mensaje = `<p style="color: green`">Sin Observaciones</p>`;
      }
      html += `
          <tr>
            <td>${element.fecha}</td>
            <td>${element.titulo}</td>
            <td>${mensaje}</td>
            <td>${element.hora}</td>
          </tr>`;
    });
    $("#tabla-data-citas").html(html);
  }catch(e){
    console.log("ERROR al obtener las citas del cliente: "+e);
  }
}
