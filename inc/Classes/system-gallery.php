<?php if(!defined("inside")) exit;
class systemgallery
{
	var $tableName 	= "gallery";

	function getsitegallery($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `gallery_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalgallery($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

//	function getgalleryInformation($gallery_serial)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `gallery_serial` = '".$gallery_serial."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal > 0)
//			{
//				$sitegallery = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"gallery_serial"	    => 		$sitegallery['gallery_serial'],
//					"type"    	         	=> 		$sitegallery['gallery_type'],
//					"link"    	         	=> 		$sitegallery['gallery_link'],
//					"status"			    => 		$sitegallery['gallery_status']
//				);
//			}else{return null;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}
	
//	function isgalleryExists($name)
//	{
//		if($GLOBALS['login']->doCheck() == true)
//		{
//			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `gallery_name` = '".$name."' LIMIT 1 ");
//			$queryTotal = $GLOBALS['db']->resultcount();
//			if($queryTotal == 1)
//			{
//				$sitegallery = $GLOBALS['db']->fetchitem($query);
//				return array(
//					"id"			=> 		$sitegallery['gallery_serial'],
//				);
//			}else{return true;}
//		}else{$GLOBALS['login']->doDestroy();return false;}
//	}

//	function setgalleryInformation($gallery)
//	{
//
//	
//        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`gallery_type`			        =	'".$gallery[name]."',
//			`gallery_type`			        =	'".$gallery[name]."',
//			`gallery_status`		        =	'".$gallery[status]."'
//			WHERE `gallery_serial` 		= 	'".$gallery[id]."' LIMIT 1 ");
//		return 1;
//	}

	function addNewgallery($gallery)
	{
        if($gallery['type'] == 'image')
        {
            $link = $gallery['image'];
        }elseif($gallery['type'] == 'video'){
            $link = $gallery['link'];
        }

		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`gallery_serial`, `gallery_type`, `gallery_link`, `gallery_status`)
		VALUES ( NULL ,'".$gallery['type']."','".$link."','".$gallery['status']."') ");
		return 1;
	}

	function deletegallery($gallery_serial)
	{
        
       $sitegallery = $this->getgalleryInformation($gallery_serial);
        if($sitegallery['type'] == 'image')
        {
            @unlink($path.$sitegallery['link']);
        }
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `gallery_serial` = '".$gallery_serial."' LIMIT 1 ");
		return 1;
	}
	
//	function activestatusgallery($gallery_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `gallery_serial` 		 = 	'".$gallery_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `gallery_serial` 		 = 	'".$gallery_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>