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
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['orders_view'] == 0){
                    header("Location:./permission.php");
                }else{
                    $user_id = intval($_GET['user']);
                    if($user_id == 0)
                    {
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $pager->doAnalysisPager("page",$page,$basicLimit,$orders->getTotalorders(),"orders.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $orders = $orders->getsiteorders($limitmequry);
                    }else{
                        include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $pager->doAnalysisPager("page",$page,$basicLimit,$orders->getTotaluserorders($user_id),"orders.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $orders = $orders->getuserorders($limitmequry,$user_id);
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
                $delete = $orders->deleteorders($mId,$path);
                if($delete == 1)
                {
                    echo 116;
                    exit;
                }
            break;

            case"del":
                if($group['orders_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $orders->deleteorders($mId);
                    if($delete == 1)
                    {
                        header("Location:./orders.php?message=delete");
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
            <input type="hidden" value="orders" id="page">
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
                      <h4 class="card-title "><?php echo $lang['orders'];?></h4>
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
                            <?php  if(empty($orders))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_orders']."</td></tr>";
                                    }else{
                                        foreach( $orders as $k => $u)
                                        {
                                            echo"
                                            <tr id=tr_".$u['order_serial'].">
                                                    <td><a href='orders_view.php?id=".$u['order_serial']."'>".$u['order_serial']."</a></td>
                                                    <td>".getusername($u['user_id'])."</td>
                                                    <td><a href='orders_view.php?id=".$u['order_serial']."'>";
                                                    if($u['order_type'] == 'home'){ echo $lang['from_home'].'<i class="material-icons">motorcycle</i>'; }else{ echo $lang['from_branch'].'<i class="material-icons">store</i>';}
                                                    echo"</a></td>
                                                    <td>"._date_format($u['order_date'])."</td>
                                                    <td><span>";
                                                    if($u['order_status'] == 0){
                                                        echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['admin_cancel'].'</i>';
                                                    }elseif($u['order_status'] == 1){
                                                        echo '<i class=\"fa fa-check"style="font-size:18px\"  dir=\"ltr\">'.$lang['unfinished'].'</i>';
                                                    }elseif($u['order_status'] == 2){
                                                        echo '<i class=\"fa fa-check"style="font-size:18px;color:grean\"  dir=\"ltr\">'.$lang['finished'].'</i>';
                                                    }
                                                    echo"</span>
                                                        </td>
                                                          <td id='item_".$u['order_serial']."'class='td-actions text-right'>";
                                                        if($group['orders_edit'] == 1)
                                                        {
                                                            echo"<button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                                <i class='material-icons'>edit</i>
                                                            </button>";
                                                        }
                                                        if($group['orders_delete'] == 1)
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
								    <td colspan="5" align="right"><?php echo $pager;?></td>
                                    <?php if($group['orders_add'] == 1)
                                        {
                                            echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="orders_add.php">'.$lang['add_order'].'</a></td>';
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