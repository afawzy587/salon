<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-branches.php");
	$branch = new systembranches();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
        exit;
	}else{
        if($_GET['id'] != 0 )
		{
            
			$branch = $branch->getbranchesInformation($_GET['id']);
            $logs->addLog(56,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"best_saller",
                                "mode" 		        => 	"list",
                                "best_saller" 	    => 	$_GET['id'],
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
        }else{
            header("Location:./error.php");
            exit;
        }
    }
?>
<body class="">
      <div class="wrapper ">
        <?php include './assets/layout/sidebar.php';?>
        <div class="main-panel">
          <?php include './assets/layout/navbar.php';?>
          <div class="content">
              <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title"><?php echo $lang['branch_details'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="card card-profile">

                        <div class="card-body">
                          <h4 class="card-title"><?php echo $branch['branch_name'];?></h4>
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['owner'];?> </strong></span>
								<span class="view_span"><?php  echo getusername($branch['manager_id']);?></span>
							  </div> 
							</div> 
                       </div> 
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['ADDRESS'];?> :</strong></span>
								<span class="view_span"><?php echo $branch['address'];?></span>
							  </div> 
							</div> 
                       </div>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['image'];?> : </strong></span>
                                   <a href="<?php echo $path.$branch['image'];?>" target="_blank">
                                        <span class="view_span">
                                           <img src="<?php echo $path.$branch['image'];?>" class="rounded"  width="100" height="100">
                                        </span>
                                    </a>

							  </div> 
							</div> 
                       </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert ">
                                    <span style="width:auto;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['day_work'];?>  : </strong></span>
                                    <span class="view_span"><?php
                                        if($branch['SAT'] == 0){
                                            echo '<i class="fa fa-close" style="font-size:18px;color:red;margin:10px;" dir="ltr">'.$lang['SAT'].'</i>';
                                        }else{
                                            echo '<i class="fa fa-check"style="font-size:18px;margin:10px;"  dir="ltr">'.$lang['SAT'].'</i>';
                                        }
                                        if($branch['SUN'] == 0){
                                            echo '<i class="fa fa-close" style="font-size:18px;color:red;margin:10px;" dir="ltr">'.$lang['SUN'].'</i>';
                                        }else{
                                            echo '<i class="fa fa-check"style="font-size:18px;margin:10px;"  dir="ltr">'.$lang['SUN'].'</i>';
                                        }
                                        if($branch['MON'] == 0){
                                            echo '<i class="fa fa-close" style="font-size:18px;color:red;margin:10px;" dir="ltr">'.$lang['MON'].'</i>';
                                        }else{
                                            echo '<i class="fa fa-check"style="font-size:18px;margin:10px;"  dir="ltr">'.$lang['MON'].'</i>';
                                        }
                                         if($branch['TUE'] == 0){
                                            echo '<i class="fa fa-close" style="font-size:18px;color:red;margin:10px;" dir="ltr">'.$lang['TUE'].'</i>';
                                        }else{
                                            echo '<i class="fa fa-check"style="font-size:18px;margin:10px;"  dir="ltr">'.$lang['TUE'].'</i>';
                                        }
                                         if($branch['WED'] == 0){
                                            echo '<i class="fa fa-close" style="font-size:18px;color:red;margin:10px;" dir="ltr">'.$lang['WED'].'</i>';
                                        }else{
                                            echo '<i class="fa fa-check"style="font-size:18px;margin:10px;"  dir="ltr">'.$lang['WED'].'</i>';
                                        }
                                         if($branch['THU'] == 0){
                                            echo '<i class="fa fa-close" style="font-size:18px;color:red;margin:10px;" dir="ltr">'.$lang['THU'].'</i>';
                                        }else{
                                            echo '<i class="fa fa-check"style="font-size:18px;margin:10px;"  dir="ltr">'.$lang['THU'].'</i>';
                                        }
                                         if($branch['FRI'] == 0){
                                            echo '<i class="fa fa-close" style="font-size:18px;color:red;margin:10px;" dir="ltr">'.$lang['FRI'].'</i>';
                                        }else{
                                            echo '<i class="fa fa-check"style="font-size:18px;margin:10px;"  dir="ltr">'.$lang['FRI'].'</i>';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['start_time'];?> :</strong></span>
								<span class="view_span"><?php echo $branch['branch_from'];?></span>
							  </div> 
							</div> 
                            <div class="col-md-6">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['end_time'];?> :</strong></span>
								<span class="view_span"><?php echo $branch['branch_to'];?></span>
							  </div> 
							</div>  
                       </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert ">
                                    <span style="width:auto;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                                    <span class="view_span"><?php if($branch['status'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';}else{
                                        echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['active'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="form-group" id="item_{$u.id}">
                <a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-rtl: 20px"><?php echo $lang['print'];?></a>
                  <?php if($group['branches_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="branches_edit.php?id='.$branch['branch_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['branches_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="branches.php?do=del&id='.$branch['branch_serial'].'">'.$lang['delete'].'</a>';
                  } ?>
                  <?php
                    echo "<a class='btn btn-primary   btn-sm' title='".$lang['branche_services']."' href='services.php?branch=".$branch['branch_serial']."' ><i class=\"material-icons\">style</i>".$lang['branche_services']."</a>
                          <a class='btn btn-success  btn-sm' title='".$lang['branche_add_service']."' href='branche_services.php?branch=".$branch['branch_serial']."' ><i class=\"material-icons\">style</i></a>
                          <a class='btn btn-info   btn-sm' title='".$lang['branch_staff']."' href='staffs.php?branch=".$branch['branch_serial']."' ><i class=\"material-icons\">people</i>".$lang['branch_staff']."</a>
                          <a class='btn btn-success  btn-sm' title='".$lang['branche_add_staff']."' href='staffs_add.php?branch=".$branch['branch_serial']."' ><i class=\"material-icons\">people</i></a>
                    ";
                    ?>
                
                
             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>
