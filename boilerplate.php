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




?>
<?php require "backend/shared/admin_header.php" ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin Dashboard
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
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <?php require "backend/shared/admin_footer.php" ?>