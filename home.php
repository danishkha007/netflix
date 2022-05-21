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
$pageTitle="Movies | Netflix Official Site";
require "backend/shared/header.php";
?>
<div class="wrapper">
    <?php require "backend/shared/nav.php" ?>
    <?php echo $preview->createVideoPreview($entity="",$user_id); ?>
    <main class="nm-collections-container">
        <div class="nm-collections-header">
            <h1 class="nm-collections-header-name">Movies</h1>
            <p class="nm-collections-header-description">Movies move us like nothing else can, whether they're scary, funny, dramatic, romantic, or anywhere in-between so many titles, So much to experience.</p>
        </div>
        <?php echo $categoryContainers->getAllCategories(); ?>
    </main>
</div>
<script src="<?php echo url_for('frontend/assets/js/main.js'); ?>"></script>