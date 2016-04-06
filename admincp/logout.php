<? 
session_start();
$_SESSION['logged']=false;
$_SESSION['username']="";
session_destroy();
echo("<script language='javascript'>window.location.href='index.php';</script>");
?>