<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-services.php");
	$services = new systemservices();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($_GET['id'] != 0 )
		{
            
			$service = $services->getservicesInformation($_GET['id']);
            $logs->addLog(101,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"services",
                                "mode" 		        => 	"view",
                                "service_id" 		=> 	$_GET['id'],
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
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
                      <h4 class="card-title"><?php echo $lang['service_details'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="card card-profile">

                        <div class="card-body">
                          <h4 class="card-title"><?php echo $service['service_name'];?></h4>
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['price'];?> :</strong></span>
								<span class="view_span"><?php echo $service['price'];?></span>
							  </div> 
							</div> 
                            <div class="col-md-6">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['discount'];?> :</strong></span>
								<span class="view_span"><?php echo $service['discount'] ."\n".$lang['Currancy'] ;?></span>
							  </div> 
							</div>
                       </div> 
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['duration'];?> :</strong></span>
								<span class="view_span"><?php echo $service['duration'] .$lang['minute'] ;?></span>
							  </div> 
							</div> 
                            
                       </div> 
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['image'];?> : </strong></span>
                                   <a href="<?php echo $path.$service['image'];?>" target="_blank">
                                        <span class="view_span">
                                           <img src="<?php echo $path.$service['image'];?>" class="rounded"  width="100" height="100">
                                        </span>
                                    </a>

							  </div> 
							</div> 
                       </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert ">
                                    <span style="width:auto;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                                    <span class="view_span"><?php if($service['status'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';}else{
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
                  <?php if($group['services_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="services_edit.php?id='.$service['service_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['services_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="services.php?do=del&id='.$service['service_serial'].'">'.$lang['delete'].'</a>';
                  } ?>
                
                
             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>
