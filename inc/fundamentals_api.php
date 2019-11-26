<?php if(!defined("inside")) exit;
	error_reporting (E_ALL ^ E_NOTICE);
	include("../inc/Classes/database.class.php");
	include("../inc/Classes/class.API.php");
	include("../inc/config.php");
	include("../assets/assets.php");
	include("../inc/Classes/login.class.php");
    ######### Language files #########
    include("../assets/Languages/lang.php");
    $api = new API();
?>