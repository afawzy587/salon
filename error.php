<?php
	// output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
    include './assets/layout/header.php';
    if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}
    
?>
    <body class="">
      <div class="wrapper ">
        <?php include './assets/layout/sidebar.php';?>
        <div class="main-panel">
          <?php include './assets/layout/navbar.php';?>
          <div class="content">
            <input type="hidden" value="users" id="page">
            <input type="hidden" value="<?php echo $lang['user']?>" id="lang_name">
            <input type="hidden" value="<?php echo $lang['delete_alarm_massage_in_men']?>" id="lang_del">
            <input type="hidden" value="<?php echo $lang['status_alarm_massage_in_men']?>" id="lang_status">  
            <div class="container-fluid">
              <div class="row">
                   <!-- Main content -->
                <section class="content">
                  <div class="error-page">
                    <h2 class="headline text-yellow"> 400 </h2>

                    <div class="error-content">
                      <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                    </div>
                    <!-- /.error-content -->
                  </div>
                  <!-- /.error-page -->
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>

 <?php include './assets/layout/footer.php';?>
