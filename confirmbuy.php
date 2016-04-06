<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');	
	$record=Select_Qry("*",BIN,"id='".base64_decode($_REQUEST['bin_id'])."'","","","","");
	$rec=Select_Qry("*",ADVERTISE,"add_id='".$record['add_id']."'","","","","");
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
	function payment1()
	{
		document.frm.action='payment.php';
		document.frm.submit();
	}
</script>
</head>
<body>
<? include_once("toppage1.php");?>
<div id="container" >
<!--LEFT PANEL-->
<? include_once("left-menu.php");?>
<!--LEFT PANEL-->
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
<p style="height:32px;">&nbsp;</p>
<form name="frm" method="post" action="" onsubmit="payment1()">
<input type="hidden" name="mode" value="buyitnow" />
<input type="hidden" name="amount" value="<?=$record['bin_amt']?>" />
<input type="hidden" name="add_id" value="<?=$record['add_id']?>" />
<input type="hidden" name="bin_id" value="<?=$record['id']?>" />
<div style="vertical-align:top;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78%" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="8" class="border">
  <?php /*?><tr>
    <td align="left" valign="top" style="border-bottom:1px solid #EBEBEB;"><span class="title"><?=$record['title']?></span><br /><span class="txtLabel"><?=$record['subtitle']?></span></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Company Name:</span> <?=$record['company_name']?></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Website:</span> <a href="<?=$record['website']?>"><?=$record['website']?></a></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Listed:</span> <?=dateprint($record['posted_on'])?></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Price:</span> <span class="error">$<strong><?=$record['price']?></strong></span></td>
  </tr><?php */?>
   
  <tr>
    <td class="des" style="border-bottom:1px solid #EBEBEB;" align="left">You are just One Step away...</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<?
		if($_REQUEST['msg']!=''){
	?>
	<tr>
    <td colspan="2" align="center" class="error">Your BIN offer was accepted for this auction. Now you can communicate with the seller via PM. </td>
    </tr>
  <? }?>
  <tr>
    <td width="48%" align="right" class="txtLabel"><strong>Buy It Now Price :</strong> </td>
    <td width="52%">$
      <input type="text" name="amount" value="<?=$record['bin_amt']?>" class="smalltextField" readonly />USD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='bin-offer.php'" /></td>
    <td align="right"><input type="<?=$rec['paypal_email']==''?'button':'submit'?>" name="btnSubmit" value="Buy Now" <? if($rec['paypal_email']==''){?> onclick="window.location.href='confirmbuy.php?msg=chk&bin_id=<?=$_REQUEST['bin_id']?>'"<? }else{?>onclick='return payment1()'<? }?>/> <!--<input type="submit" name="btnSubmit" value="Buy Now" />--></td>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
    <td width="1%">&nbsp;</td>
    
  </tr>
</table>
</div>
</form>
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
