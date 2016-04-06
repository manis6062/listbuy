<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	################ INSERT UPDATE ################
	if(isset($_REQUEST['btnSubmit']))
	{
	$record=Select_Qry("*",ATTACHMENTS,"id='".$_REQUEST['aid']."'","","","","");
		
	$set="file_describe='".escapeQuotes(stripslashes(trim($_REQUEST['file_describe'])))."',
		add_id='".$_REQUEST['add_id']."',
		user_id='".$_SESSION['user_id']."'";
			
			if($_FILES['attach_file']['name']!="")
			  {
				$wdir="attachment/";
				@unlink("attachment/large_".$record['attach_file']);
			    @unlink("attachment/thumb_".$record['attach_file']);
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
							 
					if(isset($_REQUEST['mode1']) && $_REQUEST['mode1']=="edit")
					{
						$where_clause="WHERE id='".$_REQUEST['aid']."'";
						Update_Qry(ATTACHMENTS,$set,$where_clause);
						$msg=successfulMessage("Successfully updated!");
					}
				
				else{
					Insert_Qry(ATTACHMENTS,$set);
					$msg=successfulMessage("Successfully updated!");
					}
	     
		}
#################### DELETE ###################
if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$obpp=Select_Qry("*",ATTACHMENTS,"id='".$_REQUEST['id']."'","","","","");
		@unlink("attachment/large_".$obpp['attach_file']);
		@unlink("attachment/thumb_".$obpp['attach_file']);
		$where_clause = "WHERE id='".$_REQUEST['id']."'";
		Delete_Qry(ATTACHMENTS,$where_clause);
	}

#############################################
$where_clause="id='".$_REQUEST['aid']."'";
$arr=Select_Qry("*",ATTACHMENTS,$where_clause,"","","","");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="<?=META_KEYWORDS?>"/>
<meta name="description" content="<?=META_CONTENT?>"/>
<link href="css/fresh-auction.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function check()
{
	<?
	if($_REQUEST['aid']=="")
	{
	?>
	if(document.frm.attach_file.value=="")
	{
	alert("Please attach image");
	return false;
	}
	<?
	}
	?>
	else
	{
	return true;
	}
}
//////////////////
function jsHitListAction(p1)
	{			
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?add_id=<?=$_REQUEST['add_id']?>&PageNo="+eval(p1) ;
		document.frm.submit()
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
<p><span class="header_text_h">Attachment</span>
  </p>
<p align="center">
<form name="frm" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
<?
if($_REQUEST['mode1']!='')
{
?>
  <tr>
    <td colspan="2" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="5" class="border">
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td colspan="2" align="left" valign="top"><?=$msg?></td>
    </tr>
  <tr>
    <td width="16%" align="left" valign="top">&nbsp;</td>
    <td width="18%" align="left" valign="top">Attached Image</td>
	 <td width="66%" align="left" valign="top"><input type="file" name="attach_file" />
	 <?
	 if($arr['attach_file']!="")
	 {
	 ?>
	 <img src="attachment/thumb_<?=$arr['attach_file']?>" border="0" align="absmiddle" height="60" width="70" />
	 <?
	 }
	 ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Description</td>
    <td align="left" valign="top"><input type="text" name="file_describe" size="30" value="<?=$arr['file_describe']?>" /></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><input type="submit" name="btnSubmit" value="Submit" onclick="return check()" />&nbsp;<input type="button" name="cancel" value="Cancel" onclick="window.location.href='<?=$_SERVER['PHP_SELF']?>?add_id=<?=$_REQUEST['add_id']?>'" /></td>
  </tr>
</table>
</td>
    </tr>
	<?
	}
	?>
	
  <tr>
    <td colspan="2" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="5" class="border">
  <tr>
    <td width="27%" align="left" valign="top" class="rowhead">Attachment File</td>
    <td width="47%" align="left" valign="top" class="rowhead">Description</td>
    <td width="15%" align="left" valign="top" class="rowhead">Attached On </td>
    <td width="11%" align="left" valign="top" class="rowhead">Action</td>
  </tr>
  <?
  $sql="SELECT * FROM ".ATTACHMENTS." WHERE add_id='".$_REQUEST['add_id']."' ORDER BY id DESC";          
	  $PageSize =30;	
	  $StartRow =0;
	  include_once('paging-top.php');
	  if(mysql_num_rows($rs)>0)
		{
			$bgColor = "#ffffff";
                         for($i=0;$i<mysql_num_rows($rs);$i++)
                          { 
                            $arrsc=mysql_fetch_array($rs);
  
  ?>
  <tr>
    <td align="left" valign="top"><img src="attachment/thumb_<?=$arrsc['attach_file']?>"  border="0" align="absmiddle" /></td>
    <td align="left" valign="top"><?=$arrsc['file_describe']?></td>
    <td align="left" valign="top"><?=dateprint($arrsc['posted_on'])?></td>
    <td align="left" valign="top"><a href="<?=$_SERVER['PHP_SELF']?>?mode1=edit&aid=<?=$arrsc['id']?>&add_id=<?=$_REQUEST['add_id']?>">Edit</a> | <a href="<?=$_SERVER['PHP_SELF']?>?mode=del&id=<?=$arrsc['id']?>&add_id=<?=$_REQUEST['add_id']?>" onclick="return confirm('Are you sure?');">Delete</a></td>
  </tr>
  <?
  }
  ?>
  <tr><td colspan="4" align="right" valign="top"><? include_once('pageno.php');?></td></tr>
  <?
  }else
  {
  ?>
   <tr><td colspan="4" align="center" valign="top"><?=errorMessage("No Attachment Found")?></td></tr>
   <?
   }
   ?>
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
