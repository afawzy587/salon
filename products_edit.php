<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';

    include("./inc/Classes/system-categories.php");
    $categories = new systemcategories();

    include("./inc/Classes/system-products.php");
	$products = new systemproducts();



	
     
	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
        exit;
	}else{
        if($group['products_edit'] == 0){
            header("Location:./permission.php");
            exit;
        }else{ 
            $id    = intval($_GET['id']);
            
            if($id != 0){
                $category    = $categories->getsitecategories();
                $u           = $products->getproductsInformation($id);
                if($_POST)
                {
                    
                        
                    $_product['id']              =      $id;
                    $_product['name']            =       sanitize($_POST["name"]);
                    $_product['price']           =       floatval($_POST["price"]);
                    $_product['discount']        =       floatval($_POST["discount"]);
                    $_product['from']            =       sanitize($_POST["from"]);
                    $_product['to']              =       sanitize($_POST["to"]);
                    $_product['description']     =       sanitize($_POST["description"],"area");
                    $_product['category_id']     =       intval($_POST["category_id"]);
                    $_product['status']          =       intval($_POST["status"]);


                    if ($_product[name] =="" )
                    {
                        $errors[name] = $lang['no_product_name'];
                    }else{
                        $check = $products->isproductsExists($_product['name']);
                            if(is_array($check))
                            {
                                if($check['id'] != $_product['id'])
                                {
                                  $errors[name] = $lang['add_this_product_before'];
                                }
                            }
                    }

                    if ($_product['price'] == 0 )
                    {
                        $errors['price'] = $lang['insert_product_price'];
                    }

                    if ($_product['discount'] != 0 )
                    {
                        if ($_product['from'] == "" )
                        {
                            $errors['from'] = $lang['insert_product_from'];
                        }

                        if ($_product['to'] == "" )
                        {
                            $errors['to'] = $lang['insert_product_to'];
                        }
                    }

                    if ($_product['category_id'] == 0 )
                    {
                        $errors['category_id'] = $lang['choose_category_id'];
                    }

                    if ($_product['description'] == "" )
                    {
                        $errors['description'] = $lang['insert_product_description'];
                    }

                    if($_FILES && ( $_FILES['image']['name'] != "") && ( $_FILES['image']['tmp_name'] != "" ) )
                    {
                        if(!empty($_FILES['image']['error']))
                        {
                            switch($_FILES['image']['error'])
                            {
                                case '1':
                                    $errors[image] = $lang['UP_ERR_SIZE_BIG'];
                                    break;
                                case '2':
                                    $errors[image] = $lang['UP_ERR_SIZE_BIG'];
                                    break;
                                case '3':
                                    $errors[image] = $lang['UP_ERR_FULL_UP'];
                                    break;
                                case '4':
                                    $errors[image] = $lang['UP_ERR_SLCT_FILE'];
                                    break;
                                case '6':
                                    $errors[image] = $lang['UP_ERR_TMP_FLDR'];
                                    break;
                                case '7':
                                    $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                                    break;
                                case '8':
                                    $errors[image] = $lang['UP_ERR_UPLODED_STPD'];
                                    break;
                                case '999':
                                default:
                                    $errors[image] = $lang['UP_ERR_UNKNOWN'];
                            }
                        }
                    }
                    if( $_FILES && ( $_FILES['image']['name'] != "") && ( $_FILES['image']['tmp_name'] != "" ) )
                    {
                        include_once("./inc/Classes/upload.class.php");

                        $allow_ext = array("jpg","jpeg","gif","png");

                        $upload    = new Upload($allow_ext,false,0,0,5000,$upload_path,".","",false);

                        $files[name] 	= addslashes($_FILES["image"]["name"]);
                        $files[type] 	= $_FILES["image"]['type'];
                        $files[size] 	= $_FILES["image"]['size']/1024;
                        $files[tmp] 	= $_FILES["image"]['tmp_name'];
                        $files[ext]		= $upload->GetExt($_FILES["image"]["name"]);

                        $upfile	= $upload->Upload_File($files);


                        if($upfile)
                        {
                            $_product[image] = $upfile[newname];
                        }else
                        {
                           $errors[image] = $lang['UP_ERR_NOT_UPLODED'];
                        }
                        @unlink($path.$u['image']);
                    }

                    if(empty($errors)){
                        $update = $products->setproductsInformation($_product);
                        $logs->addLog(82,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"products",
                                    "mode" 		        => 	"update",
                                    "product_id" 		=> 	$_product['id'],
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                        if($update == 1){
                            header("Location:./products.php?message=update");
                            exit;
                        }
                    }
                }
            }else{
                 header("Location:./error.php");
                exit;
            }
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
              	<div class="col-lg-12">
					<?php if ($success){
							echo '<div class="alert alert-success">'.$success.'</div>';
						}else{
							if($errors)
							{
								echo '<div class="alert alert-danger">
								     <ul>';
								foreach($errors as $k=> $e)
								{
									echo '<li><strong>'.$e.'</strong></li>';
								}
								echo'</ul>
							         </div>';
							}
						}
					?>
              </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title"><?php echo $lang['edit_product'];?></h4>
                    </div>
                    <div class="card-body">
                      <form role='form' action="./products_edit.php?id=<?php echo $u['product_serial'];?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['name'];?></label>
                              <input type="text" class="form-control" name ="name"  value="<?php if($_product){echo $_product['name'];}else{echo $u['product_name'];}?>">
                            </div>
                          </div>
                        </div>
                          <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['price'];?></label>
                              <input type="number" class="form-control" min='1' step="any" name ="price"  value="<?php if($_product){echo $_product['price'];}else{echo $u['price'];}?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['discount'];?></label>
                              <input type="number" class="form-control"  step="any" name ="discount"  value="<?php if($_product){echo $_product['discount'];}else{echo $u['discount'];}?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['FROM'];?></label>
                              <input type="datetime" class="date form-control"  name ="from"  value="<?php if($_product){echo _date_format($_product['from']);}else{echo _date_format($u['from']);}?>">
                            </div>
                          </div>
                         <div class="col-md-4">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['TO'];?></label>
                              <input type="datetime" class="date form-control"   name ="to"  value="<?php if($_product){echo _date_format($_product['to']);}else{echo _date_format($u['to']);}?>">
                            </div>
                          </div>
                        </div>  
                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['category'];?></label>
                              <select class="browser-default custom-select choose" name="category_id">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
								  <?php if(!empty($category))
										{
											foreach($category as $k => $c)
											{
                                                echo '<option value="'.$c[category_serial].'"';
                                                if($_product){if($c[category_serial] == $_product[category_id]){echo 'selected';}}else{if($c[category_serial] == $u[category_id]){echo 'selected';}}
                                                echo'>'.$c[category_name].'</option>';
											}
										}
								  ?>
								</select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <div class="form-group">
                                    <label class="bmd-label-floating"> <?php echo $lang['product_description'];?></label>
                                    <textarea class="form-control" rows="5" name ="description"><?php if($_product){echo br2nl($_product['description']);}else{echo br2nl($u['description']);}?></textarea>
                                  </div>
                            </div>
                          </div>
                        </div>
                         
                      
                        <div class="row">
                          <div class="col-md-11">
                           <div class="form-group">
							<div class="ml-2 col-sm-5">
							  <div id="msg"></div>
								<input type="file" name="image" class="file" accept="image/*">
								<div class="input-User my-3">
								  <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
								  <div class="input-User-append">
									<button type="button" class="browse btn btn-primary"><?php echo $lang['image'];?></button>
								  </div>
								</div>
							</div>
							<div class="ml-2 col-sm-5">
							  <img src="<?php echo $path.$u['image'];?>" id="preview" class="img-thumbnail" style="width:100px;height:100px">
							</div>
				           </div>
                          </div>
                        </div>
                         <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating"><?php echo $lang['status'];?></label>
                              <select class="browser-default custom-select" name="status">
								  <option disabled  selected><?php echo $lang['choose'];?></option>
                                  
									<option value="0" <?php if($_product){if($_product[status] == 0){echo 'selected';}}else{if($u[status] == 0){echo 'selected';}}?>>
                                        <?php echo $lang['deactive'];?></option>
								  <option value="1" <?php if($_product){if($_product[status] == 1){echo 'selected';}}else{if($u[status] == 1){echo 'selected';}}?>><?php echo $lang['active'];?></option>
								</select>
                            </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><?php echo $lang['edit_product'];?></button>
                        <div class="clearfix"></div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
       </div>
    </div>
<?php include './assets/layout/footer.php';?> 
<script src="./assets/js/list-controls.js"></script>
