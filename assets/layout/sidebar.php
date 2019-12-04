<div class="sidebar" data-color="purple" data-background-color="white" data-image="./assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="./index.php" class="simple-text logo-normal">
          <?php echo $lang['site_name'];?>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="./index.php">
              <i class="material-icons">dashboard</i>
              <p><?php echo $lang['Dashboard'];?></p>
            </a>
          </li>
            <?php
            if($group['groups_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./groups.php">
                      <i class="material-icons">accessibility</i>
                      <p>'.$lang['groups'].'</p>
                    </a>
                  </li>';
            }
            ?>
          <?php
            if($group['users_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./users.php">
                      <i class="material-icons">person</i>
                      <p>'.$lang['users'].'</p>
                    </a>
                  </li>';
            }
            ?>
            <?php
            if($group['branches_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./branches.php">
                      <i class="material-icons">apartment</i>
                      <p>'.$lang['branches'].'</p>
                    </a>
                  </li>';
            }
            ?>

         <?php
            if($group['services_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./services.php">
                      <i class="material-icons">style</i>
                      <p>'.$lang['services'].'</p>
                    </a>
                  </li>';
            }
         ?>
        <?php
            if($group['staffs_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./staffs.php">
                      <i class="material-icons">people</i>
                      <p>'.$lang['staffs'].'</p>
                    </a>
                  </li>';
            }
            ?>
        <?php
            if($group['categories_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./categories.php">
                      <i class="material-icons">category</i>
                      <p>'.$lang['categories'].'</p>
                    </a>
                  </li>';
            }
            ?>
         
         <?php
            if($group['products_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./products.php">
                      <i class="material-icons">shop</i>
                      <p>'.$lang['products'].'</p>
                    </a>
                  </li>';
            }
            ?>
            <?php
        if($group['orders_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./orders.php">
                      <i class="material-icons">shopping_cart</i>
                      <p>'.$lang['orders'].'</p>
                    </a>
                  </li>';
            }
            ?>
        <?php
            if($group['service_order_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./service_order.php">
                      <i class="material-icons">settings_input_composite</i>
                      <p>'.$lang['service_orders'].'</p>
                    </a>
                  </li>';
            }
            ?>
        <?php
            if($group['gallery_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./gallery.php">
                      <i class="material-icons">perm_media</i>
                      <p>'.$lang['gallery'].'</p>
                    </a>
                  </li>';
            }
            ?>
        <?php
            if($group['rates_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./rates.php">
                      <i class="material-icons">grade</i>
                      <p>'.$lang['rates'].'</p>
                    </a>
                  </li>';
            }
            ?>
       <?php
            if($group['best_sellers_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./best_sellers.php">
                      <i class="material-icons">bar_chart</i>
                      <p>'.$lang['best_sellers'].'</p>
                    </a>
                  </li>';
            }
            ?>
        <?php
            if($group['logs_view'] == 1)
            {
               echo'<li class="nav-item">
                    <a class="nav-link" href="./logs.php">
                      <i class="material-icons">assignment</i>
                      <p>'.$lang['logs'].'</p>
                    </a>
                  </li>';
            }
            ?>

        </ul>
          
      </div>
    </div>
