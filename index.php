<?php
// output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
    if($login->doCheck() == false)
    {
        header("Location:./login.php");
        exit;
    }
    include './assets/layout/header.php';

?>

<body class="">
  <div class="wrapper ">
      
    <?php include './assets/layout/sidebar.php';?>
      
    <div class="main-panel">
        
      <?php include './assets/layout/navbar.php';?>
        
      <div class="content">
          
         
          
      </div>
    </div>
  </div>
    
 <?php include './assets/layout/footer.php';?>
