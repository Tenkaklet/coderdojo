<?php
class Actions{
    private $db;

    public function __construct(){
    }

    public function productData($productId){

        require_once("../app/libraries/pquery/pquery.php");
        $dbProfile = new dbconnect('a');
        $request = array
        (
            'methodValues' => Array("products", "*"),

            'JOIN' => array(
                array("categories", "categories.category_id", "=", "#products.product_categoryId"),
            ),
            'WHERE' => array(
                array("product_forSale", "=", "1", "AND"),
                array("product_id", "=", $productId)
            ),
        );
       return ($dbProfile->select($request));

    }
}