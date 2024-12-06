<!doctype html>
<html class="no-js" lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Titulo de la pagina -->
  <title>CHIC | Welcome</title>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <!-- CHARTJS-GRAFICOS -->
  <script src="<?php getrute('node_modules/chart.js/dist/chart.umd.js')?>"></script>
  <!-- ICONOS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Estilos foundation -->
  <link rel="stylesheet" href="<?php getrute('utils/foundation/css/foundation.css'); ?>">
  <link rel="stylesheet" href="<?php getrute('utils/foundation/css/foundation-float.css'); ?>">
  <link rel="stylesheet" href="<?php getrute('utils/foundation/css/foundation-prototype.css'); ?>">
  <!-- Motion UI -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />
  <!-- Motion UI end -->
   <!-- jquery -->
   <script src="<?php getrute('utils/foundation/js/jquery.min.js'); ?>"></script>
  <!-- css and js-->
   <link rel="stylesheet" href="<?php css('app')?>">
   <script src="<?php js('app');?>"></script>
    <!-- PLUGINS A UTILIZAR JS -->
    <script src="<?php plugin('ajax/crud');?>"></script>
    <script src="<?php plugin('helpers/validation');?>"></script>
    <script src="<?php plugin('dni/dni');?>"></script>
    <script src="<?php plugin('helpers/search');?>"></script>
    <script src="<?php echo constant('URL') ?>node_modules/fullcalendar/index.global.min.js"></script>
</head>
<body>
    <nav class="nav">
        <div class="nav__box nav--logo">
            <div class="logo">
                <div class="logo__icon"><i class="fa-solid fa-tooth"></i></div>
                <div class="logo__title">CHIC</div>
            </div>
            <div class=""></div>
        </div>
        <div class="nav__box nav--menu">
            <ul class="nav__list">
                <li class="nav__item <?php echo @$this->css == 'agenda' ? 'nav--selected' : '';?>"><a href="<?php getrute('agenda')?>">Agenda</a></li>
                <li class="nav__item <?php echo @$this->css == 'clientes' ? 'nav--selected' : '';?>"><a href="<?php getrute('clientes')?>" >Clientes</a></li>
                <li class="nav__item <?php echo @$this->css == 'estadisticas' ? 'nav--selected' : '';?>"><a href="<?php getrute('estadisticas')?>">Graficos</a></li>
            </ul>
        </div>
        <div class="nav__box nav--btn">
            <?php if($_SESSION['katari'] == "katariAdmin"){?>
            <div class="nav__icons">
                <a href="<?php getrute('personal')?>"><i class="fa-solid fa-gear"></i></a>
            </div>
            <?php } ?>
            <div class="nav__icons">
                <!-- <a href=""><i class="fa-solid fa-door-open"></i></a> -->
                <a href="<?php getrute('login/logout')?>"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
    </nav>
    <?php require 'modales.php';?>
    <div class="gird-container full">