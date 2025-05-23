<?php
session_start();
class App
{
  function __construct()
  {
    #echo "<p>Nueva APP</p>";
    @$url = $_GET['url'];
    @$url = rtrim($url, '/');
    @$url = explode('/', $url);

    if (@$_SESSION['katari']) {
      #echo "Inicio de session";
      if (empty($url[0])) {
        $archivoController = "controller/dashboard.php";
        require_once $archivoController;
        $controller = new Dashboard;
        $controller->loadModel('dashboard');
        $controller->render();
        return false;
      }

      #echo "con parametros";
      $archivoController = "controller/" . $url[0] . ".php";

      if (file_exists($archivoController)) {
        #echo "Si existe";
        require_once $archivoController;
        $controller = new $url[0];
        $controller->loadModel($url[0]);

        # numero de elementos del arreglo
        $nparam = sizeof($url);

        if ($nparam > 1) {
          if ($nparam > 2) {
            $param = [];
            for ($i = 2; $i < $nparam; $i++) {
              array_push($param, $url[$i]);
            }
            $controller->{$url[1]}($param);
          } else {
            $controller->{$url[1]}();
          }
        } else {
          $controller->render();
        }
      } else {
        #echo "no existe";
        require "controller/error.php";
        $controller = new ErrorGeneral();
        $controller->render();
      }
    } else {
      // ZETA CAMBIO----------------para que redireccione a inicio====
      if (empty($url[0])) {
        #echo "URL vacia";
        $archivoController = "controller/login.php";
        require_once $archivoController;
        $controller = new Login;
        $controller->loadModel('login');
        $controller->render();
        return false;
      }
      // ZETA CAMBIO-END---------------
      #echo "Segundo: ".$url[1];
      if (isset($url[1]) && $url[1] == "user") {
        $archivoController = "controller/login.php";
        require_once $archivoController;
        $controller = new Login;
        $controller->loadModel('login');
        $controller->user();
        //$controller->render();
      } else {
        #echo "nada";
        header("location: " . constant('URL'));
      }
    }
  }

}



