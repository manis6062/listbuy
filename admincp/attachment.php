<?
require_once('../config/config.php');

if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{	
		$obpp=Select_Qry("*",ATTACHMENTS,"id='".$_REQUEST['cid']."'","","","","");
		@unlink("../attachment/large_".$obpp['attach_file']);
		@unlink("../attachment/thumb_".$obpp['attach_file']);
		$where_clause = "WHERE id='".$_REQUEST['cid']."'";
		Delete_Qry(ATTACHMENTS,$where_clause);
	}

if($_REQUEST['mode'] == 'delete')
	{		
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
		$table = ATTACHMENTS;
		$objj=Select_Qry("*",ATTACHMENTS,"id='".$_REQUEST['chk'][$i]."'","","","","");
		@unlink("../attachment/large_".$objj['attach_file']);
		@unlink("../attachment/thumb_".$objj['attach_file']);
	    $where_clause = "WHERE id ='".$_REQUEST['chk'][$i]."'";
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
		$table = ATTACHMENTS;
		$where_clause = "WHERE id='".$_REQUEST['sid']."'";
		$set_value ="status = '".$stat."'";
		Update_Qry($table,$set_value,$where_clause);
	}
	
	if($_REQUEST['mode'] == 'approve'){	
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
			 $whap=" WHERE id='".$_REQUEST['chk'][$i]."'";			
			 $setap=" status='1'";
			Update_Qry(ATTACHMENTS,$setap,$whap);
			
		}
	}
	if($_REQUEST['mode'] == 'disapprove')
		{
		for($i=0;$i<sizeof($_REQUEST['chk']);$i++){
			$whap=" WHERE id='".$_REQUEST['chk'][$i]."'";			
			$setap=" status='0'";
			Update_Qry(ATTACHMENTS,$setap,$whap);
		}
	}
	################### INSERT and UPDATE #########################
	if(isset($_REQUEST['btnsubmit']))
	{
	  
	$record=Select_Qry("*",ATTACHMENTS,"id='".$_REQUEST['editid']."'","","","","");
		
	$set="file_describe='".escapeQuotes(stripslashes(trim($_REQUEST['file_describe'])))."',
		add_id='".$_REQUEST['add_id']."'";
			
			if($_FILES['attach_file']['name']!="")
			  {
				$wdir="../attachment/";
				@unlink("../attachment/large_".$record['attach_file']);
			    @unlink("../attachment/thumb_".$record['attach_file']);
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
				$where_clause="WHERE id='".$_REQUEST['editid']."'";
				Update_Qry(ATTACHMENTS,$set,$where_clause);
				$msg=successfulMessage("You are updated successfully");
			}
			
			else{
				Insert_Qry(ATTACHMENTS,$set);
				$msg=successfulMessage("You are added successfully");
			    }
	     
		}

######################################
$where_clause="id='".$_REQUEST['editid']."'";
$arr=Select_Qry("*",ATTACHMENTS,$where_clause,"","","","");
?>
<script language="javascript">
function check()
{
	<?
	if($_REQUEST['editid']=="")
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
 function statusCheck(id,stat)
	{
		window.location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&add_id=<?=$_REQUEST['add_id']?>&mode=stat&sid='+id+'&stat='+stat;
		//document.frm.submit();
	}
	function jsHitListAction(p1)
	{			
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&add_id=<?=$_REQUEST['add_id']?>&PageNo="+eval(p1) ;
		document.frm.submit()
	}
	
function del(cid)
	{
	 if(confirm('Do you want to delete really?'))
	  {
      window.location.href='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&add_id=<?=$_REQUEST['add_id']?>&mode=del&cid='+cid;
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
	       alert("Select any attachment");
	       return false;
	    }
	   else
	    {
	       var con = confirm("Are You Sure?")
	       if(con)
		    {
			document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&add_id=<?=$_REQUEST['add_id']?>&mode='+status;
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
<form name="frm" method="post" action="" enctype="multipart/form-data">
  
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
							<span style="padding-left:10px; padding-top:8px; position:absolute;">Attachment </span></td>
							<td width="7%" align="center" valign="top">
							<a href="home.php?page=auction-list"><img src="images/close.png" border="0" align="absmiddle" /></a><br />
						    Close</td>
							<td width="13%" align="center" valign="top">
					<a href="home.php?page=<?=$_REQUEST['page']?>&mode1=add&add_id=<?=$_REQUEST['add_id']?>">
					<img src="images/new.png" border="0" width="31" height="30" /><br />
					</a>
                    Attachment(s)<br /></td>
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
				<?=$_REQUEST['mode1']=='edit'?"Edit":"Add"?> Attachment(s)</legend>
					  <table width="100%" border="0">
					  <tr>
				  <td align="center" colspan="3"><?=$msg?></td>
				  </tr>
  
   <? if($_REQUEST['mode1']!=''){ ?>
   <tr>
     <td width="29%" align="right" valign="top"><strong>Attachment Image</strong></td>
     <td width="6%" align="center" valign="top"><strong>:</strong></td>
     <td width="65%" align="left" valign="top"><input type="file" name="attach_file" class="input" />
	 <?
	 if($arr['attach_file']!="")
	 {
	 ?>
	 <img src="../attachment/thumb_<?=$arr['attach_file']?>" border="0" align="absmiddle" height="60" width="70" />
	 <?
	 }
	 ?></td>
   </tr>
   <tr>
     <td align="right"><strong>Description</strong></td>
     <td align="center"><strong>:</strong></td>
     <td align="left"><input type="text" name="file_describe" value="<?=$arr['file_describe']?>" size="30" class="input" /></td>
   </tr>
   <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left"><input name="btnsubmit" type="submit" value="<?=$_REQUEST['mode1']=='edit'?"Update":"Insert"?>" onclick="return check()" class="bttn"/><input name="cancel" type="button" class="bttn" onclick="window.location.href='home.php?page=<?=$_REQUEST['page']?>&add_id=<?=$_REQUEST['add_id']?>'" value="Cancel"/></td>
  </tr>
   <? }?>
                </table>
			    </fieldset></td></tr><? }?>
				
					  <tr>
			  <td height="208" align="left" valign="top">	  
					  <table width="100%" border="0">
						<tr>
						<td height="189" valign="top" align="left" colspan="2">
								<table width="100%" cellpadding="5" cellspacing="0">
							   <tr>
							     <td width="6%" align="left" class="tblborder">Sl.no</td>
							   <td width="4%" height="30" align="left" class="tblborder"><input type="checkbox" name="chk_all" onclick="AllSelect()" /></td>
								
								 <td height="30" align="left" valign="top" class="tblborder" style="padding-left:10px;">Attachment Image</td>
								 
								
								 <td width="25%" align="left" class="tblborder" style="padding-left:10px;">Description</td>
								 <td width="18%" align="left" class="tblborder" style="padding-left:10px;">Attached On</td>
								 <td width="8%" align="left" class="tblborder" style="padding-left:10px;">Status</td>
								 <td height="30" colspan="2" align="center" class="tblborder">Action</td>
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
						<tr valign="top" bgcolor="<?php echo $bgColor;?>" class="onmouse">
						  <td align="left" class="tblborder1"><?=($i+1+$recordNo)?></td>
						  <td align="left" class="tblborder1"><input type="checkbox" name="chk[]" value="<?=$arrsc["id"]?>" onclick="deselect_any()" /></td>
						  
						  <td width="23%" align="left" valign="top" class="tblborder1" style="padding-left:10px;"><img src="../attachment/thumb_<?=$arrsc['attach_file']?>"  border="0" align="absmiddle" height="70" width="80"/></td>
						  
						  <td align="left" class="tblborder1" style="padding-left:10px;">
						  <?=substr(strip_tags($arrsc['file_describe']),0,150)?></td>
<td align="left" class="tblborder1" style="padding-left:10px;"><?=dateprint($arrsc['posted_on'])?></td>
						  <td align="center" class="tblborder1" style="padding-left:10px;"><a href="Javascript:void(0)" onclick="javascript:statusCheck('<?=$arrsc['id']?>','<?=$arrsc['status']?>')" class="tooltipClass" onmouseover="return escape('<?=$arrsc['status']=='0'?'Unpublished' : 'Published'?>')"><? echo(($arrsc['status'] == '0') ? '<img src="images/unpublish.png" border="0" alt="Unpublished"/>' : '<img src="images/apply.png" border="0" alt="Published"/>')?></a></td>
						  <td width="4%" align="center" class="tblborder1"><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode1=edit&editid=<?=$arrsc['id']?>&add_id=<?=$_REQUEST['add_id']?>&PageNo=<?=$_REQUEST['PageNo']?>"><img src="images/edit.png" align="absmiddle" border="0"  alt="Click Here to Edit"/></a></td>
						<td width="12%" align="center" class="tblborder1"><a href="javascript:del(<?=$arrsc['id']?>)"><img src="images/delete.png" align="absmiddle" border="0" alt="Click Here to Delete"/></a></td>
						</tr>
				<?php 
		$bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
			} 
			?>
				  <tr><td colspan="10" align="right">Page No<? include_once('pageno.php');?></tr>
				 
				   <?
 					 }
				  else{
  					?>
  <tr>
    <td colspan="10" align="center" valign="top" class="error"><?=errorMessage("No Attachment Found")?></td>
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