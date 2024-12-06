<div class="overlay"></div>
<div class="grid-container nuevocliente">
    <div class="grid-x align-center">
        <h2>Nuevo Cliente</h2>
    </div>
    <form method="POST" id="form-nuevocliente">
    <div class="grid-x grid-margin-x nuevocliente__box nuevocliente--inputs">
        <div class="cell large-6 nuevocliente__item">
            <label for="dni">DNI</label>
            <input type="text" id="dni" name="dni" required>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="telefono">Telefono</label>
            <input type="text" id="telefono" name="telefono" required>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="totalpagar">Total a Pagar</label>
            <input type="text" id="totalpagar" name="totalpagar" required>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="procedimiento">Procedimiento</label>
            <select name="procedimiento" id="procedimiento"></select>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="primerpago">Primer Pago</label>
            <input type="text" id="primerpago" name="primerpago" required>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="concepto">Concepto</label>
            <input type="text" id="concepto" name="concepto" placeholder="Primer Pago" required>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required readonly>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required readonly>
        </div>
    </div>
    <div class="grid-x nuevocliente__box nuevocliente--buttons">
        <div class="cell large-6">
            <button class="button" id="btn-cerrar-nuevocliente" type="button">Cancelar</button>
        </div>
        <div class="cell large-6 text-right">
            <button class="button" type="submit">GUARDAR</button>
        </div>
    </div>
    </form>
</div>