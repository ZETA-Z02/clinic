<?php require 'views/navbar.php'; ?>

<link rel="stylesheet" href="<?php css('dashboard') ?>">
<div class="grid-container">
    <!-- ENLACES AL SISTEMA -->
    <div class="grid-x align-center grid-margin-x cards__enlaces">
        <a href="<?php getrute('clientes'); ?>" class="cell large-6 card card-clientes">
            <div class="card-divider align-center">
                <p class="lead card-title">CLIENTES</p>
            </div>
            <div class="card-section text-center">
                <i class="fa-solid fa-people-group"></i>
            </div>
        </a>
        <a href="<?php getrute('agenda'); ?>" class="cell large-6 card card-agenda">
            <div class="card-divider align-center">
                <p class="lead card-title">AGENDA</p>
            </div>
            <div class="card-section text-center">
                <i class="fa-regular fa-calendar-days"></i>
            </div>
        </a>
        <a href="<?php getrute('estadisticas'); ?>" class="cell large-6 card card-estadisticas">
            <div class="card-divider align-center">
                <p class="lead card-title">ESTADISTICAS</p>
            </div>
            <div class="card-section text-center">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </a>
    </div>
    <!-- ENLACES AL SISTEMA END -->
</div>
<?php require 'views/footer.php'; ?>