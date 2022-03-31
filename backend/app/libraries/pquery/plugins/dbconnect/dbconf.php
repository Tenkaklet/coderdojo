<?php

class dbConf{
    protected $dbId;
    protected $connect;
    public function __construct($dbId){

        $this->dbId = strval($dbId);

        require_once(dirname(__FILE__).'/../../constants.php');
        if (file_exists(dirname(__FILE__).'/../../pquery.ini')){

            $ini = parse_ini_file(dirname(__FILE__).'/../../pquery.ini', true);

            if(!isset($ini['databaseConnection']["profile_".$this->dbId])){
                $this->throwError(DBCONNECT_PROFILE_NOT_FOUND, "DB profile not found");
            }
            $db_name = $ini['databaseConnection']["profile_".$this->dbId]['db_name'];
            $db_host = $ini['databaseConnection']["profile_".$this->dbId]['db_host'];
            $db_userName = $ini['databaseConnection']["profile_".$this->dbId]['db_userName'];
            $db_password = $ini['databaseConnection']["profile_".$this->dbId]['db_password'];

            try {
                $connect = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_userName, $db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
                $connect-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connect = $connect;
    
            }catch(PDOException $e){
                $this->throwError(DBCONNECT_CONNECTION_ERROR, "Database connection error");
            }
        }else{
            $this->throwError(CONFIG_INI_NOT_FOUND, "Config file not found");
        }
    }


    //throw error function
    public function throwError($code, $message){
        $errorMsg = array(['error' => ['status' => $code, 'message' =>$message]]);
        return ($errorMsg);
        exit;
    }

    public function returnResponse($code, $responseData){
        $response = ['response' => ['status' =>$code, "result" => $responseData]];
        return($response);
        exit;
    }
}