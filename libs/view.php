<?php 

class View{
    function __construct(){
        //echo "<br> vista base";
    }
    function render($nombre){
        require 'views/'.$nombre.'.php';
    }
}

?>