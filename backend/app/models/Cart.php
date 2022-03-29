<?php
class Cart{

    public function __construct(){
        
    }

    public function getCart(){
        $result = array(
            [
                'product_name' => 'äpple',
                'product_price' => '55'
            ],
            [
                'product_name' => 'äpple',
                'product_price' => '55'
            ]
    );

        return $result;
    }
}