<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-services.php");
	$services = new systemservices();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['services_view'] == 0){
                    header("Location:./permission.php");
                }else{
                    $branch_id = intval($_GET['branch']);
                    if($branch_id == 0)
                    {
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $total      = $services->getTotalservices();
                        $pager->doAnalysisPager("page",$page,$basicLimit,$total,"services.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $services = $services->getsiteservices($limitmequry); 
                        $logs->addLog(96,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"services",
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
                        $pager->doAnalysisPager("page",$page,$basicLimit,$services->getTotalbranchservices($branch_id),"services.php".$paginationAddons,true);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $services = $services->getbranchservices($limitmequry,$branch_id);
                    }
                    
                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_services_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_services_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_branches_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $services->deleteservices($mId,$path);
                $logs->addLog(97,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"services",
                                "mode" 		        => 	"delete",
                                "service_id" 		=> 	$mId,
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
                if($delete == 1)
                {
                    echo 116;
                    exit;
                }
            break;
            case"delete_service":
                $mId = intval($_POST['id']);
                $delete = $services->deletebranchservices($mId);
                $logs->addLog(98,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"services",
                                    "mode" 		        => 	"delete_service",
                                    "service_id" 	    => 	$mId,
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
                if($group['services_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $services->deleteservices($mId,$path);
                    $logs->addLog(97,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"services",
                                "mode" 		        => 	"delete",
                                "service_id" 		    => 	$mId,
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
                    if($delete == 1)
                    {
                        header("Location:./services.php?message=delete");
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
            <input type="hidden" value="services" id="page">
            <input type="hidden" value="<?php echo $lang['service']?>" id="lang_name">
            <input type="hidden" value="<?php echo $lang['delete_alarm_massage_in_woman']?>" id="lang_del">
            <input type="hidden" value="<?php echo $lang['status_alarm_massage_in_woman']?>" id="lang_status">  
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
                      <h4 class="card-title "><?php echo $lang['services'];?></h4>
                      <p class="card-category"> <?php if($branch_id){ echo $lang['branch'].  ' : ' .getbranchname($branch_id);}?></p>
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
                              <?php echo $lang['price'];?>
                            </th>
                            <th>
                              <?php echo $lang['duration'];?>
                            </th>
                            <th>
                              <?php echo $lang['status'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($services))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_services']."</td></tr>";
                                    }else{
                                        foreach( $services as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['service_serial'].">
                                                    <td>".$u['service_serial']."</td>
                                                    <td><a href='services_view.php?id=".$u['service_serial']."'>".$u['service_name']."</a></td>
                                                    <td>".$u['price']."</td>
                                                    <td>".$u['duration'].$lang['minute']."</td>";
                                                    status("services","service_serial","service_status",$u['service_serial'],$u['service_status']);
                                                if($branch_id){ 
                                                        
                                                        echo"<td id='item_".$u['branche_serivce_serial']."'class='td-actions text-right del_".$u['service_serial']."'>
                                                        <button  rel='tooltip' title='".$lang['delete']."'class='btn btn-danger btn-link btn-sm delete_service'>
                                                                <i class='material-icons'>close</i>
                                                            </button>";
                                                }else{
                                                    
                                                    if($group['services_edit'] == 1)
                                                    {
                                                         echo"<td id='item_".$u['service_serial']."'class='td-actions text-right'>
                                                        <button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                            <i class='material-icons'>edit</i>
                                                        </button>";
                                                    }
                                                    if($group['services_delete'] == 1)
                                                    {
                                                        echo"<button  rel='tooltip' title='".$lang['delete']."'class='btn btn-danger btn-link btn-sm delete'>
                                                                <i class='material-icons'>close</i>
                                                            </button>";
                                                    }
                                                    
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
                                    <?php if($branch_id){
                                                         echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="branche_services.php?branch='.$branch_id.'">'.$lang['add_branch_service'].'</a></td>';   
                                                }else{
                                                    if($group['services_add'] == 1)
                                                        {
                                                            echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="services_add.php">'.$lang['add_service'].'</a></td>';
                                                        }
    
                                                }?>
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
