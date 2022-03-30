<?php
class Notfound extends Controller{
    public function __construct(){

    }

    public function defaultMethod(){
        $this->view('notfound/default');
    }
}