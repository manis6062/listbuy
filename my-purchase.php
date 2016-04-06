<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{
		Delete_Qry(ADVERTISE,"WHERE add_id='".$_REQUEST['id']."'");
		$msg="Deleted successfully";
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
><? include_once("top-menu.php")?>
</div-->
<p><span class="header_text_h">My Purchases </span><br />
  <br /> 
  Your recently purchased auction(s)
</p>
<p align="left">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td width="36%" class="rowhead" align="left">Title</td>
    <td width="12%" class="rowhead" align="center">Price($)</td>
    <td width="14%" class="rowhead" align="center">Created</td>
    <td width="14%" class="rowhead" align="center">Ends</td>
    <td width="12%" class="rowhead" align="center">Bids</td>
    <td width="12%" class="rowhead" align="center">Comments</td>
    </tr>
  <?
 	  $sql="SELECT * FROM ".ADVERTISE." WHERE winner_id='".$_SESSION['user_id']."' ORDER BY add_id DESC";          
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
				
  ?>
  <? if($arradv['site_img']==''){?>
  <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
    <td width="36%" align="left" class="txtLabel" valign="top" <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32"  /><? }?></td>
    <td width="262" align="left" valign="top" style="padding-left:5px;"><strong>Category:</strong> <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="./<?=remspace($arradv['add_id'])?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=$arradv['title']?></a><br /><a href="compose-message.php?add_id=<?=$arradv['add_id']?>"><strong>PM</strong></a></td>
  </tr>
</table></td>
    <td width="12%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$arradv['price']?></td>
    <td width="14%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['posted_on'])?></td>
    <td width="14%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['valid_till'])?></td>
    <td width="12%" align="center"  <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?php /*?><?=$bidcou['addID']?><br /><?php */?>
      <?=$bidcou['addID']?><br/>
	  <?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected</td>
    <td width="12%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$quescou['comm']?></td>
    </tr>
  <tr><td colspan="6" style="height:5px;"></td></tr>
  <? }else{?>
  <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
    <td width="36%" align="left" class="txtLabel" valign="top" <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32"  /><? }?></td>
    <td align="left" width="43"><a href="./<?=remspace($arradv['add_id'])?>"><img src="websiteImage/thumb<?=$arradv['site_img']?>" border="0" class="img_border" /></a></td>
    <td width="181" style="padding-left:5px;"><strong>Category:</strong> <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="./<?=remspace($arradv['add_id'])?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=$arradv['title']?></a><br /><a href="compose-message.php?add_id=<?=$arradv['add_id']?>"><strong>PM</strong></a></td>
  </tr>
</table></td>
    <td width="12%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$arradv['price']?></td>
    <td width="14%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['posted_on'])?></td>
    <td width="14%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=dateprint($arradv['valid_till'])?></td>
    <td width="12%" align="center"  <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?php /*?><?=$bidcou['addID']?><br /><?php */?>
      <?=$bidcou['addID']?><br/>
	  <?=$pending['PEND']?> Pending<br />
      <?=$reject['REJ']?> Rejected</td>
    <td width="12%" align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$quescou['comm']?></td>
    </tr>
  <tr><td colspan="6" style="height:5px;"></td></tr>
  <? }?>
  <?
	}
 ?>
<tr><td colspan="6" align="right" valign="top"><? include_once('pageno.php');?></td></tr> <?
 }else{
 ?>
 <tr><td colspan="6" align="center" valign="top"><?=errormessage("No Listings")?></td></tr>
 <?
 }
 ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
