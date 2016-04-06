<?
validation_check($_SESSION['logged'], 'index.php');
$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['id']."'","","","","");
if(isset($_REQUEST['btnSubmit']))
{
	$fields = "*";
	$table  = ADVERTISE;
	$where_clause = "add_id='".$_REQUEST['id']."'";
	$rs1	=Select_Qry($fields,$table,$where_clause,"","","","");
	$cat	=Select_Qry("*",CATEGORY,"cat_id='".$_REQUEST['category']."'","","","","");
	
	$bo		=$_REQUEST['bold']==""?"0":"1";
	$hig	=$_REQUEST['highlight']==""?"0":"1";
	$fea	=$_REQUEST['featured']==""?"0":"1";
	$rowb	=$_REQUEST['rowborder']==""?"0":"1";
	$table	=ADVERTISE;
	$set="cat_id='".escapeQuotes(stripslashes(trim($_REQUEST['category'])))."',
		title ='".escapeQuotes(stripslashes(trim($_REQUEST['title'])))."',
		subtitle  ='".escapeQuotes(stripslashes(trim($_REQUEST['subtitle'])))."',
		description='".escapeQuotes(stripslashes(trim($_REQUEST['description'])))."',
		asking_price='".$_REQUEST['price']."',
		length='".escapeQuotes(stripslashes(trim($_REQUEST['length'])))."',
		buyer_price='".$_REQUEST['buyer_price']."',
		paypal_email='".escapeQuotes(stripslashes(trim($_REQUEST['paypal_email'])))."',
		company_name='".escapeQuotes(stripslashes(trim($_REQUEST['company_name'])))."',
		website='".escapeQuotes(stripslashes(trim($_REQUEST['website'])))."',
		site_status_name = '".$_REQUEST['statusId']."',
		visitor = '".$_REQUEST['visitor']."',
		traffic_pages = '".$_REQUEST['traffic_pages']."',
		income_month='".$_REQUEST['income_month']."',
		run_cost='".$_REQUEST['run_cost']."',
		disk_space='".$_REQUEST['disk_space']."',
		bandwidth='".$_REQUEST['bandwidth']."',
		site_members='".$_REQUEST['site_members']."',
		income_1 = '".$_REQUEST['income_1']."',
		income_2 = '".$_REQUEST['income_2']."',
		income_3 = '".$_REQUEST['income_3']."',
		income_4 = '".$_REQUEST['income_4']."',
		income_5 = '".$_REQUEST['income_5']."',
		income_6 = '".$_REQUEST['income_6']."',
		sold_1='".$_REQUEST['sold_1']."',
		sold_2='".$_REQUEST['sold_2']."',
		sold_3='".$_REQUEST['sold_3']."',
		sold_4='".$_REQUEST['sold_4']."',
		sold_5='".$_REQUEST['sold_5']."',
		sold_6='".$_REQUEST['sold_6']."',
		own_content='".$_REQUEST['own_content']."',
		own_server='".$_REQUEST['own_server']."',
		aboutus='".escapeQuotes(stripslashes(trim($_REQUEST['aboutus'])))."',
		product_page='".escapeQuotes(stripslashes(trim($_REQUEST['product_page'])))."',
		faq='".escapeQuotes(stripslashes(trim($_REQUEST['faq'])))."',
		contact_us='".escapeQuotes(stripslashes(trim($_REQUEST['contact_us'])))."',
		contact_email='".escapeQuotes(stripslashes(trim($_REQUEST['contact_email'])))."',
		bold='".$bo."', 
		highlight='".$hig."',
		featured='".$fea."',
		rowborder='".$rowb."',
		valid_till= ADDDATE(NOW(),INTERVAL ".$_REQUEST['length']." DAY),
		posted_on=NOW()";
		  
	 if($cat['add_space']!='1')
	{
		if($_FILES["site_img"]["name"] != '')
			{
				if(file_exists("../websiteImage/".$rs1['site_img']))
					{
						@unlink("../websiteImage/".$rs1['site_img']);
						@unlink("../websiteImage/thumb".$rs1['site_img']);
					}
				$uploaddir='../websiteImage/';
				$fileExt = strchr($_FILES["site_img"]["name"],".");
				$random=rand();
				$picture=$random.$fileExt;
				$uploadfile =$uploaddir . $picture;
				$file_type = $_FILES['site_img']['type'];
				$file_name = $_FILES['site_img']['name'];
				$file_size = $_FILES['site_img']['size'];
				$file_tmp = $_FILES['site_img']['tmp_name'];
				
				image_resize($uploaddir."thumb",80,$file_type,$file_name,$file_size,$file_tmp,$picture);
				move_uploaded_file($_FILES['site_img']['tmp_name'], $uploadfile);
				$set.=",site_img='".$picture."'";
			}
		}	
		else
		{
		@unlink("../websiteImage/".$rs1['site_img']);
		@unlink("../websiteImage/thumb".$rs1['site_img']);
		$set.=",site_img=''";
		}	
		 
		if($_REQUEST['id']=="")
		{
	 		$set.=",price='".$_REQUEST['price']."'";
			Insert_Qry(ADVERTISE,$set);
		}
		else
		{
			Update_Qry(ADVERTISE,$set,"WHERE add_id='".$_REQUEST['id']."'");
		}
	//$msg= successfulMessage("<b>You Are Succesfully Added.</b>");
	 echo "<script>window.location.href='home.php?page=auction-list'</script>";
	
}
			
###################### Status Change ##########################		
		if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="publish"))
	{			
		$obap=Select_Qry("status",ADVERTISE," add_id='".$_REQUEST['id']."'","","","","");
			$whap=" WHERE add_id='".$_REQUEST['id']."'";			
			$setap=" status='1'";
			Update_Qry(ADVERTISE,$setap,$whap);
	}
	
	  if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=="unpublish"))
	{			
		$obap=Select_Qry("status",ADVERTISE," add_id='".$_REQUEST['id']."'","","","","");
			$whap="WHERE add_id='".$_REQUEST['id']."'";			
			$setap="status='0'";
			Update_Qry(ADVERTISE,$setap,$whap);
	}
	
	
				
###########
$table=ADVERTISE;
$field="*";
$where_clause="add_id='".$_REQUEST['id']."'";
$arr=Select_Qry($field,$table,$where_clause,"","","","");
if($_REQUEST['cat_id']!='')
	{
		$catID=$_REQUEST['cat_id'];
	}
	else
	{
		$catID=$pro['cat_id'];
	}
$cat=Select_Qry("*",CATEGORY," cat_id='".$catID."'","","","","");

	if($_REQUEST['cat_id']!='')
		{
			$CATID=$_REQUEST['cat_id'];
		}
		else if($_REQUEST['cat_id']=="" && $_REQUEST['id']=="")
		{
			$CATID='0';
		}
		else
		{
			$CATID=$arr['cat_id'];
		}	
?>
<script type="text/javascript" src="js/urlcheck.js"></script>
<script language="javascript">
function doCategory(catID)
	{
		window.location.href='home.php?page=<?=$_REQUEST['page']?>&id=<?=$_REQUEST['id']?>&cat_id='+catID;
	}
function docheck()
{
	if(document.frm.category.value=="")
	{
	alert("Please select category");
	document.frm.category.focus();
	return false;
	}
	else if(document.frm.title.value=="")
	{
	alert("Please enter title");
	document.frm.title.focus();
	return false;
	}
	else if(document.frm.subtitle.value=="")
	{
	alert("Please enter subtitle");
	document.frm.subtitle.focus();
	return false;
	}
	else if(document.frm.description.value=="")
	{
	alert("Please enter description");
	document.frm.description.focus();
	return false;
	}
	else if(document.frm.company_name.value=="")
	{
	alert("Please enter Company name");
	document.frm.company_name.focus();
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
	
/////////////////////////////
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
					<img src="images/mediamanager.png" width="48" height="48" border="0" />
					<span style="padding-left:10px; padding-top:8px; position:absolute;">
					<?php echo $_REQUEST['id']==''?'Add' : 'Edit'?> Auction Listing</span></td>
					<? if($_REQUEST['id']!='')
		                 {           
		                  if($arr['status'] == '0')
						    {?>
					<td width="4%" align="center" valign="top">
					<a href="javascript: publish(<? echo($arr['add_id']);?>)">
					<img src="images/published.png"  border="0" alt="Click Here to Publish"/></a> 	</td>
					     <? }
						 if($arr['status'] == '1') 
						    {?>
                    <td width="4%" align="center" valign="top">
					<a href="javascript: unpublish(<? echo($arr['add_id']);?>)">
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
    <td align="left" valign="top" class="sitesettings">Category</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><select name="category" onchange="doCategory(this.value)">
      <option value="" selected>Select Category</option>
      <?php 
								  $sql_category="select * from ".CATEGORY." WHERE status='1'";
								  $rs_category=mysql_query($sql_category);
								  if(mysql_num_rows($rs_category)>0)
								  {
								  while($arr_category=mysql_fetch_array($rs_category))
								   {
								  echo("<option value='".$arr_category['cat_id']."'>".$arr_category['cat_name']."</option>");
								   }
								  }
							?>
    </select>
    <script language="JavaScript">
                            var CType="<?=$_REQUEST['cat_id'] !=''?$_REQUEST['cat_id']:$arr['cat_id']?>";
                            for (var i=0; i<document.frm.category.options.length; i++)
                                {
                                    if (document.frm.category.options[i].value==CType)
                                        {		
                                          document.frm.category.options[i].selected=true;
                                          break;
                                        }
                                }
                        </script></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Title</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="title"  size="30" class="input" value="<?=$arr['title']?>" /></td>
  </tr>
  <tr>
    <td width="28%" align="left" valign="top" class="sitesettings">Subtitle</td>
    <td width="5%" align="center" valign="top" >:</td>
    <td width="67%" align="left" valign="top" ><input type="text" name="subtitle"  size="30" class="input" value="<?=$arr['subtitle']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Description</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><textarea name="description" class="input" cols="30" rows="8"><?=$arr['description']?></textarea></td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="sitesettings">Length</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="length" class="input"  size="30" value="<?=$arr['length']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/></td>
  </tr>
  <?
  	if(CATEGORY_ADD($CATID)!='1')  {
?>
  
  <tr>
    <td align="left" valign="top" class="sitesettings">Price</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="price" class="input"  size="30" value="<?=$arr['price']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Buy it now price </td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="buyer_price" class="input"  size="30" value="<?=$arr['buyer_price']?>"  onkeypress="return keyRestrict(event,'1234567890.')"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Paypal Email </td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="paypal_email" class="input"  size="30" value="<?=$arr['paypal_email']?>"/></td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td align="left" valign="top" class="sitesettings">Company Name</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="company_name"  size="30" class="input" value="<?=$arr['company_name']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Website</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input type="text" name="website"  size="30" class="input" value="<?=$arr['website']?>"/></td>
  </tr>
  
  <?
  	if(CATEGORY_ADD($CATID)!='1')  {
?>
  <tr>
    <td align="left" valign="top" class="sitesettings">Site Image</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input type="file" name="site_img">
					&nbsp;
					<?
					if($arr['site_img']!="")
					{
					?>
					<img src="../websiteImage/<?=$arr['site_img']?>" width="50" align="top"/>
					<?
					}
					?>					</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Site Status</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><select name="statusId" class="SELECT" style="width:200px;">
      <option value="">Select Category</option>
      <?
					$catList=Listing_Qry("*",CATEGORY,"WHERE status='1' ORDER BY cat_id DESC","");
		if($catList!="")
		{
			foreach($catList as $cat)
			{
	  ?>
	  <option value="<?=$cat['cat_id']?>"><?=$cat['cat_name']?></option>
	  <?
	  		}
		}
	  ?>
	  </select>
</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Visitors</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input name="visitor" type="text" class="textbox2" value="<?=$arr['visitor']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')">    
	 Daily</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Page Views</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input name="traffic_pages" type="text" class="textbox2" value="<?=$arr['traffic_pages']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')" />
Daily</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Income</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input name="income_month" type="text" class="textbox2" value="<?=$arr['income_month']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')">
	US$ Per Month</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Cost to run site</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input name="run_cost" type="text" class="textbox2" value="<?=$arr['run_cost']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')"/>
US$ Per Month</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Disk Space used</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input name="disk_space" type="text" class="textbox2" value="<?=$arr['disk_space']?>" size="10" onKeyPress="return keyRestrict(event,'1234567890.')"/>
			MB</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Bandwidth used</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input name="bandwidth" type="text" class="textbox2" value="<?=$arr['bandwidth']?>" size="10" onKeyPress="return keyRestrict(event,'1234567890.')"/>
			MB per month</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Members</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top"><input name="site_members" type="text" class="textbox2" value="<?=$arr['site_members']?>" size="7" onKeyPress="return keyRestrict(event,'1234567890.')"/>
			Total number of members</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Business 
	Information</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td width="200"><strong>Income from: </strong><span class="smalltext"><br>            
		    <input type="checkbox" name="income_1" value="1" <? if($arr['income_1']=='1'){?>checked<? } ?>>
		Selling Products<br>          
		<input type="checkbox" name="income_2" value="1" <? if($arr['income_2']=='1'){?>checked<? } ?>>          
		Selling Access to Site<br>          
		<input type="checkbox" name="income_3" value="1" <? if($arr['income_3']=='1'){?>checked<? } ?>>          
		Selling Site-related Services<br>          
		<input type="checkbox" name="income_4" value="1" <? if($arr['income_4']=='1'){?>checked<? } ?>>
		Selling Non-Site-related Services<br>          
		<input type="checkbox" name="income_5" value="1" <? if($arr['income_5']=='1'){?>checked<? } ?>>
		Other<br>          
		<input type="checkbox" name="income_6" value="1" <? if($arr['income_6']=='1'){?>checked<? } ?>>
		No Income</span></td>
		<td width="140"><strong>Sold with website: </strong><br>            
		<input type="checkbox" name="sold_1" value="1" <? if($arr['sold_1']=='1'){?>checked<? } ?>>
		<span class="smalltext">		Business<br>          
		<input type="checkbox" name="sold_2" value="1" <? if($arr['sold_2']=='1'){?>checked<? } ?>>
		Images &amp; Content<br>          
		<input type="checkbox" name="sold_3" value="1" <? if($arr['sold_3']=='1'){?>checked<? } ?>>
		Software<br>          
		<input type="checkbox" name="sold_4" value="1" <? if($arr['sold_4']=='1'){?>checked<? } ?>>
		Tradenamed<br>          
		<input type="checkbox" name="sold_5" value="1" <? if($arr['sold_5']=='1'){?>checked<? } ?>>
		Original Graphics<br>          
		<input type="checkbox" name="sold_6" value="1" <? if($arr['sold_6']=='1'){?>checked<? } ?>>
		3<sup>rd</sup> party Licenses</span><br>        </td>
		<td><strong>Site owns</strong>:<br>            
		<input type="checkbox" name="own_content" value="1" <? if($arr['own_content']=='1'){?>checked<? } ?>>
		<span class="smalltext">All Content<br>          
		<input type="checkbox" name="own_server" value="1" <? if($arr['own_server']=='1'){?>checked<? } ?>>
		Server</span><br></td>
		</tr>
		</table>	</td>
  </tr>
  <? }?>
  <tr>
    <td align="left" valign="top" class="sitesettings">About Us </td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="aboutus"  size="30" class="input" value="<?=$arr['aboutus']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Product Page </td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="product_page"  size="30" class="input" value="<?=$arr['product_page']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Faq</td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="faq"  size="30" class="input" value="<?=$arr['faq']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Contact us </td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="contact_us"  size="30" class="input" value="<?=$arr['contact_us']?>"/></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="sitesettings">Contact Email </td>
    <td align="center" valign="top" >:</td>
    <td align="left" valign="top" ><input type="text" name="contact_email"  size="30" class="input" value="<?=$arr['contact_email']?>"/></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" class="sitesettings">Listing Upgrades</td>
    </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="8%" align="left" valign="top"><input type="checkbox" name="bold" value="1" <? if($arr['bold']=='1'){?> checked="checked"<? }?> /></td>
    <td width="33%" align="left" valign="top">Site Listed in Bold Fee : </td>
    <td width="59%" align="left" valign="top" class="error">($<?php echo FEE_BOLD?>)</td>
   </tr>
  <tr>
    <td align="left" valign="top"><input type="checkbox" name="highlight" value="1" <? if($arr['highlight']=='1'){?> checked="checked"<? }?> /></td>
    <td align="left" valign="top">Site Listed in Highlighted Fee :</td>
    <td align="left" valign="top" class="error">($<?php echo FEE_HIGHLIGHTED?>)</td>
  </tr>
  <tr>
    <td align="left" valign="top"><input type="checkbox" name="featured" value="1" <? if($arr['featured']=='1'){?> checked="checked"<? }?> /></td>
    <td align="left" valign="top">Site Listed in Featured Fee:</td>
    <td align="left" valign="top" class="error">($<?php echo FEE_FEATURED?>)</td>
  </tr>
  <tr>
    <td align="left" valign="top"><input type="checkbox" name="rowborder" value="1" <? if($arr['rowborder']=='1'){?> checked="checked"<? }?> /></td>
    <td align="left" valign="top">Site Listed in Row Border Fee: </td>
    <td align="left" valign="top" class="error">($<?php echo FEE_ROWBORDER?>)</td>
  </tr>
</table></td>
    </tr>
 <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="center" valign="top" >&nbsp;</td>
    <td align="left" valign="top" ><input type="submit" name="btnSubmit" class="bttn" value="<?php echo $_REQUEST['id']==''?'Add':'Edit'?>" onclick="return docheck()"/>&nbsp;&nbsp;<input type="button"  name="btnBack" value="Back" class="bttn" onClick="window.location.href='home.php?page=auction-list&PageNo=<?=$_REQUEST['PageNo']?>'"/></td>
  </tr>
</table>
</fieldset>
</td></tr></table>
</form>