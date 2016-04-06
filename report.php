<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
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
	if(isset($_REQUEST['btncomment']))
		{
			if($_REQUEST['comment']==''){
				$msg="Please Write Content.";
			}
			else{
				if($_REQUEST['capture_value']==$_REQUEST['captcha_code'])
				{
				 $value = "add_id = '".$_REQUEST['add_id']."',
						   user_id='".$_SESSION['user_id']."',
						   message='".$_REQUEST['comment']."',posted_on=NOW()";
				 Insert_Qry(TERM_VIOLATION,$value);
				 //////////////////
					$mail_To = ADMIN_EMAIL;
					$mail_From= USEREMAIL($_SESSION['user_id']);
					$mail_subject="Listing abuse of ".ADDTITLE($_REQUEST['add_id'])." from ".WEB_ADDRESS;
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
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="font">
					<tr>
					<td width="100%"><font color="#000000">Site Abuse</font>
					</td>
					</tr>
					<tr><td width="100%">&nbsp;</td></tr>
					<tr>
					<td width="100%">
					A user has filed a listing abuse claim against : <a href="http://'.WEB_ADDRESS.'./'.remspace($_REQUEST['add_id']).'" target="_blank"> Click to the view listing</a>. 
					</td>
					</tr>
					<tr>
					<td width="100%">&nbsp;</td></tr>
					<tr>
					<td width="100%">User name : '.USERNAME($_SESSION['user_id']).'</td></tr>
					<td width="100%">Message : '.$_REQUEST['comment'].'</td>
					</tr>
					<tr>
					<td width="100%">&nbsp;</td></tr>
					</table>
					</body>
					</html>';
					$msg=successfulMessage("Your comment has been sent to webmaster. We appreciate your submission, it will be reviewed within a few hours.");
					Send_HTML_Mail(ADMIN_EMAIL, $mail_From, '', $mail_subject, $mail_Body);
					}
					else
					{
						$msg=errorMessage("Invalid Code!");
					}
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
function chk()
 { 
   if(document.frm.comment.value == '')
   {
    alert('Please provide comment');
	document.frm.comment.focus();
	return false;
   }
   else
   {
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
<p style="height:42px;">&nbsp;</p>
<div style="vertical-align:top;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="3" align="left" width="100%" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td width="45%" valign="top"><a href="index.php">Fresh Auction</a> >> Shortlist for <?=ADDTITLE($_REQUEST['add_id'])?></td>
    <td align="left" valign="top" style="border-left:1px solid #EBEBEB;">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="13%" align="left" valign="top"><img src="avatar/<?=AVATAR($_SESSION['user_id'])!=""?'thumb_'.AVATAR($_SESSION['user_id']):"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"></td>
    <td width="87%" align="left" valign="middle"><?=USERNAME($_SESSION['user_id'])?>(<a href="compose-message.php?add_id=<?=$record['add_id']?>" class="user_menu">Private Messages</a>)<br />
      You have <?=CREDIT($_SESSION['user_id'])?> auction credits. <a href="buycredit.php" class="green">Buy more credits</a></td>
  </tr>
</table>

	</td>
  </tr>
</table>
</td></tr>
<tr><td colspan="3" align="right" width="100%" valign="top" style="height:5px;"></td></tr>
<tr><td colspan="3" align="right" width="100%" valign="top">
<table width="60%" border="0" cellspacing="0" cellpadding="4" class="border">
  <tr>
    <td style="border-right:1px solid #EBEBEB;"><a href="short-list.php" class="user_menu">My Shortlist</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="subscription-list.php" class="user_menu">My Subscriptions</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="mylistings.php" class="user_menu">My Activity</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="user-profile.php" class="user_menu">My Account</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="my-message.php?mode=inbox" class="user_menu">My Messages</a></td>
    <td><a href="logout.php" class="user_menu">Logout</a></td>
  </tr>
</table>
</td></tr>
</table>
</div>
<p align="center">
<form name="frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center" class="border">
<tr>
    <td align="left" colspan="2" valign="top" class="header_text_h">Report a Listing </td>
  </tr>
  <tr>
    <td align="left" colspan="2" valign="top"></td>
  </tr>
  <tr>
    <td align="left" colspan="2" valign="top">
	<?=statica_cms_page_value(22)?> </td>
  </tr>
  <tr>
    <td align="left" colspan="2" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="3" align="left">
	<?
		if($msg!=''){
	?>
	<tr>
            <td align="center" class="error"><?=$msg?></td>
          </tr>
	<? }?>
          <tr>
            <td align="left" class="txtLabel">We appreciate your assistance!</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="text-small"><input type="text" name="user_name" size="61" class="largetextField" readonly value="<?=USERNAME($_SESSION['user_id'])?>" />
            * (Name) </td>
          </tr>
          <tr>
            <td valign="top" align="left"><textarea name="comment" id="comment" cols="75" rows="10"></textarea>
             * </td>
          </tr>
		   <tr>
            <td align="left" valign="top" class="txtLabel" id="imgco"><img src="image_code.php?txt=<?=$checkCode?>" align="absmiddle" /><a href="javascript: void(0)" onClick="imgcode()"><img src="images/refresh.png" alt="Click To refresh the image" width="16" height="16" border="0" align="absmiddle" /></a>&nbsp;
    <input type="text" name="captcha_code" size="10" class="inputTextBox" onFocus="showdiv('captcha')" /><input type="hidden" name="capture_value" value="<?=$checkCode?>">    <span id="capt"></span></td>
          </tr>
          <tr>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="54%" align="left"><input name="btncomment" type="submit" value="Report to Webmaster" /></td>
    <td width="41%" align="left"><input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='./<?=remspace($_REQUEST['add_id'])?>'" /></td>
    <td width="5%">&nbsp;</td>
  </tr>
</table></td>
          </tr>
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
