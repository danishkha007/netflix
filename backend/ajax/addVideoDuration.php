<?php

require_once "../init.php";

if(is_post_request()){
    if(isset($_POST['videoId']) && !empty($_POST['email'])){
        $videoId=h($_POST['videoId']);
        $email=FormSanitizer::sanitizeFormEmail($_POST['email']);
        $videoProgressRecord=$loadFromUser->get("videoProgress",["*"],["videoId"=>$videoId,"email"=>$email]);
        if(empty($videoProgressRecord)){
            $lastInserted=$loadFromUser->create("videoProgress",["videoId"=>$videoId,"email"=>$email]);
            
        }
    }
}