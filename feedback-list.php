<?
	require_once('config/config.php');
//$advarr=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");

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
<p><span class="header_text_h">Feedback for <?=USERNAME($_REQUEST['user_id'])?></span>
  </p>
<p align="center">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr><td align="left" valign="top"><?=$msg?></td></tr>
<tr><td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" class="border">
<?
  			$PageSize =30;	
            $StartRow = 0;
           	$sql="SELECT * FROM ".USER_FEEDBACK." WHERE user_id='".$_REQUEST['user_id']."' ORDER BY id DESC"; 
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
  <td width="75%" align="left" valign="top" class="title"><?=$obj_fetch['subject']?><br /><span class="txtLabel">Posted By: <a href="feedback-list.php?user_id=<?=$obj_fetch['posted_by']?>"><?=USERNAME($obj_fetch['posted_by'])?></a></span></td>
  <td width="25%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
  <td width="75%" align="left" valign="top" class="txtLabel"><?=$obj_fetch['comment']?></td>
  <td width="25%" align="right" valign="bottom" class="txtLabel"><?=dateprint($obj_fetch['posted_on'])?></td>
  </tr>
   <tr><td colspan="2" style="border-bottom:1px dashed #CCCCCC;">&nbsp;</td></tr>
  <?
  }
  ?>
  <tr><td align="right" valign="top" colspan="2"><? include_once('pageno.php');?></td></tr>
  <?
  }else{
  ?>
  <tr><td align="center" valign="top" colspan="2"><?=errormessage("No feedback posted")?></td></tr>
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
