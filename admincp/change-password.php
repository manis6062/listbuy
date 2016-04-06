   <?php
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
if(isset($_REQUEST['btnsubmit']))
	{
		$fields = "*";
		$table = ADMIN;
		$where_clause = "admin_password ='".escapeQuotes(stripslashes(trim($_REQUEST['old_password'])))."'";
		
		if(Select_Qry($fields,$table,$where_clause,"","","", ""))
		{		  
			$table = ADMIN;
			$set_value = "admin_password = '".escapeQuotes(stripslashes(trim($_REQUEST['new_password'])))."'";
			Update_Qry($table,$set_value,"");
			$msg=successfulMessage('<b>Your Password has been changed Successfully</b>');
			
	    }
		else
		{
			$msg=errorMessage('<b>Invalid Old Password !</b>');
		}
	}
?>  
<SCRIPT LANGUAGE="JavaScript">
<!--
	function check()
	{
		if(document.frm.old_password.value == "")
		{
			alert("Please Enter Old Password.");
			document.frm.old_password.focus();
			return false;
		}
		else if(document.frm.new_password.value == "")
		{
			alert("Please Enter New Password.");
			document.frm.new_password.focus();
			return false;
		}
		else if(document.frm.cnew_password.value == "")
		{
			alert("Please Enter Confirm New Password.");
			document.frm.cnew_password.focus();
			return false;
		}
		else if(document.frm.cnew_password.value != document.frm.new_password.value)
		{
			alert("Password Mismatch.");
			document.frm.cnew_password.focus();
			return false;
		}
		else
		{
			return true;
		}
			}
//-->
</SCRIPT>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
            <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6"><img src="images/7_01.png" width="6" height="64" /></td>
                <td background="images/7_03.png"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="63%" class="texttitle">
					<img src="images/changepwd.png" width="48" height="48" border="0" />
					<span style="padding-left:10px; padding-top:8px; position:absolute; left: 88px;">Change Password</span>
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
            <td><table width="100%" border="0" cellspacing="5" cellpadding="3">
              <tr>
                <td colspan="2" width="60%"><fieldset  style="width:98%;">
                  <legend>Change Password</legend>
               <form name="frm" method="post" action="">
			      <table width="100%" border="0" cellspacing="1" cellpadding="1">
                  
				    <tr>
                      <td colspan="6"  valign="top"><center><?=$msg ?></center></td>
                    </tr>
				  
				  
				    <tr>
                      <td width="25%" class="sitesettings">Old Password </td>
                      <td width="51%" style="padding-top:10px;">
					  <input name="old_password" type="password" size="42" /></td>
                    </tr>
                    <tr>
                      <td class="sitesettings">New Password </td>
                      <td style="padding-top:10px;"><input name="new_password" type="password" size="42" /></td>
                    </tr>
                    <tr>
                      <td class="sitesettings">Confirm New Password </td>
                      <td style="padding-top:10px;"><input name="cnew_password" type="password" size="42" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td style="padding-top:10px; padding-bottom:10px;">
					<input type="submit" class="bttn" name="btnsubmit" value="Update" onclick="return check();" />
                     	<input type="reset" class="bttn" onclick=location.href="home.php" value="Cancel"/>						</td>
                    </tr>
                  </table>
			    </form>
                </fieldset></td>
                
              </tr>
              <tr>
                <td></td>
              </tr>
            </table>
          </td>
          </tr>
        
        </table>
	