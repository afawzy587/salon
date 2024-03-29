<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';

    include("./inc/Classes/system-orders.php");
	$orders = new systemorders();

    include("./inc/Classes/system-products.php");
	$products = new systemproducts();

    include("./inc/Classes/system-users.php");
	$users = new systemusers();

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
        exit;
	}else{
        if($group['users_add'] == 0){
            header("Location:./permission.php");
            exit;
        }else{
            $id    = intval($_GET['id']);
            if($id != 0)
            {

                $products = $products->getsiteproducts();
                $u        = $orders->getordersInformation($id);
                $user     = $users->getsiteusers();
                $user_id  = intval($_GET['user']);
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
                    $_order['product_id']        =       $_POST["product"];
                    $_order['price']             =       $_POST["price"];
                    $_order['total']             =       $_POST["total"];
                    $_order['item']              =       $_POST["item"];
                    $_order['status']            =       intval($_POST["status"]);


                    if ($_order['user_id'] == 0 )
                    {
                        $errors['user_id'] = $lang['INSERT_USER_ID'];
                    }

                    if ($_order['product_id'] == 0 )
                    {
                        $errors['product_id'] = $lang['INSERT_PRODUCT_ID'];
                    }

                    if ($_order['type'] == "" && ( $_order['type'] !='home' || $_order['type'] !='branch' ) )
                    {
                        $errors['type'] = $lang['INSERT_ORDER_TYPE'];
                    }
                    if(is_array($_order['product_id']))
                    {
                       foreach($_POST["product"] as $k => $v)
                        {
                           if($_order['product_id'][$k] != 0)
                            {
                                if(intval($_POST['quantity'][$k]) == 0)
                                {
                                    $p =$k+1;
                                    $errors['quantity'] = $lang['INSERT_PRODUCT_QUANTITY'] .$p;
                                }else{
                                     $_order['quantity'][$k] = $_POST["quantity"][$k];
                                }
                           }
                        }
                    }


                    if(empty($errors)){
                        $edit = $orders->setordersInformation($_order);
                        if($_order['status'] == 2)
                        {
                            updatebestseller($_order['id']);
                        }
                        $logs->addLog(76,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"orders",
                                    "mode" 		        => 	"update",
                                    "order_id" 		    => 	$_order['id'],
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                        if($edit == 1){
                            header("Location:./orders.php?message=update");
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
                <input type="hidden" value="<?php echo $lang['product']?>" id="lang_name">
                <input type="hidden" value="<?php echo $lang['delete_alarm_massage_in_men']?>" id="lang_del">
                <input type="hidden" value="<?php echo $lang['status_alarm_massage_in_men']?>" id="lang_status">
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
                  <SCRIPT>
                   function cal(){
						var my1      = document.querySelector("input#price_1").value;
						var my2      = document.getElementById("quantity_1").value;
						var result   = document.getElementById("total_1");
						var myResult = parseInt(my1) * parseInt(my2); // Parse the strings
						result.value = myResult;
					}
                 </SCRIPT>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title"><?php echo $lang['edit_order'];?></h4>
                    <p class="card-category"><?php if($user_id){ echo  $lang['user'] . ' : ' .getusername($user_id);}?></p>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./orders_edit.php?id=<?php echo $u['order_serial']; if($user_id != 0){echo '?user='.$user_id;}?>" method="post" enctype="multipart/form-data">
                          <br>
                        <?php if(!$user_id){
                                echo '<div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="bmd-label-floating">'.$lang["user"].'</label>
                                      <select class="browser-default custom-select choose" name="user_id" readonly>
                                          <option disabled  selected>'.$lang["choose"].'</option>';
                                           if(!empty($user))
                                                {
                                                    foreach($user as $k => $s)
                                                    {
                                                        echo '<option value="'.$s['user_serial'].'"';if($_order){if($s['user_serial'] == $_order['user_id']){echo 'selected';}else{echo 'disabled';}}else{if($s['user_serial'] == $u['user_id']){echo 'selected';}else{echo 'disabled';}}echo'>'.$s['user_name'].'</option>';
                                                    }
                                                }
                                    echo '</select>
                                    </div>
                                  </div>
                                </div>';
                            }
                          ?>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['order_type'];?></label>
                              <select class="browser-default custom-select" name="type">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
									<option value="home" <?php if($_order){if($_order['type'] == 'home'){echo 'selected';}}else{if($u['order_type'] == 'home'){echo 'selected';}}?>><?php echo $lang['from_home'];?></option>
								  <option value="branch"<?php if($_order){if($_order['type'] == 'branch'){echo 'selected';}}else{if($u['order_type'] == 'branch'){echo 'selected';}}?>><?php echo $lang['from_branch'];?></option>
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
                                         <th><?php echo $lang['product'];?></th>
                                         <th><?php echo $lang['price'];?></th>
                                         <th><?php echo $lang['quantity'];?></th>
                                         <th><?php echo $lang['total'];?></th>
                                     </tr>
                                 </thead>
                                 <tbody class="request">

                                     <?php if($_order)
                                           {
                                                if(is_array($_order['product_id']))
                                                {
                                                   foreach($_order['product_id'] as $k => $_p)
                                                    {
                                                        echo '<tr ><td >
                                                                 <div class="form-group" id="'.$k.'">
                                                                  <select class="browser-default custom-select product"  name="product[]" >
                                                                      <option disabled  selected>'.$lang['product'].'</option>';
                                                                        foreach($products as $p)
                                                                        {
                                                                            echo'<option value="'.$p['product_serial'].'"';if($p['product_serial'] == $_order['product_id'][$k]){ echo "selected";} echo'>'.$p['product_name'].'</option>';
                                                                        }
                                                               echo'</select>
                                                                </div>
                                                             </td>
                                                             <td>
                                                                 <div class="form-group">
                                                                  <input type="number" class="form-control price" min="1" placeholder='.$lang['price'].' id="price_'.$k.'" name ="price[]"  value="'.$_order['price'][$k].'" readonly>
                                                                </div>
                                                             </td>
                                                             <td>
                                                                 <div class="form-group">
                                                                  <label class="bmd-label-floating">'.$lang['quantity'].'</label>
                                                                  <input type="number" class="form-control" min="1" id="quantity_'.$k.'" name ="quantity[]" onchange="cal_'.$k.'()"   value="'.$_order['quantity'][$k].'">
                                                                </div>
                                                             </td>
                                                             <td>
                                                                 <div class="form-group">
                                                                  <label class="bmd-label-floating">'.$lang['total'].'</label>
                                                                  <input type="number" class="total form-control" min="1" id="total_'.$k.'" name ="total[]"  value="'.$_order['total'][$k].'">
                                                                </div>
                                                             </td>
                                                             </tr>
                                                                <SCRIPT>
                                                                   function cal_'.$k.'(){
                                                                        var my1      = document.querySelector("input#price_'.$k.'").value;
                                                                        var my2      = document.getElementById("quantity_'.$k.'").value;
                                                                        var result   = document.getElementById("total_'.$k.'");
                                                                        var myResult = parseInt(my1) * parseInt(my2); // Parse the strings
                                                                        result.value = myResult;
                                                                    }
                                                                    </SCRIPT>';
                                                    }
                                                }else{
                                                    echo'<tr >
                                                     <td >
                                                         <div class="form-group" id=1>
                                                          <select class="browser-default custom-select product" name="product[]">
                                                              <option disabled  selected>'.$lang['product'].'</option>';
                                                               if(!empty($products))
                                                                {
                                                                    foreach($products as $k => $p)
                                                                    {
                                                                        echo '<option value="'.$p['product_serial'].'"';if($p['product_serial'] == $_order['product_id']){echo 'selected';}echo'>'.$p['product_name'].'</option>';
                                                                    }
                                                                }
                                                        echo'</select>
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <input type="number" class="form-control" min="1" step="any" name ="price[]" placeholder="'.$lang['price'].'" id="price_1" value="" readonly>
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <label class="bmd-label-floating">'. $lang['quantity'].'</label>
                                                          <input type="number" class="form-control" min="1" id="quantity_1" step="any" name ="quantity[]"  onchange="cal()" onchange="cal()"  value="">
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <label class="bmd-label-floating">'.$lang['total'].'</label>
                                                          <input type="number" class="total form-control" min="1" id="total_1" step="any" name ="total[]"  value="">
                                                        </div>
                                                     </td>
                                                 </tr>';
                                                }
                                            }else{

                                            if(is_array($u['products']))
                                                {
                                                   foreach($u['products'] as $k => $_p)
                                                    {
                                                        echo '<tr id="tr_'.$_p['id'].'" ><td >
                                                                 <div class="form-group" id="'.$k.'">
                                                                  <select class="browser-default custom-select product"  name="product[]" >
                                                                      <option disabled  selected>'.$lang['product'].'</option>';
                                                                        foreach($products as $p)
                                                                        {
                                                                            echo'<option value="'.$p['product_serial'].'"';if($p['product_serial'] == $_p['product_id']){ echo "selected";} echo'>'.$p['product_name'].'</option>';
                                                                        }
                                                               echo'</select>
                                                                </div>
                                                             </td>
                                                             <td>
                                                                 <div class="form-group">
                                                                  <input type="number" class="form-control price" step="any" min="1" placeholder='.$lang['price'].' id="price_'.$k.'" name ="price[]"  value="'.$_p['price'].'" readonly>
                                                                </div>
                                                             </td>
                                                             <td>
                                                                 <div class="form-group">
                                                                  <label class="bmd-label-floating">'.$lang['quantity'].'</label>
                                                                  <input type="number" class="form-control" min="1" id="quantity_'.$k.'" step="any" name ="quantity[]" onchange="cal_'.$k.'()"   value="'.$_p['quantity'].'">
                                                                </div>
                                                             </td>
                                                             <td>
                                                                 <div class="form-group">
                                                                  <label class="bmd-label-floating">'.$lang['total'].'</label>
                                                                  <input type="number" class="total form-control" min="1" id="total_'.$k.'" step="any" name ="total[]"  value="'.$_p['product_total'].'">
                                                                </div>
                                                             </td>
                                                             <td id="item_'.$_p['id'].'">
                                                                <input type="text" name="item[]" value="'.$_p['id'].'" hidden>
                                                                <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_order_product\'>
                                                                    <i class=\'material-icons\'>close</i>
                                                                </a>
                                                             </td>
                                                             </tr>
                                                                <SCRIPT>
                                                                   function cal_'.$k.'(){
                                                                        var my1      = document.querySelector("input#price_'.$k.'").value;
                                                                        var my2      = document.getElementById("quantity_'.$k.'").value;
                                                                        var result   = document.getElementById("total_'.$k.'");
                                                                        var myResult = parseInt(my1) * parseInt(my2); // Parse the strings
                                                                        result.value = myResult;
                                                                    }
                                                                    </SCRIPT>';
                                                    }
                                                }else{
                                                    echo'<tr >
                                                     <td >
                                                         <div class="form-group" id=1>
                                                          <select class="browser-default custom-select product" name="product[]">
                                                              <option disabled  selected>'.$lang['product'].'</option>';
                                                               if(!empty($products))
                                                                {
                                                                    foreach($products as $k => $p)
                                                                    {
                                                                        echo '<option value="'.$p['product_serial'].'"';if($p['product_serial'] == $_order['product_id']){echo 'selected';}echo'>'.$p['product_name'].'</option>';
                                                                    }
                                                                }
                                                        echo'</select>
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <input type="number" class="form-control" min="1" name ="price[]" step="any" placeholder="'.$lang['price'].'" id="price_1" value="" readonly>
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <label class="bmd-label-floating">'. $lang['quantity'].'</label>
                                                          <input type="number" class="form-control" min="1" id="quantity_1" name ="quantity[]" step="any"  onchange="cal()" onchange="cal()"  value="">
                                                        </div>
                                                     </td>
                                                     <td>
                                                         <div class="form-group">
                                                          <label class="bmd-label-floating">'.$lang['total'].'</label>
                                                          <input type="number" class="total form-control" min="1" id="total_1" step="any" name ="total[]"  value="">
                                                        </div>
                                                     </td>
                                                 </tr>';
                                                }
                                        }
                                     ?>


                                 </tbody>
                                 <tfoot>
                                     <tr>
                                         <td>
                                             <div class="form-group">
                                                <a class="addrequest btn btn-success btn-xs" ><i class="fa fa-plus"></i><?php echo $lang['add'];?></a>
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
								  <option value="0"<?php if($_order){if($_order['status'] == 0){echo 'selected';}}else{if($u['status'] == 0){echo 'selected';}}?>><?php echo $lang['admin_cancel'];?></option>
								  <option value="1"<?php if($_order){if($_order['status'] == 1){echo 'selected';}}else{if($u['status'] == 1){echo 'selected';}}?>><?php echo $lang['unfinished'];?></option>
								  <option value="2"<?php if($_order){if($_order['status'] == 2){echo 'selected';}}else{if($u['status'] == 2){echo 'selected';}}?>><?php echo $lang['finished'];?></option>
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
