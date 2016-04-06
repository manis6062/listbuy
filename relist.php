<?
	require_once('config/config.php');
	if($_REQUEST['btnSubmit'])
	{
		if(CREDIT($_SESSION['user_id']) >= BASIC_FEE)
		{
		$tmp_sess_id = session_id();
		Update_Qry(CREDIT," credit=(credit-".$_REQUEST['amount'].")","WHERE user_id='".$_SESSION['user_id']."'");
		$set = "length='".VALLID_DAYS."',valid_till= ADDDATE(NOW(),INTERVAL ".VALLID_DAYS." DAY), credit_paid=(credit_paid + ".$_REQUEST['amount']."),payment_date=NOW(),status='1'";
		Update_Qry(ADVERTISE,$set,"WHERE add_id='".$_REQUEST['add_id']."'");
		$table = TRANSACTION;
		$value = "user_id='".$_SESSION['user_id']."',
				  add_id='".$_REQUEST['add_id']."',
				  name ='".$_SESSION['username']."',
				  email ='".$_SESSION['email']."',
				  trans_purpose = 'Listing Relist Payment',
				  trns_amount = '".$_REQUEST['amount']."',
				  payment_date = NOW(),
				  status='1',
				  sess_id = '".$tmp_sess_id."'";
		Insert_Qry($table,$value);
		$record = Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
			$mail_To = USEREMAIL($_SESSION['user_id']);
			$mail_From = ADMIN_EMAIL;
			$mail_subject = "Your listing has been relisted ".WEB_ADDRESS;
			$message='<html>
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
						   <tr><td width="100%">Dear '.USERNAME($_SESSION['user_id']).',</td></tr>
						   <tr><td width="100%">&nbsp;</td></tr>
						   <tr>
							 <td width="100%">Thank you for relisting.</td>
						   </tr>
						   <tr><td width="100%">&nbsp;</td></tr>
						 <tr><td width="100%">Your listing has been successfully relisted at '.WEB_ADDRESS.' </td></tr>
						 <tr><td width="100%">&nbsp;</td></tr>
						 <tr><td width="100%">Your listing details are as follows:</td></tr>
						 <tr>
						 <tr>
						   <td width="100%"><strong>Your listing title is:</strong> '.$record['title'].'</td>
						 </tr>
						  <tr><td width="100%">&nbsp;</td></tr>
						  </tr>
						  <tr>
							<td width="100%">Upgrade your listing to get maximum exposure, visit <a href="http://'.$_SERVER['HTTP_HOST'].'/login.php">login</a> to '.WEB_ADDRESS.'</td>
						  </tr>
							<tr>
							<td width="100%" align="left" valign="top">&nbsp;</td>
						  </tr>
						  <tr>
								<td width="100%">Best Regards,</td>
								</tr>
								<tr>
								<td width="100%">&nbsp;</td></tr>
								<tr>
								<td width="100%">'.WEB_ADDRESS.'</td>
								</tr>
						</table>
						</body>
						</html>';
			#print $mail_Body;
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $message);
			
			header('location:mylistings.php');
			}
			else
			{
				$msg='Sorry! You dont have enough credits in your account.';
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
	function payment()
	{
		<? if(CREDIT($_SESSION['user_id']) >= BASIC_FEE){?>
			document.frm.action='payment.php';
			document.frm.submit();
		<? }?>
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
<p><span class="header_text_h">Relist  
  <?=ADDTITLE($_REQUEST['add_id'])?></span>
  </p>
<p align="left" style="vertical-align:top;">
<form name="frm" method="post" action="">
<input type="hidden" name="mode" value="relist" />
<input type="hidden" name="amount" value="<?=BASIC_FEE?>" />
<input type="hidden" name="add_id" value="<?=$_REQUEST['add_id']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
<?
	if($msg!=''){
?>
<tr>
    <td colspan="2" align="center" class="redbold"><?=$msg?></td>
    </tr>
	<? }?>
<?
	if(CREDIT($_SESSION['user_id']) < BASIC_FEE){
?>
  <tr>
    <td colspan="2" align="center" class="redbold">You don't have enough credits, you must purchase at least
      <?=BASIC_FEE?> credits.</td>
    </tr>
<? }?>
  <tr>
    <td width="46%">&nbsp;</td>
    <td width="54%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="header_sl_2">To relist for another <span class="redbold"><?=VALLID_DAYS?></span> days you must pay <span class="redbold"><?=BASIC_FEE?></span> credits.</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><input type="button" name="btnCancel" value="Cancel" onClick="window.location.href='mylistings.php'" /></td>
    <td align="right"><input type="submit" name="btnSubmit" value="Pay Now" /></td>
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
