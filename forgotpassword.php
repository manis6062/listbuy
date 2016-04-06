<?
	require_once('config/config.php');
	if(isset($_REQUEST['btnSubmit'])){
		$record=Select_Qry("*",USER,"username ='".escapeQuotes(stripslashes($_REQUEST['username']))."'","","","","");
		if($record !=''){
			$mail_To = escapeQuotes(stripslashes($record['email']));
			$mail_From = WEB_ADDRESS."<br>";
			$mail_subject = "Password Reminder";
			$mail_Body = "<p>Your password at ".WEB_ADDRESS." is <b>".$record['password']."</b></p>";
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			$msg = successfulMessage("Your password has been sent to ".escapeQuotes(stripslashes($record['email']))."");
		}
		else
		{
			$msg=errorMessage("Invalid Username.");
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
<p><span class="header_text_h"><?=static_cms_title(26)?></span><br /><?=statica_cms_page_value(26)?> </p>
<p align="center">
<form name="frm" method="post" action="" onsubmit="return doCheck()">
<table width="60%" border="0" cellspacing="3" cellpadding="4" align="center" style="border:1px solid #CCCCCC;">
  <tr>
    <td width="7%">&nbsp;</td>
    <td colspan="2"><?=$msg?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="33%" align="left" class="txtLabel">Enter Your Username</td>
    <td width="60%" align="left"><input type="text" name="username" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left"><input type="submit" name="btnSubmit" value="Submit" />&nbsp;&nbsp;<input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='login.php'" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left"><p>Not a Registered member yet?<br />
      <a href="registration.php">Sign-up Now</a> ! Its free!</p></td>
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
