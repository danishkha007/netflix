<?php

require_once "../init.php";

if(is_post_request()){
    if(isset($_POST['videoId']) && !empty($_POST['progress'])){
        $videoId=h($_POST['videoId']);
        $email=FormSanitizer::sanitizeFormEmail($_POST['email']);
        $progress=$_POST['progress'];

        $video=new Video($videoId);
        $video->updateVideoDuration($videoId,$email,$progress);
        
    }
}