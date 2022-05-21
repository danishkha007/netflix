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


$pageTitle = "Admin | Video";

?>
<?php require "backend/shared/admin_header.php";
        function convertVideoToMp4($tempFilePath,$finalFilePath){
            $ffmpegPath=realpath("ffmpeg/bin/ffmpeg.exe");

            $cmd="$ffmpegPath -i $tempFilePath $finalFilePath 2>&1";
            $outputLog=array();
            exec($cmd,$outputLog,$returnCode);
            if($returnCode !=0){
                foreach($outputLog as $line){
                    echo $line."<br>";
                    return false;
                }
            }
            return true;
        }

        function deleteFile($filePath){
            if(!unlink($filePath)){
                echo "Could not delete file \n";
                return false;
            }
            return true;
        }

        function getVideoDuration($filePath){
            $ffprobePath=realpath("ffmpeg/bin/ffprobe.exe");

            return shell_exec("$ffprobePath -v error -select_streams v:0 -show_entries duration -of default=noprint_wrapper=1:nokey=1 -sexagesimal $filePath");

        }
if(is_post_request()) {
    if(isset($_POST['addvideo'])){
        $title=FormSanitizer::sanitizeFormString($_POST['movieName']);
        $movieDescription=FormSanitizer::sanitizeFormString($_POST['movieDescription']);
        $videoData=$_FILES['videoFile'];
        $isMovie=$_POST['selectIsMovie'];
        $releaseDate=$_POST['releaseDate'];
        $entityId=$_POST['selectEntity'];
        $season=FormSanitizer::sanitizeFormString($_POST['season']);
        $episode=FormSanitizer::sanitizeFormString($_POST['episode']);

        $fileTmp_v=$videoData['tmp_name'];
        $fileType_v=$videoData['type'];
        $fileName_v=$videoData['name'];
        $fileSize_v=$videoData['size'];
        $errors_v=$videoData['error'];


        $videoType=pathinfo($fileName_v,PATHINFO_EXTENSION);
        $allowedType=array("mp4","flv","webm","mkv","vob","ogv","ogg","avi","wmv","mov","mpeg","mpg");
        
                // get extensions 
        $f_extension=explode('.',$fileName_v);
        $f_extension=strtolower(end($f_extension));

        if(in_array($videoType,$allowedType)){
            $folder='frontend/entities/videos/';
            $tempFilePath=$folder.str_shuffle(substr(md5(time().mt_rand()),2,25)).'.'.$f_extension;
            if($errors_v===0){
                if($fileSize_v <= 50104857601){
                    if(move_uploaded_file($fileTmp_v,$_SERVER['DOCUMENT_ROOT'].'/netflix/'.$tempFilePath)){
                        $finalFilePath=$folder.str_shuffle(substr(md5(time().mt_rand()),2,25)).'.mp4';
                        if(!convertVideoToMp4($tempFilePath,$finalFilePath)){
                            echo "Something Wrong";
                            return false;
                        }

                        if(!deleteFile($tempFilePath)){
                            echo "file not deleted";
                            return false;
                        }

                        $videoDuration = getVideoDuration($finalFilePath);


                    }
                    // $videoUploaded=$videoPath;
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








        
        
        
        
        if(!isset($videoError)){
            // if(isset($entityName) && !empty($entityName) && !empty($posterImage) && !empty($videoData) && !empty($categoryName)){
            $lastedId=$loadFromUser->create('videos',['title'=>$title,'description'=>$movieDescription,'filePath'=>$finalFilePath,'isMovie'=>$isMovie,'releaseDate'=>$releaseDate,'duration'=>date("H:i:s",strtotime($videoDuration)),"season"=>$season,"episode"=>$episode,"entityId"=>$entityId]);
            if($lastedId){
                $success='<script type="text/javascript">
                swal({
                    title: "success!",
                    text: "Video Data inserted Successfully",
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
      Add Video
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
            <h3 class="box-title">Video Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
            <form role="form" method="POST" action="<?php echo h($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="movieName">Title</label>
                        <input type="text" class="form-control" id="movieName" name="movieName" placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <label for="movieDescription">Description</label>
                        <textarea class="form-control" rows="5" id="movieDescription" name="movieDescription" placeholder="Enter Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="videoFile">Video</label>
                        <input type="file" id="videoFile" name="videoFile" >
                    </div>
                    <div class="form-group">
                        <label>Select isMovie</label>
                        <select class="form-control" name="selectIsMovie" required>
                            <option value="" disabled Selected>Select isMovie</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info" name="addvideo">Add Video</button>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="releaseDate">Release Date</label>
                        <input type="date" id="releaseDate" name="releaseDate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="season">Season</label>
                        <input type="text" id="season" name="season" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="episode">Episode</label>
                        <input type="text" id="episode" name="episode" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Select EntityId</label>
                        <select class="form-control" name="selectEntity" required>
                            <option value="" disabled Selected>Select Entity</option>
                            <?php $entityData=$loadFromUser->get('entities',["*"]);
                                foreach($entityData as $cat){
                                    ?>
                                    <option value="<?php echo $cat->Id; ?>"><?= $cat->name; ?></option>
                                    <?php
                                }
                                ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
      </div>
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <?php require "backend/shared/admin_footer.php" ?>