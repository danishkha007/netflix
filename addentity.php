<?php require "backend/init.php";
if(isset($_SESSION['isVerify'])){
  $user_id=$_SESSION['isVerify'];
}else if(Login::isLoggedIn()){
  $user_id=Login::isLoggedIn();
  $status=$loadFromUser->get("token",["status"],["user_id"=>$user_id]);
  if($status['status']==1){
      $userid=Login::isLoggedin();
  }else{
      $verify->authOnly($user_id);
  }
}else{
  redirect_to(url_for('index'));
} 



$userData = $loadFromUser->userData($user_id);
if($userData['role']=='Admin'){
  $date_joined=strtotime($userData['joined']);
}else if($userData['role']=='User'){
  redirect_to(url_for('home'));
}


$pageTitle = "Admin | Entity";

?>
<?php require "backend/shared/admin_header.php";
if(is_post_request()) {
    if(isset($_POST['addentity'])){
        $entityName=FormSanitizer::sanitizeFormString($_POST['entityName']);
        $posterImage=$_FILES['posterImage'];
        $videoData=$_FILES['preview'];
        $categoryName=$_POST['selectCategory'];

        $fileInfo=getimagesize($posterImage['tmp_name']);
        $fileTmp=$posterImage['tmp_name'];
        $fileName=$posterImage['name'];
        $fileSize=$posterImage['size'];
        $errors=$posterImage['error'];

        // get extensions 
        $f_extension=explode('.',$fileName);
        $f_extension=strtolower(end($f_extension));



        $allowed_files=array('image/png','image/jpg','image/jpeg');

        if(in_array($fileInfo['mime'],$allowed_files)){
            $folder='frontend/entities/thumbnails/';
            $filePath=$folder.str_shuffle(substr(md5(time().mt_rand().time()),0,25)).'.'.$f_extension;
            if($errors===0){
                if($fileSize <= 101857601){
                    move_uploaded_file($fileTmp,$_SERVER['DOCUMENT_ROOT'].'/netflix/'.$filePath);
                    $fileUploaded=$filePath;
                }else{
                    $imageError='<script type="text/javascript">
                    swal({
                        title: "warning!",
                        text: "File Size is too large",
                        icon: "warning",
                        button: "ok",
                    });
                    </script>';
                    echo $imageError;
                }
            }
        }else{
            $imageError='<script type="text/javascript">
            swal({
                title: "warning!",
                text: "File Extension is not Supported",
                icon: "warning",
                button: "ok",
                });
            </script>';
            echo $imageError;
        }


        $fileTmp_v=$videoData['tmp_name'];
        $fileType_v=$videoData['type'];
        $fileName_v=$videoData['name'];
        $fileSize_v=$videoData['size'];
        $errors_v=$videoData['error'];

        // get extensions 
        $f_extension=explode('.',$fileName_v);
        $f_extension=strtolower(end($f_extension));


        $allowed_video=array('video/mp4');
        
        
        if(in_array($fileType_v,$allowed_video)){
            $folder='frontend/entities/previews/';
            $videoPath=$folder.str_shuffle(substr(md5(time().mt_rand()),2,25)).'.'.$f_extension;
            if($errors_v===0){
                if($fileSize_v <= 101857601){
                    move_uploaded_file($fileTmp_v,$_SERVER['DOCUMENT_ROOT'].'/netflix/'.$videoPath);
                    $videoUploaded=$videoPath;
                }else{
                    $videoError='<script type="text/javascript">
                    swal({
                        title: "warning",
                        text: "File Size is too large",
                        icon: "warning",
                        button: "ok",
                    });
                    </script>';
                    echo $videoError;
                }
            }
        }else{
            $videoError='<script type="text/javascript">
            swal({
                title: "warning!",
                text: "Video Extension is not Supported",
                icon: "warning",
                button: "ok",
                });
            </script>';
            echo $videoError;
        }
        
        
        
        

        if(!isset($imageError) && !isset($videoError)){
            if(isset($entityName) && !empty($entityName) && !empty($posterImage) && !empty($videoData) && !empty($categoryName)){
                $loadFromUser->create('entities',['name'=>$entityName,'thumbnail'=>$fileUploaded,'preview'=>$videoUploaded,'categoryId'=>$categoryName]);
                $success='<script type="text/javascript">
                swal({
                    title: "success!",
                    text: "Entity Data inserted Successfully",
                    icon: "success",
                    button: "ok",
                    });
                </script>';
                echo $success;

            }
        }
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add Entity
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
      | Your Page Content Here |
      -------------------------->
      <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Entity Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
            <form role="form" method="POST" action="<?php echo h($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="entityName">Name</label>
                        <input type="text" class="form-control" id="entityName" name="entityName" placeholder="Enter Entity" required>
                    </div>
                    <div class="form-group">
                        <label for="posterImage">Thumbnail</label>
                        <input type="file" id="posterImage" name="posterImage" >
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="preview">Preview Video</label>
                        <input type="file" id="preview" name="preview">
                    </div>
                    <div class="form-group">
                        <label>Select Category</label>
                        <select class="form-control" name="selectCategory" required>
                            <option value="" disabled Selected>Select Category</option>
                            <?php $categoryData=$loadFromUser->get('categories',["*"]);
                                foreach($categoryData as $cat){
                                    ?>
                                    <option value="<?php echo $cat->id; ?>"><?= $cat->name; ?></option>
                                    <?php
                                }
                                ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-info" name="addentity">Add Entity</button>
            </form>
        </div>
      </div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <?php require "backend/shared/admin_footer.php" ?>