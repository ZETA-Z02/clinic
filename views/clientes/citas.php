<?php require 'views/navbar.php'; ?>
<div class="grid-container full" id="clientes-detalles">
    <div class="grid-x">
        <div class="cell">
            <h2>Citas de <?php echo $this->data['nombre'].' '.$this->data['apellido'] ?></h2>
            <input type="hidden" name="idcliente" id="idcliente" value="<?php echo @$this->data['idcliente'];?>">
        </div>
        <div class="cell calendario-container" id="calendario">
			<div class="calendar" id="calendar"></div>
	    </div>  
    </div>
</div>
<style>
table {
  background-color: white !important;
  border-radius: 0px !important;
  box-shadow: none !important;
  overflow: hidden !important;
  margin-bottom: 0;
}
thead {
  background: white !important;
}
thead th {
  font-weight: 800 !important;
  text-align: center;
}
.nav {
  margin-bottom: 1rem !important;
}
.footer-katari {
  display: none;
}
</style>
<!-- scripts -->
<script src="<?php js('citas') ?>"></script>
<?php require 'views/footer.php'; ?>
