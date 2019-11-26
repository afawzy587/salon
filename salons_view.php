<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-salons.php");
	$salons = new systemsalons();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($_GET['id'] != 0 )
		{
            
			$salon = $salons->getsalonsInformation($_GET['id']);
        }else{
            header("Location:./error.php");
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
                      <h4 class="card-title"><?php echo $lang['salon_details'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="card card-profile">
<!--
                        <div class="card-avatar">
                          <a href="#pablo">
                            <img class="img" src="<?php echo $path.$salon['image'];?>" />
                          </a>
                        </div>
-->
                        <div class="card-body">
                          <h4 class="card-title"><?php echo $salon['salon_name'];?></h4>
<!--                          <a href="#pablo" class="btn btn-primary btn-round">Follow</a>-->
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['owner'];?> :</strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $salon['owner'];?></span>
							  </div> 
							</div> 
                            
                       </div> 
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['image'];?> : </strong></span>
                                   <a href="<?php echo $path.$salon['image'];?>" target="_blank">
                                        <span style="width:80%;display:inline-block;">
                                           <img src="<?php echo $path.$salon['image'];?>" class="rounded"  width="100" height="100">
                                        </span>
                                    </a>

							  </div> 
							</div> 
                       </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert ">
                                    <span style="width:20%;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                                    <span style="width:75%;display:inline-block;"><?php if($salon['status'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';}else{
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
                  <?php if($group['salons_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="salons_edit.php?id='.$salon['salon_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['salons_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="salons.php?do=del&id='.$salon['salon_serial'].'">'.$lang['delete'].'</a>';
                  } ?>
                
                
             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>    