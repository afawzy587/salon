<?php
error_reporting(0);

$dbserver   = "localhost";
$dbName     = "salon";
$dbuser     = "root";
$dbpassword = "";

 $db = new DB($dbuser,$dbpassword,$dbName,$dbserver);

 $frontUrl 		= $host.$mainFolder;
 $adminUrl 		= $host.$mainFolder.$adminFolder;



?>
