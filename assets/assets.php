<?php
 

	######### Main Security Basic Filter Function ;) #########
	function sanitize( $str , $type = "str" )
	{
		$str = strip_tags ($str);
		$str = trim ($str);
		$str = htmlspecialchars ($str, ENT_NOQUOTES);
		$str = addslashes ($str);
		if($type == "area")
		$str = str_replace("\n","<br />",$str);
		return $str;
	}
    ######### Swapping textarea Content #########
    function br2nl($str)
	{
	    $str = str_replace("<br />","\n",$str);
	    return $str;
	}
	######### Valid Email Check #########
	function checkMail($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
	}
    ////////// Valid phone check ///////////////
    function checkPhone($phone)
    {
        $phone  = str_replace("+2","",$phone);
        if(strlen($phone) == 11 || !is_numeric($phone))
        {
            $sub = substr($phone,0,3);
            $ext = ['010','011','012','015'];
            return ( ! in_array($sub,$ext) ? false : true);
        }elseif(strlen($phone) == 10 || !is_numeric($phone)){
            $pattern = "/^0[1-9]{1}[0-9]{8}$/";
            return ( !preg_match($pattern, $number) ? false : true);
        }else{
            return false;
        }
        
        
    }

    ///############# Send notification ##################//
    function send_notification($message, $user_id)
    {
        $query      =  $GLOBALS['db']->query("SELECT * FROM `pushs` WHERE `user_id` ='".$user_id."' and `out` = '0'");
        $queryTotal =  $GLOBALS['db']->resultcount();
        $siteuser   =  $GLOBALS['db']->fetchlist();
        foreach ($siteuser as $k=>$p)
        {
            $push_id    =  $p['pushid'];
            $key        =  "AAAADBwqIHs:APA91bE1pmbqVLfXKtEtGAbSf4W3G7wjr3oO5GI9Q8stBDOmSamMZCaiYBU1G2jENYLAcbkK4WhG9FGES7pADo4QpxaOxWIRQEBcRpnpSIXBlcNo4Dmwh9xm5KMzQoBN8-XoZkKVjB3P";
            $fields = array
            (

                    'to'		      => $push_id,
                    'data'            => array
                    (
                        "title"=> "Salon",
                        "body" => $message, //$message
                        "icon" => "logo"
                    ),
            );
            $headers = array (
                    'Authorization: key='.$key,
                    'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
        }

    }

    function get_user_id($data)
    {
        $_data     =      explode("|",$data);
        $table     =      $_data[0];
        $where     =      $_data[1];
        $s_col     =      $_data[2];
        $id        =      $_data[3];
        $status    =      $_data[4];

        $query = $GLOBALS['db']->query("SELECT * FROM `".$table."`  WHERE `".$where."` ='".$id."' LIMIT 1 ");
        $queryTotal = $GLOBALS['db']->resultcount();
        $siteuser   = $GLOBALS['db']->fetchitem($query);
        return $siteuser['user_id'];
    }

    function _date_format ($date)
	{
	    return  date('Y-m-d / g:i A', strtotime($date));
	}

    function end_time ($start,$end)
	{
	    return  date('Y-m-d H:m:s', (strtotime($date)+($end*60)));
	}

    function time_format ($time)
	{
	    return  date('g:i A', strtotime($time));
	}

	function array_length ($array)
	{
	    return  count($array);
	}
	
	function getFromTable($params, &$smarty)
	{
		$attId   		= $params['a'];
		$tableName   	= $params['b'];
		$functionName   = $params['c'];
		$attName   		= $params['d'];
		require_once('./inc/Classes/system-'.$tableName.'.php');

		eval("\$class = new system".ucfirst($tableName)."();");

		$returnedData = $class->$functionName($attId);

		return ($returnedData[$attName]);
	}

    function getFromInternalTable($a, $b, $c, $d)
	{
		$attId   		= $a;
		$tableName   	= $b;
		$functionName   = $c;
		$attName   		= $d;

		require_once('./inc/Classes/system-'.$tableName.'.php');

		eval("\$class = new system".ucfirst($tableName)."();");

		$returnedData = $class->$functionName($attId);

		if($returnedData[$attName] != "")
        return ($returnedData[$attName]);
        return "";
	}
    
    function replacestring($num){
	     $num =	  str_replace("] , [","]<br>[",$num);
		  return "$num";
	  }

	function getusername($_Id)
	{

		$user = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$_Id."' LIMIT 1");
		$userCount = $GLOBALS['db']->resultcount();
		if($userCount == 1)
		{
			$_user = $GLOBALS['db']->fetchitem($user);
			return ($_user['user_name']);
		}
		else
		{
			return ($GLOBALS['lang']['DELETED']);
		}
	}

	function getsalonname($_Id)
	{

		$salon = $GLOBALS['db']->query(" SELECT * FROM `salons` WHERE `salon_serial` = '".$_Id."' LIMIT 1");
		$salonCount = $GLOBALS['db']->resultcount();
		if($salonCount == 1)
		{
			$_salon = $GLOBALS['db']->fetchitem($salon);
			return ($_salon['salon_name']);
		}
		else
		{
			return ($GLOBALS['lang']['DELETED']);
		}
	}

    function getbranchname($_Id)
	{

		$branch = $GLOBALS['db']->query(" SELECT `branch_name` FROM `salon_branches`  WHERE `branch_serial` = '".$_Id."' LIMIT 1");
		$branchCount = $GLOBALS['db']->resultcount();
		if($branchCount == 1)
		{
			$_branch = $GLOBALS['db']->fetchitem($branch);
			return($_branch['branch_name']);
		}
		else
		{
			return ($GLOBALS['lang']['DELETED']);
		}
	}

    function getcategoryname($_Id)
	{

		$cat = $GLOBALS['db']->query(" SELECT * FROM `product_categories` WHERE `category_serial` = '".$_Id."' LIMIT 1");
		$catCount = $GLOBALS['db']->resultcount();
		if($catCount == 1)
		{
			$_cat = $GLOBALS['db']->fetchitem($cat);
			return $_cat['category_name'];
		}
		else
		{
			return ($GLOBALS['lang']['DELETED']);
		}
	}

    function getproductname($_Id)
	{

		$pro = $GLOBALS['db']->query(" SELECT * FROM `products` WHERE `product_serial` = '".$_Id."' LIMIT 1");
		$proCount = $GLOBALS['db']->resultcount();
		if($proCount == 1)
		{
			$_pro = $GLOBALS['db']->fetchitem($pro);
			return ($_pro['product_name']);
		}
		else
		{
			return ($GLOBALS['lang']['DELETED']);
		}
	}

    function getservicename($_Id)
	{

		$serviceq = $GLOBALS['db']->query(" SELECT * FROM `services` WHERE `service_serial` = '".$_Id."' LIMIT 1");
		$serviceCount = $GLOBALS['db']->resultcount();
		if($serviceCount == 1)
		{
			$service = $GLOBALS['db']->fetchitem($serviceq);
			return ($service['service_name']);
		}
		else
		{
			return ($GLOBALS['lang']['DELETED']);
		}
	}

    function getstaffname($_Id)
	{

		$staffq = $GLOBALS['db']->query(" SELECT * FROM `branche_staff` WHERE `staff_serial` = '".$_Id."' LIMIT 1");
		$staffCount = $GLOBALS['db']->resultcount();
		if($staffCount == 1)
		{
			$staff = $GLOBALS['db']->fetchitem($staffq);
			return ($staff['staff_name']);
		}
		else
		{
			return ($GLOBALS['lang']['DELETED']);
		}
	}
    function getlog_type($_Id)
    {

        $product = $GLOBALS['db']->query(" SELECT * FROM `log_type` WHERE `id` = '".$_Id."' LIMIT 1");
        $productCount = $GLOBALS['db']->resultcount();
        if($productCount == 1)
        {
            $_product = $GLOBALS['db']->fetchitem($product);
            return ("<b>".$_product['module']."</b>");
        }else
        {
            return ($GLOBALS['lang']['DELETED']);
        }
    }

    function status($table,$where,$status,$id,$svalue)
    {
        $message ="<td id=td_".$id.">
                <span id='".$table."|".$where."|".$status."|".$id."|".$svalue."'>";
                if($svalue == 0){
                    $message .='<a class="btn btn-danger btn-sm status_active" style="color:white;border-radius:12px;"   title="'.$GLOBALS['lang']['activtion'].'">'.$GLOBALS['lang']['deactive'].'</a></span></td>';
                }else{
                    $message .='<a class="btn btn-success btn-sm status_active" style="color:white;border-radius:12px;"   title="'.$GLOBALS['lang']['deactivtion'].'">'.$GLOBALS['lang']['active'].'</a></span>
                                </td>';
                }

        echo $message;
    }

    function call_phone($mobile)
    {
        echo "<a dir='ltr' href='tel:".$mobile."'>".$mobile."</a>";
    }

    function updatebestseller($id)
    {
        $productquery   = $GLOBALS['db']->query("SELECT  `product_id`, `quantity` FROM `order_cart` WHERE `order_id` = '".$id."'");
        $productTotal   = $GLOBALS['db']->resultcount();
        $products       = $GLOBALS['db']->fetchlist();
        foreach($products as $pid => $p)
        {
            $sellerquery      = $GLOBALS['db']->query("SELECT  * FROM `best_sellers` WHERE `product_id` = '".$p['product_id']."' LIMIT 1");
            $sellerTotal     = $GLOBALS['db']->resultcount();
            if($sellerTotal == 1)
            {
                $seller      = $GLOBALS['db']->fetchitem($sellerquery);
                $quntity     = $p['quantity'] + $seller['quantity'] ;
                $GLOBALS['db']->query("UPDATE LOW_PRIORITY `best_sellers` SET `quantity`='".$quntity."' WHERE `best_seller_serial` = '".$seller['best_seller_serial']."' AND `product_id` = '".$p['product_id']."'  LIMIT 1");
            }else{
                $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `best_sellers`
                (`best_seller_serial`, `product_id`, `quantity`) VALUES
                (NULL,'".$p['product_id']."','".$p['quantity']."')");
            }
        }
    }










	

?>
