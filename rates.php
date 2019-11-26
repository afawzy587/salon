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
	}else{
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['rates_view'] == 0){
                    header("Location:./permission.php");
                }else{
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $pager->doAnalysisPager("page",$page,$basicLimit,$rates->getTotalrates(),"rates.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $rates = $rates->getsiterates($limitmequry); 
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
                if($delete == 1)
                {
                    echo 116;
                    exit;
                }
            break;
            case"del":
                if($group['rates_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $rates->deleterates($mId,$path);
                    if($delete == 1)
                    {
                        header("Location:./rates.php?message=delete");
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
                      <h4 class="card-title "><?php echo $lang['categories'];?></h4>
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
                              <?php echo $lang['status'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($categories))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_categories']."</td></tr>";
                                    }else{
                                        foreach( $categories as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['rate_serial'].">
                                                    <td>".$u['rate_serial']."</td>
                                                    <td>".$u['rate']."</td>
                                                    <td>".$u['rate_description']."</td>
                                                    <td><span>";
                                                    if($u['rate_status'] == 0){
                                                        echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';
                                                    }else{
                                                        echo '<i class=\"fa fa-check"style="font-size:18px\"  dir=\"ltr\">'.$lang['active'].'</i>';
                                                    }
                                                    echo"</span>
                                                        </td>
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