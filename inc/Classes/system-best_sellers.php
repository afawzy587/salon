<?php if(!defined("inside")) exit;
class systembest_sellers
{
	var $tableName 	= "best_sellers";

	function getsitebest_sellers($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `best_seller_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalbest_sellers($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

//	function getbest_sellersInformation($best_seller_serial)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `best_seller_serial` = '".$best_seller_serial."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal > 0)
//			{
//				$sitebest_sellers = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"best_seller_serial"	    => 		$sitebest_sellers['best_seller_serial'],
//					"type"    	         	=> 		$sitebest_sellers['rate_type'],
//					"link"    	         	=> 		$sitebest_sellers['rate_link'],
//					"status"			    => 		$sitebest_sellers['rate_status']
//				);
//			}else{return null;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}

//	function isbest_sellersExists($name)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `rate_name` = '".$name."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal == 1)
//			{
//				$sitebest_sellers = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"id"			=> 		$sitebest_sellers['best_seller_serial'],
//				);
//			}else{return true;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}

//	function setbest_sellersInformation($best_sellers)
//	{
//
//
//        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`rate_type`			        =	'".$best_sellers[name]."',
//			`rate_type`			        =	'".$best_sellers[name]."',
//			`rate_status`		        =	'".$best_sellers[status]."'
//			WHERE `best_seller_serial` 		= 	'".$best_sellers[id]."' LIMIT 1 ");
//		return 1;
//	}

//	function addNewbest_sellers($best_sellers)
//	{
//        if($best_sellers['type'] == 'image')
//        {
//            $link = $best_sellers['image'];
//        }elseif($best_sellers['type'] == 'video'){
//            $link = $best_sellers['link'];
//        }
//
//		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
//		(`best_seller_serial`, `rate_type`, `rate_link`, `rate_status`)
//		VALUES ( NULL ,'".$best_sellers['type']."','".$link."','".$best_sellers['status']."') ");
//		return 1;
//	}

//	function deletebest_sellers($best_seller_serial)
//	{
//
//		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `best_seller_serial` = '".$best_seller_serial."' LIMIT 1 ");
//		return 1;
//	}

//	function activestatusbest_sellers($best_seller_serial,$status)
//	{
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `best_seller_serial` 		 = 	'".$best_seller_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `best_seller_serial` 		 = 	'".$best_seller_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>
