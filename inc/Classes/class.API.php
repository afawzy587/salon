<?php if(!defined("inside")) exit;

//echo '<meta charset="utf-8">';

class API
{
	var $host = "";
	var $settings = array();
	
/* ----------------------------------------------------------------------------------------*/	
/* Start : Private/Global Functions */
	private function getDefaults($attribute = "unknown")	
	{
		$settings = array(
			"url"			     	    => "http://".$_SERVER['SERVER_NAME']."/salon/",
			"img_url"			        => "http://".$_SERVER['SERVER_NAME']."/salon/uploads/",
			"pagination"				=> 10,
			"salt"					    => "wZy",
			"unknown"					=> "unknown",
			"img-default-avater"        => "uploads/defaults/avater.png",
			"product-default-image"     => "uploads/defaults/product.png",
			"service-default-image"     => "uploads/defaults/service.png",
			"salon-default-image"       => "uploads/defaults/salon.png",
			"gallery-default-image"     => "uploads/defaults/gallery.png",
			"branch-default-image"      => "uploads/defaults/branch.png"
		);
		$this->settings = $settings;
		return ($settings[$attribute]);
	}
	
	private function _serialize($x)
	{
		$array = unserialize($x); 
		if(!is_array($array))
		{
			
			return(array(
				"total" => 0,
				"count" => 0,
			));
		}else{
			return ($array);
		}
	}
	
	private function format_distance ($distance)
    {
        $distance = $distance * 1000;
        if($distance < 1000 )
        {
            $fullDistance = "~ ".ceil($distance). " M";
        }elseif($distance > 1000 )
        {
            $distance = $distance / 1000 ;
            $fullDistance = "~ ".ceil($distance). " Km";
        }
        return ($fullDistance);
        return ($distance);
    }
	
	private function crypto_rand_secure($min, $max)
	{
		$range = $max - $min;
		if ($range < 1) return $min; // not so random...
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}
	
	private function is_timestamp($timestamp)
	{
		// trim the last three zeros if 13.
		if(ctype_digit($timestamp) && strtotime(date('Y-m-d H:i:s',$timestamp)) === (int)$timestamp)
		{
			return true;
		}else
		{
			return false;
		}
	}
	
	private function generateKey($length = 15)
	{
		$token 		= "";
		$key 		= "0123456789";
		$max 		= strlen($key);

		for ($i=0; $i < $length; $i++) {
			$token .= $key[$this->crypto_rand_secure(0, $max-1)];
		}
		return ($token);
	}
	

	private function isValidDate($date, $format= 'Y-m-d')
	{
		if ($date == date($format, strtotime($date)) )
		{
			return $date;	 
		}
	}

/* End : Private/Global Functions */
/* ----------------------------------------------------------------------------------------*/	
/* Start : Collection Functions */
	
	private function addLog ($typeId, $logData, $who, $id, $update = 0)
	{
		$typeId = intval($typeId);
		if($typeId == 0)
		{
			$this->terminate('error','missing type id in log',50);
		}else
		{
			$_logQuery 		= $GLOBALS['db']->query("SELECT * FROM `log_type` WHERE `id` = '".$typeId."' LIMIT 1 ");//$queryLimit
			$_logQueryCount = $GLOBALS['db']->resultcount();
			if($_logQueryCount == 1)
			{
				$_logData 		= $GLOBALS['db']->fetchitem($_logQuery); 

				$logParams = unserialize($_logData['params']);
				
				if(!is_array($logData))
				{
					$this->terminate('error','missing log data in log',50);
				}else
				{
					if( sizeof($logData) != sizeof($logParams) )
					{
						if($update == 1)
						{
//							echo "updating log keys: \n";
//							print_r(array_keys($logData));
							
							$GLOBALS['db']->query("UPDATE `log_type` SET `params`='".serialize(array_keys($logData))."' WHERE `id` = '".$typeId."' LIMIT 1");
							return 1;
						}else
						{
							$this->terminate('error','wrong count( log data : ('.sizeof($logParams).' , '.sizeof($logData).') )  in log',50);
						}
					}else
					{
						foreach($_GET as $pName => $pData)
						{
							$data .= "[ G_".sanitize($pName)." => ".sanitize($pData)."] , ";
						}
						foreach($_POST as $pName => $pData)
						{
							 
							$data .= "[ P_".sanitize($pName)." => ".sanitize($pData)."] , ";
						}
						
						if($who == "")
						{
							$this->terminate('error','missing who in log',50);
						}else
						{
							$userId = intval($id);
							if($userId == 0)
							{
								$this->terminate('error','missing user_id in log',50);
							}else
							{
								$GLOBALS['db']->query("UPDATE `log_type` SET `params`='".serialize(array_keys($logData))."' WHERE `id` = '".$typeId."' LIMIT 1");
								
								$GLOBALS['db']->query( "INSERT INTO `logs` (`id` , `type` ,`who` ,`user_id` ,`time` , `message`, `data`, `periority`) VALUES (NULL , '".$typeId."' , '".$who."' , '".$userId."' , '".time()."' , '', '".$data."', '1' ) " );

								$logId = $GLOBALS['db']->fetchLastInsertId();

								$message = ucfirst($who)." #".$userId." at ( ".date("M j,Y \a\\t h:i A")." ) opened ";
								
								foreach($logParams as $paramId => $param)
								{
									$GLOBALS['db']->query( "INSERT INTO `log_params` (`id` , `log_id` ,`position` , `value`) VALUES (NULL , '".$logId."' , '".$param."' , '".$logData[$param]."' ) " );
									$message .= "[ ".$param." => ".$logData[$param]."] , ";
								}
								$GLOBALS['db']->query("UPDATE `logs` SET `message`='".$message."' WHERE `id` = '".$logId."' AND `type` = '".$typeId."' LIMIT 1");
							}
						}
					}
				}
			}else
			{
				// insert new log id
				if(!is_array($logData))
				{
					$this->terminate('error','missing log data in log',50);
				}else
				{
					if($who == "")
					{
						$this->terminate('error','missing who in log',50);
					}else
					{
						$userId = intval($id);
						if($userId == 0)
						{
							$this->terminate('error','missing user_id in log',50);
						}else
						{
//							echo "adding new log keys:\n";
//							print_r($logData);
							
							$params = array_keys ($logData);
							print_r($params);
							
							
							$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `log_type` (`id` , `type` ,`module` ,`mode` ,`params`) VALUES 
							('".$typeId."' , '".$who."' , '".$logData['module']."' , '".$logData['mode']."' , '".serialize($params)."' ) " );
							exit;
						}
					}
				}
				$this->terminate('error','wrong log id',50);
			}
		}
	}
	private function updateLoginTime($who)
	{
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `users` SET `last_login`= now() WHERE `user_serial` = '".$who."' LIMIT 1");
	}
	private function updateToken($in,$who,$udid)
	{
		if($in == "client")
		{
			$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `tokens` WHERE `user_id` = '".$who."' AND `type` = 'client' AND `udid` = '".($udid)."' ");

			$staticKey = $this->generateKey(20);

			$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `tokens` ( `id` , `token` , `type` , `user_id` , `udid` , `time` ) VALUES ( NULL ,  '".$staticKey."' ,  'client' ,  '".$who."', '".$udid."', '".time()."' ) ");
			return $staticKey;
		}
    }
	
	private function buildMembershipCredintials($credintials="",$token="",$addons = array())
	{
			$userData = array(
				"user_serial"		    =>		intval($credintials["user_serial"]),		
				"user_name"			    =>		$credintials["user_name"],		
				"email"				    =>		$credintials["email"],
				"user_address"			=>		$credintials["user_address"],		
				"phone"			        =>		$credintials["phone"],
				"group_id"				=>		intval($credintials["group_id"]),
				"verified"	            =>		intval($credintials["verified"]),		
				"image"			        =>		($credintials["user_photo"] == "") ? $this->getDefaults("img_url").$this->getDefaults("img-default-image") : $this->getDefaults("img_url").$credintials["user_photo"],	
				"user_status"			=>		intval($credintials["user_status"]),		
				"last_login"			=>		$credintials["last_login"],		
			);
		
		if($token != "")
		{
			$userData["static"] = "".$token."";
		}
		if(is_array($addons) AND !empty($addons))
		{
			foreach($addons as $key => $feature)
			{
				$userData[$key] = "".$feature."";
			}
		}
		return $userData;
	}


/* End : Collection Functions */
/* ----------------------------------------------------------------------------------------*/	
/* start client function */
    
    /************ START authenticat funtion ***/
    public function AddNewuserRegister()
    {
        if(sanitize($_POST['email']) == "")
		{
			$this->terminate('error',$GLOBALS['lang']['INSERT_EMAIL'],204);
		}else
		{
            if( checkMail($_POST['email']) == false)
            {
                $this->terminate('error',$GLOBALS['lang']['INCORRECT_EMAIL'],204);
            }else{
                if(sanitize($_POST['phone']) == "")
                {
                    $this->terminate('error',$GLOBALS['lang']['INSERT_PHONE'],204);
                }else
                {
                    if(checkPhone($_POST['phone']) == false)
                    {
                        $this->terminate('error', $GLOBALS['lang']['INCORRECT_PHONE'],204);
                    }else{
                        if(sanitize($_POST['address']) == "")
                        {
                            $this->terminate('error', $GLOBALS['lang']['INSERT_ADDRESS'],204);
                        }else{
                             if(sanitize($_POST['password']) == "" || strlen($phone) >= 8 )
                            {
                                $this->terminate('error', $GLOBALS['lang']['INSERT_PASSWORD'],204);
                            }else{
                                 
                                $_mail 			= 		sanitize(strtolower($_POST['email']));
                                $_phone		    = 		sanitize($_POST['phone']);
                                $_name 			= 		sanitize($_POST['name']);
                                $_address 	    = 		sanitize($_POST['address']);
                                $_password 		= 		sanitize($_POST['password']);
                                $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `email` = '".($_mail)."' OR `phone` = '".($_phone)."' ");
                                $prevReg = $GLOBALS['db']->resultcount();
                                if($prevReg > 0 )
                                {
                                    $this->terminate('error',$GLOBALS['lang']['PHO_EM_USED'],400);
                                }else
                                {
                                    if($_FILES)
                                    {
                                        if(!empty($_FILES['image']['error']))
                                        {
                                            switch($_FILES['image']['error'])
                                            {
                                                case '1':
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_SIZE_BIG'];
                                                    break;
                                                case '2':
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_SIZE_BIG'];
                                                    break;
                                                case '3':
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_FULL_UP'];
                                                    break;
                                                case '4':
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_SLCT_FILE'];
                                                    break;
                                                case '6':
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_TMP_FLDR'];
                                                    break;
                                                case '7':
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_NOT_UPLODED'];
                                                    break;
                                                case '8':
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_UPLODED_STPD'];
                                                    break;
                                                case '999':
                                                default:
                                                    $errors[image] = $GLOBALS['lang']['UP_ERR_UNKNOWN'];
                                            }
                                        }elseif(empty($_FILES['image']['tmp_name']) || $_FILES['image']['tmp_name'] == 'none')
                                        {
                                            $this->terminate('error',$GLOBALS['lang']['UP_ERR_SLCT_FILE'],209);
                                        }else
                                        {
                                           
                                            include_once("upload.class.php");
                                            $allow_ext = array("jpg","jpeg","gif","png");
                                            $upload    = new Upload($allow_ext,false,0,0,5000,"../uploads/",".","",false);
                                            $files[name] 	= addslashes($_FILES["image"]["name"]);
                                            $files[type] 	= $_FILES["image"]['type'];
                                            $files[size] 	= $_FILES["image"]['size']/1024;
                                            $files[tmp] 	= $_FILES["image"]['tmp_name'];
                                            $files[ext]		= $upload->GetExt($_FILES["image"]["name"]);


                                            $upfile	= $upload->Upload_File($files);

                                            if($upfile)
                                            {
                                                $imgUrl =  $upfile[newname];

                                            }else
                                            {
                                               $this->terminate('error',$GLOBALS['lang']['UP_ERR_NOT_UPLODED'],210);
                                            }

                                            @unlink($_FILES['image']);
                                        }	

                                    $verifiedcode 	= $this->generateKey(5);
                                    $GLOBALS['db']->query
                                    ("
                                        INSERT INTO `users`
                                        (
                                             `user_name`, `email`, `user_address`, `password`, `phone`, `user_photo`, `type`, `group_id`, `last_login`, `verified_code`, `verified`, `user_status`
                                        ) VALUES
                                        (
                                            '".$_name."' ,'".$_mail."','".$_address."' ,'".crypt($_password,$this->getDefaults("salt"))."','".$_phone."','".$imgUrl."','client','1',NOW(),'".$verifiedcode."','0', '1'
                                        )
                                    ");
                                       
                                    $pid = $GLOBALS['db']->fetchLastInsertId();
                                        
                                    if($pid){
                                        
                                        include_once("send_email.php");
                                        
                                        $send    = new sendmail();
                                        
                                        $link    = $this->getDefaults("url").'/api/index.php?mode=active&data='.$verifiedcode.$this->getDefaults("salt");
                                        
                                        $_link   ='link:<a href='.$link.'>'.$GLOBALS['lang']['CLICK_TO_ACTIVE'].'</a>';
                                        
                                        $subject = $GLOBALS['lang']['Salon_verified_email'];
                                        
                                        $done = $send->email($_mail,$_link,$subject);
                                        
                                        if($done == 1)
                                        {
                                            $this->terminate('success',$GLOBALS['lang']['Registeration_Success'] ,201);
                                        }
                                        $this->addLog(1,
                                                array(
                                                    "type" 		=> 	"client",
                                                    "module" 	=> 	"membership",
                                                    "mode" 		=> 	"register_normal",
                                                    "id" 		=>	$pid,
                                                ),"patient",$pid,1
                                            );
                                    }else
                                    {
                                        $this->terminate('error',$GLOBALS['lang']['ERROR_IN_INSERT'] ,400);
                                    }
                                    // send sms with $mobileRandomKey for activation.
                                   
                                        
                                    
                                }
                             }

                        }
                    }
                }
            }
            
            
        }
        
    }
        
    }
    public function checkCredintials()
	{
		$_empho 	= sanitize(strtolower($_POST['empho']));
		$_pass 		= sanitize($_POST['password']);
		$_udid 		= sanitize($_POST['udid']);
		$userLoginQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE ( `email` = '".$_empho."' OR `phone` = '".$_empho."' ) AND `password` = '".crypt($_pass,$this->getDefaults("salt"))."' LIMIT 1");
        $userCount = $GLOBALS['db']->resultcount();
		if($userCount == 1)
		{                
			$userCredintials 		= $GLOBALS['db']->fetchitem($userLoginQuery);
            if($userCredintials['user_status'] != 0)
			{
                if($userCredintials['type'] == "client")
                {
                    if($userCredintials['verified'] == 1)
                    {  
                        $staticKey 				= $this->updateToken("client",$userCredintials['user_serial'],$_udid);
                        $this->updateLoginTime($doctorCredintials['id']);
                        $GLOBALS['db']->query("UPDATE `pushs` SET `out` = '1'  WHERE `type` = 'client' AND `user_id` = '".$userCredintials['user_serial']."' AND `udid` = '".$_udid."' ");
                        $_doctorCredintials 	= $this->buildMembershipCredintials($userCredintials,$staticKey);
                        $this->addLog(2,
                            array(
                                "type" 		=> 	"client",
                                "module" 	=> 	"login",
                                "mode" 		=> 	"login",
                                "id" 		=>	$userCredintials['user_serial'],
                            ),"client",$userCredintials['user_serial'],1
                        );
                        $this->terminate('success',$_doctorCredintials,200);
                    }else{
                        $this->terminate('error', $GLOBALS['lang']['ACCOUT_NOT_VERIFIED'],400);
                    }
                }
            }else{
                $this->terminate('error',$GLOBALS['lang']['ACCOUT_SUSPENDED'],400);
            }
        }else{
			$this->terminate('error',$GLOBALS['lang']['INVALID_DATA'],400);
		}
    }
    public function user_doLogOut()
	{
		$tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
				$_udid 				= sanitize($_POST['udid']);
                $userCredintials 	= $GLOBALS['db']->fetchitem($userQuery);
				$GLOBALS['db']->query("UPDATE LOW_PRIORITY `pushs` SET `out` = '0'  WHERE `type` = 'client' AND `user_id` = '".$userCredintials['user_serial']."' AND `udid` = '".$_udid."' ");
            	
				$this->addLog(3,
					array(
						"type" 		=> 	"client",
						"module" 	=> 	"logout",
						"mode" 		=> 	"logout",
						"id" 		=>	$userCredintials['user_serial'],
					),"client",$userCredintials['user_serial'],1
				);
				$this->terminate('success', $GLOBALS['lang']['logout_success'],200);
			}
        }
	}
    public function user_setAvater()
	{
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
			$_Password = sanitize($_POST['password']);
			if($_Password != "")
			{
				$userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");
				$usersCount = $GLOBALS['db']->resultcount();
				if($usersCount == 1)
				{
					$userCredintials = $GLOBALS['db']->fetchitem($userQuery);
					if( $userCredintials['password']  != crypt($_Password,$this->getDefaults("salt")))
					{
						$this->terminate('error',$GLOBALS['lang']['INVALID_PASSWORD'],400);
					}else
					{	
						if($_FILES)
						{
							if(!empty($_FILES['image']['error']))
							{
								switch($_FILES['image']['error'])
								{
									case '1':
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_SIZE_BIG'];
                                        break;
                                    case '2':
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_SIZE_BIG'];
                                        break;
                                    case '3':
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_FULL_UP'];
                                        break;
                                    case '4':
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_SLCT_FILE'];
                                        break;
                                    case '6':
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_TMP_FLDR'];
                                        break;
                                    case '7':
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_NOT_UPLODED'];
                                        break;
                                    case '8':
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_UPLODED_STPD'];
                                        break;
                                    case '999':
                                    default:
                                        $errors[image] = $GLOBALS['lang']['UP_ERR_UNKNOWN'];
								}
							}elseif(empty($_FILES['image']['tmp_name']) || $_FILES['image']['tmp_name'] == 'none')
							{
								$this->terminate('error',$GLOBALS['lang']['UP_ERR_SLCT_FILE'],209);
							}else
							{
								$disallow_mime = array
								(
									"text/html",
									"text/plain",
									"magnus-internal/shellcgi",
									"application/x-php",
									"text/php",
									"application/x-httpd-php" ,
									"application/php",
									"magnus-internal/shellcgi",
									"text/x-perl",
									"application/x-perl",
									"application/x-exe",
									"application/exe",
									"application/x-java" ,
									"application/java-byte-code",
									"application/x-java-class",
									"application/x-java-vm",
									"application/x-java-bean",
									"application/x-jinit-bean",
									"application/x-jinit-applet",
									"magnus-internal/shellcgi",
									"image/svg",
									"image/svg-xml",
									"image/svg+xml",
									"text/xml-svg",
									"image/vnd.adobe.svg+xml",
									"image/svg-xml",
									"text/xml",
								);
								include_once("upload.class.php");
								$allow_ext = array("jpg","jpeg","gif","png");
								$upload    = new Upload($allow_ext,false,0,0,5000,"../uploads/",".","",false);
								$files[name] 	= addslashes($_FILES["image"]["name"]);
								$files[type] 	= $_FILES["image"]['type'];
								$files[size] 	= $_FILES["image"]['size']/1024;
								$files[tmp] 	= $_FILES["image"]['tmp_name'];
								$files[ext]		= $upload->GetExt($_FILES["image"]["name"]);


								$upfile	= $upload->Upload_File($files);

								if($upfile)
								{
									$imgUrl =  $upfile[newname];

								}else
								{
								   $this->terminate('error',$GLOBALS['lang']['UP_ERR_NOT_UPLODED'],210);
								}

								
							}	

							$userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");
							$userCredintials = $GLOBALS['db']->fetchitem($userQuery);
							if($userCredintials['user_photo'] != "")
							{
								@unlink("../uploads/".$userCredintials['user_photo']);
								$userCredintials['image'] = $imgUrl;
							}

							$GLOBALS['db']->query("UPDATE `users` SET `user_photo`='".$imgUrl."' WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");

							$_userCredintials 	= $this->buildMembershipCredintials($userCredintials,"");
							$this->addLog(4,
								array(
									"type" 		=> 	"client",
									"module" 	=> 	"credintials",
									"mode" 		=> 	"image",
									"image" 	=> 	$imgUrl,
									"id" 		=>	$userCredintials['user_serial'],
								),"client",$userCredintials['user_serial'],1
							);
							$this->terminate('success',$_userCredintials,201);
						}else
						{
							$this->terminate('error',$GLOBALS['lang']['UP_ERR_SLCT_FILE'],400);
						}
					}
				}
			}else{
				$this->terminate('error',$GLOBALS['lang']['INCORRECT_PASS'],400);
			}
        }
	}
    public function user_getCredintials()
	{   
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
				$_userCredintials 	= $this->buildMembershipCredintials($userCredintials,"");
				$this->terminate('success',$_userCredintials,200);
				$this->addLog(5,
					array(
						"type" 		=> 	"client",
						"module" 	=> 	"credintials",
						"mode" 		=> 	"get",
						"id" 		=>	$userCredintials['user_serial'],
					),"client",$userCredintials['user_serial'],1
				);
            }else
            {
                $this->terminate('error', $GLOBALS['lang']['INVALID_USER_LOGIN'],400);
            }
        }
	}
    public function user_edit_profile()
	{   
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                if(sanitize($_POST['email']) == "")
                {
                    $this->terminate('error',$GLOBALS['lang']['INSERT_EMAIL'],204);
                }else
                {
                    if( checkMail($_POST['email']) == false)
                    {
                        $this->terminate('error',$GLOBALS['lang']['INCORRECT_EMAIL'],204);
                    }else{
                        if(sanitize($_POST['phone']) == "")
                        {
                            $this->terminate('error',$GLOBALS['lang']['INSERT_PHONE'],204);
                        }else
                        {
                            if(checkPhone($_POST['phone']) == false)
                            {
                                $this->terminate('error', $GLOBALS['lang']['INCORRECT_PHONE'],204);
                            }else{
                                if(sanitize($_POST['address']) == "")
                                {
                                    $this->terminate('error', $GLOBALS['lang']['INSERT_ADDRESS'],204);
                                }else{
                                    if(sanitize($_POST['password']) == "" || strlen($phone) >= 8 )
                                    {
                                        $this->terminate('error',$GLOBALS['lang']['INSERT_PASSWORD'],204);
                                    }else{
                                        $_mail 			= 		sanitize(strtolower($_POST['email']));
                                        $_phone		    = 		sanitize($_POST['phone']);
                                        $_name 			= 		sanitize($_POST['name']);
                                        $_address 	    = 		sanitize($_POST['address']);
                                        $_pass 	        = 		sanitize($_POST['password']);
                                        if( $userCredintials['password']  != crypt($_pass,$this->getDefaults("salt")))
                                        {
                                            $this->terminate('error', $GLOBALS['lang']['INCORRECT_PASS'] ,400);
                                        }else
                                        {
                                            $GLOBALS['db']->query(" SELECT * FROM `users` WHERE (`email` = '".$_mail."' OR `phone` = '".$_phone."' )AND  `user_serial` != '".$tokenUserId."' ");
                                            $prevReg = $GLOBALS['db']->resultcount();
                                            if($prevReg > 0 )
                                            {
                                                $this->terminate('error',$GLOBALS['lang']['PHO_EM_USED'],400);
                                            }else
                                            {
                                                 if( $userCredintials['phone']  != $_phone)
                                                 {
                                                    $code 	        = $this->generateKey(5);
                                                    $verified_code  = "`verified_code`='".$code."',`verified`='0',"; // send new veried
                                                 }else
                                                 {
                                                     $verified_code  = "";
                                                 }

                                                    $GLOBALS['db']->query(
                                                        "UPDATE `users` SET 
                                                        `user_name`='".$_name."',".$verified_code."
                                                        `email`='".$_mail."',
                                                        `user_address`='".$_address."',
                                                        `phone`='".$_phone."'
                                                        WHERE `user_serial`='".$tokenUserId."'
                                                    ");
                                                
                                                    $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");
                                                    $_user = $GLOBALS['db']->fetchitem($userQuery);
                                                    $_userCredintials 	= $this->buildMembershipCredintials($_user,"");
                                                    $this->terminate('success',$_userCredintials,200);
                                                    $this->addLog(5,
                                                        array(
                                                            "type" 		=> 	"client",
                                                            "module" 	=> 	"credintials",
                                                            "mode" 		=> 	"get",
                                                            "id" 		=>	$userCredintials['user_serial'],
                                                        ),"client",$userCredintials['user_serial'],1
                                                    );

                                            }
                                        }
                                     }

                                }
                            }
                        }
                    }
                }
				
            }else
            {
                $this->terminate('error',$GLOBALS['lang']['INVALID_USER_LOGIN'],400);
            }
        }
	}
    public function user_activemail()
	{   
        if($_GET)
        {
            $data      = sanitize($_GET['data']);
            if($data == "")
            {
                $this->terminate('error', $GLOBALS['lang']['NO_DATA'],400);
            }else{
                $_data = str_replace($this->getDefaults("salt"),"",$data);
                
                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `verified_code` = '".$_data."'  LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                if($usersCount == 1)
                {
                    $userCredintials    = $GLOBALS['db']->fetchitem($userQuery);
                    
                    $GLOBALS['db']->query(
                        "UPDATE `users` SET 
                        `verified_code`='0',
                        `verified`='1'
                        WHERE `user_serial`='".$userCredintials['user_serial']."'
                    ");
                    
                    $this->terminate('success',$GLOBALS['lang']['email_activated'],200);
                    $this->addLog(5,
                        array(
                            "type" 		=> 	"client",
                            "module" 	=> 	"active",
                            "mode" 		=> 	"get",
                            "id" 		=>	$userCredintials['user_serial'],
                        ),"client",$userCredintials['user_serial'],1
                    );
                }else
                {
                    $this->terminate('error', $GLOBALS['lang']['INVALID_LINK'],400);
                }
            }
            
        }
	}
    public function user_recovery_pass()
	{   
        if($_POST)
        {
            $_mail      = sanitize($_POST['email']);
            if($_mail == "")
            {
                $this->terminate('error', $GLOBALS['lang']['INSERT_EMAIL'],400);
            }else{
                
                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `email` = '".$_mail."'  LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                if($usersCount == 1)
                {
                    $userCredintials    = $GLOBALS['db']->fetchitem($userQuery);
                        if($userCredintials['recovery_code'] != 0 && (strtotime($userCredintials['recovery_expired']) > time()))
                        {
                            $this->terminate('error', $GLOBALS['lang']['WE_SEND_EMAIL_BEFORE'],400);
                        }else{
                            $recovery_code    	= $this->generateKey(5);

                            $expired_date   = date('Y-m-d H:i:s', strtotime('+1 day', time()));

                            $GLOBALS['db']->query(
                                "UPDATE `users` SET 
                                `recovery_code`    ='".$recovery_code."',
                                `recovery_expired` ='".$expired_date."'
                                WHERE `user_serial`='".$userCredintials['user_serial']."'
                            ");


                            include_once("send_email.php");
                            $send = new sendmail();

                            $link  = $this->getDefaults("url").'/api/index.php?mode=active&data='.$recovery_code.$this->getDefaults("salt");

                            $_link ='link:<a href='.$link.'>'.$GLOBALS['lang']['CLICK_TO_ACTIVE'].'</a>';

                            $subject = $GLOBALS['lang']['Salon_RECOVERY_PASS'];

                            $done = $send->email($_mail,$_link,$subject);

                            if($done == 1)
                            {
                                $this->terminate('success',$GLOBALS['lang']['SEND_RECOVERY_PASS'],200);
                            }

                            $this->addLog(9,
                                array(
                                    "type" 		=> 	"client",
                                    "module" 	=> 	"recovery_pass",
                                    "mode" 		=> 	"get",
                                    "id" 		=>	$userCredintials['user_serial'],
                                ),"client",$userCredintials['user_serial'],1
                            );
                        }
                }else
                {
                    $this->terminate('error', $GLOBALS['lang']['INVALID_LINK'],400);
                }
            }
            
        }
	}
    
    /*******  باقى لينك الاكتف وفورجت باسورد   */
    /************ END authenticat funtion ***/
    
    
    
    /* START CLIENT APP FUNCTION ***/
    public function client_get_salon()
    {
        $id = intval($_GET['id']);
        if($id != 0)
        {
            $addquery = "AND s.`salon_serial` = '".$id."' LIMIT 1";
        }else{
            $addquery = "ORDER BY `salon_serial` DESC";
        }
        
        $salonQuery = $GLOBALS['db']->query("SELECT s.* , u.user_name FROM `salons` s INNER JOIN `users` u ON s.`owner_id` = u.`user_serial`  WHERE s.`salon_status` = '1'".$addquery);
        $salonCount = $GLOBALS['db']->resultcount();
        $_salonCredintials =[];
        if($salonCount != 0)
        {
            $salonCredintials = $GLOBALS['db']->fetchlist();
            
            foreach($salonCredintials as $sId => $s)
            {
                $_salonCredintials[$sId]['salon_serial']        =       intval($s['salon_serial']); 
                $_salonCredintials[$sId]['salon_name']          =       $s['salon_name']; 
                $_salonCredintials[$sId]['owner']               =       $s['user_name']; 
                $_salonCredintials[$sId]['logo']                =       ($s["salon_photo"] == "") ? $this->getDefaults("img_url").$this->getDefaults("salon-default-image") : $this->getDefaults("img_url").$s["salon_photo"];	 
            }
            
            $this->terminate('success',$_salonCredintials,200);
           
        }else
        {
            $this->terminate('success',$_salonCredintials,200);
        }
    }
    
    public function client_get_salon_branch()
    {
        $id = intval($_GET['salon_id']);
        if($id != 0)
        {
            $salonQuery = $GLOBALS['db']->query("SELECT DISTINCT  * FROM `salons` WHERE `salon_status` = '1' AND  `salon_serial`= '".$id."' LIMIT 1");
            $salonCount = $GLOBALS['db']->resultcount();
            $salonCredintials = $GLOBALS['db']->fetchitem();
            if($salonCount != 0)
            {
                $branchQuery = $GLOBALS['db']->query("SELECT DISTINCT b.* , s.user_name FROM `salon_branches` b INNER JOIN `users` s ON b.`manager_id` = s.`user_serial` WHERE b.`branch_status` = '1' AND  b.`salon_id`= '".$id."'");
                $branchCount = $GLOBALS['db']->resultcount();
                $_branchCredintials =[];
                if($branchCount != 0)
                {
                    $branchCredintials = $GLOBALS['db']->fetchlist();
                    foreach($branchCredintials as $sId => $s)
                    {
                        $_branchCredintials[$sId]['branch_serial']        =       intval($s['branch_serial']); 
                        $_branchCredintials[$sId]['salon_name']           =       $salonCredintials['salon_name']; 
                        $_branchCredintials[$sId]['branch_name']          =       $s['branch_name']; 
                        $_branchCredintials[$sId]['manger']               =       $s['user_name']; 
                        $_branchCredintials[$sId]['logo']                 =       ($s["photo"] == "") ? $this->getDefaults("img_url").$this->getDefaults("branch-default-image") : $this->getDefaults("img_url").$s["photo"];
                        $_branchCredintials[$sId]['address']              =       $s['address']; 
                        $_branchCredintials[$sId]['branch_sat']           =       intval($s['branch_sat']); 
                        $_branchCredintials[$sId]['branch_sun']           =       intval($s['branch_sun']); 
                        $_branchCredintials[$sId]['branch_mon']           =       intval($s['branch_mon']); 
                        $_branchCredintials[$sId]['branch_tus']           =       intval($s['branch_tus']); 
                        $_branchCredintials[$sId]['branch_wed']           =       intval($s['branch_wed']); 
                        $_branchCredintials[$sId]['branch_thurs']         =       intval($s['branch_thurs']); 
                        $_branchCredintials[$sId]['branch_fri']           =       intval($s['branch_fri']);
                        $_branchCredintials[$sId]['branch_from']          =       date('g:i A', strtotime($s['branch_from'])); 
                        $_branchCredintials[$sId]['branch_to']            =       date('g:i A', strtotime($s['branch_to']));
                        $_branchCredintials[$sId]['branch_status']        =       intval($s['branch_status']); 
                    } 
                    $this->terminate('success',$_branchCredintials,200);
                }else{
                    $this->terminate('error',$GLOBALS['lang']['NO_BRANCH_TO_THIS_SALON'],400);
                    
                }
                
            }else
            {
                $this->terminate('error',$GLOBALS['lang']['NOT_FOUND_SALON_ID'],400);
            }
        }else{
            $this->terminate('error',$GLOBALS['lang']['INSERT_SALON_ID'],400);
        }
    }
    
    public function client_get_services_branch()
    {
        $id = intval($_GET['branch_id']);
        if($id != 0)
        {
            $branchQuery       = $GLOBALS['db']->query("SELECT DISTINCT  * FROM `salon_branches` WHERE `branch_status` = '1' AND  `branch_serial`= '".$id."' LIMIT 1");
            $branchCount       = $GLOBALS['db']->resultcount();
            $branchCredintials = $GLOBALS['db']->fetchitem();
            if($branchCount != 0)
            {
                $branchQuery = $GLOBALS['db']->query("
                SELECT DISTINCT s.*  
                FROM `branche_serivces` bs INNER JOIN `salon_branches` b ON bs.`branch_id` = b.`branch_serial`
                INNER JOIN `services` s ON bs.`service_id` = s.`service_serial`
                WHERE s.`service_status` = '1' AND  bs.`branch_id`= '".$id."'");
                $servicesCount = $GLOBALS['db']->resultcount();
                $_services =[];
                if($servicesCount != 0)
                {
                    $services = $GLOBALS['db']->fetchlist();
                    foreach($services as $sId => $s)
                    {
                        $_services[$sId]['service_serial']        =       intval($s['service_serial']); 
                        $_services[$sId]['service_name']          =       $s['service_name']; 
                        $_services[$sId]['price']                 =       floatval($s['price']); 
                        $_services[$sId]['discount']              =       floatval($s['discount']); 
                        $_services[$sId]['duration']              =       intval($s['duration']); 
                        $_services[$sId]['logo']                  =       ($s["service_photo"] == "") ? $this->getDefaults("img_url").$this->getDefaults("service-default-image") : $this->getDefaults("img_url").$s["service_photo"];
                        $_services[$sId]['service_status']        =       $s['service_status']; 
                        
                    } 
                    $this->terminate('success',$_services,200);
                }else{
                    $this->terminate('error',$GLOBALS['lang']['NO_service_TO_THIS_SALON'],400);
                    
                }
                
            }else
            {
                $this->terminate('error',$GLOBALS['lang']['NOT_FOUND_BRANCHE_ID'],400);
            }
        }else{
            $this->terminate('error',$GLOBALS['lang']['INSERT_BRANCHE_ID'],400);
        }
    }
    
    public function client_get_products()
    {
        
        $start 				= ( intval($_GET['p']) == 0)? 0 : intval($_GET['p']);
        $queryLimit 		= " LIMIT ".($start * $this->getDefaults("pagination")) ." , ". $this->getDefaults("pagination");
        $id = intval($_GET['id']);
        if($id != 0)
        {
            $addquery = "AND p.`product_serial` = '".$id."' LIMIT 1";
        }else{
            $addquery = "ORDER BY p.`product_serial` DESC".$queryLimit;
        }
        
        $productQuery = $GLOBALS['db']->query("SELECT p.* , c.`category_name` FROM `products` p INNER JOIN `product_categories` c ON p.`category_id` = c.`category_serial`  WHERE p.`product_status` = '1'".$addquery);
        $productCount = $GLOBALS['db']->resultcount();
        $_productCredintials =[];
        if($productCount != 0)
        {
            $productCredintials = $GLOBALS['db']->fetchlist();
            
            foreach($productCredintials as $pId => $p)
            {
                $_productCredintials[$pId]['product_serial']        =       intval($p['product_serial']); 
                $_productCredintials[$pId]['product_name']          =       $p['product_name']; 
                $_productCredintials[$pId]['caegory']               =       $p['category_name']; 
                $_productCredintials[$pId]['description']           =       $p['product_description']; 
                $_productCredintials[$pId]['price']                 =       floatval($p['product_price']); 
                $_productCredintials[$pId]['discount']              =       intval($p['product_discount']); 
                $_productCredintials[$pId]['discount_from']         =       $p['product_from']; 
                $_productCredintials[$pId]['discount_to']           =       $p['product_to']; 
                $_productCredintials[$pId]['image']                 =       ($p["product_photo"] == "") ? $this->getDefaults("img_url").$this->getDefaults("product-default-image") : $this->getDefaults("img_url").$p["product_photo"];	 
            }
            
            $this->terminate('success',$_productCredintials,200);
           
        }else
        {
            $this->terminate('success',$_productCredintials,200);
        }
    }
    
    public function client_get_gallery()
    {
        
        $start 				= ( intval($_GET['p']) == 0)? 0 : intval($_GET['p']);
        $queryLimit 		= " LIMIT ".($start * $this->getDefaults("pagination")) ." , ". $this->getDefaults("pagination");
    
        $type = sanitize($_GET['type']);
        if($type != "")
        {
            $addquery = "AND `gallery_type` = '".$type."' LIMIT 1";
        }else{
            $addquery = "ORDER BY `gallery_serial` DESC".$queryLimit;
        }
        
        $galleryQuery = $GLOBALS['db']->query("SELECT * FROM `gallery`  WHERE `gallery_status` = '1'".$addquery);
        $galleryCount = $GLOBALS['db']->resultcount();
        $_galleryCredintials =[];
        if($galleryCount != 0)
        {
            $galleryCredintials = $GLOBALS['db']->fetchlist();
            
            foreach($galleryCredintials as $gId => $g)
            {
                $_galleryCredintials[$gId]['gallery_serial']        =       intval($g['gallery_serial']); 
                $_galleryCredintials[$gId]['gallery_type']          =       $g['gallery_type']; 
                $_galleryCredintials[$gId]['link']                  =       ($g['gallery_type'] == 'image')?($g["gallery_photo"] == "") ? $this->getDefaults("img_url").$this->getDefaults("gallery-default-image") : $this->getDefaults("img_url").$g["gallery_link"] : $g['gallery_link'];	 
            }
            
            $this->terminate('success',$_galleryCredintials,200);
           
        }else
        {
            $this->terminate('success',$_galleryCredintials,200);
        }
    }
    
	
/* end client function */        
/* ----------------------------------------------------------------------------------------*/	
	private function testToken()
	{
        $staticToken = sanitize($_POST['token']);
        $udid = sanitize($_POST['udid']);
        if($staticToken == "" )
		{
			$this->terminate('error','unknown token parameters (POST:static or POST:udid )',3);
		}else
		{
			// `type` = 'patient' AND
            $tokenQuery = $GLOBALS['db']->query(" SELECT * FROM `tokens` WHERE `token` = '".$staticToken."' AND `udid` = '".$udid."' LIMIT 1");
            $tokenValidity = $GLOBALS['db']->resultcount();
            if( $tokenValidity == 1 )
			{
                $tokenData = $GLOBALS['db']->fetchitem($tokenQuery);
                $tokenUserId = $tokenData['user_id'];
                $tokenType = $tokenData['type'];
                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `user_serial` = '".$tokenUserId."' LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                if($usersCount == 1)
                {
                    $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                    $status = $userCredintials['user_status'];
                    if($status == 0)
                    {
                        $this->terminate('error',$GLOBALS['lang']['ACCOUT_SUSPENDED'],6);
                    }else
                    {
                        $verified = $userCredintials['verified'];
                        if($verified == 0)
                        {
                            $this->terminate('error','this account isn\'t verified',6);
                        }else
                        {
                            return ($tokenUserId);
                        }
                    }
                }else
                {
                    $this->terminate('error','This account has been deleted from our systems',6);
                }
            }else
            {
                $this->terminate('error','invalid token',5);
            }
        }
	}
	public function authenticat()
	{
		$staticToken = sanitize($_POST['token']);
        $udid = sanitize($_POST['udid']);
        if($staticToken == "")
		{
			$this->terminate('error','token parameter not found',1);
		}else
		{
			$tokenQuery = $GLOBALS['db']->query(" SELECT * FROM `tokens` WHERE `token` = '".$staticToken."' AND `udid` = '".$udid."' LIMIT 1");
			$validToken = $GLOBALS['db']->resultcount();
			if( $validToken == 1 )
			{
				$tokenData = $GLOBALS['db']->fetchitem($tokenQuery);
				return $tokenData['type'];
			}else
			{
				$this->terminate('error','invalid token',2);
			}
		}
	}
    public function terminate($title='success',$data=null,$status=200)
    {
        if(is_array($data)){
            $message  = $data;
            
        }else{
            $message  = ['massage'=>$data];
        }
        $response=[
            "title"  => $title == 'success'?"success":"error",
            "data"   => $message,
            "status" => in_array($status,$this->statuscode())?true :false
        ];
        die(json_encode($response));
    }
    public function statuscode()
    {
        return array(200,201,202);
    }
    public function send_sms($phone,$message)
    {
        $phone      = str_replace("+20","0",$phone);
        $message    = str_replace(" ","+",$message);
        $DelayUntil =date('Y-m-d H-m');
        try
        {
            $ch = curl_init();
            // Check if initialization had gone wrong*
            if ($ch === false) {
                throw new Exception('failed to initialize');
            }
//            $url =https://smsmisr.com/api/webapi/?username=sMBu5ifW&password=fjXSOxum61&language=3&sender=creative&Mobile=2
            curl_setopt($ch, CURLOPT_URL,$url.$phone.",&message=".$message);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
            //    curl_setopt(/* ... */);
            $content = curl_exec($ch);
            //		var_dump($content) ;
            // Check the return value of curl_exec(), too
            if ($content === false) {
                return 2;
            }else{
                return 1;
            }
            /* Process $content here */
            // Close curl handle
            curl_close($ch);
        }
        catch(Exception $e)
        {
            trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
        }
    }    
}


?>
