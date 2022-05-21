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

if(!isset($_GET['entity'])){
    redirect_to(url_for('home'));
}else{
    $entityId=h($_GET['entity']);
    $entity=new Entity($entityId);
    $entityData=$entity->entityData();
    if(empty($entityData)){
        redirect_to(url_for('index'));
    }

}
$pageTitle=$entityData['name']." | Netflix Official Site";
require "backend/shared/header.php";
?>
<div class="wrapper">
<?php require "backend/shared/nav.php" ?>
    <?php echo $preview->createVideoPreview($entity,$user_id); ?>
    <?php echo $seasonProvider->createSeason($entity); ?>
</div>
<script src="<?php echo url_for('frontend/assets/js/main.js'); ?>"></script>