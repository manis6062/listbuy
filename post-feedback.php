<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if($_REQUEST['u']=='' && $_REQUEST['add_id'])
	{
		header('location:mylistings.php');
	}
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
	
	$feed_arr=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	if(isset($_REQUEST['btnSubmit']))
	{
		if($_REQUEST['capture_value']==$_REQUEST['captcha_code'])
		{
		$where="user_id='".$feed_arr['user_id']."' AND posted_by='".$_SESSION['user_id']."' AND add_id='".$_REQUEST['add_id']."'";
			$chk=Select_Qry("*",USER_FEEDBACK,$where,"","","","");
			if($chk!='')
			{
			 $msg=successfulMessage("You have already posted feedback for this Listing.");		
			}
			else
			{
			$set="user_id='".base64_decode($_REQUEST['u'])."',
				posted_by='".$_SESSION['user_id']."',
				add_id='".$_REQUEST['add_id']."',
				subject='".escapeQuotes(stripslashes(trim($_REQUEST['subject'])))."',
				comment='".escapeQuotes(stripslashes(trim($_REQUEST['comment'])))."',
				rate='".$_REQUEST['rate']."'";
				Insert_Qry(USER_FEEDBACK,$set);
				$msg=successfulMessage("Your feedback has been posted.");    
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
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" src="ajax_imgcode.js"></script>
<script type="text/javascript">
function goChk()
{
	if(document.frm.subject.value=="")
	{
	alert("Please enter subject");
	document.frm.subject.focus();
	return false;
	}
	/*else if(document.frm.comment.value=="")
	{
	alert("Please enter subject");
	document.frm.comment.focus();
	return false;
	}*/
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

/*tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,insertdate,inserttime,|,forecolor,backcolor",
		//theme_advanced_buttons2 : "bullist,numlist,|,insertdate,inserttime,|,forecolor,backcolor",
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
	});*/
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
<p><span class="header_text_h">Post Feedback</span>
  </p>
<p align="center">

<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
  <tr>
    <td align="left" valign="top" colspan="2">
	<?
		
	/*$where="user_id='".$feed_arr['user_id']."' AND posted_by='".$_SESSION['user_id']."' AND add_id='".$_REQUEST['add_id']."'";
	$chk=Select_Qry("*",USER_FEEDBACK,$where,"","","","");
	if($chk!='')
	{
		 echo successfulMessage("You had already posted feedback against this Listing. Click to go <a href='Javascript:history.back();'>back</a>");	
	}
	else{*/
	if($msg!=''){
		echo $msg;
	}else{
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="5" class="border">
  <tr>
    <td colspan="2" align="left" valign="top"></td>
    </tr>
	
	<tr>
    <td width="21%" align="left" valign="top" class="txtLabel">User</td>
    <td width="79%" align="left" valign="top"><strong><?=USERNAME(base64_decode($_REQUEST['u']))?></strong></td>
  </tr>
  <tr>
    <td width="21%" align="left" valign="top" class="txtLabel">Subject</td>
    <td width="79%" align="left" valign="top"><input type="text" name="subject" value="" size="30" /></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">Comment</td>
    <td align="left" valign="top"><textarea name="comment" cols="40" rows="10"></textarea></td>
  </tr>
  <tr>
    <td width="21%" align="left" valign="top" class="txtLabel">Rate Your Feedback</td>
    <td width="79%" align="left" valign="top"><input type="radio" name="rate" value="1" /> 
    Positive (1) &nbsp;
    <input type="radio" name="rate" value="0" checked="checked" /> 
    Neutral (0) &nbsp;
    <input type="radio" name="rate" value="2" /> 
    Negetive (-1)</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="txtLabel">Image Verification</td>
    <td align="left" valign="top" id="imgco"><img src="image_code.php?txt=<?=$checkCode?>" align="absmiddle" /><a href="javascript: void(0)" onClick="imgcode()"><img src="images/refresh.png" alt="Click To refresh the image" width="16" height="16" border="0" align="absmiddle" /></a>&nbsp;
    <input type="text" name="captcha_code" size="10" class="inputTextBox" onFocus="showdiv('captcha')" /><input type="hidden" name="capture_value" value="<?=$checkCode?>">    <span id="capt"></span></td>
  </tr>
  <?php /*?><tr>
    <td align="left" valign="top" class="txtLabel">Security Code</td>
    <td align="left" valign="top"><input type="text" name="security_code"  id="security_code" class="smalltextField" value="" /></td>
  </tr><?php */?>
  <tr>
    <td align="left" valign="top" class="txtLabel">&nbsp;</td>
    <td align="left" valign="top"><input type="submit" name="btnSubmit" value="Post Feedback"  onclick="return goChk()"/>&nbsp;<input type="button" name="cancel" value="Cancel" onclick="window.location.href='./<?=remspace($_REQUEST['add_id'])?>'" /></td>
  </tr>
  
</table>
	<? }?>
</td>
    </tr>
  <tr>
    <td align="left" valign="top" colspan="2">&nbsp;</td>
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
