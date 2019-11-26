<?php if(!defined("inside")) exit;
class systemstaff
{
	var $tableName 	= "branche_staff";

	function getsitestaff($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `staff_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalstaff($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getstaffInformation($staff_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `staff_serial` = '".$staff_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$sitestaff = $GLOBALS['db']->fetchitem($query);
				return array(
					"staff_serial"	        => 		$sitestaff['staff_serial'],
					"branch_id"		    	=> 		$sitestaff['branch_id'],
					"staff_name"    		=> 		$sitestaff['staff_name'],
					"image"      		    => 		$sitestaff['staff_photo'],
					"sat"	         	    => 		$sitestaff['staff_sat'],
					"sat_from"	            => 		$sitestaff['staff_sat_from'],
					"sat_to"	            => 		$sitestaff['staff_sat_to'],
                    "sun"	         	    => 		$sitestaff['staff_sun'],
					"sun_from"	            => 		$sitestaff['staff_sun_from'],
					"sun_to"	            => 		$sitestaff['staff_sun_to'],
                    "mon"	         	    => 		$sitestaff['staff_mon'],
					"mon_from"	            => 		$sitestaff['staff_mon_from'],
					"mon_to"	            => 		$sitestaff['staff_mon_to'],
                    "tus"	         	    => 		$sitestaff['staff_tus'],
					"tus_from"	            => 		$sitestaff['staff_tus_from'],
					"tus_to"	            => 		$sitestaff['staff_tus_to'],
                    "wed"	         	    => 		$sitestaff['staff_wed'],
					"wed_from"	            => 		$sitestaff['staff_wed_from'],
					"wed_to"	            => 		$sitestaff['staff_wed_to'],
                    "thurs"	                => 		$sitestaff['staff_thurs'],
					"thurs_from"	        => 		$sitestaff['staff_thurs_from'],
					"thurs_to"	            => 		$sitestaff['staff_thurs_to'],
                    "fri"	         	    => 		$sitestaff['staff_fri'],
					"fri_from"	            => 		$sitestaff['staff_fri_from'],
					"fri_to"	            => 		$sitestaff['staff_fri_to'],
					"status"			    => 		$sitestaff['staff_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function isstaffExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `staff_name` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$sitestaff = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$sitestaff['staff_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setstaffInformation($staff)
	{
		if($staff[image] != "")
		{
			$queryimage = "`staff_photo`='".$staff[image]."',";
		}else
		{
			$queryimage = "";
		}
	
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`staff_name`			    =	'".$staff[name]."',".$queryimage."
			`branch_id`      	        =	'".$staff[branch_id]."',
			`staff_sat`		            =	'".$staff[sat]."',
			`staff_sat_from`		    =	'".$staff[sat_from]."',
			`staff_sat_to`		        =	'".$staff[sat_to]."',
            `staff_sun`		            =	'".$staff[sun]."',
			`staff_sun_from`		    =	'".$staff[sun_from]."',
			`staff_sun_to`		        =	'".$staff[sun_to]."',
            `staff_mon`		            =	'".$staff[mon]."',
			`staff_mon_from`		    =	'".$staff[mon_from]."',
			`staff_mon_to`		        =	'".$staff[mon_to]."',
            `staff_tus`		            =	'".$staff[tus]."',
			`staff_tus_from`		    =	'".$staff[tus_from]."',
			`staff_tus_to`		        =	'".$staff[tus_to]."',
            `staff_wed`		            =	'".$staff[wed]."',
			`staff_wed_from`		    =	'".$staff[wed_from]."',
			`staff_wed_to`		        =	'".$staff[wed_to]."',
            `staff_thurs`		        =	'".$staff[thurs]."',
			`staff_thurs_from`		    =	'".$staff[thurs_from]."',
			`staff_thurs_to`		    =	'".$staff[thurs_to]."',
            `staff_fri`		            =	'".$staff[fri]."',
			`staff_fri_from`		    =	'".$staff[fri_from]."',
			`staff_fri_to`		        =	'".$staff[fri_to]."',
			`staff_status`		        =	'".$staff[status]."'
			WHERE `staff_serial` 		= 	'".$staff[id]."' LIMIT 1 ");
		return 1;
	}

	function addNewstaff($staff)
	{
        
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`staff_serial`, `branch_id`, `staff_name`, `staff_photo`, `staff_sat`, `staff_sat_from`, `staff_sat_to`, `staff_sun`, `staff_sun_from`, `staff_sun_to`, `staff_mon`, `staff_mon_from`, `staff_mon_to`, `staff_tus`, `staff_tus_from`, `staff_tus_to`, `staff_wed`, `staff_wed_from`, `staff_wed_to`, `staff_thurs`, `staff_thurs_from`, `staff_thurs_to`, `staff_fri`, `staff_fri_from`, `staff_fri_to`, `staff_status`)
		VALUES ( NULL ,  '".$staff[branch_id]."',  '".$staff[name]."' ,'".$staff[image]."' ,'".$staff[sat]."','".$staff[sat_from]."','".$staff[sat_to]."','".$staff[sun]."','".$staff[sun_from]."','".$staff[sun_to]."','".$staff[mon]."','".$staff[mon_from]."','".$staff[mon_to]."','".$staff[tus]."','".$staff[tus_from]."','".$staff[tus_to]."','".$staff[wed]."','".$staff[wed_from]."','".$staff[wed_to]."','".$staff[thurs]."','".$staff[thurs_from]."','".$staff[thurs_to]."','".$staff[fri]."','".$staff[fri_from]."','".$staff[fri_to]."','".$staff[status]."') ");
		return 1;
	}

	function deletestaff($staff_serial,$path)
	{
        
       $sitestaff = $this->getstaffInformation($staff_serial);
        @unlink($path.$sitestaff['image']);
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `staff_serial` = '".$staff_serial."' LIMIT 1 ");
		return 1;
	}
	
//	function activestatusstaff($staff_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `staff_serial` 		 = 	'".$staff_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `staff_serial` 		 = 	'".$staff_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>