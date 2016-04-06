

<?
validation_check($_SESSION['logged'], 'index.php');
if(isset($_REQUEST['btnSubmit']))
{
	
		  
		
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
     
      
      if(empty($errors)==true){
      
      if(file_exists("../images/logo/".$file_name)) unlink("../images/logo/".$file_name);
      
         move_uploaded_file($file_tmp,"../images/logo/".'logo.jpg');
   $msg  = 'The image has been updated .please refresh to see the changes';
      }else{
         print_r($errors);
      }
   }

}
?>

<script language="javascript" src="js/ajax_state.js"></script>
<script language="javascript" src="js/validate_email.js"></script>


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
					Upload Image</span> </td>
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
   <td> <h2>Previous Image </h2></td>
   
   <img src="../images/logo/logo.jpg" align="absmiddle" border="0" />
   
 <h3><?php if(!empty($msg)){
    echo $msg;}
    
 ?><h3>
       <td align="left" valign="top">
   
 
 
    <td align="left" valign="top">
	<input type="file" name="image" class="input" size="30" />

	</td>

  </tr>
  
 <tr>
    <td align="left" valign="top" class="sitesettings">&nbsp;</td>
    <td align="center" valign="top" >&nbsp;</td>
    <td align="left" valign="top" ><input type="submit" name="btnSubmit" class="bttn" value="<?php echo 'Upload'?>" />&nbsp;&nbsp;<input type="button"  name="btnBack" value="Back" class="bttn" onClick="window.location.href='home.php?page=user-list&PageNo=<?=$_REQUEST['PageNo']?>'"/></td>
  </tr>
</table>
</fieldset>
</td></tr></table>
</form>