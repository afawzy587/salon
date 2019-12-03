<?php if(!defined("inside")) exit;
class systemservice_order
{
	var $tableName 	= "service_order";

	function getsiteservice_order($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `service_order_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalservice_order($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

    function getuserservice_order($addon = "" , $user_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `user_id` ='".$user_id."' ORDER BY `service_order_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

    function getTotaluserservice_order($user_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` WHERE `user_id` ='".$user_id."' ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getservice_orderInformation($service_order_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."`  WHERE `service_order_serial` = '".$service_order_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteservice_order     = $GLOBALS['db']->fetchitem($query);
                $sevicequery   = $GLOBALS['db']->query("SELECT * FROM `service_cart` WHERE `order_id` = '".$service_order_serial."' ");
                $seviceTotal   = $GLOBALS['db']->resultcount();
                $sevices       = $GLOBALS['db']->fetchlist();
                $_sevices      = [];
                foreach($sevices as $sid => $s)
                {
                    $_sevices[$sid]['id']                    =  $s['cart_serial'];
                    $_sevices[$sid]['order_id']              =  $s['order_id'];
                    $_sevices[$sid]['service_id']            =  $s['service_id'];
                    $_sevices[$sid]['staff_id']              =  $s['staff_id'];
                    $_sevices[$sid]['start_time']            =  $s['start_time'];
                    $_sevices[$sid]['duration']              =  $s['duration'];
                    $_sevices[$sid]['cost']                  =  $s['cost'];
                    $total  += $s['cost'];
                }


				return array(
					"service_order_serial"	        => 		$siteservice_order['service_order_serial'],
					"user_id"				        => 		$siteservice_order['user_id'],
					"branch_id"    		            => 		$siteservice_order['branch_id'],
					"service_order_type"    		=> 		$siteservice_order['service_order_type'],
					"date"		                    => 		$siteservice_order['date'],
					"total"		                    => 		$total,
					"sevices"		                => 		$_sevices,
					"status"			            => 		$siteservice_order['service_order_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}


	function setservice_orderInformation($service_order)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `service_cart` WHERE `order_id` = '".$service_order['id']."'");
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`service_order_type`      	        =	'".$service_order['type']."',
			`user_id`      	                    =	'".$service_order['user_id']."',
			`branch_id`      	                =	'".$service_order['branch_id']."',
			`service_order_status`		        =	'".$service_order['status']."'
			WHERE `service_order_serial` 		= 	'".$service_order['id']."' LIMIT 1 ");
        foreach($service_order['service_id'] as $k => $p)
        {
            $query = $GLOBALS['db']->query("SELECT * FROM `services`  WHERE `service_serial` = '".$p."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteservice    = $GLOBALS['db']->fetchitem($query);
                $price          = $siteservice['price'] - ($siteservice['price'] *($siteservice['discount']/100));
                $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `service_cart`
                (`cart_serial`, `order_id`, `service_id`, `staff_id`, `start_time`, `duration`, `cost`)
                VALUES ( NULL ,  '".$service_order['id']."' ,'".$p."' , '".$service_order['staff'][$k]."','".$service_order['date'][$k]."','".$siteservice['duration']."','".$price."') ");
            }
        }
		return 1;
	}

	function addNewservice_order($orders)
	{
        $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`service_order_serial`, `user_id`, `branch_id`, `service_order_type`, `date`, `service_order_status`)
		VALUES ( NULL ,  '".$orders[user_id]."' ,'".$orders[branch_id]."' ,'".$orders[type]."' , NOW() ,'".$orders[status]."') ");
        $pid = $GLOBALS['db']->fetchLastInsertId();
        foreach($orders[service_id] as $k => $p)
        {
            $query = $GLOBALS['db']->query("SELECT * FROM `services`  WHERE `service_serial` = '".$p."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteservice    = $GLOBALS['db']->fetchitem($query);
                $price          = $siteservice['price'] - ($siteservice['price'] *($siteservice['discount']/100));
                $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `service_cart`
                (`cart_serial`, `order_id`, `service_id`, `staff_id`, `start_time`, `duration`, `cost`)
                VALUES ( NULL ,  '".$pid."' ,'".$p."' , '".$orders['staff'][$k]."','".$orders['date'][$k]."','".$siteservice['duration']."','".$price."') ");
            }
        }
		return 1;
	}

	function deleteservice_order($service_order_serial)
	{
        $GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `service_cart` WHERE `order_id` = '".$service_order_serial."'");
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `service_order_serial` = '".$service_order_serial."' LIMIT 1");
		return 1;
	}

//	function activestatusservice_order($mservice_order_serial,$status)
//	{
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `service_order_serial` 		 = 	'".$mservice_order_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `service_order_serial` 		 = 	'".$mservice_order_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>
