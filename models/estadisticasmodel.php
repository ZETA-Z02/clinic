<?php 
class EstadisticasModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function get(){
        $sql = "SELECT (SELECT COUNT(idcliente) FROM clientes) AS clientes, (select count(idcita) from citas where current_date() < date(fecha_ini)) AS citas, (SELECT SUM(importe) FROM presupuesto_pagos) AS dinero;";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function GetLine($fecha){
        $sql = "SELECT 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 1 AND YEAR(fecha) = $fecha) as enero, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 2 AND YEAR(fecha) = $fecha) as febrero, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 3 AND YEAR(fecha) = $fecha) as marzo, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 4 AND YEAR(fecha) = $fecha) as abril, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 5 AND YEAR(fecha) = $fecha) as mayo, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 6 AND YEAR(fecha) = $fecha) as junio, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 7 AND YEAR(fecha) = $fecha) as julio, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 8 AND YEAR(fecha) = $fecha) as agosto, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 9 AND YEAR(fecha) = $fecha) as setiembre, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 10 AND YEAR(fecha) = $fecha) as octubre, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 11 AND YEAR(fecha) = $fecha) as noviembre, 
        (SELECT SUM(importe) FROM presupuesto_pagos WHERE MONTH(fecha) = 12 AND YEAR(fecha) = $fecha) as diciembre;";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function GetBarras($fecha){
        $sql = "SELECT 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 1 AND YEAR(feCreate) = '$fecha') as enero, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 2 AND YEAR(feCreate) = '$fecha') as febrero, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 3 AND YEAR(feCreate) = '$fecha') as marzo, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 4 AND YEAR(feCreate) = '$fecha') as abril, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 5 AND YEAR(feCreate) = '$fecha') as mayo, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 6 AND YEAR(feCreate) = '$fecha') as junio, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 7 AND YEAR(feCreate) = '$fecha') as julio, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 8 AND YEAR(feCreate) = '$fecha') as agosto, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 9 AND YEAR(feCreate) = '$fecha') as setiembre, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 10 AND YEAR(feCreate) = '$fecha') as octubre, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 11 AND YEAR(feCreate) = '$fecha') as noviembre, 
        (SELECT COUNT(*) FROM clientes WHERE MONTH(feCreate) = 12 AND YEAR(feCreate) = '$fecha') as diciembre;";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
}