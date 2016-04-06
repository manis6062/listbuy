<? 	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if($_REQUEST['user_id']!=''){
		$user_id=$_REQUEST['user_id'];
	}else{
		$user_id=$_SESSION['user_id'];
	}
	
	#$advarr=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	$feedbackprofile=Select_Qry("COUNT(id) as feeid",USER_FEEDBACK,"user_id='".$user_id."'","","","","");
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
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?PageNo="+eval(p1) ;
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
<p><span class="header_text_h"><?=WEB_ADDRESS?> Profile for <?=USERNAME($user_id)?></span>
  </p>
<p align="center">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
  <tr>
    <td colspan="2" align="left" valign="top">
	<? if($user_id !=$_SESSION['user_id']){?>
	<a href="compose-message.php?add_id=<?=$_REQUEST['add_id']?>&u=<?=$user_id?>&m=reply">Send <?=USERNAME($user_id)?> a private message</a>
	<?
	}
	?>
	</td>
  </tr>
  <tr>
    <td width="67%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="10" class="border">
  <tr>
    <td align="left" valign="top">
	<?
	if($feedbackprofile!="")
	{
	?>
	Feedback Score: <?=feedback($user_id)?>% 
	<?
	}
	else{
	?><br />
    This user has not yet received any feedback.
	<?
	}
	?></td>
  </tr>
</table>
</td>
	 <td width="33%" align="left" valign="top">
	 <table width="100%" border="0" cellspacing="0" cellpadding="5" class="border">
  <tr>
    <td colspan="2" align="center" valign="top" class="rowhead">Trust Rating: <?=feedback($user_id)?>%</td>
    </tr>
  <tr>
    <td width="63%" align="center" valign="middle"><a href="feedback-list.php?user_id=<?=$_REQUEST['user_id']?>">Feedback Profile</a></td>
    <td width="37%" align="right" valign="top"><img src="avatar/<?=AVATAR($user_id)!=""?'thumb_'.AVATAR($user_id):"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"></td>
  </tr>
</table>
</td>
    </tr>
  <tr>
    <td align="left" colspan="2" valign="top"><strong>Recent Listing</strong></td>
  </tr>
  <tr>
    <td align="left" colspan="2" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="5" class="border">
  <tr>
    <td width="60%" align="left" valign="top" class="rowhead">Title</td>
    <td width="10%" align="center" valign="top" class="rowhead">Status</td>
    <td width="11%" align="center" valign="top" class="rowhead">&nbsp;</td>
    <td width="19%" align="center" valign="top" class="rowhead">Ends</td>
  </tr>
  <?
  $sql="SELECT * FROM ".ADVERTISE." WHERE  user_id='".$user_id."' ORDER BY add_id DESC"; 
	$PageSize =30;	
	$StartRow =0;
	include_once('paging-top.php');
	if(mysql_num_rows($rs)>0)
	{
	$bgColor = "#ffffff";
	 for($i=0;$i<mysql_num_rows($rs);$i++)
	  { 
		$arrurpro=mysql_fetch_array($rs);
	?>
  <tr>
    <td align="left" valign="top"><a href="./<?=remspace($arrurpro['add_id'])?>"><?=$arrurpro['title']?></a></td>
    <td align="center" valign="top">
	<? if($arrurpro['status']==1 && $arrurpro['winner_id']==0){ 
	echo "Open"; 
	}elseif($arrurpro['status']==0 && $arrurpro['winner_id']==0){ 
	echo "Relist";
	}else{ 
	echo "Closed";}	?>	</td>
    <td align="center" valign="top" style="color:#FF0033;"><?=$arrurpro['status']=='2'?"SOLD":"UNSOLD"?></td>
    <td align="center" valign="top"><?php echo enddate($arrurpro['valid_till'])?></td></tr>
  <?  }  ?>
  <tr><td colspan="4" align="right" valign="top"><? include_once('pageno.php');?></td></tr>
  <?  }else{  ?>
   <tr><td colspan="4" align="center" valign="top"><?=errormessage("No advertise Available")?></td></tr>
  <?  }  ?>
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
