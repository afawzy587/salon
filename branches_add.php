<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
//    echo' <link href="./assets/css/materialize.min.css" rel="stylesheet" />';



    include("./inc/Classes/system-branches.php");
	$branches = new systembranches();

	include("./inc/Classes/system-users.php");
	$users = new systemUsers();

	
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
        exit;
	}else{
        if($group['branches_add'] == 0){
            header("Location:./permission.php");
            exit;
        }else{ 
            $user   = $users->getsiteUsers();
            if($_POST)
            {
                

                $_branch['name']          =       sanitize($_POST["name"]);
                $_branch['address']       =       sanitize($_POST["address"]);
                $_branch['branch_from']   =       sanitize($_POST["branch_from"]);
                $_branch['branch_to']     =       sanitize($_POST["branch_to"]);
                $_branch['address']       =       sanitize($_POST["address"]);
                $_branch['manager_id']    =       intval($_POST["manager_id"]);
                $_branch['SAT']           =       intval($_POST["SAT"]);
                $_branch['SUN']           =       intval($_POST["SUN"]);
                $_branch['MON']           =       intval($_POST["MON"]);
                $_branch['TUE']           =       intval($_POST["TUE"]);
                $_branch['WED']           =       intval($_POST["WED"]);
                $_branch['THU']           =       intval($_POST["THU"]);
                $_branch['FRI']           =       intval($_POST["FRI"]);
                $_branch['status']        =       intval($_POST["status"]);


                if ($_branch[name] =="" )
                {
                    $errors[name] = $lang['no_branch_name'];
                }else{
                    $check = $branches->isbranchesExists($_branch['name'] , $_branch['salon_id']);
                        if(is_array($check))
                        {
                             $errors[name] = $lang['add_this_branch_before'];
                        }
                }
                
                if ($_branch[branch_from] =="" )
                {
                    $errors[branch_from] = $lang['INSERT_branch_from'];
                }
                
                if ($_branch[branch_to] =="" )
                {
                    $errors[branch_to] = $lang['INSERT_branch_to'];
                }
                
                if ($_branch[address] =="" )
                {
                    $errors[address] = $lang['INSERT_ADDRESS'];
                }
                


                if ($_branch[manager_id] == 0 )
                {
                    $errors[manager_id] = $lang['NO_OWNER_ID'];
                }

                if($_FILES && ( $_FILES['image']['name'] != "") && ( $_FILES['image']['tmp_name'] != "" ) )
                {
                    if(!empty($_FILES['image']['error']))
                    {
                        switch($_FILES['image']['error'])
                        {
                            case '1':
                                $errors[image] = $lang['UP_ERR_SIZE_BIG'];
                                break;
                            case '2':
                                $errors[image] = $lang['UP_ERR_SIZE_BIG'];
                                break;
                            case '3':
                                $errors[image] = $lang['UP_ERR_FULL_UP'];
                                break;
                            case '4':
                                $errors[image] = $lang['UP_ERR_SLCT_FILE'];
                                break;
                            case '6':
                                $errors[image] = $lang['UP_ERR_TMP_FLDR'];
                                break;
                            case '7':
                                $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                                break;
                            case '8':
                                $errors[image] = $lang['UP_ERR_UPLODED_STPD'];
                                break;
                            case '999':
                            default:
                                $errors[image] = $lang['UP_ERR_UNKNOWN'];
                        }
                    }
                }elseif(empty($_FILES['image']['tmp_name']) || $_FILES['image']['tmp_name'] == 'none')
                    {
                        $errors[image] = $lang['UP_ERR_SLCT_FILE'];
                    }
                if( $_FILES && ( $_FILES['image']['name'] != "") && ( $_FILES['image']['tmp_name'] != "" ) )
                {
                    include_once("./inc/Classes/upload.class.php");

                    $allow_ext = array("jpg","jpeg","gif","png");

                    $upload    = new Upload($allow_ext,false,0,0,5000,$upload_path,".","",false);

                    $files[name] 	= addslashes($_FILES["image"]["name"]);
                    $files[type] 	= $_FILES["image"]['type'];
                    $files[size] 	= $_FILES["image"]['size']/1024;
                    $files[tmp] 	= $_FILES["image"]['tmp_name'];
                    $files[ext]		= $upload->GetExt($_FILES["image"]["name"]);

                    $upfile	= $upload->Upload_File($files);


                    if($upfile)
                    {
                        $_branch[image] = $upfile[newname];
                    }else
                    {
                       $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                    }
                }

                if(empty($errors)){
                    $add = $branches->addNewbranches($_branch);
                    if($add == 1){
                        $logs->addLog(54,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"branches",
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
                      <h4 class="card-title"><?php echo $lang['add_branch'];?></h4>
                    <p class="card-category"><?php if($salon_id){ echo  $lang['salon'] . ' : ' .getsalonname($salon_id);}?></p>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./branches_add.php<?php if($salon_id != 0){echo '?salon='.$salon_id;}?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php echo $_branch['name'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['ADDRESS'];?></label>
                              <input type="text" class="form-control" name ="address"  value="<?php echo $_branch['address'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['owner'];?></label>
                              <select class="browser-default custom-select choose" name="manager_id">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
								  <?php if(!empty($user))
										{
											foreach($user as $k => $v)
											{
												echo '<option value="'.$v[user_serial].'"';if($v[user_serial] == $_branch[manager_id]){echo 'selected';}echo'>'.$v[user_name].'</option>';
											}
	
										}
								  ?>
								</select>
                            </div>
                          </div>
                        </div>
                         <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p> <?php echo $lang['choose_day_work'];?> </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                              <div class="custom-control custom-checkbox col-md-3">
                                <input type="checkbox" class="custom-control-input" name="SAT" value="1" id="<?php echo $lang['SAT'];?>" <?php if($_branch[SAT] == 1){echo 'checked';}?>/>
                                  <label class="custom-control-label" for="<?php echo $lang['SAT'];?>"><p><?php echo $lang['SAT'];?></p></label>
                              </div>
                            </div>
                            
                            <div class="col-md-3">  
                              <div class="custom-control custom-checkbox col-md-3">
                                <input type="checkbox" class="custom-control-input" name="SUN" value="1" id="<?php echo $lang['SUN'];?>" <?php if($_branch[SUN] == 1){echo 'checked';}?> >
                                <label class="custom-control-label" for="<?php echo $lang['SUN'];?>"><?php echo $lang['SUN'];?></label>
                              </div>  
                            </div> 
                            <div class="col-md-3">  
                             <div class="custom-control custom-checkbox col-md-3">
                                <input type="checkbox" class="custom-control-input" name="MON" value="1" id="<?php echo $lang['MON'];?>" <?php if($_branch[MON] == 1){echo 'checked';}?>>
                                <label class="custom-control-label" for="<?php echo $lang['MON'];?>"><?php echo $lang['MON'];?></label>
                              </div> 
                            </div> 
                            <div class="col-md-3">
                             <div class="custom-control custom-checkbox col-md-3">
                                <input type="checkbox" class="custom-control-input" name="TUE" value="1" id="<?php echo $lang['TUE'];?>" <?php if($_branch[TUE] == 1){echo 'checked';}?>>
                                <label class="custom-control-label" for="<?php echo $lang['TUE'];?>"><?php echo $lang['TUE'];?></label>
                              </div> 
                            </div>
                            <div class="col-md-3">  
                             <div class="custom-control custom-checkbox col-md-3">
                                <input type="checkbox" class="custom-control-input" name="WED" value="1" id="<?php echo $lang['WED'];?>" <?php if($_branch[WED] == 1){echo 'checked';}?>>
                                <label class="custom-control-label" for="<?php echo $lang['WED'];?>"><?php echo $lang['WED'];?></label>
                              </div> 
                            </div> 
                            <div class="col-md-3">  
                              <div class="custom-control custom-checkbox col-md-3">
                                <input type="checkbox" class="custom-control-input" name="THU" value="1" id="<?php echo $lang['THU'];?>" <?php if($_branch[THU] == 1){echo 'checked';}?>>
                                <label class="custom-control-label" for="<?php echo $lang['THU'];?>"><?php echo $lang['THU'];?></label>
                              </div>
                            </div>
                            <div class="col-md-3">
                             <div class="custom-control custom-checkbox col-md-3">
                                <input type="checkbox" class="custom-control-input" name="FRI" value="1" id="<?php echo $lang['FRI'];?>" <?php if($_branch[FRI] == 1){echo 'checked';}?>>
                                <label class="custom-control-label" for="<?php echo $lang['FRI'];?>"><?php echo $lang['FRI'];?></label>
                              </div> 
                          </div>
                        </div>
                         <br/>
                        <div class="row">
                          <div class="col-md-6">
                              <label class="bmd-label-floating"><?php echo $lang['start_time'];?></label>
                              <input type="datetime" class="form-control onlytime" autocomplete="off" name ="branch_from"  value="<?php echo $_branch['branch_from'] ?>">
                          </div>
                         <div class="col-md-6">
                              <label class="bmd-label-floating"><?php echo $lang['end_time'];?></label>
                              <input type="datetime" class="form-control onlytime" autocomplete="off" name ="branch_to"  value="<?php echo $_branch['branch_to'] ?>">
                          </div>
                        </div> 
                        <div class="row">
                          <div class="col-md-11">
                           <div class="form-group">
							<div class="ml-2 col-sm-5">
							  <div id="msg"></div>
								<input type="file" name="image" class="file" accept="image/*">
								<div class="input-User my-3">
								  <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
								  <div class="input-User-append">
									<button type="button" class="browse btn btn-primary"><?php echo $lang['image'];?></button>
								  </div>
								</div>
							</div>
							<div class="ml-2 col-sm-5">
							  <img src="https://placehold.it/80x80" id="preview" class="img-thumbnail" style="width:100px;height:100px">
							</div>
				           </div>
                          </div>
                        </div>
                          
                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['status'];?></label>
                              <select class="browser-default custom-select" name="status">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
									<option value="0" <?php if($_branch[status] == 0){echo 'selected';}?>><?php echo $lang['deactive'];?></option>
								  <option value="1"<?php if($_branch[status] == 1){echo 'selected';}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['add_branch'];?></button>
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
