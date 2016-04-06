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
		if(trim($_REQUEST['username'])!=""){
			$where.=" AND username LIKE '%".escapeQuotes(stripslashes(trim($_REQUEST['username'])))."%'";
		}
		if(trim($_REQUEST['email'])!=""){
			$where.=" AND email LIKE '%".escapeQuotes(stripslashes(trim($_REQUEST['email'])))."%'";
		}
		if(trim($_REQUEST['city'])!=""){
			$where.=" AND city LIKE '%".escapeQuotes(stripslashes(trim($_REQUEST['city'])))."%'";
		}	
	}
	###################### DELETE #######################	
 if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$table = USER;
		$where_clause = "WHERE user_id='".$_REQUEST['id']."'";
		Delete_Qry($table,$where_clause);
		Delete_Qry(ADVERTISE,$where_clause);
		Delete_Qry(ATTACHMENTS,$where_clause);
		Delete_Qry(BIN,$where_clause);
		Delete_Qry(CREDIT,$where_clause);
		Delete_Qry(PROPOSAL,$where_clause);
		Delete_Qry(SHORTLIST,$where_clause);
		Delete_Qry(TRANSACTION,$where_clause);
		Delete_Qry(TERM_VIOLATION,$where_clause);
	}
	if($_REQUEST['mode'] == 'delall'){			
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
		$table = USER;
		$where_clause = "WHERE user_id='".$_REQUEST['chk'][$i]."'";
		Delete_Qry($table,$where_clause);
		Delete_Qry(ADVERTISE,$where_clause);
		Delete_Qry(ATTACHMENTS,$where_clause);
		Delete_Qry(BIN,$where_clause);
		Delete_Qry(CREDIT,$where_clause);
		Delete_Qry(PROPOSAL,$where_clause);
		Delete_Qry(SHORTLIST,$where_clause);
		Delete_Qry(TRANSACTION,$where_clause);
		Delete_Qry(TERM_VIOLATION,$where_clause);
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
		$sql_update="UPDATE ".USER." SET status='".$status."' WHERE user_id='".$_REQUEST['sid']."'";
		mysql_query($sql_update);
		
		Update_Qry(ADVERTISE,"status='".$status."'","WHERE user_id='".$_REQUEST['sid']."'");
	}

	if($_REQUEST['mode'] == 'approve')
	{	
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			$whap=" WHERE user_id='".$_REQUEST['chk'][$i]."'";			
			 $setap="status='1'";
			Update_Qry(USER,$setap,$whap);
			Update_Qry(ADVERTISE,$setap,$whap);
		}
	}
	
	if($_REQUEST['mode'] == 'disapprove')
		{
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			$whap="WHERE user_id='".$_REQUEST['chk'][$i]."'";			
			$setap="status='0'";
			Update_Qry(USER,$setap,$whap);
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
                    <td width="69%" class="texttitle">
					<img src="images/usermanager.png" width="48" height="48" />
					<span style="padding-left:10px; padding-top:8px; position:absolute;">User Management  </span></td>
                    <td width="7%" align="center" valign="top"><input type="submit" name="btnapprove" class="publishbttn" value="" onClick="return Confirm('approve')" /><br />
					Publish<br />
					</td>
                    <td width="9%" align="center" valign="top">
                      <input type="submit" name="btndisapprove" class="unpublishbttn" value="" onClick="return Confirm('disapprove')" /><br />
                    Unpublish<br /></td>
                    <td width="9%" align="center" valign="top">
					<a href="home.php?page=add-user">
					<img src="images/new.png" border="0" width="31" height="30" /><br />
					</a>
                    Create User <br /></td>
                    <td width="6%" align="center" valign="top"><input type="submit" name="btndelete" class="deletebttn" value="" onclick="return Confirm('delall')" />
                    <br />Delete<br />	
                   
                    </td>
                  </tr>
              </table></td><td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td></tr>
<tr><td align="left" valign="top">

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="11" align="left" valign="top">
	
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="6"><img src="images/7_01.png" width="6" height="64" />
</td>
<td background="images/7_03.png">
<table cellpadding="3" cellspacing="0" width="100%">
<tr>
<td width="13%" align="left" valign="top"><strong> Username </strong></td>
<td width="17%" align="left" valign="top"><input type="text" name="username" value="<?=$_REQUEST['username']?>" size="15" class="input" /></td><td width="8%" align="left" valign="top"><strong>E-mail</strong></td>
<td width="17%" align="left" valign="top"><input type="text" name="email" value="<?=$_REQUEST['email']?>" size="15" class="input"/></td>
  <td width="6%" align="left" valign="top"><strong>City</strong></td>
  <td width="16%" align="left" valign="top"><input type="text" name="city" value="<?=$_REQUEST['city']?>" size="15" class="input"/></td><td width="23%" align="left" valign="top"><input type="submit" value="Search" name="btnSubmit" class="bttn"/>&nbsp;<input type="button" name="viewall" value="Viewall" onclick="window.location.href='home.php?page=<?=$_REQUEST['page']?>'" class="bttn"/></td></tr>
</table></td>
<td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td>
  </tr>
  <tr>
    <td colspan="11" align="center" valign="top"><?=$msg?></td>
  </tr>
  <tr>
    <td width="6%" align="left" valign="top" class="tblborder">Sl. No </td>
    <td width="4%" align="left" valign="top" class="tblborder"><input type="checkbox" name="chk_all" onClick="AllSelect()" /></td>
	 <td width="15%" align="left" valign="top" class="tblborder">Username</td>
     <td width="12%" align="left" valign="top" class="tblborder">Email</td>
     <td width="10%" align="left" valign="top" class="tblborder">City</td>
     <td width="9%" align="center" valign="top" class="tblborder">Credit Point</td>
     <td width="12%" align="left" valign="top" class="tblborder">Registered On</td>
    <td width="11%" align="center" valign="top" class="tblborder">Option</td>
    <td width="8%" align="center" valign="top" class="tblborder">Status</td>
    <td colspan="2" align="center" valign="top" class="tblborder">Action</td>
  </tr>
  
 			 <?             
			 			$PageSize =30;	
                     $StartRow = 0;
                    $sql="SELECT * FROM ".USER." WHERE 1 ".$where." ORDER BY user_id  DESC";
							$slNo=0;
							include_once('paging-top.php');
                            if(mysql_num_rows($rs)>0)
							{
								if(isset($_REQUEST['PageNo']) && $_REQUEST['PageNo']!='')
										{
											$recordNo=$PageSize*($_REQUEST['PageNo']-1);
										}
									$bgColor = "#ffffff";
									for($i=0;$i<mysql_num_rows($rs);$i++)
									{
									$slNo++;
									$obj_fetch=mysql_fetch_array($rs);
	$prposal=Select_Qry("COUNT(id) as prid",PROPOSAL,"user_id='".$obj_fetch['user_id']."'","","","","");									
	$credit_point=Select_Qry("credit",CREDIT,"user_id='".$obj_fetch['user_id']."'","","","","");								?>
  <tr bgcolor="<?php echo $bgColor;?>" class="onmouse">
    <td height="35" align="left" valign="top" class="tblborder1"><?=($i+1+$recordNo)?></td>
    <td align="left" valign="top" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$obj_fetch["user_id"]?>" onClick="deselect_any()" /></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['username']?></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['email']?></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['city']?></td>
    <td align="center" valign="top" class="tblborder1"><span style="color:#D50000"><?=$credit_point['credit']?></span></td>
    <td align="left" valign="top" class="tblborder1"><?=dateprint($obj_fetch['reg_on'])?></td>
    <td align="center" valign="top" class="tblborder1"><a href="home.php?page=my-message&uid=<?php echo $obj_fetch['user_id']?>&m=inbox">My messages</a><br /><br /><a href="home.php?page=proposal&uid=<?=$obj_fetch['user_id']?>">Placed Bids(<?=$prposal['prid']?>)</a><br /><a href="home.php?page=question-list&uid=<?=$obj_fetch['user_id']?>">Question</a><br /><a href="home.php?page=feedback-list&uid=<?=$obj_fetch['user_id']?>">Feedback</a></td>
    <td align="center" valign="top" class="tblborder1"><a href="javascript: statusCheck(<?php echo($obj_fetch['user_id']);?>,<?php echo($obj_fetch['status']);?>)" class="tooltipClass" onmouseover="return escape('<?=$obj_fetch['status']=='0'?'Unpublished' : 'Published'?>')">
				  <?php echo(($obj_fetch['status'] == '0') ? '<img src="images/unpublish.png" border="0"  alt="Unpublished"/>' : '<img src="images/apply.png" border="0" alt="Published"/>')?></a></td>
    <td width="6%" align="center" valign="top" class="tblborder1">
	<a href="home.php?page=add-user&id=<?=$obj_fetch['user_id']?>"><img src="images/edit.png" border="0" align="absmiddle" alt="Click Here to Edit"/></a></td>
    <td width="7%" align="center" valign="top" class="tblborder1"><a href="<?=$_SERVER['PHP_SELF']?>?page=user-list&mode=del&id=<?=$obj_fetch['user_id']?>"onclick="return confirm('Are you sure to delete')"><img src="images/delete.png" align="absmiddle" border="0" alt="Click Here to Delete"/></a></td>
  </tr>
  <?
  $bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
  }
  ?>
  <tr>
    <td colspan="11" align="right" valign="top">Page No : <? include_once('pageno.php');?></td>
    </tr>
  
  <?
  }
  else{
  ?>
  <tr>
    <td colspan="11" align="center" valign="top" class="error"><?=errormessage("No User currently available")?></td>
  </tr>
  <?
  }
  ?>
</table>

</td></tr>
</table>
</form>
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script>
