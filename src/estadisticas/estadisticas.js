import ApiService from "../../public/js/api/apiservice.js";

class Estadisticas extends ApiService {
    constructor() {
        super();
        this.controller = "estadisticas";
        this.BarrasInstance;
        this.linesInstance;
    }
    async init() {
        await this.getCards();
        this.elegirFecha();
        this.cambioFecha();
        this.chartBarras();
        this.chartLineas();
    }
    async getCards() {
        try {
            const data = await this.read(this.controller, "get");
            $("#card-clientes").html(data.clientes);
            $("#card-citas").html(data.citas);
            $("#card-recaudado").html(`S/. ${data.dinero}`);
        } catch (error) {
            console.log("ERROR en cards", error);
        }
    }
    elegirFecha() {
        let actual = new Date().getFullYear();
        let anioInicio = actual - 2;
        let html = "";
        for (let i = 0; i < 5; i++) {
            html += `<option value="${anioInicio + i}" ${
                actual === anioInicio + i ? "selected" : ""
            }>${anioInicio + i}</option>`;
        }
        $("#fecha-year").html(html);
    }
    cambioFecha() {
        $(document).on("change", "#fecha-year", async function () {
            let fecha = $(this).val();
            await chartBarras(fecha);
            await chartLineas(fecha);
        });
    }
    async chartLineas(fecha = new Date().getFullYear()) {
        const ctx = document.getElementById("chart-line").getContext("2d");
        if (this.linesInstance) this.linesInstance.destroy();
        try {
            const data = await this.readOne(
                { fecha: fecha },
                this.controller,
                "getLine"
            );
            const setdata = [
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
                data.diciembre,
            ];
            this.linesInstance = new Chart(ctx, {
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
                            label: "Recaudado",
                            data: setdata,
                            borderColor: "#ff6384",
                            backgroundColor: "rgba(255, 99, 132, 0.2)",
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 5,
                            pointBackgroundColor: "#ff6384",
                            pointBorderColor: "#fff",
                            hoverBackgroundColor: "#ff6384",
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        tooltip: { enabled: true },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: "rgba(200, 200, 200, 0.3)" },
                        },
                        x: {
                            grid: { display: false },
                        },
                    },
                },
            });
        } catch (error) {
            console.log("Error en line", error);
        }
    }
    async chartBarras(fecha = new Date().getFullYear()) {
        const ctx = document.getElementById("chart-barras").getContext("2d");
        if (this.BarrasInstance) this.BarrasInstance.destroy();
        try {
            const data = await this.readOne(
                { fecha: fecha },
                this.controller,
                "getBarras"
            );
            const setdata = [
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
                data.diciembre,
            ];

            this.BarrasInstance = new Chart(ctx, {
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
                    datasets: [
                        {
                            label: "# de clientes",
                            data: setdata,
                            backgroundColor: "rgba(54, 162, 235, 0.6)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 2,
                            borderRadius: 5,
                            hoverBackgroundColor: "rgba(54, 162, 235, 0.9)",
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        tooltip: { enabled: true },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: "rgba(200, 200, 200, 0.3)" },
                        },
                        x: {
                            grid: { display: false },
                        },
                    },
                },
            });
        } catch (error) {
            console.error("Error al obtener los datos:", error);
        }
    }
}

document.addEventListener("DOMContentLoaded", async function () {
    const estadisticas = new Estadisticas();
    await estadisticas.init();
});
