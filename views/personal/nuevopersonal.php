<div class="overlay"></div>
<div class="grid-container nuevopersonal">
    <div class="grid-x align-center">
        <h2>Nuevo Personal</h2>
    </div>
    <form method="POST" id="form-nuevopersonal">
    <div class="grid-x grid-margin-x nuevopersonal__box nuevopersonal--inputs" id="nuevopersonal">
        <div class="cell large-6 nuevopersonal__item">
            <label for="dni">DNI</label>
            <input type="text" id="dni" name="dni" maxlength="8" required>
        </div>
        <div class="cell large-6 nuevopersonal__item">
            <label for="telefono">Telefono</label>
            <input type="text" id="telefono" name="telefono" maxlength="9" required>
        </div>
        <div class="cell large-6 nuevopersonal__item">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" readonly require>
        </div>
        <div class="cell large-6 nuevopersonal__item">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" readonly require>
        </div>
    </div>
    <!-- SE REGISTRA EL LOGIN DEL PERSONAL -->
    <div class="grid-x grid-margin-x nuevopersonal__box nuevopersonal--inputs" id="nuevologin">
        <div class="cell large-6 nuevopersonal__item">
            <label for="username">Nombre de Usuario</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="cell large-6 nuevopersonal__item">
            <label for="password">Contraseña</label>
            <input type="text" id="password" name="password" required>
        </div>
    </div>
    <div class="grid-x nuevopersonal__box nuevopersonal--buttons">
        <div class="cell large-6">
            <button class="button" id="btn-cerrar-nuevopersonal" type="button">Cancelar</button>
        </div>
        <div class="cell large-6 text-right" id="btn-siguiente">
            <button class="button" type="button">Login</button>
        </div>
        <div class="cell large-6 text-right" id="btn-guardar">
            <button class="button" type="submit">GUARDAR</button>
        </div>
    </div>
    </form>
</div>