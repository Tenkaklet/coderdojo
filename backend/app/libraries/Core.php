<?php
    //Core App Class
    class Core{
        protected $_controller = 'index';
        protected $_method = 'default';
        protected $_params = [];

        public function __construct(){
            $this->_parseUrl();
        }


        private function _parseUrl()
        {
            $url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);

            if(isset($url[0]) && $url[0] != ''){
                $this->_controller = $url[0];
            }
            if(isset($url[1]) && $url[1] != ''){
                $this->_method = $url[1];
            }
            if(isset($url[2]) && $url[2] != ''){
                $this->_params = explode('/', $url[2]);
            }
        }


        public function dispatch(){
            $contollerClassName = ucfirst($this->_controller) . 'Controller';
            $methodName = $this->_method . 'Method';

            if(!file_exists('../app/controllers/' . $contollerClassName.'.php')){
                $contollerClassName = 'notfound';
            }
            
            require_once '../app/controllers/' . $contollerClassName . '.php';
            if(!class_exists($contollerClassName)){
                $contollerClassName = "notfound";
            }
            $controller = new $contollerClassName();
            if(!method_exists($controller, $methodName)){
                $this->_method = $methodName = "Notfound";
            }
            $controller->setController($this->_controller);
            $controller->setMethod($this->_method);
            $controller->setparams($this->_params);
            $controller->$methodName();
        }
    }