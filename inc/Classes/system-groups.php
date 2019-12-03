<?php if(!defined("inside")) exit;
class systemgroups
{
	var $tableName 	= "user_groups";

	function getsitegroups($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `group_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalgroups($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getgroupsInformation($group_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
            $query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `group_serial` = '".$group_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$sitegroup = $GLOBALS['db']->fetchitem($query);
				return array(
					"group_serial"                    =>          $sitegroup['group_serial'],
                    "group_name"                      =>          $sitegroup['group_name'],
                    "users_view"                      =>          $sitegroup['users_view'],
                    "users_edit"                      =>          $sitegroup['users_edit'],
                    "users_delete"                    =>          $sitegroup['users_delete'],
                    "users_add"                       =>          $sitegroup['users_add'],
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
                    "orders_view"                     =>          $sitegroup['orders_view'],
                    "orders_edit"                     =>          $sitegroup['orders_edit'],
                    "orders_delete"                   =>          $sitegroup['orders_delete'],
                    "orders_add"                      =>          $sitegroup['orders_add'],
                    "groups_view"                     =>          $sitegroup['groups_view'],
                    "groups_edit"                     =>          $sitegroup['groups_edit'],
                    "groups_delete"                   =>          $sitegroup['groups_delete'],
                    "groups_add"                      =>          $sitegroup['groups_add'],
                    "service_order_view"              =>          $sitegroup['service_order_view'],
                    "service_order_edit"              =>          $sitegroup['service_order_edit'],
                    "service_order_delete"            =>          $sitegroup['service_order_delete'],
                    "service_order_add"               =>          $sitegroup['service_order_add'],
                    "gallery_view"                    =>          $sitegroup['gallery_view'],
                    "gallery_delete"                  =>          $sitegroup['gallery_delete'],
                    "gallery_add"                     =>          $sitegroup['gallery_add'],
                    "best_sellers_view"               =>          $sitegroup['best_sellers_view'],
                    "salons_edit"                     =>          $sitegroup['salons_edit'],
                    "rates_view"                      =>          $sitegroup['rates_view'],
                    "status"                          =>          $sitegroup['status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function isgroupsExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `name` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$sitegroups = $GLOBALS['db']->fetchitem($query);
				return array(
					"group_serial"			=> 		$sitegroups['group_serial'],
				);


			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setgroupsInformation($groups)
	{

		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
          `group_name`		           	 =	        '".$groups['name']."',
          `users_view`                   =          '".$groups['users_view']."',
          `users_edit`                   =          '".$groups['users_edit']."',
          `users_delete`                 =          '".$groups['users_delete']."',
          `users_add`                    =          '".$groups['users_add']."',
          `branches_view`                =          '".$groups['branches_view']."',
          `branches_edit`                =          '".$groups['branches_edit']."',
          `branches_delete`              =          '".$groups['branches_delete']."',
          `branches_add`                 =          '".$groups['branches_add']."',
          `services_view`                =          '".$groups['services_view']."',
          `services_edit`                =          '".$groups['services_edit']."',
          `services_delete`              =          '".$groups['services_delete']."',
          `services_add`                 =          '".$groups['services_add']."',
          `staffs_view`                  =          '".$groups['staffs_view']."',
          `staffs_edit`                  =          '".$groups['staffs_edit']."',
          `staffs_delete`                =          '".$groups['staffs_delete']."',
          `staffs_add`                   =          '".$groups['staffs_add']."',
          `categories_view`              =          '".$groups['categories_view']."',
          `categories_edit`              =          '".$groups['categories_edit']."',
          `categories_delete`            =          '".$groups['categories_delete']."',
          `categories_add`               =          '".$groups['categories_add']."',
          `products_view`                =          '".$groups['products_view']."',
          `products_edit`                =          '".$groups['products_edit']."',
          `products_delete`              =          '".$groups['products_delete']."',
          `products_add`                 =          '".$groups['products_add']."',
          `orders_view`                  =          '".$groups['orders_view']."',
          `orders_edit`                  =          '".$groups['orders_edit']."',
          `orders_delete`                =          '".$groups['orders_delete']."',
          `orders_add`                   =          '".$groups['orders_add']."',
          `groups_view`                  =          '".$groups['groups_view']."',
          `groups_edit`                  =          '".$groups['groups_edit']."',
          `groups_delete`                =          '".$groups['groups_delete']."',
          `groups_add`                   =          '".$groups['groups_add']."',
          `service_order_view`           =          '".$groups['service_order_view']."',
          `service_order_edit`           =          '".$groups['service_order_edit']."',
          `service_order_delete`         =          '".$groups['service_order_delete']."',
          `service_order_add`            =          '".$groups['service_order_add']."',
          `gallery_view`                 =          '".$groups['gallery_view']."',
          `gallery_delete`               =          '".$groups['gallery_delete']."',
          `gallery_add`                  =          '".$groups['gallery_add']."',
          `best_sellers_view`            =          '".$groups['best_sellers_view']."',
          `salons_edit`                  =          '".$groups['salons_edit']."',
          `rates_view`                   =          '".$groups['rates_view']."',
          `status`		                 =	        '".$groups['status']."'
          WHERE `group_serial`    	     = 	        '".$groups['id']."' LIMIT 1 ");
		return 1;
	}

	function addNewgroups($groups)
	{

		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		( `group_serial` , `group_name` , `status`  )
		VALUES ( NULL ,  '".$groups[name]."' ,  '".$groups[status]."')");
		return 1;
	}

	function deletegroups($group_serial)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `group_serial` = '".$group_serial."' LIMIT 1 ");
		return 1;
	}
	
	function activestatusgroups($mgroup_serial,$status)
	{  
		if($status==1)
		{
			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`status`    =	'0'
			 WHERE `group_serial` 		 = 	'".$mgroup_serial."' LIMIT 1 ");
			return 1;
		}else
		{
			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
				`status`    =	'1'
			 	WHERE `group_serial` 		 = 	'".$mgroup_serial."' LIMIT 1 ");
			return 1;
		}
	}

}
?>
