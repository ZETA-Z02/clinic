<?php 
class DashboardModel extends Model{
    function __construct(){
        parent::__construct();
    }
    public function get(){
        $sql = "Consulta sql";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
}