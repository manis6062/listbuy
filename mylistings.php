<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{
		Delete_Qry(ADVERTISE,"WHERE add_id='".$_REQUEST['id']."'");
		$msg="Deleted Successfully!";
	}
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="cancel"))
	{
		Update_Qry(ADVERTISE,"status='3'","WHERE add_id='".$_REQUEST['id']. "'");
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
<p><span class="header_text_h">My Listings </span><br />
</p>
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td width="26%" class="rowhead" align="left">Title</td>
    <td width="10%" class="rowhead" align="center">Your Price</td>
    <td width="7%" class="rowhead" align="center">Current Bids</td>
    <td width="8%" class="rowhead" align="center">Started</td>
    <td width="7%" class="rowhead" align="center">Ends</td>
    <td width="9%" class="rowhead" align="center">Bids</td>
    <td width="8%" class="rowhead" align="center">Comments</td>
    <td width="7%" class="rowhead" align="center">Upgrades</td>
    <td width="18%" class="rowhead" align="center">Options</td>
  </tr>
  <?
 	  $sql="SELECT * FROM ".ADVERTISE." WHERE user_id='".$_SESSION['user_id']."' ORDER BY add_id DESC";          
	  $PageSize =30;	
	  $StartRow =0;
	  include_once('paging-top.php');
	  if(mysql_num_rows($rs)>0)
		{
			$bgColor = "#ffffff";
			 for($i=0;$i<mysql_num_rows($rs);$i++)
			  { 
				$arradv=mysql_fetch_array($rs);
				$quescou=Select_Qry("COUNT(id) as comm",QUESTION,"add_id='".$arradv['add_id']."'","","","","");
				$bidcou=Select_Qry("COUNT(id) as addID",PROPOSAL,"add_id='".$arradv['add_id']."'","","","","");
				$pending=Select_Qry("COUNT(id) as PEND",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='0'","","","","");
				$reject=Select_Qry("COUNT(id) as REJ",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='1'","","","","");
				$usrfeedback=Select_Qry("*",USER_FEEDBACK," add_id='".$arradv['ad_id']."' AND user_id='".$_SESSION['user_id']."'","","","","");
				$usr=Select_Qry("*",USER," user_id='".$usrfeedback['posted_by']."' AND status='1'","","","","");
	$accept_bin=Select_Qry("*",BIN,"add_id='".$arradv['add_id']."'","","","","");
  ?>
  <? if((CATEGORY_ADD($arradv['cat_id'])=='1') && $arradv['site_img']==''){?>
  <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
    <td width="26%" align="left" class="txtLabel" valign="top" <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32"/><? }?></td>
    <td width="262" align="left" valign="top" style="padding-left:5px;">Category: <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="./<?=remspace($arradv['add_id'])?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=$arradv['title']?></a></td>
  </tr>
</table></td>
    <td width="10%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>-</td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>-</td>
    <td width="8%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['posted_on'])?></td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['valid_till'])?></td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?php /*?><?=$bidcou['addID']?><br /><?php */?>-
     <?php /*?> <?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected<?php */?></td>
    <td width="8%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$quescou['comm']?></td>
    <td width="7%" align="left" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><? if($arradv['status']=='0' || $arradv['status']=='1'){?><? if($arradv['bold'] != '1' || $arradv['highlight'] != '1' || $arradv['featured'] != '1' || $arradv['rowborder'] != '1') { ?><a href="listing-upgrades.php?add_id=<?=$arradv['add_id']?>">Upgrade</a><? } else{ echo "-"; }?><? }?></td>
    <td width="18%" align="center" <? if($arradv['rowborder']==1){?>style="border-right:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
	<a href="editlisting.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Edit</a> <!--| <a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=$arradv['add_id']?>" onclick="return confirm('Are you Sure?');">Delete</a>--><? }?><br />
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
      <br /><a href="attachment.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Attachment</a>
	  <br /><a href="<?=$_SERVER['PHP_SELF']?>?mode=cancel&id=<?=$arradv['add_id']?>" onclick="return confirm('Confirm that you wish to cancel the listing');" class="user_menu"><span class="error">Cancel</span></a>
	  <? }?> <? if($arradv['status']==0){?><br /><a href="relist.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Relist</a><? }?> <? if($arradv['status']==3){?><br />
      <span class="error"><strong>Cancelled</strong></span><? }?></td>
  </tr>
  <tr><td colspan="9" style="height:5px;"></td></tr>
  <? }else{?>
  <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
    <td width="26%" align="left" class="txtLabel" valign="top" <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="16" width="16"/><? }?> </td>
    <td align="left" width="43"><a href="details.php?add_id=<?=$arradv['add_id']?>"><img src="websiteImage/thumb<?=$arradv['site_img']?>" border="0" class="img_border" /></a></td>
    <td width="181" style="padding-left:5px;">Category: <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="details.php?add_id=<?=$arradv['add_id']?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=substr(strip_tags($arradv['title']),0,50)?></a>
      </td>
  </tr>
</table></td>
    <td width="10%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$arradv['asking_price']?></td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	
	<?  if($arradv['status']==2){
			$acbin=Select_Qry("bin_amt, COUNT(id) as ACCBIN",BIN,"accept > '1' AND add_id ='".$arradv['add_id']."'","","","","");
			if($acbin['ACCBIN'] >0){
			$price=$acbin['bin_amt'];
			}else {
			$price=$arradv['price'];
			}
	  	}else{
		$price=$arradv['price'];
		}
	  ?>
	  <?=$price ?>
	</td>
    <td width="8%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['posted_on'])?></td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['valid_till'])?></td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?php /*?><?=$bidcou['addID']?><br /><?php */?>
     
	<?
	if($arradv['winner_id']=="0")
	{
	?>
	<?=$bidcou['addID']?><br/>[
	<a href="received-bids.php#<?=$arradv['add_id']?>"><?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected</a>]
	  <?
	  } else{
	  ?><span style="color:#FF0033">Sold</span><? }?>
	 <?php /*?> <? 
	   if($accept_bin['accept']=='2' ||  $arradv['winner_id']!='0')
	   {
	  ?>
	  <span style="color:#FF0033">Sold</span><? } else{?>
	  
	  <?=$bidcou['addID']?><br/>[
	<a href="received-bids.php#<?=$arradv['add_id']?>"><?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected</a>]
	   <? }?><?php */?>
	  
	  </td>
    <td width="8%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$quescou['comm']?></td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><? if($arradv['status']=='0' || $arradv['status']=='1'){?><? if($arradv['bold'] != '1' || $arradv['highlight'] != '1' || $arradv['featured'] != '1' || $arradv['rowborder'] != '1') { ?><a href="listing-upgrades.php?add_id=<?=$arradv['add_id']?>">Upgrade</a><? } else{ echo "-"; }?><? }?></td>
    <td width="18%" align="center" <? if($arradv['rowborder']==1){?>style="border-right:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
	<a href="editlisting.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Edit</a> <!--| <a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=$arradv['add_id']?>" onclick="return confirm('Are you Sure?');">Delete</a>--><? } ?><br />
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
     <br /> <a href="attachment.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Attachment</a> 
	 <br /><a href="<?=$_SERVER['PHP_SELF']?>?mode=cancel&id=<?=$arradv['add_id']?>" onclick="return confirm('Are you want to cancel this listing?');" class="user_menu"><span class="error">Cancel</span></a><? }?> 
	 
	 <? if($arradv['status']==0){?>
	 <br /><a href="relist.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Relist</a>
 
	 <? }?> 
	 
<? if($arradv['winner_id']!='0' && $arradv['status']==2){
	 	$where="user_id='".$arradv['winner_id']."' AND posted_by='".$_SESSION['user_id']."' AND add_id='".$arradv['add_id']."'";
		$chk=Select_Qry("*",USER_FEEDBACK,$where,"","","","");
		if($chk=='')
		{
?><br /><a href="post-feedback.php?u=<?=base64_encode($arradv['winner_id'])?>&add_id=<?=$arradv['add_id']?>" class="user_menu">Feedback</a>

<? } }?> 
	  <? if($arradv['status']==3){?>
	  <br /><span class="error"><strong>Cancelled</strong></span>
	
	  
	  <? } ?><br /><? if($accept_bin['accept']=='2') {?> Not Paid <? } if($accept_bin['accept']=='3') {?><span style="color:#FF0033">Paid</span><? }?>	</td>
  </tr>
  <tr><td colspan="9" style="height:5px;"></td></tr>
  <? }?>
  <?
	}
 ?>
<tr><td colspan="9" align="right" valign="top"><? include_once('pageno.php');?></td></tr> <?
 }else{
 ?>
 <tr><td colspan="9" align="center" valign="top"><?=errormessage("No Listings")?></td></tr>
 <?
 }
 ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
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
