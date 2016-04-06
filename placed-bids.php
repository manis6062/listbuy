<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		Delete_Qry(PROPOSAL,"WHERE id='".base64_decode($_REQUEST['id'])."'");
		$msg=successfulMessage("Deleted Successfully");
	}
	
	if(isset($_REQUEST['pid'])!="")
	{
	Update_Qry(PROPOSAL,"accept='3'","WHERE id='".$_REQUEST['pid']."'");
	
		$objaccep=Select_Qry("*",PROPOSAL,"id='".$_REQUEST['pid']."'","","","","");
		$siteowner3=Select_Qry("*",ADVERTISE,"add_id='".$objaccep['add_id']."'","","","","");
	
	############### mail to seller ########
		$mail_From=ADMIN_EMAIL;
		$mail_subject="Your bid for ".ADDTITLE($siteowner3['add_id'])." was confirmed by ".USERNAME($objaccep['user_id'])." at ".WEB_ADDRESS;
		$mail_To=USEREMAIL($objaccep['user_id']);
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
			<td width="100%">Dear: '.USERNAME($siteowner3['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">Your bid for '.ADDTITLE($siteowner3['add_id']).' was confirmed by '.USERNAME($objaccep['user_id']).' at '.WEB_ADDRESS.'</td>
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
		$mail_subject2="You confirmed a bid for ".ADDTITLE($objaccep['add_id'])." at ".WEB_ADDRESS; 
		$mail_To2=USEREMAIL($objaccep['user_id']);
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
			<td width="100%">Dear: '.USERNAME($objaccep['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">You confirmed a bid for '.ADDTITLE($objaccep['add_id']).' at '.WEB_ADDRESS.'</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			<td width="100%">Click here to login to our site <a href="http://'.WEB_ADDRESS.'">http://'.WEB_ADDRESS.'/login.php</a></td></tr>
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
	$msg=successfulMessage("You have successfully confirmed the bid amount, please wait for the seller to confirm. For further communication please use private message system.");
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
<p><span class="header_text_h">Placed Bids </span></p>
<p align="center">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr><td align="left" valign="top"><?=$msg?></td></tr>
<tr><td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="border">
  <tr>
    <td width="23%" align="left" valign="top" class="rowhead">Advertise Title </td>
    <td width="16%" align="left" valign="top" class="rowhead">Bid Amount($)</td>
    <td width="16%" align="left" valign="top" class="rowhead">Proposed By </td>
    <td width="17%" align="left" valign="top" class="rowhead">Proposed Amount($) </td>
    <td width="14%" align="left" valign="top" class="rowhead">Posted On </td>
    <td width="14%" align="center" valign="top" class="rowhead">Action</td>
  </tr>
  <?
  			$PageSize =30;	
            $StartRow = 0;
           	$sql="SELECT p.id,p.user_id as USERID,p.add_id,p.proposed_amt,p.posted_on,p.accept,a.add_id,a.user_id as ADDUSERID,a.title,a.price,a.length,a.status FROM ".PROPOSAL." AS p LEFT JOIN ".ADVERTISE." AS a ON p.add_id=a.add_id WHERE p.user_id='".$_SESSION['user_id']."' ORDER BY p.id DESC ";
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
    <td align="left" valign="top"><?=$obj_fetch['price']?></td>
    <td align="left" valign="top"><?=USER($obj_fetch['USERID'])?></td>
    <td align="left" valign="top"><?=$obj_fetch['proposed_amt']?></td>
    <td align="left" valign="top"><?=dateprint($obj_fetch['posted_on'])?></td>
    <td align="center" valign="top">
    <?php /*?><a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=base64_encode($obj_fetch['id'])?>" onClick="return confirm('Are you sure to delete?')" title="Delete">Delete</a><?php */?>
<? if($obj_fetch['accept']=='0'){?>
Pending
<? }if($obj_fetch['accept']=='1'){?>
Rejected
<? }if($obj_fetch['accept']=='2'){?>
<a href="<?=$_SERVER['PHP_SELF']?>?pid=<?=$obj_fetch['id']?>">Confirm</a>
<? }if($obj_fetch['accept']=='3'){?>
Confirmed
<? }if($obj_fetch['accept']=='4'){?>
<span style="color:#E80000">Winner</span>
<br />
<?
	$where="user_id='".$obj_fetch['ADDUSERID']."' AND posted_by='".$_SESSION['user_id']."' AND add_id='".$obj_fetch['add_id']."'";
	$chk=Select_Qry("*",USER_FEEDBACK,$where,"","","","");
	if($chk=='')
	{
?>
<a href="post-feedback.php?u=<?=base64_encode($obj_fetch['ADDUSERID'])?>&add_id=<?=$obj_fetch['add_id']?>" class="">Feedback</a>
<?
	}
}
?>
</td>
  </tr>
  <tr><td colspan="6" style="border-bottom:1px dashed #CCCCCC;">&nbsp;</td></tr>
  <?
  	}
  ?>
  <tr><td align="right" valign="top" colspan="6"><? include_once('pageno.php');?></td></tr>
  <?
  }
  else
  {
  ?>
  <tr><td align="center" valign="top" colspan="6"><?=errormessage("No Bid History")?></td></tr>
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
