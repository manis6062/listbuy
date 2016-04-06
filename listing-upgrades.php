<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	/*if(isset($_REQUEST['btnSubmit']))
	{
		$f=$_REQUEST['featured']!=''?'1':'0';
		$h=$_REQUEST['highlighted']!=''?'1':'0';
		$b=$_REQUEST['bold']!=""?'1':'0';
		$r=$_REQUEST['rowborder']!=""?'1':'0';
		
		$set="featured='".$f."',
			  highlight ='".$h."',
			  bold='".$b."',
			  rowborder ='".$r."'";
			Update_Qry(ADVERTISE,$set,"WHERE add_id='".$_REQUEST['add_id']."'");
	
	}*/
	
	$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?=META_KEYWORDS?>"/>
<meta name="description" content="<?=META_CONTENT?>"/>
<link href="css/fresh-auction.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function doCheck()
	{
		document.frm.action='confirm-upgrades.php?<?=$_SERVER['QUERY_STRING']?>';
		document.frm.submit();
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
<p><span class="header_text_h">Listing Details</span>
  </p>
<p align="left">
<form name="frm" method="post" action="" onsubmit="doCheck()">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
<tr>
    <td align="left" class="header_sl_2"></td>
  </tr>
   <tr>
    <td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
	<tr>
    <td width="29%" class="rowhead">Description</td>
    <td width="71%" class="rowhead">Details</td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Category</td>
    <td align="left"><?=CATEGORY($record['cat_id'])?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Title</td>
    <td align="left"><?=$record['title']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Subtitle</td>
    <td align="left"><?=$record['subtitle']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel" valign="top">Description</td>
    <td align="left" valign="top"><?=$record['description']?></td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
  <tr>
    <td align="left" class="txtLabel">Price</td>
    <td align="left"><span class="error"><strong>$<?=$record['price']?></strong></span></td>
  </tr>
  <? }?>
  <tr>
    <td align="left" class="txtLabel">Listing Length </td>
    <td align="left"><?=$record['length']?> Days</td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Company Name </td>
    <td><?=$record['company_name']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Website</td>
    <td align="left"><?=$record['website']?></td>
  </tr>
  <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
   <tr>
    <td colspan="2" align="left" class="txtLabel" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="29%" height="20" align="left" class="txtLabel">Site Status</td>
                <td width="31%" height="20" align="left"><?=SITESTATUS($record['site_status_name'])?></td>
                <td width="21%" height="20" align="left" class="txtLabel">Visitors</td>
                <td width="19%" height="20" align="left"><?=$record['visitor']?></td>
              </tr>
              <tr>
                <td height="20" align="left" class="txtLabel">Income</td>
                <td height="20" align="left">$<?=$record['income_month']?></td>
                <td height="20" align="left" class="txtLabel">Page Views</td>
                <td height="20" align="left"><?=$record['traffic_pages']?></td>
              </tr>
              <tr>
                <td height="20" align="left" class="txtLabel">Cost to run site</td>
                <td height="20" align="left"><?=$record['run_cost']?></td>
                <td height="20" align="left" class="txtLabel">Disk Space Used</td>
                <td height="20" align="left"><?=$record['disk_space']?></td>
              </tr>
              <tr>
                <td height="20" align="left" class="txtLabel">Bandwidth Used</td>
                <td height="20" align="left"><?=$record['bandwidth']?></td>
                <td height="20" align="left" class="txtLabel">Members</td>
                <td height="20" align="left"><?=$record['site_members']?></td>
              </tr>
            </table>
	</td>
    </tr>
	<? }?>
</table>
</td></tr>
 <?
  	if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
  <tr>
    <td align="left" class="header_sl_2">Income Source </td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="border">
              <tr>
                <td width="41%" valign="top">
				<ul class="listUL">
				<?
					if($record['income_1'] == '1')
					{
				?>
				<li>Selling Products</li>
				<?
					}
					if($record['income_2'] == '1')
					{
				?>
				<li>Selling Access to Site</li>
				<?
					}
					if($record['income_3'] == '1')
					{
				?>
				<li>Selling Site-related Services</li>
				<?
					}
					if($record['income_4'] == '1')
					{
				?>
				<li>Selling Non-Site-related Services</li>
				<?
					}
					if($record['income_5'] == '1')
					{
				?>
				<li>Other</li>
				<?
					}
					if($record['income_6'] == '1')
					{
				?>
				<li>No Income</li>
				<?
					}
				?>
				</ul>				</td>
                <td width="31%" valign="top">
				<ul class="listUL">
				<?
					if($record['sold_1'] == '1')
					{
				?>
				<li>Business</li>
				<?
					}
					if($record['sold_2'] == '1')
					{
				?>
				<li>Images & Content</li>
				<?
					}
					if($record['sold_3'] == '1')
					{
				?>
				<li>Software</li>
				<?
					}
					if($record['sold_4'] == '1')
					{
				?>
				<li>Tradenamed</li>
				<?
					}
					if($record['sold_5'] == '1')
					{
				?>
				<li>Original Graphics</li>
				<?
					}
					if($record['sold_6'] == '1')
					{
				?>
				<li>3rd party Licenses</li>
				<?
					}
				?> 
				</ul></td>
                <td width="28%" valign="top">
				<ul class="listUL">
				<?
					if($record['own_content'] == '1')
					{
				?>
				<li>All Content</li>
				<?
					}
					if($record['own_server'] == '1')
					{
				?>
				<li>Server</li>
				<?
					}
				?>
				</ul></td>
                </tr>
             </table>
	</td></tr>
	<? }?>
<tr>
    <td align="left" class="header_sl_2">Option Details </td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
	<tr>
    <td width="29%" class="rowhead">Description</td>
    <td width="71%" class="rowhead">Details</td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">About Us </td>
    <td align="left"><?=$record['aboutus']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Products Page</td>
    <td align="left"><?=$record['product_page']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">FAQ</td>
    <td align="left"><?=$record['faq']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Contact Us </td>
    <td align="left"><?=$record['contact_us']?></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel">Contact Email </td>
    <td align="left"><?=$record['contact_email']?></td>
  </tr>
</table></td></tr>
<tr>
    <td align="left" class="header_sl_2">Listing Upgrades</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="5" cellpadding="4" class="border">
					 <tr>
                        <td><input type="checkbox" name="featured" value="1"<? if($record['featured']=='1'){?> checked="checked" disabled="disabled"<? }?> /></td>
                        <td>&nbsp;</td>
                        <td align="left"><span class="text-bold"> Listing Featured On Homepage Fee: </span><span class="error">(<?=FEE_FEATURED?> credits)
                        </span></td>
              </tr>
					  <tr>
                        <td>
						<input type="checkbox" name="highlight" value="1" <? if($record['highlight']=='1'){?> checked="checked" disabled="disabled"<? }?> /></td>
                        <td>&nbsp;</td>
                        <td align="left"><span class="text-bold">Listing in Highlighted Fee : </span><span class="error">(<?=FEE_HIGHLIGHTED?> credits)</span></td>
                      </tr>
                      <tr>
                        <td width="8%">
						<input type="checkbox" name="bold" value="1" <? if($record['bold']=='1'){?> checked="checked" disabled="disabled"<? }?> /></td>
                        <td width="3%">&nbsp;</td>
                        <td width="89%" align="left"><span class="text-bold">Listing in Bold Fee : </span><span class="error">(<?=FEE_BOLD?> credits)</span></td>
                      </tr>
					  <tr>
                        <td><input type="checkbox" name="rowborder" value="1" <? if($record['rowborder']=='1'){?> checked="checked" disabled="disabled"<? }?> /></td>
                        <td>&nbsp;</td>
                        <td align="left"><span class="text-bold">Listing in Row Border Fee: </span><span class="error">(<?=FEE_ROWBORDER?> credits)</span></td>
                      </tr>
            </table>
	</td></tr>
	<tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input type="button" name="btnCancel" value="Back to Listings" onclick="window.location.href='mylistings.php'" /></td>
    <td align="right"><input type="submit" name="btnSubmit" value="Continue" /></td>
  </tr>
</table>

	</td>
  </tr>
</table>
  <?php /*?><table width="100%" border="0" cellspacing="3" cellpadding="0" align="center" class="border">
    <tr>
      <td colspan="2" align="left" class="subheader">Listing Details</td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="32%" align="left" class="txtLabel">Category </td>
      <td width="68%" align="left"><?php echo CATEGORY($upgrade['cat_id'])?></td>
    </tr>
    <tr>
      <td align="left" class="txtLabel">Title</td>
      <td align="left"><?=$upgrade['title']?></td>
    </tr>
    <tr>
      <td align="left" class="txtLabel">Subtitle</td>
      <td align="left"><?=$upgrade['title']?></td>
    </tr>
    
    <tr>
      <td width="32%" align="left" class="txtLabel" valign="top">Description</td>
      <td width="68%" align="left" valign="top"><?=$upgrade['title']?></td>
    </tr>
    <tr>
      <td width="32%" align="left" class="txtLabel">Listing Length </td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
    <tr>
      <td width="32%" align="left" class="txtLabel">Comapny Name  </td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
    <tr>
      <td width="32%" align="left" class="txtLabel">Website</td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td colspan="2" align="left" class="subheader">Optional Details</td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="32%" align="left"><span class="txtLabel">About Us</span> <br />
        (Give the URL on your website of your 'About Us' page)</td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
    <tr>
      <td width="32%" align="left"><span class="txtLabel">Products Page</span> <br />
       <span class="text-small">(Give the URL of the page on your website which lists all your products (if applicable))</span></td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
	<tr>
      <td width="32%" align="left"><span class="txtLabel">FAQ </span><br />
        <span class="text-small">(Give the URL of the page on your website with your FAQ (if applicable))</span></td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
	<tr>
      <td width="32%" align="left"><span class="txtLabel">Contact Us</span><br />
        <span class="text-small">(Give the URL to your website's 'Contact Us' page)</span> </td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
	<tr>
      <td width="32%" align="left"><span class="txtLabel">Contact Email</span>  <br />
        <span class="text-small">(Give the email address of the person to contact for this listing)</span></td>
      <td width="68%" align="left"><?=$upgrade['title']?></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<tr>
      <td colspan="2" align="left" class="subheader">New Listing Upgrades </td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<tr>
      <td width="32%" align="left" class="txtLabel">&nbsp;</td>
      <td width="68%" align="left" valign="top">
	  <table width="100%" border="0" cellspacing="5" cellpadding="4">
					 <tr>
                        <td><input type="checkbox" name="featured" value="1"<? if($upgrade['featured']=='1'){?> checked="checked"<? }?> /></td>
                        <td>&nbsp;</td>
                        <td align="left"><span class="text-bold">Project Listed in Featured Fee: </span><span class="error">(<?=FEE_FEATURED?> credits)
                        </span></td>
                      </tr>
					  <tr>
                        <td>
						<input type="checkbox" name="highlighted" value="1" <? if($upgrade['highlight']=='1'){?> checked="checked"<? }?> /></td>
                        <td>&nbsp;</td>
                        <td align="left"><span class="text-bold">Project Listed in Highlighted Fee : </span><span class="error">(<?=FEE_HIGHLIGHTED?> credits)</span></td>
                      </tr>
                      <tr>
                        <td width="8%">
						<input type="checkbox" name="bold" value="1" <? if($upgrade['bold']=='1'){?> checked="checked"<? }?> /></td>
                        <td width="3%">&nbsp;</td>
                        <td width="89%" align="left"><span class="text-bold">Project Listed in Bold Fee : </span><span class="error">(<?=FEE_BOLD?> credits)</span></td>
                      </tr>
					  <tr>
                        <td><input type="checkbox" name="rowborder" value="1" <? if($upgrade['rowborder']=='1'){?> checked="checked"<? }?> /></td>
                        <td>&nbsp;</td>
                        <td align="left"><span class="text-bold">Project Listed in Row Border Fee: </span><span class="error">(<?=FEE_ROWBORDER?> credits)</span></td>
                      </tr>
                    </table>
	  </td>
    </tr>
	
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSubmit" value="Continue" />
        &nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table><?php */?>
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
