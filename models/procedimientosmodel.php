<?php 
class ProcedimientosModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function Get():mysqli_result|bool{
        $sql = "SELECT idprocedimiento,procedimiento,descripcion,precio,feCreate FROM procedimientos";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
    }
    public function GetOne($id){
        $sql = "SELECT idprocedimiento,procedimiento,descripcion,precio,iniciales FROM procedimientos WHERE idprocedimiento = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function NuevoProcedimiento($procedimiento,$descripcion,$precio,$iniciales):bool{
        $sql = "INSERT INTO procedimientos (procedimiento,descripcion,precio,iniciales) VALUES ('$procedimiento','$descripcion','$precio','$iniciales');";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
    public function EditarProcedimiento($id,$procedimiento,$descripcion,$precio,$iniciales){
        $sql = "UPDATE procedimientos SET procedimiento = '$procedimiento', descripcion = '$descripcion', precio='$precio', iniciales='$iniciales' WHERE idprocedimiento = '$id';";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
    public function Delete($id){
        $sql = "DELETE FROM procedimientos WHERE idprocedimiento = '$id';";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
}