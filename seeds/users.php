<?php 
   // output buffer..
	ob_start("ob_gzhandler");
    // my system key cheker..
    define("inside",true);
	// get funcamental file which contain config and template files,settings.
	include("../inc/fundamentals.php");

    include '../assets/layout/header.php';
    include("../inc/Classes/system-users.php");
	$Users = new systemUsers();
    for($i=33; $i < 66 ;$i++ )
    {
        $_user['name']       =       "Icouna".$i;
        $_user['phone']      =       "011497468".$i;
        $_user['email']      =       "fawzy".$i."@gmail.com";
        $_user['address']    =       $i."st Zahra";
        $_user['password']   =       "wZxE8666/VO2w";
        $_user['image']      =       "dd72efa83c.jpg";
        $_user['group']      =       1;
        $_user['status']     =       1;
        $Users->addNewUsers($_user);
    }





?>     
