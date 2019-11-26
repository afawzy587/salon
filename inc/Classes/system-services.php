<?php if(!defined("inside")) exit;
class systemservices
{
	var $tableName 	= "services";

	function getsiteservices($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `service_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function getTotalservices($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function getbranchservices($addon = "" , $branch_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT s.*, b.`branche_serivce_serial`  FROM `".$this->tableName."` s INNER JOIN `branche_serivces` b ON s.`service_serial` = b.`service_id` WHERE B.`branch_id` ='".$branch_id."' ORDER BY s.`service_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function getTotalbranchservices($branch_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` s INNER JOIN `branche_serivces` b ON s.`service_serial` = b.`service_id` WHERE B.`branch_id` ='".$branch_id."' ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getservicesInformation($service_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `service_serial` = '".$service_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteservices = $GLOBALS['db']->fetchitem($query);
				return array(
					"service_serial"	    => 		$siteservices['service_serial'],
					"service_name"			=> 		$siteservices['service_name'],
					"price"    		        => 		$siteservices['price'],
					"discount"      		=> 		$siteservices['discount'],
					"duration"	         	=> 		$siteservices['duration'],
					"image"      	        => 		$siteservices['service_photo'],
					"status"			    => 		$siteservices['service_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function isservicesExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `service_name` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$siteservices = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$siteservices['service_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setservicesInformation($services)
	{
		if($services[image] != "")
		{
			$queryimage = "`service_photo`='".$services[image]."',";
		}else
		{
			$queryimage = "";
		}
	
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`service_name`			    =	'".$services[name]."',".$queryimage."
			`price`      	            =	'".$services[price]."',
			`discount`      	        =	'".$services[discount]."',
			`duration`      	        =	'".$services[duration]."',
			`service_status`		    =	'".$services[status]."'
			WHERE `service_serial` 		= 	'".$services[id]."' LIMIT 1 ");
		return 1;
	}

	function addNewservices($services)
	{
        
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`service_serial`, `service_name`, `price`, `discount`, `duration`, `service_photo`, `service_status`) 
		VALUES ( NULL ,  '".$services[name]."' ,'".$services[price]."' ,'".$services[discount]."' ,'".$services[duration]."' , '".$services[image]."' ,'".$services[status]."') ");
		return 1;
	}

	function deleteservices($service_serial,$path)
	{
        $site = $this->getservicesInformation($service_serial);
        @unlink($path.$site['image']);
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `service_serial` = '".$service_serial."' LIMIT 1 ");
		return 1;
	}
    
    function deletebranchservices($service_serial)
    {
        $GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `branche_serivces` WHERE `branche_serivce_serial` = '".$service_serial."' LIMIT 1 ");
		return 1;
	}
    
    function getsitebranchserives($id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `service_serial` NOT IN (SELECT `service_id` FROM `branche_serivces` WHERE `branch_id` = '".$id."' ) ORDER BY `service_serial` DESC ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function isbranchservicesExists($bid,$sid)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `branche_serivces` WHERE `branch_id` = '".$bid."' AND `service_id` = '".$sid."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$siteservices = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$siteservices['branche_serivce_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function addNewbranceservices($services)
	{
        
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `branche_serivces`
		(`branche_serivce_serial`, `branch_id`, `service_id`)
		VALUES ( NULL ,  '".$services[branch_id]."' ,'".$services[service_id]."')");
		return 1;
	}
	
//	function activestatusservices($service_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `service_serial` 		 = 	'".$service_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `service_serial` 		 = 	'".$service_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>