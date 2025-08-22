<?php require 'views/sidebar.php';?>
<div class="grid-container">
    <div class="grid-x align-center">
        <h1>Personal: <?php echo @$this->data['nombre'];?></h1>
    </div>
    <hr>
    <form action="<?php getrute('personal/actualizarPersonal');?>" method="POST" id="form-detallespersonal" enctype="multipart/form-data">
    <div class="grid-x grid-margin-x">
        <div class="cell large-12 callout text-center">
            <img src="<?php echo $this->data['foto'];?>" alt="fotopersonal" width="400">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto">
            <input type="hidden" name="idpersonal" id="idpersonal" value="<?php echo $this->data['idpersonal'];?>">
        </div>
        <div class="cell large-6">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $this->data['nombre'];?>">
        </div>
        <div class="cell large-6">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?php echo $this->data['apellido'];?>">
        </div>
        <div class="cell large-6">
            <label for="dni">DNI</label>
            <input type="text" name="dni" id="dni" value="<?php echo $this->data['dni'];?>">
        </div>
        <div class="cell large-6">
            <label for="telefono">Celular</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo $this->data['telefono'];?>">
        </div>
        <div class="cell large-6">
            <label for="sexo">Genero</label>
            <input type="text" name="sexo" id="sexo" value="<?php echo $this->data['sexo'];?>">
        </div>
        <div class="cell large-6">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php echo $this->data['email'];?>">
        </div>
        <div class="cell large-6">
            <label for="fechanacimiento">Fecha Nacimiento</label>
            <input type="date" name="fechanacimiento" id="fechanacimiento" value="<?php echo $this->data['fechaNac'];?>">
        </div>
        <div class="cell large-6">
            <label for="fechacreacion">Fecha de Creacion</label>
            <input type="text" name="fechacreacion" id="fechacreacion" value="<?php echo $this->data['feCreate'];?>">
        </div>
    </div>
    <div class="grid-x">
        <div class="cell large-12 text-center">
            <button type="submit" class="button btn-success">Actualizar</button>
        </div>
    </div>
    </form>
</div>

<?php require 'views/footerSidebar.php';?>