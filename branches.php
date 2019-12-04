<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-branches.php");
	$branches = new systembranches();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['branches_view'] == 0){
                    header("Location:./permission.php");
                }else{
                    
                    $salon_id = intval($_GET['salon']);    
                    include("./inc/Classes/pager.class.php");
                    $page;
                    $pager      = new pager();
                    $page 		= intval($_GET[page]);
                    $total      = $branches->getTotalbranches($salon_id);
                    $pager->doAnalysisPager("page",$page,$basicLimit,$total,"branches.php".$paginationAddons,$paginationDialm);
                    $thispage = $pager->getPage();
                    $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                    $pager =$pager->getAnalysis();
                    $branches = $branches->getsitebranches($limitmequry ,$salon_id);
                    $logs->addLog(52,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"branches",
										"mode" 		        => 	"list",
                                        "total" 	        => 	$total,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_branches_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_branches_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_branches_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $branches->deletebranches($mId);
                if($delete == 1)
                {
                    $logs->addLog(53,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"branches",
										"mode" 		        => 	"delete",
										"branch" 	        => 	$mId,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                    echo 116;
                    exit;
                }
            break;
            case"del":
                if($group['branches_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $branches->deletebranches($mId);
                    if($delete == 1)
                    {
                        $logs->addLog(53,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"branches",
										"mode" 		        => 	"delete",
										"branch" 	        => 	$mId,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                        header("Location:./branches.php?message=delete");
                        
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
            <input type="hidden" value="branches" id="page">
            <input type="hidden" value="<?php echo $lang['branch']?>" id="lang_name">
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
                      <h4 class="card-title "><?php echo $lang['branches'];?></h4>
                      <p class="card-category"><?php if($salon_id){ echo $lang['salon'].' : '.getsalonname($salon_id);}?></p>
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
                              <?php echo $lang['owner'];?>
                            </th>
                            <th>
                              <?php echo $lang['ADDRESS'];?>
                            </th>
                            <th>
                              <?php echo $lang['services'];?>
                            </th>
                            
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($branches))
                                    {
                                        echo "<tr><td colspan=\"4\">".$lang['no_branches']."</td></tr>";
                                    }else{
                                        foreach( $branches as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['branch_serial'].">
                                                    <td>".$u['branch_serial']."</td>
                                                    <td><a href='branches_view.php?id=".$u['branch_serial']."'>".$u['branch_name']."</a></td>
                                                    <td>".getusername($u['manager_id'])."</td>
                                                    <td>".$u['address']."</td>
                                                    <td>
                                                        <a title='".$lang['branche_services']."' href='services.php?branch=".$u['branch_serial']."' ><i class=\"material-icons\">style</i></a>
                                                        <a class='success' title='".$lang['branche_add_service']."' href='branche_services.php?branch=".$u['branch_serial']."' ><i class=\"material-icons\">library_add</i></a>
                                                    </td>
                                                    <td id='item_".$u['branch_serial']."'class='td-actions text-right'>";
                                                    if($group['branches_edit'] == 1)
                                                    {
                                                        echo"<button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                            <i class='material-icons'>edit</i>
                                                        </button>";
                                                    }
                                                    if($group['branches_delete'] == 1)
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
                                    <?php if($group['branches_add'] == 1)
                                            {
								                echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="branches_add.php">'.$lang['add_branch'].'</a></td>';
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
