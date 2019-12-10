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

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($_GET['id'] != 0 )
		{

			$orders = $orders->getordersInformation($_GET['id']);
            $logs->addLog(77,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"orders",
                                    "mode" 		        => 	"view",
                                    "order_id" 		    => 	$_GET['id'],
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
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
                      <h4 class="card-title"><?php echo $lang['orders_details'];?></h4>
                    </div>
                    <div class="card-body">

                      <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['user'];?> :</strong></span>
								<span class="view_span"><?php echo getusername($orders['user_id']);?></span>
							  </div>
							</div>
                       </div>
                      <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['order_type'];?> :</strong></span>
								<span class="view_span">
                                    <?php
                                    if($orders['order_type'] == 'home')
                                    { echo $lang['from_home'].'<i class="material-icons">motorcycle</i>';
                                    }else
                                    { echo $lang['from_branch'].'<i class="material-icons">store</i>';}
                                    ?></span>
							  </div>
							</div>
                       </div>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['date'];?> :</strong></span>
								<span class="view_span"><?php echo _date_format($orders['order_date']);?></span>
							  </div>
							</div>
                       </div>
                        <br/>
                          <div class="row">
                            <div class="col-md-12">
                                <div class="form-User">
                                    <p> <?php echo $lang['order'];?> </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                 <table class="table table-bordered table-sm">
                                    <thead>
                                      <tr>
                                        <th><?php echo $lang['product'];?></th>
                                        <th><?php echo $lang['quantity'];?></th>
                                        <th><?php echo $lang['price'];?></th>
                                        <th><?php echo $lang['total'];?></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($orders['products'] as $k => $p)
                                            {
                                                echo'<tr>
                                                     <td>
                                                        '.getproductname($p["product_id"]).'
                                                    </td>
                                                    <td>
                                                    '.$p["quantity"].'
                                                    </td>
                                                    <td>
                                                    '.$p["price"].'
                                                    </td>
                                                    <td>
                                                    '.$p["product_total"].'
                                                    </td>
                                                    </tr>';
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="3">
                                                <?php echo $lang['order_total'];?>
                                            </td>
                                            <td colspan="1">
                                                <?php echo $orders['total'] .' '. $lang['Currancy'];?>
                                            </td>
                                        </tr>
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                         <br/>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert ">
                                    <span style="width:auto;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                                    <span class="view_span">
                                        <?php if($orders['status'] == 0)
                                            {
                                                echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['admin_cancel'].'</i>';
                                            }elseif($orders['status'] == 1){
                                              echo '<i class="fa fa-minus-circle"style="font-size:18px"  dir="ltr">'.$lang['unfinished'].'</i>';
                                            }elseif($orders['status'] == 2){
                                                echo '<i class="fa fa-check"style="font-size:18px;color:grean"  dir="ltr">'.$lang['finished'].'</i>';
                                            }?></span>
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
                  <?php if($group['orders_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="orders_edit.php?id='.$orders['order_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['orders_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="orders.php?do=del&id='.$orders['order_serial'].'">'.$lang['delete'].'</a>';
                  } ?>


             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>
