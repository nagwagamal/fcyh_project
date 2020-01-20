<?php
error_reporting(0);
$dbserver   = "172.17.0.5";
$dbName     = "sfa";
$dbuser     = "root";
$dbpassword = "e9548dc7a0a6a30c";

$db = new DB($dbuser,$dbpassword,$dbName,$dbserver);

$frontUrl 		= $host.$mainFolder;
$adminUrl 		= $host.$mainFolder.$adminFolder;
// -------------------PATH-FOR-IMAGE-------------------//
$uploadimg     = "uploads/";
$path_img      = "";
$Currancy      = "جنيه مصري";


?>
