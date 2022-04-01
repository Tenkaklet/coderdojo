<?php
define('BASEPATH', true);
require_once("pquery.php");

$test = new dbconnect('a');

$request = array
(
    'methodValues' => Array("products", "products.*", "auth.*"),

    'WHERE' => array(
        array("product_id", "=", "1", "OR"),
        array("product_name", "LIKE", "DDD"),
        //array("coupon_type", "BETWEEN", "gift", "points", "AND"),
        //array("coupons.coupon_type", "IN", "points"),
    ),

    'JOIN' => array(
        array("auth", "auth.auth_id", "=", "#products.product_id"),
    ),

    'orderBy' => array("product_id", "DESC"),
    'groupBy' => array("product_id"),
    'LIMIT' => array("0" , "1"),
);


$test1 = $test->select($request);

print_r($test1);