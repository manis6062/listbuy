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
	###################### DELETE #######################	
 if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$table = PROPOSAL;
		$where_clause = "WHERE id='".$_REQUEST['id']."'";
		Delete_Qry($table,$where_clause);
	}
	if($_REQUEST['mode'] == 'delall'){			
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
		$table = PROPOSAL;
		$where_clause = "WHERE id='".$_REQUEST['chk'][$i]."'";
		Delete_Qry($table,$where_clause);
	}
}
################# STATUS #################
	/*if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='stat')
    {
	   if($_REQUEST['stat']=='1')
	    {
		 $status='0';
		}
	   else
	    {
		 $status='1';
		}	
		$sql_update="UPDATE ".PROPOSAL." SET status='".$status."' WHERE id='".$_REQUEST['sid']."'";
		mysql_query($sql_update);
	}

	if($_REQUEST['mode'] == 'approve')
	{	
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			$whap=" WHERE id='".$_REQUEST['chk'][$i]."'";			
			 $setap="status='1'";
			Update_Qry(PROPOSAL,$setap,$whap);
		}
	}
	
	if($_REQUEST['mode'] == 'disapprove')
		{
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
			$whap="WHERE id='".$_REQUEST['chk'][$i]."'";			
			$setap="status='0'";
			Update_Qry(PROPOSAL,$setap,$whap);
		}
	}*/
	
	
	$wherel="";	
	if(escapeQuotes(stripslashes($_REQUEST['accept']))=='0'){
		$wherel=" AND accept='0'";
	}
	elseif(escapeQuotes(stripslashes($_REQUEST['accept']))=='1'){
		$wherel=" AND accept='1'";
	}
	elseif(escapeQuotes(stripslashes($_REQUEST['accept']))=='2'){
		$wherel=" AND accept='2'";
	}
	elseif(escapeQuotes(stripslashes($_REQUEST['accept']))=='3'){
		$wherel=" AND accept='3'";
	}
	
	elseif(escapeQuotes(stripslashes($_REQUEST['accept']))=='4'){
		$wherel=" AND accept='4'";
	}
	else{
		$wherel="";
	}	
####################################################	
	
?>
<script language="javascript" type="text/javascript" src="js/CalendarPopup.js"></script>
<script language="javascript">

function statusCheck(id,stat)
	{
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>&mode=stat&sid=" + id + "&stat=" + stat;
		document.frm.submit();
	}
	
function jsHitListAction(p1)
	{			
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>&PageNo=" + eval(p1) ;
		document.frm.submit()
	}


function dostat(id){
	document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>';
	document.frm.submit();
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
	       alert("Select any Proposal");
	       return false;
	    }
		
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
 
 
 /////////
 
 function keyRestrict(e, validchars)
	{
	 var key='', keychar='';
	 key = getKeyCode(e);
	 if (key == null) return true;
	 keychar = String.fromCharCode(key);
	 keychar = keychar.toLowerCase();
	 validchars = validchars.toLowerCase();
	 if (validchars.indexOf(keychar) != -1)
	  return true;
	 if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
	  return true;
	 return false;
    }
    function getKeyCode(e)
	{
	 if (window.event)
		return window.event.keyCode;
	 else if (e)
		return e.which;
	 else
		return null;
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
                    <td width="74%" class="texttitle">
					<img src="images/usermanager.png" width="48" height="48" />
					<span style="padding-left:10px; padding-top:8px; position:absolute;"> <?=substr(strip_tags($title),0,30)?> Bidding History</span></td>
					<td width="13%" align="center" valign="top"><a href="#" onclick="javascript:history.back();"><img src="images/close.png" border="0" align="absmiddle" /></a><br />
				    Close</td>
                    <td width="13%" align="center" valign="top"><input type="submit" name="btndelete" class="deletebttn" value="" onclick="return Confirm('delall')" />
                    <br />Delete<br />                    </td>
                  </tr>
              </table></td><td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td></tr>
<tr><td align="left" valign="top">

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  
  <tr>
    <td colspan="8" align="center" valign="top"><?=$msg?></td>
  </tr>
  <tr>
    <td width="8%" align="left" valign="top" class="tblborder">Sl. No </td>
    <td width="4%" align="left" valign="top" class="tblborder"><input type="checkbox" name="chk_all" onClick="AllSelect()" /></td>
	 <td width="16%" align="left" valign="top" class="tblborder">Advertise Title</td>
     <td width="11%" align="left" valign="top" class="tblborder">Price($)</td>
     <td width="22%" align="left" valign="top" class="tblborder">Proposal Amount($)</td>
    <td width="13%" align="left" valign="top" class="tblborder">Posted On</td>
    <td width="19%" align="center" valign="top" class="tblborder"><select name="accept" onchange="dostat(this.value)">
		  <option value="">All History</option>
		  <option value="0">Pending</option>
		  <option value="1">Rejected</option>
		  <option value="2">Accepted</option>
		  <option value="3">Confirmed</option>
		  <option value="4">Winner</option>
		  </select> <script language="JavaScript">
                            var CType="<?=$_REQUEST['accept']?>";
                            for (var i=0; i<document.frm.accept.options.length; i++)
                                {
                                    if (document.frm.accept.options[i].value==CType)
                                        {		
                                            document.frm.accept.options[i].selected=true;
                                            break;
                                        }
                                }
                        </script></td>
    <td align="center" valign="top" class="tblborder">Action</td>
  </tr>
  
 			 <?             
			 	$PageSize =30;	
                 $StartRow = 0;
               $sql="SELECT * FROM ".PROPOSAL." WHERE ".$where.$wherel." ORDER BY id  DESC";
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
    <td height="35" align="left" valign="top" class="tblborder1"><?=($i+1+$recordNo)?></td>
    <td align="left" valign="top" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$obj_fetch["id"]?>" onClick="deselect_any()" /></td>
    <td align="left" valign="top" class="tblborder1"><?=ADDTITLE($obj_fetch['add_id'])?></td>
    <td align="left" valign="top" class="tblborder1"><?=ADDPRICE($obj_fetch['add_id'])?></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['proposed_amt']?></td>
    <td align="left" valign="top" class="tblborder1"><?=dateprint($obj_fetch['posted_on'])?></td>
    <td align="center" valign="top" class="tblborder1">
	<? if($obj_fetch['accept']=='1') echo "Rejected"; if($obj_fetch['accept']=='2') echo "Accepted";   if($obj_fetch['accept']=='3') echo "Confirmed"; if($obj_fetch['accept']=='4') echo "<span style='color:#EC0000'>Winner</span>"; if($obj_fetch['accept']=='0') echo "Pending";?>
	
	</td>
    <td width="7%" align="center" valign="top" class="tblborder1"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=del&id=<?=$obj_fetch['id']?>&uid=<?=$_REQUEST['uid']?>&add_id=<?=$_REQUEST['add_id']?>"onclick="return confirm('Are you sure to delete')"><img src="images/delete.png" align="absmiddle" border="0" alt="Click Here to Delete"/></a><br />
	</td>
  </tr>
  <?
  $bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
  }
  ?>
  <tr>
    <td colspan="8" align="right" valign="top">Page No : <? include_once('pageno.php');?></td>
    </tr>
  
  <?
  }
  else{
  ?>
  <tr>
    <td colspan="8" align="center" valign="top" class="error"><?=errormessage("No bidding currently available")?></td>
  </tr>
  <?
  }
  ?>
</table>

</td></tr>
</table>
</form>
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script>
