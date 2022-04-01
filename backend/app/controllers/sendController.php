<?php
class sendController extends Controller{
    public function __construct(){
        $this->sendModal = $this->model('Send');
    }
    public function defaultMethod(){
        echo "wrong request type";
    }
    public function emailMethod(){
        $data = $this->sendModal->email($_SERVER['REQUEST_METHOD']);
        $data = [
            'data' => $data,
            'request_type' => $_SERVER['REQUEST_METHOD'],
            'params' => $this->_params
        ];
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $this->view('send/default', $data);
        }else{
            echo "wrong request type";
        }
    }
    public function smsMethod(){
        $data = $this->sendModal->sms();
        $data = [
            'data' => $data,
            'request_type' => $_SERVER['REQUEST_METHOD'],
            'params' => $this->_params
        ];
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $this->view('send/default', $data);
        }
    }
}