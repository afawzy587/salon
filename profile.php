<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
    include './assets/layout/header.php';
    include("./inc/Classes/system-users.php");
	$Users = new systemUsers();

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
            if($_GET['message']== "update")
            {
                $success = $lang['edit_profile_success'];
            }
            if($_POST)
            {
                $_user['id']         =       $login->getUserId();
                $_user['name']       =       sanitize($_POST["name"]);
                $_user['phone']      =       sanitize($_POST["phone"]);
                $_user['email']      =       sanitize(strtolower($_POST["email"]));
                $_user['address']    =       sanitize($_POST["address"]);
                $_user['password']   =       sanitize($_POST["password"]);

                if ($_user[name] =="" )
                {
                    $errors[name] = $lang['no_user_name'];
                }

                if ($_user[email] =="" )
                {
                    $errors[email] = $lang['NOEMAIL'];
                }
                else
                {
                    if(checkMail($_user[email]) == false){
                        $errors[email] = $lang['NOT_VALID_EMAIL'];
                    }else{
                        $check = $Users->isUsersExists($_user['email']);
                        if(is_array($check))
                        {
                            if($_user['id'] != $check['id'])
                            {
                                $errors[email] = $lang['EMAILISENTERBEFORE'];
                            }
                        }
                    }
                }

                if ($_user[phone] =="" )
                {
                    $errors[phone] = $lang['NOPHONE'] ;
                }else
                {
                    if(checkPhone($_user[phone]) == false)
                    {
                        $errors[phone] = $lang['NOT_VALID_PHONE'];
                    }else{
                        $check = $Users->isUsersExists($_user['phone']);
                        if(is_array($check))
                        {
                            if($_user['id'] != $check['id'])
                            {
                                $errors[phone] = $lang['add_this_user_before'];
                            }
                        }
                    }
                }
                if ($_user[address] =="" )
                {
                    $errors[address] = $lang['NO_ADDRESS'];
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
                    $_user[image] = $upfile[newname];
                }else
                {
                   $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                }
                @unlink($path.$u['user_photo']);
            }

            if(empty($errors)){
              print_r($login->setUserInformation($_user));
                $update = $login->setUserInformation($_user);
                $logs->addLog(112,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"profile",
                                "mode" 		        => 	"update",
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
                if($update == 1){
                    header("Location:./profile.php?message=update");
                }

            }
        }
            $u  = $login->getUserInformation();
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
                      <h4 class="card-title"><?php echo $lang['edit_profile'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./profile.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php if($_user){echo $_user['name'];}else{echo $u['user_name'];} ?>">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['phone'];?></label>
                              <input type="tel" class="form-control" name="phone"  value="<?php if($_user){echo $_user['phone'];}else{echo $u['phone'];} ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['email'];?></label>
                              <input type="email" class="form-control" autocomplete="new-password" name="email" value="<?php if($_user){echo $_user['email'];}else{echo $u['email'];} ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['ADDRESS'];?></label>
                              <input type="text" class="form-control" name='address' value="<?php if($_user){echo $_user['address'];}else{echo $u['address'];} ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['password'];?></label>
                              <input type="password" class="form-control" autocomplete="new-password" name='password' >
                              <p class="help-block"><?php echo $lang['NOCHANGEINPASS'];?></p>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                           <div class="form-group">
							<div class="ml-2 col-sm-6">
							  <div id="msg"></div>
								<input type="file" name="image" class="file" accept="image/*">
								<div class="input-group my-3">
								  <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
								  <div class="input-group-append">
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
                        <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_profile'];?></button>
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
