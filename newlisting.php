<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	$editcat=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	
	if($_REQUEST['cat_id']!='')
	{
	$CATID=$_REQUEST['cat_id'];
	}
	else
	{
	$CATID=$editcat['cat_id'];
	}
	
	$CAT=Select_Qry("*",CATEGORY,"cat_id='".$CATID."'","","","","");
	if(isset($_REQUEST['btnSubmit']))
	{	
		$where_chk="title='".escapeQuotes(stripslashes($_REQUEST['title']))."'";
		if($_REQUEST['add_id']!="")
		{
		$where_chk.="AND add_id <>'".$_REQUEST['add_id']."'";
		}
		if(Select_Qry("*",ADVERTISE,$where_chk,"","","",""))
		{
			$msg=errorMessage("Title name already exists!");
		}
		else
		{
		$f=$_REQUEST['featured']!=''?'1':'0';
		$h=$_REQUEST['highlight']!=''?'1':'0';
		$b=$_REQUEST['bold']!=""?'1':'0';
		$r=$_REQUEST['rowborder']!=""?'1':'0';


$t2=stripslashes(trim($t1));
$domain_parts = explode('.', $t2);
echo $web2=$domain_parts[0]; // returns appl

$input=$_POST['title'];
$k1=explode(".",$input);
$webn=$k1[0]; // returns appl

			
		$set="user_id		='".$_SESSION['user_id']."',
			  cat_id		='".$_REQUEST['category']."',
			  title			='".escapeQuotes(stripslashes(trim($_REQUEST['title'])))."',
			  subtitle		='".escapeQuotes(stripslashes(trim($_REQUEST['subtitle'])))."',
			  description	='".escapeQuotes(stripslashes(trim($_REQUEST['description'])))."',
			  asking_price 	='".escapeQuotes(stripslashes(trim($_REQUEST['price'])))."',
			  price			='".escapeQuotes(stripslashes(trim($_REQUEST['price'])))."',
			  length		='".escapeQuotes(stripslashes(trim($_REQUEST['length'])))."',
			  company_name	='".escapeQuotes(stripslashes(trim($_REQUEST['company_name'])))."',
			  website		='".escapeQuotes(stripslashes(trim($_REQUEST['website'])))."',
			  site_status_name = '".escapeQuotes(stripslashes(trim($_REQUEST['statusId'])))."',
			  visitor 		= '".escapeQuotes(stripslashes(trim($_REQUEST['visitor'])))."',
			  traffic_pages = '".escapeQuotes(stripslashes(trim($_REQUEST['traffic_pages'])))."',
			  income_month	='".escapeQuotes(stripslashes(trim($_REQUEST['income_month'])))."',
			  run_cost		='".escapeQuotes(stripslashes(trim($_REQUEST['run_cost'])))."',
			  disk_space	='".escapeQuotes(stripslashes(trim($_REQUEST['disk_space'])))."',
			  bandwidth		='".escapeQuotes(stripslashes(trim($_REQUEST['bandwidth'])))."',
			  site_members	='".escapeQuotes(stripslashes(trim($_REQUEST['site_members'])))."',
			  income_1 		= '".escapeQuotes(stripslashes(trim($_REQUEST['income_1'])))."',
			  income_2 		= '".escapeQuotes(stripslashes(trim($_REQUEST['income_2'])))."',
			  income_3 		= '".escapeQuotes(stripslashes(trim($_REQUEST['income_3'])))."',
			  income_4 		= '".escapeQuotes(stripslashes(trim($_REQUEST['income_4'])))."',
			  income_5 		= '".escapeQuotes(stripslashes(trim($_REQUEST['income_5'])))."',
			  income_6 		= '".escapeQuotes(stripslashes(trim($_REQUEST['income_6'])))."',
			  sold_1		='".escapeQuotes(stripslashes(trim($_REQUEST['sold_1'])))."',
			  sold_2		='".escapeQuotes(stripslashes(trim($_REQUEST['sold_2'])))."',
			  sold_3		='".escapeQuotes(stripslashes(trim($_REQUEST['sold_3'])))."',
			  sold_4		='".escapeQuotes(stripslashes(trim($_REQUEST['sold_4'])))."',
			  sold_5		='".escapeQuotes(stripslashes(trim($_REQUEST['sold_5'])))."',
			  sold_6		='".escapeQuotes(stripslashes(trim($_REQUEST['sold_6'])))."',
			  own_content 	='".escapeQuotes(stripslashes(trim($_REQUEST['own_content'])))."',
			  own_server 	='".escapeQuotes(stripslashes(trim($_REQUEST['own_server'])))."',
			  paypal_email	='".escapeQuotes(stripslashes(trim($_REQUEST['paypal_email'])))."',
			  buyer_price	='".escapeQuotes(stripslashes(trim($_REQUEST['buyer_price'])))."',
			  aboutus		='".escapeQuotes(stripslashes(trim($_REQUEST['aboutus'])))."',
			  product_page 	='".escapeQuotes(stripslashes(trim($_REQUEST['product_page'])))."',
			  faq 			='".escapeQuotes(stripslashes(trim($_REQUEST['faq'])))."',
			  contact_us 	='".escapeQuotes(stripslashes(trim($_REQUEST['contact_us'])))."',
			  contact_email ='".escapeQuotes(stripslashes(trim($_REQUEST['contact_email'])))."',
			  keyword       ='".$webn."',
			  featured		='".$f."',
			  highlight 	='".$h."',
			  bold			='".$b."',
			  rowborder 	='".$r."',
			  valid_till	= ADDDATE(NOW(),INTERVAL ".VALLID_DAYS." DAY),
			  posted_on		=NOW()";
			  
		if($CAT['add_space']!='1')
		{
		if($_FILES["site_img"]["name"] != ''){
		
			$uploaddir='websiteImage/';
			@unlink("websiteImage/".$editcat['site_img']);
			@unlink("websiteImage/thumb".$editcat['site_img']);
			$fileExt = strchr($_FILES["site_img"]["name"],".");
			$random=rand();
			$picture=$random.$fileExt;
			$uploadfile =$uploaddir.$picture;
			
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
		@unlink("websiteImage/".$editcat['site_img']);
		@unlink("websiteImage/thumb".$editcat['site_img']);
		$set.=",site_img=''";
		}	
		
			if($_REQUEST['add_id']=="")
			{
		
			$add_id=Insert_Qry(ADVERTISE,$set);
			echo"<script>window.location.href='review.php?add_id=".$add_id."'</script>";
			}
			else
			{
			Update_Qry(ADVERTISE,$set,"WHERE add_id='".$_REQUEST['add_id']."'");
		echo"<script>window.location.href='review.php?add_id=".$_REQUEST['add_id']."'</script>";
			}
	}
	}
	
	$editlisting=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
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
<SCRIPT type="text/javascript" src="js/side_scripts.js"></script>
<script type="text/javascript" src="js/urlcheck.js"></script>
<script type="text/javascript">
	function doChange1(CATID)
	{
		window.location.href='newlisting.php?add_id=<?=$_REQUEST['add_id']?>&cat_id='+CATID;
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
		/*else if(document.frm.description.value=='')
		{
			alert('Please write Description.');
			document.frm.description.focus();
			return false;
		}*/
		<?	
		if($CAT['add_space']!='1'){
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
		if($CAT['add_space']!='1'){
	?>
		<?
		if($_REQUEST['add_id']=="")
		{
		?>
		
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
	function keyRestrict(e, validchars)
	{
	 var key='', keychar='';
	 key = getKeyCode(e);
	 if (key == null) return true;
	 keychar = String.fromCharCode(key);
	 keychar = keychar.toLowerCase();
	 validchars = validchars.toLowerCase();
	 if (validchars.indexOf(keychar) != -1)
	  return true;
	 if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
	  return true;
	 return false;
    }
    function getKeyCode(e)
	{
	 if (window.event)
		return window.event.keyCode;
	 else if (e)
		return e.which;
	 else
		return null;
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
<p><span class="header_text_h">Create a New Listing </span>
  </p>
<p align="left">
<form name="frm" method="post" action="" onsubmit="return doCheck()" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="3" cellpadding="0" align="center" class="border">
    <tr>
      <td colspan="2" align="left" class="subheader">Required Details</td>
    </tr>
	<?
		if($msg!=''){
	?>
	<tr>
      <td width="100%" align="left" colspan="2"><?=$msg?></td>
    </tr>
	<? }?>
	<tr>
      <td width="100%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="100%" align="left" class="txtLabel">Choose a category</td>
      <td width="68%" align="left">
	  <select name="category" onchange="doChange1(this.value)">
	  <option value="">Select Category</option>
	  <?
	  	$catList=Listing_Qry("*",CATEGORY,"WHERE status='1' ORDER BY cat_name ASC","");
		if($catList!="")
		{
			foreach($catList as $cat)
			{
	  ?>
	  <option value="<?=$cat['cat_id']?>"><?=$cat['cat_name']?></option>
	  <?
	  		}
		}
	  ?>
	  </select>
	  <script language="JavaScript">
		var CType="<?=$_REQUEST['cat_id']==""?$editlisting['cat_id']:$_REQUEST['cat_id']?>";
		for (var i=0; i<document.frm.category.options.length; i++)
			{
				if (document.frm.category.options[i].value==CType)
					{		
						document.frm.category.options[i].selected=true;
						break;
					}
			}
	</script></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td align="left" class="txtLabel" valign="top">Domain Name</td>
      <td align="left"><input type="text" name="title" value="<?=isset($_REQUEST['title']) ? $_REQUEST['title']:$editlisting['title']?>" class="largetextField"  /></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td align="left" class="txtLabel">Subtitle</td>
      <td align="left"><input type="text" name="subtitle" value="<?=isset($_REQUEST['subtitle'])?$_REQUEST['subtitle']:$editlisting['subtitle']?>" class="largetextField" /></td>
    </tr>
    <tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="100%" align="left" class="txtLabel" valign="top">Detailed Description</td>
      <td width="68%" align="left"><textarea name="description" id="description" rows="10" cols="55"><?=isset($_REQUEST['description']) ? $_REQUEST['description'] : $editlisting['description']?></textarea></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<?	
		if($CAT['add_space']!='1'){
	?>
	<tr>
      <td width="100%" align="left" class="txtLabel">Starting Price</td>
      <td width="68%" align="left">$<input type="text" name="price" value="<?=isset($_REQUEST['price']) ? $_REQUEST['price'] : $editlisting['price']?>" class="smalltextField" onkeypress="return keyRestrict(event,'1234567890.')" /></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<? }?>
    <tr>
      <td width="100%" align="left" class="txtLabel">Listing Length - days</td>
      <td width="68%" align="left"><input type="text" name="length" value="<?=$editlisting['length']==""?VALLID_DAYS:$editlisting['length']?>" class="smalltextField" readonly /></td>
    </tr>
	<?	
		if($CAT['add_space']!='1'){
	?>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<tr>
      <td width="100%" align="left" class="txtLabel">Buy It Now Price - BIN </td>
      <td width="68%" align="left">$<input type="text" name="buyer_price" value="<?=isset($_REQUEST['buyer_price']) ? $_REQUEST['buyer_price'] : $editlisting['buyer_price']?>" class="smalltextField" onkeypress="return keyRestrict(event,'1234567890.')" /></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	
	<tr>
      <td width="100%" align="left" class="txtLabel" valign="top">Paypal Email Address </td>
      <td width="68%" align="left"><input type="text" name="paypal_email" value="<?=isset($_REQUEST['paypal_email'])? $_REQUEST['paypal_email'] : $editlisting['paypal_email']?>" class="largetextField" /></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<? }?>
    <tr>
      <td width="100%" align="left" class="txtLabel">Company or Your Name  </td>
      <td width="68%" align="left"><input type="text" name="company_name" value="<?=isset($_REQUEST['company_name']) ? $_REQUEST['company_name'] : $editlisting['company_name']?>" class="largetextField" /></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="100%" align="left" class="txtLabel">URL of Website</td>
      <td width="68%" align="left"><input type="textLabel" name="website" value="<?=isset($_REQUEST['website']) ? $_REQUEST['website'] : $editlisting['website']?>" class="largetextField" /><span class="text-small">(Ex:http://www.websitename.com)</span></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<?	
		if($CAT['add_space']!='1'){
	?>
	<tr>
      <td width="100%" align="left" class="txtLabel">Logo</td>
      <td width="68%" align="left"><input type="file" name="site_img" /> <? 
	  if($editlisting['site_img']!=""){ ?><img src="websiteImage/thumb<?=$editlisting['site_img']?>" border="0" align="absmiddle" />  <? }?></td>
    </tr>
	<tr>
      <td width="100%" align="left" style="height:5px;"></td>
      <td width="68%" align="left"></td>
    </tr>
    <tr>
      <td width="100%" align="left" class="txtLabel">Visitors</td>
      <td width="68%" align="left"><input type="text" name="visitor" value="<?=isset($_REQUEST['visitor']) ? $_REQUEST['visitor'] : $editlisting['visitor']?>" class="largetextField" />Daily</td>
    </tr>
	<tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>
	
	 <tr>
     <td width="100%" align="left" class="txtLabel">Page Views</td>
     <td width="68%" align="left"><input name="traffic_pages" type="text" class="textbox2" value="<?=$arr['traffic_pages']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')" />
Daily</td>
  </tr>
	<tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>
	  
	   <tr>
    <td width="100%" align="left" class="txtLabel">Income</td>
    <td width="68%" align="left"><input name="income_month" type="text" class="textbox2" value="<?=$arr['income_month']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')">
	US$ Per Month</td>
  </tr>
	  
	<tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>
	  
	  <tr>
     <td width="100%" align="left" class="txtLabel">Cost to run site</td>
    <td width="68%" align="left"><input name="run_cost" type="text" class="textbox2" value="<?=$arr['run_cost']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')"/>
US$ Per Month</td>
  </tr>
  
	  
	  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>  
	  
	  <tr>
     <td width="100%" align="left" class="txtLabel">Disk Space used</td>
    <td width="68%" align="left"><input name="disk_space" type="text" class="textbox2" value="<?=$arr['disk_space']?>" size="10" onKeyPress="return keyRestrict(event,'1234567890.')"/>
			MB</td>
  </tr>
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>
  <tr>
     <td width="100%" align="left" class="txtLabel">Bandwidth used</td>
    <td width="68%" align="left"><input name="bandwidth" type="text" class="textbox2" value="<?=$arr['bandwidth']?>" size="10" onKeyPress="return keyRestrict(event,'1234567890.')"/>
			MB per month</td>
  </tr>
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>
  <tr>
     <td width="100%" align="left" class="txtLabel">Members</td>
   <td width="68%" align="left"><input name="site_members" type="text" class="textbox2" value="<?=$arr['site_members']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')"/>
			Total number of members</td>
  </tr>
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>

<tr>
     <td width="100%" align="left" class="txtLabel">Business 
	Information</td>
     <td width="68%" align="left">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td width="200"><strong>Income from: </strong><span class="smalltext"><br>            
		    <input type="checkbox" name="income_1" value="1" <? if($arr['income_1']=='1'){?>checked<? } ?>>
		Selling Products<br>          
		<input type="checkbox" name="income_2" value="1" <? if($arr['income_2']=='1'){?>checked<? } ?>>          
		Selling Access to Site<br>          
		<input type="checkbox" name="income_3" value="1" <? if($arr['income_3']=='1'){?>checked<? } ?>>          
		Selling Site-related Services<br>          
		<input type="checkbox" name="income_4" value="1" <? if($arr['income_4']=='1'){?>checked<? } ?>>
		Selling Non-Site-related Services<br>          
		<input type="checkbox" name="income_5" value="1" <? if($arr['income_5']=='1'){?>checked<? } ?>>
		Other<br>          
		<input type="checkbox" name="income_6" value="1" <? if($arr['income_6']=='1'){?>checked<? } ?>>
		No Income</span></td>
		<td width="140"><strong>Sold with website: </strong><br>            
		<input type="checkbox" name="sold_1" value="1" <? if($arr['sold_1']=='1'){?>checked<? } ?>>
		<span class="smalltext">		Business<br>          
		<input type="checkbox" name="sold_2" value="1" <? if($arr['sold_2']=='1'){?>checked<? } ?>>
		Images &amp; Content<br>          
		<input type="checkbox" name="sold_3" value="1" <? if($arr['sold_3']=='1'){?>checked<? } ?>>
		Software<br>          
		<input type="checkbox" name="sold_4" value="1" <? if($arr['sold_4']=='1'){?>checked<? } ?>>
		Tradenamed<br>          
		<input type="checkbox" name="sold_5" value="1" <? if($arr['sold_5']=='1'){?>checked<? } ?>>
		Original Graphics<br>          
		<input type="checkbox" name="sold_6" value="1" <? if($arr['sold_6']=='1'){?>checked<? } ?>>
		3<sup>rd</sup> party Licenses</span><br>        </td>
		<td><strong>Site owns</strong>:<br>            
		<input type="checkbox" name="own_content" value="1" <? if($arr['own_content']=='1'){?>checked<? } ?>>
		<span class="smalltext">All Content<br>          
		<input type="checkbox" name="own_server" value="1" <? if($arr['own_server']=='1'){?>checked<? } ?>>
		Server</span><br></td>
		</tr>
		</table>
	</td>
  </tr>
	  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>	  

<tr>
    <td width="100%" align="left" class="txtLabel">About Us </td>
   <td width="68%" align="left"><input type="text" name="aboutus"  size="30" class="input" value="<?=$arr['aboutus']?>"/></td>
  </tr>
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>	 
  <tr>
    <td width="100%" align="left" class="txtLabel">Product Page </td>
    <td width="68%" align="left"><input type="text" name="product_page"  size="30" class="input" value="<?=$arr['product_page']?>"/></td>
  </tr>
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>	 
  <tr>
    <td width="100%" align="left" class="txtLabel">Faq</td>
   <td width="68%" align="left"><input type="text" name="faq"  size="30" class="input" value="<?=$arr['faq']?>"/></td>
  </tr>
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>	 
  <tr>
    <td width="100%" align="left" class="txtLabel">Contact us </td>
    <td width="68%" align="left"><input type="text" name="contact_us"  size="30" class="input" value="<?=$arr['contact_us']?>"/></td>
  </tr>
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>	 
  <tr>
    <td width="100%" align="left" class="txtLabel">Contact Email </td>
    <td width="68%" align="left"><input type="text" name="contact_email"  size="30" class="input" value="<?=$arr['contact_email']?>"/></td>
  </tr>	
  <tr>
	  <td width="100%" align="left" style="height:5px;"></td>
	  <td width="68%" align="left"></td>
	  </tr>	  

	  
	<? }?>
	<tr>
	  <td colspan="2" align="left" class="subheader">New Listing Upgrades </td>
	  </tr>
	<tr>
      <td width="100%" align="left" style="height:10px;"></td>
      <td width="68%" align="left"></td>
    </tr>
	<tr>
      <td width="100%" align="left" class="txtLabel"><p>Get more exposure!</p></td>
      <td width="68%" align="left" valign="top">
	  <table width="100%" border="0" cellspacing="5" cellpadding="4">
					 <tr>
                        <td><input type="checkbox" name="featured" value="1" <? if($editlisting['featured']==1 || isset($_REQUEST['featured'])){?>checked="checked"<? }?> /></td>
                        <td align="left"><span class="text-bold">Listing Featured On Homepage Fee: </span><span class="error">(<?=FEE_FEATURED?> credits)</span></td>
              </tr>
					  <tr>
                        <td>
						<input type="checkbox" name="highlight" value="1" <? if($editlisting['highlight']==1 || isset($_REQUEST['highlight'])){?>checked="checked"<? }?> /></td>
                        <td align="left"><span class="text-bold">Listing in Highlighted Fee : </span><span class="error">(<?=FEE_HIGHLIGHTED?> credits)</span></td>
                      </tr>
                      <tr>
                        <td width="6%">
						<input type="checkbox" name="bold" value="1" <? if($editlisting['bold']==1 || isset($_REQUEST['bold'])){?>checked="checked"<? }?> /></td>
                        <td width="94%" align="left"><span class="text-bold">Listing in Bold Fee : </span><span class="error">(<?=FEE_BOLD?> credits)</span></td>
                      </tr>
					  <tr>
                        <td><input type="checkbox" name="rowborder" value="1" <? if($editlisting['rowborder']==1 || isset($_REQUEST['rowborder'])){?>checked="checked"<? }?> /></td>
                        <td align="left"><span class="text-bold">Listing in Row Border Fee: </span><span class="error">(
                        <?=FEE_ROWBORDER?> credits)</span></td>
                      </tr>
            </table>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSubmit" value="Continue" />
        &nbsp;&nbsp;
        <input type="reset" name="btnReset" value="Reset" />      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
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
