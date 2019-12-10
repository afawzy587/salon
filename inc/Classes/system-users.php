<?php if(!defined("inside")) exit;
class systemUsers
{
	var $tableName 	= "users";

	function getsiteUsers($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `user_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalUsers($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getUsersInformation($user_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT u.* , g.group_name FROM `".$this->tableName."` u INNER JOIN `user_groups` g ON u.`group_id` = g.`group_serial`  WHERE u.`user_serial` = '".$user_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteUsers = $GLOBALS['db']->fetchitem($query);
				return array(
					"user_serial"	        => 		$siteUsers['user_serial'],
					"user_name"				=> 		$siteUsers['user_name'],
					"address"    		    => 		$siteUsers['user_address'],
					"phone"		            => 		$siteUsers['phone'],
					"image"      		    => 		$siteUsers['user_photo'],
					"group_id"	         	=> 		$siteUsers['group_id'],
					"group"	         	    => 		$siteUsers['group_name'],
					"type"	         	    => 		$siteUsers['type'],
					"last_login"		    => 		$siteUsers['last_login'],
					"email"		            => 		$siteUsers['email'],
					"status"			    => 		$siteUsers['user_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function isUsersExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `user_name` = '".$name."' ||`phone` = '".$name."' || `email` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$siteUsers = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$siteUsers['user_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setUsersInformation($Users)
	{
		if($Users[password] != "")
		{
			$queryPass = "`password`='".crypt($Users[password],$GLOBALS['login']->salt)."',";
		}else
		{
			$queryPass = "";
		}
		
		if($Users[image] != "")
		{
			$queryimage = "`user_photo`='".$Users[image]."',";
		}else
		{
			$queryimage = "";
		}
	
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`user_name`			        =	'".$Users['name']."',".$queryPass."
			`user_address`              =	'".$Users['address']."',".$queryimage."
			`email`      	            =	'".$Users['email']."',
			`phone`      	            =	'".$Users['phone']."',
			`type`      	            =	'".$Users['type']."',
			`group_id`      	        =	'".$Users['group']."',
			`user_status`		        =	'".$Users['status']."'
			WHERE `user_serial` 		= 	'".$Users['id']."' LIMIT 1 ");
		return 1;
	}

	function addNewUsers($Users)
	{
		if($Users[password] != "")
		{
			 $Users[password] = crypt($Users[password],$GLOBALS['login']->salt);
		}
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`user_serial`, `user_name`, `email`, `user_address`, `password`, `phone`, `type`, `user_photo`, `group_id`,`user_status`,`verified`)
		VALUES ( NULL ,  '".$Users['name']."' ,'".$Users['email']."' , '".$Users['address']."' ,'".$Users['password']."' ,'".$Users['phone']."' ,'".$Users['type']."' ,'".$Users['image']."' ,'".$Users['group']."','".$Users['status']."',1) ");
		return 1;
	}

	function deleteUsers($user_serial,$path)
	{
//        $site = $this->getstaffInformation($user_serial);
//        @unlink($path.$site['image']);
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `user_serial` = '".$user_serial."' LIMIT 1 ");
		return 1;
	}
	
	function activestatusUsers($muser_serial,$status)
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
