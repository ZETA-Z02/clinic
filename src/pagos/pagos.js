import PresupuestoGeneral from "./general.js";
import PresupuestoDetallado from "./detallado.js";
import PresupuestoOrtodoncia from "./ortodoncia.js";

document.addEventListener("DOMContentLoaded", async () => {
    const presupuestoGeneral = new PresupuestoGeneral();
    const presupuestoDetallado = new PresupuestoDetallado();
    const presupuestoOrtodoncia = new PresupuestoOrtodoncia();

    document.querySelectorAll(".modal").forEach(modal => {
        modal.style.display = "none";
    });
    const btnTablas = document.querySelectorAll(".activate");
    btnTablas.forEach(btn => {
        btn.addEventListener("click", async function (){
            const idtabla = this.dataset.id;
            document.querySelectorAll(".modal").forEach(modal => {
                modal.style.display = "none";
            });
            const modalTarget = document.getElementById("tabla-" + idtabla);
            if (modalTarget) {
                modalTarget.style.display = "block";
            }
            if(idtabla === "detallado"){
                await presupuestoDetallado.init();
            }else if(idtabla === "general"){
                await presupuestoGeneral.init();
            }else if(idtabla === "ortodoncia"){
                await presupuestoOrtodoncia.init();
            }
        });
    });
    
});