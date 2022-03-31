<?php
class indexController extends Controller{
    public function __construct(){
        //$this->indexModel = $this->model('Index');
    }

    public function defaultMethod(){
        $this->view('index/default');
    }
}