<?php if(!defined("inside")) exit;
class systemGroups
{
	var $tableName 	= "user_groups";

	function getsiteGroups($addon = "")
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

	function getTotalGroups($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getGroupsInformation($muser_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT u.* , g.group_name FROM `".$this->tableName."` u INNER JOIN `user_groups` g ON u.`group_id` = g.`group_serial`  WHERE u.`user_serial` = '".$muser_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteGroups = $GLOBALS['db']->fetchitem($query);
				return array(
					"user_serial"	        => 		$siteGroups['user_serial'],
					"user_name"				=> 		$siteGroups['user_name'],
					"address"    		    => 		$siteGroups['user_address'],
					"phone"		            => 		$siteGroups['phone'],
					"photo"      		    => 		$siteGroups['user_photo'],
					"group"	         	    => 		$siteGroups['group_name'],
					"last_login"		    => 		$siteGroups['last_login'],
					"email"		            => 		$siteGroups['email'],
					"status"			    => 		$siteGroups['status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function isGroupsExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `name` = '".$name."' || `email` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$siteGroups = $GLOBALS['db']->fetchitem($query);
				return array(
					"user_serial"			=> 		$siteGroups['user_serial'],
				);


			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setGroupsInformation($Groups)
	{
		
		if($Groups[password] != "")
		{
			$queryPass = "`password`='".(md5($GLOBALS['login']->salt.$Groups[password].$GLOBALS['login']->salt))."',";
		}else
		{
			$queryPass = "";
		}
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`name`			=	'".$Groups[name]."',".$queryPass."
			`email`      	=	'".$Groups[email]."',
			`status`		=	'".$Groups[status]."'
			WHERE `user_serial` 		= 	'".$Groups[user_serial]."' LIMIT 1 ");
		return 1;
	}

	function addNewGroups($Groups)
	{
		if($Groups[password] != "")
		{
			 $Groups[password] = md5($GLOBALS['login']->salt.$Staffs[password].$GLOBALS['login']->salt);
		}else
		{
			$Groups[password] = "";
		}
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		( `user_serial` , `name` , `password` , `email`   , `status`  ) 
		VALUES ( NULL ,  '".$Groups[name]."' ,'".$Groups[password]."' , '".$Groups[email]."' , '1'  ) ");
		return 1;
	}

	function deleteGroups($muser_serial)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `user_serial` = '".$muser_serial."' LIMIT 1 ");
		return 1;
	}
	
	function activestatusGroups($muser_serial,$status)
	{  
		if($status==1)
		{
			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`status`    =	'0'
			 WHERE `user_serial` 		 = 	'".$muser_serial."' LIMIT 1 ");
			return 1;
		}else
		{
			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
				`status`    =	'1'
			 	WHERE `user_serial` 		 = 	'".$muser_serial."' LIMIT 1 ");
			return 1;
		}
	}

}
?>