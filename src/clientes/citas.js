import ApiService from "../../public/js/api/apiservice.js";
import { search } from "../../public/js/utils/search.js";
class Citas extends ApiService {
    constructor() {
        super();
        this.controller = "clientes";
    }
    async init(){
        this.calendarioCitas();
        await this.getCitasCliente();
    }
    calendarioCitas() {
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
                    url: `${this.url}/clientes/onecita/${idcliente}`,
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
    }
    async getCitasCliente(){
        var idcliente = $("#idcliente").val();
        try{
            const data = await this.readOne(idcliente,this.controller,'citasCliente');
            let html = '';
            let mensaje = '';
            data.forEach(element => {
                if(element.mensaje == ''){
                    mensaje = `<p style='color: green;'>Sin Observaciones</p>`;
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
            initPaginador(7, "tabla-data-citas", "paginador-citas");
        }catch(error){
            console.log("ERROR al obtener las citas del cliente: ", error);
        }
    }
}

document.addEventListener("DOMContentLoaded", async function () {
    const citas = new Citas();
    await citas.init();
    // Buscador
    search("search-citas", "tabla-citas");
});