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
        exit;
	}else{
        if($group['groups_edit'] == 0){
            header("Location:./permission.php");
            exit;
        }else{
              $id    = intval($_GET['id']);
              if($id != 0)
              {
                $u  = $groups->getgroupsInformation($id);
                if($_POST)
                {
                  $_group['id']                           =          $id;
                  $_group['name']                         =          sanitize($_POST["name"]);
                  $_group["users_view"]                   =          intval($_POST["users_view"]);
                  $_group["users_edit"]                   =          intval($_POST["users_edit"]);
                  $_group["users_delete"]                 =          intval($_POST["users_delete"]);
                  $_group["users_add"]                    =          intval($_POST["users_add"]);
                  $_group["branches_view"]                =          intval($_POST["branches_view"]);
                  $_group["branches_edit"]                =          intval($_POST["branches_edit"]);
                  $_group["branches_delete"]              =          intval($_POST["branches_delete"]);
                  $_group["branches_add"]                 =          intval($_POST["branches_add"]);
                  $_group["services_view"]                =          intval($_POST["services_view"]);
                  $_group["services_edit"]                =          intval($_POST["services_edit"]);
                  $_group["services_delete"]              =          intval($_POST["services_delete"]);
                  $_group["services_add"]                 =          intval($_POST["services_add"]);
                  $_group["staffs_view"]                  =          intval($_POST["staffs_view"]);
                  $_group["staffs_edit"]                  =          intval($_POST["staffs_edit"]);
                  $_group["staffs_delete"]                =          intval($_POST["staffs_delete"]);
                  $_group["staffs_add"]                   =          intval($_POST["staffs_add"]);
                  $_group["categories_view"]              =          intval($_POST["categories_view"]);
                  $_group["categories_edit"]              =          intval($_POST["categories_edit"]);
                  $_group["categories_delete"]            =          intval($_POST["categories_delete"]);
                  $_group["categories_add"]               =          intval($_POST["categories_add"]);
                  $_group["products_view"]                =          intval($_POST["products_view"]);
                  $_group["products_edit"]                =          intval($_POST["products_edit"]);
                  $_group["products_delete"]              =          intval($_POST["products_delete"]);
                  $_group["products_add"]                 =          intval($_POST["products_add"]);
                  $_group["orders_view"]                  =          intval($_POST["orders_view"]);
                  $_group["orders_edit"]                  =          intval($_POST["orders_edit"]);
                  $_group["orders_delete"]                =          intval($_POST["orders_delete"]);
                  $_group["orders_add"]                   =          intval($_POST["orders_add"]);
                  $_group["groups_view"]                  =          intval($_POST["groups_view"]);
                  $_group["groups_edit"]                  =          intval($_POST["groups_edit"]);
                  $_group["groups_delete"]                =          intval($_POST["groups_delete"]);
                  $_group["groups_add"]                   =          intval($_POST["groups_add"]);
                  $_group["service_order_view"]           =          intval($_POST["service_order_view"]);
                  $_group["service_order_edit"]           =          intval($_POST["service_order_edit"]);
                  $_group["service_order_delete"]         =          intval($_POST["service_order_delete"]);
                  $_group["service_order_add"]            =          intval($_POST["service_order_add"]);
                  $_group["gallery_view"]                 =          intval($_POST["gallery_view"]);
                  $_group["gallery_delete"]               =          intval($_POST["gallery_delete"]);
                  $_group["gallery_add"]                  =          intval($_POST["gallery_add"]);
                  $_group["best_sellers_view"]            =          intval($_POST["best_sellers_view"]);
                  $_group["salons_edit"]                  =          intval($_POST["salons_edit"]);
                  $_group["rates_view"]                   =          intval($_POST["rates_view"]);
                  $_group["logs_view"]                    =          intval($_POST["logs_view"]);
                  $_group['status']                       =          intval($_POST["status"]);


                    if ($_group['name'] =="" )
                    {
                        $errors['name'] = $lang['no_group_name'];
                    }
                    if(empty($errors)){
                        $logs->addLog(67,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"groups",
                                    "mode" 		        => 	"update",
                                    "group_id" 		    => 	$_group['id'],
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                        $update = $groups->setgroupsInformation($_group);
                        if($update == 1){
                            header("Location:./groups.php?message=update");
                            exit;
                        }

                    }
                }
              }else{
                header("Location:./error.php");
                  exit;
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
                      <h4 class="card-title"><?php echo $lang['edit_group'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./groups_edit.php?id=<?php echo $u['group_serial'];?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php if($_group){echo $_group['name'];}else{echo $u['group_name'];} ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="checkall btn btn-primary pull-right"><?php echo $lang['SELECT_ALL'];?></button>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="table-responsive">
                                     <table class="table table-bordered table-sm">
                                        <thead>
                                          <tr>
                                            <th><?php echo $lang['PAGE'];?></th>
                                            <th><?php echo $lang['SHOW_VIEW'];?></th>
                                            <th><?php echo $lang['ADD_CONTROLLER'];?></th>
                                            <th><?php echo $lang['DELETE_CONTROLLER'];?></th>
                                            <th><?php echo $lang['EDIT_CONTROLLER'];?></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>
                                                <h4><?php echo $lang['groups'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="groups_view" value="1" id="groups_view"
                                                           <?php if($_group){if($_group['groups_view'] == 1){echo 'checked';}}else{if($u['groups_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="groups_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="groups_add" value="1" id="groups_add"
                                                           <?php if($_group){if($_group['groups_add'] == 1){echo 'checked';}}else{if($u['groups_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="groups_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="groups_delete" value="1" id="groups_delete"
                                                           <?php if($_group){if($_group['groups_delete'] == 1){echo 'checked';}}else{if($u['groups_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="groups_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="groups_edit" value="1" id="groups_edit"
                                                           <?php if($_group){if($_group['groups_edit'] == 1){echo 'checked';}}else{if($u['groups_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="groups_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                         <tr>
                                            <td>
                                                <h4><?php echo $lang['users'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="users_view" value="1" id="users_view"
                                                           <?php if($_group){if($_group['users_view'] == 1){echo 'checked';}}else{if($u['users_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="users_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="users_add" value="1" id="users_add"
                                                           <?php if($_group){if($_group['users_add'] == 1){echo 'checked';}}else{if($u['users_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="users_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="users_delete" value="1" id="users_delete"
                                                           <?php if($_group){if($_group['users_delete'] == 1){echo 'checked';}}else{if($u['users_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="users_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="users_edit" value="1" id="users_edit"
                                                           <?php if($_group){if($_group['users_edit'] == 1){echo 'checked';}}else{if($u['users_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="users_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                        <tr>
                                            <td>
                                                <h4><?php echo $lang['branches'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="branches_view" value="1" id="branches_view"
                                                           <?php if($_group){if($_group['branches_view'] == 1){echo 'checked';}}else{if($u['branches_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="branches_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="branches_add" value="1" id="branches_add"
                                                           <?php if($_group){if($_group['branches_add'] == 1){echo 'checked';}}else{if($u['branches_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="branches_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="branches_delete" value="1" id="branches_delete"
                                                           <?php if($_group){if($_group['branches_delete'] == 1){echo 'checked';}}else{if($u['branches_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="branches_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="branches_edit" value="1" id="branches_edit"
                                                           <?php if($_group){if($_group['branches_edit'] == 1){echo 'checked';}}else{if($u['branches_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="branches_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                        <tr>
                                            <td>
                                                <h4><?php echo $lang['services'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="services_view" value="1" id="services_view"
                                                           <?php if($_group){if($_group['services_view'] == 1){echo 'checked';}}else{if($u['services_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="services_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="services_add" value="1" id="services_add"
                                                           <?php if($_group){if($_group['services_add'] == 1){echo 'checked';}}else{if($u['services_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="services_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="services_delete" value="1" id="services_delete"
                                                           <?php if($_group){if($_group['services_delete'] == 1){echo 'checked';}}else{if($u['services_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="services_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="services_edit" value="1" id="services_edit"
                                                           <?php if($_group){if($_group['services_edit'] == 1){echo 'checked';}}else{if($u['services_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="services_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                        <tr>
                                            <td>
                                                <h4><?php echo $lang['staffs'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="staffs_view" value="1" id="staffs_view"
                                                           <?php if($_group){if($_group['staffs_view'] == 1){echo 'checked';}}else{if($u['staffs_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="staffs_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="staffs_add" value="1" id="staffs_add"
                                                           <?php if($_group){if($_group['staffs_add'] == 1){echo 'checked';}}else{if($u['staffs_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="staffs_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="staffs_delete" value="1" id="staffs_delete"
                                                           <?php if($_group){if($_group['staffs_delete'] == 1){echo 'checked';}}else{if($u['staffs_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="staffs_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="staffs_edit" value="1" id="staffs_edit"
                                                           <?php if($_group){if($_group['staffs_edit'] == 1){echo 'checked';}}else{if($u['staffs_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="staffs_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                         <tr>
                                            <td>
                                                <h4><?php echo $lang['categories'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="categories_view" value="1" id="categories_view"
                                                           <?php if($_group){if($_group['categories_view'] == 1){echo 'checked';}}else{if($u['categories_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="categories_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="categories_add" value="1" id="categories_add"
                                                           <?php if($_group){if($_group['categories_add'] == 1){echo 'checked';}}else{if($u['categories_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="categories_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="categories_delete" value="1" id="categories_delete"
                                                           <?php if($_group){if($_group['categories_delete'] == 1){echo 'checked';}}else{if($u['categories_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="categories_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="categories_edit" value="1" id="categories_edit"
                                                           <?php if($_group){if($_group['categories_edit'] == 1){echo 'checked';}}else{if($u['categories_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="categories_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                        <tr>
                                            <td>
                                                <h4><?php echo $lang['products'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="products_view" value="1" id="products_view"
                                                           <?php if($_group){if($_group['products_view'] == 1){echo 'checked';}}else{if($u['products_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="products_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="products_add" value="1" id="products_add"
                                                           <?php if($_group){if($_group['products_add'] == 1){echo 'checked';}}else{if($u['products_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="products_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="products_delete" value="1" id="products_delete"
                                                           <?php if($_group){if($_group['products_delete'] == 1){echo 'checked';}}else{if($u['products_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="products_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="products_edit" value="1" id="products_edit"
                                                           <?php if($_group){if($_group['products_edit'] == 1){echo 'checked';}}else{if($u['products_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="products_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                        <tr>
                                            <td>
                                                <h4><?php echo $lang['orders'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="orders_view" value="1" id="orders_view"
                                                           <?php if($_group){if($_group['orders_view'] == 1){echo 'checked';}}else{if($u['orders_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="orders_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="orders_add" value="1" id="orders_add"
                                                           <?php if($_group){if($_group['orders_add'] == 1){echo 'checked';}}else{if($u['orders_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="orders_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="orders_delete" value="1" id="orders_delete"
                                                           <?php if($_group){if($_group['orders_delete'] == 1){echo 'checked';}}else{if($u['orders_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="orders_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="orders_edit" value="1" id="orders_edit"
                                                           <?php if($_group){if($_group['orders_edit'] == 1){echo 'checked';}}else{if($u['orders_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="orders_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                         <tr>
                                            <td>
                                                <h4><?php echo $lang['service_orders'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="service_order_view" value="1" id="service_order_view"
                                                           <?php if($_group){if($_group['service_order_view'] == 1){echo 'checked';}}else{if($u['service_order_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="service_order_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="service_order_add" value="1" id="service_order_add"
                                                           <?php if($_group){if($_group['service_order_add'] == 1){echo 'checked';}}else{if($u['service_order_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="service_order_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="service_order_delete" value="1" id="service_order_delete"
                                                           <?php if($_group){if($_group['service_order_delete'] == 1){echo 'checked';}}else{if($u['service_order_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="service_order_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="service_order_edit" value="1" id="service_order_edit"
                                                           <?php if($_group){if($_group['service_order_edit'] == 1){echo 'checked';}}else{if($u['service_order_edit'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="service_order_edit"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                          </tr>
                                         <tr>
                                            <td>
                                                <h4><?php echo $lang['gallery'];?></h4>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="gallery_view" value="1" id="gallery_view"
                                                           <?php if($_group){if($_group['gallery_view'] == 1){echo 'checked';}}else{if($u['gallery_view'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="gallery_view"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="gallery_add" value="1" id="gallery_add"
                                                           <?php if($_group){if($_group['gallery_add'] == 1){echo 'checked';}}else{if($u['gallery_add'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="gallery_add"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-checkbox col-md-3">
                                                    <input type="checkbox" class="checkhour custom-control-input" name="gallery_delete" value="1" id="gallery_delete"
                                                           <?php if($_group){if($_group['gallery_delete'] == 1){echo 'checked';}}else{if($u['gallery_delete'] == 1){echo 'checked';}}?>/>
                                                     <label class="custom-control-label" for="gallery_delete"><b><?php echo $lang['active'];?></b></label>
                                                </div>
                                            </td>
                                            <td>
                                            </td>
                                          </tr>

                                        </tbody>
                                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="checkhour custom-control-input" name="best_sellers_view" value="1" id="best_sellers_view"
                                           <?php if($_group){if($_group['best_sellers_view'] == 1){echo 'checked';}}else{if($u['best_sellers_view'] == 1){echo 'checked';}}?>/>
                                     <label class="custom-control-label" for="best_sellers_view"><b><?php echo $lang['best_sellers_view'];?></b></label>
                                </div>
                            </div>
                          </div>
                           <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="checkhour custom-control-input" name="salons_edit" value="1" id="salons_edit"
                                           <?php if($_group){if($_group['salons_edit'] == 1){echo 'checked';}}else{if($u['salons_edit'] == 1){echo 'checked';}}?>/>
                                     <label class="custom-control-label" for="salons_edit"><b><?php echo $lang['SETTING_MANGMENT'];?></b></label>
                                </div>
                            </div>
                          </div>
                           <div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="checkhour custom-control-input" name="rates_view" value="1" id="rates_view"
                                           <?php if($_group){if($_group['rates_view'] == 1){echo 'checked';}}else{if($u['rates_view'] == 1){echo 'checked';}}?>/>
                                     <label class="custom-control-label" for="rates_view"><b><?php echo $lang['rates_view'];?></b></label>
                                </div>
                            </div>
                          </div><div class="col-md-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="checkhour custom-control-input" name="logs_view" value="1" id="logs_view"
                                           <?php if($_group){if($_group['logs_view'] == 1){echo 'checked';}}else{if($u['logs_view'] == 1){echo 'checked';}}?>/>
                                     <label class="custom-control-label" for="logs_view"><b><?php echo $lang['LOGS_VIEW'];?></b></label>
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

									<option value="0" <?php if($_group){if($_group['status'] == 0){echo 'selected';}}else{if($u['status'] == 0){echo 'selected';}}?>>
                                        <?php echo $lang['deactive'];?></option>
								  <option value="1" <?php if($_group){if($_group['status'] == 1){echo 'selected';}}else{if($u['status'] == 1){echo 'selected';}}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_group'];?></button>
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
