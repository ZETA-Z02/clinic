<?php require 'views/sidebar.php';?>
<div class="grid-container full">
    <div class="grid-x">
        <div class="cell text-center">
            <h1>Procedimientos</h1>
            <hr>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell large-6">
            <table>
                <thead>
                    <tr>
                        <th>Procedimiento</th>
                        <th>Fecha Creacion</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-procedimientos">
                    <tr>
                        <td>Cirugia</td>
                        <td>02-11-2003</td>
                        <td>edit</td>
                        <td>delete</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="cell large-6 callout">
            <form id="form-procedimiento" method="POST">
            <div class="grid-x">
                <div class="cell">
                    <h3>Nuevo Procedimiento</h3>
                </div>
                <div class="cell">
                    <input type="text" name="id" id="id" hidden style="display:none;">
                    <label for="procedimiento">Nombre del Procedimiento</label>
                    <input type="text" name="procedimiento" id="procedimiento">
                    <label for="descripcion">Descripcion del procedimiento</label>
                    <textarea name="descripcion" id="descripcion"></textarea>
                </div>    
                <div class="cell text-center">
                    <button class="button" type="submit" id="btn-guardar">Guardar</button>
                </div>
            </div>
            </form>   
        </div>
    </div>
</div>
<script src="<?php js('procedimientos');?>"></script>
<?php require 'views/footer.php';?>