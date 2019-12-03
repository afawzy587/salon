<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-groups.php");
	$groups = new systemgroups();

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($_GET['id'] != 0 )
		{

			$group = $groups->getgroupsInformation($_GET['id']);
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
                      <h4 class="card-title"><?php echo $lang['group_details'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="card card-profile">
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $group['group_name'];?></h2>
                          <h4 class="card-category text-gray"><span style="width:75%;display:inline-block;"><?php if($group['status'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';}else{
                                        echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['active'].'</i>';}?></span></h4>
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['groups'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['groups_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['groups_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['groups_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['groups_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['users'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['users_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['users_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['users_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['users_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['branches'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['branches_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['branches_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['branches_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['branches_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['services'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['services_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['services_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['services_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['services_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['staffs'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['staffs_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['staffs_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['staffs_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['staffs_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['categories'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['categories_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['categories_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['categories_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['categories_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['products'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['products_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['products_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['products_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['products_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['orders'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['orders_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['orders_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['orders_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['orders_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['service_orders'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['service_order_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['service_order_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['service_order_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['EDIT_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['EDIT_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['service_order_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['gallery'];?> : </strong></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['gallery_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['gallery_add'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['ADD_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['ADD_CONTROLLER'].'</i>';}?></span>
                                    <span style="width:20%;display:inline-block;"><?php if ($group['gallery_delete'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['DELETE_CONTROLLER'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['DELETE_CONTROLLER'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['best_sellers'];?> : </strong></span>
                                    <span style="width:80%;display:inline-block;"><?php if ($group['best_sellers_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['rates'];?> : </strong></span>
                                    <span style="width:80%;display:inline-block;"><?php if ($group['rates_view'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
				                <div class="alert">
                                    <span style="width:10%;display:inline-block;vertical-align:top;"><strong> <?php echo $lang['SETTING_MANGMENT'];?> : </strong></span>
                                    <span style="width:80%;display:inline-block;"><?php if ($group['salons_edit'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SHOW_VIEW'].'</i>';}else{echo '<i class="fa fa-check" style="font-size:18px" dir="ltr" >'.$lang['SHOW_VIEW'].'</i>';}?></span>
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
                  <?php if($group['groups_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="groups_edit.php?id='.$group['group_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['groups_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="groups.php?do=del&id='.$group['group_serial'].'">'.$lang['delete'].'</a>';
                  } ?>


             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>