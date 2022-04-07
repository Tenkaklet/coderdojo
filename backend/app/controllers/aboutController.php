<?php
class aboutController extends Controller{
    public function __construct(){
        $this->aboutModal = $this->model('About');
    }

    public function defaultMethod(){
        $lang = "";
        if((isset(getallheaders()["lang"])) && (!empty(getallheaders()["lang"]))){
            $lang = getallheaders()["lang"];
        }else{
            $lang = "English";
        }
        //echo $lang;
        $allData = $this->aboutModal->allData($lang);
        $data = [
            'getData' => $allData,
            'request_type' => $_SERVER['REQUEST_METHOD'],
            'params' => $this->_params
        ];
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $this->view('about/get', $data);
        }else if($_SERVER['REQUEST_METHOD'] == "POST"){
            $this->view('about/post', $data);
        }
    }
}