<?php
class About{
    private $db;

    public function __construct(){
    }

    public function allData(){

        require_once("../app/libraries/pquery/pquery.php");
        $dbProfile = new dbconnect('a');
        $request = array
        (
            'methodValues' => Array("about", "*"),
        );
       return ($dbProfile->select($request));

    }
}