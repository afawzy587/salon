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
	include("./inc/Classes/system-Users.php");
	$users = new systemUsers();

	
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($group['salons_edit'] == 0){
            header("Location:./permission.php");
        }else{ 
        
            $id    = intval($_GET['id']);
            if($id != 0){
                $user = $users->getsiteUsers();
                $u  = $salons->getsalonsInformation($id);
                if($_POST)
                {
                    $_salon['id']         =       $id;
                    $_salon['name']       =       sanitize($_POST["name"]);
                    $_salon['owner_id']   =       intval($_POST["owner_id"]);
                    $_salon['status']     =       intval($_POST["status"]);


                    if ($_salon[name] =="" )
                    {
                        $errors[name] = $lang['no_salon_name'];
                    }else{
                        $check = $salons->issalonsExists($_salon['name']);
                        if(is_array($check))
                        {
                            if($check['id'] != $_salon['id'])
                            {
                                $errors[name] = $lang['add_this_salon_before'];
                            }
                        }
                    }

                    if ($_salon[owner_id] == 0 )
                    {
                        $errors[owner_id] = $lang['NO_OWNER_ID'];
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
                            $_salon[image] = $upfile[newname];
                        }else
                        {
                           $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                        }
                        @unlink($path.$u['salon_photo']);
                    }

                    if(empty($errors)){
                        $update = $salons->setsalonsInformation($_salon);
                        if($update == 1){
                            header("Location:./salons.php?message=update");
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
                      <h4 class="card-title"><?php echo $lang['edit_salon'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./salons_edit.php?id=<?php echo $u['salon_serial'];?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php if($_salon){echo $_salon['name'];}else{echo $u['salon_name'];} ?>">
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
                              <label class="bmd-label-floating"><?php echo $lang['User'];?></label>
                              <select class="browser-default custom-select" name="owner_id">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
								  <?php if(!empty($user))
										{
											foreach($user as $k => $v)
											{
												echo '<option value="'.$v[user_serial].'"';
                                                if($_salon){if($v[user_serial] == $_salon[owner_id]){echo 'selected';}}else{if($v[user_serial] == $u[owner_id]){echo 'selected';}}
                                                echo '>'.$v[user_name].'</option>';
											}
	
										}
								  ?>
								</select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['status'];?></label>
                              <select class="browser-default custom-select" name="status">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
                                  
									<option value="0" <?php if($_salon){if($_salon[status] == 0){echo 'selected';}}else{if($u[status] == 0){echo 'selected';}}?>>
                                        <?php echo $lang['deactive'];?></option>
								  <option value="1" <?php if($_salon){if($_salon[status] == 1){echo 'selected';}}else{if($u[status] == 1){echo 'selected';}}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_salon'];?></button>
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