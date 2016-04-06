<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		Delete_Qry(PROPOSAL,"WHERE id='".base64_decode($_REQUEST['id'])."'");
		$msg=successfulMessage("Proposal has been deleted successfully!");
	}
	
	if(isset($_REQUEST['prid'])!="")
	{
	Update_Qry(PROPOSAL,"accept='2'","WHERE id='".$_REQUEST['prid']."'");
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
<p><span class="header_text_h">My Proposal  </span>
  </p>
<p align="center">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr><td align="left" valign="top"><?=$msg?></td></tr>
<tr><td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="border">
  <tr>
    <td width="23%" align="left" valign="top" class="rowhead">Advertise Title </td>
    <td width="16%" align="left" valign="top" class="rowhead">Total Amount($)</td>
    <td width="16%" align="left" valign="top" class="rowhead">Proposed By </td>
    <td width="17%" align="left" valign="top" class="rowhead">Proposed Amount </td>
    <td width="16%" align="left" valign="top" class="rowhead">Posted On </td>
    <td width="12%" align="left" valign="top" class="rowhead">Action</td>
  </tr>
  <?
  			$PageSize =30;	
            $StartRow = 0;
           	$sql="SELECT p.id,p.user_id as USERID,p.add_id,p.proposed_amt,p.posted_on,p.accept,a.user_id,a.title,a.price,a.length,a.status FROM ".PROPOSAL." AS p LEFT JOIN ".ADVERTISE." AS a ON p.add_id=a.add_id WHERE p.user_id='".$_SESSION['user_id']."' ORDER BY p.id DESC ";
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
    <td align="left" valign="top"><?=$obj_fetch['title']?></td>
    <td align="left" valign="top"><?=$obj_fetch['price']?></td>
    <td align="left" valign="top"><?=USER($obj_fetch['USERID'])?></td>
    <td align="left" valign="top"><?=$obj_fetch['proposed_amt']?></td>
    <td align="left" valign="top"><?=dateprint($obj_fetch['posted_on'])?></td>
    <td align="left" valign="top"><? if($obj_fetch['accept']=='0'){?>
    <a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=base64_encode($obj_fetch['id'])?>" onClick="return confirm('Are you sure to delete this proposal?')" title="Delete your Investment Proposal">Delete</a><br><? } ?>
<? if($obj_fetch['accept']=='0'){?>
Not Confirmed
<? }if($obj_fetch['accept']=='1'){?>
Accepted<br />
<a href="<?=$_SERVER['PHP_SELF']?>?prid=<?=$obj_fetch['id']?>">Confirmed</a>
<? }if($obj_fetch['accept']=='2'){?>
Confirmed
<? }if($obj_fetch['accept']=='3'){?>
<span style="color:#E80000">Winner</span>
<?
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
  <tr><td align="center" valign="top" colspan="6"><?=errormessage("No Proposal Available")?></td></tr>
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
