<?php
class AboutController extends Controller{
    public function __construct(){
    }
    
    public function defaultMethod(){
        $data = [
            'title' => 'Home Page',
            'users' => 'ahmad'
        ];
        $this->view('about/default', $data);
    }
}