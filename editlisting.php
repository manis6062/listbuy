<?
	require_once('config/config.php');
	$rs=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	
	$CAT=Select_Qry("*",CATEGORY,"cat_id='".$_REQUEST['cat_id']."'","","","","");
	if(isset($_REQUEST['btnSubmit']))
	{
		$where_c = "title='".escapeQuotes(stripslashes(trim($_REQUEST['title'])))."' AND add_id<>'".$_REQUEST['add_id']."'";
		$record = Select_Qry("*",ADVERTISE,$where_c,"","","","");
		if($record != '')
		{
			$msg=errorMessage("Title already exists!");
		}
		else
		{
		$buy=$_REQUEST['buyer_price']=="" ? $rs['buyer_price']:$_REQUEST['buyer_price'];
		 $set="cat_id='".$_REQUEST['category']."',
			 title='".escapeQuotes(stripslashes($_REQUEST['title']))."',
			  subtitle='".escapeQuotes(stripslashes($_REQUEST['subtitle']))."',
			  description='".escapeQuotes(stripslashes($_REQUEST['description']))."',
			  asking_price='".$_REQUEST['price']."',
			  length='".$_REQUEST['length']."',
			  company_name='".escapeQuotes(stripslashes($_REQUEST['company_name']))."',
			  website='".escapeQuotes(stripslashes($_REQUEST['website']))."',
			  site_status_name = '".$_REQUEST['statusId']."',
			  visitor = '".$_REQUEST['visitor']."',
			  traffic_pages = '".$_REQUEST['traffic_pages']."',
			  income_month='".$_REQUEST['income_month']."',
			  run_cost='".$_REQUEST['run_cost']."',
			  disk_space='".$_REQUEST['disk_space']."',
			  bandwidth='".$_REQUEST['bandwidth']."',
			  site_members='".$_REQUEST['site_members']."',
			  income_1 = '".$_REQUEST['income_1']."',
			  income_2 = '".$_REQUEST['income_2']."',
			  income_3 = '".$_REQUEST['income_3']."',
			  income_4 = '".$_REQUEST['income_4']."',
			  income_5 = '".$_REQUEST['income_5']."',
			  income_6 = '".$_REQUEST['income_6']."',
			  sold_1='".$_REQUEST['sold_1']."',
			  sold_2='".$_REQUEST['sold_2']."',
			  sold_3='".$_REQUEST['sold_3']."',
			  sold_4='".$_REQUEST['sold_4']."',
			  sold_5='".$_REQUEST['sold_5']."',
			  sold_6='".$_REQUEST['sold_6']."',
			  own_content ='".$_REQUEST['own_content']."',
			  own_server ='".$_REQUEST['own_server']."',
			  paypal_email='".escapeQuotes(stripslashes($_REQUEST['paypal_email']))."',
			  buyer_price='".$buy."',
			  aboutus='".escapeQuotes(stripslashes($_REQUEST['aboutus']))."',
			  product_page ='".escapeQuotes(stripslashes($_REQUEST['product_page']))."',
			  faq ='".escapeQuotes(stripslashes($_REQUEST['faq']))."',
			  contact_us ='".escapeQuotes(stripslashes($_REQUEST['contact_us']))."',
			  contact_email ='".escapeQuotes(stripslashes($_REQUEST['contact_email']))."'";
			  
		if($CAT['add_space']!='1'){
			if($_FILES["site_img"]["name"] != '')
			{
			
			if(file_exists("websiteImage/".$rs['site_img']))
				{
				@unlink("websiteImage/".$rs['site_img']);
				}
				$uploaddir='websiteImage/';
				$fileExt = strchr($_FILES["site_img"]["name"],".");
				$random=rand();
				$picture=$random.$fileExt;
				$uploadfile =$uploaddir . $picture;
				
				$file_type = $_FILES['site_img']['type'];
				$file_name = $_FILES['site_img']['name'];
				$file_size = $_FILES['site_img']['size'];
				$file_tmp = $_FILES['site_img']['tmp_name'];
				$ext=strchr($_FILES['site_img']['name'],".");
				$imagname=$random.$ext;
				
				image_resize($uploaddir."thumb",80,$file_type,$file_name,$file_size,$file_tmp,$imagname);
				move_uploaded_file($_FILES['site_img']['tmp_name'], $uploadfile);
			   $set.=",site_img='".escapeQuotes(stripslashes($imagname))."'";
			}
		}
		else
		{
		@unlink("websiteImage/".$rs['site_img']);
		@unlink("websiteImage/thumb".$rs['site_img']);
		$set.=",site_img=''";
		}
			Update_Qry(ADVERTISE,$set,"WHERE add_id='".$_REQUEST['add_id']."'");
			$msg=successfulMessage('<b>Your listing has been updated</b>');
		}
	}
	
	$record_advedit=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	
	$accept_bin=Select_Qry("*",BIN,"add_id='".$_REQUEST['add_id']."' AND accept='2'","","","","");

	if($_REQUEST['cat_id']!='')
	{
		$CATID=$_REQUEST['cat_id'];
	}
	else
	{
		$CATID=$record_advedit['cat_id'];
	}
	$pending=Select_Qry("COUNT(id) as PEND",PROPOSAL,"add_id='".$_REQUEST['add_id']."' AND accept='0'","","","","");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?=META_KEYWORDS?>"/>
<meta name="description" content="<?=META_CONTENT?>"/>
<link href="css/fresh-auction.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/validate_email.js"></script>
<script type="text/javascript" src="js/urlcheck.js"></script>
<script type="text/javascript">
	function doChange1(CATID)
	{
		window.location.href='editlisting.php?add_id=<?=$_REQUEST['add_id']?>&cat_id='+CATID;
	}
	function doCheck()
	{
		if(document.frm.category.value=='')
		{
			alert('Please select Category.');
			document.frm.category.focus();
			return false;
		}
		else if(document.frm.title.value=='')
		{
			alert('Please enter Title.');
			document.frm.title.focus();
			return false;
		}
		else if(document.frm.subtitle.value=='')
		{
			alert('Please enter Subtitle.');
			document.frm.subtitle.focus();
			return false;
		}
	<?
		if((CATEGORY_ADD($CATID)!='1')){
	?>
		else if(document.frm.price.value=='')
		{
			alert('Please enter Price.');
			document.frm.price.focus();
			return false;
		}
		else if(document.frm.buyer_price.value=='')
		{
			alert('Please enter Buying Price.');
			document.frm.buyer_price.focus();
			return false;
		}
	<? }?>
		/*else if(document.frm.paypal_email.value=='')
		{
			alert('Please enter Paypal Email Address.');
			document.frm.paypal_email.focus();
			return false;
		}
		else if(!emailCheck(document.frm.paypal_email))
		{
			document.frm.paypal_email.focus();
			return false;
		}*/
		else if(document.frm.company_name.value=='')
		{
			alert('Please enter Company Name.');
			document.frm.company_name.focus();
			return false;
		}
		
		
		<?
		if((CATEGORY_ADD($CATID)!='1'))
		{
		if($_REQUEST['add_id']=="")
		{
		?>
		else if(document.frm.site_img.value=="")
		{
			alert("Please upload your Site Image.");
			document.frm.site_img.focus();
			return false;
		}
		else if(!chkimage(document.frm.site_img.value))
		{
			alert("only .jpg .gif .png images can be uploaded.");
			return false;
		}
		<?
		}
		?>
		else if(document.frm.statusId.value=="")
		{
			alert("Please select site status");
			document.frm.statusId.focus();
			return false;
		}
		else if(document.frm.visitor.value=="")
		{
			alert("Please provide number of visitors");
			document.frm.visitor.focus();
			return false;
		}
		<?
		}
		?>
		
		else{
			return true;
		}
	}
	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline",
		theme_advanced_buttons2 : "",
	//	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	//	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/style2.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
</head>
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
<? if($record_advedit['status']=='2' || $pending['PEND'] >0){?>
<p><span class="header_text_h">Your Listing has accepted bids  or an accepted BIN offer.</span> <br />
  You can edit the listing details if there are no approved bids and no accepted BIN offers.</p>
<? }else{?>
<p><span class="header_text_h">Update Listing </span>
  </p>
<p align="left">
<form name="frm" method="post" action="" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="3" cellpadding="0" align="center" class="border">
    <tr>
      <td colspan="2" align="left"><?=$msg?></td>
    </tr>
    <tr>
      <td colspan="2" align="left" class="subheader">Required Details</td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="32%" align="left" class="txtLabel">Select Category </td>
      <td width="68%" align="left">
	  <select name="category" onchange="doChange1(this.value)">
	  <option value="">Choose Category</option>
	  <?
	 $cat_listing=Listing_Qry("*",CATEGORY,"WHERE status='1'","");
	 if($cat_listing !="")
	 {
	 foreach($cat_listing as $cat_record)
	 {
	  ?>
<option value="<?=$cat_record['cat_id']?>"><?php echo $cat_record['cat_name']?></option>
	  <?
	  }
	  }
	  ?>
	  </select>
	  <script language="JavaScript">
		var CType="<?=$_REQUEST['cat_id'] !=''?$_REQUEST['cat_id']:$record_advedit['cat_id']?>";
		for (var i=0; i<document.frm.category.options.length; i++)
			{
				if (document.frm.category.options[i].value==CType)
					{		
						document.frm.category.options[i].selected=true;
						break;
					}
			}
	</script>	  </td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td align="left" class="txtLabel">Title</td>
      <td align="left" valign="top"><input type="text" name="title" value="<?=$record_advedit['title']?>" class="largetextField" /></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td align="left" class="txtLabel">Subtitle</td>
      <td align="left"><input type="text" name="subtitle" value="<?=$record_advedit['subtitle']?>" class="largetextField" /></td>
    </tr>
    <tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="32%" align="left" class="txtLabel" valign="top">Description</td>
      <td width="68%" align="left">
	  <textarea name="description" id="description" rows="10" cols="55"><?=$record_advedit['description']?></textarea></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<?
		if((CATEGORY_ADD($CATID)!='1')){
	?>
    <tr>
      <td align="left" class="txtLabel">Price</td>
      <td align="left">$<input type="text" name="price" value="<?=$record_advedit['asking_price']?>" class="smalltextField" onkeypress="return keyRestrict(event,'1234567890.')" /></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<? }?>
    <tr>
      <td width="32%" align="left" class="txtLabel">Listing Length </td>
      <td width="68%" align="left"><input type="text" name="length" value="<?=$record_advedit['length']=='0'? VALLID_DAYS : $record_advedit['length']?>" class="smalltextField" readonly /></td>
    </tr>
	<?
		if((CATEGORY_ADD($CATID)!='1')){
	?>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<tr>
      <td width="32%" align="left" class="txtLabel">Buy It Now Price </td>
      <td width="68%" align="left">
	  <?
	  if($accept_bin)
	  {
	  ?>
	  <?=$record_advedit['buyer_price']?>
	 <br /><?=statica_cms_page_value(27)?>
	  <? }else{?>
	  $<input type="text" name="buyer_price" value="<?=$record_advedit['buyer_price']?>" class="smalltextField" onkeypress="return keyRestrict(event,'1234567890.')" /><? }?></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<tr>
      <td width="32%" align="left" class="txtLabel" valign="top">Paypal Email Address </td>
      <td width="68%" align="left"><input type="text" name="paypal_email" value="<?=$record_advedit['paypal_email']?>" class="largetextField" /></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<? }?>
    <tr>
      <td width="32%" align="left" class="txtLabel">Company Name  </td>
      <td width="68%" align="left"><input type="text" name="company_name" value="<?=$record_advedit['company_name']?>" class="largetextField" /></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="32%" align="left" class="txtLabel">Website</td>
      <td width="68%" align="left"><input type="text" name="website" value="<?=$record_advedit['website']?>" class="largetextField" /></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<?
		
	if((CATEGORY_ADD($CATID)!='1')){
	
	?>
	<tr>
      <td width="32%" align="left" class="txtLabel">Logo</td>
      <td width="68%" align="left"><input type="file" name="site_img" />&nbsp;<? if($record_advedit['site_img']!=''){?><img src="websiteImage/thumb<?=$record_advedit['site_img']?>" width="50" align="absmiddle"/><? }?></td>
    </tr>
	<tr>
      <td width="32%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<? }?>
	<tr>
	  <td width="32%" align="left" style="height:10px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSubmit" value="Submit" onclick="return doCheck();" />
        &nbsp;&nbsp;
        <input type="button" name="cancel" value="Cancel" onclick="window.location.href='mylistings.php'" />      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

</p>
<? }?>
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
