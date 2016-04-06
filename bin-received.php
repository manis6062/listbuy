<?	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="rej"))
	{	
		Update_Qry(BIN,"accept='1'","WHERE id='".base64_decode($_REQUEST['id'])."'");
		$msg=successfulMessage("You have successfully rejected the BIN Offer.");
		$objreject=Select_Qry("*",BIN,"id='".base64_decode($_REQUEST['id'])."'","","","","");
		$siteowner3=Select_Qry("*",ADVERTISE,"add_id='".$objreject['add_id']."'","","","","");
		
		############### mail to seller ########
		$mail_From=ADMIN_EMAIL;
		$mail_subject="You have rejected the BIN Offer for ".ADDTITLE($siteowner3['add_id'])." at ".WEB_ADDRESS;
		$mail_To=USEREMAIL($siteowner3['user_id']);
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
			<td width="100%">Dear '.USERNAME($siteowner3['user_id']).',</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">You have rejected the BIN Offer for '.ADDTITLE($siteowner3['add_id']).' at '.WEB_ADDRESS.'</td>
			</tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">Click here to login to our site <a href="http://'.WEB_ADDRESS.'">http://'.WEB_ADDRESS.'/login.php</a>
</td></tr>
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
			<td width="100%">'.WEB_ADDRESS.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
			
			################### mail to buyer #########
		$mail_From2=ADMIN_EMAIL;
		$mail_subject2="Your BIN Offer was rejected for ".ADDTITLE($objreject['add_id'])." at ".WEB_ADDRESS; 
		$mail_To2=USEREMAIL($objreject['user_id']);
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
			<td width="100%">Dear: '.USERNAME($objreject['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">Your BIN Offer was rejected for '.ADDTITLE($objreject['add_id']).' at '.WEB_ADDRESS.'</td>
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
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="acc"))
	{	$objaccep=Select_Qry("*",BIN,"id='".base64_decode($_REQUEST['id'])."'","","","","");
		$siteowner4=Select_Qry("*",ADVERTISE,"add_id='".$objaccep['add_id']."'","","","","");
		
		
		Update_Qry(BIN,"accept='2'","WHERE id='".base64_decode($_REQUEST['id'])."'");
		Update_Qry(ADVERTISE,"winner_id='".$objaccep['user_id']."',status='2'","WHERE add_id='".$objaccep['add_id']."'");
		
		$msg=successfulMessage("You have accepted the BIN offer, The buyer has been notified. If you entered a paypal address in your listing, the buyer will automatically be prompted to pay via paypal through this site and the buyer and seller details will be exchanged. If a paypal address wasn't entered during the original listing setup, please contact the other party to arrange payment.");
	############### mail to seller #################
		$mail_From=ADMIN_EMAIL;
	$mail_subject="You have accepted the BIN Offer for ".ADDTITLE($siteowner4['add_id'])." was posted by ".USERNAME($objaccep['user_id'])." at ".WEB_ADDRESS;
	$mail_To=USEREMAIL($siteowner4['user_id']);
	$mail_Body='<html><head><title></title><style type="text/css">
		.font{FONT-FAMILY:tahoma, helvetica, sans-serif;
		FONT-SIZE:10pt;FONT-WEIGHT:normal;COLOR:black;
		}</style></head><body>
		<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">Dear '.USERNAME($siteowner4['user_id']).',</td></tr>
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">You have accepted the BIN Offer for '.ADDTITLE($siteowner4['add_id']).' was posted by '.USERNAME($objaccep['user_id']).' at '.WEB_ADDRESS.'</td></tr>
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">Click here to logon to our site 
		<a href="http://'.WEB_ADDRESS.'">http://'.WEB_ADDRESS.'/login.php</a></td></tr>
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">Best Regards,</td></tr>
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">'.WEB_ADDRESS.'</td></tr>
		</table></body></html>';
		Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
		//print $mail_Body;
	################### mail to buyer #########
	$mail_From2=ADMIN_EMAIL;
	$mail_subject2="Your BIN Offer was accepted for ".ADDTITLE($objaccep['add_id'])." at ".WEB_ADDRESS." "; 
	$mail_To2=USEREMAIL($objaccep['user_id']);
	$mail_Body2='<html><head><title></title>
	<style type="text/css">.font{
	FONT-FAMILY:tahoma, helvetica, sans-serif;
	FONT-SIZE:10pt;FONT-WEIGHT:normal;COLOR:black;
	}</style></head><body>
	<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
	<tr><td width="100%">&nbsp;</td></tr>
	<tr><td width="100%">Dear '.USERNAME($objaccep['user_id']).',</td></tr>
	<tr><td width="100%">&nbsp;</td></tr>
	<tr><td width="100%">
	Your BIN Offer was accepted for '.ADDTITLE($objaccep['add_id']).' at '.WEB_ADDRESS.', please arrange to make payment to the seller</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td width="100%">Click here to logon to our site <a href="http://'.WEB_ADDRESS.'"> http://'.WEB_ADDRESS.'/login.php</a></td></tr>
	<tr><td width="100%">&nbsp;</td></tr>
	<tr><td width="100%">Best Regards,</td></tr>
	<tr><td width="100%">&nbsp;</td></tr>
	<tr><td width="100%">'.WEB_ADDRESS.'</td></tr>
	</table></body></html>';
	Send_HTML_Mail($mail_To2, $mail_From2, '', $mail_subject2, $mail_Body2);
	//print $mail_Body;
		
	}
###################### DELETE #########################	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{
	$objdel=Select_Qry("*",BIN,"id='".base64_decode($_REQUEST['id'])."'","","","","");
	$siteowner8=Select_Qry("*",ADVERTISE,"add_id='".$objdel['add_id']."'","","","","");
		
	Delete_Qry(BIN,"WHERE id='".base64_decode($_REQUEST['id'])."'");
	if(date("m-d-Y",strtotime($siteowner8['valid_till'])) > date("m-d-Y"))
	{
	Update_Qry(ADVERTISE,"winner_id='0',status='1'","WHERE add_id='".$objdel['add_id']."'");
	}
	$msg=successfulMessage("You have successfully deleted the BIN Offer.");
	}
###################### REJECT AND RELIST #####################
/*if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="rejRelist"))
	{
		$objrelist=Select_Qry("*",BIN,"id='".base64_decode($_REQUEST['id'])."'","","","","");
		$siteowner7=Select_Qry("*",ADVERTISE,"add_id='".$objrelist['add_id']."'","","","","");
			
		Update_Qry(BIN,"accept='1'","WHERE id='".base64_decode($_REQUEST['id'])."'");
		
		if(date("m-d-Y",strtotime($siteowner7['valid_till'])) > date("m-d-Y"))
		{
		Update_Qry(ADVERTISE,"winner_id='0',status='1'","WHERE add_id='".$objrelist['add_id']."'");
		}
		$msg=successfulMessage("You have successfully rejected the BIN Offer.");
	}*/
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
function jsHitListAction(p1)
	{			
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?PageNo=" + eval(p1) ;
		document.frm.submit()
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
<p><span class="header_text_h">Received BIN Offers </span></p>
<p align="center">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr><td align="left" valign="top"><?=$msg?></td></tr>
<tr><td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="border">
  <tr>
    <td width="23%" align="left" valign="top" class="rowhead">Advertise Title </td>
    <td width="16%" align="left" valign="top" class="rowhead">BIN Price($)</td>
    <td width="16%" align="left" valign="top" class="rowhead">Proposed By </td>
    <td width="16%" align="left" valign="top" class="rowhead">Posted On </td>
    <td width="12%" align="left" valign="top" class="rowhead">Action</td>
  </tr>
  <?
  			$PageSize =30;	
            $StartRow = 0;
           	$sql="SELECT p.id,p.user_id as USERID,p.add_id,p.bin_amt,p.posted_on,p.accept,a.add_id,a.user_id as ADDUSERID,a.title,a.price,a.length,a.status FROM ".BIN." AS p LEFT JOIN ".ADVERTISE." AS a ON p.add_id=a.add_id WHERE a.user_id='".$_SESSION['user_id']."' ORDER BY p.id DESC ";
			$slNo=0;
			include_once('paging-top.php');
            if(mysql_num_rows($rs)>0)
			{
			$bgColor = "#ffffff";
			for($i=0;$i<mysql_num_rows($rs);$i++)
			{
			$slNo++;
			$obj_fetch=mysql_fetch_array($rs);
  ?>
  <tr>
    <td align="left" valign="top"><a href="./<?=remspace($obj_fetch['add_id'])?>"><?=$obj_fetch['title']?></a></td>
    <td align="left" valign="top"><?=$obj_fetch['bin_amt']?></td>
    <td align="left" valign="top"><?=USER($obj_fetch['USERID'])?></td>
    <td align="left" valign="top"><?=dateprint($obj_fetch['posted_on'])?></td>
    <td align="left" valign="top">
    
<? if($obj_fetch['accept']=='0' && $obj_fetch['status']=='1'){?>
Pending [<a href="<?=$_SERVER['PHP_SELF']?>?mode=acc&id=<?=base64_encode($obj_fetch['id'])?>" onClick="return confirm('Are you sure to accept this offer?')" title="Accept This Offer" class="user_menu">Accept</a>  | <a href="<?=$_SERVER['PHP_SELF']?>?mode=rej&id=<?=base64_encode($obj_fetch['id'])?>" onClick="return confirm('Are you sure to reject this offer?')" title="Reject This Offer" class="user_menu">Reject</a> ]
<? }if($obj_fetch['accept']=='1'){?>
Rejected
<? }if($obj_fetch['accept']=='2'){?>
Accepted | <?php /*?><a href="<?=$_SERVER['PHP_SELF']?>?mode=rejRelist&id=<?=base64_encode($obj_fetch['id'])?>" onClick="return confirm('Are you sure to reject and relist?')" title="Reject and Relist" class="user_menu">Reject & Relist</a>
<a href="<?=$_SERVER['PHP_SELF']?>?mode=rej&id=<?=base64_encode($obj_fetch['id'])?>" onClick="return confirm('Are you sure to reject this offer?')" title="Reject This Offer" class="user_menu">Reject</a><br /><?php */?>

<? }if($obj_fetch['accept']=='3'){?>
<span style="color:#E80000">Purchased</span>

<? }if($obj_fetch['accept'] >='2'){
	$where="user_id='".$obj_fetch['USERID']."' AND posted_by='".$_SESSION['user_id']."' AND add_id='".$obj_fetch['add_id']."'";
	$chk=Select_Qry("*",USER_FEEDBACK,$where,"","","","");
	if($chk=='')
	{
?>
<br /><a href="post-feedback.php?u=<?=base64_encode($obj_fetch['USERID'])?>&add_id=<?=$obj_fetch['add_id']?>" class="user_menu">Feedback</a>

<?
}
}if($obj_fetch['accept']!='3'){
?>
<br /><a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=base64_encode($obj_fetch['id'])?>" onClick="return confirm('Are you sure you want to delete this offer?')" title="Delete This Offer" class="user_menu">Delete</a>
<? }?></td>
  </tr>
  <tr><td colspan="5" style="border-bottom:1px dashed #CCCCCC;">&nbsp;</td></tr>
  <?
  	}
  ?>
  <tr><td align="right" valign="top" colspan="5"><? include_once('pageno.php');?></td></tr>
  <?
  }
  else
  {
  ?>
  <tr><td align="center" valign="top" colspan="5"><?=errormessage("No BIN Offers Posted")?></td></tr>
  <?
  }
  ?>
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
