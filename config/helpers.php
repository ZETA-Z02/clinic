<?php 
function getrute($ruta):void{
    echo constant('URL') . $ruta;
}
function image($archivo):void{
    echo constant('URL'). "public/assets/images/" . $archivo;
}
function video($archivo):void{
    echo constant('URL'). "public/assets/video/" . $archivo;
}
function css($name):void{
    echo constant('URL'). "public/css/" . $name . '.css';
}
function js($name):void{
    echo constant('URL'). "public/js/" . $name . '.js';
}
function plugin($name):void{
    echo constant('URL'). "public/plugins/" . $name . '.js';
}
function test($name){
    echo "<script src=".constant('URL'). "public/plugins/" . $name . '.js'."></script>";
}
?>