<?
require_once('../config/config.php');

if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$table = USER_FEEDBACK;
		$where_clause = "WHERE id='".$_REQUEST['cid']."'";
		Delete_Qry($table,$where_clause);
	}

if($_REQUEST['mode'] == 'delete')
	{		
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
		$table = USER_FEEDBACK;
	    $where_clause = "WHERE id ='".$_REQUEST['chk'][$i]."'";
		Delete_Qry($table,$where_clause);
	}
}
######################################
if($_REQUEST['uid']!="")
	{
	$title=USERNAME($_REQUEST['uid']);
	$where="user_id='".$_REQUEST['uid']."'";
	}
	if($_REQUEST['add_id']!="")
	{
	$title=ADDTITLE($_REQUEST['add_id']);
	$where="add_id='".$_REQUEST['add_id']."'";
	}
?>
<script language="javascript">
function statusCheck(id,stat)
	{
		window.location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>&mode=stat&sid='+id+'&stat='+stat;
		//document.frm.submit();
	}
	function jsHitListAction(p1)
	{			
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>&PageNo="+eval(p1) ;
		document.frm.submit()
	}
	
function del(cid)
	{
	 if(confirm('Do you want to delete really?'))
	  {
      window.location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>&mode=del&cid='+cid;
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
	       alert("Select any question");
	       return false;
	    }
	   else
	    {
	       var con = confirm("Are You Sure?")
	       if(con)
		    {
			document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>&mode='+status;
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
							<span style="padding-left:10px; padding-top:8px; position:absolute;">Feedback of <?=substr(strip_tags($title),0,30)?></span></td>
							
							<td width="12%" align="center" valign="top"><a href="home.php?page=<?=$_REQUEST['uid']==""?"auction-list":"user-list"?>"><img src="images/close.png" border="0" align="absmiddle" /></a><br />
						    Close</td>
							<td width="10%" align="center" valign="top">
							
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
			
				
					  <tr>
			  <td height="208" align="left" valign="top">	  
					  <table width="100%" border="0">
						<tr>
						<td height="189" valign="top" align="left" colspan="2">
								<table width="100%" cellpadding="5" cellspacing="0">
							   <tr>
							     <td width="7%" align="left" class="tblborder">Sl.no</td>
							   <td width="6%" height="30" align="left" class="tblborder"><input type="checkbox" name="chk_all" onclick="AllSelect()" /></td>
								
								 <td height="30" align="left" valign="top" class="tblborder" style="padding-left:10px;">Sender</td>
								
								 <td width="16%" align="left" class="tblborder" style="padding-left:10px;">Subject</td>
								 <td width="37%" align="left" class="tblborder" style="padding-left:10px;">Comment</td>
								 <td width="11%" align="left" class="tblborder" style="padding-left:10px;">Sent on</td>
								 <td height="30" align="center" class="tblborder">Action</td>
							   </tr>
		
		<? 
	$sql="SELECT * FROM ".USER_FEEDBACK." WHERE ".$where." ORDER BY id DESC";          
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
						  <td align="left" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$arrsc[" id"]?>" onclick="deselect_any()" /></td>
						  
						  <td width="14%" align="left" valign="top" class="tblborder1" style="padding-left:10px;"><?=USERNAME($arrsc['posted_by'])?></td>
						  
			<td align="left" class="tblborder1" style="padding-left:10px;"><?=$arrsc['subject']?></td>
						  <td align="left" class="tblborder1" style="padding-left:10px;"><?=substr(strip_tags($arrsc['comment']),0,150)?></td>
						  <td align="left" class="tblborder1" style="padding-left:10px;"><?=dateprint($arrsc['posted_on'])?></td>
						  <td width="9%" align="center" class="tblborder1"><a href="javascript:del(<?=$arrsc['id']?>)"><img src="images/delete.png" align="absmiddle" border="0" alt="Click Here to Delete"/></a></td>
						</tr>
				<?php 
		$bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
			} 
			?>
				  <tr><td colspan="9" align="right">Page No<? include_once('pageno.php');?></tr>
				 
				   <?
 					 }
				  else{
  					?>
  <tr>
    <td colspan="9" align="center" valign="top" class="error"><?=errorMessage("No feedback posted")?></td>
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