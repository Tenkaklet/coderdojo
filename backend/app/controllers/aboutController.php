<?php
class aboutController extends Controller{
    public function __construct(){
        $this->aboutModal = $this->model('About');
    }

    public function defaultMethod(){
        $allData = $this->aboutModal->allData();
        $data = [
            'allData' => $allData,
            'params' => $this->_params
        ];
        $this->view('about/default', $data);
    }
}