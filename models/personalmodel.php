<?php 
class PersonalModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function Get():mysqli_result|bool{
        $sql = "SELECT idpersonal, nombre, apellido, dni, telefono FROM personal;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function GetPersonal($id){
        $sql = "SELECT idpersonal, nombre, apellido, dni, telefono, sexo, email, foto, fechaNac, feCreate, feUpdate FROM personal WHERE idpersonal = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function GetLogin($id){
        $sql = "SELECT l.idlogin, l.idpersonal, l.username, l.password, l.estado, l.nivel, p.nombre FROM login l JOIN personal p ON l.idpersonal = p.idpersonal WHERE l.idpersonal = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function NuevoPersonal($dni,$telefono,$nombre,$apellido,$username,$password,$etiqueta,$color){
        try{
            $this->conn->conn->begin_transaction();
            $sqlpersonal = "INSERT INTO personal (nombre,apellido,dni,telefono) VALUES ('$nombre','$apellido','$dni','$telefono');";
            $resultpersonal = $this->conn->ConsultaSin($sqlpersonal);
            $idpersonal = $this->conn->conn->insert_id;
            $sqllogin = "INSERT INTO login (idpersonal,username,password) VALUES ('$idpersonal','$username','$password');";
            $resultlogin = $this->conn->ConsultaSin($sqllogin);
            $sqletiqueta = "INSERT INTO etiquetas (idpersonal, color, nombre) VALUES ('$idpersonal','$color','$etiqueta');";
            $resultetiqueta = $this->conn->ConsultaSin($sqletiqueta);
            $this->conn->conn->commit();
            $result = $resultpersonal && $resultlogin && $resultetiqueta;
            return $result;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            error_log("ERROR PERSONAL: " . $e->getMessage());
            throw $e;
        }finally{
            $this->conn->conn->close();
        }
    }
    public function ActualizarPersonal($id,$telefono,$sexo,$email,$fechanacimiento,$ruta){
        $fechaupdate = date("Y-m-d");
        if(empty($fechanacimiento)){
            $fechanacimiento = date("Y-m-d");
        }
        $sql = "UPDATE personal SET telefono = '$telefono', sexo = '$sexo', email = '$email', fechaNac = '$fechanacimiento', feUpdate = '$fechaupdate', foto='$ruta' WHERE idpersonal = '$id';";
        $result = $this->conn->ConsultaSin($sql);
        return $result;
    }
    public function ActualizarLogin($id,$username,$password,$estado,$nivel){
        $sqlpsw = "";
        if(!empty($password)){
            $sqlpsw = ", password = '$password'";
        }
        $sql = "UPDATE login SET username = '$username', estado = '$estado', nivel = '$nivel' ". $sqlpsw . " WHERE idpersonal = '$id';";
        
        $result = $this->conn->ConsultaSin($sql);
        return $result;

    }
}