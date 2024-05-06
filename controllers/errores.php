<?php

class Errores extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->mensaje ="<br>ERROR, NO SE ENCONTRO LA PAGINA";
        $this->view->render('errores/errores');
        
    }

 

}
?>