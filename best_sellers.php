<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-best_sellers.php");
	$best_sellers = new systembest_sellers();

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['best_sellers_view'] == 0){
                    header("Location:./permission.php");
                }else{
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET['page']);
                        $total      = $best_sellers->getTotalbest_sellers();
                        $pager->doAnalysisPager("page",$page,$basicLimit,$total,"best_sellers.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $best_sellers = $best_sellers->getsitebest_sellers($limitmequry);
                        $logs->addLog(50,
									array(
										"type" 		        => 	"admin",
										"module" 	        => 	"best_saller",
										"mode" 		        => 	"list",
										"total" 		    => 	$total,
										"id" 	        	=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);

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
            <input type="hidden" value="best_sellers" id="page">
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
                      <h4 class="card-title "><?php echo $lang['best_sellers'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead class=" text-primary">
                            <th>
                              #
                            </th>
                            <th>
                              <?php echo $lang['product'];?>
                            </th>
                            <th>
                              <?php echo $lang['best_sellers_quantity'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($best_sellers))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_best_sellers']."</td></tr>";
                                    }else{
                                        foreach( $best_sellers as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['best_seller_serial'].">
                                                    <td>".$u['best_seller_serial']."</td>
                                                    <td>".getproductname($u['product_id'])."</td>
                                                    <td>".$u['quantity']."</td>
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
