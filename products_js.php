<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
    include("./inc/Classes/system-products.php");
	$products = new systemproducts();

    include("./inc/Classes/system-services.php");
	$services = new systemservices();

    include("./inc/Classes/system-staffs.php");
	$staff = new systemstaff();

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        switch($_GET['do'])
		{
			case"request":
                    $products = $products->getsiteproducts();
                    $time     = time();
                    echo '<tr id="tr_'.$time.'"><td >
                             <div class="form-group" id="'.$time.'">
                              <select class="browser-default custom-select product"  name="product[]" >
                                  <option disabled  selected>'.$lang['product'].'</option>';
                                    foreach($products as $p)
                                    {
                                        echo'<option value="'.$p['product_serial'].'">'.$p['product_name'].'</option>';
                                    }
                           echo'</select>
                            </div>
                         </td>
                         <td>
                             <div class="form-group">
                              <input type="number" class="form-control price" min="1" step="any" placeholder='.$lang['price'].' id="price_'.$time.'" name ="price[]"  value="" readonly>
                            </div>
                         </td>
                         <td>
                             <div class="form-group">
                              <label class="bmd-label-floating">'.$lang['quantity'].'</label>
                              <input type="number" class="form-control" min="1" id="quantity_'.$time.'" step="any" name ="quantity[]" onchange="cal_'.$time.'()"  value="">
                            </div>
                         </td>
                         <td>
                             <div class="form-group">
                              <label class="bmd-label-floating">'.$lang['total'].'</label>
                              <input type="number" class="total form-control" min="1" id="total_'.$time.'" step="any" name ="total[]"  value="">
                            </div>
                         </td>
                         <td id="item_'.$time.'">
                            <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_product\'>
                                <i class=\'material-icons\'>close</i>
                            </a>
                         </td>
                         </tr>
                            <SCRIPT>
                               function cal_'.$time.'(){
                                    var my1      = document.querySelector("input#price_'.$time.'").value;
                                    var my2      = document.getElementById("quantity_'.$time.'").value;
                                    var result   = document.getElementById("total_'.$time.'");
                                    var myResult = parseInt(my1) * parseInt(my2); // Parse the strings
                                    result.value = myResult;
                                }
                             </SCRIPT>';
                exit;
            break;
            case"product_price":
                if($_POST)
                {
                    $ID  = $_POST['product_id'];
                    $products = $products->getproductsInformation($ID);
                    echo $products['price'];
                    exit;
                }

            break;
            case"delete_order_product":
            if($_POST)
            {
                $ID  = $_POST['id'];
                $delete = $products->delete_order_product($ID);
                if($delete == 1)
                {
                    echo 116;
                    exit;
                }
            }
            break;
            case"delete_order_service":
            if($_POST)
            {
                $ID     = $_POST['id'];
                $delete = $products->delete_order_service($ID);
                if($delete == 1)
                {
                    echo 116;
                    exit;
                }
            }
            break;
           case"service_price":
                if($_POST)
                {
                    $ID  = $_POST['service_id'];
                    $service = $services->getservicesInformation($ID);
                    echo $service['price'];
                    exit;
                }
            break;
            case"service":
                   $service  = $services->getsiteservices();
                    $ID         = $_POST['branch_id'];
                    $staffs     = $staff->getbranchstaff($ID);
                   $time     = time();
                    echo '<tr id="tr_'.$time.'"><td >
                             <div class="form-group" id="'.$time.'">
                              <select class="browser-default custom-select service"  name="service[]" >
                                  <option disabled  selected>'.$lang['service'].'</option>';
                                    foreach($service as $s)
                                    {
                                        echo'<option value="'.$s['service_serial'].'">'.$s['service_name'].'</option>';
                                    }
                           echo'</select>
                            </div>
                         </td>
                         <td >
                             <div class="form-group" id=1>
                              <select class="staff browser-default custom-select" name="staff[]">';
                                    if($ID == 0){
                                        echo'<option disabled  selected>'.$lang['CHOOSE_BRANCH_FIRST'].'</option>';
                                    }else{
                                        if(!empty($staffs))
                                        {
                                            foreach($staffs as $k => $s)
                                            {
                                                echo '<option value="'.$s['staff_serial'].'">'.$s['staff_name'].'</option>';
                                            }
                                        }else{
                                            echo '<option value="">'.$lang['no_branch_staff'].'</option>';
                                        }
                                    }

                            echo'</select>
                            </div>
                         </td>
                       <td>
                         <div class="form-group">
                              <input type="datetime" class="date form-control" autocomplete="off"  name ="date[]"  value="">
                            </div>
                         </td>
                         <td>
                             <div class="form-group">
                              <input type="number" class="form-control price" min="1" step="any" placeholder='.$lang['price'].' id="price_'.$time.'" name ="price[]"  value="" readonly>
                            </div>
                         </td>

                         <td id="item_'.$time.'">
                            <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_product\'>
                                <i class=\'material-icons\'>close</i>
                            </a>
                         </td>
                         </tr>';
                exit;
            break;
            case"branch_staff":
                    $ID         = $_POST['branch_id'];
                    $staffs     = $staff->getbranchstaff($ID);
                    if(is_array($staffs))
                    {
                       foreach($staffs as $s)
                        {
                            echo '<option value="'.$s['staff_serial'].'">'.$s['staff_name'].'</option>';
                        }
                    }else{
                        echo '<option value="">'.$lang['no_branch_staff'].'</option>';
                    }



                exit;
            break;
            case"status":
                if($_POST)
                {
                    $data      = sanitize($_POST['data']);
                    $_data     =    explode("|",$data);
                    $active    = $products->activestatus($data);
                    $logs->addLog(112,
                                array(
                                    "type" 		=> 	"admin",
                                    "module" 	=> 	$_data[0],
                                    "mode" 		=> 	"status",
                                    "status_id" 	=> 	$_data[3],
                                    "id" 		=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                    if($active == 1)
                    {
                        echo 1190;
                        exit;
                    }
                }
            break;
            case"status_order":
                if($_POST)
                {
                    $data      = sanitize($_POST['data']);
                    $_data     =    explode("|",$data);
                    $table     =      $_data[0];
                    $where     =      $_data[1];
                    $s_col     =      $_data[2];
                    $id        =      $_data[3];
                    $status    =      $_data[4];
                    $active    = $products->changestatus_order($data);
                    if(($table == "orders") && ($status == 2))
                    {
                        updatebestseller($id);
                    }
                    $logs->addLog(113,
                                array(
                                    "type" 		    => 	"admin",
                                    "module" 	    => 	$_data[0],
                                    "mode" 		    => 	"status",
                                    "status_id" 	=> 	$_data[3],
                                    "id" 		    =>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                    if($active == 1)
                    {
                        echo 1190;
                        exit;
                    }
                }
            break;

        }

    }
?>

