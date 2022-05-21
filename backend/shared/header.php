<?php
    if(!isset($pageTitle)){
       $pageTitle="Netflix - Watch TV Shows Online, Watch Movies Online";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="shortcut icon" href="<?= url_for('frontend/assets/images/netflix.ico');?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo url_for('frontend/assets/css/master.css'); ?>">
    <link rel="stylesheet" href="<?php echo url_for('frontend/assets/css/fontawesome.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.2/plyr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.2/plyr.min.js"></script>
    <script src="<?php echo url_for('frontend/assets/lib/jquery.js'); ?>" ></script>
</head>
<body>