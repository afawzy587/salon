<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-rates.php");
	$rates = new systemrates();
     
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
                if($group['rates_view'] == 0){
                    header("Location:./permission.php");
                    exit;
                }else{
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $total      = $rates->getTotalrates();
                        $pager->doAnalysisPager("page",$page,$basicLimit,$total,"rates.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $rates = $rates->getsiterates($limitmequry); 
                        $logs->addLog(84,
                                    array(
                                        "type" 		        => 	"admin",
                                        "module" 	        => 	"rates",
                                        "mode" 		        => 	"view",
                                        "rates" 		    => 	$total,
                                        "id" 	        	=>	$login->getUserId(),
                                    ),"admin",$login->getUserId(),1
                                );
                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_rates_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_rates_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_branches_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $rates->deleterates($mId,$path);
                $logs->addLog(85,
                                    array(
                                        "type" 		        => 	"admin",
                                        "module" 	        => 	"rates",
                                        "mode" 		        => 	"delete",
                                        "rate_id" 		    => 	$mId,
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
                if($group['rates_delete'] == 0){
                    header("Location:./permission.php");
                    exit;
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $rates->deleterates($mId,$path);
                    $logs->addLog(85,
                                    array(
                                        "type" 		        => 	"admin",
                                        "module" 	        => 	"rates",
                                        "mode" 		        => 	"delete",
                                        "rate_id" 		    => 	$mId,
                                        "id" 	        	=>	$login->getUserId(),
                                    ),"admin",$login->getUserId(),1
                                );
                    if($delete == 1)
                    {
                        header("Location:./rates.php?message=delete");
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
            <input type="hidden" value="rates" id="page">
            <input type="hidden" value="<?php echo $lang['rate']?>" id="lang_name">
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
                      <h4 class="card-title "><?php echo $lang['rates'];?></h4>
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
                              <?php echo $lang['rate'];?>
                            </th>
                            <th>
                              <?php echo $lang['rate_description'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($rates))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_rates']."</td></tr>";
                                    }else{
                                        foreach( $rates as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['rate_serial'].">
                                                    <td>".$u['rate_serial']."</td>
                                                    <td>".getusername($u['user_id'])."</td>
                                                    <td>";
                                                    for($i=1;$i<=5 ;$i++)
                                                    {
                                                        if($i <= $u['rate'])
                                                        {
                                                            echo '<span class="fa fa-star checked"></span>';
                                                        }else{
                                                            echo '<span class="fa fa-star"></span>';
                                                        }
                                                    }
                                                    echo"</td>
                                                    <td style=''>".$u['rate_description']."</td>
                                                    <td id='item_".$u['rate_serial']."'class='td-actions text-right'>";
                                                        if($group['categories_delete'] == 1)
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
								    <td colspan="3" align="right"><?php echo $pager;?></td>
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
