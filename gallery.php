<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-gallery.php");
	$gallery = new systemgallery();
     
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
                if($group['gallery_view'] == 0){
                    header("Location:./permission.php");
                    exit;
                }else{
                   include("./inc/Classes/pager.class.php");
                    $page;
                    $pager      = new pager();
                    $page 		= intval($_GET[page]);
                    $total      = $gallery->getTotalgallery();
                    $pager->doAnalysisPager("page",$page,$basicLimit,$total,"gallery.php".$paginationAddons,$paginationDialm);
                    $thispage = $pager->getPage();
                    $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                    $pager =$pager->getAnalysis();
                    $gallery = $gallery->getsitegallery($limitmequry); 
                    $logs->addLog(61,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"gallery",
                                "mode" 		        => 	"list",
                                "total" 	        => 	$total,
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
                    
                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_gallery_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_gallery_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_branches_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $gallery->deletegallery($mId,$path);
                $logs->addLog(62,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"gallery",
                                "mode" 		        => 	"delete",
                                "gallery_id" 	    => 	$mId,
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
                if($group['gallery_delete'] == 0){
                    header("Location:./permission.php");
                    exit;
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $gallery->deletegallery($mId,$path);
                    $logs->addLog(62,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"gallery",
                                "mode" 		        => 	"delete",
                                "gallery_id" 	    => 	$mId,
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
                    if($delete == 1)
                    {
                        header("Location:./gallery.php?message=delete");
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
            <input type="hidden" value="gallery" id="page">
            <input type="hidden" value="<?php echo $lang['gallery']?>" id="lang_name">
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
                      <h4 class="card-title "><?php echo $lang['gallery'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead class=" text-primary">
                            <th>
                              # 
                            </th>
                            <th>
                              <?php echo $lang['type'];?>
                            </th>
                            <th>
                              <?php echo $lang['link'];?>
                            </th>
                            <th>
                              <?php echo $lang['status'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($gallery))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_gallery']."</td></tr>";
                                    }else{
                                        foreach( $gallery as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['gallery_serial'].">
                                                    <td>".$u['gallery_serial']."</td>
                                                    <td>";
                                                    if($u['gallery_type']== 'image'){
                                                        echo $lang['image']."</td><td><a href='".$path.$u['gallery_link']."' target=\"_blank\"><img src=".$path.$u['gallery_link']." class=\"rounded\"  width=\"100\" height=\"100\"></a></td>";
                                                    }else{echo $lang['video']."</td><td>
                                                    <a href='".$u['gallery_link']."' target=\"_blank\">".$lang['go_to_link']."</a>
                                                    </td>"; }
                                                    status("gallery","gallery_serial","gallery_status",$u['gallery_serial'],$u['gallery_status']);
                                                    echo"<td id='item_".$u['gallery_serial']."'class='td-actions text-right'>";
                                                        if($group['gallery_delete'] == 1)
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
								    <td colspan="4" align="right"><?php echo $pager;?></td>
                                    <?php if($group['gallery_add'] == 1)
                                            {
								                echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="gallery_add.php">'.$lang['add_gallery'].'</a></td>';
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
