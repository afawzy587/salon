<?php if(!defined("inside")) exit;
class systemsalons
{
	var $tableName 	= "salons";

	function getsitesalons($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `salon_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalsalons($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getsalonsInformation($salon_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT s.* , u.user_name FROM `".$this->tableName."` s INNER JOIN `users` u ON s.`owner_id` = u.`user_serial`  WHERE s.`salon_serial` = '".$salon_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$sitesalons = $GLOBALS['db']->fetchitem($query);
				return array(
					"salon_serial"	        => 		$sitesalons['salon_serial'],
					"salon_name"			=> 		$sitesalons['salon_name'],
					"owner_id"    		    => 		$sitesalons['owner_id'],
					"image"      		    => 		$sitesalons['salon_photo'],
					"owner"	         	    => 		$sitesalons['user_name'],
					"status"			    => 		$sitesalons['salon_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function issalonsExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `salon_name` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$sitesalons = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$sitesalons['salon_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setsalonsInformation($salons)
	{
		if($salons[image] != "")
		{
			$queryimage = "`salon_photo`='".$salons[image]."',";
		}else
		{
			$queryimage = "";
		}
	
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`salon_name`			    =	'".$salons[name]."',".$queryimage."
			`owner_id`      	        =	'".$salons[owner_id]."',
			`salon_status`		        =	'".$salons[status]."'
			WHERE `salon_serial` 		= 	'".$salons[id]."' LIMIT 1 ");
		return 1;
	}

	function addNewsalons($salons)
	{
        
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`salon_serial`, `salon_name`, `owner_id`, `salon_photo`, `salon_status`)
		VALUES ( NULL ,  '".$salons[name]."' ,'".$salons[owner_id]."' , '".$salons[image]."' ,'".$salons[status]."') ");
		return 1;
	}

	function deletesalons($salon_serial,$path)
	{
        
        $site = $this->getsalonInformation($salon_serial);
        @unlink($path.$site['image']);
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `salon_serial` = '".$salon_serial."' LIMIT 1 ");
		return 1;
	}
	
//	function activestatussalons($salon_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `salon_serial` 		 = 	'".$salon_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `salon_serial` 		 = 	'".$salon_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>