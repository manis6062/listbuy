 <?php
 	require_once('../config/config.php');
	if(isset($_REQUEST['btnsubmit']))
	{
		$table=NEWSLETTER;
		$set=" name='".escapeQuotes(stripslashes($_REQUEST['name']))."', 
		       subject='".escapeQuotes(stripslashes($_REQUEST['subject']))."', 
			   content='".escapeQuotes(stripslashes($_REQUEST['description']))."'";
		
		if($_REQUEST['editid']=='')
		 {
			Insert_Qry($table,$set);
			$msg=successfulMessage('Newsletter has been added successfully');
			//header('location:home.php?status=newsletterall');
			echo"<script>window.location.href='home.php?page=all-newsletter&PageNo=".$_REQUEST['PageNo']."'</script>";
		 }
		else
		{
			$where=" WHERE newsletter_id='".$_REQUEST['editid']."'";
			Update_Qry($table,$set,$where);
			$msg=successfulMessage('Newsletter has been Updated successfully');
			echo"<script>window.location.href='home.php?page=all-newsletter&PageNo=".$_REQUEST['PageNo']."'</script>";
		 }
	}
	
	if($_REQUEST['editid']!=''){
		$table=NEWSLETTER;
		$where1=" newsletter_id='".$_REQUEST['editid']."'";
		$obj=Select_Qry("*",$table,$where1,"","","","");
	
	}
	
		if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="publish"))
	{			
		$obap=Select_Qry("publish",NEWSLETTER," newsletter_id='".$_REQUEST['editid']."'","","","","");
			$whap=" WHERE newsletter_id='".$_REQUEST['editid']."'";			
			$setap=" publish='1'";
			Update_Qry(NEWSLETTER,$setap,$whap);
	}
	
	  if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="unpublish"))
	{			
		$obap=Select_Qry("publish",NEWSLETTER," newsletter_id='".$_REQUEST['editid']."'","","","","");
			$whap=" WHERE newsletter_id='".$_REQUEST['editid']."'";			
			$setap=" publish='0'";
			Update_Qry(NEWSLETTER,$setap,$whap);
	}
	
	if(isset($_REQUEST['page']) && $_REQUEST['page']=="edit1"){
		$obj=Select_Qry("*",NEWSLETTER," newsletter_id='".$_REQUEST['editid']."'","","","","");
		}
	
?>
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--

    function publish(id)
	{
		  if(confirm('Do you want to publish this Content ?'))
		{ 
		   document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=publish&editid='+id;
		   document.frm.submit();
		}
	}
	
	 function unpublish(id)
	{
		  if(confirm('Do you want to unpublish this Content ?'))
		{ 
		   document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=unpublish&editid='+id;
		   document.frm.submit();
		}
	}
	
	function check()
	{
		if(document.frm.name.value==""){
			alert("Please enter the Name");
			document.frm.name.focus();
			return false;
		}
		else if(document.frm.subject.value==""){
			alert("Please enter the subject");
			document.frm.subject.focus();
			return false;
		}

		else
		{
			return true;
		}
		
	}
	function cancel()
	{
		window.location.href='home.php?page=all-newsletter&PageNo=<?=$_REQUEST['PageNo']?>';
	}
//-->

	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
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
</SCRIPT>
<form method="post" name="frm" action="" onsubmit="return check();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                
			    <tr>
            <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6"><img src="images/7_01.png" width="6" height="64" /></td>
                <td background="images/7_03.png"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="63%" class="texttitle">
					<img src="images/cmspage.png" />
					<span style="padding-left:10px; padding-top:8px; position:absolute; left: 88px;">Newsletter Management</span></td>
                   
                  </tr>
                </table>
				</td>
                <td width="10">
				<img src="images/7_05.png" width="6" height="64" />
				</td>
              </tr>
            </table>
			</td>
              </tr>
			  <tr>
                <td>
				 <fieldset  style="width:98%;"><legend style="color:#000066;"><? echo $_REQUEST['page']=="edit"?"Edit":"Add"?>&nbsp;Newsletter</legend> 
				 
				<table width="100%" border="0" cellspacing="1" cellpadding="1">
                  <tr>
                   <td colspan="6"  valign="top"><center><?=$msg ?></center></td>
                  </tr>
				
				  <tr>
                    <td width="25%" align="left" valign="top" class="sitesettings" style="font-weight:bold;">Name</td>
                    <td colspan="2" style="padding-top:10px;">
					<input name="name" type="text" size="50" value="<?=$obj['name']?>" /> 
					[ Please Enter Newsletter Name]  </td>
                  </tr>
                  <tr>
                    <td valign="top" align="left" class="sitesettings" style="font-weight:bold;">Subject </td>
                    <td colspan="2" style="padding-top:10px;">
					<input name="subject" type="text" size="50" value="<?=$obj['subject']?>" /> 
					[ Please Enter Newsletter Subject.] </td>
                  </tr>
				   
				  
				   
				   
				    
				   <tr>
                    <td rowspan="2" align="left" valign="top" class="sitesettings" style="font-weight:bold;">Description</td>
                    <td width="45%" style="padding-top:10px;"> [ Please Enter Newsletter content ]</td>
                    <td width="30%" rowspan="2" valign="top" style="padding-top:10px;">&nbsp;</td>
			      </tr>
				   <tr>
				     <td style="padding-top:10px;">

<textarea id="elm1" name="description" rows="25" cols="50" style="width:50%"><?=$obj["content"]?></textarea>
</td>
			      </tr>
				   
				     <?
		if($_REQUEST['editid']=='')
		{
	?><input type="hidden" name="physical_page" value="1" /><? } ?>
				   
				    <tr>
					<td>&nbsp;</td>
                    <td colspan="2" style="padding-top:10px; padding-bottom:10px;">
			<input type="submit" class="bttn" name="btnsubmit" value="<? echo $_REQUEST['editid']!=""?"Update":"Add"?>" />
                     	<input type="button" name="btn" class="bttn" value="Cancel" onclick="cancel()" />					  </td>
				  </tr>
                </table>
				
				</fieldset>								</td>
              </tr>
            </table>              
           </form>

