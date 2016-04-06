<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if(isset($_REQUEST['btnFinish'])){
		if($_REQUEST['amount']==0){
			header('location:mylistings.php');
		}
		if(CREDIT($_SESSION['user_id'])>=$_REQUEST['amount'])
		{
			$tmp_sess_id = session_id();
			$result = Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']. "'","","","","");
	
			$b=$_REQUEST['bold']!=""?'1':$result['bold'];
			$h=$_REQUEST['highlight']!=''?'1':$result['highlight'];
			$f=$_REQUEST['featured']!=''?'1':$result['featured'];
			$r=$_REQUEST['rowborder']!=''?'1':$result['rowborder'];
			
			$set_value= "bold='".$b."',
					 highlight='".$h."',
					 featured='".$f."',
					 rowborder='".$r."'";
			$where=" WHERE add_id='".$_REQUEST['add_id']."'";
			Update_Qry(ADVERTISE,$set_value,$where);
	
			$set="credit_paid=(credit_paid + ".$_REQUEST['amount'].")";
		Update_Qry(ADVERTISE,$set,"WHERE add_id='".$_REQUEST['add_id']."'");
		Update_Qry(CREDIT," credit =(credit-".$_REQUEST['amount'].")","WHERE user_id='".$_SESSION['user_id']."'");
			$table = TRANSACTION;
			$value = "user_id='".$_SESSION['user_id']."',
					  add_id='".$_REQUEST['add_id']."',
					  name ='".$_SESSION['username']."',
					  email ='".$_SESSION['email']."',
					  trans_purpose = 'Listing Upgradation',
					  trns_amount = '".$_REQUEST['amount']."',
					  payment_date = NOW(),
					  status='1',
					  sess_id = '".$tmp_sess_id."'";
			Insert_Qry($table,$value);
			
			$recordSite = Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
			
			$mail_To = USEREMAIL($recordSite['user_id']);
			$mail_From = ADMIN_EMAIL;
			$mail_subject = "Your listing has been upgraded successfully at ".WEB_ADDRESS;
			$message='<html><head><title></title><style type="text/css">
			.font{FONT-FAMILY:tahoma, helvetica, sans-serif;FONT-SIZE:10pt;
			FONT-WEIGHT:normal;COLOR:black;}
			</style></head>
			<body>
			<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">Dear '.USERNAME($recordSite['user_id']).',</td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">Thank you for upgrading your Listing.</td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">Your listing has been successfully upgraded at '.WEB_ADDRESS.' 
			</td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">Your listing details are as follows:</td></tr>
			<tr><tr><td width="100%"><strong>Your listing title is:</strong> 
			'.$recordSite['title'].'</td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">For further details and additional upgrades please 
			<a href="http://'.$_SERVER['HTTP_HOST'].'/login.php">login</a> to '.WEB_ADDRESS.'</td>
			</tr>
			<tr><td width="100%" align="left" valign="top">&nbsp;</td></tr>
			<tr><td width="100%">Best Regards,</td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">'.WEB_ADDRESS.'</td></tr></table>
			</body></html>';
			#print $mail_Body;
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $message);
			header('location:mylistings.php');
		}
		else
		{
			$msg='Sorry! Not enought credits. Please add more credits to your account';
		}
	}
	$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
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
<p><span class="header_text_h">Confirm Your Listing Upgrades </span>  </p>
<p align="left">
<form name="frm" method="post" action="" >
<input type="hidden" name="bold" value="<?=$_REQUEST['bold']?>">
<input type="hidden" name="highlight" value="<?=$_REQUEST['highlight']?>">
<input type="hidden" name="featured" value="<?=$_REQUEST['featured']?>">
<input type="hidden" name="rowborder" value="<?=$_REQUEST['rowborder']?>">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
<?php /*?><?
	if(CREDIT($record['user_id']) < $total){
?>
<tr>
    <td align="center" class="redbold">You have no credits in your auction account so will need to buy at least <?=$total?> credits.</td>
  </tr> 
 <?
 }
 ?><?php */?>
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
    <td align="left" class="txtLabel">Category</td>
    <td align="left"><?=CATEGORY($record['cat_id'])?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Title</td>
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
    <td align="left" class="txtLabel">Price</td>
    <td align="left"><span class="error"><strong>$<?=$record['price']?></strong></span></td>
  </tr>
  <? }?>
  <tr>
    <td align="left" class="txtLabel">Listing Length </td>
    <td align="left"><?=$record['length']?> Days</td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Company Name </td>
    <td><?=$record['company_name']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Website</td>
    <td align="left"><?=$record['website']?></td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
   <tr>
    <td colspan="2" align="left" class="txtLabel" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="29%" height="20" align="left" class="txtLabel">Site Status</td>
                <td width="31%" height="20" align="left"><?=SITESTATUS($record['site_status_name'])?></td>
                <td width="21%" height="20" align="left" class="txtLabel">Visitors</td>
                <td width="19%" height="20" align="left"><?=$record['visitor']?></td>
              </tr>
              <tr>
                <td height="20" align="left" class="txtLabel">Income</td>
                <td height="20" align="left">$<?=$record['income_month']?></td>
                <td height="20" align="left" class="txtLabel">Page Views</td>
                <td height="20" align="left"><?=$record['traffic_pages']?></td>
              </tr>
              <tr>
                <td height="20" align="left" class="txtLabel">Cost to run site</td>
                <td height="20" align="left"><?=$record['run_cost']?></td>
                <td height="20" align="left" class="txtLabel">Disk Space Used</td>
                <td height="20" align="left"><?=$record['disk_space']?></td>
              </tr>
              <tr>
                <td height="20" align="left" class="txtLabel">Bandwidth Used</td>
                <td height="20" align="left"><?=$record['bandwidth']?></td>
                <td height="20" align="left" class="txtLabel">Members</td>
                <td height="20" align="left"><?=$record['site_members']?></td>
              </tr>
            </table>
	</td>
    </tr>
	<? }?>
</table>

	</td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
  <tr>
    <td align="left" class="header_sl_2">Business Details</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="border">
              <tr>
                <td width="41%" valign="top">
				<ul class="listUL">
				<?
					if($record['income_1'] == '1')
					{
				?>
				<li>Selling Products</li>
				<?
					}
					if($record['income_2'] == '1')
					{
				?>
				<li>Selling Access to Site</li>
				<?
					}
					if($record['income_3'] == '1')
					{
				?>
				<li>Selling Site-related Services</li>
				<?
					}
					if($record['income_4'] == '1')
					{
				?>
				<li>Selling Non-Site-related Services</li>
				<?
					}
					if($record['income_5'] == '1')
					{
				?>
				<li>Other</li>
				<?
					}
					if($record['income_6'] == '1')
					{
				?>
				<li>No Income</li>
				<?
					}
				?>
				</ul>				</td>
                <td width="31%" valign="top">
				<ul class="listUL">
				<?
					if($record['sold_1'] == '1')
					{
				?>
				<li>Business</li>
				<?
					}
					if($record['sold_2'] == '1')
					{
				?>
				<li>Images & Content</li>
				<?
					}
					if($record['sold_3'] == '1')
					{
				?>
				<li>Software</li>
				<?
					}
					if($record['sold_4'] == '1')
					{
				?>
				<li>Tradenamed</li>
				<?
					}
					if($record['sold_5'] == '1')
					{
				?>
				<li>Original Graphics</li>
				<?
					}
					if($record['sold_6'] == '1')
					{
				?>
				<li>3rd party Licenses</li>
				<?
					}
				?> 
				</ul></td>
                <td width="28%" valign="top">
				<ul class="listUL">
				<?
					if($record['own_content'] == '1')
					{
				?>
				<li>All Content</li>
				<?
					}
					if($record['own_server'] == '1')
					{
				?>
				<li>Server</li>
				<?
					}
				?>
				</ul></td>
                </tr>
             </table>
	</td></tr>
	<? }?>
  <tr>
    <td align="left" class="header_sl_2">Option Details </td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
	<tr>
    <td width="29%" class="rowhead">Description</td>
    <td width="71%" class="rowhead">Details</td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">About Us </td>
    <td align="left"><?=$record['aboutus']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Products Page</td>
    <td align="left"><?=$record['product_page']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">FAQ</td>
    <td align="left"><?=$record['faq']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Contact Us </td>
    <td align="left"><?=$record['contact_us']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Contact Email </td>
    <td align="left"><?=$record['contact_email']?></td>
  </tr>
</table>
	</td>
  </tr>
  <tr>
    <td align="left" class="header_sl_2">Upgrades </td>
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
    <td align="left" class="txtLabel"><span class="text-bold">Listing in Featured</span></td>
    <td>Your listing will appear as a featured listing in the natural listings and on the auction homepage.</td>
  </tr>
  <? }?>
  <?
  	if($record['highlight']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel">Listing in Highlighted</td>
    <td>Your listing will appear as a highlighted listing in the natural listings.</td>
  </tr>
  <? }?>
  <?
  	if($record['bold']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel">Listing in Bold</td>
    <td>Your listing will appear as a bold listing in the natural listings.</td>
  </tr>
  <? }?>
  <?
  	if($record['rowborder']==1){
  ?>
  <tr>
    <td align="left" class="txtLabel">Listing in Row Border</td>
    <td>Your listing will appear with a border around your listing in the natural listings.</td>
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
  <?
  	if($_REQUEST['featured']!=''){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing Featured On Home Page Fee</span></td>
    <td align="right"><?=$_REQUEST['featured']!='' ? FEE_FEATURED : '0'?></td>
  </tr>
  <? }?>
  <?
  	if($_REQUEST['highlight']!=''){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing in Highlighted Fee</span></td>
    <td align="right"><?=$_REQUEST['highlight']!='' ? FEE_HIGHLIGHTED : '0'?></td>
  </tr>
  <? }?>
  <?
  	if($_REQUEST['bold']!=''){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing in Bold Fee</span></td>
    <td align="right"><?=$_REQUEST['bold']!='' ? FEE_BOLD : '0'?></td>
  </tr>
  <? }?>
  <?
  	if($_REQUEST['rowborder']!=''){
  ?>
  <tr>
    <td align="left" class="txtLabel"><span class="text-bold">Listing in Row Border Fee</span></td>
    <td align="right"><?=$_REQUEST['rowborder']!='' ? FEE_ROWBORDER : '0'?></td>
  </tr>
  <? }?>
  <?
	$bold=$_REQUEST['bold']!=''?FEE_BOLD:0;
	$highlight=$_REQUEST['highlight']!=''?FEE_HIGHLIGHTED:0;
	$feature=$_REQUEST['featured']!=''?FEE_FEATURED:0;
	$rowborder=$_REQUEST['rowborder']!=''?FEE_ROWBORDER:0;

	 $amount =($bold + $highlight + $feature + $rowborder);
	 $totalAmount =$amount;
  ?>
 <input type="hidden" name="amount" value="<?=$totalAmount?>">
  <tr>
    <td width="84%" class="rowhead1" align="right"><strong>Total cost:</strong></td>
    <td width="16%" class="rowhead1" align="right"><span class="redbold"><?=$totalAmount?></span></td>
	</tr>
</table>
	</td>
  </tr>
  <tr>
    <td align="right" style="height:10px;"></td>
  </tr>
   <tr>
    <td align="right"><input type="submit" name="btnFinish" value="Finish" /></td>
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
