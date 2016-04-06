<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	
	$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	$f=$record['featured']==1?FEE_FEATURED:'0';
	$h=$record['highlight']==1?FEE_HIGHLIGHTED:'0';
	$b=$record['bold']==1?FEE_BOLD:'0';
	$r=$record['rowborder']==1?FEE_ROWBORDER:'0';
	$total=BASIC_FEE+$f+$h+$b+$r;
	
	if(isset($_REQUEST['btnSubmit'])){
		if(CREDIT($_SESSION['user_id']) >= $_REQUEST['amount'])
		{
			$tmp_sess_id = session_id();
			
			$set="credit_paid='".$_REQUEST['amount']."',status='1'";
			Update_Qry(ADVERTISE,$set,"WHERE add_id='".$_REQUEST['add_id']. "'");
			
			$userCredit=Select_Qry("credit",CREDIT," user_id='".$_SESSION['user_id']."'","","","","");
			if($userCredit)
			{
			Update_Qry(CREDIT," credit=(credit-".$_REQUEST['amount'].")","WHERE user_id='".$_SESSION['user_id']."'");
			}else{
			$CREDITVALUE="user_id='".$_SESSION['user_id']."',credit='".$_REQUEST['amount']."',status='1',posted_on=NOW()";
			Insert_Qry(CREDIT,$CREDITVALUE);
			}
			$table = TRANSACTION;
			$value = "user_id='".$_SESSION['user_id']."',
					  add_id='".$_REQUEST['add_id']."',
					  name ='".$_SESSION['name']."',
					  email ='".$_SESSION['email']."',
					  trans_purpose = 'Listing Add',
					  credit = '".$_REQUEST['amount']."',
					  payment_date = NOW(),
					  status='1',
					  sess_id = '".$tmp_sess_id."'";
			Insert_Qry($table,$value);
		
			
			$mail_To = USEREMAIL($_SESSION['user_id']);
			$mail_From = ADMIN_EMAIL;
			$mail_subject = "Your listing has been successfully added at ".WEB_ADDRESS;
			$mail_Body ="<html>
						<head>
						<title></title>
						<style type='text/css'>
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
						<table border='0' cellpadding='0' cellspacing='0' width='80%' class='font'>
						  <tr><td>&nbsp;</td></tr>
						   <tr><td>Dear ".USERNAME($_SESSION['user_id']).",</td></tr>
						   <tr><td>&nbsp;</td></tr>
						   <tr>
							 <td>Thank you for your listing.</td>
						   </tr>
						   <tr><td>&nbsp;</td></tr>
						 <tr><td>Your listing was successfully listed at ".WEB_ADDRESS.".</td></tr>
						 <tr><td>&nbsp;</td></tr>
						 <tr><td>Your listing details are as follows:</td></tr>
						 <tr>
						 <tr>
						   <td width='100%' align='left' valign='top'><strong>Your listing title is:</strong> ".$record['title']."</td>
						 </tr>
						  <tr><td>&nbsp;</td></tr>
						  </tr>
						  <tr>
							<td width='100'>Get more exposure by upgrading your listing today! visit <a href='http://".$_SERVER['HTTP_HOST']."/login.php'>login</a> to ".WEB_ADDRESS.".</td>
						  </tr>
							<tr>
							<td width='100%' align='left' valign='top'>&nbsp;</td>
						  </tr>
						  <tr>
								<td width='100%' align='left' valign='top'>Best Regards,</td>
								</tr>
								<tr>
								<td width='100%' align='left' valign='top'>&nbsp;</td></tr>
								<tr>
								<td width='100%' align='left' valign='top'>".WEB_ADDRESS." Team</td>
								</tr>
						</table>
						</body>
						</html>";
						//print $mail_Body ;
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			
			header('location:mylistings.php');
		}
		else
		{
			$msg='Sorry! Sorry you dont have enough credits';
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
	/*function payment()
	{
		if(document.frm.check.checked==false)
		 {
		 	alert("You must accept the terms and conditions");
			return false;
		 }
		 else
		 {
		 	<? if(CREDIT($record['user_id']) >= $total){?>
			document.frm.action='payment.php';
			document.frm.submit();
			<? }?>
		  }
	}*/
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
<p><span class="header_text_h">Review Your Listing</span>  </p>
<p align="left">
<form name="frm" method="post" action="">
<input type="hidden" name="mode" value="payment" />
<input type="hidden" name="amount" value="<?=$total?>" />
<input type="hidden" name="add_id" value="<?=$_REQUEST['add_id']?>" />
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
<?
	if($msg!=''){
?>
<tr><td align="center" class="redbold"><?=$msg?></td></tr><? }?>
<?
	if(CREDIT($record['user_id']) < $total){
?>
<tr>
    <td align="center" class="redbold">You have no credits in your account, you need to purchase at least 
      <?=$total?> credits.</td>
  </tr> 
 <?
 }
 ?>
  <tr>
    <td align="left" class="header_sl_2">Required Details </td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
	<tr>
    <td width="29%" class="rowhead">Description</td>
    <td width="71%" class="rowhead">Details</td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Selected Category</td>
    <td align="left"><?=CATEGORY($record['cat_id'])?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Listing Title</td>
    <td align="left"><?=$record['title']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Subtitle</td>
    <td align="left"><?=$record['subtitle']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel" valign="top">Description</td>
    <td align="left" valign="top"><?=$record['description']?></td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
  <tr>
    <td align="left" class="txtLabel">Asking Price</td>
    <td align="left"><span class="error"><strong>$<?=$record['price']?></strong></span></td>
  </tr>
  <? }?>
  <tr>
    <td align="left" class="txtLabel">Listing Length </td>
    <td align="left"><?=$record['length']?> Days</td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
  <tr>
    <td align="left" class="txtLabel">Buy It Now Price</td>
    <td align="left"><span class="error"><strong>$<?=$record['buyer_price']?></strong></span></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Paypal Email Address</td>
    <td align="left"><?=$record['paypal_email']?></td>
  </tr>
  <? }?>
  <tr>
    <td align="left" class="txtLabel">Company Name </td>
    <td><?=$record['company_name']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Demo URL</td>
    <td align="left"><?=$record['website']?></td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
   <tr>
    <td colspan="2" align="left" class="txtLabel" valign="top">&nbsp;</td>
    </tr>
	<? }?>
</table>

	</td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
	<? }?>
  <tr>
    <td align="left" class="header_sl_2">Optional Upgrades </td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
	<tr>
    <td width="29%" class="rowhead">Upgrade</td>
    <td width="71%" class="rowhead">Description</td>
  </tr>
  <?
  	if($record['featured']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Featured</span></td>
    <td>Your listing will appear featured section</td>
  </tr>
  <? }?>
  <?
  	if($record['highlight']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel">Highlighted</td>
    <td>Your listing will appear highlighted as light yellow.</td>
  </tr>
  <? }?>
  <?
  	if($record['bold']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel">Bold</td>
    <td>Your listing text title will be bold</td>
  </tr>
  <? }?>
  <?
  	if($record['rowborder']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel">Row Border</td>
    <td>Your listing will appear with a border</td>
  </tr>
  <? }?>
</table>
	</td>
  </tr>
  <tr>
    <td align="left" class="header_sl_2">Total cost of your Listing</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
	<tr>
    <td width="84%" class="rowhead">Item</td>
    <td width="16%" class="rowhead" align="right">Cost(credits)</td>
	</tr>
  <tr>
    <td align="left" class="txtLabel">Basic Listing Fee </td>
    <td align="right"><?=BASIC_FEE?></td>
  </tr>
  <?
  	if($record['featured']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing Featured On Home Page Fee</span></td>
    <td align="right"><?=FEE_FEATURED?></td>
  </tr>
  <? }?>
  <?
  	if($record['highlight']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing in Highlighted Fee</span></td>
    <td align="right"><?=FEE_HIGHLIGHTED?></td>
  </tr>
  <? }?>
  <?
  	if($record['bold']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing in Bold Fee</span></td>
    <td align="right"><?=FEE_BOLD?></td>
  </tr>
  <? }?>
  <?
  	if($record['rowborder']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing in Row Border Fee</span></td>
    <td align="right"><?=FEE_ROWBORDER?></td>
  </tr>
  <? }?>
  <tr>
    <td width="84%" class="rowhead1" align="right"><strong>Total cost:</strong></td>
    <td width="16%" class="rowhead1" align="right"><span class="redbold"><?=$total?></span></td>
	</tr>
</table>
	</td>
  </tr>
  <tr>
    <td align="right" style="height:10px;"></td>
  </tr>
   <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><input type="button" name="preview" onclick="window.location.href='newlisting.php?add_id=<?=$_REQUEST['add_id']?>'" value="< Preview" /></td>
    <td align="right" valign="top"><input type="submit" name="btnSubmit" value="Finish" /></td>
  </tr>
</table>

</td>
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
