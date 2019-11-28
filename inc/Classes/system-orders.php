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


	function setordersInformation($orders)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `order_cart` WHERE `order_id` = '".$orders['id']."'");
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`order_type`      	        =	'".$orders['type']."',
			`order_status`		        =	'".$orders['status']."'
			WHERE `order_serial` 		= 	'".$orders['id']."' LIMIT 1 ");
        foreach($orders['product_id'] as $k => $p)
        {
            $query = $GLOBALS['db']->query("SELECT * FROM `products`  WHERE `product_serial` = '".$p."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteoproduct    = $GLOBALS['db']->fetchitem($query);
                $cartquery = $GLOBALS['db']->query("SELECT * FROM `order_cart`  WHERE `order_id` = '".$orders['id']."' AND `product_id` = '".$p."' LIMIT 1 ");
			    $cartTotal = $GLOBALS['db']->resultcount();
                if($cartTotal>0)
                {
                    $cartproduct    = $GLOBALS['db']->fetchitem($query);

                     $q = $cartproduct['quantity'] + $orders['quantity'][$k];

                     $GLOBALS['db']->query("UPDATE LOW_PRIORITY `order_cart` SET
                        `quantity`		                =	'".$q."'
                        WHERE `order_cart_serial` 		= 	'".$cartproduct['order_cart_serial']."' LIMIT 1 ");
                }else{
                    $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `order_cart`
                    (`order_cart_serial`, `order_id`, `product_id`, `quantity`, `price`)
                    VALUES ( NULL ,  '".$orders['id']."' ,'".$p."' , '".$orders['quantity'][$k]."','".$siteoproduct['product_price']."') ");
                }


            }
        }

		return 1;
	}

	function addNeworders($orders)
	{
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`order_serial`, `user_id`, `order_type`, `order_date`, `order_status`)
		VALUES ( NULL ,  '".$orders[user_id]."' ,'".$orders[type]."' , NOW() ,'".$orders[status]."') ");
        $pid = $GLOBALS['db']->fetchLastInsertId();
        foreach($orders[product_id] as $k => $p)
        {
            $query = $GLOBALS['db']->query("SELECT * FROM `products`  WHERE `product_serial` = '".$p."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteoproduct    = $GLOBALS['db']->fetchitem($query);
                $cartquery = $GLOBALS['db']->query("SELECT * FROM `order_cart`  WHERE `order_id` = '".$pid."' AND `product_id` = '".$p."' LIMIT 1 ");
			    $cartTotal = $GLOBALS['db']->resultcount();
                if($cartTotal>0)
                {
                    $cartproduct    = $GLOBALS['db']->fetchitem($query);

                     $q = $cartproduct['quantity'] + $orders['quantity'][$k];

                     $GLOBALS['db']->query("UPDATE LOW_PRIORITY `order_cart` SET
                        `quantity`		                =	'".$q."'
                        WHERE `order_cart_serial` 		= 	'".$cartproduct[order_cart_serial]."' LIMIT 1 ");
                }else{
                    $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `order_cart`
                    (`order_cart_serial`, `order_id`, `product_id`, `quantity`, `price`)
                    VALUES ( NULL ,  '".$pid."' ,'".$p."' , '".$orders['quantity'][$k]."','".$siteoproduct['product_price']."') ");
                }


            }
        }
        return 1;

	}

	function deleteorders($order_serial)
	{

		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `order_serial` = '".$order_serial."' LIMIT 1");
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `order_cart` WHERE `order_id` = '".$order_serial."'");
		return 1;
	}


}
?>
