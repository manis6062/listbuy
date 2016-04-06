<?
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
###################### ADD & EDIT ####################
	if(isset($_REQUEST['btnsubmit']))
	{
	$where_cheak="Title='".escapeQuotes(stripslashes($_REQUEST['txttitle']))."'";
	if($_REQUEST['mode1']=="edit1")
	{
	$where_cheak.="AND cmsid <> '".$_REQUEST['editid']."'";
	}
	if(Select_Qry("*",STATICCMS,$where_cheak,"","","",""))
	{
	$msg=errorMessage("You can not have same Page or Title twice");
	}
	else{		
		$set="Title='".escapeQuotes(stripslashes($_REQUEST['txttitle']))."', 
			pagename='".escapeQuotes(stripslashes($_REQUEST['txtpagename']))."', 
			description='".escapeQuotes(stripslashes($_REQUEST['description']))."',
			seo_keywords='".escapeQuotes(stripslashes(trim($_REQUEST['meta_key'])))."', 
			seo_content='".escapeQuotes(stripslashes(trim($_REQUEST['meta_cont'])))."'";
		
		 if(isset($_REQUEST['mode1']) && $_REQUEST['mode1']=="edit1")
			{				
			$where = " WHERE cmsid='".$_REQUEST['editid']."'";
			Update_Qry(STATICCMS,$set,$where);
			$msg=successfulMessage("Your Request Updated successfully");	
			}
			else
			{			
			Insert_Qry(STATICCMS,$set);
			$msg=successfulMessage("CMS has been added successfully");	
			}	
		}	
	}
	
######################## STATUS ##############################	
	
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
		$where_clause = "WHERE cmsid='".$_REQUEST['sid']."'";
		$set_value ="status = '".$stat."'";
		Update_Qry(STATICCMS,$set_value,$where_clause);
	}
	/*if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="del"))
	{			
		$delob=Select_Qry("*",STATICCMS,"cmsid='".$_REQUEST['id']."'","","","","");
		Delete_Qry(STATICCMS,"WHERE cmsid='".$_REQUEST['id']."'");
	}*/
	
$obj=Select_Qry("*",STATICCMS," cmsid='".escapeQuotes(stripslashes($_REQUEST['editid']))."'","","","","");	
?>
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script language="javascript">
function del(id)
	{
		  if(confirm('Do you want to delete this Content ?'))
		{ 
		   document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=del&id='+id;
		   document.frm.submit();
		}
	}
function statusCheck(id,stat)
	{
		document.frm.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>&mode=stat&sid=" + id + "&id=<?php echo($_REQUEST['id']);?>&stat=" + stat;
		document.frm.submit();
	}

function jsHitListAction(p1)
	{			
	document.frm.action = "<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&PageNo=" + eval(p1) ;
		document.frm.submit()
	}

function check()
	{
		if(document.frm.txttitle.value=="" || document.frm.txttitle.value=="Title"){
			alert("Please enter Title");
			document.frm.txttitle.focus();
			return false;
		}
		else if(document.frm.txtpagename.value=="" || document.frm.txtpagename.value=="Page Name"){
			alert("Please enter page name");
			document.frm.txtpagename.focus();
			return false;
		}
		else if(document.frm.meta_key.value=="" || document.frm.meta_key.value=="Meta Keyword"){
			alert("Please enter Meta keyword");
			document.frm.meta_key.focus();
			return false;
		}
		else if(document.frm.meta_cont.value=="" || document.frm.meta_cont.value=="Meta Content"){
			alert("Please enter Meta content");
			document.frm.meta_cont.focus();
			return false;
		}
		
		else
		{
			return true;
		}
		
	}
	
//-->

tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
/////////


</script>
<form name="frm" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
             <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6"><img src="images/7_01.png" width="6" height="64" /></td>
                <td background="images/7_03.png">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="84%" class="texttitle">
					<img src="images/sectionmanager.png" width="48" height="48" />
					
		
					<span style="padding-left:10px; padding-top:8px; position:absolute;">Static CMS</span></td>
					
                    <td width="16%" align="center">
					<a href="home.php?page=static-cmslist&mode1=Add">
					<img src="images/new.png" border="0" width="31" height="30" /><br />
					</a>
                    Create CMS</td>
                    
                  </tr>
                </table>
				</td>
                <td width="10">
				<img src="images/7_05.png" width="6" height="64" />
				</td>
              </tr>
            </table></td></tr>
          <?
          if($_REQUEST['mode1'])
		  {
		  ?>  
		<tr>
          <td align="center" valign="top">
          <fieldset style="width:98%;">
          <legend style="color:#000066;"><?=$_REQUEST['mode1']=='edit1'?'Edit':'Create'?> CMS Page</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center" valign="top" style="font-weight:bold;" colspan="2"><?=$msg?></td>
    </tr>
 
  <tr>
    <td width="56%" align="left" valign="top"><textarea name="description" id="description" rows="30" cols="50"><?=$obj['description']?></textarea></td>
	<td width="44%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="#F7F7F7" style="border:1px solid #BFBFBF;">
      <tr>
    <td align="left" valign="top">
	<input type="text"  name="txttitle" size="20" value="<?=$obj['Title']==""?"Title":$obj['Title']?>" onFocus="if(this.value==this.defaultValue ) this.value='';" onBlur="if( this.value=='' ) this.value=this.defaultValue;"/></td>	
	<td align="left" valign="top"><input type="text" name="txtpagename"  size="20" value="<?=$obj['pagename']==""?"Page Name":$obj['pagename']?>"  onFocus="if(this.value==this.defaultValue ) this.value='';" onBlur="if( this.value=='' ) this.value=this.defaultValue;"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" colspan="2"><input type="text" name="meta_key"  size="49" value="<?=$obj['seo_keywords']==""?"Meta Keyword":$obj['seo_keywords']?>" onFocus="if(this.value==this.defaultValue ) this.value='';" onBlur="if( this.value=='' ) this.value=this.defaultValue;"/></td>
	
  </tr>
  <tr>
    <td align="left" valign="top" colspan="2"><input type="text" name="meta_cont"  size="49" value="<?=$obj['seo_content']==""?"Meta Content":$obj['seo_content']?>" onFocus="if(this.value==this.defaultValue ) this.value='';" onBlur="if( this.value=='' ) this.value=this.defaultValue;"/></td>
	
  </tr>
    </table></td> 
  </tr>
  <tr>
    <td align="center" valign="top"><input type="submit" class="bttn" name="btnsubmit" value="<?=$_REQUEST['mode1']=="edit1"?"Update":"Save"?>" onclick="return check()"/>&nbsp;<input type="button" name="button" value="Cancel" class="bttn" onclick="window.location.href='home.php?page=static-cmslist'"/></td>
	<td></td>
  </tr>
</table>
</fieldset>
</td></tr>
   <?
   }
 if($_REQUEST['mode1']=="")
		 {
		 ?> 
		   <tr>
            <td align="left" valign="top"><table width="100%" align="left" border="0" cellspacing="0" cellpadding="5">
                 <tr>
                    <td width="5%" align="center" class="tblborder">Sl No </td>
                    <td width="27%" align="left" class="tblborder" style="padding-left:10px;">  CMS Title</td>
                    <td width="29%" align="left" class="tblborder" style="padding-left:10px;">Page Name </td>
                    <td align="center" class="tblborder">Page Type </td>
                    <td align="center" class="tblborder">Publish</td>
                    <td align="center" class="tblborder">Actions</td>
              </tr>
				 <?
				 $sql="SELECT * FROM ".STATICCMS." WHERE 1  ORDER BY cmsid";
				$PageSize =30;	
				$StartRow = 0;
				//Set the page no
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
			$obj_fetch=mysql_fetch_array($rs);
				 
				 ?>
                  <tr class="onmouse">
                    <td class="tblborder1" align="center" valign="top"><?=$i+1?></td>
                    <td align="left" valign="top" class="tblborder1">
					<?=$obj_fetch['Title']?>				</td>
                   
				    <td align="left" class="tblborder1" valign="top">
					<?=$obj_fetch['pagename']?></td>
				    <td width="14%" align="center" class="tblborder1" valign="top"><?=$obj_fetch["email"]=='1'?"<span style='color:#FF0000'>Mail Content</span>":"Page Content"?></td>
				    <td width="11%" align="center" class="tblborder1" valign="top">
					<a href="javascript: statusCheck(<?php echo($obj_fetch['cmsid']);?>,<?php echo($obj_fetch['status']);?>)" class="tooltipClass" onmouseover="return escape('<?=$obj_fetch['status']=='0'?'Unpublished' : 'Published'?>')">
					<?php echo(($obj_fetch['status'] == '0') ? '<img src="images/unpublish.png" border="0" alt="Unpublished"/>' : '<img src="images/apply.png" border="0" alt="Published"/>')?></a>				    </td>
                    <td width="14%" align="center" class="tblborder1">
					<a href="home.php?page=static-cmslist&mode1=edit1&editid=<?=$obj_fetch['cmsid'];?>">
				      <img src="images/edit.png" border="0" alt="Click Here to Edit"/></a>&nbsp;				</td>
                  </tr>
				  <?
				  $bgColor == "#ffffff" ? $bgColor ="#fbfbfb" : $bgColor = "#ffffff";
				  }
				  ?>
				  <tr><td align="right" valign="top" colspan="6"><? include_once('pageno.php')?></td></tr>
				  <?
				  }else{
				  ?>
	<tr><td align="center" valign="top" colspan="6"><?=errorMessage('No Content Found ')?></td></tr>
				  <?
				  }
				  ?>
				 </table></td></tr>	  
<?
}
?>
</table>    </form>    
           
<script language="JavaScript" type="text/javascript" src="js/wz_tooltip.js"></script> 
