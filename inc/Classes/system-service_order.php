<?php if(!defined("inside")) exit;
class systemservice_order
{
	var $tableName 	= "service_order";

	function getsiteservice_order($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `serice_order_serial` DESC ".$addon);
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
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `user_id` ='".$user_id."' ORDER BY `serice_order_serial` DESC ".$addon);
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

	function getservice_orderInformation($serice_order_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."`  WHERE `serice_order_serial` = '".$serice_order_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteservice_order     = $GLOBALS['db']->fetchitem($query);
                $sevicequery   = $GLOBALS['db']->query("SELECT * FROM `service_cart` WHERE `order_id` = '".$serice_order_serial."' ");
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
					"serice_order_serial"	        => 		$siteservice_order['serice_order_serial'],
					"user_id"				        => 		$siteservice_order['user_id'],
					"branch_id"    		            => 		$siteservice_order['branch_id'],
					"serice_order_type"    		    => 		$siteservice_order['serice_order_type'],
					"date"		                    => 		$siteservice_order['date'],
					"total"		                    => 		$total,
					"sevices"		                => 		$_sevices,
					"status"			            => 		$siteservice_order['serice_order_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

//	function isservice_orderExists($name)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `user_name` = '".$name."' ||`phone` = '".$name."' || `email` = '".$name."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal == 1)
//			{
//				$siteservice_order = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"id"			=> 		$siteservice_order['serice_order_serial'],
//				);
//			}else{return true;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}

	function setservice_orderInformation($service_order)
	{
		if($service_order[password] != "")
		{
			$queryPass = "`password`='".crypt($service_order[password],$GLOBALS['login']->salt)."',";
		}else
		{
			$queryPass = "";
		}

		if($service_order[image] != "")
		{
			$queryimage = "`user_photo`='".$service_order[image]."',";
		}else
		{
			$queryimage = "";
		}

        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`user_name`			        =	'".$service_order[name]."',".$queryPass."
			`user_address`              =	'".$service_order[address]."',".$queryimage."
			`email`      	            =	'".$service_order[email]."',
			`phone`      	            =	'".$service_order[phone]."',
			`group_id`      	        =	'".$service_order[group]."',
			`user_status`		        =	'".$service_order[status]."'
			WHERE `serice_order_serial` 		= 	'".$service_order[id]."' LIMIT 1 ");
		return 1;
	}

	function addNewservice_order($service_order)
	{
		if($service_order[password] != "")
		{
			 $service_order[password] = crypt($service_order[password],$GLOBALS['login']->salt);
		}
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`serice_order_serial`, `user_name`, `email`, `user_address`, `password`, `phone`, `user_photo`, `group_id`,`user_status`)
		VALUES ( NULL ,  '".$service_order[name]."' ,'".$service_order[email]."' , '".$service_order[address]."' ,'".$service_order[password]."' ,'".$service_order[phone]."' ,'".$service_order[image]."' ,'".$service_order[group]."','".$service_order[status]."'  ) ");
		return 1;
	}

	function deleteservice_order($serice_order_serial,$path)
	{

		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `serice_order_serial` = '".$serice_order_serial."' LIMIT 1");
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `order_cart` WHERE `order_id` = '".$serice_order_serial."'");
		return 1;
	}

//	function activestatusservice_order($mserice_order_serial,$status)
//	{
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `serice_order_serial` 		 = 	'".$mserice_order_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `serice_order_serial` 		 = 	'".$mserice_order_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>
