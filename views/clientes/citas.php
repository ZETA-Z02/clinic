<?php require 'views/navbar.php'; ?>
<link rel="stylesheet" href="<?php getrute('public/js/plugins/jpaginate.css') ?>">
<script src="<?php echo constant('URL') ?>node_modules/fullcalendar/index.global.min.js"></script>
<div class="grid-container" id="clientes-detalles">
  <div class="cell">
            <h2>Citas de <?php echo $this->data['nombre'].' '.$this->data['apellido'] ?></h2>
            <input type="hidden" name="idcliente" id="idcliente" value="<?php echo @$this->data['idcliente'];?>">
  </div>
  <div class="cell grid-x">
    <div class="cell">
      <div class="search__item">
        <input type="text" id="search-citas" placeholder="Buscar Cita">
      </div>
    </div>
    <div class="cell">
      <table id="tabla-citas">
        <thead class="thead-blue">
          <tr>
            <th>FECHA</th>
            <th>CASO</th>
            <th>OBSERVACIONES</th>
            <th>HORA</th>
          </tr>
        </thead>
        <tbody id="tabla-data-citas">
          <tr>
            <td>2025-01-01</td>
            <td>JS-NOMBRE-ORTO-1H30M-JS</td>
            <td>No hay citas registradas</td>
            <td>07:00:00</td>
          </tr>
          <tr></tr>
          <tr></tr>
        </tbody>
      </table>
      <div id="paginador-citas"></div>
    </div>
  </div>
</div>
<div class="grid-container full" id="clientes-detalles">
  <details class="calendario-details">
    <summary class="titulo-calendario">
      <h3>CALENDARIO DEL CLIENTE</h3>
    </summary>  
    <div class="grid-x">
      <div class="cell calendario-container" id="calendario">
      <div class="calendar" id="calendar"></div>
      </div>  
    </div>
  </details>
</div>
<style>
.calendar table {
  background-color: white !important;
  border-radius: 0px !important;
  box-shadow: none !important;
  overflow: hidden !important;
  margin-bottom: 0;
}
.calendar thead {
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
.titulo-calendario{
  border: 1px solid #19c8ecff;
  text-align: center;
}
.titulo-calendario:hover {
  border: 3px solid #240be1ff;
}

</style>
<!-- scripts -->
<script src="<?php plugin('jpaginate');?>"></script>
<script type="module" src="<?php src('clientes','citas') ?>"></script>
<?php require 'views/footer.php'; ?>
