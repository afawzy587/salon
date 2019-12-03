<?php if(!defined("inside")) exit;
class systembranches
{
	var $tableName 	= "salon_branches";

	function getsitebranches($addon = "" , $salon_id =0)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
            if($salon_id == 0)
            {
                $query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `branch_serial` DESC ".$addon);
            }else{
                $query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `salon_id` = '".$salon_id."' ORDER BY `branch_serial` DESC ".$addon);
            }
			
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalbranches($salon_id = 0)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
            if($salon_id == 0)
            {
			     $query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
            }else{
                 $query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` WHERE `salon_id` = '".$salon_id."' ");
            }
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getbranchesInformation($branch_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."`  WHERE `branch_serial` = '".$branch_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$sitebranches = $GLOBALS['db']->fetchitem($query);
				return array(
					"branch_serial"	        => 		$sitebranches['branch_serial'],
					"branch_name"			=> 		$sitebranches['branch_name'],
					"address"    		    => 		$sitebranches['address'],
					"manager_id"      		=> 		$sitebranches['manager_id'],
					"image"	         	    => 		$sitebranches['photo'],
					"SAT"	                => 		$sitebranches['branch_sat'],
					"SUN"	                => 		$sitebranches['branch_sun'],
					"MON"	                => 		$sitebranches['branch_mon'],
					"TUE"	                => 		$sitebranches['branch_tus'],
					"WED"	                => 		$sitebranches['branch_wed'],
					"THU"	                => 		$sitebranches['branch_thurs'],
					"FRI"	                => 		$sitebranches['branch_fri'],
					"branch_from"	        => 		date('g:i A', strtotime($sitebranches['branch_from'])),
					"branch_to"	         	=> 		date('g:i A', strtotime($sitebranches['branch_to'])),
					"status"			    => 		$sitebranches['branch_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function isbranchesExists($name , $id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `branch_name` = '".$name."' AND `salon_id` = '".$id."'  LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$sitebranches = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$sitebranches['branch_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setbranchesInformation($branches)
	{
		if($branches[image] != "")
		{
			$queryimage = "`photo`='".$branches[image]."',";
		}else
		{
			$queryimage = "";
		}
         $from = date('H:i', (strtotime($branches["branch_from"])));
         $to   = date('H:i', (strtotime($branches["branch_to"])));

  
	
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`branch_name`			    =	'".$branches[name]."',".$queryimage."
			`address`      	            =	'".$branches[address]."',
			`manager_id`      	        =	'".$branches[manager_id]."',
			`branch_sat`      	        =	'".$branches[SAT]."',
			`branch_sun`      	        =	'".$branches[SUN]."',
			`branch_mon`      	        =	'".$branches[MON]."',
			`branch_tus`      	        =	'".$branches[TUE]."',
			`branch_wed`      	        =	'".$branches[WED]."',
			`branch_thurs`      	    =	'".$branches[THU]."',
			`branch_fri`      	        =	'".$branches[FRI]."',
			`branch_from`      	        =	'".$from."',
			`branch_to`      	        =	'".$to."',
			`branch_status`		        =	'".$branches[status]."'
			WHERE `branch_serial` 		= 	'".$branches[id]."' LIMIT 1 ");
		return 1;
	}

	function addNewbranches($branches)
	{
         $from = date('H:i', (strtotime($branches["branch_from"])));
         $to   = date('H:i', (strtotime($branches["branch_to"])));
		
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`branch_serial`, `branch_name`, `address`,  `manager_id`, `photo`, `branch_sat`, `branch_sun`, `branch_mon`, `branch_tus`, `branch_wed`, `branch_thurs`, `branch_fri`, `branch_from`, `branch_to`, `branch_status`)
		VALUES ( NULL ,  '".$branches[name]."' ,'".$branches[address]."' ,'".$branches[manager_id]."' , '".$branches[image]."' ,'".$branches[SAT]."' ,'".$branches[SUN]."','".$branches[MON]."' ,'".$branches[TUE]."' ,'".$branches[WED]."' ,'".$branches[THU]."' ,'".$branches[FRI]."' ,'".$from."' ,'".$to."' ,'".$branches[branch_status]."')");
		return 1;
	}

	function deletebranches($branch_serial,$path)
	{
        $site = $this->getbranchesInformation($branch_serial);
        @unlink($path.$site['image']);
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `branch_serial` = '".$branch_serial."' LIMIT 1 ");
		return 1;
	}
	
//	function activestatusbranches($branch_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `branch_serial` 		 = 	'".$branch_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `branch_serial` 		 = 	'".$branch_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>
