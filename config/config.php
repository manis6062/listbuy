<?php
	session_start();
	###########  SETTING COMMON VARIABLES
	define("CURRENT_DATE", date('Y-m-d'));
	
	define("IP_ADDRESS", $_SERVER['REMOTE_ADDR']);
	
	define("PHP_SELF", $_SERVER["PHP_SELF"]);
	
	define("QUESY_STRING", $_SERVER["QUERY_STRING"]);
	
	//THIS IS THE ENTIRE DOMAIN NAME FOR SETTING COOKIES.
	 
	//define("COOKIE_DOMAIN", "www.waytobay.net");
	
	define("SITENAME", "listbuydomains.com");
	
	########## Database ##################
	
	if($_SERVER['HTTP_HOST']=="localhost")
	{
	#DATABASE CONNECTION VARIABLE FOR LOCALHOST
	define(DATABASE_SERVER,"localhost");
	define(DATABASE_USERNAME,"root");
	define(DATABASE_PASSWORD,"root");
	define(DATABASE_NAME,"listbuy");
	$GLOBALS['HOST']="http://localhost/listbuy/";
	}
	else
	{
	#DATABASE CONNECTION VARIABLE FOR HOST SERVER
	define(DATABASE_SERVER,"localhost");
	define(DATABASE_USERNAME,"USERNAME");
	define(DATABASE_PASSWORD,"PASSWORD");
	define(DATABASE_NAME,"listbuy");
	$GLOBALS['HOST']="http://www.listbuydomains.com/";
	}
	
		$conn=mysql_pconnect(DATABASE_SERVER,DATABASE_USERNAME,DATABASE_PASSWORD);
		if(!$conn)
		{
			echo("Error on Connection");
		}
		mysql_select_db(DATABASE_NAME,$conn);
	
	require_once('function.php');
	require_once('define.php');
	require_once('db_variables.php');
	############################################

function EdURL($uttl)
{

$uttl=str_replace("$","","$uttl");
//$uttl=str_replace("&","","$uttl");
$uttl=str_replace("=","","$uttl");
$uttl=str_replace("?","","$uttl");
$uttl=str_replace("`","","$uttl");
$uttl=str_replace(":","","$uttl");
$uttl=str_replace("<","","$uttl");
$uttl=str_replace(">","","$uttl");
$uttl=str_replace("[","","$uttl");
$uttl=str_replace("]","","$uttl");
$uttl=str_replace("{","","$uttl");
$uttl=str_replace("}","","$uttl");
$uttl=str_replace("\"","","$uttl");
$uttl=str_replace("+","","$uttl");
$uttl=str_replace("%","","$uttl");
$uttl=str_replace("@","","$uttl");
$uttl=str_replace("/","","$uttl");
//$uttl=str_replace(";","","$uttl");
$uttl=str_replace("\\","","$uttl");
$uttl=str_replace("^","","$uttl");
$uttl=str_replace("|","","$uttl");
$uttl=str_replace("~","","$uttl");
$uttl=str_replace("'","","$uttl");
$uttl=str_replace(",","","$uttl");
//$uttl=str_replace("#","","$uttl");
$uttl=str_replace("(","","$uttl");
$uttl=str_replace(")","","$uttl");
$uttl=str_replace("_","","$uttl");
$uttl=str_replace("!","","$uttl");
$uttl=str_replace(".","","$uttl");
$uttl=str_replace("\"","","$uttl");

$uttl=str_replace("’","-","$uttl");

$uttl=str_replace("  "," ","$uttl");

$uttl=str_replace(" ","-","$uttl");

//$uttl=urlencode($uttl);
return $uttl;
}


?>