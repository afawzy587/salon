<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';


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
                if($group['logs_view'] == 0){
                    header("Location:./permission.php");
                    exit;
                }else{
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $pager->doAnalysisPager("page",$page,$basicLimit,$logs->getTotallogs(),"logs.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $logs = $logs->getsitelogs($limitmequry);


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
            <input type="hidden" value="logs" id="page">
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
                      <h4 class="card-title "><?php echo $lang['logs'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead class=" text-primary">
                            <th>
                              #
                            </th>
                            <th>
                              <?php echo $lang['log_type'];?>
                            </th>
                            <th>
                              <?php echo $lang['log_by'];?>
                            </th>
                              <th>
                              <?php echo $lang['log_user_name'];?>
                            </th>
                              <th>
                              <?php echo $lang['log_time'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($logs))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_logs']."</td></tr>";
                                    }else{
                                        foreach( $logs as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['id'].">
                                                    <td>".$u['id']."</td>
                                                    <td>".getlog_type($u['type'])."<br>".replacestring($u['message'])."</td>
                                                    <td>".$u['who']."</td>
                                                    <td>".getusername($u['user_id'])."</td>
                                                    <td>"._date_format($u['time'])."</td>
                                                </tr>";
                                        }
                                    }
                              ?>
                          </tbody>
                            <tfoot>
                                <tr>
								    <td colspan="4" align="right"><?php echo $pager;?></td>
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
