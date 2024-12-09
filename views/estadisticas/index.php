<?php require 'views/navbar.php'; ?>
<script src="<?php getrute('node_modules/chart.js/dist/chart.umd.js') ?>"></script>
<div class="grid-container fluid">
    <!-- CARDS -->
    <div class="grid-x large-up-3 cards">
        <div class="card margin-horizontal-3 shadow">
            <div class="card-divider align-center">
                <h3 id="card-clientes">10</h3>
            </div>
            <div class="card-section text-center">
                <p class="lead">Clientes</p>
            </div>
        </div>
        <div class="card margin-horizontal-3 shadow">
            <div class="card-divider align-center">
                <h3 id="card-citas">20</h3>
            </div>
            <div class="card-section text-center">
                <p class="lead">Citas</p>
            </div>
        </div>
        <div class="card margin-horizontal-3 shadow">
            <div class="card-divider align-center">
                <h3 id="card-recaudado">30</h3>
            </div>
            <div class="card-section text-center">
                <p class="lead">Recaudado</p>
            </div>
        </div>
    </div>
    <div class="grid-x grid-margin-x" id="graficos">
        <div class="cell large-6">
            <canvas id="chart-barras"></canvas>
        </div>
        <div class="cell large-6">
            <canvas id="chart-line"></canvas>
        </div>
    </div>
    <div class="grid-x">
        <div class="cell">
            <label for="">Elegir Año</label>
            <select name="fecha-year" id="fecha-year"></select>
        </div>
    </div>
    <!-- CARDS END -->
</div>
<script src="<?php js('estadisticas') ?>"></script>
<?php require 'views/footer.php'; ?>