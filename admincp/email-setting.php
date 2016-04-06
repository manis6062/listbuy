<?
	require_once('../config/config.php');
	validation_check($_SESSION['logged'], 'index.php');
		if(isset($_REQUEST['btnsubmit']) && $_REQUEST['btnsubmit']=="Update")
			{
				$table= CONFIG;
				$set_value="admin_email='".escapeQuotes(stripslashes(trim($_REQUEST['admin_email'])))."',paypal_email='".escapeQuotes(stripslashes(trim($_REQUEST['paypal_email'])))."'";
				$where_clause="where id ='1'";
		if(Update_Qry($table,$set_value,$where_clause))
					{
						$msg=successfulMessage('<b>Email Updated Successfully.</b>');
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
	<script language="javascript" src="js/validate_email.js"></script>
<script language="javascript">
function validated()
	{
 		 if(document.frm1.admin_email.value == '')
			{
			alert("Please Enter admin Email-ID.");
			document.frm1.admin_email.focus();
			return false;
		}
		else if(!emailCheck(document.frm1.admin_email))
		{
			document.frm1.admin_email.focus();
			return false;
		}
		 if(document.frm1.paypal_email.value == '')
			{
			alert("Please Enter admin Email-ID.");
			document.frm1.paypal_email.focus();
			return false;
		}
		else if(!emailCheck(document.frm1.paypal_email))
		{
			document.frm1.paypal_email.focus();
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
					<img src="images/email.png" width="48" height="48" border="0" />
					<span style="padding-left:10px; padding-top:8px; position:absolute; left: 88px;">Email Management</span>
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
				 <fieldset  style="width:97%;"><legend>Email Settings</legend> 
				<form method="post" name="frm1" action="" onsubmit="return validated();">
				
				<table width="100%" border="0" cellspacing="1" cellpadding="5">
                
				 <tr>
                    <td colspan="6"  valign="top"><center><?=$msg?></center></td>
                  </tr>
				  <tr>
                    <td width="25%" class="sitesettings" align="left" valign="top">Admin Email </td>
                    <td width="62%"  align="left" valign="top">
					<input type="text"  name="admin_email" size="45" value="<?=$obj['admin_email']?>" /></td>
                  </tr>
                  <tr>
                    <td width="25%" class="sitesettings" align="left" valign="top">Paypal Email </td>
                    <td width="62%" align="left" valign="top">
					<input type="text"  name="paypal_email" size="45" value="<?=$obj['paypal_email']?>" /></td>
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
                <td>				
				</td>
              </tr>
            
            </table>              
           

