<?
validation_check($_SESSION['logged'], 'index.php');
$record=Select_Qry("*",USER,"user_id='".$_REQUEST['id']."'","","","","");
if(isset($_REQUEST['btnSubmit']))
{
	$wherechk=" email='".escapeQuotes(stripslashes(trim($_REQUEST['email'])))."'";
	if($_REQUEST['id']!=""){
		$wherechk.=" AND user_id<>'".$_REQUEST['id']."'";
	}
	if(Select_Qry("*",USER,$wherechk,"","","","")){
		$msg=errorMessage("This Email already exists! Please try another...");
	}
	else{
	$table=USER;
	$set="username='".escapeQuotes(stripslashes(trim($_REQUEST['username'])))."',
		first_name ='".escapeQuotes(stripslashes(trim($_REQUEST['first_name'])))."',
		last_name  ='".escapeQuotes(stripslashes(trim($_REQUEST['last_name'])))."',
		 email='".escapeQuotes(stripslashes(trim($_REQUEST['email'])))."',
		password='".escapeQuotes(stripslashes(trim($_REQUEST['password'])))."',
		st_add='".escapeQuotes(stripslashes(trim($_REQUEST['st_add'])))."',
		  city='".escapeQuotes(stripslashes(trim($_REQUEST['city'])))."',
		  state='".$_REQUEST['state']."',
		  country='".$_REQUEST['country']."',
		  zip='".escapeQuotes(stripslashes(trim($_REQUEST['zip'])))."',
		  phone='".escapeQuotes(stripslashes(trim($_REQUEST['phone'])))."'";
		  
		  if($_FILES['avatar']['name']!="")
			  {
				$wdir="../avatar/";
				@unlink("../avatar/small_".$record['avatar']);
			    @unlink("../avatar/thumb_".$record['avatar']);
				$file_type = $_FILES['avatar']['type'];
				$file_name = $_FILES['avatar']['name'];
				$file_size = $_FILES['avatar']['size'];
				$file_tmp = $_FILES['avatar']['tmp_name'];
				$ext=getext($_FILES['avatar']['name']);
				$imagname=rand()."_".date("m_d_Y").$ext;
image_resize($wdir."small_",70,$file_type,$file_name,$file_size,$file_tmp,$imagname);
image_resize($wdir."thumb_",100,$file_type,$file_name,$file_size,$file_tmp,$imagname);
				$set.=",avatar ='".$imagname."'";
				}
		  
		
		if($_REQUEST['id']=="")
		{
	 		$uid=Insert_Qry($table,$set);
			$set_credit="user_id='".$uid."',
			credit='".$_REQUEST['credit']."',
			posted_on=NOW(),
			status='1'";
			Insert_Qry(CREDIT,$set_credit);
			/*$name =$_REQUEST['first_name'].' '.$_REQUEST['last_name'];
			$setnews=" user_id=$uid,
			name='".$name."',
			email='".escapeQuotes(stripslashes($_REQUEST['email']))."', status='1'";
			Insert_Qry(USERNEWSLETTER,$setnews);	*/		
	 	}
		else{
			Update_Qry($table,$set,"WHERE user_id='".$_REQUEST['id']."'");
		$fetch_credit=Select_Qry("*",CREDIT,"user_id='".$_REQUEST['id']."'","","","","");
				if($fetch_credit['user_id']=="")
				{
					$set_credit="user_id='".$_REQUEST['id']."',
					credit='".$_REQUEST['credit']."',
					posted_on=NOW(),
					status='1'";
					Insert_Qry(CREDIT,$set_credit);
				}
				else
				{
				Update_Qry(CREDIT,"credit='".$_REQUEST['credit']."',posted_on=NOW(),status='1'","WHERE user_id='".$_REQUEST['id']."'");
				}
		}
	//$msg= successfulMessage("<b>You Are Succesfully Added.</b>");
	 echo "<script>window.location.href='home.php?page=user-list'</script>";
	 }
}
			
###################### Status Change ##########################		
		if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="publish"))
	{			
		$obap=Select_Qry("status",USER," user_id='".$_REQUEST['id']."'","","","","");
			$whap=" WHERE user_id='".$_REQUEST['id']."'";			
			$setap=" status='1'";
			Update_Qry(USER,$setap,$whap);
	}
	
	  if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="unpublish"))
	{			
		$obap=Select_Qry("status",USER," user_id='".$_REQUEST['id']."'","","","","");
			$whap="WHERE user_id='".$_REQUEST['id']."'";			
			$setap="status='0'";
			Update_Qry(USER,$setap,$whap);
	}
	
	
				
###########
$table=USER;
$field="*";
$where_clause="user_id='".$_REQUEST['id']."'";
$arr=Select_Qry($field,$table,$where_clause,"","","","");

$arr_credit=Select_Qry("*",CREDIT,"user_id='".$_REQUEST['id']."'","","","","");
?>

<script language="javascript" src="js/ajax_state.js"></script>
<script language="javascript" src="js/validate_email.js"></script>
<script language="javascript">
function docheck()
{
	if(document.frm.username.value=="")
	{
	alert("Please enter Username");
	document.frm.username.focus();
	return false;
	}
	else if(document.frm.email.value=="")
	{
	alert("Please enter E-mail");
	document.frm.email.focus();
	return false;
	}
	else if(!emailCheck(document.frm.email))
	{
	document.frm.email.focus();
	return false;
	}
	else if(document.frm.password.value=="")
	{
	alert("Please enter Password");
	document.frm.password.focus();
	return false;
	}
	<?
	if($_REQUEST['id']=="")
	{
	?>
	else if(document.frm.avatar.value=="")
	{
	alert("Please upload avatar");
	return false;
	}
	<?
	}
	?>
	else if(document.frm.st_add.value=="")
	{
	alert("Please enter street address");
	document.frm.st_add.focus();
	return false;
	}
	else if(document.frm.city.value=="")
	{
	alert("Please enter city");
	document.frm.city.focus();
	return false;
	}
	else if(document.frm.country.value=="")
	{
	alert("Please select country");
	return false;
	}
	else if(document.frm.state.value=="")
	{
	alert("Please select state");
	return false;
	}
	else
	{
	return true;
	}

}
/////////////
	 
	  function publish(id)
	{
		  if(confirm('Do you want to publish this Content ?'))
		{ 
		   document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=publish&id='+id;
		   document.frm.submit();
		}
	}
	
	 function unpublish(id)
	{
		  if(confirm('Do you want to unpublish this Content ?'))
		{ 
		   document.frm.action='<?=$_SERVER['PHP_SELF']?>?page=<?=$_REQUEST['page']?>&mode=unpublish&id='+id;
		   document.frm.submit();
		}
	}
	
	function ShowChange(val){
		alert(val);
	}
	
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
<form action="" method="post" name="frm" enctype="multipart/form-data">
<table cellpadding="5" cellspacing="0" width="100%">
<tr><td align="left" valign="top">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td width="6"><img src="images/7_01.png" width="6" height="64" />
</td>
<td background="images/7_03.png">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="62%" class="texttitle">
					<img src="images/usermanager.png" width="48" height="48" />
					<span style="padding-left:10px; padding-top:8px; position:absolute;">
					<?php echo $_REQUEST['id']==''?'Add' : 'Edit'?> User</span></td>
					<? if($_REQUEST['id']!='')
		                 {           
		                  if($arr['status'] == '0')
						    {?>
					<td width="4%" align="center" valign="top">
					<a href="javascript: publish(<? echo($arr['user_id']);?>)">
					<img src="images/published.png"  border="0" alt="Click Here to Publish"/></a> 	</td>
					     <? }
						 if($arr['status'] == '1') 
						    {?>
                    <td width="4%" align="center" valign="top">
					<a href="javascript: unpublish(<? echo($arr['user_id']);?>)">
					<img src="images/unpublished.png"  border="0" alt="Click Here to Unpublish"/></a>
					</td>
                          <? } }?>
                  </tr>
                </table></td><td width="10"><img src="images/7_05.png" width="6" height="64" /></td></tr></table>


</td></tr>


<tr><td align="left" valign="top" >
<fieldset  style="width:98%;">

<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="3" align="center" valign="top"><?=$msg?></td>
    </tr>
  
  <tr>
    <td align="left" valign="top" class="sitesettings">Username</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="username"  size="30" class="input" value="<?=$arr['username']?>"/></td>
  </tr>
  <tr>
    <td width="28%" align="left" valign="top" class="sitesettings">First Name</td>
    <td width="5%" align="center" valign="top" >:</td>
    <td width="67%" align="left" valign="top" ><input type="text" name="first_name"  size="30" class="input" value="<?=$arr['first_name']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Last Name</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="last_name" class="input"  size="30" value="<?=$arr['last_name']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">E-mail</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="email" class="input"  size="30" value="<?=$arr['email']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Password</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="password" name="password"  size="30" class="input" value="<?=$arr['password']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Avatar</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top">
	<input type="file" name="avatar" class="input" size="30" />
	<?
	if($arr['avatar']!="")
	{
	?>
	<img src="../avatar/small_<?=$arr['avatar']?>" align="absmiddle" border="0" />
	<?
	}
	?>	</td>
  </tr>
  <tr>
   <td align="left" valign="top" class="sitesettings">Address</td>
   <td align="center" valign="top" >:</td>
   <td align="left" valign="top" ><input type="text" name="st_add" class="input"  size="30" value="<?=$arr['st_add']?>"/></td>
 </tr>
 <tr>
   <td align="left" valign="top" class="sitesettings">City</td>
   <td align="center" valign="top" >:</td>
   <td align="left" valign="top" ><input type="text" name="city" class="input"  size="30" value="<?=$arr['city']?>"/></td>
 </tr>
 
 <tr>
   <td align="left" valign="top" class="sitesettings">Country</td>
   <td align="center" valign="top" >:</td>
   <td align="left" valign="top"><select name="country" onChange="showState(this.value)" >
                            <option value="" selected>Select Country</option>
                                <?php 
								  $sql_country="select * from ".COUNTRY;
								  $rs_country=mysql_query($sql_country);
								  if(mysql_num_rows($rs_country)>0)
								  {
								  while($arr_country=mysql_fetch_array($rs_country))
								   {
								  echo("<option value='".$arr_country['countryId']."'>".$arr_country['countryName']."</option>");
								   }
								  }
							?>
                           </select>
						   <script language="JavaScript">
                            var CType="<?=$arr['country']?>";
                            for (var i=0; i<document.frm.country.options.length; i++)
                                {
                                    if (document.frm.country.options[i].value==CType)
                                        {		
                                            document.frm.country.options[i].selected=true;
                                            break;
                                        }
                                }
                        </script></td>
 </tr>
 <tr>
   <td align="left" valign="top" class="sitesettings">State</td>
   <td align="center" valign="top" >:</td>
   <td align="left" valign="top" id="TxtState">
   <select name="state">
   <option value="">-Select State-</option>
   <?
   	$statelist=Listing_Qry("*",STATE," WHERE countryId_fk='".$arr['country']."'","");
	foreach($statelist as $state){
   ?>
   <option value="<?=$state['stateId']?>"><?=$state['stateName']?></option>
   <? } ?>
   </select>
   <script language="JavaScript">
                            var CType="<?=$arr['state']?>";
                            for (var i=0; i<document.frm.state.options.length; i++)
                                {
                                    if (document.frm.state.options[i].value==CType)
                                        {		
                                            document.frm.state.options[i].selected=true;
                                            break;
                                        }
                                }
                        </script>   </td>
 </tr>
 <tr>
   <td align="left" valign="top" class="sitesettings">Zip</td>
   <td align="center" valign="top" >:</td>
   <td align="left" valign="top" ><input type="text" name="zip" class="input"  size="30" value="<?=$arr['zip']?>"/></td>
 </tr>
 <tr>
   <td align="left" valign="top" class="sitesettings">Phone</td>
   <td align="center" valign="top" >:</td>
   <td align="left" valign="top" ><input type="text" name="phone" class="input"  size="30" value="<?=$arr['phone']?>"/></td>
 </tr>
 <tr>
   <td align="left" valign="top" class="sitesettings">Credit Point </td>
   <td align="center" valign="top" >:</td>
   <td align="left" valign="top" ><input type="text" name="credit" class="input"  size="30" value="<?=$arr_credit['credit']?>" onkeypress="return keyRestrict(event,'1234567890.')"/></td>
 </tr>
 <tr>
    <td align="left" valign="top" class="sitesettings">&nbsp;</td>
    <td align="center" valign="top" >&nbsp;</td>
    <td align="left" valign="top" ><input type="submit" name="btnSubmit" class="bttn" value="<?php echo $_REQUEST['id']==''?'Add':'Edit'?>" onclick="return docheck()"/>&nbsp;&nbsp;<input type="button"  name="btnBack" value="Back" class="bttn" onClick="window.location.href='home.php?page=user-list&PageNo=<?=$_REQUEST['PageNo']?>'"/></td>
  </tr>
</table>
</fieldset>
</td></tr></table>
</form>