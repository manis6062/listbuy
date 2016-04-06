<?
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
////////
	$where="";
	if(isset($_REQUEST['btnSubmit'])){
	$where="";
	if(trim($_REQUEST['searchText'])!=""){
		$Q=mysql_query("SELECT * FROM ".ADVERTISE." WHERE 1  AND title='".$_REQUEST['searchText']."'");
		$rec=mysql_fetch_array($Q);
		if(mysql_num_rows($Q)>0)
		{
			$where.=" AND add_id='".$rec['add_id']."'";
		}
		else
		{
			$where.=" AND add_id='".$rec['add_id']."'";
		}
		}
	
	}
		
 if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$table = TERM_VIOLATION;
		$where_clause = "WHERE id='".$_REQUEST['id']."'";
		Delete_Qry($table,$where_clause);
	}
	if($_REQUEST['mode'] == 'delall'){			
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
		$table = TERM_VIOLATION;
		$where_clause = "WHERE id='".$_REQUEST['chk'][$i]."'";
		Delete_Qry($table,$where_clause);
	}}
	
	
	
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
	       alert("Select any Report");
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
	       alert("Select any Report");
	       return false;
	    }
		
	       var con = confirm("Are You Sure?")
	       if(con)
		    {
			document.frm.action="home.php?page=report-list";
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
<table width="100%" cellpadding="3" cellspacing="0">
<tr><td align="left" valign="top">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="6"><img src="images/7_01.png" width="6" height="64" />
</td>
<td background="images/7_03.png">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="69%" class="texttitle">
					<img src="images/cmspage.png" />
					<span style="padding-left:10px; padding-top:8px; position:absolute;">Report Management  </span></td>
					<td width="6%" align="center" valign="middle"></td>
                    
                    <td width="6%" align="center" valign="middle"><input type="submit" name="btndelete" class="deletebttn" value="" onclick="return Confirm('delall')" />
                    <br />Delete<br />                    </td>
                  </tr>
              </table></td><td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td></tr>
<tr><td align="left" valign="top">

<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td colspan="7" align="left" valign="top">
	
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="6"><img src="images/7_01.png" width="6" height="64" />
</td>
<td background="images/7_03.png"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr>
    
	<td width="122" align="right" valign="top"><strong>Listing Title</strong></td>
    <td width="16" align="center" valign="top"><strong>:</strong></td>
    <td width="360" align="left" valign="top"><input type="text"  name="searchText" class="input" id="searchText" value="<?=$_REQUEST['searchText']?>" size="60" /></td>
    <td width="144" align="left" valign="top"><input type="submit" name="btnSubmit" class="bttn" value="Filter" />&nbsp;<input type="button" name="viewall" value="Viewall" class="bttn" onclick="window.location.href='home.php?page=<?=$_REQUEST['page']?>'" /> </td>
  </tr>
</table></td>
<td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="top"><?=$msg?></td>
  </tr>
  <tr>
    <td width="5%" align="left" valign="top" class="tblborder">Sl. No </td>
    <td width="4%" align="left" valign="top" class="tblborder"><input type="checkbox" name="chk_all" onClick="AllSelect()" /></td>
	 <td width="17%" align="left" valign="top" class="tblborder">Name</td>
    <td width="27%" align="left" valign="top" class="tblborder">Listing Title </td>
    <td width="22%" align="left" valign="top" class="tblborder">Message</td>
    <td width="11%" align="left" valign="top" class="tblborder">Created On</td>
    <td width="8%" align="center" valign="top" class="tblborder">Action</td>
  </tr>
<?   
	$PageSize =30;	#_____________ Changes for no page & records
	$StartRow = 0;
	$sql="SELECT * FROM ".TERM_VIOLATION." WHERE 1 ".$where." ORDER BY id ";
	$slNo=0;
	include_once('paging-top.php');
	if(mysql_num_rows($rs)>0)
	{
		$bgColor = "#ffffff";
		for($i=0;$i<mysql_num_rows($rs);$i++)
		{
			$slNo++;
			$obj_fetch=mysql_fetch_array($rs);
									
?>
  <tr bgcolor="<?php echo $bgColor;?>" class="onmouse">
    <td height="35" align="left" valign="top" class="tblborder1"><?=$i+1?></td>
    <td align="left" valign="top" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$obj_fetch["id"]?>" onClick="deselect_any()" /></td>
    <td align="left" valign="top" class="tblborder1"><?=USERNAME($obj_fetch['user_id'])?></td>
    <td align="left" valign="top" class="tblborder1"><?=ADDTITLE($obj_fetch['add_id'])?></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['message']?></td>
    <td align="left" valign="top" class="tblborder1"><?=dateprint($obj_fetch['posted_on'])?></td>
    <td align="center" valign="top" class="tblborder1">	  <a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=del&id=<?=$obj_fetch['id']?>"onclick="return confirm('Are you sure to delete?')"><img src="images/delete.png" border="0" alt="Click Here to Delete"/></a></td>
    </tr>
  <?
  $bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
  }
  ?>
  <tr>
    <td colspan="7" align="right" valign="top">Page No : <? include_once('pageno.php');?></td>
    </tr>
  
  <?
  }
  else{
  ?>
  <tr>
    <td colspan="7" align="center" valign="top" class="error">
	<?=errormessage("No Report currently available")?></td>
  </tr>
  <?
  }
  ?>
</table>

</td></tr>
</table>
</form>
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script>
