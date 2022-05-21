<?php

require "backend/init.php";
if(isset($_POST['submitButton'])){
    $f_name=$_FILES['fileUpload']['name'];
    $f_tmp=$_FILES['fileUpload']['tmp_name'];
    $f_size=$_FILES['fileUpload']['size'];
    $f_extension=explode('.',$f_name);
    $f_extension=strtolower(end($f_extension));
    $f_newfile=uniqid().'.'.$f_extension;

    // if($f_extension=='jpg'){

    // }else{
    //     echo "File extension is not Supported";
    // }
    // if($f_size>=100){
    //     echo "File size is too large";
    // }else{

    // }
    $store="upload/".$f_newfile;
    // echo $store;
    if(move_uploaded_file($f_tmp,$store)){
        echo "File Uploaded Successfully";
    }
    // echo '<pre>';
    // print_r($_FILES['fileUpload']);
    // echo '</pre>';
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <title>File Upload</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <p><input type="file" name="fileUpload"></p>
        <button type="submit" name="submitButton">File Upload</button>
    </form>
</body>
</html>