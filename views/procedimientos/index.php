<?php require 'views/sidebar.php';?>
<link rel="stylesheet" href="<?php getrute('public/plugins/paginador/jpaginate.css') ?>">
<div class="grid-container full">
    <div class="grid-x">
        <div class="cell text-center">
            <h1>Procedimientos</h1>
            <hr>
        </div>
    </div>
    <div class="grid-x">
        <div class="cell text-center">
            <button class="button btn-success" id="btn-nuevoprocedimiento">Nuevo Procedimiento</button>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell large-12" id="tabla-procedimientos">
            <table class="stack">
                <thead>
                    <tr>
                        <th>Procedimiento</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Fecha Creacion</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-procedimientos" class="text-center">
                    <tr>
                        <td>Cirugia</td>
                        <td>200.00</td>
                        <td>02-11-2003</td>
                        <td>edit</td>
                        <td>delete</td>
                    </tr>
                </tbody>
            </table>
            <div id="paginador-procedimientos"></div>
        </div>
        <div class="cell large-12 callout grid-x align-center" id="formulario-procedimiento">
            <form id="form-procedimiento" method="POST">
            <div class="grid-x">
                <div class="cell text-center">
                    <h3 id="titule">Nuevo Procedimiento</h3>
                    <hr>
                </div>
                <div class="cell large-12 grid-x grid-margin-x padding-3">
                    <input type="hidden" name="id" id="id">
                    <div class="cell large-6">    
                        <label for="procedimiento">Nombre del Procedimiento</label>
                        <input type="text" name="procedimiento" id="procedimiento">
                    </div>
                    <div class="cell large-6">
                        <label for="precio">Precio del Procedimiento</label>
                        <input type="text" name="precio" id="precio">
                    </div>
                    <div class="cell large-6">
                        <label for="iniciales">Iniciales del Procedimiento</label>
                        <input type="text" name="iniciales" id="iniciales">
                    </div>
                    <div class="cell large-6">
                        <label for="descripcion">Descripcion del procedimiento</label>
                        <textarea name="descripcion" id="descripcion"></textarea>
                    </div>
                    <div class="cell large-6">
                        <label for="color">Color del Procedimiento</label>
                        <input type="color" name="color" id="color" class="color">
                    </div>
                </div>    
                <div class="cell grid-x align-spaced">
                    <button class="button btn-cancel" type="button" id="btn-cancelar">Cancelar</button>
                    <button class="button" type="submit" id="btn-guardar">Guardar</button>
                </div>
            </div>
            </form>   
        </div>
    </div>
</div>
<script src="<?php plugin('paginador/jpaginate');?>"></script>
<script src="<?php js('procedimientos');?>"></script>
<?php require 'views/footer.php';?>