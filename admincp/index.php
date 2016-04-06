<?
	require_once("../config/config.php");
	if(isset($_REQUEST['btn_submit']))
	{
		$where_clause = "admin_name='".mysql_real_escape_string($_REQUEST['username'])."' AND admin_password ='".mysql_real_escape_string($_REQUEST['pwd'])."'";
		$check = Select_Qry("*",ADMIN,$where_clause,"","","", "");
		
		    if($check){
			$_SESSION['logged']=true;
		$_SESSION['username']="Administrator";
		echo("<script language=javascript>window.location='homepage.php';</script>");
		}
		else
		{
			$msg=errorMessage('Invalid Username or Password');
		}
	}
	?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=TITLE?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<? include_once('common-js.php');?>
</head>

<body topmargin="0" leftmargin="0">
<table width="100%" border="0" bordercolor="#000066" cellpadding="0" cellspacing="0">
  <tr>
    <td><? include_once('header.php');?></td>
  </tr>
  
  <tr>
    <td class="bodyarea">

	<table width="400" style="margin-bottom:20px;" align="center" cellspacing="10" cellpadding="0" border="0">
      <tr>
        <td class="texttitle" style="padding-top:20px;" align="center">Administrator Login </td>
      </tr>
      <tr>
        <td width="418">
		 <form name="frm" method="post" action=""><fieldset >
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
        
		 <? if(isset($msg) && $msg!="")
                            {
                             ?>
		  <tr>
            <td colspan="3">
			<?=$msg?>			</td>
            </tr>
			<?
			}
			?>
			
          <tr>
            <td width="19%" valign="middle">User Name </td>
            <td width="40%" valign="top">
              <input type="text" name="username"></td>
            <td width="41%" rowspan="3" valign="top"><img src="images/key-lock2.jpeg" border="0" align="absmiddle" height="114" width="120"/></td>
          </tr>
          <tr>
            <td valign="middle">Password</td>
            <td valign="top">
             <input type="password" name="pwd"></td>
            </tr>
          <tr>
            <td valign="top">			</td>
            <td valign="top">
              <input type="submit" name="btn_submit" class="loginbttn" value="Login"/>           </td>
            </tr>
        </table>
		 </fieldset>
		</form>
			</td>
      </tr>
      <tr>
        <td><!--<img src="images/lock.png" width="128" height="128" />--></td>
      </tr>
    </table>
    
    </td>
  </tr>
  <tr><td><? include_once('footer.php');?></td></tr>
</table>
</body>
</html>