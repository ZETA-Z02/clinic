<?php 
class Odontograma extends Controller{
    function __construct(){
        parent::__construct();
    }
    public function render(){
        $this->view->Render('odontograma/index');
    }

}
?>