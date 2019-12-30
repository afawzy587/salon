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
        exit;
	}
    $logs->addLog(78,
                    array(
                        "type" 		        => 	"admin",
                        "module" 	        => 	"permission",
                        "mode" 		        => 	"view",
                        "id" 	        	=>	$login->getUserId(),
                    ),"admin",$login->getUserId(),1
                );
    
?>
    <body class="">
      <div class="wrapper ">
        <?php include './assets/layout/sidebar.php';?>
        <div class="main-panel">
          <?php include './assets/layout/navbar.php';?>
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                   <!-- Main content -->
                <section class="content">
                  <div class="error-page">
                    <h2 class="headline text-yellow"> 404</h2>

                    <div class="error-content">
                      <h3><i class="fa fa-warning text-yellow"></i> <?php echo $lang['PERMISSION_ERROR_CONTENT']?></h3>
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
