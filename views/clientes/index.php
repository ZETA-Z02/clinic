<?php require 'views/navbar.php'; ?>
<link rel="stylesheet" href="<?php getrute('public/plugins/paginador/jpaginate.css') ?>">
<link rel="stylesheet" href="<?php css('clientes') ?>">

<div class="grid-container" id="clientes-main">
    <div class="grid-x grid-margin-x margin-top-3">
        <div class="cell large-9 search">
            <div class="search__item">
                <input type="text" id="search-clientes" placeholder="Buscar Cliente">
            </div>
        </div>
        <div class="cell large-3 add">
            <div class="cell add_item">
                <button class="button search" id="btn-nuevocliente"><i class="fa fa-plus"></i> Agregar Cliente</button>
            </div>
        </div>
    </div>
    <div class="grid-x margin-top-2 table-clientes">
        <div class="cell large-12 table__clientes" id="table-clientes">
            <table class="stack table" id="table-clientes-data">
                <thead>
                    <tr>
                        <th>Info</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Celular</th>
                        <th colspan="3">Acciones</th>
                    </tr>
                </thead>
                <tbody id="clientes-data">
                    <!-- <tr>
                        <td><button class="button btn-info">Detalles</button></td>
                        <td>Jersson Pelayo</td>
                        <td>Quispe Apaza</td>
                        <td>72535245</td>
                        <td>998777712</td>
                        <td><button class="button btn-primary">Citas</button></td>
                        <td><button class="button btn-warning">Pagos</button></td>
                        <td><button class="button btn-success">Nuevo Pago</button></td>
                    </tr> -->
                </tbody>
            </table>
            <div id="paginador-clientes"></div>
        </div>
    </div>
</div>
<?PHP require 'nuevocliente.php';?>
<?PHP require 'nuevopago.php';?>
<!-- scripts -->
<script src="<?php plugin('paginador/jpaginate');?>"></script>
<script src="<?php js('clientes') ?>"></script>
<?php require 'views/footer.php'; ?>
