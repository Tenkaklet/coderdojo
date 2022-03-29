<?php
class User{
    private $db;

    public function __construct(){
    }

    public function getProducts(){

        require_once("../app/libraries/pquery/pquery.php");
        $test = new dbconnect('a');
        $request = array
        (
            'methodValues' => Array("products", "*"),

            // 'WHERE' => array(
            //     array("product_id", "=", "1", "OR"),
            //     array("product_name", "LIKE", "DDD"),
            //     //array("coupon_type", "BETWEEN", "gift", "points", "AND"),
            //     //array("coupons.coupon_type", "IN", "points"),
            // ),

            // 'JOIN' => array(
            //     array("auth", "auth.auth_id", "=", "#products.product_id"),
            // ),

            // 'orderBy' => array("product_id", "DESC"),
            // 'groupBy' => array("product_id"),
            //'LIMIT' => array("0" , "1"),
        );
       return ($test->select($request));

    }
}