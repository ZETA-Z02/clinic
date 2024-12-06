<?php

class Model
{
  protected $conn;
  function __construct()
  {
    #echo "<h1>Model Base</h1>";
    $this->conn = new Conexion();
  }
}
