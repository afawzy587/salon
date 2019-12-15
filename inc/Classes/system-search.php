<?php if(!defined("inside")) exit;
class systemsearch
{

	function search_for_groups($q)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT
			c.group_serial,
			c.group_name
			FROM `user_groups` c WHERE ( c.`group_name` LIKE '%".$q."%' ) ORDER BY c.`group_serial` DESC ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    function search_for_services($q)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT
			a.service_serial,
			a.service_name
			FROM `services` a WHERE ( a.`service_name` LIKE '%".$q."%' ) ORDER BY a.`service_serial` DESC ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

    function search_for_users($q)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT
			a.user_serial,
			a.user_name,
			a.email,
			a.phone,
			b.group_name
			FROM `users` a INNER JOIN `user_groups` b ON a.`group_id` = b.`group_serial` WHERE ( b.`group_name` LIKE '%".$q."%' || a.`user_name` LIKE '%".$q."%' || a.`email` LIKE '%".$q."%' || a.`phone` LIKE '%".$q."%'  ) ORDER BY a.`user_serial` DESC ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}


    function search_for_branches($q)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT
			a.user_serial,
			a.user_name,
			a.email,
			a.phone,
			b.branch_serial,
			b.branch_name
			FROM `salon_branches` b INNER JOIN `users` a ON a.`user_serial` = b.`manager_id` WHERE ( b.`branch_name` LIKE '%".$q."%' || a.`user_name` LIKE '%".$q."%' || a.`email` LIKE '%".$q."%' || a.`phone` LIKE '%".$q."%'  ) ORDER BY b.`branch_serial` DESC ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    function search_for_products($q)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT
			a.product_serial,
			a.product_price,
			b.category_name,
			a.product_name
			FROM `products` a INNER JOIN `product_categories` b ON a.`category_id` = b.`category_serial` WHERE ( a.`product_name` LIKE '%".$q."%' || b.`category_name` LIKE '%".$q."%' ) ORDER BY a.`product_serial` DESC ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}





}
?>
