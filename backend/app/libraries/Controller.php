<?php
    //load the model and the view
    class Controller{
        protected $_controller;
        protected $_method;
        protected $_params;

        public function model($model){
            if(file_exists('../app/models/' . $model . '.model.php')){
                require_once '../app/models/' . $model . '.model.php';
            }else{
                die("Modal Does Not Exists");
            }
            //istantiate model
            return new $model();
        }

        //load the view (checks for the file)
        public function view($view, $data = []){

            if(file_exists('../app/views/' . $view . '.view.php')){
                require_once '../app/views/' . $view . '.view.php';
            }else{
                die("View Does Not Exists");
            }
        }

        public function Notfound(){
            if(file_exists('../app/views/notfound/default.php')){
                require_once '../app/views/notfound/default.php';
            }else{
                die("404 page not found");
            }
        }


        public function setController($controllerName){
            $this->_controller = $controllerName;
        }
    
        public function setMethod($methodName){
            $this->_method = $methodName;
        }
    
        public function setParams($params){
            $this->_params = $params;
        }
    }