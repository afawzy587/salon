<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-products.php");
	$products = new systemproducts();
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if($_GET['id'] != 0 )
		{
			$product = $products->getproductsInformation($_GET['id']);
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
                      <h4 class="card-title"><?php echo $lang['product_details'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="card card-profile">
                        <div class="card-body">
                          <h2 class="card-title"><?php echo $product['product_name'];?></h2>
                          <h4 class="card-category text-gray"><?php echo  $lang['category']." : ".getcategoryname($product['category_id']);?></h4>
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="alert ">
								<span style="width:25%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['price'];?> :</strong></span>
								<span style="width:70%;display:inline-block;"><?php echo $product['price'] ." \n ".$lang['Currancy'];?></span>
							  </div> 
							</div> 
                            <div class="col-md-6">
                              <div class="alert ">
								<span style="width:25%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['discount'];?> :</strong></span>
								<span style="width:70%;display:inline-block;"><?php if($product['discount'] !=0){echo $product['discount'] ."\n".$lang['Currancy']. "<br>" . $lang['FROM'] . " : " . _date_format($product['from']) ."<br>". $lang['TO'] . " : " . _date_format($product['to']) ;}else{ echo "ـــــــــ" ;} ?></span>
							  </div> 
							</div>
                       </div> 
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['product_description'];?> :</strong></span>
								<span style="width:80%;display:inline-block;"><?php echo br2nl($product['description']) ;?></span>
							  </div> 
							</div> 
                       </div> 
                        <div class="row">
                            <div class="col-md-12">
                              <div class="alert ">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $lang['image'];?> : </strong></span>
                                   <a href="<?php echo $path.$product['image'];?>" target="_blank">
                                        <span style="width:80%;display:inline-block;">
                                           <img src="<?php echo $path.$product['image'];?>" class="rounded"  width="100" height="100">
                                        </span>
                                    </a>

							  </div> 
							</div> 
                       </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert ">
                                    <span style="width:20%;display:inline-block;vertical-align:top;"><strong>  <?php echo $lang['status'];?>  : </strong></span>
                                    <span style="width:75%;display:inline-block;"><?php if($product['status'] == 0){echo '<i class="fa fa-close" style="font-size:18px;color:red" dir="ltr">'.$lang['deactive'].'</i>';}else{
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
                  <?php if($group['products_edit'] == 1){
                    echo '<a class="hidden-print btn btn-warning btn-sm" href="products_edit.php?id='.$product['product_serial'].'">'.$lang['edit'].'</a>';
                  } ?>
                  <?php if($group['products_delete'] == 1){
                    echo '<a class="hidden-print btn btn-danger btn-sm" href="products.php?do=del&id='.$product['product_serial'].'">'.$lang['delete'].'</a>';
                  } ?>
                
                
             </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?>
