<?
require_once('../config/config.php');

if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$table = SITE_STATUS;
		$where_clause = "WHERE statusId='".$_REQUEST['cid']."'";
		Delete_Qry($table,$where_clause);
	}

if($_REQUEST['mode'] == 'delete')
	{		
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
		$table = SITE_STATUS;
	    $where_clause = "WHERE statusId ='".$_REQUEST['chk'][$i]."'";
		Delete_Qry($table,$where_clause);
	}
}
	
	if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="stat"))
	{	
		if($_REQUEST['stat'] == '1')
		{
			$stat = '0';
		}
		else
		{
			$stat = '1';
		}
		$table = SITE_STATUS;
		$where_clause = "WHERE statusId='".$_REQUEST['sid']."'";
		$set_value ="status = '".$stat."'";
		Update_Qry($table,$set_value,$where_clause);
	}
	
	if($_REQUEST['mode'] == 'approve'){	
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
			 $whap=" WHERE statusId='".$_REQUEST['chk'][$i]."'";			
			 $setap=" status='1'";
			Update_Qry(SITE_STATUS,$setap,$whap);
			
		}
	}
	if($_REQUEST['mode'] == 'disapprove')
		{
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
			$whap=" WHERE statusId='".$_REQUEST['chk'][$i]."'";			
			$setap=" status='0'";
			Update_Qry(SITE_STATUS,$setap,$whap);
		}
	}
	################### INSERT and UPDATE #########################
	if(isset($_REQUEST['btnsubmit']))
	{
	  $where_chk="status_name='".escapeQuotes(stripslashes(trim($_REQUEST['name'])))."'";
	  if($_REQUEST['editid']!="")
	  {
	   $where_chk.="AND statusId <> '".$_REQUEST['editid']."'";
	  }
	  if(Select_Qry("*",SITE_STATUS,$where_chk,"","","",""))
		{
		$msg=errorMessage("Category name already exists try another one!");
		}
		else{
			
			$set="status_name='".escapeQuotes(stripslashes(trim($_REQUEST['name'])))."'";
							 
			if(isset($_REQUEST['mode1']) && $_REQUEST['mode1']=="edit")
			{
				$where_clause="WHERE statusId='".$_REQUEST['editid']."'";
				Update_Qry(SITE_STATUS,$set,$where_clause);
				$msg=successfulMessage("You are updated successfully");
			}
			else{
				Insert_Qry(SITE_STATUS,$set);
				$msg=successfulMessage("You are added successfully");
			    }
	       }
	    
		}
############Search#################
$where="";
if(isset($_REQUEST['btnSearch']))
{
$where="";
if($_REQUEST['name2']!="")
{
$where.="AND status_name like '%".$_REQUEST['name2']."%'";
}
}
######################################
$where_clause="statusId='".$_REQUEST['editid']."'";
$arr=Select_Qry("*",SITE_STATUS,$where_clause,"","","","");
?>
<script language="javascript">
function check()
{
	if(document.frm.name.value=="")
	{
	alert("Please enter Site Status Name");
	document.frm.name.focus();
	return false;
	}
	else
	{
	return true;
	}
}
 function statusCheck(id,stat)
	{
		window.location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=stat&sid='+id+'&id=<?=$_REQUEST['id']?>&stat='+stat;
		//document.frm.submit();
	}
	function jsHitListAction(p1)
	{			
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&PageNo="+eval(p1) ;
		document.frm.submit()
	}
	
function del(cid)
	{
	 if(confirm('Do you want to delete really?'))
	  {
      window.location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=del&cid='+cid;
	  }
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
	       alert("Select any category");
	       return false;
	    }
	   else
	    {
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
    }
 
</script>
<form name="frm" method="post" action="">
  
  <table width="100%" border="0">
			<tr>
			  <td align="left" valign="top">
			  <table width="100%" border="0">
			  <tr><td>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="6"><img src="images/7_01.png" width="6" height="64" /></td>
						<td background="images/7_03.png"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td colspan="2" class="texttitle">
							<img src="images/categorymanager.png" width="48" height="48" border="0" />
							<span style="padding-left:10px; padding-top:8px; position:absolute;">Site Status  Management </span></td>
							<td width="9%" align="center" valign="top">
					<a href="home.php?page=sitestatus&mode1=add">
					<img src="images/new.png" border="0" width="31" height="30" /><br />
					</a>
                    Add Site Status(s)<br /></td>
							<td width="7%" align="center" valign="top"><input type="button" name="btnapprove" class="publishbttn" value="" onClick="Javascript:return Confirm('approve')" /><br />
					Publish<br />
					</td>
                    <td width="9%" align="center" valign="top">
                      <input type="button" name="btndisapprove" class="unpublishbttn" value="" onClick="return Confirm('disapprove')" /><br />
                    Unpublish<br /></td>
							
							<td width="6%" align="center" valign="top">
							
							<input type="button" name="btndelete" class="deletebttn" value="" onClick="return Confirm('delete')" />
							<br />Delete<br />				    </td>
							<td width="2%" align="center">&nbsp;</td>
						  </tr>
						</table>				</td>
						<td width="10">
						<img src="images/7_05.png" width="6" height="64" />				</td>
					  </tr>
				</table>
			  
			  </td></tr>
				
			  </table>
			  </td>
			</tr>
			<? if($_REQUEST['mode1']!=''){ ?>
			<tr>
			  <td align="left" valign="top">
			    
			    <fieldset  style="width:98%;"><legend style="color:#000066;">
				<?=$_REQUEST['mode1']=='edit'?"Edit":"Add"?> Site Status</legend>
					  <table width="100%" border="0">
					  <tr>
				  <td align="center" colspan="3"><?=$msg?></td>
				  </tr>
  
   <? if($_REQUEST['mode1']!=''){ ?>
   <tr><td width="29%" align="right" valign="top"><strong>Site Status Name </strong></td>
   <td width="6%" align="center" valign="top"><strong>:</strong></td>
   <td width="65%" align="left" valign="top"><input type="text" name="name" value="<?=$arr['status_name']?>" size="30"/></td></tr>
   <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left"><input name="btnsubmit" type="submit" value="<?=$_REQUEST['mode1']=='edit'?"Update":"Insert"?>" onclick="return check()" class="bttn"/><input name="cancel" type="button" class="bttn" onclick="window.location.href='home.php?page=sitestatus'" value="Cancel"/></td>
  </tr>
   <? }?>
                </table>
			    </fieldset></td></tr><? }?>
				<tr>
			  <td align="left" valign="top">	 
				<fieldset  style="width:98%;">
					  <table width="100%" border="0">
					  <tr>
				  <td align="center" colspan="5"></td>
				  </tr>
  
  <tr>
    <td width="28%" align="center" class="label"><strong>Search By  Site Status Name </strong> </td>
    <td width="7%" align="center">:</td>
    <td width="35%" align="left"><input type="text" name="name2" size="30" class="input" value="<?=$_REQUEST['name2']?>"/></td>
    <td width="3%" align="center">&nbsp;</td>
    <td width="27%" align="left"><input type="submit" name="btnSearch" class="bttn" value="Filter" />&nbsp;<input type="button" name="btn" class="bttn" value="Viewall" onclick="window.location.href='home.php?page=sitestatus'" /></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
                      </table>
				</fieldset></td></tr>
					  <tr>
			  <td height="208" align="left" valign="top">	  
					  <table width="100%" border="0">
						<tr>
						<td height="189" valign="top" align="left" colspan="2">
								<table width="100%" cellpadding="5" cellspacing="0">
							   <tr>
							     <td width="6%" align="left" class="tblborder">Sl.no</td>
							   <td width="5%" height="30" align="left" class="tblborder"><input type="checkbox" name="chk_all" onclick="AllSelect()" /></td>
								
								 <td height="30" align="left" valign="top" class="tblborder" style="padding-left:10px;">Site Status Name  </td>
								
								 <td width="8%" align="left" class="tblborder" style="padding-left:10px;">Status</td>
								 <td height="30" colspan="2" align="center" class="tblborder">Action</td>
							   </tr>
		
		<? 
	$sql="SELECT * FROM ".SITE_STATUS." WHERE 1 ".$where." ORDER BY statusId DESC";          
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
						<tr valign="top" bgcolor="<?php echo $bgColor;?>" class="onmouse">
						  <td align="left" class="tblborder1"><?=($i+1+$recordNo)?></td>
						  <td align="left" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$arrsc["statusId"]?>" onclick="deselect_any()" /></td>
						  
						  <td width="68%" align="left" valign="top" class="tblborder1" style="padding-left:10px;"><?=$arrsc['status_name']?></td>
						  
						  <td align="center" class="tblborder1" style="padding-left:10px;"><a href="Javascript:void(0)" onclick="javascript:statusCheck('<?=$arrsc['statusId']?>','<?=$arrsc['status']?>')" class="tooltipClass" onmouseover="return escape('<?=$arrsc['status']=='0'?'Unpublished' : 'Published'?>')"><? echo(($arrsc['status'] == '0') ? '<img src="images/unpublish.png" border="0" alt="Unpublished"/>' : '<img src="images/apply.png" border="0" alt="Published"/>')?></a></td>
						  <td width="7%" align="center" class="tblborder1"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode1=edit&editid=<?=$arrsc['statusId']?>&PageNo=<?=$_REQUEST['PageNo']?>"><img src="images/edit.png" align="absmiddle" border="0"  alt="Click Here to Edit"/></a></td>
						<td width="6%" align="center" class="tblborder1"><a href="javascript:del(<?=$arrsc['statusId']?>)"><img src="images/delete.png" align="absmiddle" border="0" alt="Click Here to Delete"/></a></td>
						</tr>
				<?php 
		$bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
			} 
			?>
				  <tr><td colspan="8" align="right">Page No<? include_once('pageno.php');?></tr>
				 
				   <?
 					 }
				  else{
  					?>
  <tr>
    <td colspan="8" align="center" valign="top" class="error"><?=errorMessage("No Category Found")?></td>
  </tr>
  <?
  }
  ?>				</table></td>
				</tr>
				</table>
			  </td>
			</tr>
  </table>

</form>
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script> 