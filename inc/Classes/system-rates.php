<?php if(!defined("inside")) exit;
class systemrates
{
	var $tableName 	= "rates";

	function getsiterates($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `rate_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalrates($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

//	function getratesInformation($rate_serial)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `rate_serial` = '".$rate_serial."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal > 0)
//			{
//				$siterates = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"rate_serial"	    => 		$siterates['rate_serial'],
//					"type"    	         	=> 		$siterates['rate_type'],
//					"link"    	         	=> 		$siterates['rate_link'],
//					"status"			    => 		$siterates['rate_status']
//				);
//			}else{return null;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}
	
//	function isratesExists($name)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `rate_name` = '".$name."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal == 1)
//			{
//				$siterates = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"id"			=> 		$siterates['rate_serial'],
//				);
//			}else{return true;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}

//	function setratesInformation($rates)
//	{
//
//	
//        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`rate_type`			        =	'".$rates[name]."',
//			`rate_type`			        =	'".$rates[name]."',
//			`rate_status`		        =	'".$rates[status]."'
//			WHERE `rate_serial` 		= 	'".$rates[id]."' LIMIT 1 ");
//		return 1;
//	}

//	function addNewrates($rates)
//	{
//        if($rates['type'] == 'image')
//        {
//            $link = $rates['image'];
//        }elseif($rates['type'] == 'video'){
//            $link = $rates['link'];
//        }
//
//		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
//		(`rate_serial`, `rate_type`, `rate_link`, `rate_status`)
//		VALUES ( NULL ,'".$rates['type']."','".$link."','".$rates['status']."') ");
//		return 1;
//	}

	function deleterates($rate_serial)
	{
        
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `rate_serial` = '".$rate_serial."' LIMIT 1 ");
		return 1;
	}
	
//	function activestatusrates($rate_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `rate_serial` 		 = 	'".$rate_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `rate_serial` 		 = 	'".$rate_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>