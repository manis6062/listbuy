<?
	require_once('config/config.php');
	if(isset($_REQUEST['btnSubmit']))
	{
		header('location:mylistings.php');
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
<p><span class="header_text_h"><?=static_cms_title(2)?></span>
  </p>
<p align="center">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
  <tr>
    <td align="center" valign="top"><?=statica_cms_page_value(2)?></td>
    </tr>
  <tr>
    <td align="center"><input type="button" name="btnCancel" value="  Cancel  " onClick="window.location.href='mylistings.php'" /></td>
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
