import ApiService from "../../public/js/api/apiservice.js";

// NOTAS: Se puede estilar mas los modales y los formularios, como tambien el cuacrito de MAS CITAS
class Agenda extends ApiService {
    constructor() {
        super();
        this.controller = "agenda";
        this.calendarEl = document.getElementById("calendar");
        this.calendar = new FullCalendar.Calendar(this.calendarEl, {
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
                    url: `${this.url}/${this.controller}/get`,
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
            moreLinkContent: this.masNumInfoCita,
            moreLinkClick: this.masInfoCitas,
        });
        this.calendar.render();
    }
    async init() {
        this.SeleccionFecha();
        this.cancelarCita();
        this.GuardarCita();
        this.infoCita();
        //Funcionaes
        this.sugerencias();
        this.tags();
        this.eliminarCita();
        this.cerrarCita();
        /*Modal todas las citas */
        this.CerrarModal();
        this.infoCitaModalMore();
        /*formulario de citas, obteniendo datos para los selects */
        await this.getPersonal();
        await this.getProcedimientos();
        //Duplicar cita
        this.arrastrarCita(this.calendar);
        // AJUSTAR HORA
        this.ajustarHora();
        // EDITAR CITA
        this.buttonsEdit();
        this.editarCita();
    }
    // More Link Content
    masNumInfoCita(args) {
        // Personalizar el contenido del "más" link
        return `+${args.num}`;
    }
    // MoreLinkClick
    masInfoCitas(info) {
        //console.log(info);
        const eventos = info.allSegs.map((seg) => seg.event); // Todas las citas de ese día
        let html = "";
        eventos.forEach((event) => {
            let date = event.start.toLocaleDateString("es-ES", {
                month: "long",
                day: "numeric",
            });
            $("#modal-title").html(date);
            let fecha = event.start.toLocaleDateString("es-ES", {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            });
            let hora = event.start.toLocaleDateString("es-ES", {
                hour: "2-digit",
                minute: "2-digit",
                hour12: true,
            });
            hora = hora.split(",")[1];
            html += `<div class="box--cita" data-id="${event.id}" id="modal-info-cita">
                        <span class="box--cita--title lead">${fecha}, ${hora}</span>
                        <p>${event.title}</p>
                    </div>`;
        });
        //document.getElementById("modal-content").innerHTML = modalContent;
        $("#modal-content").html(html);
        $(".modales").hide();
        $(`#modal`).show();
        return false;
    }
    mostrarFormulario() {
        // Mostrar el formulario y ajustar tamaños
        //$("#calendar-forms").css("display", "block");
        this.abrirModal("calendar-forms");
        this.tags();
    }
    tags() {
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
    async cargarHorasDisponibles(date) {
        try {
            let data = await this.readOne({ fecha: date }, this.controller, "getHoras");
            let select = document.getElementById("hora-inicio");
            let selectupdate = document.getElementById("hora-update");
            //let select = $("#hora-inicio");
            select.innerHTML = ""; // Limpiar opciones previas
            //console.log(data);
            data.forEach((hora) => {
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
        } catch (error) {
            console.log("No llegan las horas correctamente: ", error);
        }
    }
    SeleccionFecha() {
        this.calendar.on("dateClick", async (info)=> {
            let date = info.dateStr;
            //console.log(date);
            $("#fecha-inicio, #fecha-fin").val(date);
            await this.cargarHorasDisponibles(date);
            this.mostrarFormulario();
            // let fecha = date.toISOString().split("T")[0];
            // const events = calendar.getEvents();
            this.calendar.render();
        });
    }
    cancelarCita() {
        $("#btn-cerrar-agenda").on("click",  () => {
            $("#calendar-forms").css("display", "none");
            $("#calendario-formulario")[0].reset();
            this.calendar.render();
        });
    }
    abrirModal(modalId) {
        $(".modales").hide();
        $(`#${modalId}`).show();
    }
    CerrarModal() {
        $("#btn-cerrar-modal").click(function () {
            $("#modal").hide();
        });
    }
    buttonsEdit() {
        $(".info-hora,.info-title,#btn-enviaredit-cita").hide();
        $("#btn-editar-cita").on("click", function () {
            $(".info-hora,.info-title,#btn-enviaredit-cita").show();
            $("#btn-editar-cita").hide();
        });
    }
    sugerencias() {
        let clienteInput = $("#cliente");
        let sugerenciasBox = $("#cliente-sugerencias");
        let clienteId = $("#cliente_id");
        clienteInput.on("input", async () => {
            let query = $(clienteInput).val();
            // if(query.length >= 2){// Va buscar a partir de 2 letras
            if (true) {
                // Va buscar a partir de 2 letras
                try {
                    const data = await this.readOne({ query: query },this.controller,                    "searchCustomers");
                    // console.log(data);
                    sugerenciasBox.empty();
                    data.forEach((element) => {
                        sugerenciasBox.append(
                            `<li data-id="${element.id}">${element.nombre} ${element.iniApellido}</li>`
                        );
                    });
                    sugerenciasBox.show();
                } catch (error) {
                    console.log("Error al traer clientes", error);
                }
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
    GuardarCita() {
        $("#calendario-formulario").submit(async (e) => {
            e.preventDefault();
            // obtener todos los inputs del formulario como json cambiar esto-*-*-*-*-*-*-*-*-*-*-*-*-*-*
            let data = {
                personal_procedimiento: $("#personal-procedimiento").val(),
                cliente: $("#cliente").val(),
                idcliente: $("#cliente_id").val(),
                procedimientos: $("#procedimientos").val(),
                duracion: $("#duracion").val(),
                personal_creador: $("#personal-creador").val(),
                fecha_inicio: $("#fecha-inicio").val(),
                fecha_fin: $("#fecha-fin").val(),
                hora_inicio: $("#hora-inicio").val(),
                hora_fin: $("#hora-fin").val(),
                mensaje: $("#mensaje").val(),
                idetiqueta: $("#personal-procedimiento option:selected").data("id"),
            };      
            //console.log(data);
            await this.create(data, this.controller, "guardarCita");
            e.target.reset();
            $("#cliente_id").val("");
            this.calendar.refetchEvents();
            this.calendar.render();
            this.tags();
            // Cerrar el formulario
            $("#calendar-forms").css("display", "none");
        });
    }
    infoCita() {
        this.calendar.on("eventClick", async (info) => {
            let cita = info.event;
            let id = cita.id;
            let fecha = cita.extendedProps.fecha_ini;
            let hora_ini = cita.extendedProps.hora_ini;
            let hora_fin = cita.extendedProps.hora_fin;
            //console.log(hora_ini);
            //console.log(id);
            try {
                const data = await this.readOne(id, this.controller, "infoCita");
                //console.log(data);
                let nombres = data.nombre + " " + data.apellido;
                $("#cita-title").html(data.titulo);
                $("#cita-nombre").html(nombres);
                $("#cita-fecha-inicio").html(data.fecha_ini);
                $("#cita-hora-inicio").html(this.convertirHora24a12(data.hora_ini));
                $("#cita-fecha-fin").html(data.fecha_fin);
                $("#cita-hora-fin").html(this.convertirHora24a12(data.hora_fin));
                $("#cita-mensaje").html(data.mensaje);
                $("#btn-eliminar-cita").attr("id-data", data.idcita);
                $("#info-idcita").val(data.idcita);
                this.colorInfo(data.color);
                $("#info-titleupdate").val(data.titulo);
                this.mostrarCita();
                await this.cargarHorasDisponibles(fecha);
            } catch (error) {
                console.error("ERROR", error);
            }
        });
    }
    editarCita() {
        //$("#btn-enviaredit-cita").on('click',function(){
        $("#btn-enviaredit-cita").click(async () => {
            let idcita = $("#info-idcita").val();
            let titulo = $("#info-titleupdate").val();
            let horaini = $("#hora-update").val();
            let horafin = $("#info-hora-fin").val();
            const data = {
                idcita: idcita,
                titulo: titulo,
                horaini: horaini,
                horafin: horafin,
            };
            await this.create(data, this.controller, "editarCita");
            this.calendar.render();
            this.calendar.refetchEvents();
        });
    }
    eliminarCita() {
        const that = this;
        $("#info-citas").on("click", "#btn-eliminar-cita", async function () {
            let id = $(this).attr("id-data");
            //console.log(id);
            await that.delete(id, that.controller, "delete");
            that.calendar.refetchEvents();
            $("#info-citas").css("display", "none");
        });
    }
    cerrarCita() {
        $("#btn-cerrar-info-cita").click(() => {
            $("#info-citas").css("display", "none");
            this.calendar.render();
        });
    }
    mostrarCita() {
        // Mostrar el modal
        //$("#info-citas").css("display", "block");
        this.abrirModal("info-citas");
        this.calendar.render();
    }
    colorInfo(color) {
        $("#cita-title").css("color", color);
        $("#cita-flecha-icon").css("color", color);
    }
    convertirHora24a12(hora24) {
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
    infoCitaModalMore() {
        const that = this;
        $(document).on("click", "#modal-info-cita", async function () {
            let id = $(this).attr("data-id");
            try {
                const data = await that.readOne(id, that.controller, "infoCita");
                //console.log(data);
                let nombres = data.nombre + " " + data.apellido;
                $("#cita-title").html(data.titulo);
                $("#cita-nombre").html(nombres);
                $("#cita-etiqueta").html(data.etiqueta);
                $("#cita-fecha-inicio").html(data.fecha_ini);
                $("#cita-hora-inicio").html(that.convertirHora24a12(data.hora_ini));
                $("#cita-fecha-fin").html(data.fecha_fin);
                $("#cita-hora-fin").html(that.convertirHora24a12(data.hora_fin));
                $("#cita-mensaje").html(data.mensaje);
                $("#btn-eliminar-cita").attr("id-data", data.idcita);
                that.colorInfo(data.color);
                that.mostrarCita();
            } catch (error) {
                console.error("ERROR", error);
            }
        });
    }
    async getPersonal() {
        try {
            const data = await this.read(this.controller, "getPersonal");
            let html = "";
            data.forEach((element) => {
                html += `<option value="${element.iniciales}" data-id="${element.id}">${element.iniciales}-${element.nombre}</option>`;
            });
            $("#personal-procedimiento,#personal-creador").html(html);
        } catch (error) {
            console.log("ERROR al obtener personal" + error);
        }
    }
    async getProcedimientos() {
        try {
            const data = await this.read(this.controller, "getProcedimientos");
            //console.log(data);
            let html = "";
            data.forEach((element) => {
                html += `<option value="${element.iniciales}">${element.iniciales}-${element.procedimiento}</option>`;
            });
            $("#procedimientos").html(html);
        } catch (error) {
            console.log("ERROR al obtener personal" + error);
        }
    }
    arrastrarCita() {
        this.calendar.on("eventDrop", async (info) => {
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
                    //console.log(newEventData);
                    await this.create(newEventData, this.controller, "duplicarCita");
                    this.calendar.refetchEvents(); // Recargar eventos en el calendario
                    alert("La cita ha sido duplicada exitosamente.");
                } catch (error) {
                    //console.error("Error al duplicar la cita:", error);
                    alert("Hubo un error al duplicar la cita.");
                }
            } else {
                // Si no se confirma, restaurar la posición original del evento
                info.revert();
            }
        });
    }
    ajustarHora() {
        $("#calendario-formulario").on("change", "#hora-inicio,#duracion", function () {
                let hora = $("#hora-inicio").val();
                let duracion = $("#duracion").val();
                let [horas, minutos] = hora.split(":").map(Number);
                if (duracion == "30M") {
                    duracion = 0.5;
                } else if (duracion == "1H") {
                    duracion = 1;
                } else if (duracion == "1H30M") {
                    duracion = 1.5;
                } else if (duracion == "2H") {
                    duracion = 2;
                }
                let minutosTotales = horas * 60 + minutos + duracion * 60;
                let nuevaHora = Math.floor(minutosTotales / 60);
                let nuevosMinutos = minutosTotales % 60;
                let horafin = `${nuevaHora
                    .toString()
                    .padStart(2, "0")}:${nuevosMinutos
                    .toString()
                    .padStart(2, "0")}`;
                //console.log(hora, duracion, horafin);
                $("#hora-fin").val(horafin);
            }
        );
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    const agenda = new Agenda();
    await agenda.init();
});
