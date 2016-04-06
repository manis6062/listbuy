<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	$avatar_un=Select_Qry("*",USER,"user_id='".$_SESSION['user_id']."'","","","","");
if(isset($_REQUEST['btnSubmit']))
{
	$where_clause = "(email='".escapeQuotes(stripslashes(trim($_REQUEST['email'])))."' OR 
		username='".escapeQuotes(stripslashes(trim($_REQUEST['username'])))."') AND user_id <>'".$_SESSION['user_id']."'";
		$record = Select_Qry("*",USER,$where_clause,"","","","");
		
		if($record != '')
		{
			$msg=errorMessage("Username or Email address already exists!!!.");
		}
		else
		{
		$set="username='".escapeQuotes(stripslashes(trim($_REQUEST['username'])))."',
			  first_name='".escapeQuotes(stripslashes(trim($_REQUEST['first_name'])))."',
			  last_name='".escapeQuotes(stripslashes(trim($_REQUEST['last_name'])))."',
			  email='".escapeQuotes(stripslashes(trim($_REQUEST['email'])))."', 
			  st_add='".escapeQuotes(stripslashes(trim($_REQUEST['st_add'])))."',
			  city='".escapeQuotes(stripslashes(trim($_REQUEST['city'])))."',
			  state='".$_REQUEST['state']."',
			  country='".$_REQUEST['country']."',
			  zip='".escapeQuotes(stripslashes(trim($_REQUEST['zip'])))."',
			  phone='".escapeQuotes(stripslashes(trim($_REQUEST['phone'])))."'";
			  
			  if($_FILES['avatar']['name']!="")
			  {
				$wdir="avatar/";
				@unlink("avatar/small_".$avatar_un['avatar']);
			    @unlink("avatar/thumb_".$avatar_un['avatar']);
				$file_type = $_FILES['avatar']['type'];
				$file_type = $_FILES['avatar']['type'];
				$file_name = $_FILES['avatar']['name'];
				$file_size = $_FILES['avatar']['size'];
				$file_tmp = $_FILES['avatar']['tmp_name'];
				$ext=getext($_FILES['avatar']['name']);
				$imagname=rand()."_".date("m_d_Y").$ext;
				image_resize($wdir."small_",70,$file_type,$file_name,$file_size,$file_tmp,$imagname);
				image_resize($wdir."thumb_",100,$file_type,$file_name,$file_size,$file_tmp,$imagname);
				$set.=",avatar ='".$imagname."'";
				}
				  
		Update_Qry(USER,$set,"WHERE user_id='".$_SESSION['user_id']."'");
		$msg=successfulMessage('<b>Your profile has been updated.</b>');
		}
 }
$record=Select_Qry("*",USER,"user_id='".$_SESSION['user_id']."'","","","","");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?=META_KEYWORDS?>"/>
<meta name="description" content="<?=META_CONTENT?>"/>
<link href="css/fresh-auction.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/validate_email.js"></script>
<script type="text/javascript" src="js/ajax_state.js"></script>
<script type="text/javascript">
function doRegister()
{
	if(document.frm.username.value=="")
	{
	alert("Please enter username");
	document.frm.username.focus();
	return false;
	}
	else if(document.frm.first_name.value=="")
	{
	alert("Please enter first name");
	document.frm.first_name.focus();
	return false;
	}
	else if(document.frm.last_name.value=="")
	{
	alert("Please enter last name");
	document.frm.last_name.focus();
	return false;
	}
	else if(document.frm.st_add.value=="")
	{
	alert("Please enter street address");
	document.frm.st_add.focus();
	return false;
	}
	else if(document.frm.city.value=="")
	{
	alert("Please enter city");
	document.frm.city.focus();
	return false;
	}
	else if(document.frm.country.value=="")
	{
	alert("Please select country");
	return false;
	}
	else if(document.frm.state.value=="")
	{
	alert("Please select state");
	return false;
	}
	else if(document.frm.zip.value=="")
	{
	alert("Please enter zip code");
	document.frm.zip.focus();
	return false;
	}
	else if(document.frm.email.value=="")
	{
	alert("Please enter your email");
	document.frm.email.focus();
	return false;
	}
	else if(!emailCheck(document.frm.email))
	{
	document.frm.email.focus();
	return false;
	}
	else if(document.frm.phone.value=="")
	{
	alert("Please enter phone no.");
	document.frm.phone.focus();
	return false;
	}
	else
	{
	return true;
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
<p><span class="header_text_h">Edit Profile</span></p>
<form name="frm" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
  <tr>
    <td colspan="3" align="left"><?=$msg?></td>
  </tr>
  <tr>
    <td colspan="3" align="left" class="subheader">Login Information</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Username</td>
    <td width="63%" align="left"><input type="text" name="username" value="<?=$record['username']?>" /></td>
  </tr>
  <tr>
    <td colspan="3" align="left" class="subheader">Personal Information</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Avatar</td>
    <td width="63%" align="left"><input type="file" name="avatar">
	<?
	if($record['avatar']!="")
	{
	?>
	<img src="avatar/<?=$record['avatar']!=""?'small_'.$record['avatar']:"noimage.jpeg"?>" border="0" align="absmiddle" /><?
	}
	?></td>
	
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">First Name </td>
    <td width="63%" align="left"><input type="text" name="first_name" value="<?=$record['first_name']?>" /></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Last Name </td>
    <td width="63%" align="left"><input type="text" name="last_name" value="<?=$record['last_name']?>" /></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Street Address </td>
    <td width="63%" align="left"><input type="text" name="st_add" value="<?=$record['st_add']?>" /></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">City</td>
    <td width="63%" align="left"><input type="text" name="city" value="<?=$record['city']?>" /></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Country</td>
    <td width="63%" align="left"><select name="country" onchange="showState(this.value)">
      <option value="" selected>Select Country</option>
      <?php 
							  $sql_country="select * from ".COUNTRY;
							  $rs_country=mysql_query($sql_country);
							  if(mysql_num_rows($rs_country)>0)
							  {
							  while($arr_country=mysql_fetch_array($rs_country))
							   {
							  echo("<option value='".$arr_country['countryId']."'>".$arr_country['countryName']."</option>");
							   }
							  }
						?>
    </select>
        <script language="JavaScript">
						var CType="<?=$record['country']?>";
						for (var i=0; i<document.frm.country.options.length; i++)
							{
								if (document.frm.country.options[i].value==CType)
									{		
										document.frm.country.options[i].selected=true;
										break;
									}
							}
					</script></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">State</td>
    <td width="63%" id="TxtState" align="left">
	<?
	if($_REQUEST['country']!="")
	{
	$country=$_REQUEST['country'];
	}
	else
	{
	$country=$record['country'];
	}
	?>
				   <select name="state">
				   <option value=""selected>-Select State-</option>
				   <?
	$statelist=Listing_Qry("*",STATE," WHERE countryId_fk='".$country."'","");
					foreach($statelist as $state){
				   ?>
					
				   <option value="<?=$state['stateId']?>"><?=$state['stateName']?></option>
				   <? } ?>
				   </select>
	    <script language="JavaScript">
						var CType="<?=$record['state']?>";
						for (var i=0; i<document.frm.state.options.length; i++)
							{
								if (document.frm.state.options[i].value==CType)
									{		
										document.frm.state.options[i].selected=true;
										break;
									}
							}
					</script></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Zip</td>
    <td width="63%" align="left"><input type="text" name="zip" value="<?=$record['zip']?>" /></td>
  </tr>
   <tr>
    <td colspan="3" align="left" class="subheader">Contact Information</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Email</td>
    <td width="63%" align="left"><input type="text" name="email" value="<?=$record['email']?>" /></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="17%" align="left" class="txtLabel">Phone</td>
    <td width="63%" align="left"><input type="text" name="phone" value="<?=$record['phone']?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSubmit" value="Submit" onclick="return doRegister()" />
      &nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" onclick="window.location.href='my-account.php'" />    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<p align="center">

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
