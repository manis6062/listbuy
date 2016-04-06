<?
require_once('config/config.php');
$sess=$_SESSION;
	foreach($sess as $key => $value){
		$_SESSION[$key]="";
		unset($_SESSION[$key]);
	}
session_destroy();
echo("<script language='javascript'>window.location.href='index.php';</script>");
?>