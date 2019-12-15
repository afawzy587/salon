<?php
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include './assets/layout/header.php';
    include("./inc/Classes/system-search.php");
	$sys = new systemsearch();

	if($login->doCheck() == false)
	{
        $message = $lang['LGN_YOU_MUST_LOGIN'];
        header("Location:./login.php");
	}else{
        if (isset($_GET['query']) && $_GET['query'] != "" )
        {
            $query = (sanitize($_GET['query']));
            if(strlen($query) < 3)
            {
                 $search     = $query;
                 $errors['SEARCH_WORD'] = $lang['SEARCH_WORD'];
            }else
            {
                $search     = $query;
                $groups     = $sys->search_for_groups($query);
                $users      = $sys->search_for_users($query);
                $branches   = $sys->search_for_branches($query);
                $services   = $sys->search_for_services($query);
                $products   = $sys->search_for_products($query);
                $logs->addLog(112,
                    array(
                        "type" 		        => 	"admin",
                        "module" 	        => 	"search",
                        "mode" 		        => 	"search",
                        "total" 	        => 	$q,
                        "id" 	        	=>	$login->getUserId(),
                    ),"admin",$login->getUserId(),1
                );
            }
        }else
        {
            $errors['SEARCH_MUST'] = $lang['SEARCH_MUST'];
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

                  </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title "><?php echo $lang['SEARCH_RESULT'];?></h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                         <?php if($groups || $users || $branches || $services || $products)
                          {
                            echo '<table class="table">
                                  <thead class=" text-primary">
                                    <th>'.$lang['IN'].'</th>
                                    <th>'.$lang['DETAILS'].'</th>
                                  </thead>
                                  <tbody>';
                                if($groups){
                                    foreach($groups as $gId => $g)
                                    {
                                        echo'<tr>
                                            <td>'.$lang['groups'].'</td>
                                            <td>'.$lang['name'].' : <b><a href="groups_view.php?id='.$g['group_serial'].'">'.$g['group_name'].'</a></b></td>
                                            </tr>';
                                    }
                                }
                                if($users){
                                    foreach($users as $uId => $u)
                                    {
                                        echo'<tr>

                                            <td>'.$lang['users'].'</td>
                                            <td><a href="users_view.php?id='.$u['user_serial'].'">'.$lang['name'].' : <b>'.$u['user_name'].'</b> <br>
                                            '.$lang['email'].' : <b>'.$u['email'].'</b><br>
                                            '.$lang['phone'].' : <b>'.$u['phone'].'</b><br>
                                            '.$lang['group'].' : <b>'.$u['group_name'].'</b><br>
                                            </a></td>
                                            </tr>';
                                    }
                                }
                             if($branches){
                                    foreach($branches as $bId => $b)
                                    {
                                        echo'<tr>

                                            <td>'.$lang['branches'].'</td>
                                            <td><a href="branches_view.php?id='.$b['branch_serial'].'">'.$lang['name'].' : <b>'.$b['branch_name'].'</b> <br>
                                            '.$lang['owner'].' : <b>'.$b['user_name'].'</b><br>
                                            '.$lang['email'].' : <b>'.$b['email'].'</b><br>
                                            '.$lang['phone'].' : <b>'.$b['phone'].'</b><br>
                                            </a></td>
                                            </tr>';
                                    }
                                }
                            if($services){
                                    foreach($services as $sId => $s)
                                    {
                                        echo'<tr>
                                            <td>'.$lang['services'].'</td>
                                            <td>'.$lang['name'].' : <b><a href="services_view.php?id='.$s['service_serial'].'">'.$s['service_name'].'</a></b></td>
                                            </tr>';
                                    }
                                }
                            if($products){
                                    foreach($products as $pId => $p)
                                    {
                                        echo'<tr>
                                            <td>'.$lang['products'].'</td>
                                            <td>'.$lang['name'].' : <a href="products_view.php?id='.$p['product_serial'].'"><b>'.$p['product_name'].'</b> <br>
                                            '.$lang['category'].' : <b>'.$p['category_name'].'</b><br>
                                            '.$lang['price'].' : <b>'.$p['product_price'].'</b><br>
                                            </a></td>
                                            </tr>';
                                    }
                                }

                             echo'</tbody>
                                </table>';
                          }else{
                                echo '<tbody>
                                        <tr>
								            <td colspan="6" align="center">';
                                            if($errors)
                                            {

                                                foreach($errors as $k=> $e)
                                                {
                                                    echo '<li><strong>'.$e.'</strong></li>';
                                                }
                                            }else{
                                                echo '<li><strong>'.$lang['NO_SEACH_RESULT'].'</strong></li>';
                                            }

                                   echo '</td>
								        </tr>
                                    </tbody>';
                            }
                          ?>

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
 <script src="./assets/js/list-controls.js"></script>
