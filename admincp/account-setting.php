<?
	require_once('../config/config.php');
	validation_check($_SESSION['logged'], 'index.php');
		if(isset($_REQUEST['btnsubmit']) && $_REQUEST['btnsubmit']=="Update")
			{
				$table= CONFIG;
				$set_value="listing_valid_days='".escapeQuotes(stripslashes(trim($_REQUEST['listing_valid_days'])))."',
		fee_posting='".escapeQuotes(stripslashes(trim($_REQUEST['fee_posting'])))."',
		fee_bold='".escapeQuotes(stripslashes(trim($_REQUEST['fee_bold'])))."',
		fee_highlighted='".escapeQuotes(stripslashes(trim($_REQUEST['fee_highlighted'])))."',
		fee_featured='".escapeQuotes(stripslashes(trim($_REQUEST['fee_featured'])))."',
		fee_rowborder='".escapeQuotes(stripslashes(trim($_REQUEST['fee_rowborder'])))."'";
				$where_clause="where id ='1'";
		if(Update_Qry($table,$set_value,$where_clause))
					{
						$msg=successfulMessage('<b>Account details Updated Successfully.</b>');
					}
					else
					{
						$msg=errorMessage('<b>Error Occurred</b>');
					}
	 
			}
					
	 $table1 = CONFIG;
	 $where_clause1 = "id='1'";
	 $obj = Select_Qry('*',$table1,$where_clause1,"","","","");
					
	?>
	
<script language="javascript">

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
            <td colspan="2">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6"><img src="images/7_01.png" width="6" height="64" /></td>
                <td background="images/7_03.png"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="63%" class="texttitle">
					<img src="images/email.png" width="48" height="48" border="0" />
					<span style="padding-left:10px; padding-top:8px; position:absolute; left: 88px;">Account Management</span>
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
				 <fieldset  style="width:97%;"><legend>Account Settings</legend> 
				<form method="post" name="frm1" action="">
				
				<table width="100%" border="0" cellspacing="1" cellpadding="5">
                
				 <tr>
                    <td colspan="6"  valign="top"><center><?=$msg?></center></td>
                  </tr>
				  <tr>
                    <td width="50%" class="sitesettings" align="left" valign="top">Listing Valid days<br />
                    <span class="small_font">Valid days for user site listing</span></td>
                    <td width="50%"  align="left" valign="top">
					<input name="listing_valid_days" type="text" size="25" value="<?=$obj['listing_valid_days']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/> Days</td>
                  </tr>
                  <tr>
                    <td width="50%" class="sitesettings" align="left" valign="top">Fee for Posting <br />
				  <span class="small_font">User site listing fee for posting</span></td>
                    <td width="50%" align="left" valign="top">
					<input name="fee_posting" type="text" size="25" value="<?=$obj['fee_posting']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/> $</td>
                  </tr>
				    <tr>
				      <td align="left" valign="top"><strong>Listing Upgrades</strong></td>
				      <td align="left" valign="top">&nbsp;</td>
			      </tr>
				    <tr>
				      <td align="left" valign="top" class="sitesettings">Listing Featured on the Front Page<br/>
			        <span class="small_font"> User site listing will be featured on the front page for a limited period</span></td>
				      <td align="left" valign="top"><input name="fee_featured" type="text" size="25" value="<?=$obj['fee_featured']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/> $</td>
			      </tr>
				    <tr>
				      <td align="left" valign="top" class="sitesettings">Listing Title in Bold<br/>
			         <span class="small_font">The title of user site listing on the front page or in search results will appear in bold to make it stand out and get you more traffic!</span></td>
				      <td align="left" valign="top"><input name="fee_bold" type="text" size="25" value="<?=$obj['fee_bold']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/> $</td>
			      </tr>
				    <tr>
				      <td align="left" valign="top" class="sitesettings">Listing Row Highlighted<br/>
		           <span class="small_font"> User site listing will appear highlighted in color on the listings page.</span></td>
				      <td align="left" valign="top"><input name="fee_highlighted" type="text" size="25" value="<?=$obj['fee_highlighted']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/> $</td>
			      </tr>
				    <tr>
				      <td align="left" valign="top" class="sitesettings">Listing Row Border <br/>
		            <span class="small_font">User site listing will appear border in color on the listings page.</span></td>
				      <td align="left" valign="top"><input name="fee_rowborder" type="text" size="25" value="<?=$obj['fee_rowborder']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/> $</td>
			      </tr>
				    <tr>
                    <td align="left" valign="top">&nbsp;</td>
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
                <td>				
				</td>
              </tr>
            
            </table>              
           

