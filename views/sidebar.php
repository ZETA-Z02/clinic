<!doctype html>
<html class="no-js" lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Katari | Welcome</title>
  <!-- icon -->
  <link rel="shortcut icon" href="<?php echo constant('URL') ?>icon.png" type="image/x-icon">
  <!-- Estilos foundation -->
  <link rel="stylesheet" href="<?php getrute('utils/foundation/css/foundation.css'); ?>">
  <link rel="stylesheet" href="<?php getrute('utils/foundation/css/foundation-float.css'); ?>">
  <link rel="stylesheet" href="<?php getrute('utils/foundation/css/foundation-prototype.css'); ?>">
  <!-- If you are using the gem version, you need this only -->
  <!-- Motion UI -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />
  <!-- Motion UI end -->
  <!-- Pre-conexion fonts y fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@200;400&display=swap" rel="stylesheet">
  <!-- Pre-conexion fonts y fuentes -->
  <!-- ICONOS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- iconos -->
  <!-- style general -->
  <script src="<?php getrute('utils/foundation/js/jquery.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?php css('app'); ?>">
  <link rel="stylesheet" href="<?php css('sidebar'); ?>">
  <!-- SCRIPTS -->
  <script src="<?php js('app'); ?>"></script>
  <script src="<?php plugin('ajax/crud'); ?>"></script>
  <script src="<?php plugin('dni/dni'); ?>"></script>
  <script src="<?php plugin('helpers/search'); ?>"></script>
  <script src="<?php plugin('helpers/validation'); ?>"></script>
</head>

<body>
  <?php require 'modales.php'; ?>
  <div class="off-canvas-wrapper">
    <div class="off-canvas position-left reveal-for-large sidebar-z" id="offCanvas" data-off-canvas>
      <div class="grid-container nav-z">
        <div class="grid-x align-center margin-top-1">
          <img class="shadow" src="<?php image('chic.jpg') ?>" alt="katari" width="70%">
        </div>
        <hr>
        <div class="grid-x">
          <div class="cell">
            <ul class="vertical menu">
              <li>
                <a href="<?php getrute('personal') ?>">
                  <i class="fas fa-users"></i>
                  <span class="nav-item">Personal</span>
                </a>
              </li>
              <li>
                <a href="<?php getrute('procedimientos') ?>">
                  <i class="fas fa-procedures"></i>
                  <span class="nav-item">Procedimientos</span>
                </a>
              </li>
              <li>
                <a href="<?php getrute('etiquetas') ?>">
                  <i class="fas fa-tag"></i>
                  <span class="nav-item">Etiquetas</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="cell margin-top-3">
            <ul class="vertical menu">
              <li>
                <a href="#">
                  <i class="fas fa-gears"></i>
                  <span class="nav-item">Configuracion</span>
                </a>
              </li>
              <li>
                <a href="<?php getrute('dashboard') ?>">
                  <i class="fa-solid fa-door-open"></i>
                  <span class="nav-item">VOLVER</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="off-canvas-content" data-off-canvas-content>
      <div class="title-bar hide-for-large">
        <div class="title-bar-left">
          <button type="button" class="menu-icon" data-toggle="offCanvas">
          </button>
          <span class="title-bar-title">Admin Panel</span>
        </div>
      </div>
      <!-- MAIN CONTENT ALL -->
      <div class="grid-container full margin-horizontal-3">