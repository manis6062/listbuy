<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	
	if($_REQUEST['mode']=='del') 
	 {	 	
		  Delete_Qry(SHORTLIST,"WHERE id='".$_REQUEST['id']."'"); /// delete msg 
	 }
	 //$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
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
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?add_id=<?=$_REQUEST['add_id']?>&PageNo="+eval(p1) ;
		document.frm.submit()
	}
</script></head>
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
<p style="height:42px;">&nbsp;</p>
<div style="vertical-align:top;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="3" align="left" width="100%" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td width="45%" valign="top"><a href="index.php">Fresh Auction</a> >> Shortlist for <?=USERNAME($_SESSION['user_id'])?></td>
    <td align="left" valign="top" style="border-left:1px solid #EBEBEB;">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="13%" align="left" valign="top"><img src="avatar/<?=AVATAR($_SESSION['user_id'])!=""?'thumb_'.AVATAR($_SESSION['user_id']):"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"></td>
    <td width="87%" align="left" valign="middle"><?=USERNAME($_SESSION['user_id'])?>(<a href="my-message.php?mode=inbox" class="user_menu">Private Messages</a>)<br />
      You have <?=CREDIT($_SESSION['user_id'])?> auction credits. <a href="buycredit.php" class="green">Buy more credits</a></td>
  </tr>
</table>

	</td>
  </tr>
</table>
</td></tr>
<tr><td colspan="3" align="right" width="100%" valign="top" style="height:5px;"></td></tr>
<tr><td colspan="3" align="right" width="100%" valign="top">
<table width="60%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td style="border-right:1px solid #EBEBEB;"><a href="short-list.php" class="user_menu">My Shortlist</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="subscription-list.php" class="user_menu">My Subscriptions</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="mylistings.php" class="user_menu">My Activity</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="my-account.php" class="user_menu">My Account</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="my-message.php?mode=inbox" class="user_menu">My Messages</a></td>
    <td><a href="logout.php" class="user_menu">Logout</a></td>
  </tr>
</table>
</td></tr>
</table>
</div>
<p align="center">
<form name="frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
<tr>
    <td align="left" colspan="2" valign="top" class="header_text_h">My Shortlist</td>
  </tr>
  <tr>
    <td align="left" colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" colspan="2" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="5" class="border">
  <tr>
    <td width="46%" align="left" valign="top" class="rowhead">Title</td>
    <td width="16%" align="center" valign="top" class="rowhead">Status</td>
    <td width="13%" align="center" valign="top" class="rowhead">Ends</td>
    <td width="10%" align="center" valign="top" class="rowhead">Remove</td>
  </tr>
  <?
      $sql="SELECT * FROM ".SHORTLIST." WHERE user_id='".$_SESSION['user_id']."' ORDER BY id DESC";          
	  $PageSize =30;	
	  $StartRow =0;
	  include_once('paging-top.php');
	  if(mysql_num_rows($rs)>0)
	  {
		$bgColor = "#ffffff";
		 for($i=0;$i<mysql_num_rows($rs);$i++)
		  { 
			$arrurpro=mysql_fetch_array($rs);
			$advarr=Select_Qry("*",ADVERTISE,"add_id='".$arrurpro['add_id']."'","","","","");
  ?>
  <tr>
    <td align="left" valign="top"><a href="./<?=remspace($arrurpro['add_id'])?>"><?=ADDTITLE($arrurpro['add_id'])?></a></td>
    <td align="center" valign="top">
	<? if($advarr['status']==1){
		  echo "Open";
		}
	   elseif($advarr['status']==0)
	   {
	   	echo "Relist";
	   }
	   else
	   {
	   	echo "Closed";
	   }
	?></td>
    <td align="center" valign="top"><?=$advarr['status']==2?'Ended':enddate($advarr['valid_till'])?></td>
    <td align="center" valign="top"><a href="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>&mode=del&id=<?=$Ques['id']?>" onClick="return confirm('Are you sure want to remove this shortlist?')">Remove</a></td>
  </tr>
  <?
  }
  ?>
  <tr><td colspan="4" align="right" valign="top"><? include_once('pageno.php');?></td></tr>
  <?
  }else
  {
  ?>
   <tr><td colspan="4" align="center" valign="top"><?=errormessage("No Short Listed!")?></td></tr>
  <?
  }
  ?>
</table></td>
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
