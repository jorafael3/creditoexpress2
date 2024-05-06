<?php 


class Controller{
    function __construct(){

       // echo "<br>controlador base";
        $this->view = new View();
        //$this->logmodel = new LogModel();
    }

    function loadModel($model){
        
        $url = 'models/'.$model.'model.php';
        //echo $url;
        if(file_exists($url)){
            require_once $url;
            
            $modelName = $model.'Model';
            $this->model = new $modelName();
            
        }else{
        }

    }
}

?>