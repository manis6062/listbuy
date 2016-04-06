<?
error_reporting(0);
	require_once('config/config.php');
	function makeRandomWord($size) {
		$salt = "ABCHEFGHJKMNPQRSTUVWXYZ0123456789abchefghjkmnpqrstuvwxyz";
		srand((double)microtime()*1000000);
		$word = '';
		$i = 0;
		while (strlen($word)<$size) {
			$num = rand() % 59;
			$tmp = substr($salt, $num, 1);
			$word = $word . $tmp;
			$i++;
		}
		return $word;
	}
	$checkCode = makeRandomWord(5);
	$random=rand().$_SESSION['checkCode'];

	
	
if(isset($_REQUEST['btnSubmit']))
{
	if($_REQUEST['capture_value']==$_REQUEST['captcha_code'])
	{
		$where_clause = "email='".escapeQuotes(stripslashes(trim($_REQUEST['email'])))."' OR 
		username='".escapeQuotes(stripslashes(trim($_REQUEST['username'])))."'";
		$record = Select_Qry("*",USER,$where_clause,"","","","");
		
		if($record != '')
		{
			$msg=errorMessage("username or email address already exists!.");
		}
		else
		{
		$act=rand(99999999,99999999999);
		$set="username='".escapeQuotes(stripslashes(trim($_REQUEST['username'])))."',
			  first_name='".escapeQuotes(stripslashes(trim($_REQUEST['first_name'])))."',
			  last_name='".escapeQuotes(stripslashes(trim($_REQUEST['last_name'])))."',
			  email='".escapeQuotes(stripslashes(trim($_REQUEST['email'])))."', 
			  password='".escapeQuotes(stripslashes(trim($_REQUEST['password'])))."',
			  st_add='".escapeQuotes(stripslashes(trim($_REQUEST['st_add'])))."',
			  city='".escapeQuotes(stripslashes(trim($_REQUEST['city'])))."',
			  state='".$_REQUEST['state']."',
			  country='".$_REQUEST['country']."',
			  zip='".escapeQuotes(stripslashes(trim($_REQUEST['zip'])))."',
			  phone='".escapeQuotes(stripslashes(trim($_REQUEST['phone'])))."',
			  activation='".$act."'";
			  
			  if($_FILES['avatar']['name']!="")
			  {
				$wdir="avatar/";
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
				  
		$uid=Insert_Qry(USER,$set);
		
		$mail_To=$_REQUEST['email'];
		$mail_From= ADMIN_EMAIL;
		$mail_subject="New Registration at ".WEB_ADDRESS;
		$mail_Body='<html>
			<head>
			<title></title>
			<style type="text/css">
			.font
			{
				FONT-FAMILY:tahoma, helvetica, sans-serif;
	    		FONT-SIZE:10pt;
				FONT-WEIGHT:normal;
				COLOR:black;
			}
			</style>
			</head>
			<body>
			<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
			<tr><td width="100%">&nbsp;</td></tr>
			<tr>
		<td width="100%">Dear '.$_REQUEST['first_name'].' '.$_REQUEST['last_name'].',</td>
			</tr>
			<tr>
			<td width="100%">Thank You for registering with '.WEB_ADDRESS.'.</td>
			</tr>
			<tr>
			<td width="100%">To activate your account please click on the following link:</td>
			</tr>
			<tr>
			<td width="100%"><a href="http://'.WEB_ADDRESS.'/activate.php?email='.$_REQUEST['email'].'&act='.$act.'" target="_blank">http://'.WEB_ADDRESS.'/activate.php</a></td></tr>
			<tr>
			<td width="100%">
			Thank You,
			</td>
			</tr>
			<tr>
			<td width="100%">'.WEB_ADDRESS.'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To,$mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
			
			/*$link=$GLOBALS['HOST']."activate.php?act=$act&u=".base64_encode($uid);
Global_Mail(escapeQuotes(stripslashes($_REQUEST['email'])),escapeQuotes(stripslashes($_REQUEST['username'])),'24',$act,"registration",$link);*/
			
				echo"<script type='text/javascript'>window.location.href='register-thankyou.php'</script>";
			}
	}
	else
	{
	$msg=errorMessage("Invalid Code!");
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
<script language="javascript" src="ajax_imgcode.js"></script>
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
	else if(document.frm.password.value=="")
	{
	alert("Please enter password");
	document.frm.password.focus();
	return false;
	}
	else if(document.frm.conpassword.value=="")
	{
	alert("Please enter confirm password");
	document.frm.conpassword.focus();
	return false;
	}
	else if(document.frm.conpassword.value != document.frm.password.value)
	{
	alert("Password mismatch");
	document.frm.conpassword.focus();
	return false;
	}
	/*else if(document.frm.avatar.value=="")
	{
	alert("Please upload avatar");
	return false;
	}*/
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
	else if(document.frm.captcha_code.value=="")
	{
	alert("Please enter The Code shown above.");
	document.frm.captcha_code.focus();
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
<p><span class="header_text_h">Free Registration</span></p>
<form name="frm" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
  <tr>
    <td colspan="3" align="left" class="subheader">Login Information</td>
  </tr>
  <?
  	if($msg!=''){
  ?>
   <tr>
    <td colspan="3" align="center"><?=$msg?></td>
  </tr>
  <?
  	}
  ?>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Desired Username</td>
    <td width="63%" align="left"><input type="text" name="username" class="smalltextField" value="<?=$_REQUEST['username']?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel">Password</td>
    <td align="left"><input type="password" name="password" class="smalltextField" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel">Confirm Password</td>
    <td align="left"><input type="password" name="conpassword" class="smalltextField" value="" /></td>
  </tr>
  <tr>
    <td colspan="3" align="left" class="subheader">Personal Information</td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Your Image/Logo</td>
    <td width="63%" align="left"><input type="file" name="avatar" /></td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">First Name </td>
    <td width="63%" align="left"><input type="text" name="first_name" class="smalltextField" value="<?=$_REQUEST['first_name']?>" /></td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Last Name </td>
    <td width="63%" align="left"><input type="text" name="last_name" class="smalltextField" value="<?=$_REQUEST['last_name']?>" /></td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Street Address </td>
    <td width="63%" align="left"><input type="text" name="st_add" class="smalltextField" value="<?=$_REQUEST['st_add']?>" /></td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">City</td>
    <td width="63%" align="left"><input type="text" name="city" class="smalltextField" value="<?=$_REQUEST['city']?>" /></td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Country</td>
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
						var CType="<?=$_REQUEST['country']?>";
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
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">State / Province</td>
    <td width="63%" id="TxtState" align="left">
				   <select name="state">
				   <option value=""selected>-Select State-</option>
				   <?
					$statelist=Listing_Qry("*",STATE," WHERE countryId_fk='".$record['country']."'","");
					foreach($statelist as $state){
				   ?>
					
				   <option value="<?=$state['stateId']?>"><?=$state['stateName']?></option>
				   <? } ?>
				   </select>
	    <script language="JavaScript">
						var CType="<?=$_REQUEST['state']?>";
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
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Zip / Postal Code</td>
    <td width="63%" align="left"><input type="text" name="zip" class="smalltextField" value="<?=$_REQUEST['zip']?>" /></td>
  </tr>
   <tr>
    <td colspan="3" align="left" class="subheader">Contact Information</td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Email</td>
    <td width="63%" align="left"><input type="text" name="email" class="smalltextField" value="<?=$_REQUEST['email']?>" /></td>
  </tr>
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="20%" align="left" class="txtLabel">Phone Number</td>
    <td width="63%" align="left"><input type="text" name="phone" class="smalltextField" value="<?=$_REQUEST['phone']?>" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel">Security Code</td>
    <td align="left" id="imgco"><img src="image_code.php?txt=<?=$checkCode?>" align="absmiddle" /><a href="javascript: void(0)" onClick="imgcode()"><img src="images/refresh.png" alt="Click To refresh the image" width="16" height="16" border="0" align="absmiddle" /></a>&nbsp;
    <input type="text" name="captcha_code" size="10" class="inputTextBox" onFocus="showdiv('captcha')" /><input type="hidden" name="capture_value" value="<?=$checkCode?>">    <span id="capt"></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSubmit" value="Submit"  onclick="return doRegister();"/>
      &nbsp;&nbsp;
      <input type="reset" name="btnReset" value="Reset" />    </td>
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
