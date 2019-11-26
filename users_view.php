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
        if($_GET['id'] != 0 )
		{
            
			$user = $Users->getUsersInformation($_GET['id']);
        }else{
            header("Location:./error.php");
        }
    }
?>
<body class="">
      <div class="wrapper ">
        <?php include './assets/layout/sidebar.php';?>
        <div class="main-panel">
          <?php include './assets/layout/navbar.php';?>
          <div class="content">
              <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title"><?php echo $lang['user_details'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="card card-profile">
                        <div class="card-avatar">
                          <a href="<?php echo $path.$user['image'];?>" target="_blank">
                            <img class="img" src="<?php echo $path.$user['image'];?>" />
                          </a>
                        </div>
                        <div class="card-body">
                          <h6 class="card-category text-gray"><?php echo $user['group'];?></h6>
                          <h4 class="card-title"><?php echo $user['user_name'];?></h4>
<!--                          <a href="#pablo" class="btn btn-primary btn-round">Follow</a>-->
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-md-7">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['phone'];?> :</strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $user['phone'];?></span>
							  </div> 
							</div> 
                            <div class="col-md-5">
                              <div class="alert">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['ADDRESS'];?> : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $user['address'];?></span>
							 </div>
                           </div>
                       </div> 
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['email'];?> : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $user['email'];?></span>
							  </div> 
							</div> 
                            <div class="col-md-12">
                              <div class="alert">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['last_login'];?> : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo _date_format($user['last_login']);?></span>
							 </div>
                           </div>
                       </div>
                        <div class="alert ">
                            <span style="width:20%;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                            <span style="width:75%;display:inline-block;"><?php if($user['status'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';}else{
                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['active'].'</i>';}?></span>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="form-group" id="item_{$u.id}">
                <a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-rtl: 20px"><?php echo $lang['print'];?></a>
                  <?php if($group['users_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="users_edit.php?id='.$user['user_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['users_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="users.php?do=del&id='.$user['user_serial'].'">'.$lang['delete'].'</a>';
                  } ?>
                
                
             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>    