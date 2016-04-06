	<?
	require_once('../config/config.php');
	validation_check($_SESSION['logged'], 'index.php');
		if(isset($_REQUEST['btnsubmit']) && $_REQUEST['btnsubmit']=="Update")
			{
				$table= CONFIG;
				$set_value="website_address ='".escapeQuotes(stripslashes($_REQUEST['website_address']))."',
							admin_header_title='".escapeQuotes(stripslashes($_REQUEST['admin_header_title']))."',
							frontend_header_title='".escapeQuotes(stripslashes($_REQUEST['frontend_header_title']))."',
							meta_keyword='".escapeQuotes(stripslashes($_REQUEST['meta_keyword']))."',
							meta_content='".escapeQuotes(stripslashes($_REQUEST['meta_content']))."',
							paypal_url='".$_REQUEST['paypal_url']."'";
				$where_clause="where id ='1'";
		if(Update_Qry($table,$set_value,$where_clause))
					{
						$msg=successfulMessage('<b>Site Details Updated Successfully.</b>');
					}
					else
					{
						$msg=errorMessage('<b>Error Occurred</b>');
					}
			}	
		
	 $fields ="*";
	 $table1 = CONFIG;
	 $where_clause1 = "id='1'";
	 $obj = Select_Qry($fields,$table1,$where_clause1,"","","","");
							
	?>

<script language="javascript">
function validated()
	{
	if(document.frm1.website_address.value=='')
		{
			alert("Please Enter Website Address");
			document.frm1.website_address.focus();
			return false;
		}
		else if(document.frm1.admin_header_title.value=='')
		{
			alert("Please Enter Header Title");
			document.frm1.admin_header_title.focus();
			return false;
		}
		else if(document.frm1.frontend_header_title.value== '')
		{
			alert("Please Enter Frontend Header Title");
			document.frm1.frontend_header_title.focus();
			return false;
		}
		else if(document.frm1.meta_keyword.value=='')
		{
			alert("Please Enter Meta Keyword");
			document.frm1.meta_keyword.focus();
			return false;
		}
		else if(document.frm1.meta_content.value=='')
		{
			alert("Please Enter Meta Content");
			document.frm1.meta_content.focus();
			return false;
		}
		else if(document.frm1.paypal_url.value== '')
		{
			alert("Please Enter Only sandbox.paypal OR paypal");
			document.frm1.paypal_url.focus();
			return false;
		}
		
		else
		{
		return true;
		}
		}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
            <td colspan="2">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6"><img src="images/7_01.png" width="6" height="64" /></td>
                <td background="images/7_03.png"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="63%" class="texttitle">
					<img src="images/globalconfiguration.png" width="48" height="48" border="0" />
					<span style="padding-left:10px; padding-top:8px; position:absolute; left: 88px;">Website Management</span>
					</td>
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
                <td colspan="2" width="55%">
				 <fieldset  style="width:97%;"><legend>Website Configuration Settings</legend> 
				<form method="post" name="frm1" action="" onSubmit="return validated();">
				<table width="100%" border="0" cellspacing="1" cellpadding="5">
                
				  <tr>
			  <td colspan="6" valign="top"><center>	<?=$msg ?></center></td>
			  </tr>
				  <tr>
                    <td width="25%" class="sitesettings" align="left" valign="top">Website Address </td>
                    <td width="62%" valign="top" align="left">
					<input type="text"  name="website_address" size="45" 
					value="<?=$obj['website_address']?>" /></td>
                  </tr>
                  <tr>
                    <td class="sitesettings" align="left" valign="top">Admin Header Title </td>
                    <td align="left" valign="top">
					<input type="text" name="admin_header_title"  size="45" value="<?=$obj['admin_header_title'];?>" /></td>
                  </tr>
                  <tr>
                    <td class="sitesettings" align="left" valign="top">Frontend Header Title </td>
                    <td align="left" valign="top">
					<input  type="text" name="frontend_header_title" size="45" value="<?=$obj['frontend_header_title'];?>" /></td>
                  </tr>
				  
				    <tr>
                    <td class="sitesettings" align="left" valign="top">Meta Keyword </td>
                    <td  align="left" valign="top"><textarea name="meta_keyword" rows="10" cols="40"><?=$obj['meta_keyword'];?></textarea></td>
				    </tr>
				    <tr>
                    <td class="sitesettings" align="left" valign="top">Meta Content </td>
                    <td align="left" valign="top"><textarea name="meta_content" rows="10" cols="40"><?=$obj['meta_content'];?></textarea></td>
				    </tr>
				    <tr>
				      <td class="sitesettings" align="left" valign="top">Paypal URL</td>
				      <td align="left" valign="top">
				        <input type="text"  name="paypal_url" size="45" value="<?=$obj['paypal_url'];?>" />
				     </td>
			      </tr>
				    <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">
					<input type="submit" class="bttn" name="btnsubmit" value="Update" />
                     	<input type="button" class="bttn" onclick=location.href="home.php"  value="Cancel" />					  </td>
				  </tr>
                </table>
				</form>
				</fieldset>
				</td>
                
              </tr>
              <tr>
                <td></td>
              </tr>
            
            </table>              
           

