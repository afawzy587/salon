<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';

    include("./inc/Classes/system-service_order.php");
	$service_order = new systemservice_order();

    include("./inc/Classes/system-services.php");
	$services = new systemservices();

    include("./inc/Classes/system-branches.php");
	$branches = new systembranches();

    include("./inc/Classes/system-users.php");
	$users = new systemusers();

    include("./inc/Classes/system-staffs.php");
	$staff = new systemstaff();


	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($group['service_order_edit'] == 0){
            header("Location:./permission.php");
        }else{

            $id    = intval($_GET['id']);
            if($id != 0)
            {
                $u          = $service_order->getservice_orderInformation($id);
                $staffs     = $staff->getbranchstaff($u['branch_id']);
                $services   = $services->getsiteservices();
                $user       = $users->getsiteusers();
                $branch     = $branches->getsitebranches();
                $user_id    = intval($_GET['user']);
                if($_POST)
                {
                    if( $user_id == 0)
                    {
                        $_order['user_id']       =       intval($_POST["user_id"]);
                    }else{
                        $_order['user_id']       =       $user_id;

                    }
                    $_order['id']                =       $id;
                    $_order['type']              =       sanitize($_POST["type"]);
                    $_order['branch_id']         =       intval($_POST["branch_id"]);
                    $_order['service_id']        =       $_POST["service"];
                    $_order['price']             =       $_POST["price"];
                    $_order['status']            =       intval($_POST["status"]);


                    if ($_order['user_id'] == 0 )
                    {
                        $errors['user_id'] = $lang['INSERT_USER_ID'];
                    }
                    if ($_order['branch_id'] == 0 )
                    {
                        $errors['branch_id'] = $lang['INSERT_BRANCH_ID'];
                    }

                    if ($_order['service_id'] == 0 )
                    {
                        $errors['service_id'] = $lang['INSERT_service_ID'];
                    }

                    if ($_order['type'] == "" && ( $_order['type'] !='home' || $_order['type'] !='branch' ) )
                    {
                        $errors['type'] = $lang['INSERT_ORDER_TYPE'];
                    }
                    if(is_array($_order['service_id']))
                    {
                       foreach($_POST["service"] as $k => $v)
                        {
                           if($_order['service_id'][$k] != 0)
                            {
                                if(intval($_POST['staff'][$k]) == 0)
                                {
                                    $p =$k+1;
                                    $errors['staff'] = $lang['INSERT_service_staff'] .$p;
                                }else{
                                     $_order['staff'][$k] = $_POST["staff"][$k];
                                     $_order['date'][$k]  = $_POST["date"][$k];
                                }

                               if(intval($_POST['date'][$k]) == "")
                                {
                                    $p =$k+1;
                                    $errors['date'] = $lang['INSERT_service_date'] .$p;
                                }else{
                                     $_order['date'][$k]  = $_POST["date"][$k];
                                }
                           }
                        }
                    }

                    $staffs     = $staff->getbranchstaff($_order['branch_id']);


                    if(empty($errors)){
                        $update = $service_order->setservice_orderInformation($_order);
                        $logs->addLog(94,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"service_order",
										"mode" 		        => 	"update",
										"order_id" 		    => 	$_order['id'],
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                        if($update == 1){
                            header("Location:./service_order.php?message=update");
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
                      <h4 class="card-title"><?php echo $lang['add_order'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./service_order_edit.php?id=<?php echo $u['service_order_serial'];?>" method="post" enctype="multipart/form-data">
                          <br>
                        <?php if(!$user_id){
                                echo '<div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="bmd-label-floating">'.$lang["user"].'</label>
                                      <select class="browser-default custom-select choose" name="user_id">
                                          <option disabled  selected>'.$lang["choose"].'</option>';
                                           if(!empty($user))
                                                {
                                                    foreach($user as $k => $s)
                                                    {
                                                        echo '<option value="'.$s['user_serial'].'"';if($_order){if($s['user_serial'] == $_order['user_id']){echo 'selected';}}else{if($s['user_serial'] == $u['user_id']){echo 'selected';}}echo'>'.$s['user_name'].'</option>';
                                                    }
                                                }
                                    echo '</select>
                                    </div>
                                  </div>
                                </div>';
                            }
                          ?>
                          <div class="row branch">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="bmd-label-floating"><?php echo $lang["branch"] ?></label>
                                      <select class="branch browser-default custom-select choose " name="branch_id">
                                          <option disabled  selected><?php echo $lang["choose"];?></option>
                                          <?php
                                           if(!empty($branch))
                                                {
                                                    foreach($branch as $k => $b)
                                                    {
                                                        echo '<option value="'.$b['branch_serial'].'"';if($_order){if($b['branch_serial'] == $_order['branch_id']){echo 'selected';}}else{if($b['branch_serial'] == $u['branch_id']){echo 'selected';}}echo'>'.getbranchname($b['branch_serial']).'</option>';
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
                              <label class="bmd-label-floating"><?php echo $lang['order_type'];?></label>
                              <select class="browser-default custom-select" name="type">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
									<option value="home" <?php if($_order){if($_order['type'] == 'home'){echo 'selected';}}else{if($u['service_order_type'] == 'home'){echo 'selected';}}?>><?php echo $lang['from_home'];?></option>
								  <option value="branch"<?php if($_order){if($_order['type'] == 'branch'){echo 'selected';}}else{if($u['service_order_type'] == 'branch'){echo 'selected';}}?>><?php echo $lang['from_branch'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                             <table class="table  table-sm">
                                 <thead>
                                     <tr>
                                         <th><?php echo $lang['service'];?></th>
                                         <th><?php echo $lang['staff'];?></th>
                                         <th><?php echo $lang['date'];?></th>
                                         <th><?php echo $lang['price'];?></th>
                                     </tr>
                                 </thead>
                                 <tbody class="request">

                                     <?php if($_order)
                                           {
                                                if(is_array($_order['service_id']))
                                                {
                                                   foreach($_order['service_id'] as $k => $_p)
                                                    {
                                                        echo '<tr id="tr_'.$k.'">
                                                                <td >
                                                                 <div class="form-group" id="'.$k.'">
                                                                  <select class="service browser-default custom-select "  name="service[]" >
                                                                      <option disabled  selected>'.$lang['service'].'</option>';
                                                                        foreach($services as $p)
                                                                        {
                                                                            echo'<option value="'.$p['service_serial'].'"';if($p['service_serial'] == $_order['service_id'][$k]){ echo "selected";} echo'>'.$p['service_name'].'</option>';
                                                                        }
                                                               echo'</select>
                                                                </div>
                                                             </td>
                                                              <td >
                                                                 <div class="form-group" >
                                                                  <select class="staff browser-default custom-select "  name="staff[]" >';
                                                                        if(is_array($staffs))
                                                                        {
                                                                            echo'<option disabled  selected>'.$lang['staff'].'</option>';
                                                                            foreach($staffs as $s)
                                                                            {
                                                                                echo'<option value="'.$s['staff_serial'].'"';if($s['staff_serial'] == $_order['staff'][$k]){ echo "selected";} echo'>'.$s['staff_name'].'</option>';
                                                                            }
                                                                        }else{
                                                                            echo '<option value="">'.$lang['no_branch_staff'].'</option>';
                                                                        }

                                                               echo'</select>
                                                                </div>
                                                             </td>
                                                             <td>
                                                                <div class="form-group">
                                                                  <input type="datetime" class="date form-control" autocomplete="off"  name ="date[]"  value="'.$_order['date'][$k].'">
                                                                </div>
                                                             </td>
                                                             <td>
                                                                 <div class="form-group">
                                                                  <input type="number" class="form-control price" step="any" min="1" placeholder='.$lang['price'].' id="price_'.$time.'" name ="price[]"  value="'.$_order['price'][$k].'" readonly>
                                                                </div>
                                                             </td>
                                                             <td id="item_'.$k.'">
                                                                <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_service\'>
                                                                    <i class=\'material-icons\'>close</i>
                                                                </a>
                                                             </td>
                                                             </tr>';
                                                    }
                                                }else{
                                                    echo'<tr >
                                                     <td >
                                                         <div class="form-group" id=1>
                                                          <select class="browser-default custom-select service " name="service[]">
                                                              <option disabled  selected>'.$lang['service'].'</option>';
                                                               if(!empty($services))
                                                                {
                                                                    foreach($services as $k => $p)
                                                                    {
                                                                        echo '<option value="'.$p['service_serial'].'"';if($p['service_serial'] == $_order['service_id']){echo 'selected';}echo'>'.$p['service_name'].'</option>';
                                                                    }
                                                                }
                                                        echo'</select>
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group" id=1>
                                                          <select class="staff browser-default custom-select " name="staff[]">
                                                              <option disabled  selected>'.$lang['CHOOSE_BRANCH_FIRST'].'</option>';
                                                        echo'</select>
                                                        </div>
                                                     </td>
                                                     <td>
                                                        <div class="form-group">
                                                          <input type="datetime" class="date form-control" autocomplete="off"  name ="date[]"  value="'.$_order['date'][$k].'">
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <input type="number" class="form-control" min="1" step="any" name ="price[]" placeholder="'.$lang['price'].'" id="price_1" value="" readonly>
                                                        </div>
                                                     </td>
                                                 </tr>';
                                                }
                                            }else{
                                            if(is_array($u['sevices']))
                                            {
                                               foreach($u['sevices'] as $k => $_s)
                                               {
                                                   echo '<tr id="tr_'.$k.'">
                                                            <td >
                                                             <div class="form-group" id="'.$k.'">
                                                              <select class="service browser-default custom-select "  name="service[]" >
                                                                  <option disabled  selected>'.$lang['service'].'</option>';
                                                                    foreach($services as $p)
                                                                    {
                                                                        echo'<option value="'.$p['service_serial'].'"';if($p['service_serial'] == $_s['service_id']){ echo "selected";} echo'>'.$p['service_name'].'</option>';
                                                                    }
                                                           echo'</select>
                                                            </div>
                                                         </td>
                                                          <td >
                                                             <div class="form-group" >
                                                              <select class="staff browser-default custom-select "  name="staff[]" >';
                                                                    if(is_array($staffs))
                                                                    {
                                                                        echo'<option disabled  selected>'.$lang['staff'].'</option>';
                                                                        foreach($staffs as $s)
                                                                        {
                                                                            echo'<option value="'.$s['staff_serial'].'"';if($s['staff_serial'] == $_s['staff_id']){ echo "selected";} echo'>'.$s['staff_name'].'</option>';
                                                                        }
                                                                    }else{
                                                                        echo '<option value="">'.$lang['no_branch_staff'].'</option>';
                                                                    }

                                                           echo'</select>
                                                            </div>
                                                         </td>
                                                         <td>
                                                            <div class="form-group">
                                                              <input type="datetime" class="date form-control" autocomplete="off"  name ="date[]"  value="'.$_s['start_time'].'">
                                                            </div>
                                                         </td>
                                                         <td>
                                                             <div class="form-group">
                                                              <input type="number" class="form-control price" step="any" min="1" placeholder='.$lang['price'].' id="price_'.$time.'" name ="price[]"  value="'.$_s['cost'].'" readonly>
                                                            </div>
                                                         </td>
                                                         <td id="item_'.$k.'">
                                                            <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_order_service\'>
                                                                <i class=\'material-icons\'>close</i>
                                                            </a>
                                                         </td>
                                                         </tr>';
                                           }
                                            }else{
                                                echo'<tr>
                                                     <td>
                                                         <div class="form-group" id=1>
                                                          <select class="service browser-default custom-select " name="service[]">
                                                              <option disabled  selected>'.$lang['service'].'</option>';
                                                               if(!empty($services))
                                                                {
                                                                    foreach($services as $k => $p)
                                                                    {
                                                                        echo '<option value="'.$p['service_serial'].'">'.$p['service_name'].'</option>';
                                                                    }
                                                                }
                                                        echo'</select>
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group" id=1>
                                                          <select class="staff browser-default custom-select" name="staff[]">
                                                              <option disabled  selected>'.$lang['CHOOSE_BRANCH_FIRST'].'</option>
                                                         </select>
                                                        </div>
                                                     </td>
                                                     <td>
                                                        <div class="form-group">
                                                          <input type="datetime" class="date form-control" autocomplete="off"  name ="date[]"  value="">
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <input type="number" class="form-control" min="1" step="any" name ="price[]" placeholder="'.$lang['price'].'" id="price_1" value="" readonly>
                                                        </div>
                                                     </td>
                                                 </tr>';
                                            }
                                        }
                                     ?>


                                 </tbody>
                                 <tfoot class="services">
                                     <tr>
                                         <td>
                                             <div class="form-group">
                                                <a class="addservice btn btn-success btn-xs" ><i class="fa fa-plus"></i><?php echo $lang['add'];?></a>
                                            </div>
                                         </td>
                                     </tr>
                                 </tfoot>
                             </table>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['status'];?></label>
                              <select class="browser-default custom-select" name="status">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
								  <option value="1"<?php if($_order){if($_order[status] == 0){echo 'selected';}}else{if($u[status] == 0){echo 'selected';}}?>><?php echo $lang['admin_cancel'];?></option>
								  <option value="1"<?php if($_order){if($_order[status] == 1){echo 'selected';}}else{if($u[status] == 1){echo 'selected';}}?>><?php echo $lang['unfinished'];?></option>
								  <option value="2"<?php if($_order){if($_order[status] == 2){echo 'selected';}}else{if($u[status] == 2){echo 'selected';}}?>><?php echo $lang['DONE'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                          <br>
                        <div class="clearfix">
                             <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_order'];?></button>
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
