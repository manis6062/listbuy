<?
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
////////
if($_REQUEST['chk']!=""){
	$_SESSION['newsletter']=implode(",",$_REQUEST['chk']);
}

if(isset($_REQUEST['mode1']) && ($_REQUEST['mode1']=="del"))
	{	
		$table = USERNEWSLETTER;
		$where_clause = "WHERE id='".$_REQUEST['id']."'";
		Delete_Qry($table,$where_clause);
	}
	if($_REQUEST['mode1'] == 'delall'){			
		for($i=0;$i<sizeof($_REQUEST['userchk']);$i++){
		$table = USERNEWSLETTER;
		$where_clause = "WHERE id='".$_REQUEST['userchk'][$i]."'";
		Delete_Qry($table,$where_clause);
	}}
	

//////////
	if($_REQUEST['mode1']=="statsingle")
    {
	//echo "sffsdf";
	   if($_REQUEST['stat']=='1')
	    {
		 $stat='0';
		}
	   else
	    {
		 $stat='1';
		}	
		$sql_update="UPDATE ".USERNEWSLETTER." SET status='".$stat."' WHERE id='".$_REQUEST['sid']."'";       mysql_query($sql_update);
	}
	
	///////////
if($_REQUEST['mode1'] == 'approve'){	
		
		for($i=0;$i<sizeof($_REQUEST['userchk']);$i++){
			$obap=Select_Qry("status",USERNEWSLETTER," id ='".$_REQUEST['userchk'][$i]."'","","","","");
			 $whap=" WHERE id='".$_REQUEST['userchk'][$i]."'";			
			 $setap="status='1'";
			Update_Qry(USERNEWSLETTER,$setap,$whap);
			
		}
	}
	if($_REQUEST['mode1'] == 'disapprove'){
		for($i=0;$i<sizeof($_REQUEST['userchk']);$i++){
			$obap=Select_Qry("status",USERNEWSLETTER," id='".$_REQUEST['userchk'][$i]."'","","","","");
			$whap="WHERE id='".$_REQUEST['userchk'][$i]."'";			
			$setap="status='0'";
			Update_Qry(USERNEWSLETTER,$setap,$whap);
		
		}
	}
	
?>
<script language="javascript" type="text/javascript" src="js/CalendarPopup.js"></script>
<script language="javascript">


	function statusCheck(id,stat)
	{
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&PageNo=<?=$_REQUEST['PageNo']?>&mode1=statsingle&sid=" + id + "&id=<?php echo($_REQUEST['id']);?>&stat=" + stat;
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
	if(document.frm.usrchk_all.checked==true)
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
		    		document.frm.usrchk_all.checked=false;
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
			document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode1='+status;
		   		document.frm.submit();
				//return true;
		    }
			else 
			{
			  return false;
			}
	    }
		
		function Confirm1(status)
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
	       alert("Select any User");
	       return false;
	    }
		
	       var con = confirm("Are You Sure?")
	       if(con)
		    {
			document.frm.action="home.php?page=newsletter-user";
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
<input type="hidden" name="newsletter" value="<?=implode(",",$_REQUEST['chk'])?>" />
<input type="hidden" name="mode" value="selected" />
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
					<span style="padding-left:10px; padding-top:8px; position:absolute;">Newsletter User Management  </span></td>
					<td width="7%" align="center" valign="middle"><input type="button" name="btnapprove" class="publishbttn" value="" onClick="return Confirm('approve')" /><br />
					Publish<br />
					</td>
                    <td width="9%" align="center" valign="middle">
                      <input type="button" name="btndisapprove" class="unpublishbttn" value="" onClick="return Confirm('disapprove')" /><br />
                    Unpublish<br /></td>
					
                    <td width="6%" align="center" valign="middle"><input type="button" name="btndelete" class="deletebttn" value="" onclick="return Confirm('delall')" />
                    <br />Delete<br />	
                   
                    </td>
					
                  </tr>
              </table></td><td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td></tr>
<tr><td align="left" valign="top">

<table width="100%" border="0" cellpadding="4" cellspacing="0">
  
  <tr>
    <td colspan="9" align="center" valign="top"><?=$msg?></td>
  </tr>
  <tr>
    <td width="10%" align="left" valign="top" class="tblborder">Sl. No </td>
    <td width="5%" align="left" valign="top" class="tblborder"><input type="checkbox" name="usrchk_all" onClick="AllSelect()" /></td>
	 <td width="40%" align="left" valign="top" class="tblborder">Email</td>
    <td width="18%" align="left" valign="top" class="tblborder">Created On</td>
    <td width="13%" align="center" valign="top" class="tblborder">Status</td>
    <td width="14%" colspan="2" align="center" valign="top" class="tblborder">Action</td>
  </tr>
  
  <?                        $PageSize =30;	#_____________ Changes for no page & records
                            $StartRow = 0;
                            $sql="SELECT * FROM ".USERNEWSLETTER." WHERE 1 ORDER BY id ";
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
									
									?>
  <tr bgcolor="<?php echo $bgColor;?>" class="onmouse">
    <td height="35" align="center" valign="top" class="tblborder1"><?=$i+1?></td>
    <td align="left" valign="top" class="tblborder1"><input type="checkbox" name="userchk[]" value="<?=$obj_fetch["id"]?>" onClick="deselect_any()" /></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['email']?></td>
    <td align="left" valign="top" class="tblborder1"><?=dateprint($obj_fetch['reg_on'])?></td>
    <td align="center" valign="top" class="tblborder1"><a href="javascript: statusCheck(<? echo($obj_fetch['id']);?>,<? echo($obj_fetch['status']);?>)" class="tooltipClass" onmouseover="return escape('<?=$obj_fetch['status']=='0'?'Unpublished' : 'Published'?>')"><? echo(($obj_fetch['status'] == '0') ? '<img src="images/unpublish.png" border="0" alt="Unpublished"/>' : '<img src="images/apply.png" border="0" alt="Published"/>')?></a></td>
    <td align="center" valign="top" class="tblborder1"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode1=del&id=<?=$obj_fetch['id']?>"onclick="return confirm('Are you sure to delete?')"><img src="images/delete.png" border="0" alt="Click Here to Delete"/></a></td>
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
    <td colspan="9" align="center" valign="top" class="error"><?=errormessage("No Newsletter currently available")?></td>
  </tr>
  <?
  }
  ?>
</table>

</td></tr>
</table>
</form>
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script>
