<?
	require_once('config/config.php');
	$where_clause="email ='".$_REQUEST['email']."'";
	$obj=Select_Qry("*",USER,$where_clause,"","","","");
	if($obj != '')
	{
		if($obj['activation'] != '')
		{
			$set_value="status='1', activation=''";
			$where_clause="WHERE user_id='".$obj['user_id']."'";
			Update_Qry(USER,$set_value,$where_clause);
			
			$mail_From = ADMIN_EMAIL;
			$name = $obj['username'];
			$mail_To = $obj['email'];
			$mail_subject="Account Activation At ".WEB_ADDRESS;
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
			<td width="100%">Dear '.$obj['first_name'].' '.$obj['last_name'].',</td>
			</tr>
			<tr>
			<td width="100%">Thank you for registering at '.WEB_ADDRESS.'.</td>
			</tr>
			<tr>
			<td width="100%">Your account has been successfully activated.</td>
			</tr>
			<tr>
			<td width="100%">Your login information is.</td>
			</tr>
			<tr>
			<td width="100%">Username : '.$obj['username'].'</td>
			</tr>
			<tr>
			<td width="100%">Password : '.$obj['password'].'</td>
			</tr>
			<tr>
			<td width="100%">You can access your account in '.WEB_ADDRESS.'. <a href="http://'.WEB_ADDRESS.'/login.php" target="_blank" style="text-decoration:none">Click here</a> to login to your account.</td>
			</tr>
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
			
/*Global_Mail($obj["email"],$obj["username"],'25',$obj["password"],"activation",$obj["username"]);*/
			
			$msg = successfulMessage('Your account has been successfully created. You may now <a href="http://'.WEB_ADDRESS.'/login.php">login</a> using your username and password.');
		}
		else
		{
			$msg = errorMessage('This account has already been activated. Please <a href="http://'.WEB_ADDRESS.'/login.php">login</a>.');
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
<p><span class="header_text_h"> </span>
  </p>
<p align="center">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><?=$msg?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

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
