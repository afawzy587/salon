<?php  if(!defined("inside"))  exit;?>
<?php
	error_reporting (E_ALL ^ E_NOTICE);
    ######### Main PATHs #########
	define('INCLUDES_PATH',	dirname(__FILE__) 	. DIRECTORY_SEPARATOR);
	define('CLASSES_PATH',	INCLUDES_PATH 		. "Classes" . DIRECTORY_SEPARATOR);
	define('LIBs_PATH',		CLASSES_PATH 		. "libs" 	. DIRECTORY_SEPARATOR);
	define('ROOT_PATH',		INCLUDES_PATH 		. ".." 		. DIRECTORY_SEPARATOR);
	define('ASSETS_PATH', 	ROOT_PATH 			. "assets"	. DIRECTORY_SEPARATOR);
	define('CASH_PATH', 	ROOT_PATH 			. "cash"	. DIRECTORY_SEPARATOR);
    #########  Db & config Files  #########
	include(CLASSES_PATH 	. 	"database.class.php");
	include(INCLUDES_PATH 	. 	"config.php");
	include(ASSETS_PATH		.	"assets.php");
    ######### Admin Authorization Class #########
	include(CLASSES_PATH 	."login.class.php");
	$login = new loginClass();
    $basicLimit = 15;
    ######## Image path #######################
    $upload_path ='./uploads';
    $path ='./uploads/';
    ######### Language files #########
    include("./assets/Languages/lang.php");

    ######## permission for user login #######

    if($GLOBALS['login']->doCheck() == true)
    {
        $query = $GLOBALS['db']->query("SELECT * FROM `user_groups` g INNER JOIN `users` u ON u.`group_id` = g.`group_serial`  WHERE u.`user_serial` = '".$login->getUserId()."' LIMIT 1 ");
        $queryTotal = $GLOBALS['db']->resultcount();
        if($queryTotal > 0)
        {
            $sitegroup = $GLOBALS['db']->fetchitem($query);
            
            $group     = array(
            
            "user_serial"                     =>          $sitegroup['user_serial'],
            "group_name"                      =>          $sitegroup['group_name'],
            "users_view"                      =>          $sitegroup['users_view'],
            "users_edit"                      =>          $sitegroup['users_edit'],
            "users_delete"                    =>          $sitegroup['users_delete'],
            "users_add"                       =>          $sitegroup['users_add'],
            "salons_view"                     =>          $sitegroup['salons_view'],
            "salons_edit"                     =>          $sitegroup['salons_edit'],
            "salons_delete"                   =>          $sitegroup['salons_delete'],
            "salons_add"                      =>          $sitegroup['salons_add'],
            "branches_view"                   =>          $sitegroup['branches_view'],
            "branches_edit"                   =>          $sitegroup['branches_edit'],
            "branches_delete"                 =>          $sitegroup['branches_delete'],
            "branches_add"                    =>          $sitegroup['branches_add'],
            "services_view"                   =>          $sitegroup['services_view'],
            "services_edit"                   =>          $sitegroup['services_edit'],
            "services_delete"                 =>          $sitegroup['services_delete'],
            "services_add"                    =>          $sitegroup['services_add'],
            "staffs_view"                     =>          $sitegroup['staffs_view'],
            "staffs_edit"                     =>          $sitegroup['staffs_edit'],
            "staffs_delete"                   =>          $sitegroup['staffs_delete'],
            "staffs_add"                      =>          $sitegroup['staffs_add'],
            "categories_view"                 =>          $sitegroup['categories_view'],
            "categories_edit"                 =>          $sitegroup['categories_edit'],
            "categories_delete"               =>          $sitegroup['categories_delete'],
            "categories_add"                  =>          $sitegroup['categories_add'],
            "products_view"                   =>          $sitegroup['products_view'],
            "products_edit"                   =>          $sitegroup['products_edit'],
            "products_delete"                 =>          $sitegroup['products_delete'],
            "products_add"                    =>          $sitegroup['products_add'],
            "gallery_view"                    =>          $sitegroup['gallery_view'],
            "gallery_delete"                  =>          $sitegroup['gallery_delete'],
            "gallery_add"                     =>          $sitegroup['gallery_add'],    
            "best_sellers_view"               =>          $sitegroup['best_sellers_view'],
            "rates_view"                      =>          $sitegroup['rates_view']    
    
            );
        }
    }

    






?>
