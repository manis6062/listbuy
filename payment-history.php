<?
	require_once('config/config.php');
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
<p><span class="header_text_h">Payment Transaction History</span>
  </p>
<p align="left">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
			<tr>
			<td width="8%" valign="top" class="rowhead">SL No.</td>
			<td width="12%" valign="top" class="rowhead">Transaction Type (A/C)</td>
			<td width="15%" valign="top" class="rowhead">Purpose</td>
			<td width="14%" valign="top" class="rowhead">Details</td>
			<td width="12%" valign="top" class="rowhead">Trns Date</td>
			<td width="12%" valign="top" class="rowhead">T Amount (Debit)</td>
			<td width="10%" valign="top" class="rowhead">T Amount (Credit)</td>
			<td width="17%" align="left" valign="top" class="rowhead"> Transaction ID</td>
		  </tr>
<?       
				$PageSize =20;	#_____________ Changes for no page & records
				$StartRow = 0;
				$sql="SELECT * FROM ".TRANSACTION." WHERE user_id='".$_SESSION['user_id']."' AND status='1' ORDER BY payment_date DESC";
				$slNo=0;
				include_once('paging-top.php');
				if(mysql_num_rows($rs)>0)
				{
					$bgColor = "#ffffff";
					for($i=0;$i<mysql_num_rows($rs);$i++)
					{
						$obj_fetch=mysql_fetch_array($rs);
						$add = Select_Qry("*",ADVERTISE,"add_id='".$obj_fetch['add_id']. "'","","","","");
						
?> 
				  <tr class="hor_sep">
					<td class="txtfont"><?=$i+1?></td>
					<td class="txtfont"><?=$obj_fetch['add_id']=='0'?'Credit':'Debit'?></td>
					<td align="left"><?=$obj_fetch['trans_purpose']?></td>
					<td align="left">
					<? if($obj_fetch['add_id']=='0'){
							print $obj_fetch['trans_purpose'];
						}else{
					?><a href="./<?=remspace($obj_fetch['add_id'])?>" target="_blank"><?=substr($add['title'],0,50)?></a><? }?></td>
					<td align="left"><?=date('M d, Y',strtotime($obj_fetch['payment_date']));?></td>
					<td align="center">
					<? if($obj_fetch['txn_id']=='' && $obj_fetch['add_id']!=''){
							if($obj_fetch['trns_amount']==0 ){
								echo($obj_fetch['credit']);
							}
							else if($obj_fetch['credit']==0){
								echo($obj_fetch['trns_amount']);
							}
						}	
					?>
					</td>
					<td align="center" class="txtfont">
					<?=($obj_fetch['txn_id']!='' && $obj_fetch['add_id']==0)?$obj_fetch['credit']:"-"?></td> 
					<td align="center" class="txtfont"><?=$obj_fetch['txn_id']==''? 'N/A' :$obj_fetch['txn_id']?></td>
				  </tr>
 <?
 	$bgColor == "#ffffff" ? $bgColor ="#E6E6E8" : $bgColor = "#ffffff";
 					}
					?>
		<tr><td align="right" valign="top" colspan="8"><? include_once('pageno.php');?></td></tr>				
					<?
				}
			else
				{
 ?>
 <tr><td align="center" valign="top" colspan="8"><?=errormessage("No Transactions")?></td></tr>
 <?
 }
 ?>
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
