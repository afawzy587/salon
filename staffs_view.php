<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-staffs.php");
	$staff = new systemstaff();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
        exit;
	}else{
        if($_GET['id'] != 0 )
		{
            
			$staff = $staff->getstaffInformation($_GET['id']);
            $logs->addLog(106,
                            array(
                                "type" 		        => 	"admin",
                                "module" 	        => 	"staff",
                                "mode" 		        => 	"update",
                                "staff_id" 		    => 	$_GET['id'],
                                "id" 	        	=>	$login->getUserId(),
                            ),"admin",$login->getUserId(),1
                        );
        }else{
            header("Location:./error.php");
            exit;
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
                      <h4 class="card-title"><?php echo $lang['staff_details'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="card card-profile">
                        <div class="card-avatar">
                          <a href="<?php echo $path.$staff['image'];?>" target="_blank">
                            <img class="img" src="<?php echo $path.$staff['image'];?>" />
                          </a>
                        </div>
                        <div class="card-body">
                          <h4 class="card-title"><?php echo $staff['staff_name'];?></h4>
                        </div>
                      </div>
                      <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:auto;display:inline-block;vertical-align:top;"><strong><?php echo $lang['branch'];?> :</strong></span>
								<span class="view_span"><?php echo getbranchname($staff['branch_id']);?></span>
							  </div> 
							</div> 
                       </div>
                        <br/> 
                          <div class="row">
                            <div class="col-md-12">
                                <div class="form-User">
                                    <p> <?php echo $lang['day_work'];?> </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                 <table class="table table-bordered table-sm">
                                    <thead>
                                      <tr>
                                        <th><?php echo $lang['DAY'];?></th>
                                        <th><?php echo $lang['start_time'];?></th>
                                        <th><?php echo $lang['end_time'];?></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                            <div class="custom-control  col-md-3">
                                                <span><?php if($staff['sat'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SAT'].'</i>';}else{
                                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['SAT'].'</i>';}?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['sat_from']);?></span>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['sat_to']);?></span>
                                        </td>
                                      </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control  col-md-3">
                                                <span><?php if($staff['sun'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['SUN'].'</i>';}else{
                                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['SUN'].'</i>';}?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['sun_from']);?></span>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['sun_to']);?></span>
                                        </td>
                                      </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control  col-md-3">
                                                <span><?php if($staff['mon'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['MON'].'</i>';}else{
                                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['MON'].'</i>';}?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['mon_from']);?></span>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['mon_to']);?></span>
                                        </td>
                                      </tr> 
                                     <tr>
                                        <td>
                                            <div class="custom-control  col-md-3">
                                                <span><?php if($staff['tus'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['TUE'].'</i>';}else{
                                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['TUE'].'</i>';}?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['tus_from']);?></span>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['tus_to']);?></span>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <div class="custom-control  col-md-3">
                                                <span><?php if($staff['wed'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['WED'].'</i>';}else{
                                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['WED'].'</i>';}?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['wed_from']);?></span>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['wed_to']);?></span>
                                        </td>
                                      </tr>
                                     <tr>
                                        <td>
                                            <div class="custom-control  col-md-3">
                                                <span><?php if($staff['thurs'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['THU'].'</i>';}else{
                                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['THU'].'</i>';}?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['thrus_from']);?></span>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['thrus_to']);?></span>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <div class="custom-control  col-md-3">
                                                <span><?php if($staff['fri'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['FRI'].'</i>';}else{
                                                echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['FRI'].'</i>';}?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['fri_from']);?></span>
                                        </td>
                                        <td>
                                            <span> <?php echo time_format($staff['fri_to']);?></span>
                                        </td>
                                      </tr>
                                     
                                     
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                         <br/>  
                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert ">
                                    <span style="width:auto;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                                    <span class="view_span"><?php if($staff['status'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';}else{
                                        echo '<i class="fa fa-check"style="font-size:18px"  dir="ltr">'.$lang['active'].'</i>';}?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="form-group" id="item_{$u.id}">
                <a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-rtl: 20px"><?php echo $lang['print'];?></a>
                  <?php if($group['staffs_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="staffs_edit.php?id='.$staff['staff_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['staffs_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="staffs.php?do=del&id='.$staff['staff_serial'].'">'.$lang['delete'].'</a>';
                  } ?>
                
                
             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>
