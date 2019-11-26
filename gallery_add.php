<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-gallery.php");
	$gallery = new systemgallery();
	

	
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($group['gallery_add'] == 0){
            header("Location:./permission.php");
        }else{ 
            if($_POST)
            {
                $_gallery['type']       =       sanitize($_POST["type"]);
                $_gallery['link']       =       sanitize($_POST["link"]);
                $_gallery['status']     =       intval($_POST["status"]);


                if ($_gallery[type] =="" )
                {
                    $errors[type] = $lang['no_gallery_type'];
                }
                
                
                if($_gallery[type] == 'video'){
                    if ($_gallery['link'] =="" )
                    {
                        $errors['link'] = $lang['no_video_link'];
                    }
                }
                
                
                
                if($_gallery[type] == 'image')
                {
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
                            $_gallery[image] = $upfile[newname];
                        }else
                        {
                           $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                        }
                    }
                }


                if(empty($errors)){
                    $add = $gallery->addNewgallery($_gallery);
                    if($add == 1){
                        header("Location:./gallery.php?message=add");
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
                  <script>
                    function showDiv(element)
                        {
                            document.getElementById('video').style.display = element.value == 'video' ? 'block' : 'none',
                            document.getElementById('image').style.display = element.value == 'image' ? 'block' : 'none';
                        }
                  </script>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title"><?php echo $lang['add_gallery'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./gallery_add.php" method="post" enctype="multipart/form-data">
                          
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['type'];?></label>
                              <select class="browser-default custom-select" name="type" onchange="showDiv(this  )">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
									<option value="image" <?php if($_gallery[type] == 'image'){echo 'selected';}?>><?php echo $lang['image'];?></option>
								  <option value="video"<?php if($_gallery[type] == 'video'){echo 'selected';}?>><?php echo $lang['video'];?></option>
								</select>
                            </div>
                          </div>
                        </div>  
                        <div class="row" id='video' style="display:block">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['link'];?></label>
                              <input type="link" class="form-control" name ="link"  value="<?php echo $_gallery['name'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row" id="image" style="display:none">
                          <div class="col-md-12">
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
									<option value="0" <?php if($_gallery[status] == 0){echo 'selected';}?>><?php echo $lang['deactive'];?></option>
								  <option value="1"<?php if($_gallery[status] == 1){echo 'selected';}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['add_gallery'];?></button>
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