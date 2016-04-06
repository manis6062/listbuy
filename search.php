<?
	require_once('config/config.php');
	$where="";
	if($_REQUEST['cat_id']!="")
	{
		$where.=" AND cat_id='".$_REQUEST['cat_id']."'";
	}
	if($_REQUEST['keytxt']!="")
	{		
		$where.=" AND (price like '%".escapeQuotes(stripslashes($_REQUEST['keytxt']))."%' OR title like '%".escapeQuotes(stripslashes($_REQUEST['keytxt']))."%')";
		//echo $where;
	}
	if($_REQUEST['category']=='BIN'){
			if($_REQUEST['bin1']!="")
			{
			$where.=" order by buyer_price DESC ,add_id DESC ";
			}
			else
			{
			$where.=" order by buyer_price ASC ,add_id DESC";
			}
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
<? include_once("toppage1.php");?>
<body>
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
<p><span class="header_text_h">Browse All Listings!</span></p>
<p align="left">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td width="39%" class="rowhead" align="left">Title</td>
    <td width="16%" class="rowhead" align="center">Current Bid</td>
    <td width="10%" class="rowhead" align="center"># of Bids</td>
    <td width="12%" class="rowhead" align="center">Questions</td>
    <td width="11%" class="rowhead" align="center">Ends</td>
    <td  class="rowhead" align="center">
    <? if($_REQUEST['category']=="BIN" && $_REQUEST['bin1']=="" ) {  ?><a href="<?=$_SERVER['PHP_SELF']?>?category=BIN&bin1=desc">BIN</a>
<? } elseif($_REQUEST['category']=="BIN" && $_REQUEST['bin1']=="desc" ) { ?> <a href="<?=$_SERVER['PHP_SELF']?>?category=BIN">BIN</a> 
<? } else { ?> <a href="<?=$_SERVER['PHP_SELF']?>?category=BIN">BIN</a> <? } ?></td> 
    </tr>
  <?
 	 $sql="SELECT * FROM ".ADVERTISE." WHERE status='1' ".$where." ";          
	  $PageSize =30;	
	  $StartRow =0;
	  include_once('paging-top.php');
	  if(mysql_num_rows($rs)>0)
		{
			$bgColor = "#ffffff";
			 for($i=0;$i<mysql_num_rows($rs);$i++)
			  { 
				$arradv=mysql_fetch_array($rs);
				$countBid=Select_Qry("COUNT(id) AS bid",PROPOSAL,"add_id='".$arradv['add_id']."'","","","","");
				$countprop=Select_Qry("COUNT(id) AS cid",QUESTION,"add_id='".$arradv['add_id']."'","","","","");
				
			$pending=Select_Qry("COUNT(id) as PEND",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='0'","","","","");
				$reject=Select_Qry("COUNT(id) as REJ",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='1'","","","","");
  ?>
  <? if((CATEGORY_ADD($arradv['cat_id'])=='1') && ($arradv['site_img']=='')){?>
  <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>><td align="left" valign="top" colspan="5" <? if($arradv['rowborder']==1){?>class="rowborder"<? }?>>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td width="39%" align="left" class="txtLabel" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32"/><? }?></td>
    <td width="287" align="left" style="padding-left:5px;"><strong>Category:</strong> <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="./<?=remspace($arradv['add_id'])?>-<?=EdURL(substr(strip_tags($arradv['title']),0,40))?>.html" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=substr(strip_tags($arradv['title']),0,40)?></a></td>
  </tr>
</table>
</td>
    <td width="16%" align="center">-<?php /*?><?=$arradv['price']?><?php */?></td>
    <td width="10%" align="center">-<?php /*?><?=$countBid['bid']?><?php */?></td>
    <td width="12%" align="center"><?=$countprop['cid']?></td>
    <td width="11%" align="center"><?=enddate($arradv['valid_till'])?></td>
    
   
    </tr>
  </table>
  </td></tr>
  <tr><td colspan="6" style="border-bottom:1px dashed #CCCCCC;"></td></tr>
  <? }else{?>
   <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>><td align="left" valign="top" colspan="6" <? if($arradv['rowborder']==1){?>class="rowborder"<? }?>>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td width="39%" align="left" class="txtLabel" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? } else{?><img src="images/spacer.gif" border="0" height="32" width="32"  /><? }?></td>
	<td width="50" align="left"><a href="./<?=remspace($arradv['add_id'])?>"><img src="websiteImage/thumb<?=$arradv['site_img']?>" border="0" class="img_border" /></a></td>
    <td width="257" align="left" valign="top" style="padding-left:5px;"><strong>Category:</strong> <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="./<?=remspace($arradv['add_id'])?>-<?=EdURL(substr(strip_tags($arradv['title']),0,40))?>.html" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=substr(strip_tags($arradv['title']),0,40)?></a></td>
  </tr>
</table>
</td>
    <td width="16%" align="center">
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
	  <?=$price ?></td>
    <td width="10%" align="center">
	<?
	if($arradv['winner_id']=="0")
	{
	?>
	 <?=$countBid['bid']?><br/><?
	  }else{
	  ?><span style="color:#FF0033">Sold</span><? }?></td>
    <td width="12%" align="center"><?=$countprop['cid']?></td>
    <td width="11%" align="center"><?=enddate($arradv['valid_till'])?></td>
    <td align="center" ><? echo $arradv['buyer_price']; ?></td>
    </tr>
  </table>
  </td></tr>
  <tr><td colspan="5" style="border-bottom:1px dashed #CCCCCC;"></td></tr>
  <? }?>
  <?
	}
 ?>
<tr><td colspan="5" align="right" valign="top"><? include_once('pageno.php');?></td></tr> <?
 }else{
 ?>
 <tr><td colspan="5" align="center" valign="top"><?=errormessage("No postings")?></td></tr>
 <?
 }
 ?>
  <tr>
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
