<?php require 'views/sidebar.php';?>
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
                <button class="button search" id="btn-nuevopersonal"><i class="fa fa-plus"></i> Agregar Cliente</button>
            </div>
        </div>
    </div>
    <div class="grid-x">
        <div class="cell">
            <table id="table-personal-data">
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
        </div>
    </div>
</div>
<?php require('nuevopersonal.php'); ?>
<script src="<?php js('personal');?>"></script>
<?php require 'views/footerSidebar.php';?>