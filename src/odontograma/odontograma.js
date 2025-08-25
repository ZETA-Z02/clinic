import ApiService from "../../public/js/api/apiservice.js";

class Odontograma extends ApiService {
    constructor() {
        super();
        this.controller = "odontograma";
        this.metodo = "create";
    }
    async init(){
        $("#info-diente").hide();
        await this.colorPieza();
        await this.getProcedimientos();
        await this.mostrarLeyenda();
        this.InfoPieza();
        this.subirImagen();
        
        
    }
    subirImagen() {
        document.getElementById("file").addEventListener("change", function () {
            let file = this.files[0];
            let fileName = this.files[0] ? this.files[0].name : "Ningún archivo seleccionado";
            document.getElementById("file-name").textContent = fileName;
            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    let img = document.getElementById("imagen-pieza");
                    img.src = e.target.result;
                    img.style.display = "block"; // Mostrar la imagen
                };
                reader.readAsDataURL(file);
            }
        });
    }
    InfoPieza() {
        const that = this;
        $(".btn-pieza").on("click", async function () {
            $("#info-diente").show();
            let pieza = $(this).data("pieza");
            let diente = $(this).attr("title");
            let idcliente = $("#idcliente").val();
            $("#diente-seleccionado").text(diente);
            $("#diente-input").val(pieza);
            try {
                const datos = { idcliente: idcliente, pieza: pieza };
                // console.log(datos);
                const data = await that.readOne(datos, that.controller, "infoPieza");
                console.log(data);
                if (data !== 0) {
                    $("#procedimientos-select").val(data.idprocedimiento);
                    $("#diente-input").val();
                    $("#idcliente").val();
                    $("#observaciones").val(data.observaciones);
                    $("#estado").val(data.estado);
                    $("#condicion").val(data.condicion);
                    $("#imagen-pieza").attr("src", data.imagen);
                    that.metodo = "update";
                    that.Guardar();
                    //console.log("se debe actualizar el registro");
                    await that.colorPieza();
                } else {
                    $("#procedimientos-select").val("");
                    //$("#diente-input").val('');
                    //$("#idcliente").val('');
                    $("#observaciones").val("");
                    $("#estado").val("");
                    $("#condicion").val("");
                    $("#imagen-pieza").attr("src", "");
                    that.metodo = "create";
                    that.Guardar();
                    await that.colorPieza();
                    //console.log('se debe insertar nuevo registro sobre el diente seleccionado');
                }
            } catch (error) {
                console.log("ERROR al obtener un registro o insertarlo", error);
            }
            // console.log(diente, idcliente);
        });
    }
    Guardar() {
        $("#guardar").off("click").on("click", async () => {
                let data = new FormData();
                data.append("procedimiento", $("#procedimientos-select").val());
                data.append("pieza", $("#diente-input").val());
                data.append("idcliente", $("#idcliente").val());
                data.append("observaciones", $("#observaciones").val());
                data.append("estado", $("#estado").val());
                data.append("condicion", $("#condicion").val());
                data.append("imagen", $("#file")[0].files[0]);
                console.log(data);
                await this.createWithFiles(data, this.controller, this.metodo, "guardar");
                await this.colorPieza();
                if(this.metodo!== ""){
                    this.metodo = "update";
                }
            });
    }
    async getProcedimientos() {
        try {
            const data = await this.read("procedimientos", "get");
            let select = $("#procedimientos-select");
            let html = "";
            //console.log(data);
            data.forEach((element) => {
                html += `<option value="${element.id}">${element.procedimiento}</option>`;
            });
            select.html(html);
        } catch (error) {
            console.log("ERROR al obtener procedimientos", error);
        }
    }
    // GET -> Obtiene los datos de cada diente y su color
    async colorPieza() {
        let idcliente = $("#idcliente").val();
        let piezas = $(".btn-pieza");
        for (let element of piezas) {
            let pieza = $(element).data("pieza");
            try {
                const data = await this.readOne({ idcliente: idcliente, pieza: pieza }, this.controller,"colorPieza");
                //console.log(data);
                if (data !== 0) {
                    $(element).attr(
                        "style",
                        `fill: ${data.color}99 !important;`
                    );
                    $(element).hover(
                        function () {
                            $(this).css(`fill`, ``);
                        },
                        function () {
                            $(this).css(`fill`, `${data.color}99`);
                        }
                    );
                }
            } catch (e) {
                console.log("ERROR obtener colores", e);
            }
        }
    }
    async mostrarLeyenda() {
        let leyenda = $("#leyenda");
        try {
            const data = await this.read(this.controller, "leyenda");
            console.log(data);
            let html = "";
            let comunes = [
                "sellantes",
                "restauracion de niños",
                "restauracion simple rfs",
                "endodoncia anteriores",
                "endodoncia posteriores",
                "poste de seguridad",
                "corona porcelanato",
                "corona ivocron",
                "provisional coronas",
                "exodoncia",
            ];
            let inicioLista = data.filter((element) =>
                comunes.includes(element.procedimiento.toLowerCase())
            );
            inicioLista.forEach((element) => {
                html += `
            <li style="color: ${element.color};font-size: 1.4rem;"><i class="fa-solid fa-tooth" style="color: ${element.color};"></i>${element.procedimiento}</li>
            `;
            });
            let finLista = data.filter(
                (element) =>
                    !comunes.includes(element.procedimiento.toLowerCase())
            );
            finLista = finLista.filter(
                (element) => element.procedimiento.toLowerCase() != "ortodoncia"
            );
            finLista.forEach((element) => {
                html += `
            <li style="color: ${element.color};font-size: 1.4rem;"><i class="fa-solid fa-tooth" style="color: ${element.color};"></i>${element.procedimiento}</li>
            `;
            });
            $("#leyenda-data").html(html);
        } catch (e) {
            console.log("ERROR EN LEYENDA ODONTOGRAMA", e);
        }
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    const odontograma = new Odontograma();
    await odontograma.init();
});