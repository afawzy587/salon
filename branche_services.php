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
        exit;
	}else{
        if($group['services_add'] == 0){
            header("Location:./permission.php");
        }else{ 
            
            $branch_id = intval($_GET['branch']);
            if($branch_id ==0)
            {
                 header("Location:./error.php");
                 exit;
            }else{
                $service  = $services->getsitebranchserives($branch_id);
                if($_POST)
                {
                    $_service['branch_id']     =       $branch_id;
                    $_service['service_id']    =       intval($_POST["service_id"]);

               
                    if ($_service['service_id'] == 0 )
                    {
                         $errors['service_id'] = $lang['choose_branch_service'];
                    }else{
                        $check = $services->isbranchservicesExists($branch_id ,$_service['service_id']);
                            if(is_array($check))
                            {
                                 $errors['service_id'] = $lang['add_this_branch_service_before'];
                            }
                    }
                    


                    if(empty($errors)){
                        $add = $services->addNewbranceservices($_service);
                        if($add == 1){
                            $logs->addLog(51,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"brache_services",
										"mode" 		        => 	"add",
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                            header("Location:./branches.php?message=add");
                            exit;
                        }
                    }
                }
            }
            
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
              	<div class="col-lg-12">
					<?php if ($success){
							echo '<div class="alert alert-success">'.$success.'</div>';
						}else{
							if($errors)
							{
								echo '<div class="alert alert-danger">
								     <ul>';
								foreach($errors as $k=> $e)
								{
									echo '<li><strong>'.$e.'</strong></li>';
								}
								echo'</ul>
							         </div>';
							}
						}
					?>
              </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title"><?php echo $lang['add_salon'];?></h4>
                      <p class="card-category"> <?php if($branch_id){ echo $lang['branch'].  ' : ' . getbranchname($branch_id);}?></p>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./branche_services.php<?php echo '?branch='.$branch_id?>" method="post" enctype="multipart/form-data">
                        <input name='branch_id' value="<?php echo $branch_id;?>" hidden>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-User">
                              <label class="bmd-label-floating"><?php echo $lang['services'] ;?></label>
                              <select class="browser-default custom-select select2" name="service_id">
								  <option  disabled  selected><?php echo $lang['choose'];?></option>
								  <?php if(!empty($service))
										{
											foreach($service as $k => $s)
											{
												echo '<option value="'.$s[service_serial].'"';if($s[service_serial] == $_service[service_id]){echo 'selected';}echo'>'.$s[service_name].'</option>';
											}
										}else{
                                                echo '<option disabled  selected>'. $lang['all_serives_in_branch'].'</option>';
                                            }
								  ?>
								</select>
                            </div>
                          </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['add_branch_service'];?></button>
                        </div>
                        <div class="clearfix"></div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?> 
<script src="./assets/js/list-controls.js"></script>
