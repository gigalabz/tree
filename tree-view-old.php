<?php 
    define('mysite',true);
    include 'auth.php';
    include 'userInformation.php';
    $pageTitle = 'Tree View';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?= $siteName ?> | <?= ucwords($pageTitle) ?> </title>
    <meta name="Description" content="">
    <meta name="Author" content="">
	<meta name="keywords" content="">
    
    <!-- Favicon -->
    <link rel="icon" href="assets/images/brand-logos/favicon.png" type="image/x-icon">
    
    <!-- Choices JS -->
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Main Theme Js -->
    <script src="assets/js/main.js"></script>
    
    <!-- Bootstrap Css -->
    <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >

    <!-- Style Css -->
    <link href="assets/css/styles.css" rel="stylesheet" >
    <link href="assets/css/my.css" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="assets/css/icons.css" rel="stylesheet" >
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" >

    <!-- Node Waves Css -->
    <link href="assets/libs/node-waves/waves.min.css" rel="stylesheet" > 

    <!-- Simplebar Css -->
    <link href="assets/libs/simplebar/simplebar.min.css" rel="stylesheet" >
    
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="assets/libs/@simonwep/pickr/themes/nano.min.css">

    <!-- Choices Css -->
    <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet" href="assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css">

    <link rel="stylesheet" href="tree/hierarchy-view.css" type="text/css" media="all">
    <link rel="stylesheet" href="tree/main.css" type="text/css" media="all">


</head>

<body class='main-body'>
                <!-- Loader -->
                <div id="loader" >
                    <img src="assets/images/media/loader.svg" alt="">
                </div>
                <!-- Loader -->

                <div class="container-fluid" style="margin-bottom:100px;">

                    <div class="row d-flex flex-column">

                        <div class="col-md-5 pb-2 mx-auto buyPkgTop"  style="border-bottom: 3px solid #FF9B1A;">

                            <div class='col-12'>

                                <div class="row">
                                    <div class="col-12">
                                        <div class='d-flex justify-content-center align-items-center'>
                                            <h5 class='text-warning buyPkgTitle'>Tree Structure</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="col-md-5 mx-auto" id="network">
                            <div class='bg-tree-box rounded-3' id="network-main">

                                <!-- code here  -->

                                <?php


// search code tree

if(isset($_POST['search']))
{
    $searchUser = strtolower(mysqli_real_escape_string($con,$_POST['search_text']));
    $select    = "SELECT * FROM  tree WHERE user_name = '$searchUser'";
    $res       = mysqli_query($con, $select);
    $tree_data = mysqli_fetch_array($res);
    
    $placed_user_name = $tree_data['placed_user_name'];
    $randomy = $tree_data['random'];
    
    if($placed_user_name == $user_name)
    {
        header("Location: tree-structure?user_name=$randomy");
        exit();
    }
    $uname3 = $placed_user_name;
    $iteration = 1;
    while ($placed_user_name != null) {
        $select           = "SELECT * FROM tree WHERE user_name='$uname3'";
        $run              = mysqli_query($con, $select);
        $data             = mysqli_fetch_array($run);
        $placed_user_name = $data['placed_user_name'];
        //$user_name        = $data['user_name'];
       
       if($placed_user_name == $user_name)
        {
            header("Location: tree-structure?user_name=$randomy");
            exit();
        }
        
        $uname3 = $placed_user_name;
    }
    
    
    
    $_SESSION['errorMsg'] = 'User does not exist in this tree';
    header("Location: binary-view");
    exit();
    
}


//search code tree end



// Tree Code PHP

 if (isset($_GET['user_name']) and $_GET['user_name']!='') {
    
    $select = "select * from tree where random = '".$_GET['user_name']."'";
    $res = mysqli_query($conn, $select);
    $data = mysqli_fetch_array($res);
    $user_name=$data['user_name'];
    $random=$data['random'];
    
  }
  else{
    $user_name=$_SESSION['user_name'];
    $select="select * from tree where user_name='$user_name'";
    $res=mysqli_query($conn,$select);
    $tree_data=mysqli_fetch_array($res);
    $random=$tree_data['random'];
  }
    $select = "select * from tree where left_user = '".$user_name."' or right_user = '".$user_name."'";
    $res = mysqli_query($conn, $select);
    $data = mysqli_fetch_array($res);
    $up=$data['random'];

$select="select * from tree where user_name='$user_name'";
$res=mysqli_query($conn,$select);
if (!$res) {
   mysqli_error($conn);
}
$tree_user=mysqli_fetch_array($res);


$select="select * from tree where user_name='".$tree_user['left_user']."'";
$res=mysqli_query($conn,$select);
if (!$res) {
   mysqli_error($conn);
} 
$tree_user_left=mysqli_fetch_array($res);
$random1=$tree_user_left['random'];

$select="select * from tree where user_name='".$tree_user['right_user']."'";
$res=mysqli_query($conn,$select);
if (!$res) {
   mysqli_error($conn);
}
$tree_user_right=mysqli_fetch_array($res);
$random4=$tree_user_right['random'];

$select="select * from tree where user_name='".$tree_user_left['left_user']."'";
$res=mysqli_query($conn,$select);
if (!$res) {
   mysqli_error($conn);
}
$tree_user_leftl=mysqli_fetch_array($res);
$random2=$tree_user_leftl['random'];

$select="select * from tree where user_name='".$tree_user_left['right_user']."'";
$res=mysqli_query($conn,$select);
if (!$res) {
   mysqli_error($conn);
}
$tree_user_leftr=mysqli_fetch_array($res);
$random3=$tree_user_leftr['random'];

$select="select * from tree where user_name='".$tree_user_right['left_user']."'";
$res=mysqli_query($conn,$select);
if (!$res) {
   mysqli_error($conn);
}
$tree_user_rightl=mysqli_fetch_array($res);
$random5=$tree_user_rightl['random'];

$select="select * from tree where user_name='".$tree_user_right['right_user']."'";
$res=mysqli_query($conn,$select);
if (!$res) {
   mysqli_error($conn);
}
$tree_user_rightr=mysqli_fetch_array($res);
$random6=$tree_user_rightr['random'];

// End Tree Code PHP

?>
<style>
p.name {
    background-color: #f6f7fb;
    padding:1px 1px;
    border-radius: 3px;
    font-size: 14px;
    font-weight: 400;
    color: #607D8B;
    margin: 0;
    position: relative;
}
.person img{
    cursor:pointer;
}
.hv-item-parent .modal-body p {
    font-weight: normal;
}
.management-hierarchy{background:transparent !important;}
.modal-dialog{margin-top:200px!important;}
</style>
<div class="main-panel container">
          <div class="content-wrapper ">
             
              				<!-- page-header -->
 
				
            <div class="row justify-content-end">
                <div class="col-lg-4 col-md-6">
                    
                </div>
            </div>
 <?php
 $cusername = $user_name;
while($cusername != "")
  {
      
    $nusername = $cusername;
    $select = "select * from tree where user_name = '".$cusername."'";
    $res = mysqli_query($conn, $select);
    $data = mysqli_fetch_array($res);
    $cusername = $data['right_user'];
    $right_most=$data['random'];
    
    if($cusername == Null)
    {
      break;
    }

  }
  
  $cusername = $user_name;
  while($cusername != "")
  {
      
    $nusername = $cusername;
    $select = "select * from tree where user_name = '".$cusername."'";
    $res = mysqli_query($conn, $select);
    $data = mysqli_fetch_array($res);
    $cusername = $data['left_user'];
    $left_most=$data['random'];
    
    if($cusername == Null)
    {
      break;
    }

  }
  
 
?>           
            
            <!--buttons-->
            <div class="">
                <?php if(isset($_SESSION['successMsg'])): ?>
                                    <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2 mt-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-white" style="font-size:35px;padding-right:10px"><i class='mdi mdi-close-box'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-white">Success </h6>
                                                <div class="text-white"><?php echo $_SESSION['successMsg']; ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php  unset($_SESSION['successMsg']);     endif;  ?>

                                    
                                    <?php if(isset($_SESSION['errorMsg'])): ?>
                                    <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2 mt-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-white" style="font-size:35px;padding-right:10px"><i class='mdi mdi-close-box'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-white">Error </h6>
                                                <div class="text-white"><?php echo $_SESSION['errorMsg']; ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php  unset($_SESSION['errorMsg']);     endif;  ?>
                    <div class="row align-items-center justify-content-center">
                    <div class="col-lg-2 col-6 mb-2"><a href="tree-structure?user_name=<?php echo $left_most ?>" class="btn btn-primary w-100 btn-round"> Last Left</a></div>
                    <div class="col-lg-2 col-6 mb-2"><a href="tree-structure?user_name=<?php echo $right_most ?>" class="btn btn-primary w-100 btn-round">Last Right</a></div>
                    <div class="col-lg-2 col-6 mb-2"><a href="tree-structure" class="btn btn-primary w-100 btn-round">Top User</a></div>
                    <div class="col-lg-2 col-6 mb-2"><a href="#" class="btn btn-primary w-100 btn-round">1 Level Up</a></div>
                    <div class="col-lg-4 col-12 mb-2">
                    <form method="post">
                    <div class="form-group mb-0">
                      <div class="input-group">
                        <input type="text" class="form-control" name="search_text" placeholder="Enter username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <span class="input-group-btn">
                        </div>
                          <button class="btn btn-sm btn-primary" name="search" type="submit">Search</button>
                        
                      </div>
                    </div>
                    </form>
                    </div>
                    </div>
                  </div>
            
            <!--Section-->
            <section class="management-hierarchy" id="tree" >
        <div class="hv-container">
            <div id="wrapper" class="hv-wrapper pt-0 pb-5">

                <!-- Key component -->
                <div id="container" class="hv-item">

                    <div class="hv-item-parent">
                        <div class="person">
                            <img style="height:80px;width:80px;"  src="img/faces/tree-avatar.png" alt="user" data-toggle="modal" data-target="#exampleModal" data-toggle="popover" data-trigger="hover"  data-content="Left Team <?php echo $tree_user['left_count'] ?> ... Right Team <?php echo $tree_user['right_count'] ?> " onclick="removeModelBlur()" >
                            
                            <!-- Modal Start-->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">
                                    <h5 class="modal-title text-light text-capitalize" id="exampleModalLabel" style="margin:auto;"><?php echo $tree_user['user_name'] ?></h5>
                                    <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>-->
                                  </div>
                                  <div class="modal-body" background="background: #E2FAFF;">
                                    <p class="text-dark"><b>Left Points</b>: <?= $tree_user['left_points']?></p>
                                     <p class="text-dark"><b>Right Points</b>: <?= $tree_user['right_points']?></p>
                                  </div>
                                  <div class="modal-footer" background="background: #E2FAFF;">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--Modal End-->
                            
                            <p class="name">
                                <?php echo ucfirst($user_name) ?>
                            </p>
                        </div>
                    </div>

                    <div class="hv-item-children">

                        <div class="hv-item-child">
                            <!-- Key component -->
                            <div class="hv-item">

                                <div class="hv-item-parent">
                                    
                                    <div class="person">
                                        <img style="height:80px;width:80px;"  src="img/faces/tree-avatar.png" data-toggle="modal" data-target="#exampleModal1" alt="user"
                                        data-toggle="popover" data-trigger="hover"  data-content="Left Team <?php echo $tree_user_left['left_count'] ?> ... Right Team <?php echo $tree_user_left['right_count'] ?> " onclick="removeModelBlur()" >
                                        
                                        <!-- Modal Start-->
                                        <?php
                                        if ($tree_user['left_user']!='') {
                                            ?>
                                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">
                                    <h5 class="modal-title text-light text-capitalize text-center" id="exampleModalLabel" style="margin:auto;"><?php echo $tree_user_left['user_name'] ?></h5>
                                    <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>-->
                                  </div>
                                  <div class="modal-body" background="background: #E2FAFF;margin:auto;">
                                    <p class="text-dark"><b>Left Points</b>: <?= $tree_user_left['left_points']?></p>
                                     <p class="text-dark"><b>Right Points</b>: <?= $tree_user_left['right_points']?></p>                                     
                                  </div>
                                  <div class="modal-footer" background="background: #E2FAFF;">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                                        <?php    }
                                        ?>
                                        <!--Modal End-->
                                        
                                        <a style="color:#ff7808" href="tree-structure?user_name=<?php echo $random1 ?>">
                                        <p class="name">
                                           <?php echo $tree_user['left_user'];
          if ($tree_user['left_user']=='') {
            # code...
            echo "Empty";
           } ?>
                                        </p></a>
                                    </div>
                                </div>

                                <div class="hv-item-children">

                                    <div class="hv-item-child">
       
                                       
                                        <div class="person">
                                            <img style="height:70px;width:70px;"  src="img/faces/tree-avatar.png" alt="user" data-toggle="modal" data-target="#exampleModal2"
                                             data-toggle="popover" data-trigger="hover"  data-content="Left Team <?php echo $tree_user_leftl['left_count'] ?> ... Right Team <?php echo $tree_user_leftl['right_count'] ?>" onclick="removeModelBlur()">
                                            
                                            <!-- Modal Start-->
                                        <?php
                                        if ($tree_user_left['left_user']!='') {
                                            ?>
                                            
                                            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">
                                    <h5 class="modal-title text-light text-capitalize text-center" id="exampleModalLabel" style="margin:auto;"><?php echo $tree_user_leftl['user_name'] ?></h5>
                                    <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>-->
                                  </div>
                                  <div class="modal-body" background="background: #E2FAFF;margin:auto;">
                                    <p class="text-dark"><b>Left Points</b>: <?= $tree_user_leftl['left_points']?></p>
                                     <p class="text-dark"><b>Right Points</b>: <?= $tree_user_leftl['right_points']?></p>
                                  </div>
                                  <div class="modal-footer" background="background: #E2FAFF;">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                                            
                                            <?php } ?>
                                            <!--Modal End-->
                                            
                                            <a style="color:#ff7808" href="tree-structure?user_name=<?php echo $random2 ?>">
                                            <p class="name">
                                                 <?php echo $tree_user_left['left_user'];
if ($tree_user_left['left_user']=='') {
            # code...
            echo "Empty";
           } ?>
                                            </p></a>
                                        </div>
                                      
                                    </div>


                                 
                                    <div class="hv-item-child">
        

                                        <div class="person">
                                            <img style="height:70px;width:70px;"  src="img/faces/tree-avatar.png" alt="user" data-toggle="modal" data-target="#exampleModal3"  data-toggle="popover" data-trigger="hover"  data-content="Left Team <?php echo $tree_user_leftr['left_count'] ?> ... Right Team <?php echo $tree_user_leftr['right_count'] ?> " onclick="removeModelBlur()">
                                            
                                             <!-- Modal Start-->
                                        <?php
                                        if ($tree_user_left['right_user']!='') {
                                            ?>
                                            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">
                                    <h5 class="modal-title text-light text-capitalize text-center" id="exampleModalLabel" style="margin:auto;"><?php echo $tree_user_leftr['user_name'] ?></h5>
                                    <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>-->
                                  </div>
                                  <div class="modal-body" background="background: #E2FAFF;margin:auto;">
                                    <p class="text-dark"><b>Left Points</b>: <?= $tree_user_leftr['left_points']?></p>
                                     <p class="text-dark"><b>Right Points</b>: <?= $tree_user_leftr['right_points']?></p>
                                  </div>
                                  <div class="modal-footer" background="background: #E2FAFF;">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                                            
                                        <?php    }?>
                                            <!--Modal End-->
                                            <a style="color:#ff7808" href="tree-structure?user_name=<?php echo $random3 ?>">
                                            <p class="name" >
                                               <?php echo $tree_user_left['right_user'];

if ($tree_user_left['right_user']=='') {
            # code...
            echo "Empty";
           } ?>
                                            </p> </a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="hv-item-child">
                            <!-- Key component -->
                            <div class="hv-item">

                                <div class="hv-item-parent">
      

                                    <div class="person">
                                        <img style="height:80px;width:80px;"  src="img/faces/tree-avatar.png" alt="user" data-toggle="modal" data-target="#exampleModal4"  data-toggle="popover" data-trigger="hover"  data-content="Left Team <?php echo $tree_user_right['left_count'] ?> ... Right Team <?php echo $tree_user_right['right_count'] ?> " onclick="removeModelBlur()">
                                        
                                        <!-- Modal Start-->
                                          <?php
                                        if ($tree_user['right_user']!='') {
                                            ?>
                                        <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">
                                    <h5 class="modal-title text-light text-capitalize text-center" id="exampleModalLabel" style="margin:auto;"><?php echo $tree_user_right['user_name'] ?></h5>
                                    <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>-->
                                  </div>
                                  <div class="modal-body" background="background: #E2FAFF;margin:auto;">
                                    <p class="text-dark"><b>Left Points</b>: <?= $tree_user_right['left_points']?></p>
                                     <p class="text-dark"><b>Right Points</b>: <?= $tree_user_right['right_points']?></p>
                                  </div>
                                  <div class="modal-footer" background="background: #E2FAFF;">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                                        
                                         <?php    }?>
                                        <!--Modal End-->
                                        <a style="color:#ff7808" href="tree-structure?user_name=<?php echo $random4 ?>">
                                        <p class="name">
                                             <?php echo $tree_user['right_user'];
            if ($tree_user['right_user']=='') {
            # code...
            echo "Empty";
           } ?>
                                        </p></a>
                                    </div>
                                  
                                </div>

                                <div class="hv-item-children">

                                    <div class="hv-item-child">
       

                                        <div class="person">
                                            <img style="height:70px;width:70px;"  src="img/faces/tree-avatar.png" alt="user" data-toggle="modal" data-target="#exampleModal5"  data-toggle="popover" data-trigger="hover"  data-content="Left Team <?php echo $tree_user_rightl['left_count'] ?> ... Right Team <?php echo $tree_user_rightl['right_count'] ?> " onclick="removeModelBlur()" >
                                            
                                            <!-- Modal Start-->
                                          <?php
                                        if ($tree_user_right['left_user']!='') {
                                            ?>
                                            <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">
                                    <h5 class="modal-title text-light text-capitalize text-center" id="exampleModalLabel" style="margin:auto;"><?php echo $tree_user_rightl['user_name'] ?></h5>
                                    <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>-->
                                  </div>
                                  <div class="modal-body" background="background: #E2FAFF;margin:auto;">
                                    <p class="text-dark"><b>Left Points</b>: <?= $tree_user_rightl['left_points']?></p>
                                     <p class="text-dark"><b>Right Points</b>: <?= $tree_user_rightl['right_points']?></p>
                                  </div>
                                  <div class="modal-footer" background="background: #E2FAFF;">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                                             <?php    }?>
                                        
                                            <!--Modal End-->
                                           <a style="color:#ff7808" href="tree-structure?user_name=<?php echo $random5 ?>">
                                            <p class="name" >
                                               <?php echo $tree_user_right['left_user'];

if ($tree_user_right['left_user']=='') {
            # code...
            echo "Empty";
           }  ?>
                                            </p></a>
                                        </div>
                                      
                                    </div>


                                    <div class="hv-item-child">
     
                                        <div class="person">
                                            <img style="height:70px;width:70px;"  src="img/faces/tree-avatar.png" alt="user" data-toggle="modal" data-target="#exampleModal6" data-toggle="popover" data-trigger="hover"  data-content="Left Team <?php echo $tree_user_rightr['left_count'] ?> ... Right Team <?php echo $tree_user_rightr['right_count'] ?> " onclick="removeModelBlur()" >
                                           
                                           <!-- Modal Start-->
                                             
                                          <?php
                                        if ($tree_user_right['right_user']!='') {
                                            ?>
                                            <div class="modal fade" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">
                                    <h5 class="modal-title text-light text-capitalize text-center" id="exampleModalLabel" style="margin:auto;"><?php echo $tree_user_rightr['user_name'] ?></h5>
                                    <!--<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>-->
                                  </div>
                                  <div class="modal-body" background="background: #E2FAFF;margin:auto;">
                                    <p class="text-dark"><b>Left Points</b>: <?= $tree_user_rightr['left_points']?></p>
                                     <p class="text-dark"><b>Right Points</b>: <?= $tree_user_rightr['right_points']?></p>
                                  </div>
                                  <div class="modal-footer" background="background: #E2FAFF;">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="background : linear-gradient(45deg, #096dd9, #7db2eb, #096dd9, #76b8ff);">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                                            <?php    }?>
                                            <!--Modal End-->
                                            <a style="color:#ff7808" href="tree-structure?user_name=<?php echo $random6 ?>">
                                            <p class="name" >
                                               <?php echo $tree_user_right['right_user'];

if ($tree_user_right['right_user']=='') {
            # code...
            echo "Empty";
           }  ?>
                                            </p></a>
                                        </div>
                                      
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
                    </section> 
             
            
         </div>
         <!-- content-wrapper ends -->
        <script>
           function removeModelBlur()
           {
            setTimeout(function() {
                var divToRemove = document.querySelector('.modal-backdrop');
                if (divToRemove) {
                    divToRemove.remove();
                }
            }, 1000); 
                
           }
        //    function sleep(ms) {
        //     return new Promise(resolve => setTimeout(resolve, ms));
        //     }
        </script>

                                <!-- code here  -->

                            </div>
                        </div>
                        
                        

                    </div>
                    <!-- main-row -->
                    

                    

                    
                    <div class="modal fade" id="exampleModalScrollable2" data-bs-backdrop='static' tabindex="-1"
                    aria-labelledby="exampleModalScrollable2" data-bs-keyboard="false"
                    aria-hidden="true">
                    <!-- Scrollable modal -->
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h6 class="modal-title colorWhite" id="staticBackdropLabel2">Are You Sure?
                                </h6>
                            </div>
                            <div class="modal-body">
                                <p>Logging out will require you to re-enter your login details to access your account again. Are you sure you want to continue?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" onclick="signout()" class="btn btn-sm btn-danger">Yes Do it</button>
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- sponsor modal start -->

                    <div style="background-color:rgba(0,0,0,0.8)" class="modal fade" id="referralModal" tabindex="-1"
                        aria-labelledby="referralModal" data-bs-keyboard="false"
                        aria-hidden="true">
                        <!-- Scrollable modal -->
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-s-link">
                                <div class="modal-header borderBottomNone">
                                    <h6 class="modal-title text-warning ms-2" id="staticBackdropLabel2">Referral links</h6>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class='textWhite'>Left Link:</label>
                                                <div class="input-group mt-2 mb-3">                                                    
                                                    <input id="left-input" type="text" value="<?= $leftLink ?>" readonly class="form-control" placeholder=""
                                                    aria-label=""
                                                    aria-describedby="copyLeftBtn">
                                                    <button class="btn btn-primary" type="button"
                                                    id="copyLeftBtn">Copy Now</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class='textWhite'>Right Link:</label>
                                                <div class="input-group mt-2 mb-3">                                                    
                                                    <input id="right-input" type="text" value="<?= $rightLink ?>" readonly class="form-control" placeholder=""
                                                    aria-label=""
                                                    aria-describedby="copyRightBtn">
                                                    <button class="btn btn-primary" type="button"
                                                    id="copyRightBtn">Copy Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- sponsor modal end -->
                    

                </div> <!-- container -->

                <?php include "account-links.php"; ?>
                <?php include "footer.php"; ?>
                <script type="text/javascript" src="tree/MultiNestedList.js"></script>
                <script>
                    $(document).ready(function(){

                        $("#referralDiv").on("click",function(){
                            window.location.replace("referrals");
                        });


                        $("#buyPkgBtn").on("click",function(){
                            window.location.href = 'buy-pkg';
                        });

                        $("#referralBtn").on("click",function(){
                            $("#referralModal").modal("show");
                        });
                    });
                </script>
                <script>
                    const reverse1 = function reverse1(){
                        let btn1 = document.querySelector("#copyLeftBtn");
                        btn1.innerText = 'Copy Now';
                        btn1.classList.remove("btn-success");
                        btn1.classList.add("btn-primary");
                    }

                    document.querySelector("#copyLeftBtn").addEventListener("click",function(){
                        let btn1 = document.querySelector("#copyLeftBtn");
                        let input1 = document.querySelector("#left-input");
                        input1.select();
                        document.execCommand("copy");
                        btn1.classList.remove("btn-primary");
                        btn1.classList.add("btn-success");
                        input1.blur();
                        btn1.innerText = 'Copied';
                        setTimeout(reverse1,4000);
                    })

                    const reverse2 = function reverse2(){
                        let btn2 = document.querySelector("#copyRightBtn");
                        btn2.innerText = 'Copy Now';
                        btn2.classList.remove("btn-success");
                        btn2.classList.add("btn-primary");
                    }

                    document.querySelector("#copyRightBtn").addEventListener("click",function(){
                        let btn2 = document.querySelector("#copyRightBtn");
                        let input2 = document.querySelector("#right-input");
                        input2.select();
                        document.execCommand("copy");
                        btn2.classList.remove("btn-primary");
                        btn2.classList.add("btn-success");
                        input2.blur();
                        btn2.innerText = 'Copied';
                        setTimeout(reverse2,4000);
                    })

                </script>

</body>

</html>