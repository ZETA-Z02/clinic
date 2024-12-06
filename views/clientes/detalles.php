<?php require 'views/navbar.php'; ?>
<link rel="stylesheet" href="<?php css('clientes') ?>">
<div class="grid-container" id="clientes-detalles">
    <div class="grid-x">
        <div class="cell text-center">
            <h1>Cliente: <?php echo $this->data['nombre']?></h1>
        </div>
    </div>
    <form action="<?php getrute('clientes/actualizarCliente');?>" method="POST">
    <div class="grid-x grid-margin-x">
        <div class="cell large-6">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $this->data['nombre']?>">
        </div>
        <div class="cell large-6">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?php echo $this->data['apellido']?>">
        </div>
        <div class="cell large-6">
            <label for="dni">DNI</label>
            <input type="text" name="dni" id="dni" value="<?php echo $this->data['dni']?>">
        </div>
        <div class="cell large-6">
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo $this->data['telefono']?>">
        </div>
        <div class="cell large-6">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php echo $this->data['email']?>">
        </div>
        <div class="cell large-6">
            <label for="genero">Genero</label>
            <input type="text" name="genero" id="genero" value="<?php echo $this->data['genero']?>">
        </div>
        <div class="cell large-6">
            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" id="ciudad" value="<?php echo $this->data['ciudad']?>">
        </div>
        <div class="cell large-6">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" value="<?php echo $this->data['direccion']?>">
        </div>
        <div class="cell large-6">
            <label for="fecreate">Fecha de Creacion</label>
            <input type="text" name="fecreate" id="fecreate" value="<?php echo $this->data['feCreate']?>">
        </div>
        <div class="cell large-6">
            <label for="feupdate">Ultima Actualizacoin</label>
            <input type="date" name="feupdate" id="feupdate" value="<?php echo $this->data['feUpdate']?>">
        </div>
    </div>
    <div class="grid-x buttons">
        <div class="cell text-center">
            <input type="text" name="idcliente" id="idcliente" value="<?php echo $this->data['idcliente']?>" hidden style="display:none;">
            <button class="button btn-success" type="submit">Actualizar</button>
        </div>
    </div>
    </form>
</div>
<!-- scripts -->
<script src="<?php js('clientes') ?>"></script>
<?php require 'views/footer.php'; ?>
