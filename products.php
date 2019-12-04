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
        switch($_GET['do'])
		{
			case"":
			case"list":
                if($group['products_view'] == 0){
                    header("Location:./permission.php");
                }else{
                    $cat_id = intval($_GET['category']);
                    if($cat_id == 0)
                    {
                       include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $total      = $products->getTotalproducts();
                        $pager->doAnalysisPager("page",$page,$basicLimit,$total,"products.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $products = $products->getsiteproducts($limitmequry); 
                        $logs->addLog(79,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"products",
                                    "mode" 		        => 	"list",
                                    "products" 		    => 	$total,
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                    }else{
                        include("./inc/Classes/pager.class.php");
                        $page;
                        $pager      = new pager();
                        $page 		= intval($_GET[page]);
                        $total      = $products->getTotalcategoryproducts($cat_id)
                        $pager->doAnalysisPager("page",$page,$basicLimit,$total,"products.php".$paginationAddons,$paginationDialm);
                        $thispage = $pager->getPage();
                        $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                        $pager =$pager->getAnalysis();
                        $products = $products->getcategoryproducts($limitmequry,$cat_id);
                         $logs->addLog(79,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"products",
                                    "mode" 		        => 	"list",
                                    "products" 		    => 	$total,
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                    }
                    
                    if($_GET['message']== "update")
                    {
                        $message = $lang['edit_products_success'];
                    }elseif($_GET['message']== "add"){
                        $message = $lang['add_products_success'];
                    }elseif($_GET['message']== "delete"){
                        $message = $lang['delete_product_success'];
                    }
                }
               
            break;
            case"delete":
                $mId = intval($_POST['id']);
                $delete = $products->deleteproducts($mId,$path);
                $logs->addLog(80,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"products",
                                    "mode" 		        => 	"delete",
                                    "product_id" 		    => 	$mId,
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
                if($group['products_delete'] == 0){
                    header("Location:./permission.php");
                }else{
                    $mId = intval($_GET['id']);
                    $delete = $products->deleteproducts($mId,$path);
                    $logs->addLog(80,
                                array(
                                    "type" 		        => 	"admin",
                                    "module" 	        => 	"products",
                                    "mode" 		        => 	"delete",
                                    "product_id" 		    => 	$mId,
                                    "id" 	        	=>	$login->getUserId(),
                                ),"admin",$login->getUserId(),1
                            );
                    if($delete == 1)
                    {
                        header("Location:./products.php?message=delete");
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
            <input type="hidden" value="products" id="page">
            <input type="hidden" value="<?php echo $lang['product']?>" id="lang_name">
            <input type="hidden" value="<?php echo $lang['delete_alarm_massage_in_man']?>" id="lang_del">
            <input type="hidden" value="<?php echo $lang['status_alarm_massage_in_man']?>" id="lang_status">  
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
                      <h4 class="card-title "><?php echo $lang['products'];?></h4>
                      <p class="card-category"> <?php if($cat_id){ echo $lang['category'].  ' : ' ."<br>"; getcategoryname($cat_id);}?></p>
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
                              <?php echo $lang['category'];?>
                            </th>  
                            <th>
                              <?php echo $lang['price'];?>
                            </th>
                            <th>
                              <?php echo $lang['discount'];?>
                            </th>
                            <th>
                              <?php echo $lang['settings'];?>
                            </th>
                          </thead>
                          <tbody>
                            <?php  if(empty($products))
                                    {
                                        echo "<tr><td colspan=\"5\">".$lang['no_products']."</td></tr>";
                                    }else{
                                        foreach( $products as $k => $u)
                                        {
                                            echo"<tr id=tr_".$u['product_serial'].">
                                                    <td>".$u['product_serial']."</td>
                                                    <td><a href='products_view.php?id=".$u['product_serial']."'>".$u['product_name']."</a></td>
                                                    <td>".getcategoryname($u['category_id'])."</td>
                                                    <td>".$u['product_price']."\n".$lang['Currancy']."</td>
                                                    <td>"; if($u['product_discount'] != 0){echo $u['product_discount'] ."\n".$lang['Currancy']. "<br>" . $lang['FROM'] . " : " . _date_format($u['product_from']) . "<br/    >". $lang['TO'] . " : " . _date_format($u['product_to']) ; }else{ echo "ـــــــــ" ;}
                                                    echo "</td>
                                                    <td id='item_".$u['product_serial']."'class='td-actions text-right'>";
                                                    if($group['products_edit'] == 1)
                                                    {
                                                        echo"<button  rel='tooltip' title='".$lang['edit']."'class='btn btn-primary btn-link btn-sm edit'>
                                                            <i class='material-icons'>edit</i>
                                                        </button>";
                                                    }
                                                    if($group['products_delete'] == 1)
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
								    <td colspan="5" align="right"><?php echo $pager;?></td>
                                    <?php 
                                         if($group['products_add'] == 1)
                                         {
                                            echo '<td colspan="1" align="left"><a class="btn btn-primary pull-left" href="products_add.php">'.$lang['add_product'].'</a></td>';
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
