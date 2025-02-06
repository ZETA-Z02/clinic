<?php 
class EtiquetasModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function Get(){
        $sql = "SELECT e.idetiqueta, e.idpersonal, e.color, e.nombre,CONCAT(p.nombre,' ',p.apellido) as personal FROM etiquetas e JOIN personal p ON p.idpersonal = e.idpersonal;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetOne($id){
        $sql = "SELECT e.idetiqueta, e.idpersonal, e.color, e.nombre,CONCAT(p.nombre,' ',p.apellido) as personal FROM etiquetas e JOIN personal p ON p.idpersonal = e.idpersonal WHERE e.idetiqueta = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function Create($idpersonal,$color,$nombre){
        $sql = "INSERT INTO etiquetas (idpersonal, color, nombre) VALUES ('$idpersonal','$color','$nombre');";
        $response = $this->conn->ConsultaSin($sql);
        return $response;
    }
    public function Update($idetiqueta,$idpersonal,$color,$nombre){
        $sql = "UPDATE etiquetas SET idpersonal = '$idpersonal', color = '$color', nombre = '$nombre' WHERE idetiqueta = '$idetiqueta';";
        $response = $this->conn->ConsultaSin($sql);
        return $response;
    }
    public function GetPersonal(){
        $sql = "SELECT idpersonal, CONCAT(nombre,' ',apellido) as nombres FROM personal;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function Delete($id){
        $sql = "DELETE FROM etiquetas WHERE idetiqueta = '$id';";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
}