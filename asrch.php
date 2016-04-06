<?
error_reporting(0);
	require_once('config/config.php');
	$where="AND status='1' AND featured='1'";
	if(isset($_REQUEST['category']) && $_REQUEST['category']!="")
	{
		$where="";
		if($_REQUEST['category'] =='Featured')
		{
			$where.=" AND status='1' AND featured='1'";
		}
		if($_REQUEST['category'] == 'All')
		{
			$where.=" AND status='1' ";
		}
		
		/*if($_REQUEST['category'] == 'Private')
		{
			 $where.=" AND privatesale_auction='privatesale'";
		}*/
		if($_REQUEST['category'] == 'Ending')
		{
		    $where.=" AND status='1'  AND TIMESTAMPDIFF(DAY,NOW(),valid_till)<=5";
		}
		
		if($_REQUEST['category']=='Sold'){
			$where=" AND status='2'";
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
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_REQUEST['category']!=''?"category=".$_REQUEST['category']."&":""?>PageNo=" + eval(p1) ;
		document.frm.submit()
	}
</script>
</head>
<body>
<? include_once("toppage2.php");?>
<!--? include_once("header.php")?-->
<div id="container" >
<?  include_once("left-menu.php");?>
<div id="content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/lbd_24.jpg" width="742" height="10" /></td>
  </tr>
  <tr>
    <td>

    <div class="header_top">
      <?  include_once("cart-info.php");?>
    </div>

<? include_once("recent-adds.php")?>
<div class="listing">
<div class="listing_links" td align="right"><a href="<?=$_SERVER['PHP_SELF']?>?category=All">View All Listings</a><a href="<?=$_SERVER['PHP_SELF']?>?category=Featured">Featured Listings</a>   <a href="<?=$_SERVER['PHP_SELF']?>?category=Sold">Recently Sold</a><a href="<?=$_SERVER['PHP_SELF']?>?category=Ending">Ending Soon</a></div>
<div class="list-holder">
<form name="frm" method="post" action="">
 <table width="99%" border="0" cellspacing="0" cellpadding="03">
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="14%">&nbsp;</td>
      <td width="13%">&nbsp;</td>
      <td width="11%">&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right"><strong>Current Price</strong></td>
      <td align="center"><strong># of Bids</strong></td>
      <td align="center"><strong>Ends</strong></td>
      </tr>
<?
if(isset($_POST['submit']))
{
	$a1=$_POST['searchfield'];
	$a2=$_POST['cc'];
	$a3=$_POST['kws'];
	$a4=$_POST['cat'];
	$a5=$_POST['price'];
	$a6=$_POST['pagesize'];
	$a7=$_POST['visitors'];
	$a8=$_POST['age'];
	$a9=$_POST['len'];
	$b1=$_POST['rel'];
	$b2=$_POST['no_numeral'];
	$b3=$_POST['no_hyphen'];
	$b4=$_POST['income'];
	
	
	$qu="SELECT * FROM tbl_add WHERE 1=1 AND status='1'   ";
	if($a3=='0')
	{
	if($a1!='')
	{
		$qu.=" and keyword LIKE '$a1%' ";
	}
	}
	
	if($a3=='1')
	{
	if($a1!='')
	{
		$qu.=" and keyword LIKE '%$a1%' ";
	}
	}
	
	if($a3=='2')
	{
	if($a1!='')
	{
		$qu.=" and keyword LIKE '%$a1' ";
	}
	}
	if($a2!=='')
	{
	$a2=".".$a2;
		$qu.=" and title like '%$a2%' ";
	}
	if($a4!='')
	{
		$qu.=" and cat_id='$a4' ";
	}
	if($a5!='')
	{
		if($a5==1)
		{
		$qu.=" and price between 1 and 300 ";
		}
		if($a5==2)
		{
		$qu.=" and price between 300 and 1000 ";
		}
		if($a5==3)
		{
		$qu.=" and price between 1000 and 10000 ";
		}
		if($a5==4)
		{
		$qu.=" and price between 10000 and 100000 ";
		}
		if($a5==5)
		{
		$qu.=" and price >100000 ";
		}
	}
	
	if($a7!='')
	{
		if($a7==1)
		{
		$qu.=" and visitor between 1 and 1000 ";		
		}
		if($a7==2)
		{
		$qu.=" and visitor between 1000 and 10000 ";		
		}
		if($a7==3)
		{
		$qu.=" and visitor  between 10000 and 100000 ";		
		}
		if($a7==4)
		{
		$qu.=" and visitor >100000 ";		
		}
	}
	
	if($b4!='')
	{
		if($b4==1)
		{
		$qu.=" and income_month between 1 and 500 ";		
		}
		if($b4==2)
		{
		$qu.=" and income_month between 501 and 1000 ";		
		}
		if($b4==3)
		{
		$qu.=" and income_month between 1001 and 5000 ";		
		}
		if($b4==4)
		{
		$qu.=" and income_month between 5001 and 10000 ";		
		}
		if($b4==5)
		{
		$qu.=" and income_month >10000 ";		
		}
	}
	
	if($a8!='')
	{
		$date=date('Y-m-d');
		$date1 = strtotime($date);
		if($a8==1)
		{
		$date1 = strtotime("-2 day ", $date1);
		}
		if($a8==2)
		{
		$date1 = strtotime("-1 week", $date1);
		}
		if($a8==3)
		{
		$date1 = strtotime("-1 month", $date1);
		}
		if($a8==4)
		{
		$date1 = strtotime("-3 month", $date1);
		}
		$date1=date('Y-m-d', $date1);
		
		$date = strtotime($date);
		$date = strtotime("+1 day ", $date);
		$date=date('Y-m-d',$date);
		$qu.=" and `posted_on` between '$date1' and '$date'";

	 }
	 if($a9!='')
	 {
		if($a9!=7)
		{ 
	    $qu.=" and length(`keyword`)='$a9'";	
		}
		else
		{
		$qu.=" and length(`keyword`)>'6'";	
		}
	 }
	 
	 if($b3=='1')
	 {
	 $qu.=" and `keyword` NOT REGEXP '[\'-]'";
	 
	 }
	 if($b2=='2')
	 {
	 $qu.=" and `keyword` NOT REGEXP '[0-9]'";
	 }
	 
	 if($b1!='')
	 {
		if($b1==2)
		{
		$qu.=" order by keyword";	
		}
		if($b1==3)
		{
		$qu.=" order by price";	
		}	 
		if($b1==4)
		{
		$qu.=" order by price Desc ";	
		}
		if($b1==5)
		{
		$qu.=" order by visitor";	
		}
	 }
	 if($b1=='')
	 {
	 $qu.=" ORDER BY add_id DESC ";
	 }
	 
	 
}

	 if(isset($_POST['submit']))
	  {

	  $sql=$qu;
	  $_SESSION['asql']=$sql;
	  
	  }
	  else if(isset($_REQUEST['PageNo']))
	  {
	  $sql=$_SESSION['asql'];
	  }
	  else
	  {
	  $sql="SELECT * FROM ".ADVERTISE." WHERE 1 ".$where." ORDER BY add_id DESC";          
	  }
//echo $sql;
	if($a6!='')
	{
	$PageSize=$a6;
	}
	else
	{
		  $PageSize =30;	
	}
	
	if(!isset($_REQUEST['PageNo']))
	{
	$_SESSION['sql']=$sql;
	}
	else
	{
	$sql=$_SESSION['sql'];
	}
	  $StartRow =0;
	  include_once('paging-top.php');
	  if(mysql_num_rows($rs)>0)
		{
			$bgColor = "#ffffff";
			 for($i=0;$i<mysql_num_rows($rs);$i++)
			  { 
			 
				$arradv=mysql_fetch_array($rs);
		$bidcou=Select_Qry("COUNT(id) as addID",PROPOSAL,"add_id='".$arradv['add_id']."'","","","","");
		$pending=Select_Qry("COUNT(id) as PEND",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='0'","","","","");
		$reject=Select_Qry("COUNT(id) as REJ",PROPOSAL,"add_id='".$arradv['add_id']."' AND accept='1'","","","","");
?>
	<? if((CATEGORY_ADD($arradv['cat_id'])=='1') && ($arradv['site_img']=='')){?>
    <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
      <td <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="10"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32"/><? }?></td>
    <td align="left" valign="top" style="padding-left:5px;">Category: <?=CATEGORY($arradv['cat_id'])?><br />	
	<a href="./<?=remspace($arradv['add_id'])?>-<?=EdURL(substr(strip_tags($arradv['title']),0,50))?>.html" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=substr(strip_tags($arradv['title']),0,40)?></a>
      <?php /*?><a href="details.php?add_id=<?=$arradv['add_id']?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=$arradv['title']?></a><?php */?><span class="error"> <?=$arradv['status']==2?'[Sold]':''?></span></td>
  </tr>
</table></td>
      <td align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?php /*?><?=$arradv['price']?><?php */?></td>
      <td align="right" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>&nbsp;</td>
      <td align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$arradv['status']==2?'Ended':enddate($arradv['valid_till'])?></td>
      </tr>
	<tr><td colspan="4" style="height:5px;"></td></tr>
	<? }else{?>
	 <tr <? if($arradv['highlight']=='1'){?> bgcolor="#FBFEE7"<? }?>>
      <td <? if($arradv['rowborder']==1){?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="32"><? if($arradv['featured']=='1'){?><img src="images/fd.png" border="0" alt="Featured" title="Featured" /><? }else{?><img src="images/spacer.gif" border="0" height="32" width="32"/><? }?></td>
	<td width="56"><a href="details.php?add_id=<?=$arradv['add_id']?>">
	
                <?php
                                                                if(!empty($arradv['site_img'])){ ?>
                                                                 <img
                                                                            src="websiteImage/thumb<?= $arradv['site_img'] ?>"
                                                                            border="0" class="img_border"/>
                                                                <?php } 
                                                                else { ?>
                                                                
                                                              
                                                                       
                                                                           <img
                                                                            src="../images/logo/default_addimg.jpg"
                                                                            border="0" class="img_border"/> 
                                                                            <?php } ?> 
	
	</td>
    <td width="415" valign="top" style="padding-left:5px;" align="left">Category: <?=CATEGORY($arradv['cat_id'])?><br />
      <a href="details.php?add_id=<?=$arradv['add_id']?>" <? if($arradv['bold']==1){?>class="bold"<? }?>>
      <?=substr(strip_tags($arradv['title']),0,50)?></a></td>
  </tr>
</table></td>
      <td align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	  <?  if($arradv['status']==2){
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
	  <?=$price?></td>
      <td align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>>
	  <?
	if($arradv['status']!="2")
	{
	?><?=$bidcou['addID']?><br/>
	  <?
	  }else{
	  ?>
	  <span style="color:#FF0033">Sold</span><? }?></td>
      <td align="center" <? if($arradv['rowborder']==1){?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? }?>><?=$arradv['status']==2?'Ended':enddate($arradv['valid_till'])?></td>
      </tr>
	<tr><td colspan="4" style="height:5px;"></td></tr>
	<? }?>
<?
			}
?>
	<tr><td colspan="4" align="right" valign="top"><? include_once('pageno.php');?></td></tr>
<?
		}
		else{
?>
	<tr><td colspan="4" align="center" valign="top"><?=errormessage("Currently, there are no active listings in this category")?></td></tr>
<? 
	}
?>
    <!--<tr>
      <td class="td_bg"> animal prints to all over sequins, tran</td>
      <td align="right" class="td_bg">$2300</td>
      <td align="right" class="td_bg">12days</td>
      <td align="right" class="td_bg">Yestyerday</td>
    </tr>
    <tr>
      <td class="td_bg">From animal prints to all over sequins</td>
      <td align="right" class="td_bg">$500</td>
      <td align="right" class="td_bg">9days</td>
      <td align="right" class="td_bg">Today</td>
    </tr>
    <tr>
      <td class="td_bg"> animal prints to all over sequins, tran</td>
      <td align="right" class="td_bg">$2300</td>
      <td align="right" class="td_bg">12days</td>
      <td align="right" class="td_bg">Yestyerday</td>
    </tr>
    <tr>
      <td class="td_bg">From animal prints to all over sequins</td>
      <td align="right" class="td_bg">$500</td>
      <td align="right" class="td_bg">9days</td>
      <td align="right" class="td_bg">Today</td>
    </tr>
    <tr>
      <td class="td_bg"> animal prints to all over sequins, tran</td>
      <td align="right" class="td_bg">$2300</td>
      <td align="right" class="td_bg">12days</td>
      <td align="right" class="td_bg">Yestyerday</td>
    </tr>
    <tr>
      <td class="td_bg">From animal prints to all over sequins</td>
      <td align="right" class="td_bg">$500</td>
      <td align="right" class="td_bg">9days</td>
      <td align="right" class="td_bg">Today</td>
    </tr>
    <tr>
      <td class="td_bg"> animal prints to all over sequins, tran</td>
      <td align="right" class="td_bg">$2300</td>
      <td align="right" class="td_bg">12days</td>
      <td align="right" class="td_bg">Yestyerday</td>
    </tr>
    <tr>
      <td class="td_bg">From animal prints to all over sequins</td>
      <td align="right" class="td_bg">$500</td>
      <td align="right" class="td_bg">9days</td>
      <td align="right" class="td_bg">Today</td>
    </tr>
    <tr>
      <td class="td_bg"> animal prints to all over sequins, tran</td>
      <td align="right" class="td_bg">$2300</td>
      <td align="right" class="td_bg">12days</td>
      <td align="right" class="td_bg">Yestyerday</td>
    </tr>-->
    </table>
	</form>
</div>
<!--<div class="list-holder"><img src="images/fresh-auction_41.jpg" width="169" height="32" /></div>-->
</div>
</td>
  </tr>
  <tr>
    <td><img src="images/lbd_24a.jpg" width="742" height="10" /></td>
  </tr>
</table>
</div></div>
<? require_once("upper-footer.php"); ?>
<? require_once("footer.php");?>


</body>
</html>
