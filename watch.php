<?php
require "backend/init.php";
if(isset($_SESSION['isVerify'])){
    $user_id=$_SESSION['isVerify'];
}else if(isset($_SESSION['userLoggedIn'])){
    $user_id=$_SESSION['userLoggedIn'];
    $verify->authOnly($user_id);
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

if(isset($_GET['videoId'])){
    $videoId=h($_GET['videoId']);
    $video = new Video($videoId);
    if(empty($video)){
        redirect_to(url_for('index'));
    }
    $videoData=$video->videoData();
    $entityId=$videoData['entityId'];
    $posterImageData=$loadFromUser->get("entities",['thumbnail'],array("Id"=>$entityId));
    $posterImage=$posterImageData['thumbnail'];
    $videoPath=$videoData['filePath'];

    $getUpNext=$loadFromVideoProvider->getUpNext($video);
    $upNextdata=$getUpNext->videoData();
    

    $email_data=$loadFromUser->userEmailById($user_id);

    $video->videoViewsCounter();

    
}else{
    redirect_to(url_for('index'));
}
$pageTitle=$videoData['title']." | Netflix Official Site";
require "backend/shared/header.php";
?>
<div class="wrapper">
<?php require "backend/shared/nav.php" ?>
    <div class="watchContainer" data-videoid="<?= $videoData['videoId']; ?>" data-email="<?= $email_data['email']; ?>">
    <section class="videoControls upNext" style="display: none !important;">
        <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>
        <div class="upNextContainer">
            <h2>Up Next :</h2>
            <h3><?php echo $upNextdata['title']; ?></h3>
            <h3><?php echo $getUpNext->displaySeasonAndEpisode(); ?></h3>
            <button class="playNext"  onclick="watchVideo(<?php echo $upNextdata['videoId']; ?>)"><i class="fas fa-play"></i> Play</button>
        </div>
    </section>
        <video controls autoplay poster="<?php echo url_for($posterImage) ?>" onended="showUpNext()" id="player">
            <source src="<?= url_for($videoPath); ?>" type="video/mp4">
        </video>
    </div>
</div>
<script>
    const player = new Plyr("#player");
    window.player=player;
</script>
<script src="<?php echo url_for('frontend/assets/js/main.js'); ?>"></script>