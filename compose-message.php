<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if($_REQUEST['add_id']=='')
	{
	echo "<script>window.location.href='index.php'</script>";
	}
	if(isset($_REQUEST['btnSubmit']))
	{
		
		$adveruser=Select_Qry("user_id",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
		
			if($_REQUEST['m']=="reply")
			{
				$user=$_REQUEST['u'];
				$username=USERNAME($_REQUEST['u']);
			}
			else
			{
				$user=$adveruser['user_id'];
				$username=USERNAME($adveruser['user_id']);
			}
		
		$set="recipent_id='".$user."',
		sender_id='".$_SESSION['user_id']."',
		add_id='".$_REQUEST['add_id']."',
		mail_subject='".escapeQuotes(stripslashes($_REQUEST['mail_subject']))."',
		mail_content='".escapeQuotes(stripslashes($_REQUEST['mail_content']))."',
		date=NOW()";
		Insert_Qry(OUTBOX,$set);
		Insert_Qry(INBOX,$set);
		
		if($_REQUEST['m']=="reply")
			{
				Update_Qry(INBOX,"unread='1'","WHERE id='".$_REQUEST['mid']."'");
			}
		$mail_From=ADMIN_EMAIL;
		$mail_subject="A new message has been posted by ".USERNAME($_SESSION['user_id'])." at".WEB_ADDRESS;
		$mail_To=USEREMAIL($user);
		$mail_Body='<html>
			<head>
			<title></title>
			<style type="text/css">
			.font
			{
				FONT-FAMILY:tahoma, helvetica, sans-serif;
	    		FONT-SIZE:10pt;
				FONT-WEIGHT:normal;
				COLOR:black;
			}
			</style>
			</head>
			<body>
			<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">A new message has been posted by '.USERNAME($_SESSION['user_id']).' at '.WEB_ADDRESS.'</td>
			</tr>
			<tr>
			<td width="100%">Please <a href="http://'.WEB_ADDRESS.'/login.php" target="_blank" style="text-decoration:none">login</a> to view details.</td></tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">
			Best Regards,
			</td>
			</tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">'.ADMIN_EMAIL.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
		$msg=successfulMessage("Your message has been send successfully!");
		
	}
	$aduser=Select_Qry("user_id",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	
	if($_REQUEST['m']=="reply"){
		$user=$_REQUEST['u'];
		$username=USERNAME($_REQUEST['u']);
	}
	else{
		$user=$aduser['user_id'];
		$username=USERNAME($aduser['user_id']);
	}
	#print USERNAME($aduser['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?=META_KEYWORDS?>"/>
<meta name="description" content="<?=META_CONTENT?>"/>
<link href="css/fresh-auction.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
function doCheck()
{
	if(document.frm.username.value=="")
	{
	alert("Please enter username.");
	document.frm.username.focus();
	return false;
	}
	else if(document.frm.mail_subject.value=="")
	{
	alert("Please enter message subject.");
	document.frm.mail_subject.focus();
	return false;
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
<p><span class="header_text_h">Compose Message</span>
  </p>
<p align="center">
<form name="frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
  <tr>
    <td colspan="2" align="left" valign="top"><?=$msg?></td>
    </tr>
  <tr>
    <td width="21%" align="left" valign="top" class="txtLabel">To</td>
    <td width="79%" align="left" valign="top">
	<input type="text" name="username" value="<?=$username?>" class="largetextField" readonly="readonly" /><br /><span class="text-small">(To whom the message may concerned. Use only Username available on the site.)</span></td>
    </tr>
  <tr>
    <td align="left" valign="top">Subject</td>
    <td align="left" valign="top"><input type="text" name="mail_subject" value="" class="largetextField" /></td>
   </tr>
  <tr>
    <td align="left" valign="top">Message</td>
    <td align="left" valign="top"><textarea name="mail_content"  cols="50" rows="20"></textarea></td>
  </tr>
  
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><input type="submit" name="btnSubmit" value=" Send Message "  onclick="return doCheck();"/>&nbsp;
      <input type="button" name="cancel" value="Cancel"  onclick="javascript: history.back(1);"/></td>
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
