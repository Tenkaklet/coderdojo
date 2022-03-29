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


        // public function getUrl(){
        //     if(isset($_GET['url'])){
        //         $url = rtrim($_GET['url'], '/');
        //         //allows you to filter variables as string/int
        //         $url = filter_var($url, FILTER_SANITIZE_URL);
        //         //breaking it into array
        //         $url = explode('/', $url);

        //         return $url;
        //     }
        // }

        // public function __construct(){
        //     $url = $this->getUrl();

        //     if (empty($url)) {
        //         $url[0] = "";
        //     }

        //     if(isset($url[0]) && !empty($url[0])){
        //         //Look in controllers for first value, ucwords will capitalize first letter
        //         //echo ucwords($url[0]);
        //         if(file_exists('../app/controllers/' . ucwords($url[0]).'Controller.php')){
        //             //will set a new controller
        //             $this->currentController = ucwords($url[0]).'Controller';
        //             unset($url[0]);
        //         }else{
        //             $this->currentController = ucwords("notfoundController");
        //         }

        //     }

        //     //check for second part of the url
        //     if(isset($url[1]) && !empty($url[1])){
        //         if(method_exists($this->currentController, $url[1]."Method")){
        //             $this->currentMethod = $url[1]."Method";
        //             unset($url[1]);
        //         }else{
        //             $this->currentController = ucwords("notfoundController");
        //         }
        //     }

        //     //require the controller
        //     require_once '../app/controllers/' . $this->currentController . '.php';
        //     $this->currentController = new $this->currentController;

        //     //Get parameters
        //     $this->params = $url ? array_values($url) : [];


        //     echo $url[1]."Method";
        //     $this->currentController->setController($this->currentController);
        //     $this->currentController->setMethod($this->currentMethod);
        //     $this->currentController->setparams($this->params);

        //     $method = $this->currentMethod;
        //     $this->currentController->$method();
        // }
    }