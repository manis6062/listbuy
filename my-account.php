<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{
		Delete_Qry(ADVERTISE,"WHERE add_id='".$_REQUEST['id']."'");
		$msg="deleted successfully!";
	}
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="cancel"))
	{
		Update_Qry(ADVERTISE,"status='3'","WHERE add_id='".$_REQUEST['id']. "'");
	}
	########## message delete #############
	if(isset($_REQUEST['mode2']) && $_REQUEST['mode2']=='del')
	{
		Delete_Qry(INBOX,"WHERE id='".$_REQUEST['mid']."'");
	}
	
	if($_REQUEST['mode3'] == 'delall')
	{		
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			Delete_Qry(INBOX,"WHERE id ='".$_REQUEST['chk'][$i]."'");
		}
	}
	
	
	$obj_record=Select_Qry("*",USER,"user_id='".$_SESSION['user_id']."'","","","","");
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
function AllSelect()
   {
	var flag=false;
	if(document.frm.chk_all.checked==true)
	{
		flag=true;
	}
	else
	{
		flag=false;
	}
	if(flag==true)
	{
		for(var i=0;i<document.frm.elements.length;i++)
		{ 
			if(document.frm.elements[i].type=="checkbox")
			{
				document.frm.elements[i].checked=true;
			}  
		}
	}
	if(flag==false)
	{
		for(var i=0;i<document.frm.elements.length;i++)
		{ 
			if(document.frm.elements[i].type=="checkbox")
			{
				document.frm.elements[i].checked=false;
			}  
		}
	}
   }
	function deselect_any()
	{
	  var tag=false;
	  for(var i=0;i<document.frm.elements.length;i++)
	   { 
		   if(document.frm.elements[i].type=="checkbox")


		     {
		    	if(document.frm.elements[i].checked==false)
			      {
		    		document.frm.chk_all.checked=false;
			      }
		     }  
	  }
	}  		
	function Confirm(status)
    {
       var flag=0;
	   for(var i=0;i<document.frm.elements.length;i++)
       	{ 
		   if(document.frm.elements[i].type=="checkbox" && document.frm.elements[i].checked==true)
		     {
			   flag=flag+1;
		     }  
	    }
	   if(flag==0)
	    {
	       alert("Select any Message");
	       return false;
	    }
	   else
	    {
	       var con = confirm("Are You Sure?")
	       if(con)
		    {
			document.frm.action='<?=$_SERVER['PHP_SELF']?>?mode3='+status;
		   		document.frm.submit();
				//return true;
		    }
			else 
			{
			  return false;
			}
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
<p><span class="header_text_h">My Account</span><br />
</p>
<p style="vertical-align:top;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
</table>
  </p>
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
  <td width="20%" align="center" valign="top"><img src="avatar/<?=$obj_record['avatar']!=""?'thumb_'.$obj_record['avatar']:"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"><br /><br /><a href="edit-profile.php">Edit Profile</a><br /><br /><a href="change-password.php">Modify password</a></td>
    <td width="80%" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
    <td colspan="2" align="left" valign="top" class="title">Current balance: <span class="redbold"><?=CREDIT($_SESSION['user_id'])?></span></td>
    </tr>
  <tr>
    <td width="32%" align="left" valign="top" class="txtLabel">Username</td>
    <td width="68%" align="left" valign="top"><?php echo $obj_record['username']?></td>
    </tr>
 
  <tr>
    <td align="left" valign="top" class="txtLabel">Email</td>
    <td align="left" valign="top"><?php echo $obj_record['email']?></td>
  </tr>
 
</table></td>
  </tr>
</table></td>
    </tr>
	<tr><td align="left" valign="top" class="des">My Activity</td></tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td width="25%" class="rowhead" align="left">Title</td>
    <td width="11%" class="rowhead" align="center">Asking Price</td>
    <td width="9%" class="rowhead" align="center">Bid Amount</td>
    <td width="7%" class="rowhead" align="center">Created</td>
    <td width="7%" class="rowhead" align="center">Ends</td>
    <td width="10%" class="rowhead" align="center">Bids</td>
    <td width="9%" class="rowhead" align="center">Comments</td>
    <td width="9%" class="rowhead" align="center">Upgrades</td>
    <td width="13%" class="rowhead" align="center">Options</td>
  </tr>
  <?
  $slNo=0;
 	  $rs=mysql_query("SELECT * FROM ".ADVERTISE." WHERE user_id='".$_SESSION['user_id']."'  ORDER BY add_id DESC LIMIT 0,4");          
	  //$PageSize =30;	
	  //$StartRow =0;
	  //include_once('paging-top.php');
	  if(mysql_num_rows($rs)>0)
		{
			$bgColor = "#ffffff";
			 for($i=0;$i<mysql_num_rows($rs);$i++)
			  { 
			  $slNo++;
				$arradv=mysql_fetch_array($rs);
				$quescou=Select_Qry("COUNT(id) as comm",QUESTION,"add_id='".$arradv['add_id']."'","","","","");
				$bidcou=Select_Qry("COUNT(id) as addID",PROPOSAL,"add_id='".$arradv['add_id']."'","","","","");
		        $pending=Select_Qry("COUNT(id) as PEND",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='0'","","","","");
				$reject=Select_Qry("COUNT(id) as REJ",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='1'","","","","");
		
		$accept_bin=Select_Qry("*",BIN,"add_id='".$arradv['add_id']."'","","","","");
				
  ?>
  <? if((CATEGORY_ADD($arradv['cat_id'])=='1') && ($arradv['site_img']=='')){?>
  <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
    <td width="25%" align="left" class="txtLabel" valign="top" <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32" /><? }?></td>
    <td width="268" style="padding-left:5px"><strong>Category:</strong> <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="./<?=remspace($arradv['add_id'])?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=$arradv['title']?></a></td>
  </tr>
</table></td>
    <td width="11%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>-</td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>-</td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['posted_on'])?></td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['valid_till'])?></td>
    <td width="10%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>-<?php /*?><?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected<?php */?></td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$quescou['comm']?></td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><? if($arradv['status']=='0' || $arradv['status']=='1'){?><? if($arradv['bold'] != '1' || $arradv['highlight'] != '1' || $arradv['featured'] != '1' || $arradv['rowborder'] != '1') { ?><a href="listing-upgrades.php?add_id=<?=$arradv['add_id']?>">Upgrade</a><? } else{ echo "-"; }?><? }?></td>
    <td width="13%" align="center" <? if($arradv['rowborder']==1){?>style="border-right:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
	<a href="editlisting.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Edit</a> <?php /*?>| <a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=$arradv['add_id']?>" onclick="return confirm('Are you Sure?');">Delete</a><?php */?><? }?>
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
     <br /> <a href="attachment.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Attachment</a> <? }?> <? if($arradv['status']==0){?><br /><a href="relist.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Relist</a><? }?>  
	  <? if($arradv['status']==3){?>
	  <br />
	  <span class="error"><strong>Cancelled</strong></span>
	  <? }else{?>
	  <br /><a href="<?=$_SERVER['PHP_SELF']?>?mode=cancel&id=<?=$arradv['add_id']?>" onclick="return confirm('Are you want to cancel this listing?');" class="user_menu">Cancel</a>
	  <? }?></td>
  </tr>
  <tr><td colspan="9" style="border-bottom:1px dashed #CCCCCC;"></td></tr>
  <? }else{?>
  <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
    <td width="25%" align="left" class="txtLabel" valign="top"  <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32" /><? }?></td>
    <td width="56"><a href="./<?=remspace($arradv['add_id'])?>-<?=EdURL(substr(strip_tags($arradv['title']),0,50))?>.html"><img src="websiteImage/thumb<?=$arradv['site_img']?>" border="0" class="img_border" /></a></td>
    <td width="415" valign="top" style="padding-left:5px;" align="left">Category: <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="details.php?add_id=<?=$arradv['add_id']?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=substr(strip_tags($arradv['title']),0,50)?></a></td>
  </tr>
</table></td>
    <td width="11%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$arradv['asking_price']?></td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	<? if($arradv['status']==2){
			$acbin=Select_Qry("bin_amt, COUNT(id) as ACCBIN",BIN,"accept >'1' AND add_id ='".$arradv['add_id']."'","","","","");
			if($acbin['ACCBIN'] >0){
			$price=$acbin['bin_amt'];
			}else {
			$price=$arradv['price'];
			}
	  	}else{
		$price=$arradv['price'];
		}
	  ?>
	  <?=$price?>
	
	</td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['posted_on'])?></td>
    <td width="7%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['valid_till'])?></td>
    <td width="10%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	<?
	if($arradv['winner_id']=="0")
	{
	?>
	<?=$bidcou['addID']?><br/>
	[
	<a href="received-bids.php#<?=$arradv['add_id']?>"><?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected</a>]<?
	  }else{
	  ?><span style="color:#FF0033">Sold</span><? }?>
	  
	  <?php /*?><?
	  if($accept_bin['accept']=='2' ||  $arradv['winner_id']!='0')
	  {
	  ?><span style="color:#FF0033">Sold</span><? } else {?>
	  <?=$bidcou['addID']?><br/>
	[
	<a href="received-bids.php#<?=$arradv['add_id']?>"><?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected</a>] <? }?><?php */?>
	  </td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$quescou['comm']?></td>
    <td width="9%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><? if($arradv['status']=='0' || $arradv['status']=='1'){?><? if($arradv['bold'] != '1' || $arradv['highlight'] != '1' || $arradv['featured'] != '1' || $arradv['rowborder'] != '1' AND $arradv['winner_id']=='0') { ?><a href="listing-upgrades.php?add_id=<?=$arradv['add_id']?>">Upgrade</a><? } else{ echo "-"; }?><? }?></td>
    <td width="13%" align="center" <? if($arradv['rowborder']==1){?>style="border-right:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
	<a href="editlisting.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Edit</a> <?php /*?>| <a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=$arradv['add_id']?>" onclick="return confirm('Are you Sure?');">Delete</a><?php */?><? } ?> <br />
	<?
	if($arradv['status']=='0' || $arradv['status']=='1'){
	?>
      <br /><a href="attachment.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Attachment</a>
	  <br /><a href="<?=$_SERVER['PHP_SELF']?>?mode=cancel&id=<?=$arradv['add_id']?>" onclick="return confirm('Are you want to cancel this listing?');" class="user_menu">Cancel</a>
	  <? }?> 
	  
	  <? if($arradv['status']==0){?><br /><a href="relist.php?add_id=<?=$arradv['add_id']?>" class="user_menu">Relist</a><? }?> <? if($arradv['status']==3){?><br />
      <span class="error"><strong>Cancelled</strong></span><? }?><? if($arradv['winner_id']!='0' && $arradv['status']=='2'){ 
	   $where="user_id='".$arradv['winner_id']."' AND posted_by='".$_SESSION['user_id']."' AND add_id='".$arradv['add_id']."'";
		$chk=Select_Qry("*",USER_FEEDBACK,$where,"","","","");
		if($chk=='')
		{?><br /><a href="post-feedback.php?u=<?=base64_encode($arradv['winner_id'])?>&add_id=<?=$arradv['add_id']?>" class="user_menu">Feedback</a><? } }?> <br />
	  
	 <? if($accept_bin['accept']=='2') {?> Not Paid <? } if($accept_bin['accept']=='3') {?><span style="color:#FF0033">Paid</span><? }?>	 
	  </td>
  </tr>
  
  <? }?>
  <tr><td colspan="9" style="border-bottom:1px dashed #CCCCCC;">&nbsp;</td></tr>
  <?
  if($slNo>4)
  {
  ?>
  <tr><td colspan="9" align="right"><a href="mylistings.php">View Details</a></td></tr>
  <?
  }
	}
 
 }else{
 ?>
 <tr><td colspan="9" align="center" valign="top"><?=errormessage("No Listings")?></td></tr>
 <?
 }
 ?>
  
</table></td>
</tr>
	
</table>
	</td></tr>
    </tr>
	
  
</table>
</td>
  </tr>
   <?
    $sql_feedback=mysql_query("SELECT * FROM ".USER_FEEDBACK." WHERE user_id='".$_SESSION['user_id']."' ORDER BY id DESC");
	if(mysql_num_rows($sql_feedback)>0)
	{

	?>
  <tr><td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%" align="left" valign="top" class="des">Feedback(s) Received</td>
    <td width="47%" align="right" valign="top"><strong>Feedback Score: <?=feedback($_SESSION['user_id'])?>% </strong></td>
  </tr>
</table>
</td></tr>
  <tr><td align="left" valign="top">
  <table cellpadding="3" cellspacing="0" width="100%">
      <?
			for($i=0;$i<mysql_num_rows($sql_feedback);$i++)
		{
			$obj_fetch=mysql_fetch_array($sql_feedback);
?>
      <tr><td align="left" valign="top" style="border-bottom:1px solid #D5D5D5;"><a href="./<?=remspace($obj_fetch['add_id'])?>"><strong><?=ADDTITLE($obj_fetch['add_id'])?></strong></a>
        <br>
        <strong>Feedback Score :</strong> <?=getrate($obj_fetch['rate'])?>&nbsp;|&nbsp;<strong>By : </strong><?=USER($obj_fetch['posted_by'])?><br>
<br>
<strong>Feedback Details : </strong><?=$obj_fetch['comment']?><br><strong>Posted On : </strong><?=dateprint($obj_fetch['posted_on'])?></td>
      </tr>
<? }  ?>      
      </table>
  </td></tr>
  <? }?>
</table>
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
