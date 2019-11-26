<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-users.php");
	$Users = new systemUsers();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['users_view'] == 0){
                    header("Location:./permission.php");
                }else{
                    include("./inc/Classes/pager.class.php");
                    $page;
                    $pager      = new pager();
                    $page 		= intval($_GET[page]);
                    $pager->doAnalysisPager("page",$page,$basicLimit,$Users->getTotalUsers(),"users.php".$paginationAddons,$paginationDialm);
                    $thispage = $pager->getPage();
                    $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                    $pager =$pager->getAnalysis();
                    $users = $Users->getsiteUsers($limitmequry);
                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_users_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_users_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_branches_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $Users->deleteUsers($mId,$path);
                if($delete == 1)
                {
                    echo 116;
                    exit;
                }
            break;
            case"del":
                if($group['users_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $Users->deleteUsers($mId,$path);
                    if($delete == 1)
                    {
                        header("Location:./users.php?message=delete");
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
            <input type="hidden" value="users" id="page">
            <input type="hidden" value="<?php echo $lang['user']?>" id="lang_name">
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
                      <h4 class="card-title "><?php echo $lang['users'];?></h4>
                      <p class="card-category"><?php echo $lang['users_mangment'];?></p>
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
                              <?php echo $lang['email'];?>
                            </th>
                            <th>
                              <?php echo $lang['phone'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($users))
                                    {
                                        echo "<tr><td>".$lang['no_users']."</td></tr>";
                                    }else{
                                        foreach( $users as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['user_serial'].">
                                                    <td>".$u['user_serial']."</td>
                                                    <td><a href='users_view.php?id=".$u['user_serial']."'>".$u['user_name']."</a></td>
                                                    <td>".$u['email']."</td>
                                                    <td>".$u['phone']."</td>
                                                    <td id='item_".$u['user_serial']."'class='td-actions text-right'>";
                                                    if($group['users_edit'] == 1)
                                                    {
                                                        echo"<button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                            <i class='material-icons'>edit</i>
                                                        </button>";
                                                    }
                                                    if($group['users_delete'] == 1)
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
                                    <?php if($group['users_add'] == 1)
                                            {
								                echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="users_add.php">'.$lang['add_user'].'</a></td>';
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
