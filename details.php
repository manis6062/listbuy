<?php
	require_once('config/config.php');
	
	
	$add = $_GET['add_id'];
	
	$result = mysql_query("SELECT * FROM tbl_add WHERE add_id = " . $add);
	
	
	
	
	$main_record = mysql_fetch_array($result);
	
	$record = $main_record;
	
	if(isset($_REQUEST['btnUpload'])){
		$set="user_id='".$_SESSION['user_id']."',
			  add_id='".$record['add_id']."',
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
	
	
	if(isset($_REQUEST['btncomment']))
	{
		$set="sender_id='".$_SESSION['user_id']."',
		receiver_id='".$record['user_id']."',
		add_id='".$record['add_id']."',
		msgtxt='".escapeQuotes(stripslashes($_REQUEST['msg']))."'";
		Insert_Qry(QUESTION,$set);
			
	################## MAIL TO SUBSCRIBED USERS ##################
	 $sql=mysql_query("SELECT * FROM ".USERNEWSLETTER." WHERE add_id= '".$record['add_id']."'");
	 if(mysql_num_rows($sql)>0){
	 	 while($objuser=mysql_fetch_array($sql)){
	 
		$mail_To = $objuser['email'];
		$mail_From = ADMIN_EMAIL;
		$mail_subject = "".$_SESSION['username']." has posted a new question for ".ADDTITLE($record['add_id'])." at ".WEB_ADDRESS;
		$name = $_SESSION['username'];
		$mail_Body='<html><head><title></title><style type="text/css">
					.font{FONT-FAMILY:tahoma, helvetica, sans-serif;
					FONT-SIZE:10pt;FONT-WEIGHT:normal;COLOR:black;}
					</style></head><body>
					<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
					<tr><td width="100%">&nbsp;</td></tr>
					<tr><td>Dear Subscriber,</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>User '.$name.' has been posted a new question for '.ADDTITLE($record['add_id']).'</td></tr>
					<tr><td align="left" valign="top">&nbsp;</td></tr>
					<tr><td width="100%" align="left" valign="top"><strong>Question</strong></td></tr>
					<tr><td width="100%" align="left" valign="top">'.$_REQUEST['msg'].'</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td width="100%">Click here to see the listing details: 
					<a href="http://'.WEB_ADDRESS.'/'.remspace($record['add_id']).'">'.ADDTITLE($record['add_id']).'</a></td></tr>
					<tr><td width="100%">&nbsp;</td></tr>
					<tr><td width="100%">Best Regards,</td></tr>
					<tr><td width="100%">&nbsp;</td></tr>
					<tr><td width="100%">'.WEB_ADDRESS.'</td></tr>
					</table></body></html>';
		Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $mail_Body);
	  	}
	 }
	
	##############################################################		
	
		$mail_To2= USEREMAIL($record['user_id']);
		$mail_From2 = ADMIN_EMAIL;
		$mail_subject2 = "".$_SESSION['username']." has posted a new question for ".ADDTITLE($record['add_id'])." at ".WEB_ADDRESS;
		$name = $_SESSION['username'];
		$mail_Body2='<html>
		<head><title></title><style type="text/css">.font{
		FONT-FAMILY:tahoma, helvetica, sans-serif;
		FONT-SIZE:10pt;FONT-WEIGHT:normal;COLOR:black;}</style></head>
		<body>
		<table border="0" cellpadding="0" cellspacing="0" width="80%" class="font">
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">User '.$name.' has been posted a new question for '.ADDTITLE($record['add_id']).'</td></tr>
		<tr><td width="100%" align="left" valign="top"><strong>Question</strong></td></tr>
		<tr><td width="100%" align="left" valign="top">'.$_REQUEST['msg'].'</td></tr>
		<tr><td width="100%">Click here to see the listing details: 
		<a href="http://'.WEB_ADDRESS.'/'.remspace($record['add_id']).'">'.ADDTITLE($record['add_id']).'</a></td></tr>
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">Best Regards,</td></tr>
		<tr><td width="100%">&nbsp;</td></tr>
		<tr><td width="100%">'.WEB_ADDRESS.'</td></tr>
		</table>
		</body>
		</html>';
		Send_HTML_Mail($mail_To2, $mail_From2, '', $mail_subject2, $mail_Body2);
	#$msg=successfulMessage("Comment Posted successfully");
	}
	
	if($_REQUEST['mode']=='del') 
	 {	 	
		  Delete_Qry(QUESTION,"WHERE id='".$_REQUEST['id']."'"); /// delete msg 
	 }
	 #######################SUBSCRIBE#######################
	 if(isset($_REQUEST['btnSubscribe']))
	 {
	  $letterchk=Select_Qry("*",USERNEWSLETTER,"add_id='".$record['add_id']."' AND email='".USEREMAIL($_SESSION['user_id'])."'","","","","");
		if($letterchk=="")
		 {
		 $setN="add_id='".$record['add_id']."',
		 email='".USEREMAIL($_SESSION['user_id'])."'";
		Insert_Qry(USERNEWSLETTER,$setN);	
		 }
		 else
		 {
		 Delete_Qry(USERNEWSLETTER,"WHERE id='".$letterchk['id']."'");
		 }
	 
	 }
	 
	 
	
	 ########################## SHORTLIST #################
	 if(isset($_REQUEST['btnShortlist']))
	 {
	 $Shortchk=Select_Qry("*",SHORTLIST,"add_id='".$record['add_id']."' AND user_id='".$_SESSION['user_id']."'","","","","");
	 if($Shortchk=="")
		 {
			$setSho="add_id='".$record['add_id']."',
			 user_id='".$_SESSION['user_id']."'";
			Insert_Qry(SHORTLIST,$setSho);	
			$msg="You have successfully added this listing to your shortlist";
		 }
		 else
		 {
			 Delete_Qry(SHORTLIST,"WHERE id='".$Shortchk['id']."'");
			 $msg=$_REQUEST['tit']. "has been removed from your shortlist";
		 }
	  }
	  $Shortchk2=Select_Qry("*",SHORTLIST,"add_id='".$record['add_id']."' AND user_id='".$_SESSION['user_id']."'","","","","");
	###########################END########################
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
<script type="text/javascript">
	function chk()
	{
		if(document.frm.msg.value=="")
		{
		 	alert("Please Enter Your Question.");
		 	document.frm.msg.focus();
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
    
 
 
 
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <? if($_SESSION['user_id']==$record['user_id']){?>
 <tr><td>
 <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="background-color:#FBFEE7">
  <tr>
    <td><a href="listing-upgrades.php?add_id=<?=$record['add_id']?>" class="user">Upgrade This Listing</a></td>
  </tr>
  <tr>
    <td><a href="editlisting.php?add_id=<?=$record['add_id']?>" class="user">Edit Listing Details</a></td>
  </tr>
  <? if($record['status']==0){?>
  <tr>
    <td><a href="relist.php?add_id=<?=$record['add_id']?>" class="user">Relist This Listing</a></td>
  </tr>
  <? }?>
</table></td></tr>
<tr><td style="height:5px;"></td></tr>
<? }?>
<tr><td>
 <table width="100%" border="0" cellspacing="0" cellpadding="3" >
  <tr>
    <td><h2> Owner Profile </h2></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="avatar/<?=AVATAR($record['user_id'])!=""?'thumb_'.AVATAR($record['user_id']):"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"></td>
  </tr>
  <tr>
    <td align="center"><p><a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'user-profile.php?add_id='.$record['add_id']?>&user_id=<?=$record['user_id']?>" class="user">
      <?=USERNAME($record['user_id'])?> 
      </a></p>
      <p><a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'user-profile.php?add_id='.$record['add_id']?>&user_id=<?=$record['user_id']?>" class="user">Feedback Score (
        <?=feedback($record['user_id'])?>%)</a>
        <? if($_SESSION['user_id']!=$record['user_id']){?>
        <a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'compose-message.php?add_id='.$record['add_id']?>" class="user">Send a Message</a>
        <? }?>
      </p></td>
  </tr>
  <?php /*?><? if($_SESSION['user_id']!=$record['user_id']){?>
   <tr>
    <td><a href="post-feedback.php?add_id=<?=$record['add_id']?>" class="user">Post Feedback</a></td>
  </tr>
  <? }?><?php */?>
  <? if($_SESSION['user_id']!=$record['user_id']){?>
   <tr>
    <td><a href="report.php?add_id=<?=$record['add_id']?>" class="user">Report a Violation</a></td>
  </tr>
  <? }?>
</table>
</td></tr></table>



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
    <td><!--div class="menu_top">
<? include_once("top-menu.php")?>
</div-->
<form name="frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>" enctype="multipart/form-data">
  <div style="vertical-align:top;">
    <table width="710" border="0" align="center" cellpadding="0" cellspacing="0">
<? if(isset($_SESSION['user_id'])){?>
<tr><td colspan="3" align="left" width="100%" valign="top"  class="border">
<table width="710" border="0" cellspacing="0" cellpadding="4"  >
  <tr>
    <td width="45%" valign="top"><a href="index.php">Auction</a> >><?=$record['title']?></td>
    <td align="left" valign="top" style="border-left:1px solid #EBEBEB;background-color:#F8F8F8;">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="13%" align="left" valign="top"><img src="avatar/<?=AVATAR($_SESSION['user_id'])!=""?'thumb_'.AVATAR($_SESSION['user_id']):"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"></td>
    <td width="87%" align="left" valign="middle"><?=USERNAME($_SESSION['user_id'])?>(<a href="my-message.php?mode=inbox" class="user_menu">Messages</a>)<br />
      You have <?=CREDIT($_SESSION['user_id'])?>       credits.</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</td></tr>
<tr><td colspan="3" align="right" width="100%" valign="top" style="height:5px;"></td></tr>
<tr><td colspan="3" align="right" width="100%" valign="top" class="border" >
<table width="710" border="0" cellspacing="0" cellpadding="4" >
  <tr>
    <td style="border-right:1px solid #EBEBEB;"><a href="short-list.php" class="user_menu">My Shortlist</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="subscription-list.php?add_id=<?=$record['add_id']?>" class="user_menu">My Subscriptions</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="mylistings.php" class="user_menu">My Activity</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="my-account.php" class="user_menu">My Account</a></td>
    <td style="border-right:1px solid #EBEBEB;"><a href="my-message.php?mode=inbox" class="user_menu">My Messages</a></td>
    <td><a href="logout.php" class="user_menu">Logout</a></td>
  </tr>
</table>
</td></tr>
<tr><td colspan="3" align="right" width="100%" valign="top" style="height:5px;"></td></tr>
<? }?>
  <tr>
    <td width="78%" align="left" valign="top"class="border" >
	<table width="100%" border="0" cellspacing="0" cellpadding="8" style="background-color:#eef8fb;">
  <tr>
    <td colspan="2" align="left" valign="top" style="border-bottom:1px solid #EBEBEB;"><span class="title"><?=$record['title']?></span><br /><span class="txtLabel"><?=$record['subtitle']?></span></td>
  </tr>
  <? if((CATEGORY_ADD($record['cat_id'])!='1') && ($record['site_img']!='')){?>
   <tr>
    <td align="left"><img src="websiteImage/thumb<?=$record['site_img']?>" border="0" class="img_border" /></td>
    <td align="left"><table width="150" border="0" cellspacing="0" cellpadding="0" align="right">
    <?
    $bidcou=Select_Qry("COUNT(id) as addID",PROPOSAL,"add_id='".$record['add_id']."'","","","","");
	$pending=Select_Qry("COUNT(id) as PEND",PROPOSAL,"add_id='".$record['add_id']."' AND accept='0'","","","","");
	$reject=Select_Qry("COUNT(id) as REJ",PROPOSAL,"add_id='".$record['add_id']."' AND accept='1'","","","","");
	?>
	 <? 
	  if($record['winner_id']=="0") {
	 ?>
      
	  <?
	  }else{
	  ?>
      <tr>
        <td align="center" class="redbold">Sold</td>
        </tr>
		<? }?>
    </table></td>
   </tr>
  <? }?>
  <tr>
    <td colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="26%" align="left" valign="top"><span class="greenfont"><strong>Bid Price:</strong></span> $<strong>
          <?=$record['price']?>
        </strong></td>
        <td width="74%" align="left" valign="top"><?
  	 if($record['status']!=2 && ($_SESSION['user_id']!=$record['user_id']))
	 {
	 ?>
          <input type="button" name="btnPlace2" value="Place a Bid" onclick="window.location.href='<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'post-offer.php?add_id='.$record['add_id']?>'" />
          <?
	}
	?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="26%" align="left" valign="top"><span class="greenfont"><strong>BIN Price:</strong></span> <span class="error">$<strong>
          <?=$record['buyer_price']?>
        </strong></span></td>
        <td width="74%" align="left" valign="top"><?
  	 if($record['status']!=2 && ($_SESSION['user_id']!=$record['user_id']))
	 {
	 ?>
          <input type="button" name="btnBuy2" value="Buy It Now" onclick="window.location.href='<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:'buy.php?add_id='.$record['add_id']?>'" />
          <?
	}
	?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  
    <td colspan="2" align="left"><span class="greenfont"><strong>Company Name:</strong></span> <?=$record['company_name']?></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Website:</strong></span> <a href= "<?php echo $record['website'] ;?>" ><?=$record['website']?></a></td>
  </tr>
  <?
  	if($record['aboutus']==1){
  ?>
   <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>About Us:</strong></span> <a href="<?=$record['aboutus']?>"><?=$record['aboutus']?></a></td>
  </tr>
  <? }
  	if($record['product_page']==1){
  ?>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Products Page:</strong></span> <a href="<?=$record['product_page']?>"><?=$record['product_page']?></a></td>
  </tr>
  <? }
  	if($record['faq']==1){
  ?>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Faq:</strong></span> <a href="<?=$record['faq']?>"><?=$record['faq']?></a></td>
  </tr>
  <? }
  	if($record['contact_us']==1){
  ?>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Contact Us:</strong></span> <a href="<?=$record['contact_us']?>"><?=$record['contact_us']?></a></td>
  </tr>
  <? }if($record['contact_email']==1){?>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Contact Email:</strong></span> <?=$record['contact_email']?></td>
  </tr>
  <? }?>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Listed:</strong></span> <?=dateprint($record['posted_on'])?></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Visitors:</strong></span> <?=$record['visitor']?></td>
  </tr>
 <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Page Views:</strong></span> <? echo $record['traffic_pages']." Daily"; ?></td> 
  </tr> 
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Income:</strong></span> <? echo $record['income_month']." US$ Per Month"; ?></td> 
  </tr>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Cost to run site:</strong></span> <? echo $record['run_cost']." US$ Per Month" ?></td> 
  </tr>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Disk Space used:</strong></span> <? echo $record['disk_space']." MB";?></td>
  </tr> 
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Bandwidth used:</strong></span> <? echo $record['bandwidth']." MB per month"; ?></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>Members:</strong></span> <?=$record['site_members']?></td>
  </tr>
  <? /*
  <tr>
    <td colspan="2" align="left"><span class="greenfont"><strong>:</strong></span> <?=$record['']?></td>
  </tr>
  */ ?>
  <?
  if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
  <? }?>
  <?
  if(CATEGORY_ADD($record['cat_id'])!='1'){
  ?>
  <? }?>
  <tr>
    <td colspan="2" class="des">Listing Description</td>
  </tr>
  <tr>
    <td colspan="2" align="justify" valign="top">
	<?=$record['description']?>
	</td>
  </tr>
  <?
  	if(isset($_SESSION['user_id'])){
  ?>
  <tr>
    <td colspan="2"><input type="submit" name="btnSubscribe" value="<?=$letterchk==""?"Subscribe":"Unsubscribe"?> For Email Updates" />&nbsp;&nbsp;&nbsp;<input type="submit" name="btnShortlist" value="<?=$Shortchk2==""?"Add To":"Remove From"?> My Shortlist" /></td>
  </tr>
  <? }?>
</table>

	</td>
    <td width="1%">&nbsp;</td>
    <td width="21%" align="left" valign="top"class="border">
	<table width="100%" border="0" cellspacing="0" cellpadding="3" >
  <tr>
    <td class="rowhead">Attachments</td>
  </tr>
  <?
  	$attachRecord=Listing_Qry("*",ATTACHMENTS,"WHERE add_id='".$record['add_id']."' AND status='1' order by id DESC","");
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
    <td class="text-small">No Attachments</td>
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
<div style="vertical-align:top; padding-top:5px;">
<table width="710" border="0" cellspacing="0" cellpadding="0" class="border">
  <tr>
    <td colspan="2" class="rowhead" style="height:30px; padding-left:5px;">Public Questions</td>
    </tr>
	<tr>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="left" style="height:15px;">&nbsp;</td>
  </tr>
	<?	
	$QuesList =Listing_Qry("*",QUESTION,"WHERE add_id='".$record['add_id']."' ORDER BY id DESC",'');
	if($QuesList){
	foreach($QuesList as $Ques)
	{
?>
  <tr>
    <td width="8%" align="center" valign="top" style="padding-left:2px;"><img src="avatar/<?=AVATAR($Ques['sender_id'])!=""?'thumb_'.AVATAR($Ques['sender_id']):"noimage.jpeg"?>" border="0" align="absmiddle" class="img_border"><br /><? if($Ques['sender_id']!=$_SESSION['user_id']){?>
      <a href="user-profile.php?add_id=<?=$Ques['add_id']?>&user_id=<?=$Ques['sender_id']?>">
      <?=USERNAME($Ques['sender_id'])?>
      </a>
      <? }else{ echo USERNAME($Ques['sender_id']); }?><?php /*?><a href="user.php?uid=<?=$Ques['sender_id']?>"><?=USERNAME($Ques['sender_id'])? ></a><?php */?></td>
    <td width="92%" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="76%" align="left" valign="top" class="small_text"><?=$Ques['msgtxt']?></td>
    <td width="24%" align="right" valign="top"><span class="text-bold">Posted On:</span> <span class="small_text"><?=dateprint($Ques['posted_on'])?></span> <? if($_SESSION['user_id'] == $Ques['sender_id']){?>| <a href="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>&mode=del&id=<?=$Ques['id']?>" onClick="return confirm('Are you sure want to delete this message?')">Delete</a><? }?></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td colspan="2" align="left" style="border-top:1px dashed #CCCCCC;">&nbsp;</td>
    </tr>
  <? } }else{?>
<tr>
    <td colspan="2" align="left" style="padding-left:5px;" class="txtLabel">No questions posted.</td>
    </tr>
  <? }?>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="left" style="height:15px;">&nbsp;</td>
  </tr>
</table>
</div>
<?
	#if($_SESSION['user_id']!=$record['user_id']){
?>
<div style="vertical-align:top; padding-top:5px; ">
<table width="710" border="0" cellspacing="0" cellpadding="0" class="border">
  <tr>
    <td colspan="2" class="rowhead" style="height:30px; padding-left:5px;">Questions/Comments</td>
    </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="left" style="height:15px;">&nbsp;</td>
  </tr>
  <? 
  if($_SESSION['user_id']==''){?>
  <tr>
    <td colspan="2" align="left" valign="middle" class="txtLabel">To post a comment on this listing, <a href="<?=$_SESSION['user_id']==''?'login.php?add_id='.$record['add_id']:''?>" class="user">login</a></td>
    </tr>
	<? }else{?>
	<tr>
    <td colspan="2" align="left" valign="middle" style="height:20px;padding-left:5px;" class="txtfont">Logged in as <?=UserName($_SESSION['user_id'])?> (<a href="logout.php">logout</a>) </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-left:5px;"><textarea name="msg" cols="84" rows="10" id="msg"></textarea></td>
    </tr>
	<tr>
    <td align="left" style="height:10px;" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-left:5px;"><input type="submit" class="button" name="btncomment" value="Post Question" onClick="return chk()"></td>
  </tr>
  <? }?>
</table>
</div>
<? # }?>
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
