<?php if(!defined("inside")) exit;
class systemproducts
{
	var $tableName 	= "products";

	function getsiteproducts($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `product_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function getTotalproducts($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function getcategoryproducts($addon = "" , $cat_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT p.*, c.`category_serial`  FROM `".$this->tableName."` p INNER JOIN `product_categories` c ON p.`category_id` = c.`category_serial` WHERE p.`category_id` ='".$cat_id."' ORDER BY s.`product_serial` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    
    function getTotalcategoryproducts($cat_id)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` p INNER JOIN `product_categories` c ON p.`category_id` = c.`category_serial` WHERE p.`category_id` ='".$cat_id."' ORDER BY s.`product_serial` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getproductsInformation($product_serial)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `product_serial` = '".$product_serial."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$siteproducts = $GLOBALS['db']->fetchitem($query);
				return array(
					"product_serial"	    => 		$siteproducts['product_serial'],
					"product_name"			=> 		$siteproducts['product_name'],
					"price"    		        => 		$siteproducts['product_price'],
					"description"      		=> 		$siteproducts['product_description'],
					"category_id"	        => 		$siteproducts['category_id'],
					"discount"	            => 		$siteproducts['product_discount'],
					"from"	                => 		$siteproducts['product_from'],
					"to"	                => 		$siteproducts['product_to'],
					"image"      	        => 		$siteproducts['product_photo'],
					"status"			    => 		$siteproducts['product_status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function isproductsExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `product_name` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$siteproducts = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$siteproducts['product_serial'],
				);
			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function setproductsInformation($products)
	{
		if($products[image] != "")
		{
			$queryimage = "`product_photo`='".$products[image]."',";
		}else
		{
			$queryimage = "";
		}
	
        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`product_name`			    =	'".$products[name]."',".$queryimage."
			`product_price`      	    =	'".$products[price]."',
			`product_description`      	=	'".$products[description]."',
			`category_id`      	        =	'".$products[category_id]."',
			`product_discount`          =	'".$products[discount]."',
			`product_from`      	    =	'".$products[from]."',
			`product_to`      	        =	'".$products[to]."',
			`product_status`		    =	'".$products[status]."'
			WHERE `product_serial` 		= 	'".$products[id]."' LIMIT 1 ");
		return 1;
	}

	function addNewproducts($products)
	{
        
		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`product_serial`, `product_name`, `product_photo`, `product_price`, `product_description`, `category_id`, `product_discount`, `product_from`, `product_to`, `product_status`)
		VALUES ( NULL ,  '".$products[name]."' ,'".$products[image]."' ,'".$products[price]."' ,'".$products[description]."' , '".$products[category_id]."' ,'".$products[discount]."','".$products[from]."','".$products[to]."','".$products[status]."') ");
		return 1;
	}

	function deleteproducts($product_serial,$path)
	{
        $site = $this->getproductsInformation($product_serial);
        @unlink($path.$site['image']);
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `product_serial` = '".$product_serial."' LIMIT 1 ");
		return 1;
	}
    

	function delete_order_product($product_serial)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `order_cart` WHERE `order_cart_serial` = '".$product_serial."' LIMIT 1 ");
		return 1;
	}

   
	
//	function activestatusproducts($product_serial,$status)
//	{  
//		if($status==1)
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//			`status`    =	'0'
//			 WHERE `product_serial` 		 = 	'".$product_serial."' LIMIT 1 ");
//			return 1;
//		}else
//		{
//			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
//				`status`    =	'1'
//			 	WHERE `product_serial` 		 = 	'".$product_serial."' LIMIT 1 ");
//			return 1;
//		}
//	}

}
?>
