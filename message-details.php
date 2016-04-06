<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if(isset($_REQUEST['mid'])!="" && $_REQUEST['mode']=="inbox")
	{
	Update_Qry(INBOX,"unread='1'","WHERE id='".$_REQUEST['mid']."'");
	}
	else
	{
	
	}
	$table=$_REQUEST['mode']=="inbox"?INBOX:OUTBOX;
	$message_fetch=Select_Qry("*",$table,"id='".$_REQUEST['mid']."'","","","","");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?=META_KEYWORDS?>"/>
<meta name="description" content="<?=META_CONTENT?>"/>
<link href="css/fresh-auction.css" rel="stylesheet" type="text/css" />
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
<p><span class="header_text_h"><?=$_REQUEST['mode']=='inbox'?'Inbox':'Outbox'?></span>
  </p>
<p align="center">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
  <tr>
    <td align="left" valign="top"><a href="my-message.php?mode=<?=$_REQUEST['mode']?>">Back to <?=$_REQUEST['mode']=='inbox'?'Inbox':'Outbox'?></a> 
	</td>
	</tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2" align="left" valign="top" class="rowhead">For Advertise: <a href="./<?=remspace($message_fetch['add_id'])?>" ><?php echo ADDTITLE($message_fetch['add_id'])?></a></td>
    </tr>
  <tr>
    <td width="42%" align="left" valign="top"><strong>From:</strong> <?=USERNAME($message_fetch['sender_id'])?></td>
    <td width="43%" align="left" valign="top"><strong>To:</strong>
      <?=USERNAME($message_fetch['recipent_id'])?></td>
    </tr>
  
  <tr>
    <td colspan="2" align="left" valign="top"><strong>Subject: <?=$message_fetch['mail_subject']?></strong></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" class="subheader"  style="border-bottom:1px dotted #333333;"><strong>Posted On:</strong> <?=dateprint($message_fetch['date'])?></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"><?=$message_fetch['mail_content']?></td>
    </tr>
</table>
</td>
    </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  
</table>

</p>
<div class="sidebar_sep"></div>
<? require_once("upper-footer.php"); ?>
<? require_once("footer.php");?>
</div>
</div>

</body>
</html>
