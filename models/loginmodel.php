<?php 
class LoginModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function User($usuario){
        $sql = "SELECT * FROM login WHERE username='$usuario';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
}