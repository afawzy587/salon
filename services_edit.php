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
        if($group['services_edit'] == 0){
            header("Location:./permission.php");
        }else{ 
        
            $id    = $_GET['id'];
            if($id != 0){
                $u  = $services->getservicesInformation($id);
                if($_POST)
                {
                    $_service['id']         =       $id;
                    $_service['name']       =       sanitize($_POST["name"]);
                    $_service['price']      =       floatval($_POST["price"]);
                    $_service['discount']   =       floatval($_POST["discount"]);
                    $_service['duration']   =       sanitize($_POST["duration"]);
                    $_service['status']     =       intval($_POST["status"]);


                    if ($_service[name] =="" )
                    {
                        $errors[name] = $lang['no_service_name'];
                    }else{
                        $check = $services->isservicesExists($_service['name']);
                        if(is_array($check))
                        {
                            if($check['id'] != $_service['id'])
                            {
                                $errors[name] = $lang['add_this_service_before'];
                            }
                        }
                    }

                    if ($_service[price] == 0 )
                    {
                        $errors[price] = $lang['insert_service_price'];
                    }

                    if ($_service[duration] == "" )
                    {
                        $errors[duration] = $lang['insert_service_duration'];
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
                            $_service[image] = $upfile[newname];
                        }else
                        {
                           $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                        }
                        @unlink($path.$u['image']);
                    }

                    if(empty($errors)){
                        $update = $services->setservicesInformation($_service);
                        if($update == 1){
                            header("Location:./services.php?message=update");
                        }

                    }
                }
            }else{
                header("Location:./error.php");
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
                      <h4 class="card-title"><?php echo $lang['edit_service'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./services_edit.php?id=<?php echo $u['service_serial'];?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php if($_service){echo $_service['name'];}else{echo $u['service_name'];} ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['price'];?></label>
                              <input type="number" class="form-control" min='1' name ="price"  value="<?php  if($_service){echo $_service['price'];}else{echo $u['price'];} ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['discount'];?></label>
                              <input type="number" class="form-control"  max="100" name ="discount"  value="<?php  if($_service){echo $_service['discount'];}else{echo $u['discount'];}  ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['insert_service_duration'];?></label>
                              <input type="number" class="form-control" min='1'  name ="duration"  value="<?php if($_service){echo $_service['duration'];}else{echo $u['duration'];}?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                           <div class="form-group">
							<div class="ml-2 col-sm-6">
							  <div id="msg"></div>
								<input type="file" name="image" class="file" accept="image/*">
								<div class="input-User my-3">
								  <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
								  <div class="input-User-append">
									<button type="button" class="browse btn btn-primary"><?php echo $lang['image'];?></button>
								  </div>
								</div>
							</div>
							<div class="ml-2 col-sm-6">
							  <img src="<?php echo $path.$u['image'];?>" id="preview" class="img-thumbnail" style="width:100px;height:100px">
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
                                  
									<option value="0" <?php if($_service){if($_service[status] == 0){echo 'selected';}}else{if($u[status] == 0){echo 'selected';}}?>>
                                        <?php echo $lang['deactive'];?></option>
								  <option value="1" <?php if($_service){if($_service[status] == 1){echo 'selected';}}else{if($u[status] == 1){echo 'selected';}}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                          <br>
                        
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_service'];?></button>
                          </div>
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