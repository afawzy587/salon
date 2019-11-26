<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-branches.php");
	 $branches = new systembranches();

    include("./inc/Classes/system-staffs.php");
	$staff = new systemstaff();

	
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($group['staffs_edit'] == 0){
            header("Location:./permission.php");
        }else{ 
        
            $id    = intval($_GET['id']);
            if($id != 0){
                $branch    = $branches->getsitebranches();
                $u  = $staff->getstaffInformation($id);
                if($_POST)
                {
                    $_staff['id']                  =       $id;
                    $_staff['name']                =       sanitize($_POST["name"]);
                    $_staff['branch_id']           =       intval($_POST["branch_id"]);
                    $_staff['sat']                 =       intval($_POST["sat"]);
                    $_staff['sat_from']            =       sanitize($_POST["sat_from"]);
                    $_staff['sat_to']              =       sanitize($_POST["sat_to"]);
                    $_staff['sun']                 =       intval($_POST["sun"]);
                    $_staff['sun_from']            =       sanitize($_POST["sun_from"]);
                    $_staff['sun_to']              =       sanitize($_POST["sun_to"]);
                    $_staff['mon']                 =       intval($_POST["mon"]);
                    $_staff['mon_from']            =       sanitize($_POST["mon_from"]);
                    $_staff['mon_to']              =       sanitize($_POST["mon_to"]);
                    $_staff['tus']                 =       intval($_POST["tus"]);
                    $_staff['tus_from']            =       sanitize($_POST["tus_from"]);
                    $_staff['tus_to']              =       sanitize($_POST["tus_to"]);
                    $_staff['wed']                 =       intval($_POST["wed"]);
                    $_staff['wed_from']            =       sanitize($_POST["wed_from"]);
                    $_staff['wed_to']              =       sanitize($_POST["wed_to"]);
                    $_staff['thurs']               =       intval($_POST["thurs"]);
                    $_staff['thurs_from']          =       sanitize($_POST["thurs_from"]);
                    $_staff['thurs_to']            =       sanitize($_POST["thurs_to"]);
                    $_staff['fri']                 =       intval($_POST["fri"]);
                    $_staff['fri_from']            =       sanitize($_POST["fri_from"]);
                    $_staff['fri_to']              =       sanitize($_POST["fri_to"]);
                    $_staff['status']              =       intval($_POST["status"]);


                    if ($_staff[name] =="" )
                    {
                        $errors[name] = $lang['no_staff_name'];
                    }else{
                        $check = $staff->isstaffExists($_staff['name']);
                        if(is_array($check))
                        {
                            if($check['id'] != $_staff['id'])
                            {
                                $errors[name] = $lang['add_this_staff_before'];
                            }
                        }
                    }
                    
                    if ($_staff[branch_id] == 0 )
                    {
                        $errors[branch_id] = $lang['NO_BRANCH_ID'];
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
                            $_staff[image] = $upfile[newname];
                        }else
                        {
                           $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                        }
                        @unlink($path.$u['staff_photo']);
                    }

                    if(empty($errors)){
                        $update = $staff->setstaffInformation($_staff);
                        if($update == 1){
                            header("Location:./staffs.php?message=update");
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
                      <h4 class="card-title"><?php echo $lang['edit_staff'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./staffs_edit.php?id=<?php echo $u['staff_serial'];?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php if($_staff){echo $_staff['name'];}else{echo $u['staff_name'];} ?>">
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang["branch"] ;?></label>
                                <select class="browser-default custom-select choose" name="branch_id">
                                    <option disabled  selected><?php echo $lang["choose"];?></option>
                                    <?php
                                       if(!empty($branch))
                                            {
                                                foreach($branch as $k => $b)
                                                {
                                                    echo '<option value="'.$b['branch_serial'].'"';
                                                    if($_staff){if($b['branch_serial'] == $_staff['branch_id']){echo 'selected';}}else{if($b['branch_serial'] == $u['branch_id']){echo 'selected';}}
                                                    echo '>'.getbranchname($b['branch_serial']).'</option>';

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
                            <div class="col-md-12">
                                 <table class="table table-bordered table-sm">
                                    <thead>
                                      <tr>
                                        <th><?php echo $lang['DAY'];?></th>
                                        <th><?php echo $lang['start_time'];?></th>
                                        <th><?php echo $lang['end_time'];?></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="custom-control-input" name="sat" value="1" id="<?php echo $lang['SAT'];?>" 
                                                       <?php if($_staff){if($_staff['sat'] == 1){echo 'checked';}}else{if($u['sat'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['SAT'];?>"><b><?php echo $lang['SAT'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                          <input type="datetime" class="form-control onlytime" autocomplete="off" name ="sat_from" placeholder="00:00:00"  value="<?php if($_staff){echo $_staff['sat_from'];}else{echo $u['sat_from'];} ?>">
                                        </td>
                                        <td>
                                            <input type="datetime" class="form-control onlytime" autocomplete="off" name ="sat_to" placeholder="00:00:00"   value="<?php if($_staff){echo $_staff['sat_to'];}else{echo $u['sat_from'];} ?>">
                                        </td>
                                      </tr>
                                     <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="custom-control-input" name="sun" value="1" id="<?php echo $lang['SUN'];?>" 
                                                       <?php if($_staff){if($_staff['sun'] == 1){echo 'checked';}}else{if($u['sun'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['SUN'];?>"><b><?php echo $lang['SUN'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                          <input type="datetime" class="form-control onlytime" autocomplete="off" name ="sun_from" placeholder="00:00:00"  value="<?php if($_staff){echo $_staff['sun_from'];}else{echo $u['sun_from'];} ?>">
                                        </td>
                                        <td>
                                            <input type="datetime" class="form-control onlytime" autocomplete="off" name ="sun_to" placeholder="00:00:00"   value="<?php if($_staff){echo $_staff['sun_to'];}else{echo $u['sun_from'];} ?>">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="custom-control-input" name="mon" value="1" id="<?php echo $lang['MON'];?>" 
                                                       <?php if($_staff){if($_staff['mon'] == 1){echo 'checked';}}else{if($u['mon'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['MON'];?>"><b><?php echo $lang['MON'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                          <input type="datetime" class="form-control onlytime" autocomplete="off" name ="mon_from" placeholder="00:00:00"  value="<?php if($_staff){echo $_staff['mon_from'];}else{echo $u['mon_from'];} ?>">
                                        </td>
                                        <td>
                                            <input type="datetime" class="form-control onlytime" autocomplete="off" name ="mon_to" placeholder="00:00:00"   value="<?php if($_staff){echo $_staff['mon_to'];}else{echo $u['mon_from'];} ?>">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="custom-control-input" name="tus" value="1" id="<?php echo $lang['TUE'];?>" 
                                                       <?php if($_staff){if($_staff['tus'] == 1){echo 'checked';}}else{if($u['tus'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['TUE'];?>"><b><?php echo $lang['TUE'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                          <input type="datetime" class="form-control onlytime" autocomplete="off" name ="tus_from" placeholder="00:00:00"  value="<?php if($_staff){echo $_staff['tus_from'];}else{echo $u['tus_from'];} ?>">
                                        </td>
                                        <td>
                                            <input type="datetime" class="form-control onlytime" autocomplete="off" name ="tus_to" placeholder="00:00:00"   value="<?php if($_staff){echo $_staff['tus_to'];}else{echo $u['tus_to'];} ?>">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="custom-control-input" name="wed" value="1" id="<?php echo $lang['WED'];?>" 
                                                       <?php if($_staff){if($_staff['wed'] == 1){echo 'checked';}}else{if($u['wed'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['WED'];?>"><b><?php echo $lang['WED'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                          <input type="datetime" class="form-control onlytime" autocomplete="off" name ="wed_from" placeholder="00:00:00"  value="<?php if($_staff){echo $_staff['wed_from'];}else{echo $u['wed_from'];} ?>">
                                        </td>
                                        <td>
                                            <input type="datetime" class="form-control onlytime" autocomplete="off" name ="wed_to" placeholder="00:00:00"   value="<?php if($_staff){echo $_staff['wed_to'];}else{echo $u['wed_from'];} ?>">
                                        </td>
                                      </tr>
                                     <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="custom-control-input" name="thurs" value="1" id="<?php echo $lang['THU'];?>" 
                                                       <?php if($_staff){if($_staff['thurs'] == 1){echo 'checked';}}else{if($u['thurs'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['THU'];?>"><b><?php echo $lang['THU'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                          <input type="datetime" class="form-control onlytime" autocomplete="off" name ="thurs_from" placeholder="00:00:00"  value="<?php if($_staff){echo $_staff['thurs_from'];}else{echo $u['thurs_from'];} ?>">
                                        </td>
                                        <td>
                                            <input type="datetime" class="form-control onlytime" autocomplete="off" name ="thurs_to" placeholder="00:00:00"   value="<?php if($_staff){echo $_staff['thurs_to'];}else{echo $u['thurs_from'];} ?>">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="custom-control-input" name="fri" value="1" id="<?php echo $lang['FRI'];?>" 
                                                       <?php if($_staff){if($_staff['fri'] == 1){echo 'checked';}}else{if($u['fri'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['FRI'];?>"><b><?php echo $lang['FRI'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                          <input type="datetime" class="form-control onlytime" autocomplete="off" name ="fri_from" placeholder="00:00:00"  value="<?php if($_staff){echo $_staff['fri_from'];}else{echo $u['fri_from'];} ?>">
                                        </td>
                                        <td>
                                            <input type="datetime" class="form-control onlytime" autocomplete="off" name ="fri_to" placeholder="00:00:00"   value="<?php if($_staff){echo $_staff['fri_to'];}else{echo $u['fri_from'];} ?>">
                                        </td>
                                      </tr>    
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                         <br/>  
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
                                  
									<option value="0" <?php if($_staff){if($_staff[status] == 0){echo 'selected';}}else{if($u[status] == 0){echo 'selected';}}?>>
                                        <?php echo $lang['deactive'];?></option>
								  <option value="1" <?php if($_staff){if($_staff[status] == 1){echo 'selected';}}else{if($u[status] == 1){echo 'selected';}}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_staff'];?></button>
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