<?php

require_once "../init.php";

if(is_post_request()){
    if(isset($_POST['videoId']) && !empty($_POST['email'])){
        $videoId=h($_POST['videoId']);
        $email=FormSanitizer::sanitizeFormEmail($_POST['email']);

        $video=new Video($videoId);
        $video->watchVideoCompleted($videoId,$email);
        
    }
}