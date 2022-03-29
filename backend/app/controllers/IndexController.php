<?php
class indexController extends Controller{
    public function __construct(){
        $this->indexModel = $this->model('Index');
    }

    public function defaultMethod(){
        $products = $this->indexModel->popularProducts();
        $slideshow = $this->indexModel->slideshow();
        $data = [
            'products' => $products,
            'slideshow'=> $slideshow,
            'params' => $this->_params
        ];
        $this->view('index/default', $data);
    }
}