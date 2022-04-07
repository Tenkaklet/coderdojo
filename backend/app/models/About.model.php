<?php
class About{
    private $db;

    public function __construct(){
    }

    public function allData($lang){
        require_once("../app/libraries/pquery/pquery.php");
        $dbProfile = new dbconnect('a');
        $request = array
        (
            'methodValues' => Array("about", "*"),
        );
        $response = $dbProfile->select($request);
            for($i=0; $i < count($response['data']); $i++){
                if (isset($response['data'][$i]['description'][0])){
                    $DesctiptionData = json_decode(json_encode($response["data"][$i]['description'][0]), true);
                    if(isset($DesctiptionData[$lang])){
                        $response['data'][$i]['description'] = $DesctiptionData[$lang];
                    }else{
                        $response['data'][$i]['description'] = $DesctiptionData['English'];
                    }
                }
            }
       return (json_encode($response, true));
    }
}