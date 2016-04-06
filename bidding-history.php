<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');	
	if(isset($_REQUEST['btnsubmit']))
		{
		$objprop=Select_Qry("*",PROPOSAL,"id='".$_REQUEST['id']."'","","","","");
		$site=Select_Qry("*",ADVERTISE,"add_id='".$objprop['add_id']."'","","","","");
		//$propuser=Select_Qry("*",USER,"user_id='".$objprop['user_id']."'","","","","");
		//$siteuser=Select_Qry("*",USER,"user_id='".$site['user_id']."'","","","","");
		//$investormsg="Your proposal has been selected by the advertise owner. The advertise title is : <strong>$site[title]</strong>. ";
		
		Update_Qry(PROPOSAL," accept='1'","WHERE id<>'".$_REQUEST['id']."' AND add_id='".$site['add_id']."'");
		Update_Qry(PROPOSAL," accept='2'","WHERE id='".$_REQUEST['id']."'");
		Update_Qry(ADVERTISE," winner_id='".$objprop['user_id']."',status='2'","WHERE add_id='".$objprop['add_id']."'");
		
		############### mail to buyer ########
		$mail_From=ADMIN_EMAIL;
		$mail_subject="Your bid for ".ADDTITLE($objprop['add_id'])." has been accepted at ".WEB_ADDRESS;
		$mail_To=USEREMAIL($objprop['user_id']);
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
			<td width="100%">Dear: '.USERNAME($objprop['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">Your bid for '.ADDTITLE($objprop['add_id']).' has been accepted at '.WEB_ADDRESS.'</td>
			</tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">Click here to logon to our site <a href="http://'.WEB_ADDRESS.'">http://'.WEB_ADDRESS.'/login.php</a>
</td></tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">
			Best Regards,
			</td>
			</tr>
			<tr>
			<td width="100%">'.WEB_ADDRESS.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
			
			################### mail to seller #########
		$mail_From=ADMIN_EMAIL;
		$mail_subject="You have accepted a bid for ".ADDTITLE($site['add_id'])." at ".WEB_ADDRESS; 
		$mail_To=USEREMAIL($site['user_id']);
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
			<td width="100%">Dear: '.USERNAME($site['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">You have accepted a bid for '.ADDTITLE($site['add_id']).' at '.WEB_ADDRESS.'</td>
			</tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">
			Best Regards,
			</td>
			</tr>
			<tr>
			<td width="100%">'.WEB_ADDRESS.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
			
		
		$buyer=Select_Qry("*",USER,"user_id='".$objprop['user_id']."'","","","","");
		$seller=Select_Qry("*",USER,"user_id='".$site['user_id']."'","","","","");	
		$title1="You have purchased a listing for ".ADDTITLE($site['add_id'])." at ".WEB_ADDRESS;
		$title2="Your listing for ".ADDTITLE($site['add_id'])." has been sold at ".WEB_ADDRESS;
		
		$body2="<p>Dear ".USERNAME($objprop['user_id']).",</p>
		<p>Below you will find the contact details of the buyer.</p>
		<p>&nbsp;</p>
		<p>
		<table style='height: 232px;' border='0' cellspacing='3' cellpadding='3' width='433' align='left'>
		<tbody>
		<tr>
		<td>Name</td>
		<td>:</td>
		<td>".USERNAME($buyer['user_id'])."</td>
		</tr>
		<tr>
		<td>Street Addrees</td>
		<td>:</td>
		<td>".$buyer['st_add']."</td>
		</tr>
		<tr>
		<td>City</td>
		<td>:</td>
		<td>".$buyer['city']."</td>
		</tr>
		<tr>
		<td>State</td>
		<td>:</td>
		<td>".STATE($buyer['state'])."</td>
		</tr>
		<tr>
		<td>Zip</td>
		<td>:</td>
		<td>".$buyer['zip']."</td>
		</tr>
		<tr>
		<td>Country</td>
		<td>:</td>
		<td>".COUNTRY($buyer['country'])."</td>
		</tr>
		<tr>
		<td>Email</td>
		<td>:</td>
		<td>".$buyer['email']."</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>Thank You,</p>
		<p>".WEB_ADDRESS."</p>
		<p>&nbsp;</p>";
				
		
		$body1="<p>Dear ".USERNAME($buyer['user_id']).",</p>
		<p>Please view the details of seller below.</p>
		<p>&nbsp;</p>
		<p>
		<table style='height: 232px;' border='0' cellspacing='3' cellpadding='3' width='433' align='left'>
		<tbody>
		<tr>
		<td>Name</td>
		<td>:</td>
		<td>".USERNAME($seller['user_id'])."</td>
		</tr>
		<tr>
		<td>Street Addrees</td>
		<td>:</td>
		<td>".$seller['st_add']."</td>
		</tr>
		<tr>
		<td>City</td>
		<td>:</td>
		<td>".$seller['city']."</td>
		</tr>
		<tr>
		<td>State</td>
		<td>:</td>
		<td>".STATE($seller['state'])."</td>
		</tr>
		<tr>
		<td>Zip</td>
		<td>:</td>
		<td>".$seller['zip']."</td>
		</tr>
		<tr>
		<td>Country</td>
		<td>:</td>
		<td>".COUNTRY($seller['country'])."</td>
		</tr>
		<tr>
		<td>Email</td>
		<td>:</td>
		<td>".$seller['email']."</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>Thank You,</p>
		<p>".WEB_ADDRESS."</p>
		<p>&nbsp;</p>";
		Send_HTML_Mail($buyer['email'], ADMIN_EMAIL, '', $title1, $body1);
		Send_HTML_Mail($seller['email'], ADMIN_EMAIL, '', $title2, $body2);	
			
		}
		
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		Delete_Qry(PROPOSAL,"WHERE id='".base64_decode($_REQUEST['id'])."'");
		$msg=successfulMessage("The bid has been deleted successfully!");
	}
	
	############# FOR REJECTED ###############
	##########################################
	
	if(isset($_REQUEST['proaccpid'])!="")
	{
	Update_Qry(PROPOSAL,"accept='1'","WHERE id='".$_REQUEST['proaccpid']."'");
	
	$objprorej=Select_Qry("*",PROPOSAL,"id='".$_REQUEST['proaccpid']."'","","","","");
		$siteowner=Select_Qry("*",ADVERTISE,"add_id='".$objprorej['add_id']."'","","","","");
	
	############### mail to buyer ########
		$mail_From=ADMIN_EMAIL;
		$mail_subject="Your bid for ".ADDTITLE($objprop['add_id'])." has been rejected at ".WEB_ADDRESS;
		$mail_To=USEREMAIL($objprorej['user_id']);
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
			<td width="100%">Dear: '.USERNAME($objprorej['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">Your bid for '.ADDTITLE($objprorej['add_id']).' has been rejected at '.WEB_ADDRESS.'</td>
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
			<td width="100%">'.WEB_ADDRESS.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
			
			################### mail to seller #########
		$mail_From=ADMIN_EMAIL;
		$mail_subject="You have rejected a bid for ".ADDTITLE($siteowner['add_id'])." at ".WEB_ADDRESS; 
		$mail_To=USEREMAIL($siteowner['user_id']);
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
			<td width="100%">Dear: '.USERNAME($siteowner['user_id']).'</td>
			</tr>
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">You have rejected a bid for '.ADDTITLE($siteowner['add_id']).' at '.WEB_ADDRESS.'</td>
			</tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">
			Best Regards,
			</td>
			</tr>
			<tr>
			<td width="100%">'.WEB_ADDRESS.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
	
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
<script type="text/javascript" src="js/ajax_getconfirm.js"></script>
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
<div id="container">
<? include_once("left-menu.php");?>
<div id="content">
    
    <div class="header_top">
    <? include_once("cart-info.php");?>
    </div>
    

<div class="clear"></div>

    
<!--div class="menu_top">
<? include_once("top-menu.php")?>
</div-->
<p><span class="header_text_h">Bidding History  </span>
  </p>
<p align="center">
<form name="frm" method="post" action="">
<input type="hidden" name="id" value="" />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
 
  <tr>
    <td align="center" valign="top"  id="dispconfirm"><?=$msg?></td>
    </tr>
	
	<tr><td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="border">
 
  <tr>
    <td width="23%" align="left" valign="top" class="rowhead">Advertise Title </td>
    <td width="16%" align="left" valign="top" class="rowhead">Total Amount($)</td>
    <td width="14%" align="left" valign="top" class="rowhead">Proposed By </td>
    <td width="15%" align="left" valign="top" class="rowhead">Proposed Amount </td>
    <td width="14%" align="left" valign="top" class="rowhead">Posted On </td>
    <td width="18%" align="left" valign="top" class="rowhead">Action</td>
  </tr>
  <?
  			$PageSize =30;	
            $StartRow = 0;
           	$sql="SELECT p.id,p.user_id as USERID,p.add_id,p.proposed_amt,p.posted_on,p.accept,a.title,a.price,a.length,a.status FROM ".PROPOSAL." AS p LEFT JOIN ".ADVERTISE." AS a ON p.add_id=a.add_id WHERE a.user_id='".$_SESSION['user_id']."' ORDER BY p.id DESC ";
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
    <td align="left" valign="top"><a href="./<?=remspace($obj_fetch['title'])?>"><?=substr(strip_tags($obj_fetch['title']),0,100)?></a></td>
    <td align="left" valign="top"><?=$obj_fetch['price']?></td>
    <td align="left" valign="top"><?=USER($obj_fetch['USERID'])?></td>
    <td align="left" valign="top"><?=$obj_fetch['proposed_amt']?></td>
    <td align="left" valign="top"><?=dateprint($obj_fetch['posted_on'])?></td>
    <td align="left" valign="top">
	 <? if($obj_fetch['accept']=='0'){?>
	 <a href="javascript: void(0)" onClick="showConfirm('<?=$obj_fetch['id']?>','accept')">Accepted</a>
	| <a href="<?=$_SERVER['PHP_SELF']?>?proaccpid=<?=$obj_fetch['id']?>">Rejected</a>
	 <? }?>
	 
	 <? if($obj_fetch['accept']=='2') echo "<br><span class='error'>Winner</span>"; 
	  if($obj_fetch['accept']=='0') echo "<br>Pending"; if($obj_fetch['accept']=='1') echo "<br>Rejected";  
	  
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
  <tr><td align="center" valign="top" colspan="6"><?=errormessage("No Listings")?></td></tr>
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
