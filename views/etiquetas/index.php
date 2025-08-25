<?php require 'views/sidebar.php';?>
<link rel="stylesheet" href="<?php getrute('public/js/plugins/jpaginate.css') ?>">
<link rel="stylesheet" href="<?php css('etiquetas') ?>">
<div class="grid-container full">
    <div class="grid-x">
        <div class="cell text-center">
            <h1>Etiquetas</h1>
            <hr>
        </div>
    </div>
    <div class="cell text-center">
        <button class="button btn-success" id="btn-nuevaetiqueta">Nueva Etiqueta</button>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell" id="table-etiquetas">
            <table class="stack text-center">
                <tr>
                <thead>
                        <th>Etiqueta</th>
                        <th>Personal</th>
                        <th>Nombre</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-etiquetas">
                    <tr><td>Registre una nueva etiqueta para comenzar...</td>
                        <!-- <td>Fernando Lopez</td>
                        <td>Verde</td>
                        <td>FL</td>
                        <td>edit</td>
                        <td>delete</td> -->
                    </tr>
                </tbody>
            </table>
            <div id="paginador-etiquetas"></div>
        </div>
        <div class="cell callout" id="formulario-etiquetas">
            <form id="form-etiquetas" method="POST">
            <div class="grid-x">
                <div class="cell">
                    <h3>Nueva Etiqueta</h3>
                </div>
                <div class="cell grid-x grid-margin-x">
                    <input type="hidden" name="id" id="id">
                    <div class="cell large-6">
                        <label for="personal">Personal asignado a la etiqueta</label>
                        <select name="idpersonal" id="select-personal"></select>
                    </div>
                    <div class="cell large-6">
                        <label for="color">Color de la etiqueta</label>
                        <input type="color" name="color" id="color">
                    </div>
                    <div class="cell large-6">
                        <label for="nombre">Nombre de la etiqueta</label>
                        <input type="text" name="nombre" id="nombre" readonly>
                    </div>
                </div>
                <div class="cell grid-x align-spaced">
                    <button class="button" type="submit" id="btn-guardar">Guardar</button>
                    <button class="button btn-cancel" type="button" id="btn-cancelar">Cancelar</button>
                </div>
            </div>
            </form>   
        </div>
    </div>
</div>
<script type="module" src="<?php src('etiquetas');?>"></script>
<script src="<?php plugin('jpaginate');?>"></script>
<?php require 'views/footer.php';?>