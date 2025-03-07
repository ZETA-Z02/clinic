<?php 
class OdontogramaModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    public function GetOne($id){
        $sql = "SELECT idcliente,nombre,apellido FROM clientes WHERE idcliente = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function GetPiezaInfo($idcliente, $pieza){
        $sql = "SELECT idodontograma,idprocedimiento,pieza,observaciones,estado,condicion,imagen,feActualizacion FROM odontograma WHERE idcliente = '$idcliente' AND pieza = '$pieza';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function Create($idcliente,$idprocedimiento,$pieza,$observaciones,$estado,$condicion,$imagen){
        $sql = "INSERT INTO odontograma (idcliente,idprocedimiento,pieza,imagen,observaciones,estado,condicion) VALUES ('$idcliente','$idprocedimiento','$pieza','$imagen','$observaciones','$estado','$condicion');";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
    public function Update($idcliente,$idprocedimiento,$pieza,$observaciones,$estado,$condicion,$imagen){
        $sql = "UPDATE odontograma SET idprocedimiento='$idprocedimiento',observaciones='$observaciones',estado='$estado',condicion='$condicion'";
        if(!empty($imagen)){
            $sql .= ",imagen='$imagen'";
        }
        $sql .= "WHERE idcliente = '$idcliente' AND pieza = '$pieza';";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
    public function ColorPieza($idcliente,$pieza){
        $sql = "SELECT p.color FROM odontograma o JOIN procedimientos p ON o.idprocedimiento = p.idprocedimiento WHERE idcliente = '$idcliente' AND pieza = '$pieza';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
}

?>