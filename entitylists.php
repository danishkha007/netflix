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


$pageTitle="Admin || Entity Lists";

?>
<?php require "backend/shared/admin_header.php" ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Entity Lists
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
            <!-- general form elements -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Entity Lists</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">
                <table class="table table-striped" id="entityTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Thumbnail</th>
                            <th>Preview</th>
                            <th>CategoryId</th>
                            <th>ViewEntity</th>
                            <th>EditEntity</th>
                            <th>DeleteEntity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $entityContainers->entityData();  ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  
  <?php require "backend/shared/admin_footer.php" ?>