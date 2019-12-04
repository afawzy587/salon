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
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['service_order_view'] == 0){
                    header("Location:./permission.php");
                }else{
                    $user_id = intval($_GET['user']);
                    if($user_id == 0)
                    {
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $total      = $service_order->getTotalservice_order();
                        $pager->doAnalysisPager("page",$page,$basicLimit,$total,"service_order.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $service_order = $service_order->getsiteservice_order($limitmequry);
                        $logs->addLog(91,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"service_order",
										"mode" 		        => 	"list",
										"total" 		    => 	$total,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                    }else{
                        include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $total      = $service_order->getTotaluserservice_order($user_id);
                        $pager->doAnalysisPager("page",$page,$basicLimit,,"service_order.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $service_order = $service_order->getuserservice_order($limitmequry,$user_id);
                        $logs->addLog(91,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"service_order",
										"mode" 		        => 	"list",
										"total" 		    => 	$total,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                    }

                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_order_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_order_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_order_success'];
                    }
                }

            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $service_order->deleteservice_order($mId);
                 $logs->addLog(92,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"service_order",
										"mode" 		        => 	"delete",
										"service_order_id"  => 	$mId,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                if($delete == 1)
                {
                    echo 116;
                    exit;
                }
            break;

            case"del":
                if($group['service_order_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $service_order->deleteservice_order($mId);
                    $logs->addLog(92,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"service_order",
										"mode" 		        => 	"delete",
										"service_order_id"  => 	$mId,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                    if($delete == 1)
                    {
                        header("Location:./service_order.php?message=delete");
                    }
                }
                break;
        }

    }
?>

    <body class="">
      <div class="wrapper ">
        <?php include './assets/layout/sidebar.php';?>
        <div class="main-panel">
          <?php include './assets/layout/navbar.php';?>
          <div class="content">
            <input type="hidden" value="service_order" id="page">
            <input type="hidden" value="<?php echo $lang['order']?>" id="lang_name">
            <input type="hidden" value="<?php echo $lang['delete_alarm_massage_in_men']?>" id="lang_del">
            <input type="hidden" value="<?php echo $lang['status_alarm_massage_in_men']?>" id="lang_status">
            <div class="container-fluid">
              <div class="row">
              	<div class="col-lg-12">
					<?php if ($message){
							echo '<div class="alert alert-success">'.$message.'</div>';
						}
					?>
               </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title "><?php echo $lang['service_orders'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead class=" text-primary">
                            <th>
                              #
                            </th>
                            <th>
                              <?php echo $lang['user'];?>
                            </th>
                            <th>
                              <?php echo $lang['branch'];?>
                            </th>
                            <th>
                              <?php echo $lang['order_type'];?>
                            </th>
                            <th>
                              <?php echo $lang['date'];?>
                            </th>
                            <th>
                              <?php echo $lang['status'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($service_order))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_service_order']."</td></tr>";
                                    }else{
                                        foreach( $service_order as $k => $u)
                                        {
                                            echo"
                                            <tr id=tr_".$u['service_order_serial'].">
                                                    <td><a href='service_order_view.php?id=".$u['service_order_serial']."'>".$u['service_order_serial']."</a></td>
                                                    <td>".getusername($u['user_id'])."</td>
                                                    <td>".getbranchname($u['branch_id'])."</td>
                                                    <td><a href='service_order_view.php?id=".$u['service_order_serial']."'>";
                                                    if($u['service_order_type'] == 'home'){ echo $lang['from_home'].'<i class="material-icons">motorcycle</i>'; }else{ echo $lang['from_branch'].'<i class="material-icons">store</i>';}
                                                    echo"</a></td>
                                                    <td>"._date_format($u['date'])."</td>
                                                    <td><span>";
                                                    if($u['service_order_status'] == 0){
                                                        echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['admin_cancel'].'</i>';
                                                    }elseif($u['service_order_status'] == 1){
                                                        echo '<i class=\"fa fa-minus-circle"style="font-size:18px\"  dir=\"ltr\">'.$lang['unfinished'].'</i>';
                                                    }elseif($u['service_order_status'] == 2){
                                                        echo '<i class=\"fa fa-check"style="font-size:18px;color:grean\"  dir=\"ltr\">'.$lang['finished'].'</i>';
                                                    }
                                                    echo"</span>
                                                        </td>
                                                          <td id='item_".$u['service_order_serial']."'class='td-actions text-right'>";
                                                        if($group['service_order_edit'] == 1)
                                                        {
                                                            echo"<button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                                <i class='material-icons'>edit</i>
                                                            </button>";
                                                        }
                                                        if($group['service_order_delete'] == 1)
                                                        {
                                                            echo"<button  rel='tooltip' title='".$lang['delete']."'class='btn btn-danger btn-link btn-sm delete'>
                                                                    <i class='material-icons'>close</i>
                                                                </button>";
                                                        }
                                                       echo "</td>
                                                </tr>";
                                        }
                                    }
                              ?>
                          </tbody>
                            <tfoot>
                                <tr>
								    <td colspan="6" align="right"><?php echo $pager;?></td>
                                    <?php if($group['service_order_add'] == 1)
                                        {
                                            echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="service_order_add.php">'.$lang['add_order'].'</a></td>';
                                        }
                                    ?>
								</tr>

                            </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

 <?php include './assets/layout/footer.php';?>
 <script>
        $('button.delete').click(function(e){
        e.preventDefault();
		page=$('#page').val();
		id = $(this).parent('td').attr('id').replace("item_","");
		if (confirm($('#lang_del').val()+" "+$('#lang_name').val()+" ؟ "))
		{
			jQuery.ajax( {
				async :true,
				type :"POST",
				url :page+".php?do=delete",
				data: "id=" + id + "",
				success : function() {

					$("#tr_" + id).fadeTo(400, 0, function () { $("#tr_" + id).slideUp(400);});

				},
				error : function() {
					return true;
				}
			});
		}
	});
 </script>
 <script src="./assets/js/list-controls.js"></script>
