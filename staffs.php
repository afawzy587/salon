<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-staffs.php");
	$staff = new systemstaff();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['staffs_view'] == 0){
                    header("Location:./permission.php");
                }else{
                    $branch_id = intval($_GET['branch']);
                    if($branch_id == 0)
                    {
                        include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $total      = $staff->getTotalstaff();
                        $pager->doAnalysisPager("page",$page,$basicLimit,$total,"staff.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $staff = $staff->getsitestaff($limitmequry);
                        $logs->addLog(102,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"staff",
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
                        $paginationAddons ="?branch=".$branch_id;
                        $pager->doAnalysisPager("page",$page,$basicLimit,$staff->getTotalbranchstaff($branch_id),"staff.php".$paginationAddons,true);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $staff = $staff->getsitestaff($limitmequry,$branch_id);
                    }
                    if($_GET['message']== "update")
                    {
                      $message = $lang['edit_staff_success'];
                    }elseif($_GET['message']== "add"){
                      $message = $lang['add_staff_success'];
                    }elseif($_GET['message']== "delete"){
                      $message = $lang['delete_staff_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $staff->deletestaff($mId,$path);
                $logs->addLog(103,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"staff",
                                "mode" 		        => 	"delete",
                                "total" 		    => 	$mId,
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
                if($group['staffs_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $staff->deletestaff($mId,$path);
                     $logs->addLog(103,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"staff",
                                "mode" 		        => 	"delete",
                                "total" 		    => 	$mId,
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
                    if($delete == 1)
                    {
                        header("Location:./staffs.php?message=delete");
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
            <input type="hidden" value="staffs" id="page">
            <input type="hidden" value="<?php echo $lang['staff']?>" id="lang_name">
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
                      <h4 class="card-title "><?php echo $lang['staffs'];?></h4>
                      <p class="card-category"> <?php if($branch_id){ echo $lang['branch'].  ' : ' .getbranchname($branch_id);}?></p><p class="card-category"><?php echo $lang['staffs_mangment'];?></p>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead class=" text-primary">
                            <th>
                              #
                            </th>
                            <th>
                              <?php echo $lang['name'];?>
                            </th>
                            <th>
                              <?php echo $lang['branch'];?>
                            </th>
                            <th>
                              <?php echo $lang['image'];?>
                            </th>
                            <th>
                              <?php echo $lang['status'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($staff))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_staffs']."</td></tr>";
                                    }else{
                                        foreach( $staff as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['staff_serial'].">
                                                    <td>".$u['staff_serial']."</td>
                                                    <td><a href='staffs_view.php?id=".$u['staff_serial']."'>".$u['staff_name']."</a></td>
                                                    <td>".getbranchname($u['branch_id'])."</td>
                                                    <td><a href=".$path.$u['staff_photo']." target=\"_blank\"><img src=".$path.$u['staff_photo']." class=\"rounded\"  width=\"100\" height=\"100\"></a></td>";
                                                     status("branche_staff","staff_serial","staff_status",$u['staff_serial'],$u['staff_status']);
                                                    echo"<td id='item_".$u['staff_serial']."'class='td-actions text-right'>";
                                                    if($group['staffs_edit'] == 1)
                                                    {
                                                        echo"<button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                            <i class='material-icons'>edit</i>
                                                        </button>";
                                                    }
                                                    if($group['staffs_delete'] == 1)
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
                                    <?php if($group['staffs_add'] == 1)
                                            {
								                echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="staffs_add.php">'.$lang['add_staff'].'</a></td>';
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
