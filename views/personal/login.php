<?php require 'views/sidebar.php';?>
<div class="grid-container">
    <div class="grid-x align-center">
        <h1>Personal: <?php echo @$this->data['nombre'];?></h1>
    </div>
    <hr>
    <form action="<?php getrute('personal/actualizarLogin');?>" method="POST" id="form-detallespersonal" enctype="multipart/form-data">
    <div class="grid-x grid-margin-x">
        <div class="cell large-12">
            <input type="hidden" name="idpersonal" id="idpersonal" value="<?php echo $this->data['idpersonal'];?>">
        </div>
        <div class="cell large-6">
            <label for="username">Nombre de usuario</label>
            <input type="text" name="username" id="username" value="<?php echo $this->data['username'];?>">
        </div>
        <div class="cell large-6">
            <label for="password">Nuevo Password</label>
            <input type="text" name="password" id="password">
        </div>
        <div class="cell large-6">
            <label for="estado">Estado</label>
            <select name="estado" id="estado">
                <option value="1" <?php echo $this->data['estado'] == 1 ? "selected" : '';?>>Activo</option>
                <option value="0" <?php echo $this->data['estado'] == 0 ? "selected" : '';?>>Sin Acceso</option>
            </select>
        </div>
        <div class="cell large-6">
            <label for="nivel">Nivel de Usuario</label>
            <select name="nivel" id="nivel">
                <option value="2" <?php echo $this->data['nivel'] == 2 ? "selected" : '';?>>Administrador</option>
                <option value="1" <?php echo $this->data['nivel'] == 1 ? "selected" : '';?>>Personal</option>
            </select>
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