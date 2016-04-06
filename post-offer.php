<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	if($_REQUEST['add_id']==''){
		header('location:index.php');
	}
	else{
		$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
	}
	if(isset($_REQUEST['btnUpload'])){
		$set="user_id='".$_SESSION['user_id']."',
			  add_id='".$_REQUEST['add_id']."',
			  file_describe='".escapeQuotes(stripslashes(trim($_REQUEST['file_describe'])))."'";
		if($_FILES['attach_file']['name']!="")
		  {
			$wdir="attachment/";
			$file_type = $_FILES['attach_file']['type'];
			$file_name = $_FILES['attach_file']['name'];
			$file_size = $_FILES['attach_file']['size'];
			$file_tmp = $_FILES['attach_file']['tmp_name'];
			$ext=getext($_FILES['attach_file']['name']);
			$imagname=rand()."_".date("m_d_Y").$ext;
			$uploadfile =$wdir.$imagname;
			image_resize($wdir."large_",600,$file_type,$file_name,$file_size,$file_tmp,$imagname);
			image_resize($wdir."thumb_",150,$file_type,$file_name,$file_size,$file_tmp,$imagname);
			//move_uploaded_file($_FILES['attach_file']['tmp_name'], $uploadfile);
			$set.=",attach_file ='".$imagname."'";
			}
			Insert_Qry(ATTACHMENTS,$set);
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

	
	if(isset($_REQUEST['btnPlace']))
	{
		if($_REQUEST['capture_value']==$_REQUEST['captcha_code'])
			{
		
			if($_REQUEST['amount'] < $record['price'])
			{
				$msg=errorMessage("Your Offer is bellow than Advertise Price.");
			}
			else
			{
				$set="add_id='".$_REQUEST['add_id']."',
				  user_id='".$_SESSION['user_id']."',
				  proposed_amt='".$_REQUEST['amount']."'";
				Insert_Qry(PROPOSAL,$set);
	
	$mail_To = USEREMAIL($record['user_id']);
	$mail_From = ADMIN_EMAIL;
	$mail_subject = "You have a new bid at ".WEB_ADDRESS."";
	$name = $_SESSION['username'];
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
	     <td>You have a new bid amount for <strong>'.$record['title'].'</strong></td>
      </tr>
	   <tr>
	     <td>&nbsp;</td>
      </tr>
	   <tr>
	     <td width="100%">Hello '.USERNAME($record['user_id']).',</td>
	   </tr>
	   <tr>
	     <td>&nbsp;</td>
      </tr>
	   <tr>
	     <td style="border-bottom:thin"><strong>Your listing has a new bid.</strong> </td>
      </tr>
	   <tr>
	     <td>&nbsp;</td>
      </tr>
	   <tr>
	     <td><table border="0" cellpadding="0" cellspacing="0" width="90%" class="font">
		<tbody>
		
		<tr>
		  <td width="29%"><strong>Bid Details:</strong></td>
		  <td width="5%">&nbsp;</td>
		  <td width="66%">&nbsp;</td>
		  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		<td align="right">Amount</td>
		<td>:</td>
		<td>$'.$_REQUEST['amount'].'USD</td>
		</tr>
		<tr>
		<td align="right">Date</td>
		<td>:</td>
		<td>'.dateprint($record['posted_on']).'</td>
		</tr>
		<tr>
		<td align="right">Ad Description</td>
		<td>:</td>
		<td>'.$record['description'].'</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
</table></td>
      </tr>
       <tr>
         <td style="border-bottom:thin">&nbsp;</td>
       </tr>
	    <tr>
         <td>&nbsp;</td>
       </tr>
      <tr>
		<td width="100%">Best Regards,</td>
	  </tr>
	  <tr>
		<td width="100%">&nbsp;</td>
	  </tr>
	  <tr>
	    <td>'.WEB_ADDRESS.'</td>
      </tr>
	</table>
	</body>
	</html>';
	Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
		
	/*$mail_To1 = ADMIN_EMAIL;
	$mail_From1 = $_SESSION['email'];
	$mail_subject1 = "A new bid for ".$record['title']." has been placed at ".WEB_ADDRESS." ";
	Send_HTML_Mail($mail_To1, $mail_From1, '', $mail_subject1, $mail_Body);*/
	
	$mail_To2 = USEREMAIL($_SESSION['user_id']);
	$mail_From2 = ADMIN_EMAIL;
	$mail_subject2 = "You have placed a bid at ".WEB_ADDRESS."";
	$mail_Body2='<html>
		<head><title></title>
		<style type="text/css">.font{FONT-FAMILY:tahoma, helvetica, sans-serif;
		FONT-SIZE:10pt;FONT-WEIGHT:normal;COLOR:black;}</style></head>
		<body>
		<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
		<tr><td width="100%">Hi! '.USERNAME($_SESSION['user_id']).'</td></tr>
		<tr>
		<td width="100%" style="border-bottom:thin">You have placed a bid amount for <strong>'.$record['title'].'</strong></td>
		</tr>
		<tr><td width="100%">&nbsp;</td></tr>
		<tr>
		<td><table border="0" cellpadding="0" cellspacing="0" width="90%" class="font">
		<tr>
		<td width="29%"><strong>Bid Details:</strong></td>
		<td width="5%">&nbsp;</td>
		<td width="66%">&nbsp;</td>
		</tr>
		<tr><td align="right">Bid Amount</td><td>:</td><td>$'.$_REQUEST['amount'].'USD</td></tr>
		<tr><td align="right">Date</td><td>:</td><td>'.dateprint($record['posted_on']).'</td>
		</tr>
		<tr><td align="right">Ad Description</td><td>:</td><td>'.$record['description'].'</td></tr>
		</table></td>
		</tr>
		<tr><td style="border-bottom:thin">&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td width="100%">Thank You,</td></tr>
		<tr><td width="100%">'.WEB_ADDRESS.'</td></tr>
		<tr><td width="100%"></td></tr>
		</table>
	</body>
	</html>';
	Send_HTML_Mail($mail_To2, $mail_From2, '', $mail_subject2, $mail_Body2);
	
	
		$sql=mysql_query("SELECT * FROM ".USERNEWSLETTER." WHERE add_id= '".$_REQUEST['add_id']."'");
		if(mysql_num_rows($sql)>0){
		for($i=1;$i<=mysql_num_rows($sql);$i++){
		$objuser=mysql_fetch_array($sql);
	 
		$mail_To = $objuser['email'];
		$mail_From = ADMIN_EMAIL;
		$mail_subject = "A new bid posted for ".ADDTITLE($_REQUEST['add_id'])."";
		$name = $_SESSION['username'];
		$mail_Body='<html>
					<head>
					<title></title>
					<style type="text/css">.font{FONT-FAMILY:tahoma, helvetica, sans-serif;
					FONT-SIZE:10pt;FONT-WEIGHT:normal;COLOR:black;}</style>
					</head>
					<body>
					<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
					<tr><td width="100%">&nbsp;</td></tr>
					<tr><td>Dear Subscriber,</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td width="100%">A new bid has been placed for '.ADDTITLE($_REQUEST['add_id']).'</td></tr>
					<tr><td align="left" valign="top">&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
					<td width="100%">Click here to see the listing details: <a href="http://'.WEB_ADDRESS.'/'.remspace($_REQUEST['add_id']).'">'.ADDTITLE($_REQUEST['add_id']).'</a></td>
					</tr>
					<tr><td width="100%">&nbsp;</td></tr>
					<tr><td width="100%">Best Regards,<br>'.WEB_ADDRESS.'</td></tr>
					</table>
					</body>
					</html>';
					Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
	 
	  }
	 }
	
	
	$msg=successfulMessage("Your bid has been submitted and now pending seller approval.");
	$msg1='success';
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
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="lightbox/js/prototype.js"></script>
<script type="text/javascript" src="lightbox/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="lightbox/js/lightbox.js"></script>

<script language="javascript" src="ajax_imgcode.js"></script>
<script type="text/javascript" src="js/side_scripts.js"></script>
<script type="text/javascript">
	function doChk()
	{
		if(document.frm.amount.value=="")
		{
		 	alert("Your offer can not be empty.");
		 	document.frm.amount.focus();
		  	return false;
		}
		 else if(document.frm.captcha_code.value=="")
			{
			alert("Please enter The Code shown above.");
			document.frm.captcha_code.focus();
			return false;
			}
		 else if(document.frm.check.checked==false)
		 {
		 	alert("You must accept the terms and conditions");
			return false;
		 }
		 
		  return true;
	}
	function doAttach()
	{
		if(document.frm.attach_file.value=="")
		{
		 	alert("Please upload Attachment File.");
		 	document.frm.attach_file.focus();
		  	return false;
		 }
		  return true;
	}
	
	function showWindow(id)
	{
		var url="postoffer-terms-condition.php?p="+id;
		window.open(url,"artclasses", " resizable = no, status = 1, scrollbar=yes, width =400, height=300, addressbar=no, left=250, top=250 ");
		return true;
	}
</script>
</head>
<body>
<? include_once("toppage1.php");?>
<div id="container" >
<!--LEFT PANEL-->
<div id="sidebar">


<div style="vertical-align:top">


 
    <table width="216" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td><img src="images/lbd_22.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td class="left_menu_bg">
    
    
    
    
 <table width="100%" border="0" cellspacing="0" cellpadding="3" >
  <tr>
    <td class="rowhead">Owner Profile</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="avatar/<?=AVATAR($record['user_id'])!=""?'thumb_'.AVATAR($record['user_id']):"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"></td>
  </tr>
  <tr>
    <td align="center"><a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'user-profile.php?add_id='.$record['add_id']?>&user_id=<?=$record['user_id']?>" class="user"><?=USERNAME($record['user_id'])?></a><a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'compose-message.php?add_id='.$record['add_id']?>" class="user">Message me</a></td>
  </tr>
</table>






</td>
  </tr>
  <tr>
    <td><img src="images/lbd_30.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
 </div>   
</div>
<!--LEFT PANEL-->
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
<p style="height:32px;">&nbsp;</p>
<form name="frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>">
<div style="vertical-align:top;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78%" align="left" valign="top" class="border">
	<table width="100%" border="0" cellspacing="0" cellpadding="8" >
  <tr>
    <td align="left" valign="top" style="border-bottom:1px solid #EBEBEB;"><span class="title"><?=$record['title']?></span><br /><span class="txtLabel"><?=$record['subtitle']?></span></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Company Name:</span> <?=$record['company_name']?></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Website:</span> <a href="<?=$record['website']?>"><?=$record['website']?></a></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Listed:</span> <?=dateprint($record['posted_on'])?></td>
  </tr>
  <tr>
    <td align="left"><span class="txtLabel">Price:</span> <span class="error">$<strong><?=$record['price']?></strong></span></td>
  </tr>
   
  <tr>
    <td class="des" style="border-bottom:1px solid #EBEBEB;" align="left">Place Your Bid </td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<?
		if($msg!=''){
	?>
	<tr>
    <td width="25%" align="left" class="txtLabel"></td>
    <td width="75%" valign="top" align="left"><?=$msg?>
</td>
  </tr>
  <tr>
    <td width="25%" align="left" class="txtLabel"></td>
    <td width="75%" valign="top" align="right"><a href="my-account.php" class="green">Click to view Account History</a>
</td>
  </tr>
  <? }?>
  <? if($msg1!='success'){?>
  <tr>
    <td width="25%" align="left" class="txtLabel"><strong>Your Bidding Amount :</strong> </td>
    <td width="75%">$<input type="text" name="amount" value="<?=$_REQUEST['amount']?>" class="smalltextField" onkeypress="return keyRestrict(event,'1234567890.')" /></td>
  </tr>
  <tr>
    <td align="left" class="txtLabel"><strong>Security Code:</strong></td>
    <td align="left" class="txtLabel" id="imgco"><img src="image_code.php?txt=<?=$checkCode?>" align="absmiddle" /><a href="javascript: void(0)" onClick="imgcode()"><img src="images/refresh.png" alt="Click To refresh the image" width="16" height="16" border="0" align="absmiddle" /></a>&nbsp;
    <input type="text" name="captcha_code" size="10" class="inputTextBox" onFocus="showdiv('captcha')" /><input type="hidden" name="capture_value" value="<?=$checkCode?>">    <span id="capt"></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="txtLabel"><input type="checkbox" name="check" value="" />      I have read and agreed to the  <a href="javascript: void(0)" onClick="showWindow()">Terms and Condition</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='./<?=remspace($_REQUEST['add_id'])?>'" /></td>
    <td align="right"><input type="submit" name="btnPlace" value="Place a Bid" onclick="return doChk()" /></td>
  </tr>
  <? }?>
</table>

	</td>
  </tr>
</table>

	</td>
    <td width="1%">&nbsp;</td>
    <td width="21%" align="left" valign="top" class="border">
	<table width="100%" border="0" cellspacing="0" cellpadding="3" >
  <tr>
    <td class="rowhead">Attachments</td>
  </tr>
  <?
  	$attachRecord=Listing_Qry("*",ATTACHMENTS,"WHERE add_id='".$_REQUEST['add_id']."' AND status='1' order by id DESC","");
	if($attachRecord!=''){
		foreach($attachRecord as $attch){
  ?>
  <tr style="padding-bottom:4px;">
    <td align="left"><a href="attachment/large_<?=$attch["attach_file"]?>" rel="lightbox[roadtrip]"><img src="attachment/thumb_<?=$attch['attach_file']?>" border="0" class="img_border" /></a></td>
  </tr>
  <? }
  }else{
  ?>
  <tr>
    <td class="text-small">This Listing does not have any attachments</td>
  </tr>
  <? }?>
  <?
  	if($_SESSION['user_id']==$record['user_id']){
  ?>
  <tr>
    <td>Add an attachment </td>
  </tr>
  <tr>
    <td class="text-small">Choose a file:<br />
      <input type="file" name="attach_file" class="smalltextField" size="10" /></td>
  </tr>
  <tr>
    <td class="text-small">Describe your file <br /><input type="text" name="file_describe" value="" class="smalltextField" /></td>
  </tr>
  <tr>
    <td><input type="submit" name="btnUpload" value="Upload" onclick="return doAttach()" /></td>
  </tr>
  <? }?>
</table>
	</td>
  </tr>
</table>
</div>
</form>
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
