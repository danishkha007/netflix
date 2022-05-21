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




$pageTitle = "Admin | Category";


?>
<?php require "backend/shared/admin_header.php";

if(is_post_request()){
    if(isset($_POST['submitCategory'])){
        $category =FormSanitizer::sanitizeFormString($_POST['category']);
        if(!empty($category))    {
            $loadFromUser->create('categories',['name'=>$category]);
            $success='<script type="text/javascript">
            swal({
                title: "Good job!",
                text: "Category Added Successfully",
                icon: "success",
                button: "ok",
              });
            </script>';
            echo $success;
        }else{
            $success='<script type="text/javascript">
            swal({
                title: "Error!",
                text: "Field can not be empty. Please enter Category!",
                icon: "error",
                button: "ok",
              });
            </script>';
            echo $success;
        }



    }
    
    if(isset($_POST['updateBtn'])){
        $categoryName =FormSanitizer::sanitizeFormString($_POST['categoryname']);
        $categoryId =FormSanitizer::sanitizeFormString($_POST['categoryid']);
        if(!empty($categoryName))    {
            $loadFromUser->updateCategory('categories',$categoryId,["name"=>$categoryName]);
            $success='<script type="text/javascript">
            swal({
                title: "Good job!",
                text: "Category Updated Successfully",
                icon: "success",
                button: "ok",
              });
            </script>';
            echo $success;
        }else{
            $success='<script type="text/javascript">
            swal({
                title: "Error!",
                text: "Field can not be empty. Please enter Category!",
                icon: "error",
                button: "ok",
              });
            </script>';
            echo $success;
        }



    }
    
    if(isset($_POST['btndelete'])){
        $categoryId =FormSanitizer::sanitizeFormString($_POST['btndelete']);
        if(!empty($categoryId))    {
            $loadFromUser->delete('categories',["id"=>$categoryId]);
            $success='<script type="text/javascript">
            swal({
                title: "Good job!",
                text: "Category Deleted Successfully",
                icon: "success",
                button: "ok",
                });
            </script>';
            echo $success;
        
        }



    }
}



?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Category
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
            <h3 class="box-title">Category Form</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->

        <div class="box-body">
            <form role="form" method="POST" action="<?php echo h($_SERVER['PHP_SELF']) ?>">
            <?php
                if(isset($_POST['btnedit'])){
                    $categoryId=h($_POST['btnedit']);
                    $categoryData=$loadFromUser->get("categories",["*"],["id"=>$categoryId]);
                    
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="hidden" class="form-control" value="<?= $categoryId; ?>"name="categoryid" placeholder="Enter category" >
                            <input type="text" class="form-control" id="category" value="<?= $categoryData['name']; ?>"name="categoryname" placeholder="Enter category" >
                        </div>
                        <button type="submit" class="btn btn-info" name="updateBtn">Update</button>
                    </div>  
                    <?php
                }else{
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="category" name="category" placeholder="Enter category" >
                        </div>
                        <button type="submit" class="btn btn-warning" name="submitCategory">Submit</button>
                    </div>  
                    <?php
                }
            ?>
            
            <div class="col-md-8">
                <table class="table table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CATEGORY</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $categoryContainers->categoryData(); ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer">

            </div> -->
            </form>
        </div>
        <!-- /.box -->
    </div>
        

      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require "backend/shared/admin_footer.php" ?>