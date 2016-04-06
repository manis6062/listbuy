<?
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
##################### DELETE ######################
if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{			
		$table=$_REQUEST['m']='inbox'?INBOX:OUTBOX;
		$where_clause = "WHERE id='".$_REQUEST['id']."'";
		Delete_Qry($table,$where_clause);
	}

	if($_REQUEST['mode']=='delall')
	{				
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++)
		{
		$table=$_REQUEST['m']='inbox'?INBOX:OUTBOX;
		 Delete_Qry($table,"WHERE id='".$_REQUEST['chk'][$i]."'");
		  }
		}
	######################## SEARCH ######################
	
	if($_REQUEST['where']!=""){
		$where=stripslashes($_REQUEST['where']);
	}
	else{
		$where="";
	}
	if(isset($_REQUEST['btnSearch'])){
	
		$where="";
		if(trim($_REQUEST['subject'])!="")
		{
			$where.=" AND mail_subject LIKE '%".escapeQuotes(stripslashes(trim($_REQUEST['subject'])))."%'";
		}
		
	}
?>
<script language="javascript" type="text/javascript" src="js/CalendarPopup.js"></script>
<script language="javascript">

function jsHitListAction(p1)
	{			
			document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&m=<?=$_REQUEST['m']?>&PageNo=" + eval(p1) ;
			document.frm.submit()
	}
  function domess(val){
	document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&m='+val;
	document.frm.submit();
}
	 
	 ////
	
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
			document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&m=<?=$_REQUEST['m']?>&mode='+status;
		   		document.frm.submit();
				//return true;
		    }
			else
			{
			return false;
			}
	    }
    }
	
function showdetaildiv(id)
{
		if(document.getElementById("detaildiv"+id).style.display=="none")
		{
			document.getElementById("detaildiv"+id).style.display="";
			document.getElementById("dis"+id).style.display="";
		}
		else
		{
			document.getElementById("detaildiv"+id).style.display="none";
			document.getElementById("dis"+id).style.display="none";
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
                    <td width="79%" class="texttitle">
					<img src="images/usermanager.png" width="48" height="48" />
					<span style="padding-left:10px; padding-top:8px; position:absolute;">Messages of <?=USER($_REQUEST['uid'])?>  </span></td>
                   
                  <td width="12%" align="center" valign="top"><a href="home.php?page=user-list"><img src="images/close.png" border="0" align="absmiddle" /></a><br />Close</td>
                   
                    <td width="9%" align="center" valign="top"><input type="submit" class="delallbttn" name="btndelete" value="" onclick="return Confirm('delall')" />
                      <br />
                   
                    Delete</br></td></tr>
                </table></td><td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table></td></tr>
				
<tr><td align="left" valign="top">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="6"><img src="images/7_01.png" width="6" height="64" />
</td>
<td background="images/7_03.png">
<table cellpadding="3" cellspacing="0" width="100%">
<tr>
<td width="24%" align="left" valign="top"><strong>Search By Subject</strong></td>
  <td width="42%" align="left" valign="top"><input type="text" name="subject" value="<?=$_REQUEST['subject']?>" size="45" class="input"/></td><td width="34%" align="left" valign="top"><input type="submit" value="Search" name="btnSearch" class="bttn"/>&nbsp;<input type="button" name="viewall" value="Viewall" onclick="window.location.href='home.php?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&m=<?=$_REQUEST['m']?>'" class="bttn"/></td></tr>
</table></td>
<td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table>

</td></tr>
				
<tr><td align="left" valign="top">

<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td colspan="7" align="center" valign="top"><?=$msg?></td>
  </tr>
  
  <tr>
    <td width="8%" align="left" valign="top" class="tblborder">Sl. No </td>
    <td width="6%" align="left" valign="top" class="tblborder"><input type="checkbox" name="chk_all" onclick="AllSelect()" /></td>
    <td width="14%" align="left" valign="top" class="tblborder"><select name="message" onchange="domess(this.value)">
      <option value="inbox">Inbox</option>
      <option value="outbox">Outbox</option>
    </select>
      <script language="JavaScript">
                            var CType="<?=$_REQUEST['message']?>";
                            for (var i=0; i<document.frm.message.options.length; i++)
                                {
                                    if (document.frm.message.options[i].value==CType)
                                        {		
                                            document.frm.message.options[i].selected=true;
                                            break;
                                        }
                                }
                        </script>		  </td>
    <td width="17%" align="left" valign="top" class="tblborder">Subject</td>
    <td width="23%" align="left" valign="top" class="tblborder">Description </td>
    <td width="16%" align="center" valign="top" class="tblborder">Posted On </td>
    <td width="16%" align="center" valign="top" class="tblborder">Action</td>
  </tr>
  
  <?                      
  if($_REQUEST['m']=='inbox')
  {
  $table=INBOX;
  $tabid=recipent_id;
  }
  else
  {
  $table=OUTBOX;
  $tabid=sender_id;
  }
 
  					$PageSize =30;	
                     $StartRow = 0;
     $sql="SELECT * FROM ".$table." WHERE $tabid='".$_REQUEST['uid']."'  ORDER BY id DESC";
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
    <td align="left" valign="top" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$obj_fetch["id"]?>" onclick="deselect_any()" /></td>
    <td align="left" valign="top" class="tblborder1"><?=$_REQUEST['m']=='inbox'?USER($obj_fetch['sender_id']) : USER($obj_fetch['recipent_id'])?></td>
    <td align="left" valign="top" class="tblborder1"><?=$obj_fetch['mail_subject']?></td>
    <td align="left" valign="top" class="tblborder1"><a href="javascript: void(0)" onclick="showdetaildiv('<?=$obj_fetch['id']?>')"><?=substr($obj_fetch['mail_content'],0,100)?></a></td>
    <td align="center" valign="top" class="tblborder1"><?=dateprint($obj_fetch['date'])?></td>
    <td align="center" valign="top" class="tblborder1">
	<a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&uid=<?=$_REQUEST['uid']?>&m=inbox&mode=del&id=<?=$obj_fetch['id']?>&PageNo=<?=$_REQUEST['PageNo']?>"onclick="return confirm('Are you sure to delete?')"><img src="images/delete.png" border="0" alt="Click Here to Delete"/></a></td>
  </tr>
  
  <tr id="dis<?=$obj_fetch['id']?>" style="display:none;">
	  <td align="left" valign="top" class="tblborder1" style="display:none;">&nbsp;</td>
	  <td align="left" valign="top" class="tblborder1" style="display:none;">&nbsp;</td>
	  <td align="left" valign="top" class="tblborder1" style="display:none;">&nbsp;</td>
	  <td align="left" valign="top" class="tblborder1" style="display:none;">&nbsp;</td>
	    <td align="left" valign="top" colspan="3"><div id="detaildiv<?=$obj_fetch['id']?>" style="width:600px; height:300px; background:#FFFFFF; border:1px solid #999999; position:fixed; top:30%; left:25%; display:none; overflow:auto; padding:10px;">
<table cellpadding="3" cellspacing="0" width="90%">
<tr><td align="right" valign="top"><a href="javascript: showdetaildiv('<?=$obj_fetch['id']?>')">Close Window</a></td></tr>
<tr><td align="left" valign="top">
<table cellpadding="3" cellspacing="0" width="100%">
<tr><td style="text-align:justify;" valign="top"><?=$obj_fetch['mail_content']?></td></tr>
</table>
</td></tr>
</table>
</div></td>
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
    <td colspan="7" align="center" valign="top" class="error"><?=errormessage("No message found !")?></td>
  </tr>
  <?
  }
  ?>
</table>

</td></tr>
</table>
</form>
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script>