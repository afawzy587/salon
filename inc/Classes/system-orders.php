<?php if(!defined("inside")) exit;
class systemorders
{
	var $tableName 	= "orders";

	function getsiteorders($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `order_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalorders($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

    function getuserorders($addon = "" , $user_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `user_id` ='".$user_id."' ORDER BY `order_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

    function getTotaluserorders($user_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` WHERE `user_id` ='".$user_id."' ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getordersInformation($order_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."`  WHERE `order_serial` = '".$order_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteorders     = $GLOBALS['db']->fetchitem($query);
                $productquery   = $GLOBALS['db']->query("SELECT `order_cart_serial`, `order_id`, `product_id`, `quantity`, `price` FROM `order_cart` WHERE `order_id` = '".$order_serial."' ");
                $productTotal   = $GLOBALS['db']->resultcount();
                $products       = $GLOBALS['db']->fetchlist();
                $_products      = [];
                foreach($products as $pid => $p)
                {
                    $_products[$pid]['id']                    =  $p['order_cart_serial'];
                    $_products[$pid]['order_id']              =  $p['order_id'];
                    $_products[$pid]['product_id']            =  $p['product_id'];
                    $_products[$pid]['quantity']              =  $p['quantity'];
                    $_products[$pid]['price']                 =  $p['price'];
                    $_products[$pid]['product_total']         =  ($p['price'] * $p['quantity']);
                    $total  += $_products[$pid]['product_total'];
                }


				return array(
					"order_serial"	        => 		$siteorders['order_serial'],
					"user_id"				=> 		$siteorders['user_id'],
					"order_type"    		=> 		$siteorders['order_type'],
					"order_date"		    => 		$siteorders['order_date'],
					"total"		            => 		$total,
					"products"		        => 		$_products,
					"status"			    => 		$siteorders['order_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

//	function isordersExists($name)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `user_name` = '".$name."' ||`phone` = '".$name."' || `email` = '".$name."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal == 1)
//			{
//				$siteorders = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"id"			=> 		$siteorders['order_serial'],
//				);
//			}else{return true;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}

	function setordersInformation($orders)
	{
		if($orders[password] != "")
		{
			$queryPass = "`password`='".crypt($orders[password],$GLOBALS['login']->salt)."',";
		}else
		{
			$queryPass = "";
		}

		if($orders[image] != "")
		{
			$queryimage = "`user_photo`='".$orders[image]."',";
		}else
		{
			$queryimage = "";
		}

        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`user_name`			        =	'".$orders[name]."',".$queryPass."
			`user_address`              =	'".$orders[address]."',".$queryimage."
			`email`      	            =	'".$orders[email]."',
			`phone`      	            =	'".$orders[phone]."',
			`group_id`      	        =	'".$orders[group]."',
			`user_status`		        =	'".$orders[status]."'
			WHERE `order_serial` 		= 	'".$orders[id]."' LIMIT 1 ");
		return 1;
	}

	function addNeworders($orders)
	{
		if($orders[password] != "")
		{
			 $orders[password] = crypt($orders[password],$GLOBALS['login']->salt);
		}
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`order_serial`, `user_name`, `email`, `user_address`, `password`, `phone`, `user_photo`, `group_id`,`user_status`)
		VALUES ( NULL ,  '".$orders[name]."' ,'".$orders[email]."' , '".$orders[address]."' ,'".$orders[password]."' ,'".$orders[phone]."' ,'".$orders[image]."' ,'".$orders[group]."','".$orders[status]."'  ) ");
		return 1;
	}

	function deleteorders($order_serial,$path)
	{

		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `order_serial` = '".$order_serial."' LIMIT 1");
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `order_cart` WHERE `order_id` = '".$order_serial."'");
		return 1;
	}

//	function activestatusorders($morder_serial,$status)
//	{
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `order_serial` 		 = 	'".$morder_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `order_serial` 		 = 	'".$morder_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>
