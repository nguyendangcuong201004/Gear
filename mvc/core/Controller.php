<!-- Create for Extends -->


<?php

class Controller {
    public function model($model){
        require_once "./mvc/models/$model.php";
        return new $model;
    }

    public function view($view, $data=[]){
        extract($data);
        require_once "./mvc/views/$view.php";
    }
}

?>