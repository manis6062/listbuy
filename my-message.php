<?
	require_once('config/config.php');
	validation_check($_SESSION['user_id'], 'login.php');
	################# DELETE #####################
	if(isset($_REQUEST['mode2']) && $_REQUEST['mode2']=='del')
	{
		if($_REQUEST['mode']=='inbox')
		{
		$table=INBOX;
		}
		else
		{
		$table=OUTBOX;
		}
	Delete_Qry($table,"WHERE id='".$_REQUEST['id']."'");
	}
	
	
	if($_REQUEST['mode3'] == 'delall')
	{		
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			if($_REQUEST['mode']=='outbox')
			{
			$table=OUTBOX;
			}
			else
			{
			$table=INBOX;
			}
		Delete_Qry($table,"WHERE id ='".$_REQUEST['chk'][$i]."'");
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
<script type="text/javascript">
function jsHitListAction(p1)
	{			
			document.frm.action = "<?=$_SERVER['PHP_SELF']?>?mode=<?=$_REQUEST['mode']?>&PageNo=" + eval(p1) ;
			document.frm.submit()
	}


function AllSelect()
   {
	var flag=false;
	if(document.frm.chk_all.checked==true)
	{
		flag=true;
	}
	else
	{
		flag=false;
	}
	if(flag==true)
	{
		for(var i=0;i<document.frm.elements.length;i++)
		{ 
			if(document.frm.elements[i].type=="checkbox")
			{
				document.frm.elements[i].checked=true;
			}  
		}
	}
	if(flag==false)
	{
		for(var i=0;i<document.frm.elements.length;i++)
		{ 
			if(document.frm.elements[i].type=="checkbox")
			{
				document.frm.elements[i].checked=false;
			}  
		}
	}
   }
	function deselect_any()
	{
	  var tag=false;
	  for(var i=0;i<document.frm.elements.length;i++)
	   { 
		   if(document.frm.elements[i].type=="checkbox")


		     {
		    	if(document.frm.elements[i].checked==false)
			      {
		    		document.frm.chk_all.checked=false;
			      }
		     }  
	  }
	}  		
	function Confirm(status)
    {
       var flag=0;
	   for(var i=0;i<document.frm.elements.length;i++)
       	{ 
		   if(document.frm.elements[i].type=="checkbox" && document.frm.elements[i].checked==true)
		     {
			   flag=flag+1;
		     }  
	    }
	   if(flag==0)
	    {
	       alert("Select any Message");
	       return false;
	    }
	   else
	    {
	       var con = confirm("Are You Sure?")
	       if(con)
		    {
			document.frm.action='<?=$_SERVER['PHP_SELF']?>?mode=<?=$_REQUEST['mode']?>&mode3='+status;
		   		document.frm.submit();
				//return true;
		    }
			else 
			{
			  return false;
			}
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
<p><span class="header_text_h">My Messages</span>
  </p>
<p align="center">
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="3" cellpadding="4" align="center">
  <tr>
    <td align="left" valign="top"><a href="<?=$_SERVER['PHP_SELF']?>?mode=inbox" style="color:#003F7D;"><strong>Inbox</strong></a> | <a href="<?=$_SERVER['PHP_SELF']?>?mode=outbox" style="color:#8C8C8C;"><strong>Outbox</strong></a>
</td>
    </tr>
	<?
	if($_REQUEST['mode']=='outbox')
  {
  $table=OUTBOX;
  $msgid="sender_id";
  }
  else
  {
   $table=INBOX;
   $msgid="recipent_id";
  }
  $sql="SELECT * FROM ".$table." WHERE $msgid='".$_SESSION['user_id']."' ORDER BY id DESC";          
	  $PageSize =20;	
	  $StartRow =0;
	  include_once('paging-top.php');
	?>
  <tr>
    <td align="left" valign="top" class="white_text"  bgcolor="<?=$_REQUEST['mode']=="inbox"? "#003F7D":"#8C8C8C"?>">My <?=$_REQUEST['mode']=='inbox'?'Received':'Sent'?> Messages</td>
    </tr>
	<tr><td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5" class="border">
  <tr>
    <td width="5%" align="center" valign="top" bgcolor="#F0F0F0"><input type="checkbox" name="chk_all" onClick="AllSelect()" /></td>
    <td width="30%" align="left" valign="top" bgcolor="#F0F0F0">Messages</td>
    <td width="31%" align="left" valign="top" bgcolor="#F0F0F0">Title</td>
    <td width="34%" align="center" valign="top" bgcolor="#F0F0F0">
	<?
	if(mysql_num_rows($rs)>0)
	{
	?>
	<a href="#" onClick="return Confirm('delall')">Delete</a>
	<?
	}
	?></td>
  </tr>
  <tr><td colspan="4" align="center" valign="top" style="border-top:1px solid #C7C7C7;"></td></tr>
  <?
   if(mysql_num_rows($rs)>0)
		{
		$bgColor = "#ffffff";
         for($i=0;$i<mysql_num_rows($rs);$i++)
                  { 
               $arrmsg=mysql_fetch_array($rs);
					
  ?>
  <tr bgcolor="<?=$arrmsg['unread']=='0'? "#D7EBFF":$bgColor?>">
    <td align="center" valign="top"><input type="checkbox" name="chk[]"value="<?=$arrmsg["id"]?>" onClick="deselect_any()" /> </td>
    <td align="left" valign="top"><a href="message-details.php?mode=<?=$_REQUEST['mode']?>&mid=<?=$arrmsg['id']?>" <? if($arrmsg['unread']=='0'){?>class="title3" <? }else{?>class="title2"<? }?>><?php echo $arrmsg['mail_subject']?></a><br />
      <?=$_REQUEST['mode']=='inbox'?'From':'To'?>: <?=$_REQUEST['mode']=='inbox'?USERNAME($arrmsg['sender_id']):USERNAME($arrmsg['recipent_id'])?></td>
    <td align="left" valign="top"><a href="message-details.php?mode=<?=$_REQUEST['mode']?>&mid=<?=$arrmsg['id']?>" <? if($arrmsg['unread']=='0'){?>class="title3" <? }else{?>class="title2"<? }?>><?=ADDTITLE($arrmsg['add_id'])?></a></td>
    <td align="right" valign="top"><?php echo datenew($arrmsg['date'])?><br />
	<? if($_REQUEST['mode']=='inbox'){?><a href="compose-message.php?add_id=<?=$arrmsg['add_id']?>&m=reply&u=<?=$arrmsg['sender_id']?>&mid=<?=$arrmsg['id']?>">Reply</a> |<? }?>  <a href="<?=$_SERVER['PHP_SELF']?>?mode2=del&id=<?=$arrmsg['id']?>&mode=<?=$_REQUEST['mode']?>" onClick="return confirm('Are you sure?')">Delete</a></td>
  </tr>
  <?
  $bgColor=="#ffffff" ? $bgColor="#F7F7F7" : $bgColor="#ffffff";
  }
  ?>
  <tr>
  <td align="right" colspan="4" valign="top"><?php include_once('pageno.php');?></td></tr>
  <?
  }else
  {
  ?>
  <tr>
    <td align="center" colspan="4" valign="top"><?=errorMessage('No messages')?></td>
    </tr>
	<?
	}
	?>
</table>
</td></tr>
	
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
