<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-salons.php");
	$salons = new systemsalons();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
        exit;
	}else{
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['salons_view'] == 0){
                    header("Location:./permission.php");
                    exit;
                }else{
                    include("./inc/Classes/pager.class.php");
                    $page;
                    $pager      = new pager();
                    $page 		= intval($_GET[page]);
                    $total      = $salons->getTotalsalons();
                    $pager->doAnalysisPager("page",$page,$basicLimit,$total,"salons.php".$paginationAddons,$paginationDialm);
                    $thispage = $pager->getPage();
                    $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                    $pager =$pager->getAnalysis();
                    $salons = $salons->getsitesalons($limitmequry);
                    $logs->addLog(86,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"salons",
										"mode" 		        => 	"list",
										"total" 		    => 	$total,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_salons_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_salons_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_branches_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $salons->deletesalons($mId);
                $logs->addLog(87,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"salons",
										"mode" 		        => 	"delete",
										"salon_id" 		    => 	$mId,
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
                if($group['salons_delete'] == 0){
                    header("Location:./permission.php");
                    exit;
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $salons->deletesalons($mId);
                    $logs->addLog(87,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"salons",
										"mode" 		        => 	"delete",
										"salon_id" 		    => 	$mId,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
                    if($delete == 1)
                    {
                        header("Location:./salons.php?message=delete");
                        exit;
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
            <input type="hidden" value="salons" id="page">
            <input type="hidden" value="<?php echo $lang['salon']?>" id="lang_name">
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
                      <h4 class="card-title "><?php echo $lang['salons'];?></h4>
                      <p class="card-category"><?php echo $lang['salons_mangment'];?></p>
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
                              <?php echo $lang['image'];?>
                            </th>
                            <th>
                              <?php echo $lang['branches'];?>
                            </th>  
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($salons))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_salons']."</td></tr>";
                                    }else{
                                        foreach( $salons as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['salon_serial'].">
                                                    <td>".$u['salon_serial']."</td>
                                                    <td><a href='salons_view.php?id=".$u['salon_serial']."'>".$u['salon_name']."</a></td>
                                                    <td>".getusername($u['owner_id'])."</td>
                                                    <td><a href=".$path.$u['salon_photo']." target=\"_blank\"><img src=".$path.$u['salon_photo']." class=\"rounded\"  width=\"100\" height=\"100\"></a></td>
                                                    <td>
                                                        <a title='".$lang['salon_branches']."' href='branches.php?salon=".$u['salon_serial']."' ><i class=\"material-icons\">apartment</i></a>
                                                        <a class='success' title='".$lang['add_branch']."' href='branches_add.php?salon=".$u['salon_serial']."' ><i class=\"material-icons\">library_add</i></a>
                                                    </td>
                                                    
                                                    <td id='item_".$u['salon_serial']."'class='td-actions text-right'>";
                                                    if($group['salons_edit'] == 1)
                                                    {
                                                        echo"<button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                            <i class='material-icons'>edit</i>
                                                        </button>";
                                                    }
                                                    if($group['salons_delete'] == 1)
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
                                    <?php if($group['salons_add'] == 1)
                                            {
								                echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="salons_add.php">'.$lang['add_salon'].'</a></td>';
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
