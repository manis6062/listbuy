<?php

	############### DATABASE QUERY #####################################

			function Select_Qry($fields,$table,$where_clause,$orderby,$type,$startRow, $PageSize)
		{
			$sql_condition="";
			if($where_clause!="")
			{
				$sql_condition.=" WHERE ".$where_clause;
			}
			if($orderby!='')
			{
				$sql_condition.=" ORDER BY ".$orderby;
			}
			if($orderby !='' && $type!='')
			{
				$sql_condition.=" ".$type;
			}
			if($startRow!='' && $PageSize!='')
			{
				$sql_condition.=" LIMIT ".$startRow.",".$PageSize;
			}
			//echo "SELECT ".$fields." FROM ".$table." ".$sql_condition."";
			$resCondition = mysql_query("SELECT ".$fields." FROM ".$table." ".$sql_condition."")or die(mysql_error()."Error in selectQry() ");
			if(mysql_num_rows($resCondition) > 0)
				{
					$obCondition = mysql_fetch_array($resCondition);
					$fields="";
					$table="";
					$where_clause="";
					$orderby="";
					$type="";
					#print_r($obCondition);
					
					return $obCondition;
				}
			else
			{
					$fields="";
					$table="";
					$where_clause="";
					$orderby="";
					$type="";
				    return false;
			}
		}
		#######################LISTING #################################<br />
		function Listing_Qry($field,$table,$where_clause,$order)
			{
				if($where_clause != "")
				{
				//print "SELECT ".$field." FROM ".$table." ".$where_clause." ".$order."";
					$ListContent = mysql_query("SELECT ".$field." FROM ".$table." ".$where_clause." ".$order) or die(mysql_error()."Error in listingQry()");
				}
				else
				{
					//print "SELECT ".$field." FROM ".$table."";
					$ListContent = mysql_query("SELECT ".$field." FROM ".$table) or die(mysql_error()."Error in listingQry())");
				}
				if(mysql_num_rows($ListContent) > 0)
				{
					while($objContent = mysql_fetch_array($ListContent))
					{
						$arrList[] = $objContent;
					}
					return $arrList;
				}
				else
				{
					return 0;
				}
			}
		#################### INSERT ####################################
		function Insert_Qry($table,$value)
		{
			//print "INSERT INTO ".$table." SET ".$value."";
			//exit;
			mysql_query("INSERT INTO ".$table." SET ".$value."") or die(mysql_error()."Error in insertQry()");
			return mysql_insert_id();
		}
		################################################################
		function Update_Qry($table,$set_value,$where_clause)
		{
			//print "UPDATE ".$table." SET ".$set_value." ".$where_clause."";
			//exit;
			mysql_query("UPDATE ".$table." SET ".$set_value." ".$where_clause."") or die(mysql_error()."Error in updateQry()");
			return true;
		}
		function Delete_Qry($table,$where_clause)
		{
			//print "DELETE FROM ".$table." ".$where_clause."";
			mysql_query("DELETE FROM ".$table." ".$where_clause."") or die(mysql_error()."Error in deleteQry()");
			return true;
		}
	####################################################################
	
	###############################################################################
	function validation_check($checkingVariable, $destinationPath)
	{
		if($checkingVariable =='')
		{
			header("location:".$destinationPath);
		}
	}
	function validation_user_check($checkingVariable, $destinationPath)
	{
		if($checkingVariable =='')
		{
			header("location:".$destinationPath);
		}
	}
	function logout($destinationPath)
	{
		if(count($_SESSION))
		{
			foreach($_SESSION AS $key=>$value)
			{
				session_unset($_SESSION[$key]);
			}
			session_destroy();
		}
		header("location:".$destinationPath);
	}
	
	function escapeQuotes($input)
	{
		if(strlen($input) > 0)
		{
			return str_replace("'", "\'", $input);
		}
		else
		{
			return $input;
		}
	}
	function Send_HTML_Mail($mail_To, $mail_From, $mail_CC, $mail_subject, $mail_Body)
	{
		$mail_Headers  = "MIME-Version: 1.0\r\n";
		$mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		#$mail_Headers .= "To: ".$mail_To."\r\n";
		$mail_Headers .= "From: ".$mail_From."\r\n";
		$mail_Headers .= "Subject: ".$mail_subject."\r\n";
		if($mail_CC != '')
		{
			$mail_Headers .= "Cc: ".$mail_CC."\r\n";
		}
		if(mail($mail_To, $mail_subject, $mail_Body, $mail_Headers))
		{			
			return true;
		}
		else
		{        	
			return false;
		}
	}
	
	function successfulMessage($message)
	{
		$msg = "<div  class='error'><img src='".IMAGE_PATH."/success.png' align='absmiddle'/>&nbsp;&nbsp;&nbsp;&nbsp;".$message."</div>";
		return $msg;
	}
	function FrontendSuccessMessage($message)
	{
		$msg = "<div  class='error'><img src='".IMAGE_PATH."/success.png' align='absmiddle'/>&nbsp;&nbsp;&nbsp;&nbsp;".$message."</div>";
		return $msg;
	}
	
	function errorMessage($message)
	{
		$msg = "<div  class='error'><img src='".IMAGE_PATH."/alert.png' align='absmiddle'/>&nbsp;&nbsp;&nbsp;&nbsp;".$message."</div>";
		return $msg;
	}
	
	
	function statica_cms_page_value($page_id)
	{
		if($page_id!='')
		{
	$sql_page_content="select * from ".STATICCMS." where cmsid='".$page_id."' AND status='1'";
			$rs_page_content=mysql_query($sql_page_content);
			if(mysql_num_rows($rs_page_content)>0)
			{
				$obj_page_content=mysql_fetch_object($rs_page_content);
			}
			return $obj_page_content->description;
		}
		else
		{
			return false;
		}
	}
	function image_resize($path,$thumb_width,$file_type,$file_name,$file_size,$file_tmp,$picture)
	{
		//make sure this directory is writable!
		$path_thumbs = $path;		
		//the new width of the resized image, in pixels.
		$img_thumb_width = $thumb_width; // 
		$extlimit = "yes"; //Limit allowed extensions? (no for all extensions allowed)
		//List of allowed extensions if extlimit = yes
		$limitedext = array(".gif",".jpg",".png",".jpeg",".bmp");		
		
		//check if you have selected a file.
		if(!is_uploaded_file($file_tmp)){
		echo "Error: Please select a file to upload!. <br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>";
		exit(); //exit the script and don't process the rest of it!
		}
		//check the file's extension
		$ext = strrchr($file_name,'.');
		//print $ext;
		$ext = strtolower($ext);
		//uh-oh! the file extension is not allowed!
		if (($extlimit == "yes") && (!in_array($ext,$limitedext))) {
		echo "Wrong file extension.  <br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>";
		exit();
		}
		//so, whats the file's extension?
		$getExt = explode ('.', $file_name);
		$file_ext = $getExt[count($getExt)-1];
		//create a random file name
		$rand_name = md5(time());
		$rand_name= rand(0,999999999);
		//the new width variable
		$ThumbWidth = $img_thumb_width;

		/////////////////////////////////
		// CREATE THE THUMBNAIL //
		////////////////////////////////

		//keep image type
		if($file_size){
		if($file_type == "image/pjpeg" || $file_type == "image/jpg" || $file_type == "image/jpeg"){
		$new_img = imagecreatefromjpeg($file_tmp);
		}elseif($file_type == "image/x-png" || $file_type == "image/png"){
		$new_img = imagecreatefrompng($file_tmp);
		}elseif($file_type == "image/gif"){
		$new_img = imagecreatefromgif($file_tmp);
		}
		//list the width and height and keep the height ratio.
		list($width, $height) = getimagesize($file_tmp);
		//calculate the image ratio
		$imgratio=$width/$height;
		if ($imgratio>1){
		$newwidth = $ThumbWidth;
		$newheight = $ThumbWidth/$imgratio;
		}else{
		$newheight = $ThumbWidth;
		$newwidth = $ThumbWidth*$imgratio;
		}
		//function for resize image.
		if (function_exists(imagecreatetruecolor)){
		$resized_img = imagecreatetruecolor($newwidth,$newheight);
	//	print $resized_img."dsjkhfjksdhjfsdjhfshd";
		}else{
		die("Error: Please make sure you have GD library ver 2+");
		}
		//the resizing is going on here!
		imagecopyresampled($resized_img, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//finally, save the image
		ImageJpeg ($resized_img,$path.$picture);
		ImageDestroy ($resized_img);
		ImageDestroy ($new_img);
		}
	
	}
	
	function dateprint($date)
	{
		if($date!='0000-00-00 00:00:00')return date('M d, Y',strtotime($date));
		else return false;
	}
	
################################## SUMAN NATH  ######## CREATED FOR IMAGE CROP FUNCTION
		 function CroptoSmall($SrcImgPath, $DestImgPath,$StartCoordinateX,$StartCoordinateY, $width, $height)
		 {
			// Some esential variables
			$image = $SrcImgPath;
		
			// make sure the directory is writeable
			$dest_image = $DestImgPath;
			$img = imagecreatetruecolor($width,$height);
			$org_img = imagecreatefromjpeg($image);
			$ims= getimagesize($image);
				if($ims[0] >= $width)
				{
					$dest_width=$width;
				}
				else{
					$dest_width=$ims[0];
				}
				
				if($ims[1] >= $height)
				{
					$dest_height=$height;
				}
				else{
					$dest_height=$ims[1];
				}
			
			imagecopy($img,$org_img, 0, 0, $StartCoordinateX, $StartCoordinateY, $dest_width, $dest_height);
			imagejpeg($img,$dest_image,90);
			imagedestroy($img);
		 }
		function mail_attachment3($from , $to, $subject, $message, $attachment)
		{
		
					$fileatt = $attachment; // Path to the file                  
					$fileatt_type = "application/octet-stream"; // File Type 
					$start=    strrpos($attachment, '/') == -1 ? strrpos($attachment, '//') : strrpos($attachment, '/')+1;
					$fileatt_name = substr($attachment, $start, strlen($attachment)); // Filename that will be used for the file as the     attachment 
				
					$email_from = $from; // Who the email is from 
					$email_subject =  $subject; // The Subject of the email 
					$email_txt = $message; // Message that the email has in it 
					
					$email_to = $to; // Who the email is to
				
					$headers = "From: ".$email_from;
				
					$file = fopen($fileatt,'rb'); 
					$data = fread($file,filesize($fileatt)); 
					fclose($file); 
				#	$msg_txt="\n\nMail created using free code from 4word systems : http://4wordsystems.com";
				
					$semi_rand = md5(time()); 
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
					
					$headers .= "\nMIME-Version: 1.0\n" . 
							"Content-Type: multipart/mixed;\n" . 
							" boundary=\"{$mime_boundary}\""; 
				
			#		$email_txt .= $msg_txt;
					
					$email_message .= "This is a multi-part message in MIME format.\n\n" . 
								"--{$mime_boundary}\n" . 
								"Content-Type:text/html; charset=\"iso-8859-1\"\n" . 
							   "Content-Transfer-Encoding: 7bit\n\n" . 
					$email_txt . "\n\n"; 
				
					$data = chunk_split(base64_encode($data)); 
				
					$email_message .= "--{$mime_boundary}\n" . 
								  "Content-Type: {$fileatt_type};\n" . 
								  " name=\"{$fileatt_name}\"\n" . 
								  //"Content-Disposition: attachment;\n" . 
								  //" filename=\"{$fileatt_name}\"\n" . 
								  "Content-Transfer-Encoding: base64\n\n" . 
								 $data . "\n\n" . 
								  "--{$mime_boundary}--\n"; 
				
				
					$ok = @mail($email_to, $email_subject, $email_message, $headers); 
				
					if($ok) 
					{ 
					} 
					else
					 { 
						die("Sorry but the email could not be sent. Please go back and try again! check on server"); 
					} 
		}


	################## IMAGE RESIZING FUNCTIONS ########################
	function createThumbImageSize($thumbdir, $temp_img, $size, $img_name) 
		{
		$maxfile = '2000000';
		$mode = '0666';
		$fileExt = strchr($_FILES[$temp_img]["name"],".");
		$userfile_name = $img_name.$fileExt;
		#$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES[$temp_img]['tmp_name'];
		$userfile_size = $_FILES[$temp_img]['size'];
		$userfile_type = $_FILES[$temp_img]['type'];
		
		if (isset($_FILES[$temp_img]['name'])) 
		{
			$prod_img_thumb = $thumbdir.$userfile_name;
			$return_path = $userfile_name;
			
			$sizes = getimagesize($_FILES[$temp_img]['tmp_name']);
	
			$aspect_ratio = $sizes[1]/$sizes[0]; 
	
			if ($sizes[1] <= $size)
			{
				$new_width = $sizes[0];
				$new_height = $sizes[1];
			}
			else{
				$new_height = $size;
				$new_width = abs($new_height/$aspect_ratio);
			}
			if($fileExt==".jpg")
			{
				$destimg=ImageCreateTrueColor($new_width,$new_height) or die('Problem In Creating image');
				
				$srcimg=ImageCreateFromJPEG($_FILES[$temp_img]['tmp_name']) or die('Problem In opening Source Image');
				if(function_exists('imagecopyresampled'))
				{
					imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
				}
				else
				{
					Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
				}
				ImageJPEG($destimg,$prod_img_thumb,90) or die('Problem In saving');
				imagedestroy($destimg);
			}
		else if($fileExt==".png")
			{
				$destimg=ImageCreateTrueColor($new_width,$new_height) or die('Problem In Creating image');
				
				$srcimg=ImageCreateFromPNG($_FILES[$temp_img]['tmp_name']) or die('Problem In opening Source Image');
				if(function_exists('imagecopyresampled'))
				{
					imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
				}
				else
				{
					Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
				}
				ImagePNG($destimg,$prod_img_thumb,90) or die('Problem In saving');
				imagedestroy($destimg);
			}
		else if($fileExt==".gif")
			{
				$destimg=ImageCreateTrueColor($new_width,$new_height) or die('Problem In Creating image');
				
				$srcimg=ImageCreateFromGIF($_FILES[$temp_img]['tmp_name']) or die('Problem In opening Source Image');
				if(function_exists('imagecopyresampled'))
				{
					imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
				}
				else
				{
					Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg)) or die('Problem In resizing');
				}
				ImageGIF($destimg,$prod_img_thumb,90) or die('Problem In saving');
				imagedestroy($destimg);
			}
		}
		return $return_path;
	}
	###############################################################################

	function convertToDbDate($date,$format)
	{                 
		if($format=='mdy'){
		$newdate=explode('-',$date);
		$dbdate=$newdate[2]."-".$newdate[0]."-".$newdate[1];
		}
		else if($format=='dmy'){
		$newdate=explode('-',$date);
		$dbdate=$newdate[2]."-".$newdate[1]."-".$newdate[0];
		}
		return $dbdate;
	}

	function static_cms_title($page_id)
	{
		if($page_id!='')
		{
			$sql_page_content="select * from ".STATICCMS." where cmsid='".$page_id."'";
			$rs_page_content=mysql_query($sql_page_content);
			if(mysql_num_rows($rs_page_content)>0)
			{
				$obj_page_content=mysql_fetch_object($rs_page_content);
			}
			return $obj_page_content->Title;
		}
		else
		{
			return false;
		}
	}
	
	
	function static_cms_meta_content($page_id,$field)
	{
		if($page_id!='')
		{
			$sql_page_content="select * from ".STATICCMS." where cmsid='".$page_id."'";
			$rs_page_content=mysql_query($sql_page_content);
			if(mysql_num_rows($rs_page_content)>0)
			{
				$obj_page_content=mysql_fetch_object($rs_page_content);
			}
			return $obj_page_content->$field;
		}
		else
		{
			return false;
		}
	}	
####################################################################################################################

function errormsg($mms){
	echo '<div class="errmsg">'.$mms.'</div>';
}


function getext($name){
	$extar=explode(".",$name);
	$len=count($extar);
	$ext=$extar[$len-1];
	$ext=".".$ext;
	return $ext;
}

function recursive_remove_directory($directory, $empty=FALSE)
 {
     // if the path has a slash at the end we remove it here
     if(substr($directory,-1) == '/')
     {
         $directory = substr($directory,0,-1);
     }
  
    // if the path is not valid or is not a directory ...
    if(!file_exists($directory) || !is_dir($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... if the path is not readable
     }elseif(!is_readable($directory))
     {
         // ... we return false and exit the function
         return FALSE;
  
     // ... else if the path is readable
     }else{
  
         // we open the directory
         $handle = opendir($directory);
  
         // and scan through the items inside
         while (FALSE !== ($item = readdir($handle)))
         {
             // if the filepointer is not the current directory
             // or the parent directory
             if($item != '.' && $item != '..')
             {
                 // we build the new path to delete
                 $path = $directory.'/'.$item;
  
                 // if the new path is a directory
                 if(is_dir($path)) 
                 {
                     // we call this function with the new path
                     recursive_remove_directory($path);
  
                 // if the new path is a file
                 }else{
                     // we remove the file
                     unlink($path);
                 }
             }
         }
         // close the directory
         closedir($handle);
  
         // if the option to empty is not set to true
         if($empty == FALSE)
         {
             // try to delete the now empty directory
             if(!rmdir($directory))
             {
                 // return false if not possible
                 return FALSE;
             }
         }
         // return success
         return TRUE;
     }
 }
 
function convertProductName($p_name){
  $p_name=str_replace(" ","_",$p_name);
  return $p_name;
}

	function mult_mail_attachment3($from , $to, $subject, $message, $attachment)
{
				
			$fileatt_type = "application/octet-stream"; 	
			$email_from = $from; // Who the email is from 
			$email_subject =  $subject; // The Subject of the email 
			$email_txt = $message; // Message that the email has in it 
			
			$email_to = $to; // Who the email is to
		
			$headers = "From: ".$email_from;
			
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
			
			$headers .= "\nMIME-Version: 1.0\n" . 
					"Content-Type: multipart/mixed;\n" . 
					" boundary=\"{$mime_boundary}\""; 
		
	#		$email_txt .= $msg_txt;
			
			$email_message .= "This is a multi-part message in MIME format.\n\n" . 
						"--{$mime_boundary}\n" . 
						"Content-Type:text/html; charset=\"iso-8859-1\"\n" . 
					   "Content-Transfer-Encoding: 7bit\n\n" . 
			$email_txt . "\n\n"; 
		

			
			if($attachment[0]!=""){
				$start=    strrpos($attachment[0], '/') == -1 ? strrpos($attachment[0], '//') : strrpos($attachment[0], '/')+1;
			$fileatt_name = substr($attachment[0], $start, strlen($attachment[0]));
				
				
				$fileatt = $attachment[0]; // Path to the file 
				$fileatt_type = "application/octet-stream"; // File Type 
				
				$file = fopen($fileatt,'rb'); 
				$data = fread($file,filesize($fileatt)); 
				fclose($file); 
				
				
				$data = chunk_split(base64_encode($data)); 
				
				$email_message .= "--{$mime_boundary}\n" . 
				"Content-Type: {$fileatt_type};\n" . 
				" name=\"{$fileatt_name}\"\n" . 
				//"Content-Disposition: attachment;\n" . 
				//" filename=\"{$fileatt_name}\"\n" . 
				"Content-Transfer-Encoding: base64\n\n" . 
				$data . "\n\n" . 
				"--{$mime_boundary}\n"; 
				unset($data);
				unset($file);
				unset($fileatt);
				unset($fileatt_type);
				unset($fileatt_name);
				
			}
			if($attachment[1]!=""){
				$start=    strrpos($attachment[1], '/') == -1 ? strrpos($attachment[1], '//') : strrpos($attachment[1], '/')+1;
				$fileatt_name = substr($attachment[1], $start, strlen($attachment[1]));
				$fileatt = $attachment[1]; // Path to the file 
				$fileatt_type = "application/octet-stream"; // File Type 
				
				
				$file = fopen($fileatt,'rb'); 
				$data = fread($file,filesize($fileatt)); 
				fclose($file); 
				
				
				$data = chunk_split(base64_encode($data)); 
				
				$email_message .= "Content-Type: {$fileatt_type};\n" . 
				" name=\"{$fileatt_name}\"\n" . 
				//"Content-Disposition: attachment;\n" . 
				//" filename=\"{$fileatt_name}\"\n" . 
				"Content-Transfer-Encoding: base64\n\n" . 
				$data . "\n\n" . 
				"--{$mime_boundary}--\n"; 
				unset($data);
				unset($file);
				unset($fileatt);
				unset($fileatt_type);
				unset($fileatt_name);				
				
			}
			
			
			$ok = @mail($email_to, $email_subject, $email_message, $headers); 
		
			if($ok) 
			{ 
				return 1;
			} 
			else
			 { 
				return 0;
			} 
}

	function CATEGORY($catid){
		$catname=Select_Qry("*",CATEGORY," cat_id=$catid","","","","");
		return $catname['cat_name'];
	}
	
	function CATEGORY_ADD($catid)
	{
		$addspace=Select_Qry("*",CATEGORY,"cat_id=$catid","","","","");
			return $addspace['add_space'];
	}

	function USER($uid){
	$user=Select_Qry("first_name,last_name",USER,"user_id=$uid","","","","");
	return $user['first_name'].' '.$user['last_name'];
	}
	
	function USERNAME($uid){
		$username=Select_Qry("username",USER," user_id=$uid","","","","");
		return $username['username'];
	}
	
	function USEREMAIL($uid){
		$useremail=Select_Qry("email",USER," user_id=$uid","","","","");
		return $useremail['email'];
	}
	
	function ADDTITLE($id)
	{
	  $addTitle=Select_Qry("title",ADVERTISE,"add_id='".$id."'","","","","");
	  return $addTitle['title'];
	}
	
	function ADDPRICE($id)
	{
	  $addPrice=Select_Qry("price",ADVERTISE,"add_id='".$id."'","","","","");
	  return $addPrice['price'];
	}
	
	function COUNTRY($id)
	{
		$SQL_COUNRTY = mysql_query("select * from ".COUNTRY." WHERE countryId='".$id."'");
		$countryName=mysql_fetch_array($SQL_COUNRTY);
	  	return $countryName['countryName'];
	}
	
	function STATE($id)
	{
		$SQL_STATE = mysql_query("select * from ".STATE." WHERE stateId='".$id."'");
		$stateName=mysql_fetch_array($SQL_STATE);
	  	return $stateName['stateName'];
	}
		
	function CREDIT($uid)
	{
		$credit=Select_Qry("credit",CREDIT,"user_id='".$uid."'","","","","");
		if($credit['credit']==''){
	  		return 0;
		}
		else{
			return $credit['credit'];
		}
	}
	
	function AVATAR($id)
	{
	  $arr=Select_Qry("avatar",USER,"user_id='".$id."'","","","","");
	  return $arr['avatar'];
	}
	
	function datenew($date)
	{
	  if($date!='0000-00-00 00:00:00')return date('l,F j, Y, g:i A',strtotime($date));
	  else return false;
	}
	
	function enddate($date){
	$date_parts1=explode("-", $date);
	//$date_parts2=explode("-", $endDate);
   //gregoriantojd() Converts a Gregorian date to Julian Day Count
   
   	$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
   	//$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
	$end_date=gregoriantojd(date("m"), date("d"), date("Y"));
   	$daydiff = $start_date - $end_date;
	
	if($daydiff<0){
		return "Ended";
	}
	elseif($daydiff>0){
		return $daydiff." Day(s)";
	}
	else{
		return "Today";
	}
}
	function SITESTATUS($id)
	{
		 $siteStatus=Select_Qry("status_name",SITE_STATUS,"statusId='".$id."'","","","","");
	  	return $siteStatus['status_name'];
	}
	
/*function feedback($user)
{
$totfeed=Select_Qry("COUNT(id) AS totfeed",USER_FEEDBACK," user_id='$user' AND status='1'","","","","");
	$userpos=Select_Qry("COUNT(id) AS posfeed",USER_FEEDBACK," user_id='$user' AND rate='1' AND status='1'","","","","");
	$userneg=Select_Qry("COUNT(id) AS negfeed",USER_FEEDBACK," user_id='$user' AND rate='2' AND status='1'","","","","");

	if($totfeed['totfeed']>0){
		return (($userpos['posfeed']-$userneg['negfeed'])/$totfeed['totfeed'])*100;
	}
	else return 0;
}*/


function feedback($user){
	$userpos=Select_Qry("COUNT(id) AS posfeed",USER_FEEDBACK," user_id='".$user."' AND rate='1'","","","","");
	$userneg=Select_Qry("COUNT(id) AS negfeed",USER_FEEDBACK," user_id=$user AND rate='2'","","","","");
	$userfeed=Select_Qry("COUNT(id) AS totfeed",USER_FEEDBACK," user_id='".$user."' AND rate<>'0'","","","","");
	/*if($userfeed['totfeed']>0){
		$neg=($userneg['negfeed']/$userfeed['totfeed'])*100;
		$pos=100-$neg;
		return round($pos,2);
	}
	*/
	$pos=$userpos['posfeed']==''?0:$userpos['posfeed'];
	$neg=$userneg['negfeed']==''?0:$userneg['negfeed'];
	$totfeed=$userfeed['totfeed']==''?0:$userfeed['totfeed'];
	
	if($totfeed==0){
		return 0;
	}
	else{
		$calc=($pos/$totfeed)*100;
		return round($calc,2);
	}
}


function getrate($data){
	if($data==1){
		return "Positive";
	}
	elseif($data==2){
		return "Negetive";
	}
	else return "Neutral";
}
function remspace($str){
	#$record=Select_Qry("add_id",ADVERTISE," add_id= '".$str."'","","","","");
	#$str=str_replace(" ","-",$str); +6000
	$str=($str);
	return $str;
}

function addspace($str){
	#$str=str_replace("-"," ",$str); -6000
	$str=($str);
	return $str;
}

#########################################
function Global_Mail($to_email,$to_name,$page_id,$activation,$purpose,$sender){
		$body="";
		$body = statica_cms_page_value($page_id);				
		$mail_subject1 =static_cms_title($page_id);
		
		switch($purpose){
			case "registration":
				$body=str_replace("#NAME#",$to_name,$body);
				$body=str_replace("#EMAIL#",$to_email,$body);
				$body=str_replace("#PASSWORD#",$activation,$body);
				$body=str_replace("#LINK#",$sender,$body);
				//$body=str_replace("#ACTIVATION#",$activation,$body);				
				break;
			case "activation":
				$body=str_replace("#NAME#",$to_name,$body);
				$body=str_replace("#USERNAME#",$sender,$body);
				$body=str_replace("#EMAIL#",$to_email,$body);
				$body=str_replace("#PASSWORD#",$activation,$body);
				//$body=str_replace("#LINK#",$sender,$body);
				break;
			}
		$mail_To = $to_email;
		$mail_From = ADMIN_EMAIL;
		Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject1, $body);		
	}
	
?>