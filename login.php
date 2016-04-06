<?
	require_once('config/config.php');
	if(isset($_REQUEST['btnLogin']))
	{
		$where="username='".mysql_real_escape_string(stripslashes($_REQUEST['username']))."' AND password='".mysql_real_escape_string(stripslashes($_REQUEST['password']))."' AND status='1'";
		//echo "($where)"; exit;
		$record=Select_Qry("*",USER,$where,"","","","");
		if($record != '')
		{
			$_SESSION['user_id']= $record['user_id'];
			$_SESSION['username']= $record['username'];
			$_SESSION['email']= $record['email'];
			if($_REQUEST['add_id']!='')
			{
			/*
				echo"<script>window.location.href='./".remspace(ADDTITLE($_REQUEST['add_id']))."'</script>";
				*/
				header("location:details.php?tit=$_REQUEST[add_id]");
			}
			else
			{
				echo"<script>window.location.href='my-account.php'</script>";
			}
		}
		else
		{
			$msg=errorMessage("Invalid Username or Password.");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?=META_KEYWORDS?>"/>
<meta name="description" content="<?=META_CONTENT?>"/>
<link href="css/fresh-auction.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	function doCheck()
	{
		if(document.frm.username.value=='')
		{
			alert('Please enter Username.');
			document.frm.username.focus();
			return false;
		}
		else if(document.frm.password.value=='')
		{
			alert('Please enter Password.');
			document.frm.password.focus();
			return false;
		}
		else
		{
			return true;
		}
	}
</script>
</head>
<body>
<? include_once("toppage1.php");?>
<div id="container" >
<? include_once("left-menu.php");?>
<div id="content" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/lbd_24.jpg" width="742" height="10" /></td>
  </tr>
  <tr>
    <td>
    
    <div class="header_top">
    <? include_once("cart-info.php");?>
    </div>
    

<div class="clear"></div>

    
<!--div class="menu_top">
<? include_once("top-menu.php")?>
</div-->
<p><span class="header_text_h"><?=static_cms_title(23)?></span><br />
  <?=statica_cms_page_value(23)?> </p>
<p align="center">
<form name="frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>" onsubmit="return doCheck()">
<table width="60%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
  <tr>
    <td width="18%">&nbsp;</td>
    <td colspan="2"><?=$msg?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Username</td>
    <td width="65%" align="left"><input type="text" name="username" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel">Password</td>
    <td align="left"><input type="password" name="password" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left" ><input type="submit" name="btnLogin" value="Login" />
    &nbsp;&nbsp;<a href="forgotpassword.php">Password Reminder</a>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left" ><p>Not a Registered member yet? <a href="registration.php">Sign-up Now</a>! Its free!</p></td>
  </tr>
</table>
</form>
</p>
<div class="sidebar_sep"></div>
</td>
  </tr>
  <tr>
    <td><img src="images/lbd_24a.jpg" width="742" height="10" /></td>
  </tr>
</table>
</div></div></div>
<? require_once("upper-footer.php"); ?>
<? require_once("footer.php");?>

</body>
</html>