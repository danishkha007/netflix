<?php

ob_start();

require "config.php";

require "classes/PHPMailer.php";
require "classes/SMTP.php";
require "classes/Exception.php";

//autoload 
spl_autoload_register(function($class){
    require_once "classes/{$class}.php";
});


session_start();



require "functions.php";

$loadFromUser= new User;
$categoryContainers=new CategoryContainers;
$loadFromVideoProvider = new VideoProvider();
$seasonProvider=new SeasonProvider();
$entityContainers=new entityContainers;
$preview=new VideoPreviewProvider();
$verify= new Verify;
$account=new Account;