<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if($_REQUEST['add_id']==''){
		header('location:index.php');
	}
	else{
		$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	}
	if(isset($_REQUEST['btnSubmit']))
	{
		if($_REQUEST['amount'] < $record['buyer_price'])
			{
				$msg=errorMessage("Your BIN offer is below the posted BIN Price.");
			}
			else
			{
		$set="add_id='".$_REQUEST['add_id']."',
			  user_id='".$_SESSION['user_id']."',
			  bin_amt='".$_REQUEST['amount']."'";
			Insert_Qry(BIN,$set);
			$msg="Your Bin offer is awaiting the sellers approval. Once the seller approves, your offer will be activated and available for buy.";
			$succ=1;
		    $siteowner=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
			
		############### mail to seller ########
		$mail_From=ADMIN_EMAIL;
		$mail_subject="A BIN Offer for ".ADDTITLE($siteowner['add_id'])." has been 
		posted at ".WEB_ADDRESS;
		$mail_To=USEREMAIL($siteowner['user_id']);
		$mail_Body='<html>
			<head>
			<title></title>
			<style type="text/css">.font{FONT-FAMILY:tahoma, helvetica, sans-serif;
	    		FONT-SIZE:10pt;FONT-WEIGHT:normal;COLOR:black;}</style>
			</head>
			<body>
			<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">Dear '.USERNAME($siteowner['user_id']).',</td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">A BIN Offer for '.ADDTITLE($siteowner['add_id']).' 
			was posted at '.WEB_ADDRESS.'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">Click here to logon to our site <a href="http://'.WEB_ADDRESS.'">http://'.WEB_ADDRESS.'/login.php</a></td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">Best Regards,</td></tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr><td width="100%">'.WEB_ADDRESS.'</td></tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
			
			################### mail to buyer #########
		$mail_From2=ADMIN_EMAIL;
		$mail_subject2="Your BIN Offer was submitted for ".ADDTITLE($objaccep['add_id'])." at ".WEB_ADDRESS; 
		$mail_To2=USEREMAIL($_SESSION['user_id']);
		$mail_Body2='<html>
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
			<td width="100%">Dear: '.USERNAME($_SESSION['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">Your BIN Offer was submitted for '.ADDTITLE($objaccep['add_id']).' at '.WEB_ADDRESS.'</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			<td width="100%">Click here to logon to our site <a href="http://'.WEB_ADDRESS.'">http://'.WEB_ADDRESS.'/login.php</a></td></tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">
			Best Regards,</td>
			</tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">'.WEB_ADDRESS.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To2, $mail_From2, '', $mail_subject2, $mail_Body2);
			//print $mail_Body;
			
	}
}
	#############################################
	if(isset($_REQUEST['btnUpload'])){
		$set="user_id='".$_SESSION['user_id']."',
			  add_id='".$_REQUEST['add_id']."',
			  file_describe='".escapeQuotes(stripslashes(trim($_REQUEST['file_describe'])))."'";
		if($_FILES['attach_file']['name']!="")
		  {
			$wdir="attachment/";
			$file_type = $_FILES['attach_file']['type'];
			$file_name = $_FILES['attach_file']['name'];
			$file_size = $_FILES['attach_file']['size'];
			$file_tmp = $_FILES['attach_file']['tmp_name'];
			$ext=getext($_FILES['attach_file']['name']);
			$imagname=rand()."_".date("m_d_Y").$ext;
			$uploadfile =$wdir.$imagname;
			image_resize($wdir."large_",600,$file_type,$file_name,$file_size,$file_tmp,$imagname);
			image_resize($wdir."thumb_",150,$file_type,$file_name,$file_size,$file_tmp,$imagname);
			//move_uploaded_file($_FILES['attach_file']['tmp_name'], $uploadfile);
			$set.=",attach_file ='".$imagname."'";
			}
			Insert_Qry(ATTACHMENTS,$set);
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
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="lightbox/js/prototype.js"></script>
<script type="text/javascript" src="lightbox/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="lightbox/js/lightbox.js"></script>

<script type="text/javascript">
	function payment1()
	{
		document.frm.action='payment.php';
		document.frm.submit();
	}
	
	function doAttach()
	{
		if(document.frm.attach_file.value=="")
		{
		 	alert("Please upload Attachment File.");
		 	document.frm.attach_file.focus();
		  	return false;
		 }
		  return true;
	}
	function doRedirect(){
		window.location.href='bin-offer.php';
	}
</script>
</head>
<body <? if($succ==1){?>onload="setTimeout(doRedirect(),3000)" <? }?>>
<div id="container" >
<!--LEFT PANEL-->
<div id="sidebar">

 <div style="vertical-align:top">
 
   <table width="216" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td><img src="images/lbd_22.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td class="left_menu_bg">
    
    
    
 <table width="100%" >
  <tr>
    <td><h2>Owner Profile</h2></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="avatar/noimage.jpeg" /></td>
  </tr>
  <tr>
    <td align="center"><a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'user-profile.php?add_id='.$record['add_id']?>&user_id=<?=$record['user_id']?>" class="user"><?=USERNAME($record['user_id'])?></a><a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'compose-message.php?add_id='.$record['add_id']?>" class="user">Message me</a></td>
  </tr>
</table>


</td>
  </tr>
  <tr>
    <td><img src="images/lbd_30.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
 </div>   
</div>
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
<form name="frm" method="post" action="">
<input type="hidden" name="mode" value="buyitnow" />
<input type="hidden" name="amount" value="<?=$total?>" />
<input type="hidden" name="add_id" value="<?=$_REQUEST['add_id']?>" />
<div style="vertical-align:top;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78%" align="left" valign="top" class="border">
	<table width="100%" border="0" cellspacing="0" cellpadding="8" >
  <tr>
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
  </tr>
  <tr>
    <td class="des" style="border-bottom:1px solid #EBEBEB;" align="left">Buy this listing </td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	
	<tr>
    <td colspan="2" align="center" class="error"><?=$msg?></td>
    </tr>
  <? if($succ!=1){?>
  <tr>
    <td width="48%" align="right" class="txtLabel"><strong>Buy It Now Price :</strong> </td>
    <td width="52%">$
      <input type="text" name="amount" value="<?=$_REQUEST['amount']==""?$record['buyer_price']:$_REQUEST['amount']?>" class="smalltextField" />USD</td>
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
    <td><input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='./<?=remspace($record['title'])?>'" /></td>
    <td align="right"><input type="submit" name="btnSubmit" value="Buy Now" /></td>
  </tr>
  <? }?>
</table>

	</td>
  </tr>
</table>

	</td>
    <td width="1%">&nbsp;</td>
    <td width="21%" align="left" valign="top"  class="border">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td class="rowhead">Attachments</td>
  </tr>
  <?
  	$attachRecord=Listing_Qry("*",ATTACHMENTS,"WHERE add_id='".$_REQUEST['add_id']."' AND status='1' order by id DESC","");
	if($attachRecord!=''){
		foreach($attachRecord as $attch){
  ?>
  <tr style="padding-bottom:4px;">
    <td align="left"><a href="attachment/large_<?=$attch["attach_file"]?>" rel="lightbox[roadtrip]"><img src="attachment/thumb_<?=$attch['attach_file']?>" border="0" class="img_border" /></a></td>
  </tr>
  <? }
  }else{
  ?>
  <tr>
    <td class="text-small">This Listing does not have any attachments</td>
  </tr>
  <? }?>
  <?
  	if($_SESSION['user_id']==$record['user_id']){
  ?>
  <tr>
    <td>Add an attachment </td>
  </tr>
  <tr>
    <td class="text-small">Choose a file:<br />
      <input type="file" name="attach_file" class="smalltextField" size="10" /></td>
  </tr>
  <tr>
    <td class="text-small">Describe your file <br /><input type="text" name="file_describe" value="" class="smalltextField" /></td>
  </tr>
  <tr>
    <td><input type="submit" name="btnUpload" value="Upload" onclick="return doAttach()" /></td>
  </tr>
  <? }?>
</table>
	</td>
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
