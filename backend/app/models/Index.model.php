<?php
class Index{
    private $db;

    public function __construct(){
    }

    public function popularProducts(){

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
                array("product_CategoryId", "=", "1")
            ),

            'orderBy' => array("product_total_viewed", "DESC"),
        );
       return ($dbProfile->select($request));

    }

    public function slideshow(){

        require_once("../app/libraries/pquery/pquery.php");
        $dbProfile = new dbconnect('a');
        $request = array
        (
            'methodValues' => Array("slideshow", "*"),
        );
       return ($dbProfile->select($request));

    }
}