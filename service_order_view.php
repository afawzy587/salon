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

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($_GET['id'] != 0 )
		{
			$service_order = $service_order->getservice_orderInformation($_GET['id']);
            $logs->addLog(95,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"service_order",
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
                      <h4 class="card-title"><?php echo $lang['service_order_details'];?></h4>
                    </div>
                    <div class="card-body">

                      <div class="row">
                            <div class="col-md-6">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['user'];?> :</strong></span>
								<span style="width:80%;display:inline-block;"><?php echo getusername($service_order['user_id']);?></span>
							  </div>
							</div>
                          <div class="col-md-6">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['branch'];?> :</strong></span>
								<span style="width:80%;display:inline-block;"><?php echo getbranchname($service_order['branch_id']);?></span>
							  </div>
							</div>
                       </div>
                      <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['order_type'];?> :</strong></span>
								<span style="width:80%;display:inline-block;">
                                    <?php
                                    if($service_order['order_type'] == 'home')
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
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['date'];?> :</strong></span>
								<span style="width:80%;display:inline-block;"><?php echo _date_format($service_order['date']);?></span>
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
                                        <th><?php echo $lang['service'];?></th>
                                        <th><?php echo $lang['staff'];?></th>
                                        <th><?php echo $lang['start_time'];?></th>
                                        <th><?php echo $lang['duration'];?></th>
                                        <th><?php echo $lang['cost'];?></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($service_order['sevices'] as $k => $s)
                                            {
                                                echo'<tr>
                                                     <td>
                                                        '.getservicename($s["service_id"]).'
                                                    </td>
                                                    <td>
                                                    '.getstaffname($s["staff_id"]).'
                                                    </td>
                                                    <td>
                                                    '._date_format($s["start_time"]).'
                                                    </td>
                                                    <td>
                                                    '.$s["duration"].'
                                                    </td>
                                                    <td>
                                                    '.$s["cost"].'
                                                    </td>
                                                    </tr>';
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="4">
                                                <?php echo $lang['order_total'];?>
                                            </td>
                                            <td colspan="1">
                                                <?php echo $service_order['total'] .' '. $lang['Currancy'];?>
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
                                    <span style="width:20%;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                                    <span style="width:75%;display:inline-block;">
                                        <?php if($service_order['status'] == 0)
                                            {
                                                echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['admin_cancel'].'</i>';
                                            }elseif($service_order['status'] == 1){
                                              echo '<i class="fa fa-minus-circle"style="font-size:18px"  dir="ltr">'.$lang['unfinished'].'</i>';
                                            }elseif($service_order['status'] == 2){
                                                echo '<i class="fa fa-check"style="font-size:18px;color:grean"  dir="ltr">'.$lang['DONE'].'</i>';
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
                  <?php if($group['service_order_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="service_order_edit.php?id='.$service_order['service_order_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['service_order_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="service_order.php?do=del&id='.$service_order['service_order_serial'].'">'.$lang['delete'].'</a>';
                  } ?>


             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>
