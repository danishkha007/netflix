<?php

function is_post_request(){
    return $_SERVER['REQUEST_METHOD']==='POST';
}
function is_get_request(){
    return $_SERVER['REQUEST_METHOD']==='GET';
}
function h($string=""){
    return htmlspecialchars($string);
}
function u($string=""){
    return urlencode($string);
}
function net_copyright($startYear){
    $currentYear = date('Y');
    if($startYear < $currentYear){
        return "&copy; $startYear &ndash; $currentYear";
    }else {
        return "&copy; $startYear";
    }
}
function log_out_user(){
    unset($_SESSION['isVerify']);
    session_destroy();
    return true;
}
function url_for($script){
    return WWW_ROOT.$script;
}
function redirect_to($location){
    header("Location:".$location);
    exit;
}
function getInputValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}
?>