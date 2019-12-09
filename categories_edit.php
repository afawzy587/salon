<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-categories.php");
	$categories = new systemcategories();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($group['categories_edit'] == 0){
            header("Location:./permission.php");
        }else{ 
        
            $id    = $_GET['id'];
            if($id != 0){
                $u  = $categories->getcategoriesInformation($id);
                if($_POST)
                {
                    $_category['id']         =       $id;
                    $_category['name']       =       sanitize($_POST["name"]);
                    $_category['status']     =       intval($_POST["status"]);


                    if ($_category[name] =="" )
                    {
                        $errors[name] = $lang['no_category_name'];
                    }else{
                        $check = $categories->iscategoriesExists($_category['name']);
                        if(is_array($check))
                        {
                            if($check['id'] != $_category['id'])
                            {
                                $errors[name] = $lang['add_this_category_before'];
                            }
                        }
                    }

                    if(empty($errors)){
                        $update = $categories->setcategoriesInformation($_category);
                        $logs->addLog(60,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"categories",
                                "mode" 		        => 	"update",
                                "category" 		    => 	$_category['id'],
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
                        if($update == 1){
                            header("Location:./categories.php?message=update");
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
                      <h4 class="card-title"><?php echo $lang['edit_category'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./categories_edit.php?id=<?php echo $u['category_serial'];?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php if($_category){echo $_category['name'];}else{echo $u['category_name'];} ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['status'];?></label>
                              <select class="browser-default custom-select" name="status">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
                                  
									<option value="0" <?php if($_category){if($_category['status'] == 0){echo 'selected';}}else{if($u['status'] == 0){echo 'selected';}}?>>
                                        <?php echo $lang['deactive'];?></option>
								  <option value="1" <?php if($_category){if($_category['status'] == 1){echo 'selected';}}else{if($u['status'] == 1){echo 'selected';}}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                          <br>
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_category'];?></button>
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
