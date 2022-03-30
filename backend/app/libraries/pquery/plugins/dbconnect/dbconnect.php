<?php
require_once("dbconf.php");
class dbconnect extends dbconf{
    protected $requestArr;

    private $responseArr = array();

    public function __construct($dbId){
        //it will call the cunstructor of Rest class
        parent::__construct($dbId);
    }


    private function sqlAction($requestArr): array
    {
        $responseData = array();
        try{
            //Connect Database
            $databaseConn = $this->connect;

            $sqlData = $requestArr['sql'];
            $sqlDataValuesArr = $requestArr['dataValues'];
            $requestType = $requestArr['requestType'];
            //print_r($requestArr);
            $sql = $sqlData;
            $stmt = $databaseConn->prepare($sql);

            $stmt->execute($sqlDataValuesArr);

            if($requestType == "INSERT"){
                $returnInsertId = $requestArr['returnInsertId'];
                $responseResult = array(
                    "success" => "The data has been successfully inserted",
                );
                if($returnInsertId){
                    $last_id = $databaseConn->lastInsertId();
                    $last_idArr = array(
                        'InsertId' => $last_id,
                    );
                    $responseResult = array_merge($last_idArr, $responseResult);
                }
                $responseData = $responseResult;
            }elseif($requestType == "UPDATE"){
                $responseResult = array(
                    "success" => "The table has been successfully updated",
                );
                $responseData = $responseResult;
            }elseif($requestType == "DELETE"){
                $responseResult = array(
                    "success" => "The data has been successfully deleted",
                );
                $responseData = $responseResult;
            }
            while ($responseDataFetch = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                if($requestType == "SELECT"){
                    $responseData = $responseDataFetch;
                }
            }

        }catch (Exception $e){
            $this->throwError(INTERNAL_ERROR, $e);
        }


        if(!empty($responseData)){
            //return $responseData;
            return $responseData;
        } else {
            $responseArr = $this->throwError(NO_DATA_FOUND, "No data found");
            return $responseArr;
        }
    }

    //select request
    public function select($request): array
    {
        $from = "";
        $requestedValues = "";
        $sql = "";
        $dataValues = array();
        $response = array();


        if(!isset($request) || !isset($request['methodValues'])){
            $this->throwError(MISSING_DATA, "Request and methodvalues is required and cannot be empty");
        }

        if(!is_array($request)){
            $this->throwError(WRONG_DATA_TYPE, "Request should be type array");
        }

        //check if all requierd data is included in the array
        if(!isset($request['methodValues'][0])){
            $this->throwError(MISSING_DATA, "The FROM data is missing");
        }

        //if there is no data selected then return * (select * from ....)
        if(!isset($request['methodValues'][1])){
            $requestedValues = "*";
        }else{

            //loop through all selected data and store it into $requestedValues as a string
            for ($i = 1; $i < count($request['methodValues']); $i++) {
                $value = $request['methodValues'][$i];
    
                $requestedValues .= " ,".$value;
            }
            //remove the first comma from $requestedValues
            $requestedValues = substr($requestedValues, 2);

        }

        $from = $request['methodValues'][0];

        //main sql
        $sql = "SELECT ".$requestedValues." FROM ".$from;


        if(isset($request['JOIN']) && !empty($request['JOIN'])){
            $join = $request['JOIN'];
            $JOINArray = array();
            $JOINString = "";
 
            try{
                foreach($join as $data) {
                    $joinTable = $data[0];
                    $joinValue1 = $data[1];
                    $operator = $data[2];
                    $joinValue2= "";
                    $joinAndOr = "";

                    //check if there is a AND or OR at the end of join 
                    if(isset($data[4])){
                        $joinAndOr = $data[4];
                    }

                    //check if operator is LIKE
                    if($operator == "LIKE" || $operator == "NOT LIKE"){
                        $joinValue2 = "%$data[3]%";
                    }else{
                        $joinValue2 = "$data[3]";
                    }

                    //if a hashtag found at the begining of the joinValue2
                    //the hashtag refares that the value is inside the database
                    if($data[3][0] == "#"){
                        $joinValue2 = substr($joinValue2, 1);
                        $joinString = $joinTable ." ON ".$joinValue1 ." ".$operator." ".$joinValue2." ".$joinAndOr;
                        array_push($JOINArray, $joinString);
                    }else{
                        $joinString = $joinTable." ON ".$joinValue1 ." ".$operator." ? ".$joinAndOr;
                        array_push($JOINArray, $joinString);
                        array_push($dataValues, $joinValue2);
                    }

                }
                for ($i = 0; $i < count($JOINArray); $i++) {
                    $value = $JOINArray[$i];
                    $JOINString .= " ".$value;
                }
                $sql .= " JOIN ".$JOINString;
            }catch (Exception $e){
                $this->throwError(INTERNAL_ERROR, $e);
            }
        }

        if(isset($request['WHERE']) && !empty($request['WHERE'])){
            $WHERE = $request['WHERE'];
            $whereValue1 = "";
            $whereValue2 = "";
            $WHEREArray = array();
            $WHEREString = "";

            try{
                foreach($WHERE as $data) {
                    $whereValue1 = $data[0];
                    $operator = $data[1];
                    $whereAndOr = "";

                    if(end($data) == "OR" || end($data) == "AND"){
                        $whereAndOr = end($data);
                    }
                    if($operator == "IN" || $operator == "NOT IN"){
                        $questions = "";
                        for ($i = 2; $i < count($data); $i++) {
                            $whereValue2 = $data[$i];

                            if($whereValue2[0] == "#"){
                                $questions .=", ".$whereValue2;
                            }else{
                                $questions .=", ?";
                            }
                            array_push($dataValues, $whereValue2);
                        }
                        $questions = substr($questions, 2);
                        $whereString = $whereValue1 ." ".$operator." (".$questions.") ".$whereAndOr;
                        array_push($WHEREArray, $whereString);
                        //print_r($WHEREArray);

                    }elseif($operator == "BETWEEN" || $operator == "NOT BETWEEN"){
                        $whereValue2 = $data[2];
                        $whereValue3 = $data[3];
                        $whereValue2_a = "?";
                        $whereValue3_a = "?";

                        if($whereValue2[0] == "#"){
                            $whereValue2 = substr($whereValue2, 1);
                            $whereValue2_a = $whereValue2;

                        } 
                        if($whereValue3[0] == "#"){
                            $whereValue2 = substr($whereValue3, 1);
                            $whereValue3_a = $whereValue3;
                        }

                        $whereString = $whereValue1 ." ".$operator." ".$whereValue2_a." AND ".$whereValue3_a." ".$whereAndOr;
                        array_push($dataValues, $whereValue2);
                        array_push($dataValues, $whereValue3);
                        array_push($WHEREArray, $whereString);
                        //print_r($WHEREArray);
                    }else{

                        if($operator == "LIKE" || $operator == "NOT LIKE"){
                            $whereValue2 = "%$data[2]%";
                        }else{
                            $whereValue2 = "$data[2]";
                        }
                        if($data[2][0] == "#"){
                            $whereValue2 = $data[2];
                            $whereValue2 = substr($whereValue2, 1);
                            $whereString = $whereValue1 ." ".$operator." ".$whereValue2." ".$whereAndOr;
                            array_push($WHEREArray, $whereString);
                        } elseif($data[2][0] != "#"){
                            $whereString = $whereValue1 ." ".$operator." ? ".$whereAndOr;
                            array_push($WHEREArray, $whereString);
                            array_push($dataValues, $whereValue2);
                        }
                    }

                }
            }catch (Exception $e){
                $this->throwError(INTERNAL_ERROR, $e);
            }

            //print_r($WHEREArray);

            //convert whereArray to a string
            for ($i = 0; $i < count($WHEREArray); $i++) {
                $value = $WHEREArray[$i];

                $WHEREString .= " ".$value;
            }
            //check if there is and OR or AND at the last of the WHEREString (if exist then delete)
            $WHEREStringPieces = explode(' ', $WHEREString);
            //print_r( $WHEREStringPieces);
            $last_word = array_pop($WHEREStringPieces);

            if(($last_word == "and") || ($last_word == "AND") || ($last_word == "or") || ($last_word == "OR")){
                $WHEREString= preg_replace('/\W\w+\s*(\W*)$/', '$1', $WHEREString);
            }

            $sql .= " "." WHERE ".$WHEREString;

        }


        if(isset($request['groupBy']) && !empty($request['groupBy'])){
            $groupBy = $request['groupBy'];

            $sql .=" "."GROUP BY ".$groupBy[0];

        }
        if(isset($request['orderBy']) && !empty($request['orderBy'])){
            $orderBy = $request['orderBy'];
            $sort = "";
            if (isset($orderBy[1])){
                $sort = $orderBy[1];
            }
            $sql .=" "."ORDER BY ".$orderBy[0]." ". $sort;

        }
        if(isset($request['LIMIT']) && !empty($request['LIMIT'])){
            $limit = $request['LIMIT'];
            $offset = "";
            if (isset($limit[1])){
                $offset = ", ".$limit[1];
            }
            $sql .=" "."LIMIT ".$limit[0]."". $offset;

        }

        //prepare the array to to be excuted
        $dataArrayPrepared = array('sql' => $sql, 'dataValues' => $dataValues, 'requestType' => 'SELECT');
        $requestArr = $dataArrayPrepared;

        array_push($response, $this->sqlAction($requestArr));

        return($this->returnResponse(SUCCESS_RESPONSE, $response));
    }


    //inset request
    public function insert($request): array
    {

        if(!isset($request) || !isset($request['methodValues'])){
            $this->throwError(MISSING_DATA, "Request and methodvalues is required and cannot be empty");
        }

        if(!is_array($request)){
            $this->throwError(WRONG_DATA_TYPE, "Request should be type array");
        }

        //check if all requierd data is included in the array
        if(!isset($request['methodValues']['INTO'])){
            $this->throwError(MISSING_DATA, "INTO Is missing");
        }

        $INTO = $request['methodValues']['INTO'];
        $dataValues = array();
        $requestArr = array();
        $response = array();

        if(empty($INTO)){
            $this->throwError(MISSING_DATA, "INTO cannot be empty");
        }

        for ($i = 0; $i < count($INTO); $i++) {
            if (!isset($request['methodValues']['COL' . $i]) || !isset($request['methodValues']['VALUES' . $i])) {
                $this->throwError(MISSING_DATA, "COL should have a number and starts with 0 (COL0, COL1, COL2 ...)");
            }
            $singleINTO = $INTO[$i];
            $COL = $request['methodValues']['COL' . $i];
            $VALUE = $request['methodValues']['VALUES' . $i];


            $ValueQuestions = str_repeat(", ?", count($VALUE));
            $ValueQuestions = substr($ValueQuestions, 1);

            $tempDataValues = array();
            $colString = "";
            for ($COLi = 0; $COLi < count($COL); $COLi++) {
                $colString .= ", ".$COL[$COLi];
            }
            $colString = substr($colString, 1);

            $tempDataValues = array_merge($tempDataValues, $VALUE);

            array_push($dataValues, $tempDataValues);

            $sql = 'INSERT INTO '.$singleINTO.' ('.$colString.') VALUES ('.$ValueQuestions.')';
            $dataArrayPrepared = array('sql' => $sql, 'dataValues' => $dataValues[$i], 'requestType' => 'INSERT', 'returnInsertId' => $request['returnInsertId']);
            array_push($requestArr, $dataArrayPrepared);
        }
        for ($reqI = 0; $reqI < count($requestArr); $reqI++) {
            array_push($response, $this->sqlAction($requestArr[$reqI]));
        }

        $this->returnResponse(SUCCESS_RESPONSE, $response);
    }


    //update request
    public function update($request): array
    {

        if(!isset($request) || !isset($request['methodValues'])){
            $this->throwError(MISSING_DATA, "Request and methodvalues is required and cannot be empty");
        }

        if(!is_array($request)){
            $this->throwError(WRONG_DATA_TYPE, "Request should be type array");
        }

        //check if all requierd data is included in the array
        if(!isset($request['methodValues']['TABLE'])){
            $this->throwError(MISSING_DATA, "TABLE Is missing");
        }


        $TABLE = $request['methodValues']['TABLE'];
        $dataValues = array();
        $requestArr = array();
        $response = array();



        if(empty($TABLE)){
            $this->throwError(MISSING_DATA, "TABLE cannot be empty");
        }

        for ($i = 0; $i < count($TABLE); $i++) {
            if (!isset($request['methodValues']['SETCOL' . $i]) || !isset($request['methodValues']['SETVALUES' . $i])) {
                $this->throwError(MISSING_DATA, "SETCOL should have a number and starts with 0 (SETCOL0, SETCOL1, SETCOL2 ...)");
            }
            $singleTABLE = $TABLE[$i];
            $SETCOL = $request['methodValues']['SETCOL' . $i];
            $SETVALUES = $request['methodValues']['SETVALUES' . $i];


            //print_r($SETCOL);
            $SETCOLSingleString ="";
            for ($setColi = 0; $setColi < count($SETCOL); $setColi++) {
                $SETCOLSingleString .= ", ".$SETCOL[$setColi]." = ?";
            }
            $SETCOLSingleString = substr($SETCOLSingleString, 1);



            $tempDataValues = array();
            $tempDataValues = array_merge($tempDataValues, $SETVALUES);
            array_push($dataValues, $tempDataValues);


            //If Where
            if(isset($request['methodValues']['WHERE'.$i]) && !empty($request['methodValues']['WHERE'.$i])){
                $WHERE = $request['methodValues']['WHERE'.$i];

                $WHEREArray = array();
                $WHEREString = "";

                foreach($WHERE as $data) {
                    $whereValue1 = $data[0];
                    $operator = $data[1];
                    $whereAndOr = "";

                    if(end($data) == "OR" || end($data) == "AND"){
                        $whereAndOr = end($data);
                    }
                    if($operator == "IN" || $operator == "NOT IN"){
                        $questions = "";
                        for ($i = 2; $i < count($data); $i++) {
                            $whereValue2 = $data[$i];
                            $questions .=", ?";

                            if($data[$i][0] == "#"){
                                $questions .=", ".$whereValue2;
                            }
                            array_push($dataValues[$i], $whereValue2);
                        }
                        $questions = substr($questions, 2);
                        $whereString = $whereValue1 ." ".$operator." (".$questions.") ".$whereAndOr;
                        array_push($WHEREArray, $whereString);
                        //print_r($WHEREArray);

                    }elseif($operator == "BETWEEN" || $operator == "NOT BETWEEN"){
                        $whereValue2 = $data[2];
                        $whereValue3 = $data[3];
                        $whereValue2_a = "?";
                        $whereValue3_a = "?";

                        if($whereValue2[0] == "#"){
                            $whereValue2 = substr($whereValue2, 1);
                            $whereValue2_a = $whereValue2;

                        } elseif($whereValue3[0] == "#"){
                            $whereValue2 = substr($whereValue3, 1);
                            $whereValue3_a = $whereValue3;
                        }

                        $whereString = $whereValue1 ." ".$operator." ".$whereValue2_a." AND ".$whereValue3_a." ".$whereAndOr;
                        array_push($dataValues[$i], $whereValue2);
                        array_push($dataValues[$i], $whereValue3);
                        array_push($WHEREArray, $whereString);
                        //print_r($WHEREArray);
                    }else{
                        if($operator == "LIKE" || $operator == "NOT LIKE"){
                            $whereValue2 = "%$data[2]%";
                        }else{
                            $whereValue2 = "$data[2]";
                        }
                        if($data[2][0] == "#"){
                            $whereValue2 = $data[2];
                            $whereValue2 = substr($whereValue2, 1);
                            $whereString = $whereValue1 ." ".$operator." ".$whereValue2." ".$whereAndOr;
                            array_push($WHEREArray, $whereString);
                        } elseif($data[2][0] != "#"){
                            $whereString = $whereValue1 ." ".$operator." ? ".$whereAndOr;
                            array_push($WHEREArray, $whereString);
                            array_push($dataValues[$i], $whereValue2);
                        }
                    }

                }

                //print_r($WHEREArray);

                for ($whereI = 0; $whereI < count($WHEREArray); $whereI++) {
                    $value = $WHEREArray[$whereI];

                    $WHEREString .= " ".$value;
                }
                //check if there is and OR or AND at the last of the WHEREString (if exist then delete)
                $WHEREStringPieces = explode(' ', $WHEREString);
                //print_r( $WHEREStringPieces);
                $last_word = array_pop($WHEREStringPieces);

                if(($last_word == "and") || ($last_word == "AND") || ($last_word == "or") || ($last_word == "OR")){
                    $WHEREString= preg_replace('/\W\w+\s*(\W*)$/', '$1', $WHEREString);
                }
                $sql = "UPDATE ".$singleTABLE." SET ".$SETCOLSingleString." WHERE".$WHEREString;

            }else{
                $sql = "UPDATE ".$singleTABLE." SET ".$SETCOLSingleString;
            }


            $dataArrayPrepared = array('sql' => $sql, 'dataValues' => $dataValues[$i], 'requestType' => 'UPDATE', 'returnInsertId' => $request['returnInsertId']);
            array_push($requestArr, $dataArrayPrepared);
        }

        for ($reqI = 0; $reqI < count($requestArr); $reqI++) {
            array_push($response, $this->sqlAction($requestArr[$reqI]));
        }
        $this->returnResponse(SUCCESS_RESPONSE, $response);
    }



    //delete request
    public function delete($request): array
    {
        if(!isset($request) || !isset($request['methodValues'])){
            $this->throwError(MISSING_DATA, "Request and methodvalues is required and cannot be empty");
        }

        if(!is_array($request)){
            $this->throwError(WRONG_DATA_TYPE, "Request should be type array");
        }

        //check if all requierd data is included in the array
        if(!isset($request['methodValues']['FROM'])){
            $this->throwError(MISSING_DATA, "FROM Is missing");
        }

        $FROM = $request['methodValues']['FROM'];
        $dataValues = array();
        $requestArr = array();
        $response = array();



        if(empty($FROM)){
            $this->throwError(MISSING_DATA, "FROM cannot be empty");
        }

        for ($i = 0; $i < count($FROM); $i++) {
            $tempDataValues = array();
            array_push($dataValues, $tempDataValues);

            $singleFROM = $FROM[$i];

            //If Where
            if(isset($request['methodValues']['WHERE'.$i]) && !empty($request['methodValues']['WHERE'.$i])){
                $WHERE = $request['methodValues']['WHERE'.$i];
                $WHEREArray = array();
                $WHEREString = "";

                foreach($WHERE as $data) {
                    $whereValue1 = $data[0];
                    $operator = $data[1];
                    $whereAndOr = "";

                    if(end($data) == "OR" || end($data) == "AND"){
                        $whereAndOr = end($data);
                    }
                    if($operator == "IN" || $operator == "NOT IN"){
                        $questions = "";
                        for ($i = 2; $i < count($data); $i++) {
                            $whereValue2 = $data[$i];
                            $questions .=", ?";

                            if($data[$i][0] == "#"){
                                $questions .=", ".$whereValue2;
                            }

                            array_push($dataValues[$i], $whereValue2);
                        }
                        $questions = substr($questions, 2);
                        $whereString = $whereValue1 ." ".$operator." (".$questions.") ".$whereAndOr;
                        array_push($WHEREArray, $whereString);
                        //print_r($WHEREArray);

                    }elseif($operator == "BETWEEN" || $operator == "NOT BETWEEN"){
                        $whereValue2 = $data[2];
                        $whereValue3 = $data[3];
                        $whereValue2_a = "?";
                        $whereValue3_a = "?";

                        if($whereValue2[0] == "#"){
                            $whereValue2 = substr($whereValue2, 1);
                            $whereValue2_a = $whereValue2;

                        } elseif($whereValue3[0] == "#"){
                            $whereValue2 = substr($whereValue3, 1);
                            $whereValue3_a = $whereValue3;
                        }

                        $whereString = $whereValue1 ." ".$operator." ".$whereValue2_a." AND ".$whereValue3_a." ".$whereAndOr;
                        array_push($dataValues[$i], $whereValue2);
                        array_push($dataValues[$i], $whereValue3);
                        array_push($WHEREArray, $whereString);
                        //print_r($WHEREArray);
                    }else{
                        if($operator == "LIKE" || $operator == "NOT LIKE"){
                            $whereValue2 = "%$data[2]%";
                        }else{
                            $whereValue2 = "$data[2]";
                        }
                        if($data[2][0] == "#"){
                            $whereValue2 = $data[2];
                            $whereValue2 = substr($whereValue2, 1);
                            $whereString = $whereValue1 ." ".$operator." ".$whereValue2." ".$whereAndOr;
                            array_push($WHEREArray, $whereString);
                        } elseif($data[2][0] != "#"){
                            $whereString = $whereValue1 ." ".$operator." ? ".$whereAndOr;
                            array_push($WHEREArray, $whereString);
                            array_push($dataValues[$i], $whereValue2);
                        }
                    }

                }

                for ($whereI = 0; $whereI < count($WHEREArray); $whereI++) {
                    $value = $WHEREArray[$whereI];

                    $WHEREString .= " ".$value;
                }
                //check if there is and OR or AND at the last of the WHEREString (if exist then delete)
                $WHEREStringPieces = explode(' ', $WHEREString);
                //print_r( $WHEREStringPieces);
                $last_word = array_pop($WHEREStringPieces);

                if(($last_word == "and") || ($last_word == "AND") || ($last_word == "or") || ($last_word == "OR")){
                    $WHEREString= preg_replace('/\W\w+\s*(\W*)$/', '$1', $WHEREString);
                }
                $sql = "DELETE FROM ".$singleFROM. " WHERE ".$WHEREString;

            }else{
                $sql = "DELETE FROM ".$singleFROM;
            }
            $dataArrayPrepared = array('sql' => $sql, 'dataValues' => $dataValues[$i], 'requestType' => 'DELETE', 'returnInsertId' => $request['returnInsertId']);
            array_push($requestArr, $dataArrayPrepared);
        }

        for ($reqI = 0; $reqI < count($requestArr); $reqI++) {
            array_push($response, $this->sqlAction($requestArr[$reqI]));
        }
        $this->returnResponse(SUCCESS_RESPONSE, $response);
    }


}