<?
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
################ SEARCH #####################
	if($_REQUEST['where']!=""){
		$where=stripslashes($_REQUEST['where']);
	}
	else{
		$where="";
	}
	if(isset($_REQUEST['btnSubmit'])){
	
		$where="";
		if(trim($_REQUEST['title'])!="")
		{
			$where.=" AND title LIKE '%".escapeQuotes(stripslashes(trim($_REQUEST['title'])))."%'";
		}
		if(trim($_REQUEST['website'])!="")
		{
		$where.=" AND website LIKE '%".escapeQuotes(stripslashes(trim($_REQUEST['website'])))."%'";
		}
		
	}
	###################### DELETE #######################	
 if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$table = ADVERTISE;
		$delun=Select_Qry("*",$table,"add_id='".$_REQUEST['id']."'","","","","");
		@unlink("../websiteImage/".$delun['site_img']);
		@unlink("../websiteImage/thumb".$delun['site_img']);
		$where_clause = "WHERE add_id='".$_REQUEST['id']."'";
		Delete_Qry($table,$where_clause);
	}
	if($_REQUEST['mode'] == 'delall'){			
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
		$table = ADVERTISE;
		
		$delunlin=Select_Qry("*",$table,"add_id='".$_REQUEST['chk'][$i]."'","","","","");
		@unlink("../websiteImage/".$delunlin['site_img']);
		@unlink("../websiteImage/thumb".$delunlin['site_img']);
		
		$where_clause = "WHERE add_id='".$_REQUEST['chk'][$i]."'";
		Delete_Qry($table,$where_clause);
	}
}
################# STATUS #################
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='stat')
    {
	   if($_REQUEST['stat']=='1')
	    {
		 $status='0';
		}
	   else
	    {
		 $status='1';
		}	
		$sql_update="UPDATE ".ADVERTISE." SET status='".$status."' WHERE add_id='".$_REQUEST['sid']."'";
		mysql_query($sql_update);
	}

	if($_REQUEST['mode'] == 'approvesold')
	{	
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			$whap=" WHERE add_id='".$_REQUEST['chk'][$i]."'";			
			 $setap="status='2'";
			Update_Qry(ADVERTISE,$setap,$whap);
		}
	}


	if($_REQUEST['mode'] == 'approve')
	{	
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			$whap=" WHERE add_id='".$_REQUEST['chk'][$i]."'";			
			 $setap="status='1'";
			Update_Qry(ADVERTISE,$setap,$whap);
		}
	}
	
	if($_REQUEST['mode'] == 'disapprove')
		{
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			$whap="WHERE add_id='".$_REQUEST['chk'][$i]."'";			
			$setap="status='0'";
			Update_Qry(ADVERTISE,$setap,$whap);
		}
	}	
?>
<script language="javascript" type="text/javascript" src="js/CalendarPopup.js"></script>
<script language="javascript">
function statusCheck(id,stat)
	{
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=stat&sid=" + id + "&stat=" + stat;
		document.frm.submit();
	}
	
function jsHitListAction(p1)
	{			
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&PageNo=" + eval(p1) ;
		document.frm.submit()
	}
	
	 /////////
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
	       alert("Select any Name");
	       return false;
	    }
		
	       var con = confirm("Are You Sure?")
	       if(con)
		    {
			document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode='+status;
		   		document.frm.submit();
				//return true;
		    }
			else 
			{
			  return false;
			}
	    }
 
</script>
<form action="" method="post" name="frm">
<input type="hidden" name="where" value="<?=stripslashes($where)?>" />
<table width="100%" cellpadding="3" cellspacing="0">
<tr><td align="left" valign="top">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="6"><img src="images/7_01.png" width="6" height="64" />
</td>
<td background="images/7_03.png">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="55%" class="texttitle">
					<img src="images/mediamanager.png" width="48" height="48" border="0" />
					<span style="padding-left:10px; padding-top:8px; position:absolute; left: 75px; top: 44px;">Cancelled Auction List  </span></td>
					<td width="10%" align="center" valign="top">
					</td>
					
                    <td width="10%" align="center" valign="top">
					</td>
                    <td width="8%" align="center" valign="top">
                    </td>
                    <td width="9%" align="center" valign="top">
					</td>
                    <td width="8%" align="center" valign="top"><input type="submit" name="btndelete" class="deletebttn" value="" onclick="return Confirm('delall')" />
                    <br />Delete<br />	
                   
                    </td>
                  </tr>
              </table></td><td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td></tr>
<tr><td align="left" valign="top">

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="9" align="left" valign="top">
	
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="6"><img src="images/7_01.png" width="6" height="64" />
</td>
<td background="images/7_03.png">
<table cellpadding="3" cellspacing="0" width="100%">
<tr>
<td width="8%" align="left" valign="top"><strong>Title </strong></td>
<td width="28%" align="left" valign="top"><input type="text" name="title" value="<?=$_REQUEST['title']?>" size="30" class="input"/></td><td width="11%" align="left" valign="top"><strong>Website</strong></td>
  <td width="28%" align="left" valign="top"><input type="text" name="website" value="<?=$_REQUEST['website']?>" size="30" class="input"/></td><td width="25%" align="left" valign="top"><input type="submit" value="Search" name="btnSubmit" class="bttn"/>&nbsp;<input type="button" name="viewall" value="Viewall" onclick="window.location.href='home.php?page=<?=$_REQUEST['page']?>'" class="bttn"/></td></tr>
</table></td>
<td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td>
  </tr>
  <tr>
    <td colspan="9" align="center" valign="top"><?=$msg?></td>
  </tr>
  <tr>
    <td width="6%" align="left" valign="top" class="tblborder">Sl. No </td>
    <td width="4%" align="left" valign="top" class="tblborder"><input type="checkbox" name="chk_all" onClick="AllSelect()" /></td>
	 <td width="14%" align="left" valign="top" class="tblborder">Title</td>
     <td width="15%" align="left" valign="top" class="tblborder">Website</td>
     <td width="13%" align="left" valign="top" class="tblborder">Posted On</td>
     <td width="11%" align="left" valign="top" class="tblborder">Expired On</td>
     <td width="13%" align="center" valign="top" class="tblborder">Option</td>
     <td width="7%" align="center" valign="top" class="tblborder">Status</td>
    <td align="center" valign="top" class="tblborder">Action</td>
  </tr>
  
 			 <?             
			 		$PageSize =30;	
                    $StartRow = 0;
                    $sql="SELECT * FROM ".ADVERTISE." WHERE status='3' ".$where." ORDER BY add_id  DESC";
							$slNo=0;
							include_once('paging-top.php');
                            if(mysql_num_rows($rs)>0)
							{
								$bgColor = "#ffffff";
									for($i=0;$i<mysql_num_rows($rs);$i++)
									{
									$slNo++;
									$obj_fetch=mysql_fetch_array($rs);
	$attach=Select_Qry("COUNT(id) as tid",ATTACHMENTS,"add_id='".$obj_fetch['add_id']."'","","","","");	
	$prposa=Select_Qry("COUNT(id) as pid",PROPOSAL,"add_id='".$obj_fetch['add_id']."'","","","","");	
	
	$feedbart=Select_Qry("COUNT(id) as fid",USER_FEEDBACK,"add_id='".$obj_fetch['add_id']."'","","","","");								
									?>
  <tr bgcolor="<?php echo $bgColor;?>" class="onmouse">
    <td height="35" align="left" valign="top" class="tblborder1"><?=($i+1+$recordNo)?></td>
    <td align="left" valign="top" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$obj_fetch["add_id"]?>" onClick="deselect_any()" /></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['title']?></td>
    <td align="left" valign="top" class="tblborder1"><? if($obj_fetch['site_img']!=''){?><img src="../websiteImage/<?=$obj_fetch['site_img']?>" width="50" align="absmiddle"/><br /><? }?><?=$obj_fetch['website']?></td>
    <td align="left" valign="top" class="tblborder1"><?=dateprint($obj_fetch['posted_on'])?></td>
    <td align="left" valign="top" class="tblborder1"><?=dateprint($obj_fetch['valid_till'])?></td>
    <td align="center" valign="top" class="tblborder1"><a href="home.php?page=attachment&add_id=<?=$obj_fetch['add_id']?>">Attachment(<?=$attach['tid']?>)</a><br /><br /><a href="home.php?page=proposal&add_id=<?=$obj_fetch['add_id']?>">Bidding(<?=$prposa['pid']?>)</a><br /><br /><a href="home.php?page=feedback-list&add_id=<?=$obj_fetch['add_id']?>">Feedback(<?=$feedbart['fid']?>)</a><br /></td>
    <td align="center" valign="top" class="tblborder1"><?php /*?><a href="javascript: statusCheck(<?php echo($obj_fetch['add_id']);?>,<?php echo($obj_fetch['status']);?>)" class="tooltipClass" onmouseover="return escape('<?=$obj_fetch['status']=='0'?'Relist' : 'Listed'?>')">
				  <?php echo(($obj_fetch['status'] == '0') ? '<img src="images/unpublish.png" border="0"  alt="Unpublished"/>' : '<img src="images/apply.png" border="0" alt="Published"/>')?></a><br /><?php */?><? if($obj_fetch['status']=='3'){?><span style="color:#FF0000">Cancelled</span><? }?></td>
    <td width="7%" align="center" valign="top" class="tblborder1"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=del&id=<?=$obj_fetch['add_id']?>"onclick="return confirm('Are you sure to delete')"><img src="images/delete.png" align="absmiddle" border="0" alt="Click Here to Delete"/></a></td>
  </tr>
  <?
  $bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
  }
  ?>
  <tr>
    <td colspan="9" align="right" valign="top">Page No : <? include_once('pageno.php');?></td>
    </tr>
  
  <?
  }
  else{
  ?>
  <tr>
    <td colspan="9" align="center" valign="top" class="error"><?=errormessage("No listed cancelled yet")?></td>
  </tr>
  <?
  }
  ?>
</table>

</td></tr>
</table>
</form>
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script>
