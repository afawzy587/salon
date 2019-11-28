<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
    include("./inc/Classes/system-products.php");
	$products = new systemproducts();

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
                              <input type="number" class="form-control price" min="1" placeholder='.$lang['price'].' id="price_'.$time.'" name ="price[]"  value="" readonly>
                            </div>
                         </td>
                         <td>
                             <div class="form-group">
                              <label class="bmd-label-floating">'.$lang['quantity'].'</label>
                              <input type="number" class="form-control" min="1" id="quantity_'.$time.'" name ="quantity[]" onchange="cal_'.$time.'()"  value="">
                            </div>
                         </td>
                         <td>
                             <div class="form-group">
                              <label class="bmd-label-floating">'.$lang['total'].'</label>
                              <input type="number" class="total form-control" min="1" id="total_'.$time.'" name ="total[]"  value="">
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

        }

    }
?>

