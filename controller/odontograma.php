<?php 
class Odontograma extends Controller{
    function __construct(){
        parent::__construct();
    }
    public function render($npam=null){
        // ID DEL CLIENTE
        $this->view->data = $this->model->GetOne($npam[0]);
        $this->view->Render('odontograma/index');
    }
    public function InfoPieza(){
        $idcliente = $_POST['idcliente'];
        $pieza = $_POST['pieza'];
        $data = $this->model->GetPiezaInfo($idcliente,$pieza);
        if($data){
            echo json_encode($data);
        }else{
            echo 0;
        }
    }
    public function create(){
        $idcliente = $_POST['idcliente'];
        $idprocedimiento = $_POST['procedimiento'];
        $pieza = $_POST['pieza'];
        $observaciones = $_POST['observaciones'];
        $estado = $_POST['estado'];
        $condicion = $_POST['condicion'];
        $nombre = $this->model->GetOne($idcliente);
        $nombre = explode(' ',$nombre['nombre'])[0];
        $imagen = $_FILES['imagen'];
        if($imagen){
            $rutaResult = $this->foto($imagen,$nombre,$pieza);
        }
        if(empty($imagen)){
            $rutaResult = true;
        }
        if($rutaResult){
            //echo 'ok';
            if($this->model->Create($idcliente,$idprocedimiento,$pieza,$observaciones,$estado,$condicion,$rutaResult)){
                echo "ok";
            }else{
                throw new Exception("Error al crear el odontograma");
            }
        }else{
            throw new Exception("Error al subir la foto al servidor");
        }
    }
    public function update(){
        $idcliente = $_POST['idcliente'];
        $idprocedimiento = $_POST['procedimiento'];
        $pieza = $_POST['pieza'];
        $observaciones = $_POST['observaciones'];
        $estado = $_POST['estado'];
        $condicion = $_POST['condicion'];
        $imagen = $_FILES['imagen'];
        $nombre = $this->model->GetOne($idcliente);
        $nombre = explode(' ',$nombre['nombre'])[0];
        if($imagen){
            $rutaResult = $this->foto($imagen,$nombre,$pieza);
        }
        if(empty($imagen)){
            $rutaResult = true;
        }
        if($rutaResult){
            //echo 'ok';
            if($this->model->Update($idcliente,$idprocedimiento,$pieza,$observaciones,$estado,$condicion,$rutaResult)){
                echo "ok";
            }else{
                throw new Exception("Error al actualizar el odontograma");
            }
        }else{
            throw new Exception("Error al subir la foto al servidor");
        }
    }
    public function colorPieza(){
        $idcliente = $_POST['idcliente'];
        $idpieza = $_POST['pieza'];
        $data = $this->model->ColorPieza($idcliente,$idpieza);
        if($data){
            echo json_encode($data);
        }else{
            echo 0;
        }
    }

}
?>