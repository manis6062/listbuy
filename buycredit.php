<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
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
		if(document.frm.credit.value=='')
		{
			alert("Please enter Credit value.");
			document.frm.credit.focus();
			return false;
		}
		else{
			document.frm.action="payment.php";
			document.frm.submit();
		}
	}
	
	function keyRestrict(e, validchars)
	{
	 var key='', keychar='';
	 key = getKeyCode(e);
	 if (key == null) return true;
	 keychar = String.fromCharCode(key);
	 keychar = keychar.toLowerCase();
	 validchars = validchars.toLowerCase();
	 if (validchars.indexOf(keychar) != -1)
	  return true;
	 if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
	  return true;
	 return false;
    }
    function getKeyCode(e)
	{
	 if (window.event)
		return window.event.keyCode;
	 else if (e)
		return e.which;
	 else
		return null;
     }
</script>
</head>
<body>
<? include_once("toppage1.php"); ?>

<div id="container" >

<? include_once("left-menu.php"); ?>

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
<p><span class="header_text_h">Buy Credits </span>
  </p>
<p align="left">
<form name="frm" method="post" action="" onsubmit="return doCheck()">
<input type="hidden" name="mode" value="credit" />
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
<tr>
    <td width="7%">&nbsp;</td>
    <td colspan="2" align="left" style="padding-left:200px;" class="header_sl_2">You have <span class="redbold"><?=CREDIT($_SESSION['user_id'])?></span> credits in your account.</td>
    </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="32%">&nbsp;</td>
    <td width="61%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="txtLabel">How many credits would you like to buy?</span> <br />      
      1 credit costs $1USD </td>
    <td align="left" valign="top"><input type="text" name="credit" value="" class="smalltextField" onkeypress="return keyRestrict(event,'1234567890.')" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnPay" value="Pay Now" /></td>
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

<? require_once("footer.php");?>
<? require_once("upper-footer.php"); ?>


</body>
</html>
