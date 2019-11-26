<?php if(!defined("inside")) exit;
class systemcategories
{
	var $tableName 	= "product_categories";

	function getsitecategories($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `category_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalcategories($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getcategoriesInformation($category_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `category_serial` = '".$category_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$sitecategory = $GLOBALS['db']->fetchitem($query);
				return array(
					"category_serial"	    => 		$sitecategory['category_serial'],
					"category_name"    		=> 		$sitecategory['category_name'],
					"status"			    => 		$sitecategory['category_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function iscategoriesExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `category_name` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$sitecategory = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$sitecategory['category_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setcategoriesInformation($category)
	{

	
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`category_name`			        =	'".$category[name]."',
			`category_status`		        =	'".$category[status]."'
			WHERE `category_serial` 		= 	'".$category[id]."' LIMIT 1 ");
		return 1;
	}

	function addNewcategories($category)
	{
        
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`category_serial`, `category_name`, `category_status`) 
		VALUES ( NULL ,'".$category[name]."','".$category[status]."') ");
		return 1;
	}

	function deletecategories($category_serial)
	{
        
//       $sitecategory = $this->getcategoryInformation($category_serial);
//        @unlink($path.$sitecategory['image']);
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `category_serial` = '".$category_serial."' LIMIT 1 ");
		return 1;
	}
	
//	function activestatuscategory($category_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `category_serial` 		 = 	'".$category_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `category_serial` 		 = 	'".$category_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>