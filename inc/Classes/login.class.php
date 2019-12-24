<?php if(!defined("inside")) exit;

class loginClass
{
 var $name;
 var $email;
 var $password;
 var $remember;
 var $id;
 var $prefix 		= "Salon";
 var $tableName 	= "users";
 var $salt 			= "$1$\wZY";
 var $hours 		= 10;

 function doLogin($email,$pass,$remember)
 {
 	if($email !=""  || $pass != "")
 	{
 		if($this->isLogged() == false){
	 		global $db;
			
		 	$query = $db->query("SELECT * FROM `".$this->tableName."` WHERE `type` ='user' AND `email`='".$email."' AND `password`='".crypt($pass,$this->salt)."'");
	 		 $queryTotal = $db->resultcount();
		    if($queryTotal == 1)
		    {
				$userData = $db->fetchitem($query);
				if($remember == 1){$this->hours = 4;}
				$this->setName($userData['user_name']);
				$this->setEmail($userData['email']);
	 			$this->setPassword($userData['password']);
	 			$this->setUserId($userData['user_serial']);
				return 1;
		    }else{return 2;}
	 	}else{return 3;}
 	}else{return 0;}
 }
	
function doRegister($user)
 {
		if($this->isLogged() == false)
		{ 
			$query 		= $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `email`='".$user['email']."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				return 4;
			}
			else
			{	
				$query = $GLOBALS['db']->query("INSERT INTO `".$this->tableName."`(`id`, `name`, `email`,`password`, `status`) VALUES
				(NULL , '".$user['name']."', '".$user['email']."' , '".crypt($user['password'],$this->salt)."' , 1 )");
				$userId 		= $GLOBALS['db']->fetchLastInsertId();
				if($userId != 0)
				{
					return 1;

				}else
				{
					return 2;
				}
			}
		}else
		{
			return 3;
		}
 }
	


 function doLogout()
 {
 	if($this->isLogged() == true)
 	{
 		// query and get data from db
 		$this->doDestroy();
 		return  true;
 	}else{return false;}
 }

 function doDestroy()
 {
 	// query and get data from db
 	$this->doDestroyName();
 	$this->doDestroyEmail();
 	$this->doDestroyPassword();
 	$this->doDestroyUserId();
 }


 function doCheck()
 {
 	if($this->isLogged() == true)
 	{
 		global $db;
	  	$email = $this->getEmail();
	 	$pass  = $this->getPassword();
	 	$id    = $this->getUserId();

		$query = $db->query("SELECT * FROM `".$this->tableName."` WHERE `email`='$email' AND `password`='$pass' AND `user_serial`='$id' ");
 		$queryTotal = $db->resultcount();
	    if($queryTotal == 1)
	    {
			return true;
	    }else{$this->doDestroy();return false;}
 	}else{$this->doDestroy();return false;}
 }
	
	

 function getUserInformation()
 {
 	if($this->isLogged() == true)
 	{
 		global $db;
	 	$email = $this->getEmail();
	 	$pass  = $this->getPassword();
	 	$id    = $this->getUserId();
	 	$query = $db->query("SELECT * FROM `".$this->tableName."` WHERE `email`='$email' AND `password`='$pass' AND `user_serial`='$id' LIMIT 1 ");
 		$queryTotal = $db->resultcount();
	    if($queryTotal == 1)
	    {
	    	$userInformation = $db->fetchitem($query);
			return array(
                "user_name"				=> 		$userInformation['user_name'],
                "address"    		    => 		$userInformation['user_address'],
                "phone"		            => 		$userInformation['phone'],
                "image"      		    => 		$userInformation['user_photo'],
                "email"		            => 		$userInformation['email'],
			);
	    }else{$this->doDestroy();return false;}
 	}else{$this->doDestroy();return false;}
 }


 function setInformation($userInformation)
 {
 	if($this->isLogged() == true)
 	{
 		global $db;
        $userInformation['id'] = $this->getUserId();
	 	if($userInformation['password'] != "")
	 	{
	 		$queryGlue = "`password`='".crypt($userInformation['password'],$this->salt)."',";
	 		$this->setPassword($userInformation['password']);
	 	}else
	 	{
	 		$queryGlue = "";
	 	}
        if($userInformation['image'] != "")
		{
			$queryimage = "`user_photo`='".$userInformation['image']."',";
		}else
		{
			$queryimage = "";
		}
	 	$this->setName($userInformation['name']);
		$this->setEmail($userInformation['email']);

	 	$db->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
	 	`user_name`       =  '".$userInformation['name']."',".$queryimage."
	 	`email`           =  '".$userInformation['email']."',".$queryGlue."
	 	`user_address`    =  '".$userInformation['address']."',
	 	`phone`           =  '".$userInformation['phone']."'
	 	WHERE `user_serial`='".$userInformation['id']."' LIMIT 1 ");

	 	return 1;
 	}else{$this->doDestroy();return false;}
 }


 function isLogged()
 {
    $email = $this->getEmail();
 	if(isset($email) && $email !=""){return true;}else{return false;}
 }

 function getName()
 {
 	$this->name = $_COOKIE[$this->prefix."name"];

    if($this->name !=""){return ($this->name);}else{return false;}
 }

 function setName($name)
 {
	if($name != "")
	{
	    if(@setcookie($this->prefix."name",$name,time()+($this->hours*3600))){return ($this->hours);}else{return false;}
 	}else{return false;}
 }

 function doDestroyName()
 {
 	if(@setcookie($this->prefix."name",$name,time()-($this->hours*3600))){return true;}else{return false;}
 }


 function getEmail()
 {
 	$this->email = $_COOKIE[$this->prefix."email"];
    if($this->email !=""){return ($this->email);}else{return false;}
 }

 function setEmail($name)
 {
	if($name != "")
	{
	    if(@setcookie($this->prefix."email",$name,time()+($this->hours*3600))){return ($this->hours);}else{return false;}
 	}else{return false;}
 }

 function doDestroyEmail()
 {
 	if(@setcookie($this->prefix."email",$name,time()-($this->hours*3600))){return true;}else{return false;}
 }

 function getPassword()
 {
 	$this->password = $_COOKIE[$this->prefix."password"];
    if($this->password !=""){return ($this->password);}else{return false;}
 }

 function setPassword($pass)
 {
	if($pass != "")
	{
	    if(@setcookie($this->prefix."password",$pass,time()+($this->hours*3600))){return true;}else{return false;}
 	}else{return false;}
 }
 function doDestroyPassword()
 {
 	if(@setcookie($this->prefix."password",$pass,time()-($this->hours*3600))){return true;}else{return false;}
 }

 function getUserId()
 {
    $this->id = $_COOKIE[$this->prefix."id"];
    if($this->id !=""){return ($this->id);}else{return false;}
 }

 function setUserId($id)
 {
	if($id != "" && is_numeric($id))
	{
	    if(@setcookie($this->prefix."id",$id,time()+($this->hours*3600))){return true;}else{return false;}
 	}else{return false;}
 }

 function doDestroyUserId()
 {
 	if(@setcookie($this->prefix."id",$id,time()-($this->hours*3600))){return true;}else{return false;}
 }

}



?>
