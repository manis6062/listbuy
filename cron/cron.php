<?
	/***********************For connection********************/
 	$link = mysql_connect("localhost", "scgmtest_sabrina", "diamondgoat54") or die("Could Connect To The MySql Server".mysql_error());
	if ($link)
	{
		mysql_select_db("scgmtest_marketplace") or die("Could Connect To The MySql Database".mysql_error());
	}
	/****************************End***************************/
	#$SQL = "select * from tbl_add WHERE TIMESTAMPDIFF(DAY,valid_till,NOW())=1";
	$SQL = "select * from tbl_add WHERE valid_till < NOW()";
	$QUERY = mysql_query($SQL) or die('ERROR IN SELECT QUERY' . mysql_error());
	if(mysql_num_rows($QUERY) > 0)
	{
	while($RESULT = mysql_fetch_array($QUERY))
	{
		$rs = mysql_query("select * from tbl_user where user_id='".$RESULT['user_id']."'");
		$record=mysql_fetch_array($rs);
		//if(date('Y-m-d',strtotime($RESULT['valid_till'])) < date('Y-m-d'))
		//{
			$set_value = "status = '0'"; // 0 means Relist
			$where_clause = "WHERE add_id='".$RESULT['add_id']."'";
			mysql_query("UPDATE tbl_add SET ".$set_value." ".$where_clause."") or die(mysql_error()."Error in updateQry()");
			$mail_To = $record['email'];
			$mail_subject = "Relist your listing";
			$mail_From = 'info@'.WEB_ADDRESS.'';
			$mail_Headers  = "MIME-Version: 1.0\r\n";
			$mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mail_Headers .= "To: ${mail_To}\r\n";
			$mail_Headers .= "From: ${mail_From}\r\n";
			$mail_Body = "Your Auction Listing has been expired. <br />Click here to view the listing details : <a href='http://'.WEB_ADDRESS.'/".remspace($RESULT['add_id'])."'>".$RESULT['title']."</a><br />Please relist this List from listing. <br />";
			//print $mail_Body; 
			if(mail($mail_To, $mail_subject, $mail_Body, $mail_Headers))
			{			
				return true;
			}
			else
			{        	
				return false;
			}
			
			$mail_To1 = 'sabrina@zeescripts.com';
			$mail_subject1 = "".$RESULT['title']." has been Expired";
			$mail_From1 = $record['email'];
			$mail_Headers1  = "MIME-Version: 1.0\r\n";
			$mail_Headers1 .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mail_Headers1 .= "To: ${mail_To1}\r\n";
			$mail_Headers1 .= "From: ${mail_From1}\r\n";
			$mail_Body1 = "".$record['username']."'s listing has been expired. Click here to view the listing details : <a href='http://scgmtest.com/a/".remspace($RESULT['add_id'])."'>".$RESULT['title']."</a>";
			//echo $mail_Body1;
			if(mail($mail_To1, $mail_subject1, $mail_Body1, $mail_Headers1))
			{			
				return true;
			}
			else
			{        	
				return false;
			}
		//}
	}
	}
	function remspace($str){
	$str=str_replace(" ","-",$str);
	return $str;
}
?>