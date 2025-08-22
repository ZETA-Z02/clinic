<?php 
class ClientesModel extends Model{
    function __construct(){
        parent::__construct();
    }
    // OBTENER UN SOLO CLIENTE PARA DETALLES
    public function GetOne($id){
        $sql = "SELECT * FROM clientes WHERE idcliente = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    // Condicion de un solo cliente para detalles
    public function Condicion($id){
        $sql = "SELECT antecedente_enfermedad, antecedente_observacion, medicado, medicado_observacion, complicacion_anestesia, anestesia_observacion, alergia_medicamento, alergiamedicamento_observacion, hemorragias, hemorragias_observacion, enfermedad, observaciones FROM clientes_condicion WHERE idcliente = '$id';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;   
    }
    // OBTENER TODOS LOS CLIENTES
    public function Get(){
        $sql = "SELECT * FROM clientes ORDER BY apellido;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    // Registrar nuevo cliente
    public function NuevoCliente($nombre,$apellido,$dni,$telefono,$direccion){
        try{
            $this->conn->conn->begin_transaction();
            /* INSERTAR CLIENTE */
            $sql = "INSERT INTO clientes (nombre,apellido,dni,telefono,direccion) VALUES ('$nombre','$apellido','$dni','$telefono','$direccion');";
            $result = $this->conn->ConsultaSin($sql);
            $idcliente = $this->conn->conn->insert_id;
            $condicion = "INSERT INTO clientes_condicion (idcliente) VALUES('$idcliente');";
            $result2 = $this->conn->ConsultaSin($condicion);
            $this->conn->conn->commit();
            return $result && $result2;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            error_log("ERROR CLIENTES: " . $e->getMessage());
            throw $e;
        }finally{
            $this->conn->conn->close();
        }
        
    }
    // Verificar CLIENTE PARA NUEVO PAGO PERO SIN REGISTRAR DE NUEVO AL CLIENTE
    public function VerificarCliente($dni){
        $sql = "SELECT idcliente FROM clientes WHERE dni = '$dni';";
        $data = $this->conn->ConsultaArray($sql);
        return $data;
    }
    public function ActualizarCliente($idcliente,$nombre,$apellido,$telefono,$email,$sexo,$ciudad,$direccion,$antecedente, $medicado, $anestesia, $alergiamedicamento, $hemorragias, $enfermedad, $observaciones, $antecedente_observacion, $medicado_observacion, $anestesia_observacion, $alergiamedicamento_observacion, $hemorragias_observacion){
        try{
            $this->conn->conn->begin_transaction();
            $fechaActualizacion = date('Y-m-d H:i:s');
            $fecha = date('Y-m-d');
            $sql = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', telefono = '$telefono', email = '$email', sexo = '$sexo', ciudad = '$ciudad', direccion = '$direccion', feUpdate='$fechaActualizacion' WHERE idcliente = '$idcliente';";
            $result = $this->conn->ConsultaSin($sql);
            $sqlcondicion = "UPDATE clientes_condicion SET antecedente_enfermedad='$antecedente',antecedente_observacion='$antecedente_observacion', medicado='$medicado',medicado_observacion='$medicado_observacion', complicacion_anestesia='$anestesia',anestesia_observacion='$anestesia_observacion', alergia_medicamento='$alergiamedicamento',alergiamedicamento_observacion='$alergiamedicamento_observacion', hemorragias='$hemorragias',hemorragias_observacion='$hemorragias_observacion', enfermedad='$enfermedad',observaciones='$observaciones', feActualizacion='$fecha' WHERE idcliente = '$idcliente';";
            $result1 = $this->conn->ConsultaSin($sqlcondicion);
            $this->conn->conn->commit();
            return $result1 && $result;
        }catch(Exception $e){
            $this->conn->conn->rollback();
            error_log("ERROR CLIENTES: " . $e->getMessage());
            throw $e;
        }finally{
            $this->conn->conn->close();
        }
        
    }
    // CITAS
    public function onecita($id){
        $sql = "SELECT c.idcliente,e.idetiqueta,e.color,c.nombre,ci.idcita, ci.idcliente, ci.titulo, ci.idetiqueta, ci.fecha_ini, ci.hora_ini, ci.fecha_fin,ci.hora_fin FROM citas ci JOIN clientes c ON c.idcliente = ci.idcliente JOIN etiquetas e ON ci.idetiqueta=e.idetiqueta WHERE c.idcliente = '$id';";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
    public function CitasCliente($id){
        $sql = "SELECT fecha_ini, titulo, mensaje, hora_ini FROM citas WHERE idcliente = '$id' ORDER BY fecha_ini DESC;";
        $data = $this->conn->ConsultaCon($sql);
        return $data;
    }
}