<?php require 'views/sidebar.php';?>
<link rel="stylesheet" href="<?php getrute('public/js/plugins/jpaginate.css') ?>">
<link rel="stylesheet" href="<?php css('personal') ?>">
<div class="grid-container">
    <div class="grid-x align-center">
        <h1>Personal</h1>
    </div>
    <hr>
    <div class="grid-x grid-margin-x">
        <div class="cell large-9 search">
            <div class="search__item">
                <input type="text" id="search-personal" placeholder="Buscar Personal">
            </div>
        </div>
        <div class="cell large-3 add">
            <div class="cell add_item">
                <button class="button search" id="btn-nuevopersonal"><i class="fa fa-plus"></i> Agregar Personal</button>
            </div>
        </div>
    </div>
    <div class="grid-x">
        <div class="cell large-12">
            <table id="table-personal-data" class="stack">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Telefono</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="data-personal">
                    <tr>
                        <td>Elver</td>
                        <td>Eduardo Lopez</td>
                        <td>73243243</td>
                        <td>926847234</td>
                        <td><a href="" class="button btn-info">Detalles</a></td>
                        <td><a href="" class="button btn-success">Login</a></td>
                    </tr>
                </tbody>
            </table>
            <div id="paginador"></div>
        </div>
    </div>
</div>
<!-- MODALES PARA REGISTRAR UN NUEVO PERSONAL -->
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
        <div class="cell large-6">
            <label for="color">Color de la etiqueta</label>
            <input type="color" name="color" id="color">
        </div>
        <div class="cell large-6">
            <label for="nombre_etiqueta">Nombre de la etiqueta</label>
            <input type="text" name="nombre_etiqueta" id="nombre_etiqueta" readonly>
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
<script type="module" src="<?php src("personal")?>"></script>
<script src="<?php plugin('jpaginate');?>"></script>
<?php require 'views/footerSidebar.php';?>