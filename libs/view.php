<?php

class View
{
  public $data;
  public $mensaje;
  public $response;
  public $css;
  public $layout;

  function __construct()
  {
    #echo "<h1>View Base</h1>";
  }

  function Render($nombre)
  {
    require 'views/' . $nombre . '.php';
  }
}
