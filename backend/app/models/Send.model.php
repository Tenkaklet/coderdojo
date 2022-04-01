<?php
class Send{
    private $db;

    public function __construct(){
    }

    public function email($requestType){

        if($requestType == 'POST'){
            require_once("../app/libraries/pquery/pquery.php");
            $mail = new mail();

            $emailContent = '
                <html lang="en">
                <h1>Hi This is a custom html email</h1>
                <p>hej och välkommen till PQuery</p>
                </html>
            ';
            $request = array(
                'auth' => 'profile1',
                'sendTo' => array("ahmadasili1928@gmail.com", "oskar.sjoberg.dev@outlook.com"),
                'subject' => "Hej från Coderdojo",
                'noHtmlContent' =>"No html support",
                'mailContent' => array(
                    "type" => "custom",
                    "htmlData" => "<h1>Hej det är test max</h1>",
                    // "type" => "template",
                    // "file" => "text.html",
                    "data" => array(
                        "title" => "this is a title",
                        "title1" => "this is another title",
                        "contentMain" => "this is main Content",
                        "content" => "this is a content",
                        "imageUrl" => "https://c4.wallpaperflare.com/wallpaper/244/670/404/3d-hd-2560x1440-nice-wallpaper-preview.jpg",
                    ),
                ),
                'addAttachment' => array(dirname(__DIR__).'/PQuery/examples/PQuery.docx'),

            );
        return ($mail->send($request));

        }
    }
}