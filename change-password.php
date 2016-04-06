<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if(isset($_REQUEST['btnSubmit']))
	{	
	$where_clause="password='".escapeQuotes(stripslashes(trim($_REQUEST['oldpass'])))."'";
		if(Select_Qry("*",USER,$where_clause,"","","",""))
		{
		$set="password='".escapeQuotes(stripslashes(trim($_REQUEST['newpass'])))."'";
		Update_Qry(USER,$set,"WHERE user_id='".$_SESSION['user_id']."'");
		$msg=successfulMessage("You password changed successfully!");
		}
		else
		{
		$msg=errorMessage('Invalid Old Password !');
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
function doChk()
{

	if(document.frm.oldpass.value=="")
	 {
	 alert("Please enter your old password");
	 document.frm.oldpass.focus();
	 return false;
	 }
	 else if(document.frm.newpass.value=="")
	 {
	 alert("Please enter your password");
	 document.frm.newpass.focus();
	 return false;
	 }
	 else if(document.frm.confirmpass.value=="")
	 {
	 alert("Please enter confirm password");
	 document.frm.confirmpass.focus();
	 return false;
	 }
	 else if(document.frm.confirmpass.value != document.frm.newpass.value)
	 {
	 alert("Password mismatch");
	 document.frm.confirmpass.focus();
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
<p><span class="header_text_h">Change Password</span></p>
<p align="center">
<form name="frm" method="post" action="">
<table width="70%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
  <tr>
    <td width="18%">&nbsp;</td>
    <td colspan="2"><?=$msg?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="25%" align="left" class="txtLabel">Old Password </td>
    <td width="57%" align="left"><input type="password" name="oldpass" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel">New Password</td>
    <td align="left"><input type="password" name="newpass" value="" /></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel">Confirm Password</td>
    <td align="left"><input type="password" name="confirmpass" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left" ><input type="submit" name="btnSubmit" value="Change Password" onclick="return doChk();" />&nbsp;<input type="button" name="cancel" value="Cancel" onclick="window.location.href='my-account.php'" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left" ></td>
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
