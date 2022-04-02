<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mail{
    private function sendAction($actionRequest){


        include 'PHPMailer\src\PHPMailer.php';
        include 'PHPMailer\src\SMTP.php';
        include 'PHPMailer\src\Exception.php';

        echo "Hej från email";

        $subject = $actionRequest['subject'];
        $noHtmlContent = $actionRequest['noHtmlContent'];
        $auth = $actionRequest['auth'];
        $sendTo = $actionRequest['sendTo'];
        $htmlContent = $actionRequest['htmlContent'];
        $attachments = $actionRequest['attachments'];
        

        $ini = parse_ini_file(dirname(__FILE__).'/../../pquery.ini', true);
        $host = $ini['mailAuthProfiles'][$auth]['host'];
        $port = $ini['mailAuthProfiles'][$auth]['port'];
        $username = $ini['mailAuthProfiles'][$auth]['username'];
        $email = $ini['mailAuthProfiles'][$auth]['email'];
        $password = $ini['mailAuthProfiles'][$auth]['password'];
        $CompanyName = $ini['companyInfo']['name'];

        $mail = new PHPMailer;
        $mail->isSMTP(); 
        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = $host; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = $port; // TLS only
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // ssl is depracated
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->setFrom($email, $CompanyName);
        $mail->Subject = $subject;
        $mail->msgHTML($htmlContent); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        $mail->AltBody = $noHtmlContent;



        for ($i = 0; $i < count($sendTo); $i++) {
            $mail->addAddress($sendTo[$i]);
        }
        if(!empty($attachments)){
            for ($i = 0; $i < count($attachments); $i++) {
                $mail->addAttachment($attachments[$i]);
            }
        }


        if(!$mail->send()){
            //return "Mailer Error: " . $mail->ErrorInfo;
            $responseResult_arr = array();
            $responseResult = array(
                "error" => "Request error",
            );
            array_push($responseResult_arr, $responseResult);
            return($responseResult_arr);
            exit();
        }else{
            $responseResult_arr = array();
            $responseResult = array(
                "success" => "Email has been successfully sent",
            );
            array_push($responseResult_arr, $responseResult);
            return($responseResult_arr);
            exit();
        }
    }





    private function templateReq($templateFile, $templateLocation, $templateData){
        $htmlTemplate = file_get_contents($templateLocation.'/'.$templateFile);

        foreach($templateData as $key => $value) {
            $htmlTemplate = str_replace('{*'.$key.'*}', $value, $htmlTemplate);
        }

        return $htmlTemplate;
    }





    public function send($request)
    {
        if(!isset($request)){
            $responseResult_arr = array();
            $responseResult = array(
                "error" => "Request error",
            );
            array_push($responseResult_arr, $responseResult);
            return($responseResult_arr);
            exit();
        }

        if(!isset($request['auth']) || empty($request['auth'])){
            $responseResult_arr = array();
            $responseResult = array(
                "error" => "Request error",
            );
            array_push($responseResult_arr, $responseResult);
            return($responseResult_arr);
            exit();
        }
        if(!isset($request['sendTo']) || empty($request['sendTo'])){
            $responseResult_arr = array();
            $responseResult = array(
                "error" => "Request error",
            );
            array_push($responseResult_arr, $responseResult);
            return($responseResult_arr);
            exit();
        }
        if(!isset($request['mailContent']) || empty($request['mailContent'])){
            $responseResult_arr = array();
            $responseResult = array(
                "error" => "Request error",
            );
            array_push($responseResult_arr, $responseResult);
            return($responseResult_arr);
            exit();
        }

        if(!isset($request['title'])){
            $request['title'] = "";
        }
        if(!isset($request['subject'])){
            $request['subject'] = "";
        }
        

        $subject = $request['subject'];
        $title = $request['title'];
        $auth = $request['auth'];
        $sendTo = $request['sendTo'];
        $mailContent = $request['mailContent'];
        $noHtmlContent = $request['noHtmlContent'];
        $attachments = "";
        $htmlMailContent = "";

        if(isset($request['addAttachment']) || !empty($request['addAttachment'])){
            $attachments = $request['addAttachment'];
        }

        if($mailContent['type'] == "template"){
            $templateFile = $mailContent['file'];
            $templateData = $mailContent['data'];

            $ini = parse_ini_file(dirname(__FILE__).'/../../pquery.ini', true);
            $templateLocation = "";

            if (isset($ini['mailAuthProfiles'][$auth]['templateLocation']) || !empty($ini['mailAuthProfiles'][$auth]['templateLocation'])){
                $templateLocation = $ini['mailAuthProfiles'][$auth]['templateLocation'];
            }elseif(isset($request['templateLocation']) || !empty($request['templateLocation'])){
                $templateLocation = $request['templateLocation'];
            }

            $htmlMailContent = $this->templateReq($templateFile, $templateLocation, $templateData);
            
        }elseif($mailContent['type'] == "custom"){
            $templateHtml = $mailContent['htmlData'];
            $htmlMailContent = $templateHtml;
        }else{
            $responseResult_arr = array();
            $responseResult = array(
                "error" => "Request error",
            );
            array_push($responseResult_arr, $responseResult);
            return($responseResult_arr);
            exit();
        }


        $actionRequest = array(
            "subject" => $subject,
            "noHtmlContent" => $noHtmlContent,
            "auth" => $auth,
            "sendTo" => $sendTo,
            "htmlContent" => $htmlMailContent,
            "attachments" => $attachments,
        );

        //print_r($request['mailContent']['type']);
        //$remplateRes = $this->templateReq();

        $mailAction = $this->sendAction($actionRequest);

        return $mailAction;
    }
}