<?
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
		$mail_From= $_REQUEST['email'];
		$mail_subject="Contact from FreshAuction";
		$mail_To=ADMIN_EMAIL;
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
			<td width="100%">Name: '.$_REQUEST['name'].'</td>
			</tr>
			<tr>
			<td width="100%">Email: '.$_REQUEST['email'].'</td></tr>
			<tr>
			<td width="100%">Cause : '.$_REQUEST['find'].'</td>
			</tr>
			<tr>
			<td width="100%">Subject : '.$_REQUEST['subject'].'</td></tr>
			<tr>
			<td width="100%">Message: </td></tr>
			<tr>
			<td width="100%"><strong>'.$_REQUEST['message'].'</strong></td></tr>
			<tr>
			<td width="100%">&nbsp;</td></tr>
			<tr>
			<td width="100%">
			Best Regards,
			</td>
			</tr>
			<tr>
			<td width="100%">'.$_REQUEST['name'].'</td>
			</tr>
			</table>
			</body>
			</html>';
			Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
			//print $mail_Body;
			$msg=successfulMessage("Your message has been sent. Expect a reply within 12 hours.");
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
<script type="text/javascript">
function dochk()
{
	if(document.frm.name.value=="")
	{
	alert("Please Enter Your Name");
	document.frm.name.focus();
	return false;
	}
	else if(document.frm.email.value=="")
	{
	alert("Please Enter Your Email");
	document.frm.email.focus();
	return false;
	}
	else if(!emailCheck(document.frm.email))
	{
	document.frm.email.focus();
	return false;
	}
	else if(document.frm.find.value=="")
	{
	alert("Please Enter what you find");
	document.frm.find.focus();
	return false;
	}
	else if(document.frm.subject.value=="")
	{
	alert("Please Enter Your Subject");
	document.frm.subject.focus();
	return false;
	}
	else if(document.frm.message.value=="")
	{
	alert("Please Enter Your Message");
	document.frm.message.focus();
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
<p><span class="header_text_h"><?=static_cms_title(21)?></span>
  </p>
<h2 align="center">&nbsp;</h2>
<form name="frm" method="post" action="">
					<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
					
					 <tr>
        <td colspan="4" align="center" valign="top"><?=$msg?></td>
        </tr>
  <tr>
    <td width="8%" align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td width="26%" align="left" valign="top" class="txtLabel">Name : </td>
    <td width="66%" align="left" valign="top"><input type="text" name="name" value="<?=$_REQUEST['name']?>" size="30"></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top" class="txtLabel">Email : </td>
    <td align="left" valign="top"><input type="text" name="email" value="<?=$_REQUEST['email']?>" size="30"></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top" class="txtLabel">How did you find us? : </td>
    <td align="left" valign="top"><input type="text" name="find" value="<?=$_REQUEST['find']?>" size="30"></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top" class="txtLabel">Subject : </td>
    <td align="left" valign="top"><input type="text" name="subject" value="<?=$_REQUEST['subject']?>" size="30"></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top" class="txtLabel">Message : </td>
    <td align="left" valign="top"><textarea name="message" cols="50" rows="15"><?=$_REQUEST['message']?></textarea></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top" class="txtLabel">Security Code : </td>
    <td align="left" valign="top" id="imgco"><img src="image_code.php?txt=<?=$checkCode?>" align="absmiddle" /><a href="javascript: void(0)" onClick="imgcode()"><img src="images/refresh.png" alt="Click To refresh the image" width="16" height="16" border="0" align="absmiddle" /></a>&nbsp;
    <input type="text" name="captcha_code" size="10" class="inputTextBox" onFocus="showdiv('captcha')" /><input type="hidden" name="capture_value" value="<?=$checkCode?>">    <span id="capt"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top"><input type="submit" value="Send Message" name="btnSubmit" onClick="return dochk()" class="button"  />&nbsp;<input type="reset" name="reset" value="Reset" class="button" /></td>
  </tr>
  <tr>
		<td colspan="4" align="left" valign="top"><?=statica_cms_page_value(21)?></td>
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
