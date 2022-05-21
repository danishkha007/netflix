<?php
require_once "backend/init.php";

if(Login::isLoggedIn()){
    $user_id=Login::isLoggedIn();
}else if(isset($_SESSION['isVerify'])){
    log_out_user();
    redirect_to(url_for("index"));
}else{
    redirect_to(url_for("index"));
}

$loadFromUser->delete('token',array('user_id'=>$user_id));

if(isset($_COOKIE['FBID'])){
    unset($_COOKIE['FBID']);
    header('Refresh:0');
}